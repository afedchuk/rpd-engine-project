<?php
namespace DBModel\Model\Table;

use DBModel\Model\Entity\NotificationTemplateLang;
use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;

/**
 * NotificationTemplateLangs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $NotificationTemplates
 */
class NotificationTemplateLangsTable extends AppTable
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

        $this->table('notification_template_langs');
        $this->displayField('id');
        $this->primaryKey('id');

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
            ->allowEmpty('lang');

        $validator
            ->allowEmpty('subject');

        $validator
            ->allowEmpty('body');

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
        $rules->add($rules->existsIn(['notification_template_id'], 'NotificationTemplates'));
        return $rules;
    }
}
