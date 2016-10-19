<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\SolidDepend;

/**
 * SolidDepends Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Solids
 * @property \Cake\ORM\Association\BelongsTo $SolidDepends
 * @property \Cake\ORM\Association\HasMany $SolidDepends
 */
class SolidDependsTable extends Table
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

        $this->table('solid_depends');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Solids', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Solids'
        ]);
        $this->belongsTo('SolidDepends', [
            'foreignKey' => 'solid_depend_id',
            'className' => 'DBModel.SolidDepends'
        ]);
        $this->hasMany('SolidDepends', [
            'foreignKey' => 'solid_depend_id',
            'className' => 'DBModel.SolidDepends'
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
            ->integer('scope')
            ->allowEmpty('scope');

        $validator
            ->integer('count')
            ->allowEmpty('count');

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
        return $rules;
    }

    /**
    * Create a new master/slave solid depends and populate it with translated entries.
    *
    * @param int $slaveId slave solid id
    * @param int $solidId solid id
    * @return bool |  \DBModel\Model\Entity\SolidDepend validation errors
    **/
    public function populateMasterSlaveSolidDepend(int $slaveId = 0, int $solidId = 0)
    {
        $solidDepends = $this->find('list', ['keyField' => 'id', 'valueField' => 'solid_id'])
                            ->where(['solid_depend_id' => $solidId])
                            ->toArray();
        if(!empty($solidDepends)) {
            $solidDepend = $this->newEntity(['solid_id' => $slaveId]);
            if($this->save($solidDepend)) {
                foreach ($solidDepends as $key => $value) {
                    $solidDepend = $this->newEntity(['solid_id' => $value, 'solid_depend_id' => $slaveId]);
                    if(!$this->save($solidDepend)) {
                        return $solidDepend->errors();
                    }
                }
            } else {
                return $solidDepend->errors();
            }
        }
        return true;
    }
}
