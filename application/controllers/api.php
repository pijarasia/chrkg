<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Welcome module's controller for demo purposes.
 *
 * @package 	CodeIgniter
 * @category	Controllers
 * @author		Sepehr Lajevardi <me@sepehr.ws>
 * @link		https://github.com/sepehr/ci-maestro
 */
class Api extends Front_Controller {
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 */
	public function index()
	{
		echo "DATA Connector API";
	}

	public function connect()
	{
		echo "Connecting...";
	}

	public function getJobsInformation()
	{
	}

	public function pushAplicant()
	{
	}

	public function flagApplicant()
	{
	}
}

/* End of file welcome.php */
/* Location: ./application/modules/welcome/controllers/welcome.php */
