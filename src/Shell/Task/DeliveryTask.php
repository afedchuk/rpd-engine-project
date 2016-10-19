<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use DBModel\Model\Table\DeliveriesTable as Delivery;
use DBModel\Model\Table\DeliverablesTable as Deliverable;

/**
 * InitSolid shell task.
 */
class DeliveryTask extends QueueTask
{
    public $tasks = ['Queue', 'InstanceFactory'];
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main(array $params = [])
    {
        $activeStatuses = [Delivery::INIT, Delivery::SIGNOFF, Delivery::VM, Delivery::PROCESSING, Delivery::POST]; 
        $deliveryId = $this->getDelivery();
        if($deliveryId){
            $this->engineAudit("Processing deployment id [deliveryId]" , [ '[deliveryId]' => $deliveryId], 'warning');
            $deliveryStatus = $this->Deliveries->field('status', ['id' => $deliveryId]);
            $newDeliveryStatus = $deliveryStatus;
            if($deliveryStatus == Delivery::QUEUE ) {
                $this->engineAudit( "Found queue id [deliveryId]", ['did' => $deliveryId] );
                $newDeliveryStatus = Delivery::SIGNOFF;
            }
            $newDeliveryStatus = $this->{$newDeliveryStatus}($deliveryId);            
        }              
        if (isset($newDeliveryStatus) && ($newDeliveryStatus != $deliveryStatus)) {
            $this->Queue->engineAudit("Engine [engine_id] moved deployment of [deliverable] into environment [del_env] from [statusold] to [statusnew]", [
                    '[engine_id]' => get('engineId'),
                    '[deliverable]' => $this->Deliverables->field('name', ['Deliverables.id' => $this->Deliveries->field('deliverable_id', ['Deliveries.id' => $deliveryId]) ]),
                    '[del_env]' => $this->DelEnvs->field('name', ['DelEnvs.id' => $this->Deliveries->field('del_env_id', ['Deliveries.id' => $deliveryId]) ]),
                    '[statusold]' => $deliveryStatus,
                    '[statusnew]' => $newDeliveryStatus,
                    ], 'info');
        }
        if($deliveryId){
            $this->Deliveries->freeDelivery($deliveryId);
        }

        $activeDeliveries = $this->Deliveries->find()
                       ->where(['Deliveries.status IN' => $activeStatuses , 'Deliveries.engine_id' => 0])
                       ->toArray();

        foreach ($activeDeliveries as $delivery) {
            if(!$delivery->engine_id){
                $lockUid = uniqid(get('engineId'), true);
                 if (!$this->Loches->getLock('deliveries', $lockUid, 3, 1, 0)) {
                    continue;
                }
                if(!$this->Deliveries->saveField(['engine_id' =>get('engineId')], $delivery->id)){
                     $this->Loches->put('deliveries', $lockUid);
                }
                $newStatus = $this->{$delivery->status}($delivery->id);
                 if (isset($newStatus) && ($newStatus != $delivery->status)) {
                    $this->Queue->engineAudit("Engine [engine_id] moved deployment of [deliverable] into environment [del_env] from [statusold] to [statusnew]", [
                            '[engine_id]' => get('engineId'),
                            '[deliverable]' => $this->Deliverables->field('name', ['Deliverables.id' => $this->Deliveries->field('deliverable_id', ['Deliveries.id' => $deliveryId]) ]),
                            '[del_env]' => $this->DelEnvs->field('name', ['DelEnvs.id' => $this->Deliveries->field('del_env_id', ['Deliveries.id' => $deliveryId]) ] ),
                            '[statusold]' => $delivery->status,
                            '[statusnew]' => $newStatus,
                            ], 'info');
                }
                $this->Deliveries->freeDelivery($delivery->id);

            }
        }
        remove('artifactId');
    }

    /**
     * get the delivery in correspondent statuses
     *
     * @return int
     */


    public function getDelivery()
    {
        $failedDeliveries = $this
                    ->Deliveries
                    ->find()
                    ->contain(['Deliverables'])
                     ->matching(
                        'Deliverables', function ($query) {
                           return $query
                                ->where(['Deliverables.status' => Deliverable::ERROR]);
                        }
                    )
                    ->where(['Deliveries.status IN' => [Delivery::QUEUE, Delivery::DELIVER, Delivery::UNDELIVER ] ])
                    ->andWhere([
                        'Deliveries.engine_id' => 0,
                    ])
                    ->order(['Deliveries.id' => 'ASC'])
                    ->toArray();

        foreach ($failedDeliveries as $failedDelivery) {
            $failedDelivery->status = Delivery::FAIL;
                if(!$this->Deliveries->save($failedDelivery)) {
                    $this->Queue->engineAudit("Internal issue. Unable to save into " . get_class($this->Deliveries), [], 'warning');
                }
            $this->feedMe('Deployment into environment ' .
                        $this->DelEnvs->field('name' , ['DelEnvs.id' => $failedDelivery->del_env_id ])
                        . ' failed.',array(),0,0,'E');
        }
        $lockUid = uniqid(get('engineId'), true);
        if (!$this->Loches->getLock('deliveries', $lockUid, 3, 1, 0)) {
            return false;
        }
        $delivery = $this
                    ->Deliveries
                    ->find()
                    ->contain(['Deliverables'])
                    ->matching(
                        'Deliverables', function ($query) {
                           return $query
                                ->where(['Deliverables.status IN' => [Deliverable::READY, Deliverable::EXPIRED]]);
                        }
                    )
                    ->where(['Deliveries.status IN' => [Delivery::QUEUE, Delivery::DELIVER, Delivery::UNDELIVER ] ])
                    ->andWhere([
                        'Deliveries.engine_id' => 0,
                    ])
                    ->order(['Deliveries.id' => 'ASC'])
                    ->first();

        if(empty($delivery)){
            $this->Loches->put('deliveries', $lockUid);
            return false;
        }
        if(!$this->Deliveries->updateAll( ['engine_id' => get('engineId')], ['id' => $delivery->id] )) {
            $this->Queue->engineAudit("Internal issue. Unable to update into " . get_class($this->Deliveries), [], 'warning');
            $this->Loches->put('deliveries', $lockUid);
            return false;
        }

        // see if this record has an appropriate dependency
        if($delivery->status == Delivery::QUEUE && $delivery->action == 'go' && $delivery->delivery_id) {
            // get the status of the dependency.
            $dependencyStatus = $this->Deliveries->field('status', ['Deliveries.id' =>$delivery->delivery_id ] );
            if(in_array($dependencyStatus, [ Delivery::FAIL, Delivery::PASS ]))
            {   
                $this->Deliveries->freeDelivery($delivery->id);
                return false;
            }
        }
        return $delivery->id;
    }

     /**
     * signoff function
     *
     * @param int $deliveryId Delivery ID
     * @return string
     */

    public function signoff(int $deliveryId)
    {
         $delivery = $this
                    ->Deliveries
                    ->find()
                    ->contain(['DeliverySignoffs'])
                    ->where(['Deliveries.id' => $deliveryId ])
                    ->first();
           
        if(empty($delivery->delivery_signoffs)){
            $templateId = $this->DelEnvs->field('notification_template_id', ['id' => $delivery->del_env_id]);
            if(!$templateId){
                // Set the lock status on the instance record.
                $this->Deliveries->envLock($delivery->deliverable_id, $delivery->del_env_id);
                $this->Deliveries->saveField(['status' => Delivery::INIT], $delivery->id);
                return (Delivery::INIT);
            }
            $delEnvSignoffs = $this->DelEnvSignoffs->findByDelEnvId($delivery->del_env_id)->toArray();
            foreach ($delEnvSignoffs as $signoff) {
               $entity = $this->DeliverySignoffs->newEntity(  ['delivery_id' => $deliveryId,
                                        'notification_template_id' => $templateId,
                                        'type' =>  $signoff->type,
                                        'contact' => $signoff->contact,
                                     ]);
               $this->DeliverySignoffs->save($entity);
            }
        }
        $delivery = $this
                    ->Deliveries
                    ->find()
                    ->contain(['Deliverables', 'DelEnvs', 'DeliverySignoffs'])
                    ->where(['Deliveries.id' => $deliveryId ])
                    ->first();
        set('artifactId', $delivery->deliverable->artifact_id);

        $deliveryAction = $this->Deliveries->renderDelivery($delivery);

        $soHash = ['must' => [], 'oneof' => [], 'notify' => [] ];
        $notify = [];
        $confirmed = true;
        $oneOfs = false;

        foreach($delivery->delivery_signoffs as $deliverySignOff) {
            $soHash[$deliverySignOff->type][] = $deliverySignOff;
        }
        // see if we have all required...
        $timeNow = time();
        foreach($soHash['must'] as $must) {
            if(!$must['gmt_signed'] || $must['gmt_active'] > $timeNow) 
                $confirmed = false;
        }
        foreach($soHash['oneof'] as $oneof) { 
            if($oneof['gmt_signed'] && $oneof['gmt_active'] < $timeNow){
                $oneOfs = true;
            }       
        }
        
        if(count($soHash['oneof']) && !$oneOfs) {
            $confirmed = false;
        }
        // Send out notifications if we need to..
        if(!$confirmed) {
            $recipientList = [];
            $notifyIds = [];
            $checkTime = time() - ($this->Deliveries->getSysPref('signoff_reminder_days') * 86400);
            $templateId = 0;
            foreach($delivery->delivery_signoffs as $signOff) {
                $templateId = $signOff->notification_template_id;
                if($signOff->type == 'must' && !$signOff->gmt_signed && $signOff->gmt_notified < $checkTime) {
                    $recipientList[] = $signOff->contact;
                    $notifyIds[] = $signOff->id;
                }
                if($signOff->type == 'oneof' && !$oneOfs && $signOff->gmt_notified < $checkTime) {
                    $recipientList[] = $signOff->contact;
                    $notifyIds[] = $signOff->id;
                }
                if($signOff->type == 'notify' && !$signOff->gmt_notified) {
                    $recipientList[] = $signOff->contact;
                    $notifyIds[] = $signOff->id;
                }
            }
            if(count($recipientList)){
                $paramSet = [
                    'artifact_id' => $delivery->deliverable->artifact_id,
                    'artifact' => $delivery->deliverable->name,
                    'notification_template_id' => $this->NotificationTemplates->field('name', ['id' => $templateId ]),
                    'email_to' => $recipientList,
                    'env' => [
                        'VL_DELIVERY_ID' => $delivery->id,
                        'VL_DELIVERY' => 'SIGNOFF',
                        'VL_INSTANCE_TYPE' => $delivery->deliverable->type,
                        'VL_ACTION' => $this->Deliveries->renderDelivery($delivery),
                        'VL_INSTANCE' => $delivery->deliverable->name,
                        'VL_PACKAGE' => $delivery->deliverable->artifact_name,
                        'VL_CONTAINER' => $delivery->deliverable->artifact_name,
                        'VL_ENVIRONMENT_ID' => $delivery->del_env_id,
                        'VL_ENVIRONMENT' => $this->DelEnvs->field('name', ['id' => $delivery->del_env_id]),
                        'VL_USER_ID' => $delivery->user_id,
                        'VL_USER_NAME' => $this->Usrs->field('username', ['id' => $delivery->user_id]),
                    ]
                ];
                $this->feedMe('Environment ' . $delivery->del_env->name . ' ' . $deliveryAction . ' sending sign-off notifications.', [] ,0,0,'S');
                $this->feedMe('Notification list:' . implode(' ,', $recipientList) , [],0,0,'S');
                $returnStatus = $this->InstanceFactory->build(['params' => $paramSet , 'prefix' => 'Deploy', 'module' => 'send_notification']);    

                if($returnStatus['local']) {
                    $this->feedMe('Environment ' . $delivery->del_env->name . ' ' . $deliveryAction . ' sign-off notifications failed to send.',[],0,0,'E');
                    $this->Deliveries->saveField(['status' => Delivery::CANCELLED], $delivery->id);
                    return(Delivery::CANCELLED);
                }

                // update their notification records.
                foreach($notifyIds as $notifyId) {
                    $this->DeliverySignoffs->saveField(['gmt_notified' => time() ], $notifyId);
                }
                $this->feedMe('Environment ' . $delivery->del_env->name . ' ' . $deliveryAction . ' sign-off notifications sent.',[],0,0,'S');
            
            }
            $this->Deliveries->saveField(['status' => Delivery::SIGNOFF], $delivery->id);
            remove('artifactId');
            return('signoff');
        }
        // No more sign-offs required. Are we signed-off to go, or fail?
        $confirmed = true;
        foreach($soHash['must'] as $must) {
            if(strtolower($must['flag']) == 'r') {
                $this->feedMe('Environment ' . $delivery->del_env->name . ' ' . $deliveryAction . ' not signed off on by ' . $must['contact'],[],0,0,'S');
                $confirmed = false;
            }
        }
        $foundOne = false;
        $oneOfList = array();
        if(count($soHash['oneof']) == 0) {
            $foundOne = true;
        }
        foreach($soHash['oneof'] as $oneOf) {
            if(strtolower($oneOf['flag']) == 'a' && $oneOf['gmt_signed'] > 0) {
                $foundOne = true;
            }
            $oneOfList[] = $oneOf['contact'];
        }
        if(!$foundOne) {
            $confirmed = false;
            $this->feedMe('Environment ' . $delivery->del_env->name . ' ' . $deliveryAction . ' not signed off on by one of ' . implode(', ', $oneOfList),[],0,0,'S');
        }
        if(!$confirmed) {
            $this->feedMe('Rejecting Environment ' . $delivery->del_env->name . ' ' . $deliveryAction . ' due to sign-off actions',[],0,0,'E');
            $this->Deliveries->saveField(['status' => Delivery::REJECTED], $delivery->id);
            return(Delivery::REJECTED);
        }
        // Set the lock status on the instance record.
        $this->Deliveries->envLock($delivery->deliverable_id, $delivery->del_env_id);
        // and let'er rip.
        $this->Deliveries->saveField( ['status' => Delivery::INIT ], $delivery->id );
        return(Delivery::INIT);

    }

   

   

}