<?php
namespace App\Shell\Helper;

use Cake\Console\Helper;

/**
 * Engine shell helper.
 */
class EngineHelper extends Helper
{
	public function output($args)
    {
       
    }

    public function grepEncryptedProperties(array &$args)
    {
    	if(!empty($args)) {
	    	foreach (preg_grep("/^!#!/", $args) as $key => $arg) {
					$args[$key] = "******";
			}
		}
    }

    public function encodeContent(string $uri, string $content = null, int $blockSize  = 65535) {
		$parts = parse_url($uri);
		switch($parts['scheme']) {
			case 'db':
			default:
				if ($content == null) {
					// return the block size for encodable data based on the storage field limit
					$content = ($blockSize- 3) * 3 / 4;
				} else {
					$content = base64_encode($content);
				}
			case 'raw':
				if ($content == null) {
					// return the block size for encodable data based on the storage field limit
					$content = $blockSize;
				}
				break;
		}
		return $content;
	}

    public function decodeContent(string $uri, string $content) 
	{
	    if(strlen($uri) > 0) {
	        $parts = parse_url($uri);
	        switch($parts['scheme']) {
	            case 'db':
	            default:
	                $content = base64_decode($content);
	            case 'raw':
	                break;
	        }
	    } else {
	        $content = base64_decode($content);
	    }
	    return $content;
	}

	/**
     * Compress the pathname into a new pathname and return the new name
     *
     * @param  string $path solid id.
     * @return the original name if something goes wrong unlink the original path if it works
     */
	public function compressFile(string $path, int $blockSize = 16384) 
	{
		$bytes = filesize($path);
		if (($in = fopen($path,"rb")) !== false) {
			$tmp = tempnam("/tmp","vlCmp");
			if (($out = gzopen($tmp,"wb")) !== false) {
				while (!feof($in)) {
					$buf = fread($in,$blockSize);
					$bytes -= strlen($buf);
					gzwrite($out,$buf);
				}
				gzclose($out);
				fclose($in);
				unlink($path);
				return($tmp);
			} else {
				unlink($tmp);
			}
		}
		return($path);
	}

	/**
     * Uncompress the pathname into a new pathname and return the new name
     *
     * @param  string $path solid id.
     * @return the original name if something goes wrong unlink the original path if it works
     */
	public function uncompressFile(string $path, int $size)
	{
		if (($in = gzopen($path,"rb")) !== false) {
	        $tmp = tempnam("/tmp","vlUcmp");
	        if (($out = fopen($tmp,"wb")) !== false) {
	            while (!gzeof($in)) {
	                $buf = gzread($in, $size);
	                fwrite($out, $buf);
	            }
	            fclose($out);
	            gzclose($in);
	            unlink($path);
	            return($tmp);
	        } else {
	            unlink($tmp);
	        }
	    }
	    return $path;
	}

	/**
     * Parse solid location
     *
     * @param  array $params solid params.
     * @param  array $parts parsed parts.
     * @param  bool $type type solid.
     * @return params with solid location modified
     */
	public function parseSolidLocation(array &$params, array &$parts = null, bool $type = false) 
	{
		$remote = isset($params['env']['VL_REMOTE_REFERENCE']) ? $params['env']['VL_REMOTE_REFERENCE'] : 0;
		$parts = parse_url($params['location']);

		if (isset($params['parsed_location_parts'])) {
			$parts = $params['parsed_location_parts'];
		}
			
		if($remote) {
			if(preg_match('/\${(.+)}/',$parts['path'], $path))  {
				if(isset($path[1]) && isset($params['env'][$path[1]]))
					$parts['path'] = str_replace('${'.$path[1].'}', $params['env'][$path[1]], $parts['path']);
			}
			$index = strpos($parts['path'], '/', 1); 
			$params['server'] = trim(substr($parts['path'], strpos($parts['path'], '/', 0) + 1, $index - 1));
			$parts['path'] = substr($parts['path'], (!$type ? $index : $index + 1), strlen($parts['path']) - $index);
		}
		$params['cmdArgv'] = array($params['artifact'], $parts['path']);
		return $params;
	}
}
