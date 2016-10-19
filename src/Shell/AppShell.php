<?php
namespace App\Shell;

use Cake\Console\ConsoleOptionParser;
use Cake\Console\Shell;
use Cake\Core\Configure;
use Cake\Log\Log;
use Cake\Utility\Text;
use Cake\ORM\TableRegistry;
use Cake\Controller\Component;
use Cake\Controller\ComponentRegistry;
declare(ticks = 1);

/**
 * Simple app wrapper.
 */
class AppShell extends Shell
{

    public $tasks = ['Queue', 'Analyzer', 'Solid', 'InstanceFactory', 'Deliverable', 'Delivery'];

    protected $Task;

    /**
     * Time zone property
    **/
    protected $tz;

    /**
     * Process ID of current session
    **/
    protected $pid = null;

    /**
     * Engine host session key
    **/
    protected $sessionKey;

    /**
     * OS platform identify
    **/
    protected $os = false;

    public $run = 'run.bat';

    /**
     * Default functions for identify all engine options
    **/
    protected $defaultFunctions = [];

     /**
     * Determine the number of engines we need to be running, engine log status and the wake up interval for engine
    **/
    public $engineProperties = ['engineCount' => 2 , 'engineTickSec' => 3, 'engineVerbose' => 0];


	/**
     * Engine log file name
    **/
    public $logFile = 'engine-debug';

    public function startup() 
    {
        
    }

    public function initialize()
    {
        parent::initialize();
        $this->loadModel('DBModel.Api');
        $this->loadModel('DBModel.Analyzers');
        $this->loadModel('DBModel.BuildCheckouts');
        $this->loadModel('DBModel.Deliveries');
        $this->loadModel('DBModel.DeliveryProcesses');
        $this->loadModel('DBModel.Events');
        $this->loadModel('DBModel.Engines');
        $this->loadModel('DBModel.EngineHosts');
        $this->loadModel('DBModel.Prefs');
        $this->loadModel('DBModel.Platforms');
        $this->loadModel('DBModel.PlatformProperties');
        $this->loadModel('DBModel.Properties');
        $this->loadModel('DBModel.Processes');
        $this->loadModel('DBModel.Solids');
        $this->loadModel('DBModel.Zones');

        $this->Task = TableRegistry::get('DBModel.Tasks');

        $this->identifyPlatform();
    }

    /**
    * Killing process on press Ctrl+C and other
    *
    * @return void
    **/
    public function signalHandler($signal)
    {
        if(in_array($signal, [SIGINT, SIGTERM, SIGHUP, SIGCHLD])) {
            $this->Queue->engineAudit("Interrupt received, killing ".getmypid()." engine process. [result]", [
                    '[result]' => (pcntl_signal($signal,array($this,"signalHandler")) === true) ? '' : '*** FAIL'
                ], 'info');
            exit();
        }
    }


    /**
    * Identify platform for engine
    *
    * @return void
    **/
    protected function identifyPlatform()
    {
        switch (strncasecmp(PHP_OS,"WIN",3)) {
            case 0:
                $this->os = true;
                break;
            default:
                pcntl_signal(SIGINT, [&$this, "signalHandler"]);
                $this->run = './run';
                break;
        }
    }

    /**
    * Set file name for engine logs
    *
    * @return string file path.
    **/
    protected function getEngineLoggingFilepath()
    {
        if(($file = $this->Prefs->getPreference('engine_debug_filepath')) != null) {
            $this->logFile = $file;
        }
        return $this->logFile;
    }

    /**
    * Enable if needed the engine logs
    *
    * @return bool engine verbose property.
    **/
    protected function isEnabledEngineLogging()
    {
        if(($verbose = $this->Prefs->getPreference('enable_engine_logging')) != null) {
            $this->engineProperties['engineVerbose'] = in_array($verbose, ['y','yes']) ? 1 : 0;
        }
        return $this->engineProperties['engineVerbose'];
    }


    /**
    * Set default time zone
    * @return string time zone property
    **/
    protected function setDefaultTimeZone()
    {
        $this->tz = date_default_timezone_get();
        if(($timeZone = $this->Prefs->getPreference('tz')) != null) {
            $this->tz = $timeZone;
            date_default_timezone_set($timeZone);
        }
        return $this->tz;
    }

     /**
    * Create new enginehost session
    * @return string key session
    **/
    protected function newEngineSession()
    {
        $this->sessionKey = Text::uuid();
        if (($engineHost = $this->EngineHosts->findByHostname(php_uname('n'))->first()) === null) {
            $entity = $this->EngineHosts->newEntity();
            $engineHost = $this->EngineHosts->patchEntity($entity, ['hostname' => php_uname('n'),'session_key' => $this->sessionKey, 
                    'gmt_expires' => time() + 30, 'max_engines' => $this->Prefs->getPreference('default_engine_count', 1, 3),'zone_id' => 0]
                    );
            $this->EngineHosts->save($engineHost);
        } else {
            $entity = $this->EngineHosts->get($engineHost->id, ['contain' => []]); 
            $engineHost = $this->EngineHosts->patchEntity($entity, ['session_key' => env("VL_SESSION_KEY")], ['validate' => false]);
            if ($this->EngineHosts->save($engineHost))
                    return env("VL_SESSION_KEY");
        }
        return $this->sessionKey;
    }

    /**
    * Get max engine hosts tha we are running
    * @return int engine count
    **/
    protected function getEngineCount()
    {
        if(($engineHost = $this->EngineHosts->findByHostname(php_uname('n'))->first()) != false &&
                $engineHost->max_engines > 2) {
            $this->engineProperties['engineCount'] = $engineHost->max_engines;
        }
        return $this->engineProperties['engineCount'];
    }

    /**
    * Get wake up interval for engine
    * @return int wake up interval
    **/
    protected function getWakeupInterval()
    {
        if(($engineTickSec = $this->Prefs->getPreference('engine_tick_sec')) != false) {
            $this->engineProperties['engineTickSec'] = $engineTickSec;
        }
        return $this->engineProperties['engineTickSec'];
    }

    /**
    * This task checks for zombies and the likes
    * @return int $zombieCheck checkout timeout
    * @return array $result engines ids
    **/
    protected function pulseCheck(int $zombieCheck = 300)
    {
        $result = $this->EngineHosts->pulseCheck($zombieCheck);
        if(isset($result['assign']) && !empty($result['assign'])) {
            foreach($result['assign'] as $id) {
                try {
                    // Clean up all tasks related with engine id
                    if(($result = $this->Engines->pulseCheckClean($id, $zombieCheck)) !== true) {
                        $this->Queue->engineAudit("Could not clean up the engine [[engine]].",[
                                '[engine]' => $id,
                                'errors' => $result
                            ]
                        );
                    }
                } catch(\Exception $e) {
                    $this->Queue->engineAudit("Incorrectly accessing the model, or invalid database state. ". $e->getMessage(), []);
                }

            }
        }
        if(isset($result['clean']) && !empty($result['clean'])) {
            foreach($result['clean'] as $id) {
                try {
                    if(!($hook = $this->Engines->cleanup($id))) {
                        $this->Queue->engineAudit("Engine [engine_bad] exited. Engine [engine_good] has cleaned up the engine reference.", [
                                '[engine_bad]' => $id,
                                '[engine_good]' => get('engineId'),
                                'errors' => $hook
                            ]
                        );
                    }
                } catch(\Exception $e) {
                    $this->Queue->engineAudit("Incorrectly accessing the model, or invalid database state. ". $e->getMessage(), []);
                }
            }
            $this->Engines->delete($this->Engines->get(get('engineId')));
        }
        return $result;
    }

    /**
    * This task checks for zombied engine hooks
    * @return array $result engines ids
    **/
    protected function consistencyCheck()
    {
        try {
            $ids = [];
            foreach(['Tasks', 'Solids', 'Processes', 'Deliveries', 'BuildCheckouts', 'DeliveryProcesses', 'Api'] as $model) {
                 if(method_exists("\DBModel\Model\Table\\".$model."Table", 'consistencyCheck')) {
                    $model =  in_array($model, ['Tasks']) ? 'Task' : $model;
                    if(($result = $this->{$model}->consistencyCheck($ids)) !== true) {
                         $this->Queue->engineAudit('Incorrectly checking for zombied engine hooks.', ['errors' => $result]);
                    }
                }
            }
            if(!empty($ids)) {
                foreach ($ids as $type =>  $id) {
                   foreach($id as $id) {
                        $this->Queue->engineAudit("Engine for [record_type] record [record_id] crashed during execution . Engine [engine_good] has cleaned up the reference.", [
                                      '[record_type]' => $type,
                                      '[record_id]' => $id,
                                      '[engine_good]' => get('engineId'),
                                    ]
                                );
                    }
                }
            }
        } catch(\Exception $e) {
            $this->Queue->engineAudit("Incorrectly accessing the model, or invalid database state. ". $e->getMessage(), []);
        }
    }

    /**
    * Return the control state of engine
    * @return bool | string engine control
    **/
    protected function getEngineControl()
    {
        if(!is_null(get('engineId'))) {
            try {
                return $this->Engines->get(get('engineId'))->control;
            } catch(\Exception $e) {
                $this->Queue->engineAudit("Incorrectly accessing the model, or invalid database state.". $e->getMessage(), []);
            }
        }
        return false;
    }

    /**
    * We always shut down now. a separate process will manage other engines.
    * @param bool $force force shut down
    * @return void
    **/
    protected function engineShutDown(bool $force = false)
    {
        if(!$force) {
            if(strcmp($this->getEngineControl(), $this->Engines::RESTART) != 0) {
                if(($idleEngines = $this->Engines->find()->where(['activity' => 'Idle'])->count()) && $idleEngines < 2) {
                    return;
                }
            }
        }
        exit();
    }
}
