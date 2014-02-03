<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

abstract class Base_Controller extends MX_Controller {

	protected $user;
	protected $previous_page;
	protected $requested_page;

	public function __construct()
	{
		Events::trigger('before_controller_constructor', get_class($this));

		parent::__construct();

		Events::trigger('before_base_controller_constructor', get_class($this));

		$this->load->library('auth/ion_auth', '', 'auth');
		if ($this->auth->logged_in())
		{
			$this->user = $this->auth->user()->row();
			$this->user->groups = $this->auth->get_users_groups($this->user->id)->result();
			$this->user->picture = gravatar_link($this->user->email, 22, $this->user->email, "{$this->user->email} Profile", ' ', ' ');
		}
		$this->load->vars(array('current_user' => $this->user));
		if ( ! preg_match('/\.(gif|jpg|jpeg|png|css|js|ico|shtml)$/i', $this->uri->uri_string()))
		{
			$this->previous_page = $this->session->userdata('previous_page');
			$this->requested_page = $this->session->userdata('requested_page');
		}

		if (ENVIRONMENT == 'production')
		{
			// $this->db->save_queries = FALSE;
		    $this->load->driver('cache', array('adapter' => 'apc', 'backup' => 'file'));
		}

		else if (ENVIRONMENT == 'development')
		{
			ini_set('html_errors', 1);
			ini_set('display_errors', 1);
			ini_set('display_startup_errors', 1);

			if ( ! $this->input->is_cli_request() AND ! $this->input->is_ajax_request())
			{
				$this->load->library('console');
				$this->output->enable_profiler(TRUE);
			}

			$this->load->driver('cache', array('adapter' => 'dummy'));
		}

		Events::trigger('after_base_controller_constructor', get_class($this));
	}
}

/* End of file MY_Controller.php */
/* Location: ./application/core/MY_Controller.php */