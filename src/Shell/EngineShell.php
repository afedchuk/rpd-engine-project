<?php
namespace App\Shell;

use Cake\Console\Shell;
use App\Shell\App;
declare(ticks = 1);
/**
 * Engine shell command.
 */
class EngineShell extends AppShell
{
    public $eventId;
    public $engineId;

    /**
     * Default functions for identify all engine options
    **/
    protected $defaultFunctions = ['setDefaultTimeZone'];

    public function initialize()
    {
        
        parent::initialize();
        $this->setDefaultTimeZone();
        set('sessionKey', getenv('VL_SESSION_KEY'));
        if(is_array(($result = $this->Events->createEvent('Engine', 1)))) {
            $this->Queue->engineAudit('Could not create engine event. ', ['errors' => $result], 'error');
        } else {
             $this->eventId = set('eventId', $result);
        }
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() 
    {
        register_shutdown_function(array($this,"cleanup"));
        if (function_exists('pcntl_signal')) {
            pcntl_signal(SIGTERM, [&$this, 'signalHandler']);

        }

        // create a wakeup socket - pick some random port
        if (($i = getmypid()) < 10000)
            $i += 10124;
        while (($socket = socket_create_listen($i)) === false)
            $i++;

        // Register this engine in the database
        if(!($result = $this->Engines->register(php_uname('n'), getmypid(), get('sessionKey'), $i))){
            $this->Queue->engineAudit('Engine record already exists. Possible cleanup issue after restart', [
                    ], 'error');
            return false;
        } elseif(is_array($result)) {
             $this->Queue->engineAudit('Engine could register in database', [
                        'errors' => $result
                    ], 'error');
        }

        $this->engineId = set('engineId', $this->Engines->getInsertID());
        $this->_engineLoop($socket);

    }

    private function _engineLoop($socket) 
    {
        $alive = 1; $counter = 0;
        $lastSched = 0;
        while($alive) {
            $this->_overLord();
            // See if there are any new solids to populate, or analyze.
            $hasActivations = 0;
            $this->_initSolid();
            /*while ($this->_analyzerSolid()) {
                $hasActivations++;
            }*/
            $this->_iniDeliverables();
            $this->_initDeliveries();
            foreach ($this->tasks as $key => $value) {
                unset($this->{$key});
            }
            sleep(1);
        }
    }

    /**
     * Stopping engine service on windows and linux platforms
     *
     * @return void
     */
    private function serviceShutdown()
    {
        if (($ppid = getenv("VL_ENGINE_SERVICE_PID")) !== false) {
                if (strstr(PHP_OS,'WIN')) {
                    $wmi = new \COM("winmgmts:{impersonationLevel=impersonate}!\\\\.\\root\\cimv2");
                    $procs = $wmi->ExecQuery("SELECT * FROM Win32_Process WHERE ProcessId='".$ppid."'");
                    $isAlive = false;
                    foreach ($procs as $proc) {
                        if ($proc->ProcessId == $ppid)
                            $isAlive = true;
                    }
                    if (!$isAlive) {
                        $this->Queue->engineAudit("Engine service on host [hostname] has exited, issuing shutdown command.", [
                            '[hostname]' => php_uname('n'),
                        ], 'info');
                        $this->engineShutDown(true);
                    }
                } else {
                    if (posix_kill($ppid,0) === false) {
                        $this->Queue->engineAudit("Engine service on host [hostname] has exited, issuing shutdown command.", [
                            '[hostname]' => php_uname('n'),
                        ], 'info');
                        $this->engineShutDown(true);
                    }
                }
        }
    }

    /**
     * Working with engines (check zombies engine, expire date, update task statuses)
     *
     * @return void
     */
    private function _overLord()
    {   
        try {
            $engine = $this->Engines->get(get('engineId'));
            // Are we shutting down?
            if(strcmp($this->getEngineControl(), $this->Engines::RESTART) == 0) {
                 $this->Queue->engineAudit('Engine [engine] on [hostname] shutting down', [
                        '[hostname]' => php_uname('n'),
                        '[engine]' => get('engineId'),
                    ], 'info');
                $this->engineShutDown(true);
            }

            // did our parent service master go away if there was one?
            $this->serviceShutdown();
            
             // Check our session key with the host master...
            if($this->newEngineSession() != env("VL_SESSION_KEY")) {
                $this->Queue->engineAudit('Engine [engine] on host [hostname] session key has expired, issuing shutdown command.', [
                        '[hostname]' => php_uname('n'),
                        '[engine]' => get('engineId'),
                    ], 'info');
                $this->engineShutDown(true);
            }

            // Check for Zombies...
            $zombieCheck = $this->Prefs->getPreference('engine_zombie_check', 1, 300);
            $this->Engines->updateAll(['gmt_expires' => time() + $zombieCheck], ['id' => get('engineId')]);
            if(($zombie = $this->EngineHosts->tick(php_uname('n'), $zombieCheck)) === true) {
                // We get to check...
                $this->pulseCheck($zombieCheck);
            } elseif(is_array($zombie)) {
                 $this->Queue->engineAudit('Could not update gmt_expires for [host] engine host.', [
                        '[host]' => php_uname('n'),
                        'errors' => $result
                    ], 'error');
            }

            // Task checks for zombied engine hooks
            $this->consistencyCheck();

            // See if we've reached the end of our own life.
            $expired = time() > ($engine->gmt_created + ($this->Prefs->getPreference("engine_life_hr", 1, 24) * 3600)) ? true : false;
            $lifeActions = $this->Prefs->getPreference("engine_life_actions", 1, 100);
            if($expired || ($engine->count >= $lifeActions)) {
                 $this->Queue->engineAudit("Engine shutting down due to age or activity limits.", [], 'error');
                 $this->engineShutDown(true);
            }
        } catch(\Exception $e) {
            $this->Queue->engineOut('Engine [engine] on [hostname] error, engine record has gone away. '. $e->getMessage(), [
                    '[hostname]' => php_uname('n'),
                    '[engine]' => get('engineId')
                ], 'error');
            sleep(3);
            exit();
        }
    }

     /**
     * Solid initialization
     *
     * @return to be determined
     */
    private function _initSolid()
    {
        $results = $this->Solid->main();
        if($results){
            $this->InstanceFactory->build($results);
            remove('artifactId');
        }
    }

      /**
     * Deliverable initialization
     *
     * @return to be determined
     */
    private function _iniDeliverables()
    {
        $results = $this->Deliverable->main();
    }

     /**
     * Delivery initialization
     *
     * @return to be determined
     */
    private function _initDeliveries()
    {
        $results = $this->Delivery->main();
    }

    private function  _analyzerSolid() 
    {
        if(($results = $this->Analyzer->main()) !== false) {
            try {
                $this->InstanceFactory->build($results);
            } catch(\Exception $e) {
                $this->Queue->engineOut('Unable to complete [capability_name] analyzer job. '. $e->getMessage(), [
                    '[capability_name]' => $results['module']], 'error');
            }
            remove('artifactId');
            return false;
        } 
        return false;
    }

    /**
    * Remove engine from table by hostname and pid
    * @return void
    **/
    public function cleanup() {
        if(($result = $this->Engines->kill(php_uname('n'), getmypid())) !== true) {
             $this->Queue->engineAudit('Error unregistering engine process [pid] for [hostname]', [
                        '[hostname]' => php_uname('n'),
                        '[pid]' => getmypid(),
                        'errors' => $result
                    ], 'error');
        }
    }
}
