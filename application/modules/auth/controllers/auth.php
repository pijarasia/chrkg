<?php defined('BASEPATH') OR exit('No direct script access allowed');

Class Auth extends Front_Controller {

	function __construct(){
		parent::__construct();
			$this->load->model('welcome/vacancy_model','vacancy',TRUE);
			$this->load->model('applicant/applicant_model','applicant',TRUE);
			$this->load->model('ion_auth_model','ion_auth',TRUE);
			$this->load->model('register_model','register',TRUE);
			$this->config->item('use_mongodb', 'ion_auth') ?
			$this->load->library('mongo_db') :
			$this->load->database();

	$this->load->config('swiftmailer', TRUE);
	$email_config = $this->config->item('email_config', 'swiftmailer');

	if ($this->session->userdata('language') == ""){
		$this->session->set_userdata('language', "bahasa");
		$lang = "bahasa";
	}else
		$lang = $this->session->userdata('language');

	$this->lang->load('form',$lang);
	$this->lang->load('validation',$lang);
	$this->load->vars(array(
			'title' => 'Auths',
	));

	$this->transporter = Swift_SmtpTransport::newInstance($email_config['smtp'], $email_config['port'], $email_config['secure'])
	->setUsername($email_config['username'])
	->setPassword($email_config['password']);
	}

public function index(){
	$data['title'] = "Logout";
	$logout = $this->auth->logout();
	redirect('auth/login', 'refresh');
}

public function logout(){
	$data['title'] = "Logout";
	$logout = $this->auth->logout();
	redirect('auth/login', 'refresh');
}

public function forgot(){
    Template::render('login');
}

  public function login() {
        if ($this->auth->logged_in())
        {
            $group = $this->session->userdata('xyz');

            //Gta 11 Okt, udh lulus cv beda tampilan biodata
            $cek_step = $this->vacancy->cek_process_apply_stepcv($this->session->userdata('email'))->num_rows();

            switch ($group) {
                case '1':
                    redirect($this->config->item('base_url')."setting/user", 'refresh');
                    break;
                case '11':
                    //redirect($this->config->item('base_url')."applicant/form", 'refresh');
                    //Gta 11 Okt, udh lulus cv beda tampilan biodata
                    if ($cek_step == 0)
                        Template::redirect('applicant/form');
                    else
                        Template::redirect('applicant/data');
                    break;
                case '10':
                    //redirect($this->config->item('base_url')."applicant/form", 'refresh');
                    //Gta 11 Okt, udh lulus cv beda tampilan biodata
                    if ($cek_step == 0)
                        Template::redirect('applicant/form');
                    else
                        Template::redirect('applicant/data');
                    break;
                default:
                    redirect($this->config->item('base_url'), 'refresh');
                    break;
            }
        }
        $data["language"] = $this->session->userdata('language');
        $data["en"] = base_url()."login/en";
        $data["id"] = base_url()."login/id";

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
        $data['recaptcha'] = $capC['image'];
        $this->session->set_userdata('cap', $capC['word']);

        $vacancy = $this->vacancy->details($this->session->userdata('vacancy'));
        $row = $vacancy->row();
        $data["vacancyCompany"] = $row->companyName;
        $data["vacancyJob"] = $row->joborderTitle;

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js');
        Assets::add_js($this->load->view('js/register', null, true),'inline');

        Assets::add_module_css('auth','custom.css');
        $data['title'] = "Login";

        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        //forgot password
        $data['forgot'] = $this->session->userdata('form_forgot');
        $data['change'] = $this->session->userdata('form_change');
        $data['emails'] = $this->session->userdata('emails');
        $data['code_forgot'] = $this->session->userdata('code_forgot');
        $this->session->set_userdata('code_forgot',"");
        $this->session->set_userdata('form_forgot',false);
        $this->session->set_userdata('form_change',false);
        //forgot password

    if ($this->form_validation->run() == true)
    {
      $remember = (bool) $this->input->post('remember');

      if ($this->auth->login($this->input->post('identity'), $this->input->post('password'), $remember)){

                //Gita 1 September 2013
                //http://cdc.unpad.ac.id/recruitment2/applicant/form
                $person = $this->applicant->get_person($this->session->userdata('email'));
                $get_person = $person->row();
                $my_group = $this->session->userdata('group');
                if(count($my_group['groups']) > 1){
                    Template::redirect('auth/login_as');
                }else{
                    $this->session->set_userdata('group_active',$my_group['groups']);
                    Template::set_message($this->auth->messages(), 'success');
                }

                if ($get_person->AppUserLevelLevelID == 10 || $get_person->AppUserLevelLevelID == 11) //level for internal/external candidates
                {
                    if ($this->session->userdata('vacancy') != "")
                    {
                        //GTA 11 Okt
                        if ($cek_step == 0)
                            Template::redirect('applicant/form');
                        else
                            Template::redirect('applicant/data');
                    }
                    else
                        Template::redirect('jobapply');
                }
                else
            Template::redirect('joborder');
            }
      else
      {
        Template::set_message($this->auth->errors(), 'error');
        if ($this->auth->errors() == "Account is inactive") {
                    $this->session->set_userdata('errorMsg', "active");
                    $this->session->set_userdata('emails', $this->input->post('identity'));
                }
                //Template::redirect('auth/register');
                Template::redirect('login');
      }
    }
    else
    {  
      $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $data['identity'] = array('name' => 'identity',
        'id' => 'identity',
        'type' => 'text',
        'value' => $this->form_validation->set_value('identity'),
        'placeholder' => 'Username',
                'class' => 'ctrl-textbox pendek'
      );
      $data['password'] = array('name' => 'password',
        'id' => 'password',
        'type' => 'password',
        'placeholder' => 'Password',
                'class' => 'ctrl-textbox pendek'
      );
      $data['body_classes'] = 'container-register';
      Template::set($data);
      //Template::render('register');
      Template::render('login');
    }
  }

public function login_as(){
	if (!$this->auth->logged_in()){
		redirect('auth/register', 'refresh');
	}

	$this->load->model('setting/reference_model','reference',TRUE);
	$this->load->vars(array(
		'title'          => 'LOGIN AS',
	));
	Assets::clear_cache();
	Assets::add_module_css('register','custom.css');
	Assets::add_js($this->load->view('js/login_as', null, true),'inline');
	$company = $this->reference->referensi_company();
	$costcenter = $this->reference->referensi_cost();
	$data = array(
		'groups' => $this->auth->get_users_groups($this->session->userdata('user_id'))->result_array(),
		'company' => $this->register->translate_company($company),
		'costcenter' => $this->register->translate_cost($costcenter),
		'body_classes' => 'container-register'

	);
	if ($this->input->is_ajax_request()) {
		$this->register->login_as();
		Template::set_message($this->auth->messages(), 'success');
	}else {
		Template::set($data);
		Template::render('register');
	}
}

public function activation() {
	$kode = $this->input->post("kode");
	if ($this->auth->activate("", $kode) == 1)  {
		$this->session->unset_userdata('errorMsg');
		Template::set_message($this->auth->messages(), 'success');
	}
	else
		Template::set_message($this->auth->errors(), 'error');

	Template::redirect('auth/register');
}

public function verification()  {
	$kode = $this->uri->segment(3, 0);
	if ($kode != "") {
		if ($this->auth->activate("", $kode) == 1) {
			$this->session->unset_userdata('errorMsg');
			Template::set_message($this->auth->messages(), 'success');
		}
		else
			Template::set_message($this->auth->errors(), 'error');
	}
	Template::redirect('auth/register');
}

public function forgot_password() {
	if ($this->input->post('ajax'))    {
		$email = $this->input->post('emailreset');
		if ($email != "") {
			$forgotten = $this->auth->forgotten_password($email);
				if ($forgotten)
					echo lang('forgot_password_successful');
				else
					echo lang('forgot_password_unsuccessful');
		}
	}else{
        Template::render('login');
    }
}

public function reset_password($code = NULL)	{
	if (!$code){
		$code = $this->uri->segment(3, 0);
		if ($code == "")
			show_404();
	}
	$user = $this->auth->forgotten_password_check($code);
	if ($user){
	  $data['csrf'] = $this->_get_csrf_nonce();
			$data['code'] = $code;
	  $this->session->set_userdata('form_change',true);
	  $this->session->set_userdata('form_forgot',true);
	  $this->session->set_userdata('emails',$user->AppUserListEmail);
	  $this->session->set_userdata('code_forgot',$code);

	  Template::set($data);
	  Template::redirect('auth/register');
	}
}

public function change_password() {
	if ($this->input->post('ajax'))
	{
	  $code = $this->input->post('code');
	  $email = $this->input->post('email');
	  $newpassword = $this->input->post('newpassword');
	  $confirm_new_password = $this->input->post('confirm_new_password');

	  if ($email != "" && $newpassword != "" && $confirm_new_password != "")
	  {
		$old = $this->auth->forgotten_password_check($code);
		$change = $this->ion_auth->change_password($email, $old->AppUserListPassword, $newpassword);
		if ($change)
				echo lang('password_change_successful');
			else
				echo lang('password_change_unsuccessful');
	  }
	}
}

public function send_activation(){
if ($this->input->post('ajax')) {
  $getPerson = $this->applicant->get_person($this->input->post('email'))->row();
  $email = $this->input->post('email');
  $fname = $getPerson->AppUserListFirstName;
  $lname = $getPerson->AppUserListFirstName;
  $level = $getPerson->AppUserLevelLevelID;

  $this->config->load('swiftmailer');
  $swift_config = $this->config->item('email_config', 'swiftmailer');
  $from = array($swift_config['from'] => 'No Reply Kompas Gramedia');
  $to = array($email => $fname." ".$lname);
  $cc = array();
  $bcc = array();

  //sementara ngirim ke 11(external candidate) dulu
  $eml = $this->register->check_email($level, "Email Verification");
  $rowem = $eml->row();
  $rowem->EmailTmplContent = str_replace("[name]", $fname." ".$lname, $rowem->EmailTmplContent);
  $rowem->EmailTmplContent = str_replace("[email]", $this->input->post('email'), $rowem->EmailTmplContent);
  $rowem->EmailTmplContent = str_replace("[code]", $getPerson->AppUserListActivationCode, $rowem->EmailTmplContent);

  $send = $this->sendemail($from, $to, $cc, $bcc, "Welcome to Kompas Gramedia Group", $rowem->EmailTmplContent);
  if ($send == "Sent")
	  echo "Activation email has been sent";
  else
	  echo "Unable to send activation email";
}
}

public function error_captcha()  {
	if ($this->input->post('ajax')) {
		if ($this->input->post('captcha') == $this->session->userdata('cap'))
			echo "success";
		else
			echo lang('wrong_captcha');
	}
}

public function refresh() {
	if ($this->input->post('ajax')) {
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

public function _format_dropdown($results,$key,$value,$def = '',$caption = 'Please select ...'){
	$options = $def == '' ? array('' => $caption) : array();
	foreach ($results->result_array() as $rows){
		$options[$rows[$key]] = $rows[$value];
	}
	return $options;
}

  public function register(){
		$this->load->library(array('form_validation','table','pagination'));
		$this->load->driver('cache', array('adapter' => 'cache', 'backup' => 'apc'));
		$this->load->helper('form');
		$this->load->model('auth/ion_auth_model','ion_auth',TRUE);
		$this->load->model('vacancy/vacancy_model','vacancy',TRUE);
		$this->load->model('register_model','register',TRUE);
		$this->load->model('applicant/applicant_model','applicant',TRUE);
		$this->load->model('setting/reference_model','',TRUE);

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


        if ($this->auth->logged_in())
        {
            $group = $this->session->userdata('xyz');

            //Gta 11 Okt, udh lulus cv beda tampilan biodata
            $cek_step = $this->vacancy->cek_process_apply_stepcv($this->session->userdata('email'))->num_rows();

            switch ($group) {
                case '1':
                    redirect($this->config->item('base_url')."setting/user", 'refresh');
                    break;
                case '11':
                    //redirect($this->config->item('base_url')."applicant/form", 'refresh');
                    //Gta 11 Okt, udh lulus cv beda tampilan biodata
                    if ($cek_step == 0)
                        Template::redirect('applicant/form');
                    else
                        Template::redirect('applicant/data');
                    break;
                case '10':
                    //redirect($this->config->item('base_url')."applicant/form", 'refresh');
                    //Gta 11 Okt, udh lulus cv beda tampilan biodata
                    if ($cek_step == 0)
                        Template::redirect('applicant/form');
                    else
                        Template::redirect('applicant/data');
                    break;

                default:
                    redirect($this->config->item('base_url'), 'refresh');
                    break;
            }
        }

        $data["language"] = $this->session->userdata('language');
        $data["en"] = base_url()."auth/register/en";
        $data["id"] = base_url()."auth/register/id";

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
        $data['recaptcha'] = $capC['image'];
        $this->session->set_userdata('cap', $capC['word']);

        $vacancy = $this->vacancy->details($this->session->userdata('vacancy'));
        $row = $vacancy->row();
        $data["vacancyCompany"] = $row->companyName;
        $data["vacancyJob"] = $row->joborderTitle;

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js');
        Assets::add_js($this->load->view('js/register', null, true),'inline');

        Assets::add_module_css('auth','custom.css');
        $data['title'] = "Registrasi";

        $this->form_validation->set_rules('identity', 'Identity', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        //forgot password
        $data['forgot'] = $this->session->userdata('form_forgot');
        $data['change'] = $this->session->userdata('form_change');
        $data['emails'] = $this->session->userdata('emails');
        $data['code_forgot'] = $this->session->userdata('code_forgot');
        $this->session->set_userdata('code_forgot',"");
        $this->session->set_userdata('form_forgot',false);
        $this->session->set_userdata('form_change',false);
        //forgot password

    if ($this->form_validation->run() == true)
    {
      $remember = (bool) $this->input->post('remember');

      if ($this->auth->login($this->input->post('identity'), $this->input->post('password'), $remember)){

                //Gita 1 September 2013
                //http://cdc.unpad.ac.id/recruitment2/applicant/form
                $person = $this->applicant->get_person($this->session->userdata('email'));
                $get_person = $person->row();
                $my_group = $this->session->userdata('group');
                if(count($my_group['groups']) > 1){
                    Template::redirect('auth/login_as');
                }else{
                    $this->session->set_userdata('group_active',$my_group['groups']);
                    Template::set_message($this->auth->messages(), 'success');
                }

                if ($get_person->AppUserLevelLevelID == 10 || $get_person->AppUserLevelLevelID == 11) //level for internal/external candidates
                {
                    if ($this->session->userdata('vacancy') != "")
                    {
                        //GTA 11 Okt
                        if ($cek_step == 0)
                            Template::redirect('applicant/form');
                        else
                            Template::redirect('applicant/data');
                    }
                    else
                        Template::redirect('jobapply');
                }
                else
            Template::redirect('joborder');
            }
      else
      {
        Template::set_message($this->auth->errors(), 'error');
        if ($this->auth->errors() == "Account is inactive") {
                    $this->session->set_userdata('errorMsg', "active");
                    $this->session->set_userdata('emails', $this->input->post('identity'));
                }
                Template::redirect('auth/register');
      }
    }
    else
    {
      $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $data['identity'] = array('name' => 'identity',
        'id' => 'identity',
        'type' => 'text',
        'value' => $this->form_validation->set_value('identity'),
        'placeholder' => 'Username',
                'class' => 'ctrl-textbox pendek'
      );
      $data['password'] = array('name' => 'password',
        'id' => 'password',
        'type' => 'password',
        'placeholder' => 'Password',
                'class' => 'ctrl-textbox pendek'
      );
      $data['body_classes'] = 'container-register';
      Template::set($data);
      Template::render('register');
    }
  }

  public function register_applicant()
  {
      if ($this->input->post('ajax'))
      {
          $nama = $this->input->post('nama');
          $email = $this->input->post('email');
          $no_hp = $this->input->post('no_hp');
          //$no_identitas = $this->input->post('no_identitas');
          $password = $this->input->post('password');
          //$subscribe = $this->input->post('subscribe');

          do {
              $createActivationCode = $this->register->getToken(40);
              $checkActivationCode = $this->register->checkToken($createActivationCode);
          } while ($checkActivationCode == false);

          //filter person
          $result = $this->register->filter_person($email, $no_hp);
          if ($result == true) //2
          {
              $name = $this->register->explode_name($nama);
        $fname = $name[0];
              $lname = $name[1];
              $additional_data = array('AppUserListFirstName' => $fname,
                                      'AppUserListLastName' => $lname,
                              'AppUserListPhone' => $no_hp,
                                      'AppUserListActivationCode' => $createActivationCode
        );

              //Username fill with email
              $register = $this->auth->register($email, $password, $email, $additional_data);

              if ($register == false) {
                  echo "<h5 style='color: red;'>".lang('gagal_register')."(1)</h5>";
              } else {
                  $result = $this->register->register($register, $nama, $subscribe);
                  if ($result)
                  {
                      $this->config->load('swiftmailer');
                      $swift_config = $this->config->item('email_config', 'swiftmailer');
                      $from = array("{$swift_config['from']}" => 'No Reply Kompas Gramedia');
                      $to = array($email => $fname." ".$lname);
                      $cc = array();
                      $bcc = array();

                      //sementara ngirim ke 11(external candidate) dulu
                      $eml = $this->register->check_email("11", "Email Verification");
                      $rowem = $eml->row();
                      $rowem->EmailTmplContent = str_replace("[name]", $fname." ".$lname, $rowem->EmailTmplContent);
                      $rowem->EmailTmplContent = str_replace("[email]", $email, $rowem->EmailTmplContent);
                      $rowem->EmailTmplContent = str_replace("[code]", $createActivationCode, $rowem->EmailTmplContent);

                      $this->sendemail($from, $to, $cc, $bcc, "Welcome to Kompas Gramedia Group", $rowem->EmailTmplContent);
                      echo "<h5 style='color: #4F8A10;'>".lang('berhasil_register')."</h5>";
                  }
                  else
                      echo "<h5 style='color: #9F6000;'>".lang('gagal_register')."(2)</h5>";
              }
          }   else
                  echo "<h5 style='color: #9F6000;'>".lang('gagal_register')."(3)</h5>";

     }
  }

	public function sendemail($from, $to, $cc, $bcc, $subject, $msg){
		$this->mailer = Swift_Mailer::newInstance($this->transporter);
		$logger = new Swift_Plugins_Loggers_ArrayLogger();
		$this->mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

		$message = Swift_Message::newInstance();
		$message->setSubject($subject)
				->setFrom($from)
				->setTo($to)
				->setCc($cc)
				->setBcc($bcc)
				->setBody($msg,'text/html');

		$status = !$this->mailer->send($message,$failures) ? $failures : 'Sent';
        return $status;
	}

	public function _get_csrf_nonce()	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);
		return array($key => $value);
	}


  public function id() {
    $this->session->set_userdata('language', "bahasa");
    redirect('auth/login');
  }


  public function en(){
    $this->session->set_userdata('language', "english");
    redirect('auth/login');
  }
}