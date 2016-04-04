<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


/*
|--------------------------------------------------------------------------
| Custom Constants
|--------------------------------------------------------------------------
|
| These are some constants that will use for applications paths
|
*/
define('SITE_URL','http://' . $_SERVER['HTTP_HOST'] . '/numera/');

/*Table content*/
define('TBL_USERS','users');

define('PER_PAGE_RECORD','10');

define('PER_PAGE_RECORD_FRONT','30');


define('FRONTEND_DATE_VIEW_FORMAT',	    "d/m/Y");
define('ADMIN_DATE_VIEW_FORMAT',	    "d/m/Y");


/*Set Dynemic Constant*/
require_once( BASEPATH .'database/DB'. EXT );
$db =& DB();
$query = $db->get( 'numera_email' );
$row = $query->row() ;
if(isset($row) && count($row)>0){
        define('NUMERA_GMAIL_EMAIL',$row->numeraEmail);
        define('NUMERA_GMAIL_PWD',$row->numeraPassword);
}else{
    define('NUMERA_GMAIL_EMAIL','numera76@gmail.com');
    define('NUMERA_GMAIL_PWD','numera76123456');
}

define('NUMERA_SITE','http://www.oneandsimple.com/');

/*Define Footer Contant update by Admin panel*/
//define('FOOTER_TEXT','Numera, Powered by one and simple');

/* End of file constants.php */
/* Location: ./application/config/constants.php */
