<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Setting extends Admin_Controller {

  public function __construct()
	{
		parent::__construct();
		$this->load->vars(array(
			'title' => 'Settings',
			'navigation' => 'nav-settings'
		));
		$this->load->model('setting_group_model','ref_group',TRUE);
    $this->load->model('setting_permission_model','ref_permission',TRUE);
    $this->load->model('setting_company_model','ref_company',TRUE);
    $this->load->model('setting_user_model','ref_user',TRUE);
    $this->load->model('setting_cost_model','ref_cost',TRUE);
    $this->load->model('setting_vertical_model','ref_vertical',TRUE);
    $this->load->model('setting_location_model','ref_location',TRUE);
    $this->load->model('setting_candidate_source_model','ref_csources',TRUE);
    $this->load->model('setting/reference_model','reference',TRUE);
    $this->load->model('auth/register_model','register',TRUE);
    $this->load->model('ref_blood_model','ref_blood',TRUE);
    $this->load->model('ref_province_model','ref_province',TRUE);
    $this->load->model('ref_country_model','ref_country',TRUE);
    $this->load->model('ref_education_model','ref_education',TRUE);
    $this->load->model('ref_marital_model','ref_marital',TRUE);
    $this->load->model('ref_month_model','ref_month',TRUE);
    $this->load->model('ref_religion_model','ref_religion',TRUE);
    $this->load->model('ref_language_model','ref_language',TRUE);
    $this->load->model('ref_business_model','ref_business',TRUE);
    $this->load->model('ref_employment_model','ref_employment',TRUE);
    $this->load->model('ref_process_status_model','ref_process_status',TRUE);
    $this->load->model('ref_selection_steps_model','ref_selection_steps',TRUE);
    $this->load->model('t_email_model','t_email',TRUE);
	}

	public function index()
	{
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
		}else {
			Template::set($data);
			Template::set_view('nav/plan');
			Template::render();
		}
	}

	public function menu(){
		if ($this->input->is_ajax_request()) {
		}else {
			return $this->load->view('menu', $data, TRUE);
		}
	}

	public function cost_centers()
	{
		$this->load->vars(array(
			'brea_nav' => 'cost_centers-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/get_cost_centers', '', true),'inline');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
			$this->ref_cost->record();
		}else {
			Template::set($data);
			Template::set_view('nav/cost_centers');
			Template::render();
		}
	}

		public function cost_centers_delete(){
      if (!$this->auth->logged_in())
      {
          redirect($this->config->item('base_url'), 'refresh');
      }
      // $this->auth->_have_permission('Dashboard.Company.Delete');
      if ($this->input->is_ajax_request()) {
          $this->ref_cost->delete();
      }else {
      }
    }
    public function cost_centers_form(){
      if (!$this->auth->logged_in()){
          redirect($this->config->item('base_url'), 'refresh');
      }
      // $this->auth->_have_permission('Dashboard.Company.Form');
      if ($this->input->is_ajax_request()) {
          $this->ref_cost->form();
      }else {
      }
    }
    public function cost_centers_modal(){
      if ($this->input->is_ajax_request()) {
      }else {
          return $this->load->view('nav/cost_centers_modal', $data, TRUE);
      }
    }

	public function verticals()
	{
		$this->load->vars(array(
			'brea_nav' => 'verticals-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_css('custom.dialog.css');
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/get_verticals', '', true),'inline');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
			$this->ref_vertical->record();
		}else {
			$data['brea_nav'] = 'verticals-nav';
			Template::set($data);
			Template::set_view('nav/verticals');
			Template::render();
		}
	}

    public function verticals_delete(){
      if (!$this->auth->logged_in())
      {
          redirect($this->config->item('base_url'), 'refresh');
      }
      // $this->auth->_have_permission('Dashboard.Company.Delete');
      if ($this->input->is_ajax_request()) {
          $this->ref_vertical->delete();
      }else {
      }
    }
    public function verticals_form(){
      if (!$this->auth->logged_in()){
          redirect($this->config->item('base_url'), 'refresh');
      }
      // $this->auth->_have_permission('Dashboard.Company.Form');
      if ($this->input->is_ajax_request()) {
          $this->ref_vertical->form();
      }else {
      }
    }
    public function verticals_modal(){
      if ($this->input->is_ajax_request()) {
      }else {
          return $this->load->view('nav/verticals_modal', $data, TRUE);
      }
    }

	public function locations()
	{
		$this->load->vars(array(
			'brea_nav' => 'locations-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/get_locations', '', true),'inline');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
			$this->ref_location->record();
		}else {
			Template::set($data);
			Template::set_view('nav/locations');
			Template::render();
		}
	}

		public function locations_delete(){
	    if (!$this->auth->logged_in())
	    {
	        redirect($this->config->item('base_url'), 'refresh');
	    }
	    // $this->auth->_have_permission('Dashboard.Company.Delete');
	    if ($this->input->is_ajax_request()) {
	        $this->ref_location->delete();
	    }else {
	    }
	  }
	  public function locations_form(){
	    if (!$this->auth->logged_in()){
	        redirect($this->config->item('base_url'), 'refresh');
	    }
	    // $this->auth->_have_permission('Dashboard.Company.Form');
	    if ($this->input->is_ajax_request()) {
	        $this->ref_location->form();
	    }else {
	    }
	  }
	  public function locations_modal(){
	    if ($this->input->is_ajax_request()) {
	    }else {
	        return $this->load->view('nav/locations_modal', $data, TRUE);
	    }
	  }


	public function email_template()
	{
		$this->load->vars(array(
			'brea_nav' => 'email_template-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
		}else {
			Template::set($data);
			Template::set_view('nav/email_template');
			Template::render();
		}
	}

	public function candidate_sources()
	{
		$this->load->vars(array(
			'brea_nav' => 'candidate_sources-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/get_candidate_sources', '', true),'inline');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
			$this->ref_csources->record();
		}else {
			Template::set($data);
			Template::set_view('nav/candidate_sources');
			Template::render();
		}
	}
		public function candidate_sources_delete(){
      if (!$this->auth->logged_in())
      {
          redirect($this->config->item('base_url'), 'refresh');
      }
      // $this->auth->_have_permission('Dashboard.Company.Delete');
      if ($this->input->is_ajax_request()) {
          $this->ref_csources->delete();
      }else {
      }
    }
    public function candidate_sources_form(){
      if (!$this->auth->logged_in()){
          redirect($this->config->item('base_url'), 'refresh');
      }
      // $this->auth->_have_permission('Dashboard.Company.Form');
      if ($this->input->is_ajax_request()) {
          $this->ref_csources->form();
      }else {
      }
    }
    public function candidate_sources_modal(){
      if ($this->input->is_ajax_request()) {
      }else {
          return $this->load->view('nav/candidate_sources_modal', $data, TRUE);
      }
    }

	public function internal_staff()
	{
		$this->load->vars(array(
			'brea_nav' => 'internal_staff-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
		}else {
			Template::set($data);
			Template::set_view('nav/internal_staff');
			Template::render();
		}
	}

	public function agency_staff()
	{
		$this->load->vars(array(
			'brea_nav' => 'agency_staff-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
		}else {
			Template::set($data);
			Template::set_view('nav/agency_staff');
			Template::render();
		}
	}

	public function candidate_home()
	{
		$this->load->vars(array(
			'brea_nav' => 'candidate_home-nav'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}

		$this->auth->_have_permission('Dashboard.Settings.View');

		Assets::clear_cache();
		Assets::add_js('string.min.js');
		Assets::add_js('jquery.validate.min.js');
		Assets::add_js( $this->load->view('js/ready', '', true) , 'inline');
		Assets::add_module_css('setting','custom.css');

		if ($this->input->is_ajax_request()) {
		}else {
			Template::set($data);
			Template::set_view('nav/candidate_home');
			Template::render();
		}
	}

/*
	UserManagement
*/

  public function group(){
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}
	    $this->auth->_have_permission('Dashboard.Group.View');
        $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->load->vars(array('title' => "User Management :: Group"));

		Assets::clear_cache();
		Assets::add_css('bootstrap-sortable.css');
        Assets::add_css('custom.dialog.css');
		Assets::add_js('jquery.bootpag.js');
		Assets::add_js( $this->load->view('js/get_group', array('total' => $this->ref_group->count_all()), true),'inline');
		Assets::add_js( $this->load->view('js/um/ready', array('total' => $this->ref_group->count_all()), true) , 'inline');
        Assets::add_js('jquery.validate.min.js');

		if ($this->input->is_ajax_request()) {
			$this->ref_group->record();
		}else {
			Template::set_view('group/index');
            Template::set($data);
			Template::render();
		}
	}

    public function group_delete()
    {
      if (!$this->auth->logged_in()){
          redirect($this->config->item('base_url'), 'refresh');
      }
      $this->auth->_have_permission('Dashboard.Group.Delete');
      if ($this->input->is_ajax_request()) {
          $this->ref_group->delete();
      }else {

      }
    }

	public function group_form(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Group.Form');
    if ($this->input->is_ajax_request()) {
        $this->ref_group->form();
    }else {
    }
	}

  public function group_modal(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Group.Modal');
    $this->load->vars(array('sub-title' => "Group"));
    if ($this->input->is_ajax_request()) {
            $this->ref_group->modal();
    }else {
        return $this->load->view('group/modal', $data, TRUE);
    }
  }

  public function group_permission($id=null){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Group.Permission.View');
    $this->load->vars(array('title' => "User Management :: Group Permission"));
    $data = array(
        'populate' => $this->ref_permission->populate_permission(),
        'populate_by_lev_id' => $this->ref_permission->populate_permission_by_level_id($id),
        'lev_id' => $id
        );
    Assets::clear_cache();
    Assets::add_js( $this->load->view('js/get_group_permission', array(), true),'inline');
    if ($this->input->is_ajax_request()) {
        $this->ref_group->permission();
    }else {
        Template::set_view('group/permission');
        Template::set($data);
        Template::render();
    }
  }

  public function permission()
  {
      if (!$this->auth->logged_in())
      {
          redirect($this->config->item('base_url'), 'refresh');
      }
      $this->auth->_have_permission('Dashboard.Permission.View');
      $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      $this->load->vars(array('title' => "User Management :: Permission"));

      Assets::clear_cache();
      Assets::add_css('bootstrap-sortable.css');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.bootpag.js');
      Assets::add_js( $this->load->view('js/get_permission', array('total' => $this->ref_permission->count_all()), true),'inline');
      Assets::add_js( $this->load->view('js/um/ready', array('total' => $this->ref_permission->count_all()), true) , 'inline');
      Assets::add_js('jquery.validate.min.js');

      if ($this->input->is_ajax_request()) {
          $this->ref_permission->record();
      }else {
          Template::set_view('permission/index');
          Template::set($data);
          Template::render();
      }
  }

  public function permission_delete(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Permission.Delete');
    if ($this->input->is_ajax_request()) {
        $this->ref_permission->delete();
    }else {

    }
  }

  public function permission_form(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Permission.Form');
    if ($this->input->is_ajax_request()) {
        $this->ref_permission->form();
    }else {
    }
  }

  public function permission_modal(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Permission.Modal');
    $this->load->vars(array('sub-title' => "Permission"));
    if ($this->input->is_ajax_request()) {
            $this->ref_permission->modal();
    }else {
        return $this->load->view('permission/modal', $data, TRUE);
    }
  }

  public function user()
  {
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.View');
    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->vars(array(
        'title' => "User Management :: User",
        'option' => array(
            's_group' => $this->_format_dropdown($this->reference->referensi_group(),'AppLevelListID','AppLevelListLevelName'))
        ));
    $data = array(
        's_gr' => array('name' => 's_group',
                'id' => 's_group',
                'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
                'label' => 'Group'
                ),
    );

    Assets::clear_cache();
    Assets::add_css('bootstrap-sortable.css');
    Assets::add_css('custom.dialog.css');
    Assets::add_js('jquery.bootpag.js');
    Assets::add_js(
        $this->load->view('js/get_user',
            array(
                'total' => $this->ref_user->count_all()), true),'inline');
    Assets::add_js( $this->load->view('js/um/ready', array('total' => $this->ref_user->count_all()), true) , 'inline');
    Assets::add_js('jquery.validate.min.js');

    if ($this->input->is_ajax_request()) {
        $this->ref_user->record();
    }else {
        Template::set_view('user/index');
        Template::set($data);
        Template::render();
    }
  }

  //activate the user
  public function user_activate($id = null, $code=false)
  {
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.Activate');
    if ($this->input->is_ajax_request()) {
        $id = $this->input->post('id');
        if ($code !== false)
            $activation = $this->auth->activate($id, $code);
        else if ($this->auth->is_admin())
            $activation = $this->auth->activate($id);
        if ($activation){
            $this->ref_user->_aj['status'] = 'success';
            $this->ref_user->_aj['message'] = 'User Activation sucessful';
        }else{
            $this->ref_user->_aj['status'] = 'error';
            $this->ref_user->_aj['message'] = 'User Activation unsucessful';
        }
        echo json_encode($this->ref_user->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
  }

  //deactivate the user
  public function user_deactivate($id = NULL)
  {
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.Deactivate');
    if ($this->input->is_ajax_request()) {
        if ($this->auth->is_admin())
            $activation = $this->auth->deactivate($id);

        if ($activation){
            $this->ref_user->_aj['status'] = 'success';
            $this->ref_user->_aj['message'] = 'User Activation sucessful';
        }else{
            $this->ref_user->_aj['status'] = 'error';
            $this->ref_user->_aj['message'] = 'User Activation unsucessful';
        }
        echo json_encode($this->ref_user->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
  }

  public function user_delete()
  {
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.Delete');
    if ($this->input->is_ajax_request()) {
        $this->ref_user->delete();
    }else {

    }
  }

  public function user_modal_add(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Modal.Add');
    $this->load->vars(array(
            'title' => "User Management :: User Add",
            'option' => array(
                'company' => $this->_format_dropdown($this->reference->referensi_company(),'companyID','companyName')),
            ));
    // Multiple Company
    $data = array(
        'company' => array('name' => 'company',
                'id' => 'company',
                'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
                'label' => 'Company'

    ));
    // Group Multiple Select
    if (true) {//$this->input->is_ajax_request()) {
        $form_data = array('full_name','email','mobile_phone','password','hidden_id');
        foreach ($form_data as $val)
            $data[$val] = $this->input->post($val);

        $result = $this->register->filter_person($data['email'], $data['mobile_phone']);
        if ($result == true){
            do {
                $createActivationCode = $this->register->getToken(40);
                $checkActivationCode = $this->register->checkToken($createActivationCode);
            } while ($checkActivationCode == false);
            $name = $this->register->explode_name($data['full_name']);
            $fname = $name[0];
            $lname = $name[1];
            $additional_data = array(
                $this->ref_user->_first_name => $fname,
                $this->ref_user->_last_name => $lname,
                $this->ref_user->_phone => $data['mobile_phone'],
                $this->ref_user->_activation_code => $createActivationCode
            );
            $register = $this->auth->register($data['email'], $data['password'], $data['email'], $additional_data);
            if($register == false){
                $this->ref_user->_aj['status'] = 'errors';
                $this->ref_user->_aj['message'] = 'Add user unsucessful';
            }else{
                $this->ref_user->_aj['status'] = 'success';
                $this->ref_user->_aj['message'] = 'Add user sucessful';
            }
        }else {
            $this->ref_user->_aj['status'] = 'error';
            $this->ref_user->_aj['message'] = 'Add user unsucessful';
        }
        echo json_encode($this->ref_user->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }else {
        return $this->load->view('user/modal_add', $data, TRUE);
    }
  }

  public function user_modal(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.Modal');
    $this->load->vars(array(
            'title' => "User Management :: Form User",
            'option' => array(
                'company' => $this->_format_dropdown($this->reference->referensi_company(),'companyID','companyName')),
            ));
    $data = array(
        'company' => array('name' => 'company',
                'id' => 'company',
                'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
                'label' => 'Company'

    ));
    if ($this->input->is_ajax_request()) {
        $this->ref_user->form();
    }else {
        return $this->load->view('user/modal', $data, TRUE);
    }
  }

  public function user_modal_change_password(){
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.Modal.Password');
    $this->load->vars(array('sub-title' => "Password"));
    if ($this->input->is_ajax_request()) {
        $form_data = array('old_password','new_password','hidden_id');
        foreach ($form_data as $val)
            $data[$val] = $this->input->post($val);

        $user = $this->auth->user($data['hidden_id'])->row();
        $change = 1;
        if ($change){
            $this->ref_user->_aj['status'] = 'success';
            $this->ref_user->_aj['message'] = $this->auth->messages();
        }else {
            $this->ref_user->_aj['status'] = 'error';
            $this->ref_user->_aj['message'] = $this->auth->errors();
        }
        echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }else {
        return $this->load->view('user/modal_change_password', $data, TRUE);
    }
  }

  public function user_modal_change_level(){
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.Modal.Level');
    $this->load->vars(
        array('sub-title' => "Level",
                'option' => array(
                    'level' => $this->_format_dropdown_o($this->reference->referensi_group(),'AppLevelListID','AppLevelListLevelName'),
                    'company' => $this->_format_dropdown_o($this->reference->referensi_company(),'companyID','companyName'),
                    'cost' => $this->_format_dropdown_o($this->reference->referensi_cost(),'CostCenterID','CostCenterName'),
                )
            )
    );
    if ($this->input->is_ajax_request()) {
        $form_data = array('hidden_id', 'hidden_ug_id', 'level', 'refid');
        foreach ($form_data as $val)
            $data[$val] = $this->input->post($val);

        $id = $data['hidden_id'];
        unset($data['hidden_id']);

        $save = $this->ref_user->add_group($this->ref_user->translate_data($data),$id);

        if ($save){
            $this->ref_user->_aj['status'] = 'success';
            $this->ref_user->_aj['message'] = 'Group Edit Success';
            $this->ref_user->_aj['data'] = $data;
        }else {
            $this->ref_user->_aj['status'] = 'error';
            $this->ref_user->_aj['message'] = 'Group Edit Failed';
        }
        echo json_encode($this->ref_user->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }else {
        return $this->load->view('user/modal_change_level', $data, TRUE);
    }
  }

  public function user_modal_change_level_init(){
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.User.Modal.Level');
    if ($this->input->is_ajax_request()) {
        $form_data = array('id');
        foreach ($form_data as $val)
            $data[$val] = $this->input->post($val);

        $option = array(
            'level' => $this->_format_dropdown_o($this->reference->referensi_group(),'AppLevelListID','AppLevelListLevelName'),
            'company' => $this->_format_dropdown_o($this->reference->referensi_company(),'companyID','companyName'),
            'cost' => $this->_format_dropdown_o($this->reference->referensi_cost(),'CostCenterID','CostCenterName'),
        );
        $group = $this->ref_user->get_group_by_user($data['id']);
        $translate = $this->ref_user->translate_user_group_init($option);
        if(count($group) > 0){
            $translate = $this->ref_user->translate_user_group($group, $option);
        }
        $this->ref_user->_aj['status'] = 'success';
        $this->ref_user->_aj['translate'] = $translate;
        echo json_encode($this->ref_user->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
  }

  public function company()
  {
    if (!$this->auth->logged_in()){
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Company.View');

    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->vars(array(
        'title' => "User Management :: Company",
        'option' => array(
            's_business_area' => $this->_format_dropdown($this->reference->referensi_business_area(),'BusinessID','BusinessArea')
        )
        ));

    Assets::clear_cache();
    Assets::add_css('bootstrap-sortable.css');
    Assets::add_css('custom.dialog.css');
    Assets::add_js('jquery.bootpag.js');
    Assets::add_js('jquery.form.js');
    Assets::add_js( $this->load->view('js/get_company', array('total' => $this->ref_company->count_all()), true),'inline');
    Assets::add_js( $this->load->view('js/um/ready', array('total' => $this->ref_company->count_all()), true) , 'inline');
    Assets::add_js('jquery.validate.min.js');

    $data = array(
        's_ba' => array('name' => 's_business_area',
                'id' => 's_business_area',
                'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
                'label' => 'Vertical'
                ),
    );

    if ($this->input->is_ajax_request()) {
        $this->ref_company->record();
    }else {
        Template::set_view('company/index');
        Template::set($data);
        Template::render();
    }
  }

  public function company_delete() {
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Company.Delete');
    if ($this->input->is_ajax_request()) {
        $this->ref_company->delete();
    }else {

    }
  }

  public function company_form(){
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Company.Form');
    if ($this->input->is_ajax_request()) {
        $this->ref_company->form();
    }else {
    }
  }

  public function company_form_upload(){
      if (!$this->auth->logged_in())  {
          redirect($this->config->item('base_url'), 'refresh');
      }
      $this->auth->_have_permission('Dashboard.Company.Form.Upload');
      if ($this->input->is_ajax_request()) {
          $this->ref_company->form_upload();
      }else {
      }
  }

  public function company_modal(){
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Company.Modal');
    $this->load->vars(array(
        'sub-title' => "Company",
        'option' => array(
            'country' => $this->_format_dropdown($this->reference->referensi_negara(),'CountryCode','CountryName'),
            'province' => $this->_format_dropdown($this->reference->referensi_provinsi(),'ProvinceCode','ProvinceName'),
            'business_area' => $this->_format_dropdown($this->reference->referensi_business_area(),'BusinessID','BusinessArea')
        )
    ));
    $data = array(
        'ba' => array('name' => 'business_area',
                'id' => 'business_area',
                'class' => 'selectpicker show-tick show-menu-arrow',
                'label' => 'Vertical'
                ),
        'state' => array('name' => 'state',
                'id' => 'state',
                'class' => 'selectpicker show-tick show-menu-arrow',
                'label' => 'State'
                ),
        );
    if ($this->input->is_ajax_request()) {
    }else {
        return $this->load->view('company/modal', $data, TRUE);
    }
  }

  public function company_modal_upload(){
    if (!$this->auth->logged_in()) {
        redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Company.Modal.Upload');
    $this->load->vars(array(
        'sub-title' => "Company Upload",
    ));
    if ($this->input->is_ajax_request()) {
            $this->ref_company->modal_upload();
    }else {
        return $this->load->view('company/modal_upload', $data, TRUE);
    }
  }


  /* Reference
   */
	public function blood_type()	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}	else {
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->load->vars(array('title' => lang("referensi")." :: ".lang("gol_darah")));
			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_bloodtype', array('total' => $this->ref_blood->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_blood->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.Blood.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Blood.Add');
      if ($this->auth->_allowed('Dashboard.Reference.Blood.Change') || $this->auth->_allowed('Dashboard.Reference.Blood.Delete'))
          $data["bool_action"] = true;
			if ($this->input->is_ajax_request()) {
    			$this->ref_blood->record();
			}else {
				Template::set($data);
				Template::set_view('ref/blood_type');
				Template::render();
			}
		}
	}

    public function delete_blood() {
      if ($this->input->post('ajax')) {
    		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
    			redirect($this->config->item('base_url'), 'refresh');
    		}
        $id = $this->input->post('id');
        echo $this->ref_blood->delete_blood($id);
      }
    }

		public function create_blood(){
      if ($this->input->post('ajax')) {
          $id = $this->input->post('id');
          $gol_darah = $this->input->post('gol_darah');
          if ($id == "") {
              $add = array('BloodType' => $this->input->post('gol_darah'));
              echo $this->ref_blood->add_blood($gol_darah, $add);
          } else {
              $edit = array('BloodType' => $this->input->post('gol_darah'));
              echo $this->ref_blood->change_blood($id, $edit);
          }
      }
		}
	public function province()	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}else{
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->load->vars(array('title' => lang("referensi")." :: ".lang("provinsi")));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_province', array('total' => $this->ref_province->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_province->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

			$this->auth->_have_permission('Dashboard.Reference.Province.View');
			$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Province.Add');
	        if ($this->auth->_allowed('Dashboard.Reference.Province.Change') || $this->auth->_allowed('Dashboard.Reference.Province.Delete'))
	            $data["bool_action"] = true;
			if ($this->input->is_ajax_request()) {
    			$this->ref_province->record();
			}else {
				Template::set($data);
				Template::set_view('ref/province');
				Template::render();
			}
		}
	}

		public function create_province(){
	    if ($this->input->post('ajax'))
	    {
	      $id = $this->input->post('id');
	      $province = $this->input->post('provinsi');
	      if ($id == "") {
	          $add = array('ProvinceName' => $province);
	          echo $this->ref_province->add_province($province, $add);
	      } else {
	          $edit = array('ProvinceName' => $province);
	          echo $this->ref_province->change_province($id, $edit);
	      }
	    }
		}

    public function delete_province() {
      if ($this->input->post('ajax')){
    		if (!$this->auth->logged_in() || !$this->auth->is_admin())
    		{
    			redirect($this->config->item('base_url'), 'refresh');
    		}
        $id = $this->input->post('id');
        echo $this->ref_province->delete_province($id);
      }
    }
	public function country()	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		} else {
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->vars(array('title' => lang("referensi")." :: ".lang("negara")));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_country', array('total' => $this->ref_country->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_country->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.Country.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Country.Add');
      if ($this->auth->_allowed('Dashboard.Reference.Country.Change') || $this->auth->_allowed('Dashboard.Reference.Country.Delete'))
          $data["bool_action"] = true;
			if ($this->input->is_ajax_request()) {
    			$this->ref_country->record();
			}else {
				Template::set($data);
				Template::set_view('ref/country');
				Template::render();
			}
		}
	}

		public function create_country(){
      if ($this->input->post('ajax')) {
          $id = $this->input->post('id');
          $country = $this->input->post('negara');
          $add = array('CountryName' => $country);
          echo $this->ref_country->change_country($id, $add);
      }
		}

    public function delete_country() {
      if ($this->input->post('ajax')) {
    		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
    			redirect($this->config->item('base_url'), 'refresh');
    		}
        $id = $this->input->post('id');
        echo $this->ref_country->delete_country($id);
      }
    }

	public function education_level()	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}else	{
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->vars(array('title' => lang("referensi")." :: ".lang("jenjang")));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_education', array('total' => $this->ref_education->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_education->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.Education.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Education.Add');
          if ($this->auth->_allowed('Dashboard.Reference.Education.Change') || $this->auth->_allowed('Dashboard.Reference.Education.Delete'))
              $data["bool_action"] = true;

			if ($this->input->is_ajax_request()) {
    			$this->ref_education->record();
			}else {
				Template::set($data);
				Template::set_view('ref/education_level');
				Template::render();
			}
		}
	}

		public function create_education(){
	    if ($this->input->post('ajax')) {
        $id = $this->input->post('id');
        $level = $this->input->post('level');
        $category = $this->input->post('category');
        $add = array('EducationLevelName' => $level, 'EducationLevelCategory' => $category);
        echo $this->ref_education->change($id, $add);
	    }
		}

    public function delete_education() {
      if ($this->input->post('ajax'))
      {
	  		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
	  			redirect($this->config->item('base_url'), 'refresh');
	  		}
        $id = $this->input->post('id');
        echo $this->ref_education->delete($id);
      }
    }

	public function marital_status(){
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}	else {
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->load->vars(array('title' => lang("referensi")." :: ".lang("status")));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_marital', array('total' => $this->ref_marital->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_marital->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

			$this->auth->_have_permission('Dashboard.Reference.Marital.View');
			$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Marital.Add');
	        if ($this->auth->_allowed('Dashboard.Reference.Marital.Change') || $this->auth->_allowed('Dashboard.Reference.Marital.Delete'))
	            $data["bool_action"] = true;

	  	if ($this->input->is_ajax_request()) {
				$this->ref_marital->record();
			}else {
				Template::set($data);
				Template::set_view('ref/marital_status');
				Template::render();
			}
		}
	}

	public function create_marital(){
    if ($this->input->post('ajax')) {
      $id = $this->input->post('id');
      $status = $this->input->post('status');
      $english = $this->input->post('english');
      $order = $this->input->post('order');
      $add = array('MaritalName' => $status, 'MaritalEnglish' => $english, 'MaritalOrder' => $order);
      echo $this->ref_marital->change($id, $add);
    }
	}

    public function delete_marital() {
        if ($this->input->post('ajax')) {
	    		if (!$this->auth->logged_in() || !$this->auth->is_admin()) {
	    			redirect($this->config->item('base_url'), 'refresh');
	    		}
          $id = $this->input->post('id');
          echo $this->ref_marital->delete($id);
        }
    }

	public function month()	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin())		{
			redirect($this->config->item('base_url'), 'refresh');
		}	else	{
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->load->vars(array('title' => lang("referensi")." :: ".lang("bulan")));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_month', array('total' => $this->ref_month->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_month->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.Month.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Month.Add');
          if ($this->auth->_allowed('Dashboard.Reference.Month.Change') || $this->auth->_allowed('Dashboard.Reference.Month.Delete'))
              $data["bool_action"] = true;

			if ($this->input->is_ajax_request()) {
    			$this->ref_month->record();
			}else {
				Template::set($data);
				Template::set_view('ref/month');
				Template::render();
			}
		}
	}

		public function create_month(){
	    if ($this->input->post('ajax')) {
        $id = $this->input->post('id');
        $bulan = $this->input->post('bulan');
        $english = $this->input->post('english');
        if ($id == "") {
            $add = array('MonthNameID' => $bulan, 'MonthNameEN' => $english);
            echo $this->ref_month->add($bulan, $add);
        } else {
            $edit = array('MonthNameID' => $bulan, 'MonthNameEN' => $english);
            echo $this->ref_month->change($id, $edit);
        }
	    }
		}

    public function delete_month() {
      if ($this->input->post('ajax')) {
	  		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
	  			redirect($this->config->item('base_url'), 'refresh');
	  		}
        $id = $this->input->post('id');
        echo $this->ref_month->delete($id);
      }
    }

	public function religion()
	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}else{
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      $this->load->vars(array('title' => lang("referensi")." :: ".lang("agama")));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_religion', array('total' => $this->ref_religion->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_religion->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.Religion.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Religion.Add');
      if ($this->auth->_allowed('Dashboard.Reference.Religion.Change') || $this->auth->_allowed('Dashboard.Reference.Religion.Delete'))
          $data["bool_action"] = true;

			if ($this->input->is_ajax_request()) {
    			$this->ref_religion->record();
			}else {
				Template::set($data);
				Template::set_view('ref/religion');
				Template::render();
			}
		}
	}

		public function create_religion(){
		  if ($this->input->post('ajax')) {
		    $id = $this->input->post('id');
		    $agama = $this->input->post('agama');
		    if ($id == "") {
		        $add = array('ReligionName' => $agama);
		        echo $this->ref_religion->add($bulan, $add);
		    } else {
		        $edit = array('ReligionName' => $agama);
		        echo $this->ref_religion->change($id, $edit);
		    }
		  }
		}

    public function delete_religion() {
      if ($this->input->post('ajax')) {
	  		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
	  			redirect($this->config->item('base_url'), 'refresh');
	  		}
        $id = $this->input->post('id');
        echo $this->ref_religion->delete($id);
      }
    }

	public function language_literacy()
	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}	else{
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
      if ($data["language"] == "english")
          $this->load->vars(array('title' => lang("referensi")." :: ".lang('bahasa')." ".lang('kemampuan')));
      else
          $this->load->vars(array('title' => lang("referensi")." :: ".lang('kemampuan')." ".lang('bahasa')));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_language', array('total' => $this->ref_language->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_language->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.Language.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Language.Add');
      if ($this->auth->_allowed('Dashboard.Reference.Language.Change') || $this->auth->_allowed('Dashboard.Reference.Language.Delete'))
          $data["bool_action"] = true;

			if ($this->input->is_ajax_request()) {
    			$this->ref_language->record();
			}else {
				Template::set($data);
				Template::set_view('ref/language_literacy');
				Template::render();
			}
		}
	}

		public function create_language(){
	    if ($this->input->post('ajax')) {
	      $id = $this->input->post('id');
	      $kemampuan = $this->input->post('kemampuan');
	      $english = $this->input->post('english');
	      if ($id == "") {
	          $add = array('aplLangBahasa' => $kemampuan, 'aplLangEnglish' => $english);
	          echo $this->ref_language->add($bulan, $add);
	      } else {
	          $edit = array('aplLangBahasa' => $kemampuan, 'aplLangEnglish' => $english);
	          echo $this->ref_language->change($id, $edit);
	      }
	    }
		}

    public function delete_language() {
      if ($this->input->post('ajax')) {
    		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
    			redirect($this->config->item('base_url'), 'refresh');
    		}
        $id = $this->input->post('id');
        echo $this->ref_language->delete($id);
      }
    }

  public function employment_type()	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()) {
			redirect($this->config->item('base_url'), 'refresh');
		}	else {
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->vars(array('title' => lang("referensi")." :: ".lang('tipe_pekerjaan')));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_employment', array('total' => $this->ref_employment->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_employment->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.Employment.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.Employment.Add');
      if ($this->auth->_allowed('Dashboard.Reference.Employment.Change') || $this->auth->_allowed('Dashboard.Reference.Employment.Delete'))
          $data["bool_action"] = true;

			if ($this->input->is_ajax_request()) {
    			$this->ref_employment->record();
			}else {
				Template::set($data);
				Template::set_view('ref/employment_type');
				Template::render();
			}
		}
	}

		public function create_employment(){
      if ($this->input->post('ajax')) {
        $id = $this->input->post('id');
        $pekerjaan = $this->input->post('pekerjaan');
        if ($id == "") {
            $add = array('EmploymentType' => $pekerjaan);
            echo $this->ref_employment->add($id, $add);
        } else {
            $edit = array('EmploymentType' => $pekerjaan);
            echo $this->ref_employment->change($id, $edit);
        }
      }
		}

    public function delete_employment() {
      if ($this->input->post('ajax')) {
	  		if (!$this->auth->logged_in() || !$this->auth->is_admin())
	  		{
	  			redirect($this->config->item('base_url'), 'refresh');
	  		}
        $id = $this->input->post('id');
        echo $this->ref_employment->delete($id);
      }
    }

	public function process_status() {
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}	else {
      $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$this->load->vars(array('title' => lang("referensi")." :: ".lang('status_proses')));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_process_status', array('total' => $this->ref_process_status->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_process_status->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css');
      Assets::add_js('jquery.validate.min.js');

  		$this->auth->_have_permission('Dashboard.Reference.JobProcess.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.JobProcess.Add');
          if ($this->auth->_allowed('Dashboard.Reference.JobProcess.Change') || $this->auth->_allowed('Dashboard.Reference.JobProcess.Delete'))
              $data["bool_action"] = true;

			if ($this->input->is_ajax_request()) {
    			$this->ref_process_status->record();
			}else {
				Template::set($data);
				Template::set_view('ref/process_status');
				Template::render();
			}
		}
	}

	public function create_process_status(){
    if ($this->input->post('ajax')) {
      $id = $this->input->post('id');
      $status = $this->input->post('status');
      if ($id == "") {
          $add = array('StatusProcess' => $status);
          echo $this->ref_process_status->add($id, $add);
      } else {
          $edit = array('StatusProcess' => $status);
          echo $this->ref_process_status->change($id, $edit);
      }
    }
	}

    public function delete_process_status() {
      if ($this->input->post('ajax')) {
    		if (!$this->auth->logged_in() || !$this->auth->is_admin())
    		{
    			redirect($this->config->item('base_url'), 'refresh');
    		}
        $id = $this->input->post('id');
        echo $this->ref_process_status->delete($id);
      }
    }

	public function selection_steps()
	{
		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
			redirect($this->config->item('base_url'), 'refresh');
		}
		else{
            $data["language"] = $this->session->userdata('language');
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->load->vars(array('title' => lang("referensi")." :: ".lang('urutan_seleksi')));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('ref/js/get_selection_steps', array('total' => $this->ref_selection_steps->count_all()), true),'inline');
			Assets::add_js( $this->load->view('ref/js/ready', array('total' => $this->ref_selection_steps->count_all()), true) , 'inline');
            Assets::add_css('custom.dialog.css');
            Assets::add_js('jquery.validate.min.js');

    		$this->auth->_have_permission('Dashboard.Reference.SelectionSteps.View');
    		$data["bool_add"] = $this->auth->_allowed('Dashboard.Reference.SelectionSteps.Add');
            if ($this->auth->_allowed('Dashboard.Reference.SelectionSteps.Change') || $this->auth->_allowed('Dashboard.Reference.SelectionSteps.Delete'))
                $data["bool_action"] = true;

			if ($this->input->is_ajax_request()) {
    			$this->ref_selection_steps->record();
			}else {
				Template::set($data);
				Template::set_view('ref/selection_steps');
				Template::render();
			}
		}
	}

		public function create_selection_steps(){
	    if ($this->input->post('ajax')) {
	        $id = $this->input->post('id');
	        $steps = $this->input->post('steps');
	        if ($id == "") {
	            $add = array('Steps' => $steps);
	            echo $this->ref_selection_steps->add($id, $add);
	        }
	        else {
	            $edit = array('Steps' => $steps);
	            echo $this->ref_selection_steps->change($id, $edit);
	        }
	    }
		}

    public function delete_selection_steps()
    {
      if ($this->input->post('ajax')) {

  		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
  			redirect($this->config->item('base_url'), 'refresh');
  		}
          $id = $this->input->post('id');
          echo $this->ref_selection_steps->delete($id);
      }
    }

	/**
   * Template Email
   */
	public function temail()
	{
		if (!$this->auth->logged_in()){
			redirect($this->config->item('base_url'), 'refresh');
		}	else {
      $data["language"] = $this->session->userdata('language');
      $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
			$data["group"] = $this->reference->referensi_group();

      $this->load->vars(array('title' => "Email Template"));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js( $this->load->view('te/js/get_email', array('total' => $this->t_email->count_all()), true),'inline');
			Assets::add_js( $this->load->view('te/js/ready', array('total' => $this->t_email->count_all()), true) , 'inline');
      Assets::add_css('custom.dialog.css'); //custom dialog style
      Assets::add_js('jquery.validate.min.js');

      Assets::add_js('jquery.hotkeys.js');
      Assets::add_js('google-code-prettify/prettify.js');
			Assets::add_css('index.css');
      Assets::add_js('bootstrap-wysiwyg.js');

  		$this->auth->_have_permission('Dashboard.TemplateEmail.View');
  		$data["bool_add"] = $this->auth->_allowed('Dashboard.TemplateEmail.Add');

			if ($this->input->is_ajax_request()) {
    			$this->t_email->record();
			}else {
				Template::set($data);
				Template::set_view('te/temail');
				Template::render();
			}
		}
	}

		public function create_email(){
      if ($this->input->post('ajax')) {
          $id = $this->input->post('id');
          $group = $this->input->post('group');
          $subject = $this->input->post('subject');
          $editor = $this->input->post('editor');
          $add = array('EmailTmplGroup' => $group, 'EmailTmplSubject' => $subject, 'EmailTmplContent' => $editor);
          echo $this->t_email->change($id, $add);
      }
		}

    public function delete_email() {
      if ($this->input->post('ajax')) {
	  		if (!$this->auth->logged_in() || !$this->auth->is_admin()){
	  			redirect($this->config->item('base_url'), 'refresh');
	  		}
        $id = $this->input->post('id');
        echo $this->t_email->delete($id);
      }
    }

    public function check_email() {
      if ($this->input->post('ajax')) {
          $id = $this->input->post('id');
          $check = $this->t_email->check_id($id);
          foreach ($check->result() as $row) {
              $data = array("group" => $row->EmailTmplGroup, "groupname" => $row->AppLevelListLevelName ,"subject" => $row->EmailTmplSubject, "editor" => $row->EmailTmplContent);
          }
          echo json_encode($data);
      }
    }
	public function _format_dropdown($results,$key,$value,$def = ''){
    $options = $def == '' ? array('' => 'Please select ....') : array();
    foreach ($results->result_array() as $rows)    {
        $options[$rows[$key]] = $rows[$value];
    }
    return $options;
  }

  public function _format_dropdown_o($results,$key,$value,$def = ''){
    $options = $def == '' ? array(0 => 'Please select ....') : array();
    foreach ($results->result_array() as $rows)    {
        $options[$rows[$key]] = $rows[$value];
    }
    return $options;
  }

  public function _format_dropdown_array($results,$def = ''){
    $options = $def == '' ? array('' => 'Please select ....') : array();
    foreach ($results as $keys => $values)    {
        $options[$keys] = $values;
    }
    return $options;
  }


  public function _format_dropdown_ajax($results,$key,$value){
    $options = array();
    foreach ($results->result_array() as $rows)    {
        array_push($options, array('id' => $rows[$key], 'name' => $rows[$value]));
    }
    return $options;
  }

  public function _get_csrf_nonce()  {
    $this->load->helper('string');
    $key = random_string('alnum', 8);
    $value = random_string('alnum', 20);
    $this->session->set_flashdata('csrfkey', $key);
    $this->session->set_flashdata('csrfvalue', $value);

    return array($key => $value);
  }

  public function _valid_csrf_nonce()  {
    if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
            $this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue')){
        return TRUE;
    }else{
        return FALSE;
    }
  }

}
