<?php
namespace App\Shell\Task\Task;

use Cake\Console\Shell;
use Cake\ORM\TableRegistry;
use Cake\Utility\Inflector;
use Cake\Filesystem\File;
use Cake\Utility\Text;
use App\Shell\Task\QueueTask;
use DBModel\Model\Entity\Solid;

/**
 * QueueExecTask shell task.
 */
class ExecuteTask extends QueueTask
{
    public $env = ['local' => [], 'env' => [], 'hidden_props' => []];

    public $tasks = ['Bridge'];

    public $remoteCapability;

    protected static $capability = null;

    public function initialize()
    {
        parent::initialize();
        $this->env['env'] = [
            'zone' =>  __('Undefined'),
            'engine_id' =>get('engineId'),
            'engine_host' => php_uname('n'),
        ];
        if(!is_null($zone = $this->Engines->getMyZone(get('engineId')))) {
            set('zoneId', $zone->id);
        }
    }
     

    /**
     * main() method.
     *
     * @return bool|int Success or error code.
     */
    public function main(array $data = []) 
    {
        $module = $data['prefix'] . Inflector::classify($data['module']);
        $this->engineAudit("Execution [cap] module", ['[cap]' => $data['module']]);
        try {
            set('solidId', $data['params']['solidId']);
            set('artifactId', $data['params']['artifactId']);

            self::$capability = $this->load($data['prefix'], $module);
            foreach (['initialize', 'preProcess', 'filterRemoteParams', 'wantRemoteCapability'] as $key => $value) {
                if (method_exists(self::$capability, $value)){
                    $this->engineAudit("Running $value method of [cap] module", ['[cap]' =>  $module]);
                    self::$capability->$value($data['params']);
                }
            }
            if(isset($data['params']['env'])) {
			  $this->env['env'] = array_replace($this->env['env'], $data['params']['env']);
            }
            $this->initializeBridge($data['params'], self::$capability->remoteCapability);

            // get platform specific bridge properties
            $this->property('PlatformProperties',  ['platform_id' => $this->Bridge->_bridge['remote_platform']]);
            
            $this->propertyOut($this->env, true);
            $this->env['env']['BRIDGE_VERSION'] = $this->Bridge->_bridge['proto'];
            $this->Bridge->predefineVariable($this->env['env']);
            
            // // execute a command. this loads the remote capability module
            // // and passes the connection to it
            if(isset($data['params']['cmdArgv']) && !empty($data['params']['cmdArgv'])) {
                if($this->Bridge->send("_run  ". self::$capability->remoteCapability. " ".count($data['params']['cmdArgv'])."\n")) {
                    foreach($data['params']['cmdArgv'] as &$value) {
                        $value = expandText($this->env['local'], $value);
                    }
                    foreach ($data['params']['cmdArgv'] as $arg) {
                        $this->Bridge->send($arg . "\n");
                    }
                    $this->feedMe("[".self::$capability->remoteCapability."] ". implode(" ", $data['params']['cmdArgv']), $data['params']['cmdArgv'], $this->Bridge->_bridge['id'], 0, 'C', get('solidId'));
                }   
            }
            if(method_exists(self::$capability,'capabilityMain')){
                // we're connected, the remote capability (if any) is loaded. let 'er rip!
                $this->engineAudit("Running capabilityMain method of [cap] module", ['[cap]' =>  $module]);
                self::$capability->capabilityMain($data['params']);
            }
            // write flush any solids we may have open
            $this->flushSolidCache();
            $this->Bridge->disconnect();
            remove('artifactId');
        } catch(\Exception $e) {
            remove('artifactId');
            $this->engineOut('Unable to install local capability component [capability_name]'. $e->getMessage(), [
                '[capability_name]' => $module]);
            return false;
        }
        return ['local' => 0, 'remote' => 0];

    }

        /**
    * Load capability component
    * @param string $prefix type of component
    * @param string $module component name
    **/
    protected function load(string $prefix, string $module) 
    {
        $component = 'App\Shell\Task\\'.$prefix.'Component\\'.$module.'Task';
        if(class_exists($component)) {
            return new $component();
        } else {
            throw new Exception("Capability $module not found", 1);
        }
       
    }

    private function initializeBridge(array $data, string $capabilityRemote = null)
    {
        // create the connection
        if(isset($data['hostname']) && $data['hostname']) {
            if (!$this->Bridge->connect($data['hostname'])){
                $this->engineOut('Unable to connect to remote bridge: [msg]',array('[msg]' => get('bridge')['errstring']));
                $this->feedMe('Unable to connect to host [' . $data['hostname'] . ']: ' . get('bridge')['errstring'], [], 0, 0, 'E', $data['solidId']);
                return ['remote' => 1, 'local' => 0];
            }
            // send bridge mode if needed
            if(!get('bridge')['despatcher'] && $this->getSysPref('legacy_bridge_mode','n') != 'y') {
                $this->Bridge->send("_bridge_mode\n");
            }
            // if the bridge is busy, we'll try again later.
            // connect can succeeed, but still be not connected to indicate a busy bridge
            if (get('bridge')['connected']){
                if (!empty($capabilityRemote)) {
                    if($this->Bridge->send("_ping $capabilityRemote\n")) {
                        //$this->Bridge->getLine();
                        // protocol returns the lib version or < 0
                        $this->Bridge->getBridgeResponseBlock();
                        if(($status = get('bridge')['status']) == -1) {
                            // if this is a status request, don't fail the deployment just yet, just move on.
                            // they will need to update dispatchers with those that have status module.
                            $this->engineOut('Remote capability [capability_name] not available for platform [platform]', [
                                        '[platform]' => get('bridge')['platform'],
                                        '[capability_name]' => $capabilityRemote
                                    ]
                            );
                            $this->feedMe('Remote capability [capability_name] not available for platform [platform]', [
                                    '[platform]' =>get('bridge')['platform'],
                                    '[capability_name]' => $capabilityRemote
                                ], get('bridge')['id'], 0, 'E', $data['solidId']);

                            if($capabilityRemote == 'status')  {
                                $this->engineOut('Update dispatcher with latest version that contains status module to utilize remote target status functionality.', []);
                                $this->feedMe('Update dispatcher with latest version that contains status module to utilize remote target status functionality.', [], $this->Bridge->_bridge['id'], 0, 'E', $data['solidId']);
                                return ['remote' => 0, 'local' => 0];
                            }
                            return ['remote' => 7, 'local' => 0];
                        }
                        $this->env['env'] = array_merge($this->Bridge->_bridge['env'], $this->env['env'], $this->env['local'], $this->env['hidden_props']);
                        set('bridge', $this->Bridge->_bridge);
                    }
                }
            }

        }
        return $this->Bridge->_bridge;
    }

    /**
     * Send solid info reference
     *
     * @param int $artifactId artifact id
     * @return string $name solid name
     */
    public function solidInfoSend(int $artifactId, string $name) 
    {
        $solidInfo = $this->Solids->find()->where(['artifact_id' => $artifactId, 'name' => $name])->contain('ReferenceTocs')->first();
        if($solidInfo !== null) {
            if(!isset($solidInfo->reference_toc)) {
                return false;
            }
            if($this->Bridge->send("INFO " . $solidInfo->reference_toc['typ'] . " " . $solidInfo->reference_toc['siz'] . " " . $solidInfo->reference_toc['md5'] . " " . $solidInfo->reference_tocs['path'] . "\n")) {
                $this->Bridge->getBridgeResponseBlock();
            }
        }
        return true;
    }

     /**
     * recv 'name' artifact content to the store. this reads raw data from the bridge
     * and saves it in the artifact's solids. each 'name' is itself an archive and may have multiple entries.
     *
     * @param int $artifactId artifact id
     * @return string $name solid name
     */
    public function solidReceive(array $params) 
    {
        // do we want to skip the send of this entry based on existing data?
        // check to see if it exists, and store info on getting to it if it does.
        $existingData = $this->Tocs->locateExistingFile($params, $this->getSysPref('skip_transfer_threshold', 0));

        // get the solid record, if it exists (it should unless this is a dynamic process based create)
        $solid = $this->Solids->find()
            ->where(['artifact_id' => $params['artifact_id'], 'name' => $params['name']])
            ->first();

        if(is_null($solid)) {
            $this->engineAudit('solidReceive: Unable to find [[solid]] solid.', [
                                    '[solid]' => $params['name'],
                                ], 'error');
            return false;
        }

        $solidId = $solid !== null && isset($solid->id) ? $solid->id : 0;
        $params['name'] = str_replace(' ','_',$params['name']);
        switch ($params['type']) {
            case 'D':
                $this->Bridge->send("OK\n");
                $this->feedMe(sprintf("%s <-- %s", $params['name'], $params['path']), [], get('bridge')['id'], 0, 'T', $solidId);
                return true;
                break;
            default:
                $params['content'] = '';
                if (empty($existingData)) { 
                    // we want the file contents
                    $this->Bridge->send("ACK\n");
                    $showpct = $this->getSysPref('show_transfer_percentage','n') == 'y';
                    $params['content'] = tempnam("/tmp","vlRecv"); $segment = 0;
                    if(($file = fopen($params['content'],"wb"))) {
                        $pctId = 0; $size = $bytes = $params['siz'];
                        $blockSize = $this->getSysPref('transfer_block_size', 16384);
                        $boundry = ($size < $blockSize * 10) ?  $size + 1 : intval($size * 0.1);
                        while ($bytes > 0) {
                            $buf = $this->Bridge->recv(($bytes > $blockSize) ? $blockSize : $bytes);
                            $bytes -= strlen($buf); $segment += strlen($buf);
                            fwrite($file, $buf);
                            fflush($file);
                            if ($segment >= $boundry) {
                                $segment = 0; $pct = intval((($size - $bytes) / $size) * 100);
                                if ($showpct) {
                                    $this->feedMe(sprintf("Read %s -- %d%%",$params['path'], $pct), [], get('bridge')['id'], 0, 'T', $solidId);
                                }
                            }
                        }
                    }
                    fclose($file);
                    if($size > 0 && $params['md5'] != md5_file($params['content'])) {
                        $this->engineOut('solidReceive: Data corruption receiving artifact [solid_name]',['[solid_name]' => $params['name']]);
                        $this->feedMe('Data corruption receiving instance data: ' . $params['name'], [], get('bridge')['id'], 0, 'E', $solidId);
                        @unlink($params['content']);
                        $this->Bridge->send("FAIL\n");
                        return false;
                    }
                    $this->feedMe(sprintf("%s <-- %s (%ld)", $params['name'], $params['path'], $params['siz']), [], get('bridge')['id'], 0, 'T', $solidId);
                } else {
                    $this->Bridge->send("NAK\n");
                    $master = array_filter(array_merge($solid->toArray(), [
                            'reference_id' => $existingData->solid->id,
                            'status' => 'Ready', 
                            'gmt_fetched' => $existingData->solid->gmt_fetched,
                            'stamp' => $existingData->solid->stamp,
                            'module_name' => 'pointer', 
                            'analyz' => 'y',
                            'toc' => $existingData->solid->toc,
                            'md5' => $existingData->solid->md5,
                            'siz' => $existingData->solid->siz
                        ]
                    ), create_function('$value', 'return $value !== null;'));
                    $this->Solids->removeBehavior('DefaultFields');
                    if(!$this->Solids->updateAll($master, ['id' => $solid->id])) {
                        $this->engineOut('solidReceive: Update solid [solid_name] failed', [
                                '[solid_name]' => $master['name']
                            ]
                        );
                    }
                    $solid = $this->Solids->get($solid->id);
                    $this->feedMe(sprintf("%s <-- %s <-- %s(%s)", $params['name'], $existingData->path, $existingData->artifact_name, $existingData->siz), [], get('bridge')['id'], 0, 'T', $solidId);
                }
                break;
        }

        if(!$solid->reference_id) {
            $master = array_filter($solid->toArray(), create_function('$value', 'return $value !== null;')); 
            unset($master['id']);
            $entity = $this->Solids->newEntity(array_merge($master, ['artifact_id' => 0, 'gmt_fetched' => 0]));
            $this->Solids->removeBehavior('DefaultFields');
            if(!$this->Solids->save($entity)) {
                $this->engineAudit('solidReceive: Unable to save [[solid]] solid.', [
                            '[solid]' => $params['name'],
                            'errors' => $entity->errors(),
                        ], 'error');
            } else {
                $masterId = $this->Solids->getInsertID();
                $this->Solids->removeBehavior('DefaultFields');
                $this->Solids->updateAll(['reference_id' => $masterId], ['id' => $solid->id]);
            }
            $solidMaster = $this->Solids->get($masterId, ['contain' => ['Uris']]);
        } else {
            $masterId = $solid->reference_id;
            $solidMaster = $this->Solids->find()
                ->where(['Solids.id' => $masterId])
                ->contain(['Uris'])
                ->first();

        }

        if (($result = $this->addToSolid($params, true, $solidMaster->toArray())) === false) {
            $this->Bridge->send("FAIL\n");
            $this->engineOut('solidReceive: addToSolid [solid_name] failed', [
                    '[solid_name]' => $params['name']
                ]
            );
            $this->feedMe('Internal error saving instance data', [], get('bridge')['id'], 0, 'E', $solidId);
            return false;
        }
        $this->Bridge->send("OK\n");
        return true;
    }
    
    /**
    * Return the physical content in a solid and will fetch it from the URI if needed
    *
    * @param int $id solid id
    * @param array $solid solid info
    * @param bool $skipOpen skip open solid if needed
    * @return bool.
    **/
    public function getSolidContent(int $id, array $solid, bool $skipOpen = false)
    {
        if(!empty($solid)) {
            if ($solid['gmt_fetched'] == 0) {
                if($this->getLock($solid['name'], $this->getSysPref('lock_timeout', 300))) {
                    if(!($result = $this->fetchSolid($id))) {
                        $this->engineOut('getSolidContent: fetchSolid [solid_name] [artifact_id] failed', [
                            '[solid_name]' => $solid['name'], '[artifact_id]' => $solid['artifact_id']
                            ]
                        );
                    }
                    $this->putLock($solid['name']);
                    if(!$result) {
                        return false;
                    }
                }
            }
            if (!$skipOpen) {
                if($this->openSolid($solid['name'], $solid['artifact_id'], $solid['id'], $solid) === false) {
                    $this->engineOut('getSolidContent: Open solid [solid_name] [artifact_id] failed', [
                                '[solid_name]' => $solid['name'], '[artifact_id]' => $solid['artifact_id']
                            ]
                    );
                    return false;
                }
            }
        }
        return true;
    }

    protected function getSolidEntry(string $solidName, int $artifactId, $solid = null)
    {
        // auto-open the solid
        if (($entry = $this->openSolid($solidName, $artifactId, (isset($solid['id']) ? $solid['id'] : 0), (!is_null($solid) ? $solid : false))) === false) {
            $this->engineOut('Open solid failed on [solid_name] [artifact_id]', [
                '[solid_name]' => $solid['name'], '[artifact_id]' => $artifactId]);
            return false;
        }

        // check if we have remote refence functionality
        if(isset($solid['uri']['remote']) && $solid['uri']['remote']) {
            $entry['archive'] = $solid['remote_location'];
        }

        // open the archive and position the file pointer
        $fileArchive = fopen($entry['archive'],'rb');
        fseek($fileArchive,$entry['offset'],SEEK_SET);
        if (feof($fileArchive)) {
            fclose($fileArchive);
            return false;
        }

        // we got an entry, decode the header
        // read the descriptor line if present
        $header = rtrim(fgets($fileArchive));
        if(strlen($header) == 0 && feof($fileArchive)) {
            fclose($fileArchive);
            return false;
        } else {
            $header = preg_split('/ /',$header,4);
            if (count($header) < 4) {
                fclose($fileArchive);
                return false;
            }
        }
        $entry['offset'] = ftell($fileArchive);

        // set up the entry array
        $result = array(
            'name' => $solidName,
            'artifact_id' => $artifactId,
            'type' => $header[0],
            'siz' => $header[1],
            'md5'  => $header[2],
            'path' => rtrim($header[3]),
            'content' => tempnam("/tmp","vlEntry"),
            'archive' => $entry['archive']
        );

        // if there's content, read it to a tmp file.
        if ($result['type'] == 'F' && $result['siz'] > 0) {
            $bytes = $result['siz'];
            $blockSize = $this->getSysPref('transfer_block_size',16384);
            $outf = fopen($result['content'],"wb");
            while ($bytes && !feof($fileArchive)) {
                $buf = fread($fileArchive,($bytes > $blockSize) ? $blockSize : $bytes);
                $bytes -= strlen($buf);
                fwrite($outf,$buf);
            }
            fclose($outf);
        }

        $entry['offset'] = ftell($fileArchive);
        fclose($fileArchive);
        return $result;
    }

    /**
    * Open a locally stored solid for future reading. solid[blob] is a compressed archive file.
    * We'll push the blob out to a tmp file so the archive functions can act on it. when all
    * is done flushSolidCache() will take care of putting things back into the blob.
    *
    * @param string $name solid name
    * @param int $artifactId solid artifact id
    * @param int $solidId solid id
    * @param array $solid solid info
    * @return array return solid file info.
    **/
    private function openSolid(string $name, int $artifactId, int $solidId, $solid = null)
    {   
        if (get('solidCache') !== null && array_key_exists($name, get('solidCache'))) {
            return true;    
        } else {
            $entry = ['name' => $name, 'needwrite' => false,
                      'artifact_id' => $artifactId, 'solid_id' => $solidId,
                      'offset' => 0, 'archive' => tempnam("/tmp","vlRArch"), 'write_archive' => tempnam("/tmp","vlWArch"),'toc' => []];  
            if(($entry['archive'] = $this->retrieveSolidData($entry['archive'], $solid)) !== false) {
                // scan the archive to build the list of entries in the archive
                if (($f = fopen($entry['archive'],"r")) !== false) { 
                    while (!feof($f)) {
                        if (($buf = rtrim(fgets($f))) !== false) {
                            $header = preg_split('/ /',$buf,4);
                            if (count($header) == 4) {
                                $path = rtrim($header[3]);
                                $entry['toc'][$path] = array('typ' => $header[0],'siz' => $header[1],'md5' => $header[2],'offset' => ftell($f));
                                if ($header[1] > 0) {
                                    fseek($f,$header[1],SEEK_CUR);
                                }
                            }
                        }
                    }
                    fclose($f);
                }
            } else {
                $this->engineOut('openSolid: Retrieve solid content from [solid_name] with [[artifact_id]] artifact failed', [
                                '[solid_name]' => $solid['name'], '[artifact_id]' => $solid['artifact_id']
                            ]
                    );
            }
            return set('solidCache', [$name => $entry]);
        }
        return false;
    }

    /**
     * Retrieve solid content from db or using custom components
     * @param string $path temporary file path
     * @param array $solid solid information
     * @return string $path return the file.
    */
    protected function retrieveSolidData(string $path, array $solid) 
    {
        $parts = parse_url($solid['store_uri']);
        switch ($parts['scheme']) {
            case 'db':
                return $this->recvStoreData($path, $solid);
                break;
            default:
                $parts['scheme'] = 'store_' . $parts['scheme'];
                try {
                    $capability = $this->Tasks->load($parts['scheme']);
                }  catch(\Exception $e) {
                    $this->engineOut('Unable to install local capability component [capability_name]', [
                        '[capability_name]' => $parts['scheme']]);
                    return false;
                }
                break;
        }
        return $path;
    }

    /**
     * Built-in db solid storage
     * @param string $path temporary file path
     * @param array $solid solid information
     * @return string $path return the new file.
    */
    protected function recvStoreData(string $path, array $solid)
    {
        if(!$solid['uri']['remote']) {
            try {
                $chunks = $this->Blobs->find('list', ['keyField' => 'id','valueField' => 'id'])->where(['solid_id' => $solid['id']])->toArray();
                if(!empty($chunks)) {
                    sort($chunks,SORT_NUMERIC);
                    // write the chunks out to the file
                    $archiveFile = fopen($path,'wb');
                    for ($i = 0 ; $i < count($chunks) ; $i++) {
                        $blob = $this->Blobs->get($chunks[$i]);
                        if(!is_null($blob['content'])) {
                            fwrite($archiveFile, $this->helper('Engine')->decodeContent($solid['store_uri'], $blob['content']));
                        } else {
                            $this->engineOut('recvStoreData: Solid storage is empty for [solid_name]', [
                                        '[solid_name]' => $solid['name']
                                    ]
                             );
                            return false;
                        }
                    }
                    fclose($archiveFile);
                    $path = $this->helper('Engine')->uncompressFile($path, $this->getSysPref('transfer_block_size', 16384));
                } 
            } catch(\Exception $e) {
                $this->engineAudit('Internal error of built-in db solid storage for [[id]] solid. '. $e->getMessage(), ['[id]' => $solid['id']], 'error');
                return false;
            }
        }
        return $path;
    }

    protected function addToSolid(array $params, bool $isNewEntry = true, array $solid)
    {
        if ($this->openSolid($params['name'], $params['artifact_id'], (isset($solid['id']) ? $solid['id'] : 0), (!is_null($solid) ? $solid : false)) === false) {
            $this->engineOut('Open solid failed on [solid_name] [artifact_id]', [
                '[solid_name]' =>$params['name'], '[artifact_id]' => $params['artifact_id']]);
            return false;
        }
        $cache = get('solidCache');
        $fileArchive = fopen($cache[$params['name']]['write_archive'],"ab");
        if(in_array($params['type'], ['D'])) {
            $header = sprintf("D 0 0 %s\n", $params['path']);
        } else {
            $header = sprintf("F %u %s %s\n",$params['siz'],$params['md5'],$params['path']);
        }
        fwrite($fileArchive, $header);
        $cache[$params['name']]['toc'][$params['path']] = [
            'siz' => $params['siz'],
            'md5' => $params['md5'],
            'typ' => $params['type'],
            'offset' => 0
        ];
        if ($params['siz']) {
            $bytes = $params['siz'];
            $blockSize = $this->getSysPref('transfer_block_size',16384);
            if($params['content']) {
                if(($inf = fopen($params['content'],"rb")) !== false) {
                    while ($bytes && !feof($inf)) {
                        $buf = fread($inf,($bytes > $blockSize) ? $blockSize : $bytes);
                        $bytes -= strlen($buf);
                        fwrite($fileArchive,$buf);
                        fflush($fileArchive);
                    }
                    fclose($inf);
                } else {
                    $this->engineOut('addToSolid: Opening file [solid_name] failed', [
                                    '[file]' => $params['name']
                            ], 'error'
                     );
                    return false;
                }
            }
        }
        $cache[$params['name']]['needwrite'] = $isNewEntry;
        set('solidCache', $cache);
        fclose($fileArchive);
        @unlink($params['content']);
        return true;
    }

    /**
     * During processing things may wind up reading/writing solids. this should be called
     * now and then or when done to make sure all has been written out and any tmp files have
     * been cleaned up (tmp files are created on reads as well as writes)
     * @return void.
    */
    protected function flushSolidCache()
    { 
        if(!is_null(get('solidCache'))) {
            $includeDirs = strtolower($this->getSysPref('solid_toc_has_dirs','n'));
            foreach (get('solidCache') as $name => $entry) {
                if(in_array($entry['needwrite'], [true])) {
                    $file = new File($entry['write_archive'], false);
                    if(($info = $file->info()['filesize'])) {
                        $this->Tocs->deleteAll(['solid_id' => $entry['solid_id']]);
                        $data = ['siz' => filesize($entry['write_archive']), 'md5' => md5_file($entry['write_archive']),
                                'store_uri' => $this->getSysPref('artifact_store_uri', 'db://base64'), 'gmt_fetched' => time(),
                                'remote_location' => $entry['write_archive'], 'toc' => ''
                            ];
                            
                        // scan the archive to build the full toc entries
                        $nitems = count($entry['toc']);
                        if (($f = fopen($entry['write_archive'],"r")) !== false) {
                            while (!feof($f)) {
                                if (($buf = rtrim(fgets($f))) !== false) {
                                    $header = explode(' ', $buf, 4);
                                    if (count($header) == 4) {
                                        if ($header[0] == 'F' || ($header[0] == 'D' && $includeDirs == 'y')) {
                                            $data['toc'] .= trim($header[3]) . "\n";
                                        }
                                        if(($toc = $this->Tocs->flushTocCreate($entry, $header, ftell($f))) !== true) {
                                            $this->engineOut('flushSolidCache: Saving toc entry data for solid [[solid]] failed', [
                                                    '[solid]' => $entry['solid_id'],
                                                    'errors' => $toc
                                                ], 'error'
                                            );
                                        }
                                        
                                        if ($header[1] > 0) {
                                            fseek($f,$header[1],SEEK_CUR);
                                        }
                                    }
                                }
                            }
                            fclose($f);
                        }
                        $this->Solids->removeBehavior('DefaultFields');
                        $this->Solids->updateAll($data, ['id' => $entry['solid_id']]);
                        $this->Solids->updateAll($data, [
                                'reference_id' => $entry['solid_id']
                            ]
                        );
                        $solid = $this->Solids->get($entry['solid_id'], ['contain' => ['Uris']]);
                        $this->storeSolidData($entry['write_archive'],$solid);
                    }
                }
                @unlink($entry['archive']);
            }
            remove('solidCache');
        }
    }


    public function storeSolidData(string $path, Solid $solid) 
    {
        if(!$solid->uri->remote) {
            $parts = parse_url($solid->store_uri);
            if ($parts['scheme'] == 'db') {
                return($this->sendStoreData($path, $solid));
            }
        }
    }


    private function sendStoreData(string $path, Solid $solid) 
    {
        if($this->Blobs->deleteAll(['solid_id' => $solid->id])) {
            $this->engineOut('sendStoreData: Old storage for [[solid]] solid removed', [
                            '[solid]' => $solid->id
                        ], 'info'
            );
        }
        $path = $this->helper('Engine')->compressFile($path, $this->getSysPref('transfer_block_size', 16384));
        $blockSize = $this->helper('Engine')->encodeContent($solid->store_uri, null, $this->getSysPref('store_block_size', 65535));
        $bytes = filesize($path); $half = $bytes / 2;
        if(($f = fopen($path,'rb')) !== false) {
            while (!feof($f)) {
                $buf = fread($f, $blockSize);
                $bytes -= strlen($buf);
                $entity = $this->Blobs->newEntity([
                                'solid_id' => $solid->id,
                                'content' => $this->helper('Engine')->encodeContent($solid->store_uri, $buf)
                            ]
                );
                if(!$this->Blobs->save($entity)) {
                    $this->engineOut('sendStoreData: Built-in db solid storage [solid_name] failed', [
                                    '[solid_name]' => $solid->name
                                ]
                    );
                }
            }
            fclose($f);
            unlink($path);
        } else {
            $this->engineOut('sendStoreData: Reading [file] file path for built-in db solid storage failed', [
                            '[file]' => $path
                        ], 'error'
            );
            return false;
        }
        return true;
    }

    private function fetchSolid(int $id)
    {

    }

    ////////////////////////////////////////////////////////////////////////////////
    // send 'name' artifact contents to the bridge
    // send END when all done sending zero or more entries
    // abort the connection if a FAIL is received
    //
    function solidSend($bridge, $name) {
        // strip off any pattern reference that might be on the solid name.
        // this will be the handler pattern that triggered the send of this solid.
        // default to sending the entire solid.
        $artifactId = get('artifactId');
        // // try and load the solid from the 'existing solids' in the database. if it's not there, see if it'll auto-create from the script store
        $should_continue = true;
        switch($this->_loadScriptSolid($artifactId, $name)) {
                case -1:
                    $this->Bridge->send("END\n");
                    return(false);
                    break;
                case 0:
                    $should_continue = false;
                    break;
                case 1:
                    $should_continue = true;
                    break;
            }
            $this->flushSolidCache();
        // we may have called _loadScriptSolid which may have sent the script without creating a solid. that means the send is done
        if (!$should_continue) {
            $this->Bridge->send("END\n");
            return(true);
        }

        $count = 0;
        return(true);
    }

    ////////////////////////////////////////////////////////////////////////////////
    // someone is requesting a solid by name that doesn't exist. see if it exists in
    // the script database and auto-create a solid if it does
    //
    function _loadScriptSolid($artifactId, $name) {
        $bridge = get('bridge');
        $artifactId = get('artifactId');
        $solidId = get('solidId');
        $script = $this->Scripts->getScriptForBridge($name, $bridge['id']);
        $this->feedMe("Identified action [name] in Generic pack for any platform",['[name]' => $script->name, '[plaftorm]' => $script['platform']['name']],$bridge['id'],0,'T', $solidId);
        if ($script !== false) {
            if (($artifactId != 0) && strtolower($this->getSysPref('store_actions_in_instance','n')) == 'y') {
                $this->feedMe("Adding action $name to instance",[],$bridge['id'],0,'T', $solidId);
                $this->_solidReceiveFromString($artifactId, $name, $script['Script']['content']);
            }
            else {
                if ($this->_scriptSend($bridge,$script) === false){
                    return(-1);
                }
                return(0);
            }
        }
        return(1);
    }

    


    ////////////////////////////////////////////////////////////////////////////////
    // send 'name' script contents to the bridge this is called if we're not storing
    // the scripts in the artifact
    //
    function _scriptSend($bridge,$script) {
        $size = strlen($script['content']);
        $md5  = md5($script['content']);
        $path = $script['name'];
        $this->feedMe("script $path ($size)",array(),$bridge['id'],0,'T', get('solidId'));
        if ($this->Bridge->send("DATA F $size $md5 " . $path . "\n") === false) {
            $this->feedMe("Write error sending data to remote - bridge connection has gone away",[],$bridge['id'], 0, 'E', get('solidId'));
            return(false);
        }

        if (empty($entry) || empty($entry['path']))
            $entry['path'] = '?';
        $continue = $this->sendSharedDriveContinue($bridge); // send another getresponse to proceed with CONTINUE signal
        if ($continue) {
            $bytes = $this->getSysPref('transfer_block_size',16384);
            
            while (strlen($script['content']) > 0) {
                
                if ($bytes > strlen($script['content']))
                    $bytes = strlen($script['content']);

                $buf = substr($script['content'],0,$bytes);
                if ($this->Bridge->send($buf,$bytes) === false) {
                    $this->feedMe("Write error sending data to remote - bridge connection has gone away",[],$bridge['id'],0,'E',  get('solidId'));
                    return(false);
                }
                $script['content'] = substr($script['Script']['content'],$bytes);
            }
        }

        if (($buf = $this->Bridge->getBridgeResponseBlock($bridge,0)) == 'FAIL') {
            $buf = $this->Bridge->getBridgeResponseBlock($bridge,0);    // slurp the reason. it'll be an ERROR block that's handled.
            return(false);
        }
        else {
            if ($buf == 'OK_WITH_WARNING') {
                $warn = $this->Bridge->getBridgeResponseBlock($bridge,0);
                //$this->Oddit->putAudit($this->{'eventId'},'_scriptSend: warn response when sending file [name]: [message]',array('[name]' => $entry['path'],'[message]' => $buf));
            } elseif ($buf != 'OK') {
                if ($buf == 'SHARED_DRIVE') {
                    $this->feedMe("Sending " . $path . " from the shared drive.",[],$bridge['id'],0,'P',  get('solidId'));
                    $warn = $this->Bridge->getBridgeResponseBlock($bridge,0);
                    if ($warn == 'OK') {
                        return(true);
                    }
                }
                //$this->Oddit->putAudit($this->{'eventId'},'_scriptSend: odd response when sending file [name]: [message]',array('[name]' => $entry['path'],'[message]' => $buf));
                return(false);
            }
        }
        return(true);
    }

    ////////////////////////////////////////////////////////////////////////////////
    // Send another message to skip CONTINUE for shared drive
    // 
    function sendSharedDriveContinue($bridge) 
    {
        $continue = true;
        $buf = $this->Bridge->getBridgeResponseBlock($bridge,0);
        // The following responces can be obtained:
        //  - SHARED_DRIVE          : no need to receive data, the file will be copied from the shared drive
        //  - CONTINUE_SHARED_DRIVE : copying process will try to use the shared drive
        //  - CONTINUE_WITH_WARNING : copying process will try to go on, the warning will be shown
        //  - CONTINUE              : no matter whether the shared drive is used, the data should be obtained from the engine
        //  - SHARED_DRIVE_WRONG    : the shared drive is wrong, the data should be obtained from the engine
        if ($buf == 'SHARED_DRIVE') {
            $continue = false;
        } elseif ($buf == 'CONTINUE_SHARED_DRIVE') {
            $this->feedMe("Copying " . $path . " to the shared drive.",array(),$bridge->getId(),0,'P');
        } elseif ($buf == 'CONTINUE_WITH_WARNING') {
            $warn = $this->Bridge->getBridgeResponseBlock($bridge,0);
            //$this->Oddit->putAudit($this->{'eventId'},'_scriptSend: warn response when sending file [name]: [message]',array('[name]' => $entry['path'],'[message]' => $warn));
            $this->feedMe("Warning received: " . $warn,array(),$bridge->getId(),0,'E');
        } elseif ($buf == 'SHARED_DRIVE_WRONG') {
            $warn = 'Path to shared drive is incorrect. File will be sent directly to target.';
            //$this->Oddit->putAudit($this->{'eventId'},'_scriptSend: warn response when sending file [name]: [message]',array('[name]' => $entry['path'],'[message]' => $warn));
            $this->feedMe($warn,array(),$bridge['id'],0,'E');
        }
        return $continue;
    }
   
}
