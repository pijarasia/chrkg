<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/*
 | -------------------------------------------------------------------------
 | Email options.
 | -------------------------------------------------------------------------
 | email_config:
 | 	  'file' = Use the default CI config or use from a config file
 | 	  array  = Manually set your email config settings
 */
$config['email_config'] = array(
	'mailtype' => 'html',
	'smtp' => 'smtp.unpad.ac.id',
	'port' => '465',
	'secure' => 'ssl',
	'username' => 'trisna@unpad.ac.id',
	'password' => 'k0d0kl0',
	'from' => 'noreply@unpad.ac.id'
);