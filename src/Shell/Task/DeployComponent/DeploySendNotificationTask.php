<?php
namespace App\Shell\Task\DeployComponent;

use Cake\Console\Shell;
use App\Shell\Task\QueueTask;

/**
 * SendNotification shell task.
 */
class DeploySendNotificationTask extends QueueTask
{

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function capabilityMain(array $data, array $bridge = [])
    {	
    	$propertyArray = [];
    	// we need the following data
		// - id of the notification template
		// - names of each recipient
    	if(!$data['notification_template_id']) {
			$this->feedMe("No Template identfied for sign-off notification.", array(), 0, 0, 'E');
			return(1);
		}
		if(!$data['email_to']) {
			$this->feedMe("No addresses identified to send notification to.", array(), 0, 0, 'E');
			return(2);
		}
		// Prepare the properties array...
		// Order or presidence - local,specific.
		foreach($data as $name => $value) {
			if(!is_array($value)) {
				$propertyArray[$name] = $value;
			}
			else {
				if($name == 'env') {
					foreach($value as $envName => $envValue) {
						$propertyArray[$envName] = $envValue;
					}
				}
			}
			// That's really all we care about at this point in time.
		}

		if (!isset($data['env']['VL_PROCESS_ID']) && !isset($data['env']['VL_DELIVERY_ID']))
            return(0);
        // Construct a couple of helpful urls to be available...
        $baseUrl = $this->Deliveries->getSysPref('console_base_url', 'http://' . php_uname('n') . '/');
        if (!preg_match('/\/$/', $baseUrl))
            $baseUrl .= '/';
        $propertyArray['VL_BASE_URL'] = $baseUrl;
        if (empty($data['env']['VL_SYNC_RESULTS'])) {
            $propertyArray['VL_SYNC_RESULTS'] = '<A HREF="' . $baseUrl . 'report/wiz_processes' . '">' . $baseUrl . 'report/wiz_processes' . '</A>';
        }
        if (isset($data['env']['VL_CONFIG_PROCESS_TYPE'])) {
            $propertyArray['VL_LINK_CHRONO_HTML'] = '<A HREF="' . $baseUrl . 'config/chan/chrono/' . $data['env']['VL_CHANNEL_ID'] . '">' . $baseUrl . 'config/chan/chrono/' . $data['env']['VL_CHANNEL_ID'] . '</A>';
        }
        $basePlugin = 'delivery';
        if (isset($data['env']['VL_DELIVERABLE_TYPE']) && $data['env']['VL_DELIVERABLE_TYPE'] == 'B') {
            $basePlugin = 'spin';
        }
        if (isset($data['env']['VL_PROCESS_ID']) && isset($data['env']['VL_DELIVERY_ID'])) {
            $propertyArray['VL_LINK_PROCESS'] = $baseUrl . $basePlugin . '/wiz_action_results/viewProcess/' . $data['env']['VL_DELIVERY_ID'] . '/' . $data['env']['VL_PROCESS_ID'];
            $propertyArray['VL_LINK_PROCESS_HTML'] = '<A HREF="' . $baseUrl . $basePlugin . '/wiz_action_results/viewProcess/' . $data['env']['VL_DELIVERY_ID'] . '/' . $data['env']['VL_PROCESS_ID'] . '">' . $baseUrl . $basePlugin . '/wiz_action_results/viewProcess/' . $data['env']['VL_DELIVERY_ID'] . '/' . $data['env']['VL_PROCESS_ID'] . '</A>';
        }
        $propertyArray['VL_LINK_DEPLOYMENTS'] = $baseUrl . $basePlugin . '/wiz_action_results/index';
        $propertyArray['VL_LINK_DEPLOYMENTS_HTML'] = '<A HREF="' . $baseUrl . $basePlugin . '/wiz_action_results/index">' . $baseUrl . 'delivery/wiz_action_results/index</A>';
        if (isset($data['env']['VL_TASK_ID'])) {
            $propertyArray['VL_LINK_TASK_ATTENTION'] = $baseUrl . $basePlugin . '/wiz_action_results/restart/' . $data['env']['VL_DELIVERY_ID'] . '/' . $data['env']['VL_PROCESS_ID'] . '/' . $data['env']['VL_TASK_ID'];
            $propertyArray['VL_LINK_TASK_ATTENTION_HTML'] = '<A HREF="' . $baseUrl . $basePlugin . '/wiz_action_results/restart/' . $data['env']['VL_DELIVERY_ID'] . '/' . $data['env']['VL_PROCESS_ID'] . '/' . $data['env']['VL_TASK_ID'] . '">' . $baseUrl . $basePlugin . '/wiz_action_results/restart/' . $data['env']['VL_DELIVERY_ID'] . '/' . $data['env']['VL_PROCESS_ID'] . '/' . $data['env']['VL_TASK_ID'] . '</A>';
        }
        if (isset($data['env']['VL_DELIVERY_ID'])) {
            $propertyArray['VL_LINK_DEPLOYMENT'] = $baseUrl . $basePlugin . '/wiz_action_results/view/' . $data['env']['VL_DELIVERY_ID'];
            $propertyArray['VL_LINK_DEPLOYMENT_HTML'] = '<A HREF="' . $baseUrl . $basePlugin . '/wiz_action_results/view/' . $data['env']['VL_DELIVERY_ID'] . '">' . $baseUrl . $basePlugin . '/wiz_action_results/view/' . $data['env']['VL_DELIVERY_ID'] . '</A>';
            $propertyArray['VL_LINK_SIGNOFF'] = $baseUrl . $basePlugin . '/wiz_action_results/signoff/' . $data['env']['VL_DELIVERY_ID'];
            $propertyArray['VL_LINK_SIGNOFF_HTML'] = '<A HREF="' . $baseUrl . $basePlugin . '/wiz_action_results/signoff/' . $data['env']['VL_DELIVERY_ID'] . '">' . $baseUrl . $basePlugin . '/wiz_action_results/signoff/' . $data['env']['VL_DELIVERY_ID'] . '</A>';
        }
        if (isset($data['env']['VL_ACTIVITY_ID']) && ($activity = $this->Activities->field('name', ['id' => $data['env']['VL_ACTIVITY_ID'] ] ))){
            $propertyArray['VL_ACTIVITY_NAME'] = $activity->name;
        }

        $attachment_info = [
        	'include_activity_log' => isset($data['include_activity_log']) ?$data['include_activity_log']:'',
        	'activity_id' => isset($data['env']['VL_ACTIVITY_ID']) ? $data['env']['VL_ACTIVITY_ID'] :'' ,
        	'process_id' => isset($data['env']['VL_PROCESS_ID']) ? $data['env']['VL_PROCESS_ID'] :'' 
		];
		$result = $this->NotificationTemplates->sendNotification($data['email_to'], $data['notification_template_id'], $attachment_info , $propertyArray );
        if ( $result !== true) {
                $this->feedMe("Failed to send notification: [err]", array('[err]' => $result['errors']), 0, 0, 'E');
                return(3);
        }
        $this->feedMe("Sent [" . $data['notification_template_id'] . "] notification template.", array(), 0, 0, 'S');
        return(0);
    }
}
