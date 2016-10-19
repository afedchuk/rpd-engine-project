<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\TaskFeed;
use DBModel\Model\Table\AppTable;

/**
 * TaskFeeds Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Tasks
 */
class TaskFeedsTable extends AppTable
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

        $this->table('task_feeds');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Tasks', [
            'foreignKey' => 'task_id',
            'className' => 'DBModel.Tasks'
        ]);
        $this->addBehavior('DBModel.QTimestamp', ['field' => 'gmt_created']);
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
            ->integer('gmt_created')
            ->allowEmpty('gmt_created');

        $validator
            ->allowEmpty('line');

        $validator
            ->allowEmpty('flag');

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
        $rules->add($rules->existsIn(['task_id'], 'Tasks'));
        return $rules;
    }

    /**
     * Log task feeds
     *
     * @param int $artifactId artifact id
     * @param string $text log message
     * @param string $flag type message
     * @return \Cake\ORM\RulesChecker
     */
    public function putLine(int $taskId, string $text = '', string $flag = 'O') 
    {
        $new = $this->newEntity([
                'task_id' => $taskId,
                'line' => rtrim($text),
                'flag' => $flag
            ]
        );
        if(!$this->save($new))
            $new->errors();
        return true;
    }
}
