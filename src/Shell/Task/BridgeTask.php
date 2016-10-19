<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Utility\Inflector;
use App\Shell\Task\Task\ExecuteTask;

/**
 * Bridge shell task.
 */
class BridgeTask extends QueueTask
{
	public $tasks = [];

	public $_bridge = [
				'platform' => '', 
				'remote_platform' => 0, 
				'connected' => false, 
				'wport' => 50005, 
				'rport' => 50006,
				'host' => 'localhost',
				'r' => null,
				'w' => null,
				'errno' => 0,
				'errstring' => '',
				'status' => 0,
				'exit_status' => 0,
				'proto' => 0,
				'receive_patterns' => [],
				'env' => [],
				'despatcher' => null
			];

	public $statusMessages = [
				992 => 'Remote did not specify content name for send operation',
				993 => 'Data corruption receiving artifact',
				994 => 'Bridge connection lost due to timeout',
				995 => 'Illegal protocol response from remote. Aborting connection.',
				996 => 'Illegal RECV protocol state received. Aborting connection.',
				997 => 'Remote did not specify content name for send operation' ,
				998 => 'Timeout waiting for response from bridge.',
				999 => 'Bridge connection has gone away.'
			];

	public $blockTypes = ['QUIT', 'STATUS', 'ERROR', 'TEXT', 'SEND', 'FILE_INFO', 'RECV'];

	public static $bridgeProperties = [
				'read_timeout' => 300, 
				'connect_timeout' => 200, 
				'pack_id' => 1,
				'event_id' => 0
			];

	public function initialize()
    {
        parent::initialize();
        $this->ExecuteTask = new ExecuteTask();
        $this->ExecuteTask->initialize();
        $this->_bridge['trace'] = intval($this->getSysPref('trace_bridge_connection', 0));

        if(is_null(get('bridgeParams'))) {
	        self::$bridgeProperties['connect_timeout'] = $this->getSysPref('bridge_connect_timeout', 20);
	        self::$bridgeProperties['read_timeout'] = $this->getSysPref('server_read_timeout', 300);
	        self::$bridgeProperties['write_timeout'] = $this->getSysPref('write_timeout', 300);
	        self::$bridgeProperties['event_id'] = get('eventId');
	    }

        self::$bridgeProperties = !is_null(get('bridgeParams')) ? array_merge(self::$bridgeProperties, get('bridgeParams')) : self::$bridgeProperties;

        if(is_null(get('bridge'))) {
        	set('bridge', $this->_bridge);
        }
    }

     /**
     * Establish a connection to a bridge. this will auto-install the capability module on
     *
     * @param string $host hostname[:port] - port defaults to 50005
     * @param int $timeout timeout connection
     * @return connection handle or false
     */
	public function connect(string $host) 
	{
		if(!get('bridge')['connected']) {
			try {
				$bridge = $this->Bridges->findByHostname($host)
										->select(['id', 'platform', 'remote_platform', 'despatcher', 'hostname'])
										->first();
				if(!is_null($bridge)) {
					foreach ($bridge->toArray() as $key => $value) {
						if (trim($value)) {
							$this->_bridge[$key] = $value;
						}
					}
					if($this->_bridge['despatcher']) {
						$this->_bridge['despatcher'] = parse_url($this->_bridge['despatcher']);
						if(!isset($this->_bridge['despatcher']['port'])) {
							$this->_bridge['despatcher']['port'] = '50004'; 
						}
						$this->_bridge['env']['dispatch_target_host'] = $bridge['hostname'];
						$this->_bridge['env']['remote_platform'] = $this->_bridge['remote_platform'];
						$this->_bridge['env']['dispatch_platform'] = $this->_bridge['platform'];
						$host = $this->_bridge['despatcher']['host'];
					}

					$port = isset($this->_bridge['despatcher']['port']) ? $this->_bridge['despatcher']['port'] : 0;
					$this->_bridge['host'] = $this->parseBridgeHostname($host, $port);
					if($this->createStreamContext($host)) {
						$this->_bridge['connected'] = true;
						$this->_bridge['env']['bridge_version'] = $this->_bridge['proto'];
						set('bridge', $this->_bridge);
						return true;
					}
				} else {
					throw new \Exception("Could not specified remote platform for execution server, remote [host] server not found", 1);
				}
			} catch(\Exception $e) {
	            $this->engineOut('Internal error of [bridge] server connection . '. $e->getMessage(), ['[bridge]' => $host], 'error');
	            return false;
	        }
	        return false;
	    }
	    return true;
	}

	 /**
     * Shut down a link to a bridge
     *
     * @param string $host hostname[:port] - port defaults to 50005
     * @param int $timeout timeout connection
     * @return void
     */
	function disconnect() {
		if (get('bridge')['connected']) {
			if (is_resource($this->_bridge['w'])) {
				fclose($this->_bridge['w']); 
			} 
			$this->_bridge['w'] = null;
			if (is_resource($this->_bridge['r'])) {
				fclose($this->_bridge['r']);
			} 
			$this->_bridge['r'] = null;
			$this->_bridge['connected'] = false;
			
			remove('bridgeParams');
			remove('bridge'); 
		}
		$status = $this->_bridge['status'];
		return $status;
	}

	
	/**
     * Creat stream context for bridge
     *
     * @param string $host hostname[:port] - port defaults to 50005
     * @return void
     */
	private function createStreamContext(string $host)
	{
		// get a socket to the initial write channel port
		$context = stream_context_create($this->contextOptions($host));
		$this->_bridge['w'] = @stream_socket_client($this->_bridge['host'], $this->_bridge['errno'], $this->_bridge['errstring'], self::$bridgeProperties['connect_timeout'], STREAM_CLIENT_CONNECT, $context);
		if ($this->_bridge['w'] === false) {
			$this->feedMe(socket_strerror(socket_last_error()), [], 0, 0, 'E', get('solidId'));
			$this->engineOut('Unable to connect to remote server data socket at [host]', [
										'[host]' => $this->_bridge['host']
									], 'error'
							);
			if($this->Bridges->updateAll(['platform' => 'Offline'], ['id' => $this->_bridge['id']])) {
				return false;
			}
		}

		// the bridge will write back a port number that we should use to establish the read channel
		// yes, it writes to the read channel (and we read from the write channel). it's a socket so relax.
		$this->setReadTimeout($this->_bridge['w'], self::$bridgeProperties['connect_timeout']);
		$this->_bridge['rport'] = rtrim(fgets($this->_bridge['w']));
		if ($this->setReadTimeout($this->_bridge['w'], self::$bridgeProperties['write_timeout']) == true) {
			$this->engineOut('Timeout waiting for secondary negotiation with [host]', ['[host]' => $this->_bridge['host']]);
			fclose($this->_bridge['w']);
			if($this->Bridges->updateAll(['platform' => 'Offline'], ['id' => $this->_bridge['id']])) {
				return false;
			}
		}

		// NOTE: here we check for the port number returned by dispatcher. If such equals 0, then remote dispatcher is configured
		// to work in a single channeld mode. In this case we won't need to create a separate write socket, but can use existing one.
		if ($this->_bridge['rport'] == '0') {
			$this->_bridge['r'] = $this->_bridge['w'];
		} else {
			// set the secondary port number in the hostname
			$newhost = $this->parseBridgeHostname($this->_bridge['host'], $this->_bridge['rport']);
			// open up a socket on the read channel port
			if (($this->_bridge['r'] = stream_socket_client($newhost, $this->_bridge['errno'], $this->_bridge['errstring'], self::$bridgeProperties['connect_timeout'], STREAM_CLIENT_CONNECT, $context)) === false) {
				$this->feedMe('Bridge control port unavailable - will retry', [], 0, 0, 'S', get('solidId'));
				$this->engineOut('Control port negotiation failed on [host]', ['[host]' => $this->_bridge['host']]);
				fclose($this->_bridge['w']);
				return true;
			}
		}

		// the bridge will return the platform string as the first line of the read handle
		$this->setReadTimeout($this->_bridge['r'], self::$bridgeProperties['connect_timeout']);
		$this->_bridge['platform'] = rtrim(fgets($this->_bridge['r']));
		
		if (preg_match('/^\d+-/',$this->_bridge['platform'])) {
			list($this->_bridge['proto'], $this->_bridge['platform']) = explode('-',$this->_bridge['platform'],2);
		}

		if ($this->setReadTimeout($this->_bridge['r'], self::$bridgeProperties['read_timeout']) == true) {
			$this->engineOut('Timeout waiting for final negotiation with [host]', ['[host]' => $this->_bridge['host']]);
			if (is_resource($this->_bridge['w']))  {
				fclose($this->_bridge['w']); 
			}
			$this->_bridge['w'] = null;
			if (is_resource($this->_bridge['r'])) {
				fclose($this->_bridge['r']); 
			}
			$this->_bridge['r'] = null;
			if($this->Bridges->updateAll(['platform' => 'Offline'], ['id' => $this->_bridge['id']])) {
				return false;
			}
		}
		return true;		
	}

	 /**
     * Read a response block from the bridge. in the meat 'n taters this is at least the taters.
     *
     * @return a string if there could be more to receive or false if we get a STATUS block
     */
	public function getBridgeResponseBlock()
    {
    	if(isset(get('bridge')['id'])) {
    		$this->setReadTimeout(null, self::$bridgeProperties['read_timeout']);
    		if(($buf = rtrim($this->getLine())) === false) {
				if ($this->setReadTimeout(null, self::$bridgeProperties['read_timeout'])) {
					$this->setStatus(-998);
				}
				return false;
			}
			$tokens = explode(' ', $buf);
			$block = array_shift($tokens);
			if(isset($tokens[0])) {
				if (($key = array_search($block, $this->blockTypes)) !== false){
		            $result = $this->{'__'.lcfirst(Inflector::classify(strtolower($this->blockTypes[$key])))}($tokens, $buf);
		            return (!in_array($block, ['STATUS'])) ? $result : false;
		        } else {
		            $this->setStatus(-995);
		            return false;
		        }
		    } else {
				$this->send("END\n");
				$this->setStatus(-997);	
		    }
    	} else {
    		$this->setStatus(-999);
    		return false;
    	}
    	return false;
    }

    /**
    * Send properties to remote server/bridge
    * @return void
    **/
    public function predefineVariable($env)
    {
    	$bridge = get('bridge');
    	if(!is_null($bridge) && isset($env)) {
    		$envVars = "";
    		foreach ($env as $key => $value) {
    			if($bridge['proto'] < 500000) {
    				$this->send("_env $key=" . $value . "\n");
                	$this->getBridgeResponseBlock();
    			} else {
                	$envVars .= "(".strlen("$key=$value").")$key=$value";
    			}
    		}
    		if(strlen($envVars) > 0) {
    			$this->send("_env $envVars" . "\n");
            	$this->getBridgeResponseBlock();
    		}
    		unset($bridge['env']);
    		set('bridge', $bridge);
    	}
    }

	 /**
     * Prepare context opions before stream creating
     *
     * @param string $host hostname[:port] - port defaults to 50005
     * @return array options
     */
	private function contextOptions($host)
	{
		$options = [];
		if (strncmp($host, 'ssl://', 6) == 0 || strncmp($host, 'tls://', 6) == 0) {
			$options = [
				'ssl' => [
					'ciphers' => $this->getSysPref('ssl_ciphers', 'aNULL'),
					'verify_peer' => ($this->getSysPref('ssl_verify_peer', 'n') == 'y' ? true : false)
				]
			];
		}
		return $options;
	}

	/**
     * Parse server hostname
     *
     * @param string $host server hostname
     * @param int $port server port
     * @return string server hostname
     */
	public function parseBridgeHostname(string $host, int $port = 0) 
	{
		$hostParts = parse_url($host);
		$hostParts['host'] = !isset($hostParts['host']) ? $hostParts['path'] : $hostParts['host'];
		$hostParts['scheme'] = isset($hostParts['scheme']) ? $hostParts['scheme'] : 'tcp';
		$hostParts['port'] = $port > 0 ? $port : (($this->getSysPref('legacy_bridge_mode','n') == 'y') ? 50005 : 50004);
		return $hostParts['scheme'] . "://" . $hostParts['host'] . ":" . $hostParts['port'];
	}


     /**
     * Set a socket read timeout and return the timeout status
     *
     * @param resource $handle stream resource
     * @param int $sec seconds to set a timeout, null to just return timeout status
     * @return bool the last timeout flag from the stream meta data
     */
	public function setReadTimeout($handle, int $sec = 300) 
	{
		$handle = is_null($handle) ? get('bridge')['r'] : $handle;
		if (is_resource($handle)) {
			$info = stream_get_meta_data($handle);
			stream_set_timeout($handle, $sec);			
			if (isset($info['timed_out']) && $info['timed_out'] == true) {
				return true;
			}
		} 
		return false;
	}


	/**
     * Set the STATUS value returned from a bridge upon command completion
     *
     * @param int $val status value
     * @return bridge status
     */
	public function setStatus(int $val) 
	{
		$this->_bridge = get('bridge');
		$this->_bridge['status'] = intval($val);
		$this->_bridge['results']['Remote']['status'] = $this->_bridge['status'];
		if(isset($this->statusMessages[abs($val)])) {
			$this->engineOut($this->statusMessages[abs($val)], []);
			$this->feedMe($this->statusMessages[abs($val)], [], (isset($this->_bridge['id']) ? $this->_bridge['id'] : 0), 0, 'E', get('solidId'));
		}
		set('bridge', $this->_bridge);
		return get('bridge')['status'];
	}

	public function setTrace(int $flag) {
		get('bridge')['trace'] = $flag;
		set('bridge', $this->_bridge);
	}

	/**
     * Read a \n terminated string from a bridge
     *
     * @return a bridge buffer
     */
	public function getLine() 
	{
		if(is_resource(get('bridge')['r'])) {
			if ((($buf = fgets(get('bridge')['r'])) === false) || feof(get('bridge')['r'])) {
				return false;
			}
			return $buf;
		}
		return false;
	}


	/**
     * Write a set number of bytes out to a bridge
     *
     * @param string $buf bridge buffer
     * @param int $len number of bytes
     * @return bool
     */
	public function send(string $buf, int $len = 0) 
	{
		$len = ($len == 0) ? strlen($buf) : $len;
		if(is_resource(get('bridge')['w'])) {
			if (fwrite(get('bridge')['w'], $buf, $len) != $len) {
				return false;
			}
		}
		
		return true;
	}

	/**
     * Read a set number of bytes from a bridge
     *
     * @param int $len number of bytes
     * @return string bridge buffer
     */
	public function recv(int $len) 
	{
		$buf = '';
		while (strlen($buf) < $len) {
			$rbuf = fread(get('bridge')['r'], $len - strlen($buf));
			if($rbuf === false) {
				break;
			}
			$buf .= $rbuf;
		}
		return $buf;
	}

    private function __quit(array $params, string $buf) 
    {
    	return true;
    }

    private function __status(array $params, string $buf)
    {
    	return $this->setStatus($params[0]);
    }

    private function __error(array $params, string $buf)
    {
    	if(isset($params[0])) {
    		$error = rtrim($this->recv($params[0]));
    		$this->engineOut($error, [], 'error');
    		if(strpos($error, 'Java HotSpot(TM) 64-Bit Server VM warning') === false) {
				$this->feedMe($error, [], get('bridge')['id'] ,0, 'E', get('solidId'));
			}
			return true;
    	}
    	return false;
    }

    private function __text(array $params, string $buf)
    {
    	if(isset($params[0])) {
    		$res = $this->recv($params[0]);
	    	return rtrim($res); 
	    }
	    return false;
    }

    private function __send(array $params, string $buf)
    {
    	$tokens = explode(' ', $buf);
    	if(isset($params[0])) {
			if ($this->ExecuteTask->solidSend($params[0], $tokens[1]) === false) {
				$this->setStatus(-994);	
				return false;
			}
			return true;
		}
		$this->send("END\n");
		$this->setStatus(-997);
		return false;
    }

    private function __fileInfo(array $params, string $buf)
    {
    	if (!empty($params[0])) {
			if ($this->ExecuteTask->solidInfoSend($params[0]) === false) {
				$this->setStatus(-991);
				return false;
			}
			return true;
		}
		$this->send("END\n");
		$this->setStatus(-992);
    }

    private function __recv(array $params, string $buf)
    {
    	if(!is_null(get('artifactId'))) {
    		$tokens = preg_split('/\s+/', $buf, 6);
    		array_shift($tokens);
    		array_push($tokens, get('artifactId'), get('bridge')['receive_patterns']);
    		$data = array_combine(array('name','type','siz','md5','path','artifact_id','patterns'), $tokens);
    		// break up a new solid for every file received.
			if ($this->ExecuteTask->solidReceive($data) === false) {
				$this->setStatus(-993);
				return false;
			}
			return true;
    	}
    	$this->setStatus(-996);
		return false;
    }
}
