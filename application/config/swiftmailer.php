<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 | -------------------------------------------------------------------------
 | Email options.
 | -------------------------------------------------------------------------
 | email_config:
 | 	  'file' = Use the default CI config or use from a config file
 | 	  array  = Manually set your email config settings
 */
 require_once 'application/swiftmailer/swift_required.php';
$config['email_config'] = array(
	'mailtype' => 'html',
	'smtp' => 'smtp.gmail.com',
	'port' => '465',
	'secure' => 'ssl',
	'username' => 'dev.blackyt@gmail.com',
	'password' => 'blackyt7788',
	'from' => 'noreply@dev.chrkg.com'
);