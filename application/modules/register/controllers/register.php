<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author Gita D
* @author Trisna Gelar A <balaplumpat@@gmail.com> @mang_gibenk
* @created 10 May, 2013
*
**/
class Register extends Base_Controller {
	function __construct()
	{
	parent::__construct();
		$this->load->library(array('form_validation','table','pagination'));
		$this->load->helper('form');
		$this->load->model('auth/ion_auth_model','ion_auth',TRUE);
		$this->load->model('vacancy/vacancy_model','vacancy',TRUE);
		$this->load->model('register_model','register',TRUE);
		$this->load->model('applicant/applicant_model','applicant',TRUE);
		$this->load->model('setting/reference_model','',TRUE);

		if ($this->session->userdata('language') == "")
		{
			$this->session->set_userdata('language', "bahasa");
			$lang = "bahasa";
		}else
			$lang = $this->session->userdata('language');

		$this->lang->load('form',$lang);
		$this->lang->load('validation',$lang);
		$this->load->vars(array(
			'title' => 'Apply for Jobs',
		));

		$this->load->config('swiftmailer', TRUE);
		$email_config = $this->config->item('email_config', 'swiftmailer');

		$this->transporter = Swift_SmtpTransport::newInstance($email_config['smtp'], $email_config['port'], $email_config['secure'])
		->setUsername($email_config['username'])
		->setPassword($email_config['password']);
	}

	public function _format_dropdown($results,$key,$value,$def = '',$caption = 'Please select ...')
	{
		$options = $def == '' ? array('' => $caption) : array();
		foreach ($results->result_array() as $rows)
		{
			$options[$rows[$key]] = $rows[$value];
		}
		return $options;
	}

	public function index()
	{
		$data["gender"] = array('P' => 'Pria','W' => 'Wanita');

		if (!$data["country"] = $this->cache->get('country'))
		{
			$data["country"] = $this->_format_dropdown($this->reference_model->referensi_negara(),'CountryCode','CountryName','', 'Country where you currently reside');
			$this->cache->save('country', $data["country"], 300);
		}

		if (!$data["nationality"] = $this->cache->get('nationality'))
		{
			$data["nationality"] = $this->_format_dropdown($this->reference_model->referensi_nationality(),'NationalityCode','NationalityName','','Your Nationality');
			$this->cache->save('nationality', $data["nationality"], 300);
		}

		if (!$data["education_lvl"] = $this->cache->get('education_lvl'))
		{
			$data["education_lvl"] = $this->_format_dropdown($this->reference_model->referensi_pendidikan_utama(),'EducationLevelCode','EducationLevelName','','Your Education Qualification');
			$this->cache->save('country', $data["education_lvl"], 300);
		}

		if (!$data["candidate_src"] = $this->cache->get('candidate_src'))
		{
			$data["candidate_src"] = $this->_format_dropdown($this->reference_model->referensi_candidate_source(),'CandidateSourcesID','CandidateSourcesName','','How did you hear about this job?');
			$this->cache->save('candidate_src', $data["candidate_src"], 300);
		}

	Template::set($data);
	Template::render('register');
	}
  
  public function refresh()
    {
        if ($this->input->post('ajax'))
        {
            $this->load->library('session');
            $this->load->helper('captcha');
            $vals = array(
                    'img_path'   => './captcha/',
                    'img_url'    => base_url().'captcha/',
                    'img_width'  => '100',
                    'img_height' => '35',
                    'border' => 0,
                    'expiration' => 7200
                );

            $capC = create_captcha($vals);
            echo $capC['image'];
            $this->session->set_userdata('cap', $capC['word']);
        }
    }

}