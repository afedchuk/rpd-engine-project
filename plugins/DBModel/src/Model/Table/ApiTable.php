<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\Filesystem\Folder;
use DBModel\Model\Entity\Api;
use DBModel\Model\Table\AppTable;

/**
 * Api Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Events
 */
class ApiTable extends AppTable
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
        $this->consistency =  ['conditions' => [['gmt_expires <' => time()]], 'data' => [], 'contain' => []];

        $this->table('api');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Events', [
            'foreignKey' => 'event_id',
            'className' => 'DBModel.Events'
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
            ->allowEmpty('toc');

        $validator
            ->allowEmpty('groops');

        $validator
            ->integer('gmt_expires')
            ->allowEmpty('gmt_expires');

        $validator
            ->allowEmpty('token');

        $validator
            ->allowEmpty('username');

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
     * Consistency hook
     *
     * @param array $item table data
     * @return void
     */
    public function consistencyHook(\DBModel\Model\Entity\Api $item)
    {
        $entity = $this->get($item->id);
        if(!is_null($item->toc)) {
            foreach (explode("\n", $item->toc) as $path) {
                $folder = new Folder($path);
                $folder->delete();
            }
        }
        if(!$this->delete($entity)) {
            return $entity->errors();
        }
    }
}
