<?php
namespace App\Shell\Task;

use Cake\Console\Shell;
use Cake\Utility\Inflector;
use App\Shell\Task\Task\ExecuteAssetTask as Asset;
use App\Shell\Task\Task\ExecuteEmptyTask as None;

/**
 * InitSolid shell task.
 */
class InstanceFactoryTask extends QueueTask
{
    private static $modules = [
                        'asset_null', 
                        'asset_remote_reference',
                        'send_notification',
                    ];
    private static $obj;
    
    /**
     * build() method.
     *
     * @return bool|int Success or error code.
     */
    public static function build(array $params = [])
    {
        if(!in_array($params['module'], self::$modules)) {
            self::$obj = new Asset();
        } elseif(in_array($params['module'], self::$modules) || $params['params']['solid']['uri']['remote']) {
            self::$obj = new None();
        } else {
            throw new \Exception(Inflector::classify($data['module']). " component no found.", 1);
           
        }
        self::$obj->initialize();
        return self::$obj->main($params);
    }
}
