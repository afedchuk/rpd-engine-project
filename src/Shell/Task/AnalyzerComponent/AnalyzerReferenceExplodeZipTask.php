<?php
namespace App\Shell\Task\AnalyzerComponent;

use Cake\Console\Shell;
use App\Shell\Task\AnalyzerReferenceExplodeTask;

/**
 * AnalyzerReferenceExplodeZip shell task.
 */
class AnalyzerReferenceExplodeZipTask extends AnalyzerReferenceExplodeTask
{
	protected $desciption = 'Extract Zip';

	protected $moduleName = 'zip_exploder';

    /**
    * We're connected, the remote capability.
    **/
    public function capabilityMain(array $params, int $bridge) 
    {
    	parent::capabilityMain($params, $bridge);
    }


	/**
	* Write some content to a solid. this ALWAYS appends to the write copy of the archive
	**/
	protected function entrySolid(array $entry, array $solid)
    {
    	$sourceFile = $entry['content'];
		if (is_int(($z = zip_open($sourceFile)))) {
			$this->feedMe('Entry [name] could not be opened as a zip file - skipped', ['[name]' => $entry['name']], 0, 0, 'E');
			@unlink($sourceFile);
		}

		while(($zentry = zip_read($z)) !== false) {
			$zsize = zip_entry_filesize($zentry);
			zip_entry_open($z, $zentry);
			$zpath = zip_entry_name($zentry);
			$entry = ['name' => basename($entry['path']),'path' => $zpath, 
					  'content' => tempnam("/tmp","vlZE"),
					  'siz' => $zsize, 'md5' => md5_file($entry['content']), 'type' => 'F'
					 ];
			file_put_contents($entry['content'], zip_entry_read($zentry, $zsize));
			zip_entry_close($zentry);
			
			if (substr($zpath,-1) == "/") {
				$entry['type'] = 'D';
			}

			if (($rc = $this->addToSolid($entry, true, $solid)) === false) {
	            $this->engineOut('Unable to store content for [name] in database', ['[name]' => $entry['name']]);
	            $this->feedMe('Internal error saving instance data', [], 0, 0, 'E');
	            @unlink($sourceFile);
	            return false;
	        }
		}
        return true;
    }
}
