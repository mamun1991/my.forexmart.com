<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');

/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code

define('ALLOWED_COUNTRIES', serialize(array('GB', 'BG', 'RU', 'LT', 'ES')));

define('ALLOWED_IPS', serialize(array(
    '27.147.132.246',
    '124.107.173.21',
    '58.69.197.82',
    '192.168.1.85',
    '118.69.226.81',
    '182.253.242.23',
    '213.239.215.78',
    '83.219.143.110',
    '62.152.11.127',
    '104.155.4.46',
    '5.9.65.183',
    '79.170.141.39',
    '210.213.232.24',
    '210.213.232.25',
    '210.213.232.26',
    '210.213.232.27',
    '210.213.232.28',
    '210.213.232.29',
    '104.24.19.93',
    '104.24.18.93',
    '148.251.181.104',
    '10.10.111.5' //Paxum IPN
    ,'144.76.102.144', //payco\
    '115.127.83.18',
    '176.9.130.91',
    '144.76.159.179',
    '78.46.187.12'// vpn ip

)));

define('ALLOWED_IP_RANGES', serialize(array(
    array('210.213.232.24','210.213.232.29'),
    array('193.138.0.0','193.138.255.255')
)));

define('MONEYFALL_SERVER_DEMO', 'demo.forexmart.com:443');
define('MONEYFALL_SERVER_LIVE', 'real.forexmart.com:443');
define('MT4_SERVER_DEMO', 'demo.forexmart.com:443');
define('MT4_SERVER_LIVE', 'real.forexmart.com:443');

define('TEST_USERS_DEPOSIT', serialize(array(
   '395541', '134362', '140865','154810', '159603', '109142', '88163', '134424', '69818', '161813', '161934', '68516','247424','251930','184450','191154','168643', '165394','200635','135835', '164559', '206699','210600','183774','222125','224740','270609','342123','385499','377957','382003'
)));


define('ILLICIT_COUNTRIES', serialize(array('US', 'KR', 'MM', 'SD', 'SY','BE')));