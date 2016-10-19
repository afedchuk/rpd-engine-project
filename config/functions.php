<?php 
use Cake\I18n\I18n;

/**
 * Function for expanding text
 *
 * @param string $env property value encrypted.
 * @param string $text property value encrypted.
 * @param array $seen property value encrypted.
 * @return string expanded text
 */

function expandText($env,$text, array $seen = array())
{
        // env here represents an associative array, n=>v
        $closeMode = '';
        $pieces = preg_split('/(\$[{[(])(.*?)([})\]])/',$text,0, PREG_SPLIT_NO_EMPTY | PREG_SPLIT_DELIM_CAPTURE);

        $reprocess = true;
        $processed = 0;
        $returnType = true;
        $text = "";
        foreach($pieces as $piece) {
            switch($piece) {
                case '${':
                    $closeMode='}';
                    break;
                case '$(':
                    $closeMode=')';
                    break;
                case '$[':
                    $closeMode=']';
                    break;
                case '}':
                case ')':
                case ']':
                    $closeMode='';
                    break;
                default:
                    if($closeMode) {
                        $processed++;
                        if(!in_array($piece,$seen))
                            $seen[] = $piece;
                        else
                            $reprocess = false;
                    }
                    if($closeMode == '}') {
                        // Strict replace.
                        if(array_key_exists($piece, $env)) {
                            if (!is_null($env[$piece])) {
                                $piece = $env[$piece];
                            } else {
                                $piece = '';
                            }
                        } else {
                            $returnType = false;
                        }
                    }
                    if($closeMode == ')') {
                        if(isset($env[$piece])) 
                            $piece = $env[$piece];
                        else
                            $piece = '';
                    }
                    if($closeMode == ']') {
                        if(isset($env[$piece])) 
                            $piece = $env[$piece];
                    }
                    $text .= $piece;
            }
        }
        if($processed < 1) {
            $reprocess = false;
        }
        if($reprocess)
            return(expandText($env,$text,$seen));
        return($text);

}

if (!function_exists('__')) {
    function __($singular, $args = null)
    {
        if (!$singular) {
            return null;
        }

        $arguments = func_num_args() === 2 ? (array)$args : array_slice(func_get_args(), 1);
        foreach ($arguments as $key => $value) {
            if(strpos($value, '!#!') !== false) {
                $arguments[$key] = str_repeat('*', 5);
            }
        }
        
        return I18n::translator()->translate($singular, $arguments);
    }    
}

/**
 * Function allows encrypt our properties.
 *
 * @param string $value property value.
 * @return string property encoded
 */
function encodeSecretProperty($value) 
{
    $source = '! #$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}~';
    $dest   = 'f^jAE]okIOzU[2&q1{3`h5w_794p@6s8?BgP>dFV=m D<TcS%Ze|r:lGK/uCy.Jx)HiQ!#$~(;Lt-R}Ma,NvW+Ynb*0X';

    // don't re-encrypt
    if (strncmp($value,"!#!",3) == 0) {
        return($value);
    }

    // find a character that's not in the supplied value
    $delimiter = '';
    for ($i = 0 ; $delimiter == '' && $i < strlen($source); $i++) {
        if (strpos($value,substr($source,$i,1)) === false) {
            $delimiter = substr($dest,$i,1);
        }
    }

    // encode the value
    $result = '!#!' . $delimiter;
    for ($i = 0; $i < strlen($value); $i++) {
        $xchar = substr($value,$i,1);
        $x = strpos($source,$xchar);
        if ($x !== false) {
            if ($x > strlen($dest)) {
                return($value);
            }
            $result .= substr($dest, $x, 1);
        } else { // if characters are not in source we will not encode them
            $result .= $xchar;
        }
    }

    // add the delimiter again to terminate the actual value string
    $result .= $delimiter;

    // pad it out
    while (strlen($result) < 32) {
        $result .= substr($dest,rand(0,strlen($dest)-1),1);
    }
    return($result);
}


/**
 * Function allows descrypt our properties.
 *
 * @param string $value property value encrypted.
 * @return string property decoded
 */
function decodeSecretProperty($value) 
{
    $source = '! #$%&()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[]^_`abcdefghijklmnopqrstuvwxyz{|}~';
    $dest   = 'f^jAE]okIOzU[2&q1{3`h5w_794p@6s8?BgP>dFV=m D<TcS%Ze|r:lGK/uCy.Jx)HiQ!#$~(;Lt-R}Ma,NvW+Ynb*0X';
    // check if string encrypted
    if (strncmp($value,"!#!",3) == 0) {
        // get delimiter (character that was not in the encoded string and was set as delimiter)
        $delimiter = substr($source, strpos($dest, substr($value, 3, 1)), 1);
        // delete encryption label with delimiter from the string
        $value = substr($value, 4, strlen($value));
        
        // decode the value
        $result = '';
        for ($i = 0; $i < strlen($value); $i++) {
            $xchar = substr($value, $i, 1);
            $x = strpos($dest, $xchar);
            if ($x !== false) {
                if ($x > strlen($source)) {
                    return($value);
                }
                $result .= substr($source, $x, 1);
            } else { // if characters are not in source we will not decode them
                $result .= $xchar;
            }
        }
        $result = substr($result, 0, strpos($result, $delimiter));
        if ((strpos($result, ';') !== false || strpos($result, ' ') !== false)) {
            $result = '"' . $result . '"';
        }
        return $result;
    } else {
        return $value;
    }
}

/**
 * Pattern (file/content) to regex
 *
 * @param string $pattern.
 * @return string
 */
function patternToRegex($pattern) 
{
    $regex = strpos($pattern, '%');
    if($regex !== false && $regex == 0) {
        return($pattern);
    }
    return ';^'.preg_replace(['/\./', '/\?/', '/\*/'], ['\\.', '.', '.*?'], $pattern).'$;';
}

/**
 * Set global variable
 *
 * @param string $name variable name.
 * @param string $value variable value.
 * @return string variable value
 */
function set($name, $value)
{
    return $GLOBALS[$name] = $value;
}


/**
 * Get global variable
 *
 * @param string $name variable name.
 * @return string variable value
 */
function get($name)
{
    return isset($GLOBALS[$name]) ? $GLOBALS[$name] : null;
}

/**
 * Remove global variable
 *
 * @param string $name variable name.
 * @return void
 */
function remove($name)
{
    if(isset($GLOBALS[$name])) {
        unset($GLOBALS[$name]);
    }
}
/**
    * Parsing date arguments
    * @param int $gmt date time
    * @param string $fmt date format
    * @return string date
    **/
 function renderGmt($gmt, $fmt=null) 
    {
        if ($gmt) {
            if (!$fmt){
                $fmt = 'D M j h:i:sa';
            }
            return date($fmt, $gmt);
        }
        return __('Never');
    }
