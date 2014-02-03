<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Admin_Controller extends Authenticated_Controller {

	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_admin_controller');

		Template::set_theme('dashboard');
		Assets::clear_cache();
		Assets::add_css( array(
			'bootstrap_hb.css',
			'plusstrap.css',
			'custom_hb.css',
			'font-awesome.css'
		));

		Assets::add_js(array(
			'jquery.min.js',
			'modernizr.min.js',
			'bootstrap.min.js',
			'jquery.pnotify.min.js',
			'nprogress.js',
		));

		$this->load->vars(array(
			'base'           => base_url(),
			'title'          => 'Kompas Recruitment Dashboard',
			'head'           => '',
			'body_classes'   => 'dashboard-body',
		));
		Events::trigger('after_admin_controller');
    $this->load->model('welcome/vacancy_model','vacancy',TRUE);
	}
}

/* End of file Admin_Controller.php */
/* Location: ./application/core/Admin_Controller.php */