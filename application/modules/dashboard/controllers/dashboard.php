<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends Admin_Controller {

  public function __construct(){
		parent::__construct();
		$this->load->vars(array(
			'title' => 'Dashboard',
			'navigation' => 'nav-dashboard'
		));
		$this->load->model('Joborder/Joborder_Model','joborder',TRUE);
		$this->load->model('Setting/Reference_model','reference',TRUE);
	}

	public function index(){
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}
		$this->auth->_have_permission('Dashboard.Dashboard.View');
		redirect($this->config->item('base_url').'/dashboard/job', 'refresh');
	}

	public function taskbar(){
		$this->load->vars(array(
			'title' => 'Taskbar',
			'navigation' => 'nav-my-taskbar'
		));

		if (!$this->auth->logged_in()){
			redirect($this->config->item('base_url'), 'refresh');
		}
		else{
			$this->auth->_have_permission('Dashboard.Taskbar.View');
			Assets::clear_cache();

			if ($this->input->is_ajax_request()) {
			}else {
				Template::set($data);
				Template::render();
			}
		}
	}

	public function job(){
		$this->load->vars(array(
			'title' => 'Dashboard',
			'navigation' => 'nav-dashboard'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}
		$this->auth->_have_permission('Dashboard.Joborder.View');
		$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->load->vars(array(
            'option' => array(
                's_business_area' => $this->_format_dropdown($this->reference->referensi_business_area(),'BusinessID','BusinessArea','All Vertical'),
                's_location' => $this->_format_dropdown($this->reference->referensi_location(),'LocationID','Location', 'All Locations'),
                's_candidate' => $this->_format_dropdown($this->reference->referensi_candidate_sources(),'CandidateSourcesID','CandidateSourcesName', 'All Sources'),
             ),
            'refid' => $this->session->userdata('refid')));

		Assets::clear_cache();
		Assets::add_module_css('joborder','custom.css');
		Assets::add_css('custom.dialog.css');
		Assets::add_js( $this->load->view('js/get_dashboard', array('total' => $this->joborder->count_all()), true),'inline');
		Assets::add_js( $this->load->view('js/ready', array('total' => $this->joborder->count_all()), true) , 'inline');

		$data = array(
      's_business_area' => array('name' => 's_business_area',
              'id' => 's_business_area',
              'class' => 'inline input-small'
              ),
      's_location' => array('name' => 's_location',
              'id' => 's_location',
              'class' => 'inline input-small'
              ),
      's_candidate' => array('name' => 's_candidate',
              'id' => 's_candidate',
              'class' => 'inline input-small'
              ));

		if ($this->input->is_ajax_request()) {
			$this->joborder->record_dashboard();
		}else {
			Template::set($data);
			Template::render();
		}
	}

	public function candidate(){
		$this->load->vars(array(
			'title' => 'Dashboard',
			'navigation' => 'nav-dashboard'
		));

		if (!$this->auth->logged_in()){
			redirect($this->config->item('base_url'), 'refresh');
		}
		else{
			$this->auth->_have_permission('Dashboard.Candidate.View');
			Assets::clear_cache();

			if ($this->input->is_ajax_request()) {
			}else {
				Template::set($data);
				Template::render();
			}
		}
	}

	public function scorecard(){
		$this->load->vars(array(
			'title' => 'Dashboard',
			'navigation' => 'nav-dashboard'
		));

		if (!$this->auth->logged_in()){
			redirect($this->config->item('base_url'), 'refresh');
		}
		else{
			$this->auth->_have_permission('Dashboard.Scorecard.View');
			Assets::clear_cache();

			if ($this->input->is_ajax_request()) {
			}else {
				Template::set($data);
				Template::render();
			}
		}
	}

	public function calendar()
	{
		$this->load->vars(array(
			'title' => 'Calendar',
			'navigation' => 'nav-calendar'
		));
		if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}
		else
		{
			$this->auth->_have_permission('Dashboard.Calendar.View');
			Assets::clear_cache();
			Assets::add_js('underscore-min.js');
			Assets::add_js('jstz.min.js');
			Assets::add_js('calendar.min.js');
			Assets::add_js( $this->load->view('js/calendar/ready', array('total' => 100, 'navigation' => 'nav-calendar'), true),'inline');

			if ($this->input->is_ajax_request()) {
				$this->joborder->calendar_events();
			}else {
				Template::set($data);
				Template::render();
			}
		}
	}

	public function _format_dropdown($results,$key,$value,$def = ''){
      $options = $def == '' ? array('' => 'Please select ....') : array('' => $def);
      foreach ($results->result_array() as $rows){
          $options[$rows[$key]] = $rows[$value];
      }
    	return $options;
  }

  public function _format_dropdown_array($results,$def = ''){
      $options = $def == '' ? array('' => 'Please select ....') : array();
    foreach ($results as $keys => $values){
        $options[$keys] = $values;
    }
  	return $options;
  }

  public function _format_dropdown_ajax($results,$key,$value){
	$options = array();
      foreach ($results->result_array() as $rows){
        array_push($options, array('id' => $rows[$key], 'name' => $rows[$value]));
      }
    	return $options;
  }
}
