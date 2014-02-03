<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Front_Controller extends Base_Controller {

	public function __construct()	{
		parent::__construct();

		Events::trigger('before_front_controller');

		Template::set_theme($this->config->item('default_theme'));
		Assets::clear_cache();
		Assets::add_css( array(
			'bootstrap.css',
			'main.css',
			'plusstrap.css',
			'custom.css',
			'font-awesome.css'
		));
		Assets::add_js(array(
			'jquery.min.js',
			'modernizr.min.js',
			'bootstrap.min.js',
			'jquery.pnotify.min.js',
			'analytics.js',
			'jquery.bootpag.min.js'
		));

		$this->load->vars(array(
			'base'           => base_url(),
			'title'          => 'Kompas Recruitment',
			'head'           => '',
			'body_classes'   => 'front-body',
		));
		Events::trigger('after_front_controller');
	}
}
// End of Front_Controller class

/* End of file Front_Controller.php */
/* Location: ./application/core/Front_Controller.php */