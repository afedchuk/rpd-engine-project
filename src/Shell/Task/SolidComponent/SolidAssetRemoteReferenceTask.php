<?php
namespace App\Shell\Task\SolidComponent;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use App\Shell\Task\QueueTask;
use App\Shell\Task\SolidComponent\SolidAssetNullTask;

/**
 * SolidAssetNull shell task.
 */
class SolidAssetRemoteReferenceTask extends SolidAssetNullTask
{

    protected $version = 1;
    protected $message;

    public function initialize()
    {
        parent::initialize();
        $this->message = __("Remote reference Fetched (Completed)");
    }

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function capabilityMain(array $data)
    { 
        parent::capabilityMain($data);
    }
}
