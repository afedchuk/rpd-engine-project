<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Core\Configure;
use Cake\Log\Log;


/**
 * Engine shell task.
 */
class QueueTask extends Shell
{
	/**
     * Default configuration.
     *
     * @var array
     */
    protected $_defaultConfig = [];

	private $frequency = [0 => 'Disabled', 1 => 'Once', 300 => '5 Minutes', 3600 => 'Hourly', 86400 => 'Daily', 604800 => 'Weekly'];

	private $type = ['info' => ['O', 'S', 'P', 'C', 'T'], 'warning' => ['W'], 'error' => ['E']];

	public $env = [];
	
	/**
	 * Run function.
	 * This function is executed, when a worker is executing a task.
	 * The return parameter will determine, if the task will be marked completed, or be requeued.
	 *
	 * @param array $data The array passed to QueuedTask->createJob()
	 * @param int|null $id The id of the QueuedTask
	 * @return bool Success
	 */
	public function run($data, $id = null) 
	{
		return true;
	}

	public function initialize()
    {
        parent::initialize();
		$this->loadModel('DBModel.Activities');
        $this->loadModel('DBModel.Artifacts');
        $this->loadModel('DBModel.ArtifactFeeds');
        $this->loadModel('DBModel.ArtifactProperties');
		$this->loadModel('DBModel.Deliverables');
        $this->loadModel('DBModel.Deliveries');
        $this->loadModel('DBModel.DeliverySignoffs');
        $this->loadModel('DBModel.DelEnvSignoffs');
        $this->loadModel('DBModel.NotificationTemplates');
        $this->loadModel('DBModel.Usrs');
        $this->loadModel('DBModel.DelEnvs');
        $this->loadModel('DBModel.Bridges');
        $this->loadModel('DBModel.Deliverables');
        $this->loadModel('DBModel.Blobs');
        $this->loadModel('DBModel.Loches');
        $this->loadModel('DBModel.Prefs');
        $this->loadModel('DBModel.PlatformProperties');
        $this->loadModel('DBModel.Properties');
        $this->loadModel('DBModel.TaskFeeds');
        $this->loadModel('DBModel.Tocs');
        $this->loadModel('DBModel.Solids');
        $this->loadModel('DBModel.SolidDepends');
        $this->loadModel('DBModel.SolidAnalyzerMaps');
        $this->loadModel('DBModel.Uris');
        $this->loadModel('DBModel.Zones');
        $this->loadModel('DBModel.Engines');
        $this->loadModel('DBModel.Scripts');

        if(!is_null(get('logFile'))) {
            
        }
    }

    /**
    * Engine audit logs for verbose mode
    * @param string $message message
    * @param array $args message arguments
    * @return void
    **/
    public function engineAudit(string $message, array $args = array(), $level = 'debug') 
    {
		if(!empty($args)) {
			$message = $this->parseArgs($message, $args);
		}
		if(strlen($level) == 1) {
			foreach ($this->type as $key => $value) {
				if(in_array($level, $value)) {
					$level = $key;
				}
			}
		}
		$this->log(renderGmt(time(),'D M j h:i:sa') . "[" . getmypid() . "][" . get('eventId') . "]: $message",  $level);
	}

	/**
    * Engine file and stdout output messages
    **/
    public function engineOut(string $message, array $args = array(), string $level = 'debug')
    {

    	if($message) {
    		$this->putAudit($message, $args);
    		if(!is_null(get('engineId'))) { 
    			$message = $this->parseArgs($message, $args);
    		}
    		$this->log($message, $level);
	    }
    }


    public function feedMe(string $message, array $args = array(), int $bridgeId = 0, int $channelId = 0, string $flag = 'O', int $solidId = 0)
    {
    	$this->helper('Engine')->grepEncryptedProperties($args);
		$message = $this->parseArgs($message, $args);
		$this->engineAudit($message, $args, $flag);
		$needle = ': ';
		$message = substr($message,  strpos($message, $needle) + strlen($needle)); // split message by ': ' to have separate timestamp and message
		if(!is_null(get('artifactId'))) {
			$this->ArtifactFeeds->putLine(get('artifactId'), $message, $bridgeId, $channelId, $flag, $solidId);
		}
		if (!is_null(get('taskId'))) {
			$this->TaskFeeds->putLine(get('taskId'), $message, $flag);
		}
		return true;
    }

    /**
    * Put log message with message arguments in db if event_id exists
    * @param string $message engine message
	* @param array $args message arguments
    * @return void
    **/
    private function putAudit(string $message, array $args)
    {
    	if(!is_null(get('event_id')) && $message) {
    		$obj = TableRegistry::get('DBModel.Oddits');
    		$obj->putAudit(get('event_id'), $message, $args);
    	}
    }

    /**
    * Displays data from the code that led up to the debug_backtrace() function
    * @param string $count count of messages
    * @return void
    **/
    public function stackTrace(int $count = 0) {
		foreach(debug_backtrace(false) as $stack) {
			print $stack['file'].":".$stack['line']." [".$stack['class']."::".$stack['function']."]\n";
			$count--;
			if($count === 0)
				break;
		}
	}

    /**
    * Parse engine message arguments
    * @param string $message engine message
	* @param int $engineId engine id
	* @param array $args message arguments
    * @return string $message
    **/
    private function parseArgs(string $message,  array $args = array()) 
    {
		$this->databaseErrors($args ,$message);
		foreach (array_keys($args) as $key) {
			if(strpos($key,'gmt') > 0) {
				$args[$key] = renderGmt($args[$key]);
			}
			if(strpos($key,'frequency') > 0) {
				$args[$key] = isset($this->frequency[$args[$key]]) ? $this->frequency[$args[$key]] : $args[$key]." ".__('seconds');
			}
			if(!is_array($args[$key])) {
				$message = str_replace($key,$args[$key],$message);
			}
		}
		return renderGmt(time()) . "[" . getmypid() . "][" . get('engineId') . "][" . php_uname('n') . "]: $message\n";
	}

	/**
    * Parse database errros
    * @param string $message engine message
	* @param array $args message arguments
    * @return void
    **/
	private function databaseErrors(array &$args, string &$message)
	{
		if(isset($args['errors'])) {
			$message .= PHP_EOL;
			foreach ($args['errors'] as $key => $value) {
				$message .= " \t --> ".current($value). PHP_EOL;
			}
			unset($args['errors']);
		}
	}

	/**
    * Create unique id for engine
    * @param int $engineId engine id
    * @return string id
    **/
	protected function getUniqueId(int $engineId) {
		return php_uname('n') . "." . $engineId;
	}

	/**
    * Get a global semaphore lock
    * @param string $name name property
    * @param int $lifespan time lock
    * @return string id
    **/
	protected function getLock(string $name, int $lifespan = 0) {
		if($lifespan == 0) {
			$lifespan = $this->getSysPref('lock_timeout', 10);
		} 
		return $this->Loches->getLock($name, $this->getUniqueId(get('engineId')), $lifespan, ($lifespan / 3) + 1, 3);
	}


	/**
    * Release a global semaphore lock
    * @param string $name name property
    * @param int $lifespan time lock
    * @return string id
    **/
	protected function putLock(string $name) {
		return $this->Loches->put($name,$this->getUniqueId(get('engineId')));
	}

	/**
    * Get a system setting from the prefs database.
    * @param string $name name property
    * @param string $default default value
    * @return string property value
    **/
	protected function getSysPref(string $name, string $default = '') {
		return $this->Prefs->getPreference($name, 1, $default);
	}



	/**
    * Update time created for artifact
    * @param array $solid solid info
    * @return void
    **/
	protected function artifactTouch($solid)
	{
		$entity = $this->Artifacts->get($solid->artifact_id);
		if($this->Artifacts->touch($entity , 'Artifacts.gmt_created')) {
			if(!$this->Artifacts->save($entity)) {
				$this->engineAudit('Unable to update artifact time created for artifact [[artifact_id]]. ', [
						'[artifact_id]' => $solid->artifact_id,
						'errors' => $entity->errors()
					], 'error');
			}
		}			
	}

	/**
    * Set ready status for solid and artifact
    * @param int solidId, 
    * @param int artifactId
    * @return void
    **/
	protected function completeInstance(int $solidId = 0, int $artifactId, string $status)
	{
		if($solidId) {
			$this->Solids->setSolidStatus($solidId, 100, $status);
		}
		$this->Artifacts->setArtifactAndDeliverableStatus($artifactId);	
	}

	/**
	* Printing all properties and storing them for sending on a bridge before script will execute 
	* @param string $model model property name
	* @param array $conditions conditions tha need to apply in query
	* @return void
	**/
	protected  function property(string $model, array $conditions = [], bool $force = false)
	{
		$model = TableRegistry::get('DBModel.'.$model);
		$properties = $model->find('all')
            ->where(array_merge(['name not LIKE' => 'LIST_%'], $conditions))
            ->toArray();

        if(!empty($properties)) {
            foreach ($properties as $value) {
                if (strpos($value['value'], '!#!') !== false) {
                	$this->env['hidden_props'][$value['name']] = $value['value'];
                	$value['value'] = str_replace($value['value'], str_repeat('*', 5), $value['value']);
                } 
                $this->env[$value['name']] = $value['value'];
            }
        }
	}

	/**
	* Modiyfing properties before send on a bridge and saving them in db
	* @param array $properties properties
	* @param bool $force modify env properties
	* @return void
	**/
	protected function propertyOut(array $properties = [], bool $force = false)
	{	
		foreach ($properties as $key => $value) {
			if(!is_array($value)) {
				$this->env['local'] = array_merge($this->env['local'], [$key => $value]);
				foreach(array_merge($this->env['env'], $this->env['local']) as &$value) {
					$value = expandText( $this->env['local'], $value);
				}
				$this->feedMe($key . '=' .$value, [], (!is_null(get('bridge')) ? get('bridge')['id'] : 0), 0, 'P', get('solidId'));
				unset($this->env[$key]);
			} else {
				if($force) {
					foreach ($value as $k => $env) {
						if(in_array($key , ['env']) && !preg_match('/VL_/', $k)) {
							unset($this->env[$key][$k]); $k = 'VL_'. strtoupper($k);
							$this->env[$key] = array_merge($this->env[$key], [$k => $env]);
							$this->feedMe($k . '=' .$env, [], (!is_null(get('bridge')) ? get('bridge')['id'] : 0), 0, 'P', get('solidId'));
						}
					}
				}
			}
		}
		
	}

}
