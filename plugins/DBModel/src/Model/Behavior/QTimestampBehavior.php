<?php
namespace DBModel\Model\Behavior;

use Cake\Datasource\EntityInterface;
use Cake\Event\Event;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\ORM\Entity;
use Cake\ORM\Query;

class QTimestampBehavior extends TimestampBehavior
{
        /**
     * Default config
     *
     * These are merged with user-provided config when the behavior is used.
     *
     * events - an event-name keyed array of which fields to update, and when, for a given event
     * possible values for when a field will be updated are "always", "new" or "existing", to set
     * the field value always, only when a new record or only when an existing record.
     *
     * refreshTimestamp - if true (the default) the timestamp used will be the current time when
     * the code is executed, to set to an explicit date time value - set refreshTimetamp to false
     * and call setTimestamp() on the behavior class before use.
     *
     * @var array
     */
    protected $_defaultConfig = [
        'implementedFinders' => [],
        'implementedMethods' => [
            'timestamp' => 'timestamp',
             'touch' => '_touch',
        ],
        'events' => [
            'Model.beforeSave' => [
                'created' => 'new',
                'modified' => 'always'
            ]
        ],
        'refreshTimestamp' => true
    ];


    /**
    * Default time creating
    * @param Cake\ORM\Entity $entity Entity instance.
    * @return void
    **/
    public function gmtCreate(Entity $entity)
    {
        $entity->set($this->config()['field'], time());
    }

    /**
    * Before saving triggering event
    * @param Cake\Event\Event $event Event instance.
    * @param Cake\Datasource\EntityInterface $entity EntityInterface instance.
    * @return bool
    **/

    public function beforeSave(Event $event, EntityInterface $entity)
    {   
        if ($entity->isNew()){
            $this->gmtCreate($entity);
        }
    }

    
    /**
     * Touch an entity
     *
     * Bumps timestamp fields for an entity. For any fields configured to be updated
     * "always" or "existing", update the timestamp value. This method will overwrite
     * any pre-existing value.
     *
     * @param \Cake\Datasource\EntityInterface $entity Entity instance.
     * @param string $eventName Event name.
     * @return bool true if a field is updated, false if no action performed
     */
    public function _touch(EntityInterface $entity, string $eventName = 'Model.beforeSave')
    {
        $return = false;
        foreach ($this->_config['events'][$eventName] as $field => $when) {
            if (in_array($when, ['always', 'existing'])) {
                $return = true;
                $entity->dirty($field, false);
                $entity->set($field, time());
            }
        } 
        return $return;  
    }

}
?>
