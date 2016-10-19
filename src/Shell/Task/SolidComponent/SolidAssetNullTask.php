<?php
namespace App\Shell\Task\SolidComponent;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use App\Shell\Task\QueueTask;

/**
 * SolidAssetNull shell task.
 */
class SolidAssetNullTask extends QueueTask
{

    protected $version = 1;
    protected $message;

    public function initialize()
    {
        parent::initialize();
        $this->message = __('Null reference interface. No content will be stored.');
    }
    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function capabilityMain(array $data)
    { 
        try{
            $solid = $this->Solids->get($data['solidId'], ['conditions' => [ 'status' => 'Fetching', 'siz' => 0 ] ]);
            $solid->status = 'Ready';
            if($this->Solids->save($solid)) {
                $this->feedMe($this->message, [] ,0,0,'T', $data['solidId']);
                if( !$this->Solids->hasInstanceSolidsAnyAnalyzers($solid->artifact_id) ) { 
                    // if we have no analyzers set artifact->status, else - let analyzers do their job
                    $this->Artifacts->setArtifactAndDeliverableStatus($solid->artifact_id);
                }
                return true;
            }
            $this->engineAudit('Unable to save artifact properties for [[solid]] solid.', [
                                    '[solid]' => $params['solid_id'],
                                    'errors' =>  $solid->errors(),
                                    ], 'error');
            return false;  
         } catch(\Exception $e) {
            $this->engineOut('Internal error in [capability_name]. ' . $e->getMessage(), [
                                '[capability_name]' => end(explode('\\', self::class))
                         ]
            );
         }      
        return false;
        
    }
}
