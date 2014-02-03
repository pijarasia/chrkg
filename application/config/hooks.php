<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| Hooks
| -------------------------------------------------------------------------
| This file lets you define "hooks" to extend CI without hacking the core
| files.  Please see the user guide for info:
|
|	http://codeigniter.com/user_guide/general/hooks.html
|
*/

/**
 * Enables autoloading of base controllers.
 */
$hook['pre_system'] = array(
	'class'    => 'MY_Autoloader',
	'function' => 'register',
	'filename' => 'MY_Autoloader.php',
	'filepath' => 'hooks',
	'params'   => array(APPPATH . 'base/')
);

/*
// compress output
$hook['display_override'][] = array(
	'class' => '',
	'function' => 'Compress',
	'filename' => 'Compress.php',
	'filepath' => 'hooks'
	);
*/
/* End of file hooks.php */
/* Location: ./application/config/hooks.php */