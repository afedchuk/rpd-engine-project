<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use DBModel\Model\Entity\ArtifactFeed;
use DBModel\Model\Table\AppTable;

/**
 * ArtifactFeeds Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Artifacts
 * @property \Cake\ORM\Association\BelongsTo $Solids
 * @property \Cake\ORM\Association\BelongsTo $Bridges
 * @property \Cake\ORM\Association\BelongsTo $Channels
 */
class ArtifactFeedsTable extends AppTable
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

        $this->table('artifact_feeds');
        $this->displayField('id');
        $this->primaryKey('id');

        $this->belongsTo('Artifacts', [
            'foreignKey' => 'artifact_id',
            'className' => 'DBModel.Artifacts'
        ]);
        $this->belongsTo('Solids', [
            'foreignKey' => 'solid_id',
            'className' => 'DBModel.Solids'
        ]);
        $this->belongsTo('Bridges', [
            'foreignKey' => 'bridge_id',
            'className' => 'DBModel.Bridges'
        ]);
        $this->belongsTo('Channels', [
            'foreignKey' => 'channel_id',
            'className' => 'DBModel.Channels'
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
        return $rules;
    }

    /**
     * Log artifact feeds
     *
     * @param int $artifactId artifact id
     * @param string $text log message
     * @param int $serverId server id if needed
     * @param int $channelId channel id if needed
     * @param string $flag type message
     * @param int $solidId solid id if needed
     * @return \Cake\ORM\RulesChecker
     */
    public function putLine(int $artifactId, string $text = '', int $serverId = 0, int $channelId = 0, string $flag = 'O', int $solidId = 0) 
    {
        $new = $this->newEntity([
                'artifact_id' => $artifactId,
                'solid_id' => $solidId,
                'line' => rtrim($text),
                'bridge_id' => $serverId,
                'channel_id' => $channelId,
                'flag' => $flag,
                'gmt_created' => time()
            ]
        );
        if(!$this->save($new)) {
            return $new->errors();
        }       
        return true;
    }
}
