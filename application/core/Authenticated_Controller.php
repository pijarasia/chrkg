<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

Class Authenticated_Controller extends Base_Controller {

	public function __construct()
	{
		parent::__construct();

		Events::trigger('before_auth_controller');

		if ( ! $this->auth->logged_in())
		{
			$this->auth->logout();
			Template::set_message('You must be logged in to view that page.', 'error');
			Template::redirect('auth/register');
		}

		Events::trigger('after_auth_controller');
	}
}

/* End of file Auth_Controller.php */
/* Location: ./application/core/Auth_Controller.php */