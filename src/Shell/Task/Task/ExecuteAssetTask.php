<?php
namespace App\Shell\Task\Task;

use Cake\Console\Shell;
use App\Shell\Task\Task\ExecuteTask; 
/**
 * InitSolid shell task.
 */
class ExecuteAssetTask extends ExecuteTask
{
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main(array $data = []) 
    {
    	$this->env['env'] = array_merge($this->env['env'], [
                'solid_id' => $data['params']['solidId'],
                'artifact_name' => $data['params']['solid']['name']
            ]
        );

        $models = ['Properties' => [], 'BridgeProperties' => ['bridge_id' => $data['params']['solid']->bridge_id],
                   'ZoneProperties' => ['zone_id' => get('zoneId')],'ArtifactProperties' => ['artifact_id' => $data['params']['solid']->artifact_id],
                   'UriProperties' => ['uri_id' => $data['params']['solid']->uri_id],
            	];

        foreach ($models as $key => $value) {
            $this->property($key, $value);
        }

    	parent::main($data);
    }
}
