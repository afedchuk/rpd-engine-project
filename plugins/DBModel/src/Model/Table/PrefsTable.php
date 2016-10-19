<?php

namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Cache\Cache;
use Cake\Network\Session;
use DBModel\Model\Entity\Pref;
use DBModel\Model\Table\AppTable;

/**
 * Prefs Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Users
 */
class PrefsTable extends AppTable
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

        $this->table('prefs');
        $this->displayField('name');
        $this->primaryKey('id');

        $this->belongsTo('Users', [
            'foreignKey' => 'user_id'
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
            ->notEmpty('user_id');

        $validator
            ->add('name', 'unique', ['rule' => 'validateUniqueName', 'provider' => 'table', 'message' =>  __('Unable to create the setting, duplicate entry found.')])
            ->notEmpty('name');

        $validator
            ->allowEmpty('value');

        return $validator;
    }

    /**
     * Validate unique name of user preference
     *
     * @param $value preference value tha validate
     * @return bool
     */
    public function validateUniqueName($value, array $context) 
    {
        $session = new Session();
        if(($user_id = $session->read('User.user_id'))) {
            $names = $this->find('list')->where(['user_id' => $user_id])->toArray();
            if(!empty($names) && !in_array($value, $names))
                return true;
            return false;
        }
        return true;
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
        $rules->add($rules->existsIn(['user_id'], 'Users'));
        return $rules;
    }

    /**
    * Get a preference value from the prefs table.
    * @param int user_id user record id
    * @param string name preference name
    * @param string default a default value of preference
    * @return string preference value or default
    */

    public function getPreference($name, $userId = 1, $default = null) 
    {
        if(($record = $this->find()->where(['user_id' => $userId, 'name' => $name])->first()) != false) 
            return $record['value'];
        return $default;
    }
}
