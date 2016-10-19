<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;
use DBModel\Model\Entity\Oddit;

/**
 * Oddits Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Events
 */
class OdditsTable extends AppTable
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

        $this->table('oddits');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'className' => 'DBModel.Events'
        ]);
        $this->hasMany('Auditargs', [
            'foreignKey' => 'audit_id',
            'className' => 'DBModel.Auditargs',
            'dependent' => true
        ]);

        $this->addBehavior('DBModel.QTimestamp', [
            'field' => 'gmt_created',
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
            ->allowEmpty('message');

        $validator
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->integer('id')
            ->allowEmpty('id', 'create');

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
        $rules->add($rules->existsIn(['event_id'], 'Events'));
        return $rules;
    }

    /**
     * Write an audit message to an event
     *
     * @param int $eventId event record id
     * @param string $message properly formatted message string
     * @param array $args assoc array of args
     * @return bool true|string error
     */
    public function putAudit(int $eventId, string $message, array $args = []) {
        $data = ['event_id' => $eventId,'message' => $message, 'auditargs' => []];
        $entity = $this->newEntity($data);
        if(!$this->save($entity)) {
            return $entity->errors();
        } else {
            if(!empty($args)) {
                unset($args['event_id']);
                foreach (array_keys($args) as $key) {
                    $result = $this->Auditargs->newEntity(['audit_id' => $this->getInsertID(),'name' => $key, 'value' => preg_replace('/@@(\w+)/','*****',$args[$key])]);
                    $this->Auditargs->save($result);
                }
            } 
        }
        return true;
    }
}
