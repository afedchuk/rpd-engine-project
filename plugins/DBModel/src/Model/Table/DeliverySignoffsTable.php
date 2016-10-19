<?php
namespace DBModel\Model\Table;

use DBModel\Model\Entity\DeliverySignoff;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Table\AppTable;

/**
 * DeliverySignoffs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Deliveries
 * @property \Cake\ORM\Association\BelongsTo $NotificationTemplates
 */
class DeliverySignoffsTable extends AppTable
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

        $this->table('delivery_signoffs');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Deliveries', [
            'foreignKey' => 'delivery_id'
        ]);
        $this->belongsTo('NotificationTemplates', [
            'foreignKey' => 'notification_template_id'
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
            ->integer('id')
            ->allowEmpty('id', 'create');

        $validator
            ->allowEmpty('type');

        $validator
            ->allowEmpty('contact');

        $validator
            ->allowEmpty('signoff');

        $validator
            ->integer('gmt_notified')
            ->allowEmpty('gmt_notified');

        $validator
            ->integer('gmt_signed')
            ->allowEmpty('gmt_signed');

        $validator
            ->integer('gmt_active')
            ->allowEmpty('gmt_active');

        $validator
            ->allowEmpty('flag');

        $validator
            ->allowEmpty('note');

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
        // $rules->add($rules->existsIn(['delivery_id'], 'Deliveries'));
        // $rules->add($rules->existsIn(['notification_template_id'], 'NotificationTemplates'));
        return $rules;
    }
}
