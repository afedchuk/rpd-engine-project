<?php
namespace DBModel\Model\Table;

use Cake\ORM\Query;
use Cake\ORM\RulesChecker;
use Cake\ORM\Table;
use Cake\Validation\Validator;
use Cake\ORM\TableRegistry;
use DBModel\Model\Entity\Activity;
use DBModel\Model\Table\AppTable;

/**
 * Activities Model
 *
 * @property \Cake\ORM\Association\BelongsTo $Processes
 * @property \Cake\ORM\Association\BelongsTo $DefActivities
 * @property \Cake\ORM\Association\BelongsTo $LibActivities
 * @property \Cake\ORM\Association\HasMany $ActivityDepends
 * @property \Cake\ORM\Association\HasMany $TaskParams
 * @property \Cake\ORM\Association\HasMany $Tasks
 */
class ActivitiesTable extends AppTable
{
    const ACTIVE = 'ACTIVE';
    const INCOMPLETE = 'INCOMPLETE';
    const STOPPED = 'STOPPED';
    const DONE = 'DONE';
    const COMPLETE = 'COMPLETE';
    const SUSPENDED = 'SUSPENDED';
    const WAIT = 'WAIT';
    const SKIPPED = 'SKIPPED';

    public static $status = [SELF::ACTIVE, SELF::INCOMPLETE, SELF::STOPPED, SELF::DONE, SELF::COMPLETE, SELF::SUSPENDED, SELF::WAIT, SELF::SKIPPED];
    public static $busyStatus = [SELF::DONE, SELF::COMPLETE, SELF::WAIT, SELF::STOPPED, SELF::SKIPPED, SELF::SUSPENDED, SELF::INCOMPLETE];

    /**
     * Initialize method
     *
     * @param array $config The configuration for the Table.
     * @return void
     */
    public function initialize(array $config)
    {
        parent::initialize($config);

        $this->table('activities');
        $this->displayField('name');
        $this->primaryKey('id');
		$this->Tasks = TableRegistry::get('DBModel.Tasks');

        $this->belongsTo('Processes', [
            'foreignKey' => 'process_id',
            'className' => 'DBModel.Processes'
        ]);
        $this->belongsTo('DefActivities', [
            'foreignKey' => 'def_activity_id',
            'className' => 'DBModel.DefActivities'
        ]);
        $this->belongsTo('LibActivities', [
            'foreignKey' => 'lib_activity_id',
            'className' => 'DBModel.LibActivities'
        ]);
        $this->hasMany('ActivityDepends', [
            'foreignKey' => 'activity_id',
            'className' => 'DBModel.ActivityDepends'
        ]);
        $this->hasMany('TaskParams', [
            'foreignKey' => 'activity_id',
            'className' => 'DBModel.TaskParams'
        ]);
        $this->hasMany('Tasks', [
            'foreignKey' => 'activity_id',
            'className' => 'DBModel.Tasks'
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
            ->allowEmpty('name');

        $validator
            ->allowEmpty('flag');

        $validator
            ->integer('gmt_start')
            ->allowEmpty('gmt_start');

        $validator
            ->integer('duration')
            ->allowEmpty('duration');

        $validator
            ->integer('activity_timeout')
            ->allowEmpty('activity_timeout');

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
        $rules->add($rules->existsIn(['process_id'], 'Processes'));
        $rules->add($rules->existsIn(['def_activity_id'], 'DefActivities'));
        $rules->add($rules->existsIn(['lib_activity_id'], 'LibActivities'));
        return $rules;
    }
	
	 /**
     *  Method that finds a dependent task id and corresponding task feeds 
     *
     * @param int $activityId  Activity ID
	 * @param int $processId  Process ID
	 * @param string $logType  Type og Logs
     * @return array
     */
    public function getActTree(int $activityId, int  $processId, string $logType) {

        $acts = [];
        // Find out dependent id 
        $activityDepended = $this->ActivityDepends
                                 ->findByActivityId($activityId)
                                 ->toArray();

        foreach($activityDepended as $act) {
            $depId = $this->find()->where(['process_id' => $processId , 'def_activity_id' => $act->def_depend_id ])->first();
            if($depId){
                $acts[] = [ 'act_id' => $depId->id, 'name' => $depId->name ];
            }
            
        }
        
        $taskFeeds = [];
        $tasknames = [];
        // Fetch task feeds and names
        foreach ($acts as $action) {
                    $tasks = $this->Tasks->findByActivityId($action['act_id'])->toArray() ;
                   
                    foreach($tasks as $task) {
                        $taskFeeds[$action['name'].'_'.$action['act_id']] = $task;
                    }
        }
        // Call log files generation
        $paths = $this->generateActionLog($taskFeeds, $logType);
        return($paths);
    }

    
	 /**
     *  Function that generate log files for give task feeds
     *
     * @param array $taskFeeds  Task Feeds
	 * @param string $log_type Log Type
     * @return array
     */
    public function generateActionLog(array $taskFeeds, string $log_type){

        $paths = [];
        
        // Define log format
        $log_date_format = $this->getSysPref('log_date_format','H:i:s');
        // Define layouts for different outputs
        $styles = ['P' => 'style="color: rgb(64, 93, 172);font-style: italic;font-size: 12px;"', 'C'=>'style="    color: rgb(33, 133, 7);
                     font-style: italic;font-size: 12px;"', 'S'=>'style = "font-style: italic;font-size: 12px;"', 'T' => 'style = "    color: rgb(122, 0, 119);
                     font-style: italic;font-size: 12px;"', 'E' => 'style = "color: rgb(255, 0, 0);font-weight: bold;font-size: 12px;"', 'O' => 'style = "font-style: italic;font-size: 12px;"'];
        $paths = [];
        // Build files  
        foreach ($taskFeeds as $id => $taskFeed) {
            $path = ROOT . '/app/tmp/' .$id.".html";
            $f1 = fopen($path, "a");
            $output = "<table style = 'border-collapse: collapse;'>"."\n";
            // Generate table
            foreach ($taskFeed as $key => $task) {
                if((in_array($task['flag'], array('P', 'C', 'T')) || preg_match('/(Task Finished|Task Activated|Success based on|Authentication succeeded: acquired session credential|echo)/', $task['line'])) && $log_type == "Action Only")
                    continue;
                $output .= "<tr>";
                $output .= '<td width="1%" style="text-align:left; vertical-align: top; word-break: break-all;padding-left: 2px;white-space: nowrap; padding-right: 4px;">'.renderGmt($task['gmt_created'],$log_date_format).'&nbsp;</td>';
                $output .= '<td>'.$key.'&nbsp;&mdash;&nbsp;';
                $output .= '<span '.$styles[$task['flag']].'>';
                $str = ''; 
                if(!preg_match('/PASSWORD/', $task['line'])) {
                    $str = $task['line']; 
                    } 
                else {
                    $label = substr($task['line'], 0,  strpos($task['line'], '='));
                    $str = $label.'='.str_repeat('*',strlen($task['line']) - strlen($label));
                }
                $output .= $str;
            }
            fwrite($f1, $output);
            $paths[] = $path;
        }

        return($paths);
    }
    
	 /**
     *  Remove generated files
     *
     * @param array $path path to file log
     * @return bool
     */
    function destroyActionLogs($path){
        foreach ($path as $key => $file) {
            unlink($file);
        }
        return(true);
    }
}
