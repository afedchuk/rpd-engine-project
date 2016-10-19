<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use App\Shell\Task\QueueTask;

/**
 * AnalyzerSendPathTranslator shell task.
 */
class AnalyzerSendPathTranslatorTask extends QueueTask
{
	protected $_defaultConfig = [
				'a_search_for'	 => 'Search For',
				'b_replace_with' => 'Replace With'
			];

	protected $desciption = 'Translate Deployment Path';

	protected $version = 4;

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, array $bridge = []) 
    {
    	foreach ($this->_defaultConfig as $key => $value) {
    		if(isset($params['props'][$key])) {
    			$this->_defaultConfig[$key] = $params['props'][$key];
    		} else {
    			$$this->engineAudit($value . ' not exists for [name] analyzer', ['[name]' => $params['analModule']], 'error');
    		}
    	}
    	if(($new = @preg_replace($this->_defaultConfig['a_search_for'], $this->_defaultConfig['b_replace_with'], $params['entry']['path'])) == null) {
    		$this->feedMe('Error during string translation replacing "[srch]" with "[repl]" on "[str]"', [
    					'[srch]' => $this->_defaultConfig['a_search_for'], '[repl]' => $this->_defaultConfig['b_replace_with'], '[str]' => $params['entry']['path']
    				], 0, 0, 'E');
    	} else {
    		$params['entry']['path'] = $new;
    		return $params['entry'];
    	}
    	return -1;
    }
}
