<?php

/** 
 * @author Krishna
 * 
 */

// App and DB configs
$config = array();

$config['db']['hostname'] = 'localhost';
$config['db']['database'] = 'blogdb';
$config['db']['username'] = 'sqluser';
$config['db']['password'] = 'password';

//reCaptcha Key
$config['captcha_domain'] = "localhost";
$config['captcha_publickey'] = "6LcJT_ESAAAAAM19j7lu4CbM2ewcxBuCWCDSzdcg";
$config['captcha_privatekey'] = "6LcJT_ESAAAAABc5-mpykwHov4G4o7c_bEh3T6hW";

// Autoloader
function __autoload( $className ) {
    require_once( dirname(__FILE__) ."/src/". $className . ".php" );
}