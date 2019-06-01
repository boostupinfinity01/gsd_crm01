<?php

/** 
 ----------------------------------
 GENERAL STRING FUNCTIONS STARTS 
 ----------------------------------       
*/

function str_limit($string,$limit=90){
    if(strlen($string) >= $limit){
        return substr($string,0,$limit - 3)."<span class='dots'>...</span>";
    }
    return $string;
}

/**
 * Return String to display properly
 * @param string $string
 * @return string
 */
function getDisplayString($string){
    return trim(ucwords(strtolower($string)));
}

/**
 * Convert File name to display properly for url
 * @param string $file_name
 * @return string
 */
function sanitizeFileName($file_name){
    $file_name = str_replace("(","-",$file_name);
    $file_name = str_replace(")","-",$file_name);
    $file_name = str_replace(".","-",$file_name);
    $file_name = str_replace("/","-",$file_name);
    $file_name = str_replace(" ","-",$file_name);
    return $file_name; 
}

/**
 * Convert String to display properly for url
 * @param string $string
 * @return string
 */
function generateUrlString($string){
    $string = str_replace("&","and",$string);
    $string = str_replace("/","-",$string);
    $string = str_replace("%","-",$string);
    $string = str_replace("_","-",$string);
    $string = str_replace(")","",$string);
    $string = str_replace("(","",$string);        
    $string = str_replace("------","-",$string);
    $string = str_replace("-----","-",$string);
    $string = str_replace("----","-",$string);
    $string = str_replace("---","-",$string);
    $string = str_replace("--","-",$string);
    $string = str_replace(",","",$string);
    $string = str_replace("'","",$string);
    $string = str_replace('"',"",$string);
    $string = str_replace('=',"",$string);
    return trim(str_replace(" ","-",strtolower($string)));
}

/**
 * Limit the string to particular character limit
 * @param string $string
 * @param number $limit
 * @return string
 */
function strLimiter($string,$limit=0){
    $string = get_display_string($string);
    if($limit > 0){
        if(strlen($string) > $limit){
            return substr($string,0,$limit)."...";
        }            
    }
    return $string; 
}

/**
 * Strip slashes and special characters before passed to database
 * @param string $string
 * @return string
 */
function fSafeChar($string){
    $string = processInput($string);
    //$string = str_replace("\'","'",$string);
    $string = str_replace("'","''",$string);
    return trim($string);
}

/**
 * Filter string as number otherwise return 0
 * @param number $number
 * @return number
 */
function fSafeNum($number){
    if(is_numeric($number)){
        return $number;
    }else{
        return 0;
    }
}

/**
 * Strip slashes and special characters before passed to database
 * @param string $data
 * @return string
 */
function processInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return strval($data);
}

/** 
 -------------------------------------
 *** GENERAL STRING FUNCTIONS END ***
 -------------------------------------
*/

##################################################
##################################################

/** 
 -------------------------------------
 *** SECURITY FUNCTIONS STARTS ***
 -------------------------------------
*/


/**
 * Encrypt a string to one way
 * @param string $string
 * @param string $enc_key (optional)
 * @return string
 */
function oneWayEncrypt($string,$enc_key=""){
    $enc_text = md5($enc_key.$string);
    $enc_text = sha1($enc_text);
    return $enc_text;
}

/**
 * Generate a random security token
 * @param string $string
 * @param string enc_key (optional)
 * @return string
 */
function genSecurityToken($string,$enc_key=""){
    return one_way_encrypt($string,$enc_key);
}

/**
 * Encrypt a string
 * @param string $string
 * @return string
 */
function encodeString($string){
    $enc_text = base64_encode($string);    
    return $enc_text;
}

/**
 * Decrypt a string
 * @param string $string
 * @return string
 */
function decodeString($string){    
    $dec_text = base64_decode($dec_text);        
    return $dec_text;
}

/** 
 -------------------------------------
 *** SECURITY FUNCTIONS END ***
 -------------------------------------
*/

##################################################
##################################################

/** 
 -------------------------------------
 *** SESSION FUNCTIONS START ***
 -------------------------------------
*/

/**
 * Save a Session
 * @param string $session_name
 * @param string $value
 */
function saveSession($session_name,$value){    
    $_SESSION[$session_name] = encrypt($value);
}

/**
 * Get Session Value
 * @param string $session_name
 * @return string $value
 */
function getSession($session_name){    
    $value = decrypt($_SESSION[$session_name]);
    return $value;
}

/**
 * Remove Session Value
 * @param string $session_name
 * @return string $value
 */
function removeSession($session_name){    
    unset($_SESSION[$session_name]);
}

/**
 * Get Session Value as Number
 * @param string $session_name
 * @return number $value
 */
function getNumSession($session_name){    
    $value = fSafeNum(decrypt($_SESSION[$session_name]));
    return $value;
}

/**
 * Save a Cookie
 * @param string $cookie_name
 * @param string $value
 * @param number $expire_time
 * @param string $path (optional) 
 */
function saveCookie($cookie_name,$value,$expire_time,$path="/"){
    setcookie($cookie_name, encrypt($value), $expire_time, $path);
}

/**
 * Get Cookie Value
 * @param string $cookie_name
 * @return string $value
 */
function getCookie($cookie_name){
    return decrypt($_COOKIE[$cookie_name]);
}

/**
 * Get Cookie Value as Number
 * @param string $cookie_name
 * @return number $value
 */
function getNumCookie($cookie_name){
    return fSafeNum(decrypt($_COOKIE[$cookie_name]));
}

function removeCookie($cookie_name){
    setcookie($cookie_name, "", time()-3600,"/");
}

/** 
 -------------------------------------
 *** SESSION FUNCTIONS END ***
 -------------------------------------
*/

##################################################
##################################################


/** 
 -------------------------------------
 *** FORM FUNCTIONS STARTS ***
 -------------------------------------
*/


/**
 * Get a sanitize form string value from post method
 * @param string $post_name
 * @return string
 */
function getPost($post_name){
    $val = fSafeChar($_POST[$post_name]);
    return $val;
}

/**
 * Get a sanitize form number value from post method
 * @param string $post_name
 * @return number
 */
function getNPost($post_name){
    $val = getPost($post_name);
    $val = fSafeNum($val);
    return $val;
}

/**
 * Get a sanitize form number value from get method
 * @param string $get_name
 * @return number
 */
function getNGet($get_name){
    $val = getGet($get_name);
    $val = fSafeNum($val);
    return $val;
}

/**
 * Get a sanitize form string value from get method
 * @param string $get_name
 * @return string
 */
function getGet($get_name){
    $val = fSafeChar($_GET[$get_name]);
    return $val;
}    

/** 
 -------------------------------------
 *** FORM FUNCTIONS END ***
 -------------------------------------
*/

##################################################
##################################################

/** 
 -------------------------------------
 *** DATE FUNCTIONS STARTS ***
 -------------------------------------
*/

/**
 * Convert date in detail as readable string
 * @param date $timestamp
 * @param bool $isTimeStamp
 * @return string
 */
function dateDetailFormat($timestamp = "",$isTimeStamp = true){
    if($timestamp == "") $timestamp = time();
    
    if(!$isTimeStamp) $timestamp = strtotime($timestamp);
    
    return date("l, F d, Y h:i:s A",$timestamp);
}

/**
 * Convert date in summarize format as readable string
 * @param date $timestamp
 * @param bool $isTimeStamp
 * @return string
 */
function dateDisplayFormat($timestamp = "",$isTimeStamp = true){
    if($timestamp == "") $timestamp = time();
    
    if(!$isTimeStamp) $timestamp = strtotime($timestamp);
    
    return date("F d, Y",$timestamp);
}

/**
 * Convert date for javascript format
 * @param date $timestamp
 * @param bool $isTimeStamp
 * @return string
 */
function jQueryDateFormat($timestamp = "",$isTimeStamp = true){
    if($timestamp == "") $timestamp = time();
    
    if(!$isTimeStamp) $timestamp = strtotime($timestamp);
    
    return date("m/d/y",$timestamp);
}

/**
 * Convert date for mysql format
 * @param date $timestamp
 * @param bool $isTimeStamp
 * @param bool $returnTime
 * @return string
 */
function mysqlDateFormat($timestamp = "",$isTimeStamp = true,$returnTime = true){
    if($timestamp == "") $timestamp = time();
    
    if(!$isTimeStamp) $timestamp = strtotime($timestamp);
    
    if($returnTime)
        return date("Y-m-d H:i:s",$timestamp);
    else
        return date("Y-m-d",$timestamp);
}



/** 
 -------------------------------------
 *** DATE FUNCTIONS END ***
 -------------------------------------
*/


function safe_b64encode($string) {
    $data = base64_encode($string);
    $data = str_replace(array('+','/','='),array('-','_',''),$data);
    return $data;
}

function safe_b64decode($string) {
   global $encryption_key;
    $data = str_replace(array('-','_'),array('+','/'),$string);
    $mod4 = strlen($data) % 4;
    if ($mod4) {
        $data .= substr('====', $mod4);
    }
    return base64_decode($data);
}

/**
 * Convert encode encprt data with MCRYPT
 * @param value $value
 * @param encryption key $encryption_key
 * @return string
 */
 
    
function encode_encrpt($value,$encryption_key){ 
    if(!$value){return false;}
    $text = $value;
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $crypttext = mcrypt_encrypt(MCRYPT_RIJNDAEL_256, $encryption_key, $text, MCRYPT_MODE_ECB, $iv);
    return trim(safe_b64encode($crypttext)); 
}

/**
 * Convert decode encprt data with MCRYPT
 * @param value $value
 * @param encryption key $encryption_key
 * @return string
 */


function decode_encrpt($value,$encryption_key){
    if(!$value){return false;}
    $crypttext = safe_b64decode($value); 
    $iv_size = mcrypt_get_iv_size(MCRYPT_RIJNDAEL_256, MCRYPT_MODE_ECB);
    $iv = mcrypt_create_iv($iv_size, MCRYPT_RAND);
    $decrypttext = mcrypt_decrypt(MCRYPT_RIJNDAEL_256, $encryption_key, $crypttext, MCRYPT_MODE_ECB, $iv);
    return trim($decrypttext);
}

function encrypt($string, $key) {
    $result = '';
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)+ord($keychar));
        $result.=$char;
    }
    return base64_encode($result);
}

function decrypt($string, $key) {
    $result = '';
    $string = base64_decode($string);
    for($i=0; $i<strlen($string); $i++) {
        $char = substr($string, $i, 1);
        $keychar = substr($key, ($i % strlen($key))-1, 1);
        $char = chr(ord($char)-ord($keychar));
        $result.=$char;
    }
    return $result;
}

##################################################
##################################################
?>
