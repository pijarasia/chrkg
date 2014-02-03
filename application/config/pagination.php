<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| CI Pagination Configs for Bootstrap UI Framework
|--------------------------------------------------------------------------
|
| Pagination route rules:
|	$route['(.*)/page']        = '$1';
|	$route['(.*)/page/(:num)'] = '$1/$2';
|
| @see http://codeigniter.com/user_guide/libraries/pagination.html
| @see http://twitter.github.com/bootstrap/components.html#pagination
|
*/
$config['first_link']      = '« First';
$config['last_link']       = 'Last »';
$config['prev_link']       = '«';
$config['next_link']       = '»';

$config['full_tag_open']   = '<div class="pagination pagination-centered"><ul>';
$config['full_tag_close']  = '</ul></div>';

$config['first_tag_open']  = '<li>';
$config['first_tag_close'] = '</li>';
$config['last_tag_open']   = '<li>';
$config['last_tag_close']  = '</li>';

$config['cur_tag_open']    = '<li class="active"><a href="' . current_url() . '">';
$config['cur_tag_close']   = '</a></li>';
$config['next_tag_open']   = '<li>';
$config['next_tag_close']  = '</li>';
$config['prev_tag_open']   = '<li>';
$config['prev_tag_close']  = '</li>';

$config['num_tag_open']    = '<li>';
$config['num_tag_close']   = '</li>';
$config['anchor_class']    = 'pagination-link'; // Not necessary

/*
|--------------------------------------------------------------------------
| CI Pagination General Configs
|--------------------------------------------------------------------------
*/
$config['uri_segment']       = 4;
$config['num_links']         = 6;
$config['display_pages']     = TRUE;
$config['use_page_numbers']  = TRUE;
$config['page_query_string'] = FALSE;

/*
|--------------------------------------------------------------------------
| CI Pagination DYNAMIC Configs
|--------------------------------------------------------------------------
*/
// $config['base_url']   = '/path/to/page/';
// $config['first_url']  = '/path/to/page/1';
// $config['total_rows'] = $result_count;
// $config['per_page']   = $result_per_page;