<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\ORM\Behavior;
use Cake\ORM\Behavior\TimestampBehavior;
use Cake\Validation\Validator;
use DBModel\Model\Entity\Event;
use DBModel\Model\Table\AppTable;
use DBModel\Model\Behavior\QTimestampBehavior;

/**
 * Events Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Modules
 * @property \Cake\ORM\Association\BelongsTo $Users
 * @property \Cake\ORM\Association\HasMany $Api
 * @property \Cake\ORM\Association\HasMany $Oddits
 */
class EventsTable extends AppTable
{

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('events');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->addBehavior('DBModel.QTimestamp', [
            'events' => [
                'Events.beforeSave' => [
                    'gmt_created' => 'always'
                ],
            'field' => 'gmt_created'
            ]
        ]);

        $this->belongsTo('Usrs', [
            'foreignKey' => 'user_id'
        ]);
        $this->hasMany('Api', [
            'foreignKey' => 'event_id'
        ]);
        $this->hasMany('Oddits', [
            'foreignKey' => 'event_id'
        ]);
    }

    /**
     * Default validation rules.
     *
     * @param \Cake\Validation\Validator $validator Validator instance.
     * @return \Cake\Validation\Validator
     */
    public function validationDefault(Validator $validator)
    {
        $validator
            ->add('id', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('source');

        $validator
            ->add('gmt_created', 'valid', ['rule' => 'numeric'])
            ->allowEmpty('gmt_created');

        return $validator;
    }

    /**
     * Returns a rules checker object that will be used for validating
     * application integrity.
     *
     * @param \Cake\ORM\RulesChecker $rules The rules object to be modified.
     * @return \Cake\ORM\RulesChecker
     */
    public function buildRules(RulesChecker $rules)
    {
        $rules->add($rules->existsIn(['user_id'], 'Usrs', 'User does not exist in usrs table'));
        return $rules;
    }

    /**
    * Create a logging event record
    * @param string source the owner class of this event: Console, Engine, Mars, etc.
    * @param int user_id  the user associated with this logging event
    * @return int|bool event_id
    **/
    public function createEvent(string $source, int $userId = null) {
        $event = $this->newEntity([
                'user_id' => (is_null($userId)) ? 1 : $userId,
                'source' => $source
            ]
        );
        if($this->save($event)) {
            return $this->getInsertID();
        } else {
            return $event->errors();
        }
    }
}
