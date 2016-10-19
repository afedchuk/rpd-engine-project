<?php
namespace DBModel\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;
use Cake\ORM\BehaviorRegistry;

class DefaultFieldsBehavior extends Behavior
{
    protected $_defaultConfig = [];

    /**
    * Insert default values
    * @param array $item array of default field names and their values.
    * @param array $key void array. Supplied because of array walk requirement for presence key-value pair in the target function.
    * @param Cake\ORM\Entity $entity instance of entity.
    * @return void
    **/
     public function putDefault($item, $key, Entity $entity){
        $entity->set($item['field'], $item['value']);
    }

    /**
    * Before saving triggering event
    * @param Cake\Event\Event $event Event instance.
    * @param Cake\Datasource\EntityInterface $entity EntityInterface instance.
    * @return bool
    **/
    public function beforeSave(Event $event, EntityInterface $entity){     
    	if ($entity->isNew()){         
            array_walk($this->config()['fields'], array($this, 'putDefault'), $entity);
        }        
    }
    
}
?>