<?php
namespace App\Shell;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use App\Shell\App;

declare(ticks = 1);

/**
 * Engine shell command.
 */
class QShell extends AppShell
{
    /**
     * Default functions for identify all engine options
    **/
    protected $defaultFunctions = ['identifyPlatform', 'isEnabledEngineLogging', 'setDefaultTimeZone', 'newEngineSession', 
                                 'getEngineCount', 'getWakeupInterval',
                                 'settingEnvironmentVariables'];

    private $handles = [0 => STDIN, 1 => STDOUT, 2 => STDERR];        
                  
    public function initialize()
    {
        parent::initialize();
        $this->pid = getmypid(); 
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main() 
    {
    	/* Call basic methods */
        foreach($this->defaultFunctions as $func) {
             call_user_func_array(array($this, $func), []);
        } 

    	// in verbose mode, engines will write to stdout.
		// otherwise they will log their output.
		if ($this->engineProperties['engineVerbose'])
			$this->handles = [1 => ['file', LOGS.$this->logFile.'.log', 'a'], 2 => ['file', LOGS.$this->logFile.'.log', 'a']];

    	// Enable Garbage Collector
		if (function_exists('gc_enable')) {
			gc_enable();
		}

		/* Starting the main loop */
    	$procs = [];
    	while (1) {
    		set_time_limit(0);
    		for ($i = 0 ; $i < $this->engineProperties['engineCount']; $i++) {
    			if (empty($procs[$i]) || ($info = proc_get_status($procs[$i])) === false) {
    				$pipes = [];
					if(($process = proc_open($this->run.' engine', $this->handles, $pipes))) {
						$info = proc_get_status($process);
						$this->Queue->engineOut("Started Engine Process " . $info['pid']);
						$procs[$i] = $process;
					}
					continue;
    			}
    			if ($info['running'] === false) {
    				$this->Queue->engineOut("Engine process " . $info['pid'] . " has exited.");
    				proc_close($procs[$i]);
					unset($procs[$i]);
					if($this->getEngineCount() < 2)
						$this->engineProperties['engineCount'] = 2;
					continue;
    			}
    		}
    		sleep($this->engineProperties['engineTickSec']);
    	}
    }

    /**
    * Set all necessary environment variables
    *
    * @return bool os type.
    **/
    private function settingEnvironmentVariables()
    {
    	$this->Queue->engineOut("Q install directory located at " . getcwd());
    	$this->Queue->engineOut("Q Engine Service starting");
    	$this->Queue->engineOut("Timezone set to $this->tz");

        putenv("VL_ENGINE_SERVICE_PID=$this->pid");
        putenv("VL_ENGINE_VERBOSE=".$this->engineProperties['engineVerbose']);
        putenv("VL_SESSION_KEY=$this->sessionKey");

        $this->Queue->engineOut("Engine session key: $this->sessionKey");
        $this->Queue->engineOut("System configured for ".$this->engineProperties['engineCount']." concurrent engine processes.");
        $this->Queue->engineOut("Job scan interval configured for ".$this->engineProperties['engineTickSec']." seconds.");
    }
}
