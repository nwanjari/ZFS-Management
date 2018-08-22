<?php
/**
 *   HEADERS. This module is responsible for session authorization for local apps
 *
 * PHP Version 5
 *
 * @file     sn-admin/apps/.../app-header.php
 * @Requires app.json
 * @category Autorization of apps
 * @package  sn-admin
 * @author   Siddhant Rath <sid@tamu.edu>
 * @license  http://www.apache.org/licenses/LICENSE-2.0  Apache License 2.0
 */

##
#  MANDATORY CODES. DO NOT ALTER
##
require_once($_SERVER["DOCUMENT_ROOT"].'/sn-admin/protect.php');

$fileName = $_SERVER["DOCUMENT_ROOT"].'/sn-admin/apps/'.explode("/", $_SERVER['PHP_SELF'])[3].'/app.json';

try {
    if ( !file_exists($fileName) ) {
        throw new Exception('app.json not found.');
      }
    $fp = fopen($fileName, "rb");
    if ( !$fp ) {
        throw new Exception('Failed oppening app.json. Check Permissions?');
    }
    $string = stream_get_contents($fp);      
}
catch(Exception $e) {
    var_dump($e);
    die();
}
$json_a = json_decode($string, true);

try {
    if ( $json_a['app_id'] == null ) {
        throw new Exception('App ID NOT Found');
    }
}
catch(Exception $e) {
    var_dump($e);
    die();
}
_REGISTER_APP($json_a);

function _GET_APP_DETAILS() {
    global $json_a;
    return $_SESSION['sn-admin']['applications'][$json_a['app_id']];
}

### /|\
# DO NOT CHANGE ANYTHING ABOVE THESE LINES
###


/* 
 * Begin implementation of your code from here.
/*

/*


public function helloWorld() {
    printf ("Hello World");
}
*/

?>