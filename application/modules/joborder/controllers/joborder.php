<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Joborder extends Admin_Controller {

  public function __construct() {
    parent::__construct();
    $this->load->library(array('form_validation', 'table', 'pagination'));
    $this->load->helper('form');
    $this->load->model('Joborder_Model', 'joborder', TRUE);
    $this->load->model('Setting/Reference_model', 'reference', TRUE);
    $this->load->model('Setting/ref_province_model', 'ref_province', TRUE);
    $this->load->vars(array(
      'title' => 'Joborders',
      'navigation' => 'nav-job'
    ));
  }

  // Search
  public function index() {
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.View');
    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->vars(array(
      'option' => array(
        's_company' => $this->_format_dropdown($this->reference->referensi_company(), 'companyID', 'companyName'),
        's_type' => $this->_format_dropdown($this->reference->referensi_employment_type(), 'EmploymentTypeID', 'EmploymentType'),
        's_country' => $this->_format_dropdown($this->reference->referensi_negara(), 'CountryCode', 'CountryName'),
        's_province' => $this->_format_dropdown($this->reference->referensi_provinsi(), 'ProvinceCode', 'ProvinceName'),
        's_business_area' => $this->_format_dropdown($this->reference->referensi_business_area(), 'BusinessID', 'BusinessArea')
      ),
      'refid' => $this->session->userdata('refid')
    ));

    Assets::clear_cache();
    Assets::add_module_css('joborder', 'custom.css');
    Assets::add_css('custom.dialog.css');
    Assets::add_js($this->load->view('js/get_joborder', array('total' => $this->joborder->count_all()), true), 'inline');
    Assets::add_js($this->load->view('js/acc_joborder', array('total' => $this->joborder->count_all()), true), 'inline');
    Assets::add_js($this->load->view('js/ready', array('total' => $this->joborder->count_all()), true), 'inline');

    $data = array(
      's_company' => array('name' => 's_company',
        'id' => 's_company',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Company'
      ),
      's_type' => array('name' => 's_type',
        'id' => 's_type',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Employment Type'
      ),
      's_business_area' => array('name' => 's_business_area',
        'id' => 's_business_area',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Business Area'
      ),
      's_state' => array('name' => 's_state',
        'id' => 's_state',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'State'
      ),
      's_province' => array('name' => 's_province',
        'id' => 's_province',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Province'
      ),
    );

    if ($this->input->is_ajax_request()) {
      $this->joborder->record();
    }
    else {
      Template::set($data);
      Template::render();
    }
  }

  // Ubah Disamakan Dengan Hiring Bos
  public function add($template = null) {
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.Add');
    $title = empty($template) ? 'Create' : 'From Template';
    $record = empty($template) ? array() : (array) $this->joborder->get($template);
    $this->load->vars(array(
      'title' => 'Joborders' . '::' . $title,
      'in' => $id,
      'option' => array(
        'country' => $this->_format_dropdown($this->reference->referensi_negara(), 'CountryCode', 'CountryName'),
        'province' => $this->_format_dropdown($this->reference->referensi_provinsi(), 'ProvinceCode', 'ProvinceName'),
        'business_area' => $this->_format_dropdown($this->reference->referensi_business_area(), 'BusinessID', 'BusinessArea'),
        'company' => $this->_format_dropdown($this->reference->referensi_company(), 'companyID', 'companyName'),
      ),
      'record' => $record,
      'refid' => $this->session->userdata('refid')
    ));

    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }
    else {
      $this->auth->_have_permission('Dashboard.Joborder.Add');
      if ($this->input->is_ajax_request()) {
        $this->joborder->add($record[$this->joborder->_id]);
      }
      else {
        $data = array(
          'name' => array(
            'name' => 'title',
            'id' => 'title',
            'class' => 'input-xxlarge',
            'type' => 'text',
            'value' => set_value('title', $record[$this->joborder->_title]),
            'label' => 'Title'
          ),
          'ba' => array('name' => 'ba',
            'id' => 'ba',
            'class' => 'selectpicker show-tick show-menu-arrow',
            'selected' => $record[$this->joborder->_ba],
            'label' => 'Business Area'
          ),
          'company' => array(
            'name' => 'company',
            'id' => 'company',
            'class' => 'selectpicker show-tick show-menu-arrow',
            'selected' => $record[$this->joborder->_company],
            'label' => 'Company'
          ),
          'owner' => array(
            'name' => 'owner',
            'id' => 'owner',
            'class' => 'input-xxlarge',
            'type' => 'text',
            'value' => set_value('owner', $record[$this->joborder->_owner]),
            'label' => 'Owner'
          ),
          'country' => array(
            'name' => 'country',
            'id' => 'country',
            'class' => 'selectpicker show-tick show-menu-arrow',
            'selected' => $record[$this->joborder->_country],
            'label' => 'Country'
          ),
          'province' => array(
            'name' => 'province',
            'id' => 'province',
            'class' => 'selectpicker show-tick show-menu-arrow',
            'selected' => $record[$this->joborder->_province],
            'label' => 'Province'
          ),
          'address' => array(
            'name' => 'address',
            'id' => 'address',
            'class' => 'input-xxlarge',
            'value' => set_value('address', $record[$this->joborder->_address]),
            'label' => 'Address'
          ),
          'city' => array(
            'name' => 'city',
            'id' => 'city',
            'class' => 'input-xxlarge',
            'type' => 'text',
            'value' => set_value('city', $record[$this->joborder->_city]),
            'label' => 'City'
          ),
          'zipcode' => array(
            'name' => 'zipcode',
            'id' => 'zipcode',
            'class' => 'input-xxlarge',
            'type' => 'text',
            'value' => set_value('zipcode', $record[$this->joborder->_zipcode]),
            'label' => 'Zipcode'
          ),
        );
        Assets::clear_cache();
        Assets::add_module_css('joborder', 'custom.css');
        Assets::add_css('custom.dialog.css');
        Assets::add_js('jquery.bootstrap.wizard.js');
        Assets::add_js('jquery.validate.min.js');
        Assets::add_js('bootstrap-select.js');
        Assets::add_js($this->load->view('js/add_joborder', '', true), 'inline');
        Template::set($data);
        Template::render();
      }
    }
  }

  public function action_acc($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_acc();
    }
    else {
      
    }
  }

  public function action_cl($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_cl();
    }
    else {
      
    }
  }

  public function action_cv($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_cv();
    }
    else {
      
    }
  }

  public function action_delete($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_delete();
    }
    else {
      return $this->load->view('action/delete', $data, TRUE);
    }
  }

  public function action_detail($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_detail();
    }
    else {
      return $this->load->view('action/detail', $data, TRUE);
    }
  }

  public function action_email($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_email();
    }
    else {
      return $this->load->view('action/mail', $data, TRUE);
    }
  }

  public function action_prev($id = null) {
    $data = array(
      'option' => array(
        'email_template' => $this->_format_dropdown($this->joborder->referensi_email(), 'EmailTmplID', 'EmailTmplSubject')
      ),
      'email' => array('name' => 'email',
        'id' => 'email',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Email'
      ),
    );
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_prev();
    }
    else {
      return $this->load->view('action/prev', $data, TRUE);
    }
  }

  public function action_next($id = null) {
    $data = array(
      'startdate' => date('d-m-Y'),
      'option' => array(
        'email_template' => $this->_format_dropdown($this->joborder->referensi_email(), 'EmailTmplID', 'EmailTmplSubject')
      ),
      'email' => array('name' => 'email',
        'id' => 'email',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Email'
      ),
    );

    if ($this->input->is_ajax_request()) {
      $this->joborder->action_next();
    }
    else {
      return $this->load->view('action/next', $data, TRUE);
    }
  }

  public function action_note($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_note();
    }
    else {
      return $this->load->view('action/note', $data, TRUE);
    }
  }

  public function action_stop($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_stop();
    }
    else {
      return $this->load->view('action/stop', $data, TRUE);
    }
  }

  public function action_template($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_template();
    }
  }

  public function action_view($id = null) {
    if ($this->input->is_ajax_request()) {
      $this->joborder->action_view();
    }
    else {
      
    }
  }

  // Ga Kepake
  public function candidate($id = null, $apply_id = 0, $step = null, $status = null) {
    $this->load->vars(array(
      'title' => 'Dashboard',
      'navigation' => 'nav-dashboard'
    ));
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Candidate.View');
    $record = empty($id) ? array() : (array) $this->joborder->get($id);
    $this->load->vars(array(
      'title' => "Jobs Candidate::{$record[$this->joborder->_title]}",
      'record' => $record
    ));
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }
    else {
      //set the flash data error message if there is one
      $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      Assets::clear_cache();
      Assets::add_module_css('joborder', 'custom.css');
      Assets::add_css('custom.dialog.css');
      Assets::add_js(array(
        'jquery.raty.min.js',
        'jquery.validate.min.js',
        'jquery.hotkeys.js',
        'google-code-prettify/prettify.js',
        'bootstrap-wysiwyg.js'
      ));
      Assets::add_js($this->load->view('js/get_candidate', array('total' => $this->joborder->count_all(), 'id' => $id, 'apply_id' => $apply_id, 'step' => $step, 'status' => $status), true), 'inline');
      Assets::add_js($this->load->view('js/get_action', array('total' => $this->joborder->count_all()), true), 'inline');
      Assets::add_js($this->load->view('js/get_action_post', array('total' => $this->joborder->count_all()), true), 'inline');
      Assets::add_js($this->load->view('js/ready', array('total' => $this->joborder->count_all(), 'one' => true), true), 'inline');
      if ($this->input->is_ajax_request()) {
        $this->joborder->record_candidate();
      }
      else {
        Template::set($data);
        Template::render();
      }
    }
  }

  // Ga Kepake
  public function candidate2($id = null, $apply_id = 0, $step = null, $status = null) {
    $jobo = empty($id) ? array() : $this->joborder->get($id);
    $this->load->vars(array(
      'title' => '',
      'crumbs' => $this->_format_crumbs($jobo),
      'jobs' => $jobo
    ));

    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Candidate.View');
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }
    else {
      //set the flash data error message if there is one
      $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

      Assets::clear_cache();
      Assets::add_css(array(
        'custom.dialog.css',
        'fyra.css'));
      Assets::add_module_css('joborder', 'custom.css');
      Assets::add_js(array(
        'jquery.raty.min.js',
        'jquery.validate.min.js',
        'jquery.hotkeys.js',
        'google-code-prettify/prettify.js',
        'bootstrap-wysiwyg.js'
      ));
      Assets::add_js($this->load->view('js/get_candidate2', array('total' => $this->joborder->count_all(), 'id' => $id, 'apply_id' => $apply_id, 'step' => $step, 'status' => $status), true), 'inline');
      Assets::add_js($this->load->view('js/get_action', array('total' => $this->joborder->count_all()), true), 'inline');
      Assets::add_js($this->load->view('js/get_action_post', array('total' => $this->joborder->count_all()), true), 'inline');
      Assets::add_js($this->load->view('js/ready', array('total' => $this->joborder->count_all(), 'one' => false), true), 'inline');
      if ($this->input->is_ajax_request()) {
        $this->joborder->record_candidate2();
      }
      else {
        Template::set($data);
        Template::render();
      }
    }
  }

  public function detail($id = null, $jobo = array()) {
    $jobo = empty($id) ? array() : $this->joborder->get($id);
    $this->load->vars(array(
      'title' => '',
      'crumbs' => $this->_format_crumbs($jobo)
    ));

    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.Detail');
    Assets::clear_cache();
    Assets::add_css(array(
      'custom.dialog.css',
      'fyra.css'));
    Assets::add_module_css('joborder', 'custom.css');
    $data = array(
      'jobs' => $jobo
    );

    if ($this->input->is_ajax_request()) {
      
    }
    else {
      Template::set($data);
      Template::render();
    }
  }

  public function delete($id = null) {
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.Delete');

    $delete = $this->joborder->delete_joborder($id);
    if ($delete) {
      Template::set_message($this->joborder->messages(), 'success');
      redirect("joborder/index", 'refresh');
    }
    else {
      Template::set_message($this->joborder->errors(), 'error');
      redirect("joborder/index", 'refresh');
    }
  }

  public function form($id = null) {
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.Form');
    $title = empty($id) ? 'Create' : 'Edit';
    $prior = array('low' => 'Low', 'medium' => 'Medium', 'high' => 'High');
    $this->load->vars(array(
      'title' => 'Joborders' . '::' . $title,
      'in' => $id,
      'option' => array(
        'minedu' => $this->_format_dropdown($this->reference->referensi_jenjang_pendidikan(), 'EducationLevelCode', 'EducationLevelName'),
        'country' => $this->_format_dropdown($this->reference->referensi_negara(), 'CountryCode', 'CountryName'),
        'province' => $this->_format_dropdown($this->reference->referensi_provinsi(), 'ProvinceCode', 'ProvinceName'),
        'selection_step' => $this->_format_dropdown($this->reference->referensi_selection_step(), 'IDSteps', 'Steps', 'no'),
        'jobprocess_status' => $this->_format_dropdown($this->reference->referensi_jobprocess_status(), 'StatusProcessID', 'StatusProcess'),
        'employment_type' => $this->_format_dropdown($this->reference->referensi_employment_type(), 'EmploymentTypeID', 'EmploymentType'),
        'business_area' => $this->_format_dropdown($this->reference->referensi_business_area(), 'BusinessID', 'BusinessArea'),
        'company' => $this->_format_dropdown($this->reference->referensi_company(), 'companyID', 'companyName'),
        'jobprocess_flow' => $this->_format_dropdown($this->reference->referensi_jobprocess_flow(), 'FlowProcessID', 'FlowProcess'),
        'priority' => $this->_format_dropdown_array($prior)
      ),
      'refid' => $this->session->userdata('refid')
    ));

    Assets::clear_cache();
    Assets::add_module_css('joborder', 'custom.css');
    Assets::add_css('custom.dialog.css');
    Assets::add_js('jquery.bootstrap.wizard.js');
    Assets::add_js('jquery.validate.min.js');
    Assets::add_js('bootstrap-tokenfield.min.js');
    Assets::add_js($this->load->view('js/wizard/ready', array('jin' => $id), true), 'inline');
    Template::set($data);
    Template::render();
  }

  public function form_wizard1($id = null) {
    $record = (array) $this->joborder->get($id);
    if ($this->input->is_ajax_request()) {
      $this->joborder->form_wizard(1, $record[$this->joborder->_id]);
    }
    else {
      $data = array(
        'title' => array(
          'name' => 'title',
          'id' => 'title',
          'class' => 'input-xxlarge',
          'type' => 'text',
          'value' => set_value('title', $record[$this->joborder->_title]),
          'label' => 'Title'
        ),
        'ba' => array('name' => 'ba',
          'id' => 'ba',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'selected' => $record[$this->joborder->_ba],
          'label' => 'Business Area'
        ),
        'company' => array(
          'name' => 'company',
          'id' => 'company',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'selected' => $record[$this->joborder->_company],
          'label' => 'Company'
        ),
        'owner' => array(
          'name' => 'owner',
          'id' => 'owner',
          'class' => 'input-xxlarge',
          'type' => 'text',
          'value' => set_value('owner', $record[$this->joborder->_owner]),
          'label' => 'Owner'
        ),
        'country' => array(
          'name' => 'country',
          'id' => 'country',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'selected' => $record[$this->joborder->_country],
          'label' => 'Country'
        ),
        'province' => array(
          'name' => 'province',
          'id' => 'province',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'selected' => $record[$this->joborder->_province],
          'label' => 'Province'
        ),
        'address' => array(
          'name' => 'address',
          'id' => 'address',
          'class' => 'input-xxlarge',
          'value' => set_value('address', $record[$this->joborder->_address]),
          'label' => 'Address'
        ),
        'city' => array(
          'name' => 'city',
          'id' => 'city',
          'class' => 'input-xxlarge',
          'type' => 'text',
          'value' => set_value('city', $record[$this->joborder->_city]),
          'label' => 'City'
        ),
        'zipcode' => array(
          'name' => 'zipcode',
          'id' => 'zipcode',
          'class' => 'input-xxlarge',
          'type' => 'text',
          'value' => set_value('zipcode', $record[$this->joborder->_zipcode]),
          'label' => 'Zipcode'
        ),
        'startdate' => $record[$this->joborder->_startdate],
        'enddate' => $record[$this->joborder->_enddate],
        'refid' => $this->session->userdata('refid')
      );
      return $this->load->view('wizard/job_detail', $data, TRUE);
    }
  }

  public function form_wizard2($id = null) {
    $record = (array) $this->joborder->get($id);
    if ($this->input->is_ajax_request()) {
      $this->joborder->form_wizard(2, $record[$this->joborder->_id]);
    }
    else {
      $keywords = !empty($record[$this->joborder->_keywords]) ? implode(unserialize($record[$this->joborder->_keywords]), ',') : '';
      $data = array(
        'jobid' => array(
          'name' => 'jobid',
          'id' => 'jobid',
          'class' => 'input-xlarge',
          'type' => 'text',
          'value' => set_value('jobid', $record[$this->joborder->_id]),
          'label' => 'Job ID',
          'readonly' => 'true'
        ),
        'description' => array(
          'name' => 'description',
          'id' => 'description',
          'class' => 'input-xxlarge',
          'value' => set_value('description', $record[$this->joborder->_description]),
          'label' => 'Description'
        ),
        'note' => array(
          'name' => 'note',
          'id' => 'note',
          'class' => 'input-xxlarge',
          'value' => set_value('note', $record[$this->joborder->_note]),
          'label' => 'Note'
        ),
        'keywords' => array(
          'name' => 'keywords',
          'id' => 'keywords',
          'class' => 'tokenfield input-xxlarge',
          'type' => 'text',
          'value' => set_value('keywords', $keywords),
          'label' => 'Keywords'
        ),
      );
      return $this->load->view('wizard/job_description', $data, TRUE);
    }
  }

  public function form_wizard3($id = null) {
    $record = (array) $this->joborder->get($id);
    if ($this->input->is_ajax_request()) {
      $this->joborder->form_wizard(3, $record[$this->joborder->_id]);
    }
    else {
      $data = array(
        'opening' => array(
          'name' => 'opening',
          'id' => 'opening',
          'class' => 'input-xlarge',
          'type' => 'text',
          'value' => set_value('opening', $record[$this->joborder->_opening]),
          'label' => 'Headcount Allocation'
        ),
        'timeline' => array(
          'name' => 'timeline',
          'id' => 'timeline',
          'class' => 'input-xlarge',
          'type' => 'text',
          'value' => set_value('timeline'),
          'label' => 'Timeline',
          'append' => '<i class="icon-calendar"></i>'
        ),
        'minedu' => array(
          'name' => 'minedu',
          'id' => 'minedu',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'label' => 'Minimum Education',
          'selected' => $record[$this->joborder->_minedu],
        ),
        'minexe' => array(
          'name' => 'minexe',
          'id' => 'minexe',
          'class' => 'input-xlarge',
          'type' => 'text',
          'value' => set_value('minexe', $record[$this->joborder->_minexe]),
          'label' => 'Minimum Experience'
        ),
      );
      return $this->load->view('wizard/job_requirement', $data, TRUE);
    }
  }

  public function form_wizard4($id = null) {
    $record = (array) $this->joborder->get($id);
    if ($this->input->is_ajax_request()) {
      $this->joborder->form_wizard(4, $record[$this->joborder->_id]);
    }
    else {
      $data = array(
        'type' => array(
          'name' => 'type',
          'id' => 'type',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'label' => 'Type',
          'selected' => $record[$this->joborder->_type],
        ),
        'step' => array(
          'name' => 'step',
          'id' => 'step',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'label' => 'Selection Step',
          'selected' => $this->joborder->get_selection_step($record[$this->joborder->_id]),
        ),
        'status' => array(
          'name' => 'status',
          'id' => 'status',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'label' => 'Progress Flow',
          'selected' => $record[$this->joborder->_status],
        ),
        'priority' => array(
          'name' => 'priority',
          'id' => 'priority',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'label' => 'Priority',
          'selected' => $record[$this->joborder->_priority],
        ),
      );
      return $this->load->view('wizard/job_setting', $data, TRUE);
    }
  }

  public function form_wizard5($id = null) {
    $record = (array) $this->joborder->get($id);
    if ($this->input->is_ajax_request()) {
      $this->joborder->form_wizard(5, $record[$this->joborder->_id]);
    }
    else {
      $data = array(
        'exsalarymin' => array(
          'name' => 'exsalarymin',
          'id' => 'exsalarymin',
          'class' => 'input-xxlarge',
          'type' => 'text',
          'value' => set_value('exsalarymin', $record[$this->joborder->_exsalarymin]),
          'label' => 'Minimum Expected Salary'
        ),
        'exsalarymax' => array(
          'name' => 'exsalarymax',
          'id' => 'exsalarymax',
          'class' => 'input-xxlarge',
          'type' => 'text',
          'value' => set_value('exsalarymax', $record[$this->joborder->_exsalarymax]),
          'label' => 'Maximum Expected Salary'
        ),
        'facilities' => array(
          'name' => 'facilities',
          'id' => 'facilities',
          'class' => 'selectpicker show-tick show-menu-arrow',
          'label' => 'Facilities',
          'selected' => $record[$this->joborder->_facilities],
        ),
      );
      return $this->load->view('wizard/job_other', $data, TRUE);
    }
  }

  public function page($id = null, $jobo = array()) {
    $jobo = empty($id) ? array() : $this->joborder->get($id);
    $this->load->vars(array(
      'title' => '',
      'crumbs' => $this->_format_crumbs($jobo)
    ));

    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.Page');
    Assets::clear_cache();
    Assets::add_css(array(
      'custom.dialog.css',
      'fyra.css'));
    Assets::add_module_css('joborder', 'custom.css');
    Assets::add_js($this->load->view('js/ready', array('two' => TRUE), true), 'inline');
    Assets::add_js($this->load->view('js/get_page', array('two' => TRUE), true), 'inline');
    $data = array(
      'jobs' => $jobo
    );

    if ($this->input->is_ajax_request()) {
      
    }
    else {
      Template::set($data);
      Template::render();
    }
  }

  // Samain Dengan HB
  public function template() {
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.Template');
    $this->load->vars(array(
      'title' => 'Joborders::Template',
      'option' => array(
        's_company' => $this->_format_dropdown($this->reference->referensi_company(), 'companyID', 'companyName'),
        's_type' => $this->_format_dropdown($this->reference->referensi_employment_type(), 'EmploymentTypeID', 'EmploymentType'),
        's_country' => $this->_format_dropdown($this->reference->referensi_negara(), 'CountryCode', 'CountryName'),
        's_province' => $this->_format_dropdown($this->reference->referensi_provinsi(), 'ProvinceCode', 'ProvinceName'),
        's_business_area' => $this->_format_dropdown($this->reference->referensi_business_area(), 'BusinessID', 'BusinessArea')
      )
    ));

    $data = array(
      's_company' => array('name' => 's_company',
        'id' => 's_company',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Company'
      ),
      's_type' => array('name' => 's_type',
        'id' => 's_type',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Employment Type'
      ),
      's_business_area' => array('name' => 's_business_area',
        'id' => 's_business_area',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Business Area'
      ),
      's_state' => array('name' => 's_state',
        'id' => 's_state',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'State'
      ),
      's_province' => array('name' => 's_province',
        'id' => 's_province',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Province'
      ),
    );
    //set the flash data error message if there is one
    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    Assets::clear_cache();
    Assets::add_module_css('joborder', 'custom.css');
    Assets::add_css('custom.dialog.css');
    Assets::add_js('masonry.pkgd.min.js');
    Assets::add_js($this->load->view('js/get_template', array('total' => $this->joborder->count_all()), true), 'inline');
    Assets::add_js($this->load->view('js/ready', array('total' => $this->joborder->count_all()), true), 'inline');

    if ($this->input->is_ajax_request()) {
      $this->joborder->record_template();
    }
    else {
      Template::set($data);
      Template::render();
    }
  }

  public function rating_avg() {
    if ($this->input->is_ajax_request()) {
      $this->joborder->rating_avg();
      echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
  }

  public function rating_process() {
    if ($this->input->is_ajax_request()) {
      $this->joborder->rating_process();
    }
  }

  public function search() {
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }

    $this->auth->_have_permission('Dashboard.Joborder.Search');
    $this->load->vars(array(
      'title' => 'Joborders::Search',
      'option' => array(
        's_company' => $this->_format_dropdown($this->reference->referensi_company(), 'companyID', 'companyName'),
        's_type' => $this->_format_dropdown($this->reference->referensi_employment_type(), 'EmploymentTypeID', 'EmploymentType'),
        's_country' => $this->_format_dropdown($this->reference->referensi_negara(), 'CountryCode', 'CountryName'),
        's_province' => $this->_format_dropdown($this->reference->referensi_provinsi(), 'ProvinceCode', 'ProvinceName'),
        's_business_area' => $this->_format_dropdown($this->reference->referensi_business_area(), 'BusinessID', 'BusinessArea')
      )
    ));

    $data = array(
      's_company' => array('name' => 's_company',
        'id' => 's_company',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Company'
      ),
      's_type' => array('name' => 's_type',
        'id' => 's_type',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Employment Type'
      ),
      's_business_area' => array('name' => 's_business_area',
        'id' => 's_business_area',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Business Area'
      ),
      's_state' => array('name' => 's_state',
        'id' => 's_state',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'State'
      ),
      's_province' => array('name' => 's_province',
        'id' => 's_province',
        'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
        'label' => 'Province'
      ),
    );
    //set the flash data error message if there is one
    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    Assets::clear_cache();
    Assets::add_module_css('joborder', 'custom.css');
    Assets::add_css('custom.dialog.css');
    Assets::add_js(
        $this->load->view('js/get_search', array(
          'total' => $this->joborder->count_all()), true), 'inline');
    Assets::add_js($this->load->view('js/ready', array('total' => $this->joborder->count_all()), true), 'inline');

    if ($this->input->is_ajax_request()) {
      $this->joborder->record_search();
    }
    else {
      Template::set($data);
      Template::render();
    }
  }

  public function select_ba() {
    if ($this->input->is_ajax_request()) {
      $result = $this->_format_dropdown_ajax($this->reference->referensi_company_by_ba($this->input->post('id')), 'companyID', 'companyName');
      echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }
  }

  public function _format_crumbs($jobo) {

    $company = $this->joborder->populate('company');
    $state = $this->joborder->populate('state');
    $country = $this->joborder->populate('country');
    $result = <<<EOS
  <ul id='crumbs'>
  	<li data-sel="0"><a>Job: {$jobo->joborderTitle} {$company[$jobo->joborderCompanyID]} in {$state[$jobo->joborderProvinceID]}</a><br /></li>
  	<li data-sel="1"><a>1<br /><span class="label" style="margin-top:4px;margin-left:4px;">seleksi cv</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="2"><a>2<br /><span class="label" style="margin-top:4px;margin-left:4px;">interv hr</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="3"><a>3<br /><span class="label" style="margin-top:4px;margin-left:4px;">interv user</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="4"><a>4<br /><span class="label" style="margin-top:4px;margin-left:4px;">interv adv</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="6"><a>6<br /><span class="label" style="margin-top:4px;margin-left:4px;">test bidang</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="8"><a>8<br /><span class="label" style="margin-top:4px;margin-left:4px;">psikotes</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="9"><a>9<br /><span class="label" style="margin-top:4px;margin-left:4px;">medical</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="10"><a>10<br /><span class="label" style="margin-top:4px;margin-left:4px;">persentasi</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
    <li data-sel="11"><a>11<br /><span class="label" style="margin-top:4px;margin-left:4px;">hiring</span><br /><i class="icon-stop font-error"></i> <i class="icon-pause font-warning"></i> <i class="icon-play font-success"></i><br />0 0 0</span></a></li>
  </ul>
EOS;
    return $result;
  }

  public function _format_dropdown($results, $key, $value, $def = '') {
    $options = $def == '' ? array('' => 'Please select ....') : array('' => $def);
    foreach ($results->result_array() as $rows) {
      $options[$rows[$key]] = $rows[$value];
    }
    return $options;
  }

  public function _format_dropdown_array($results, $def = '') {
    $options = $def == '' ? array('' => 'Please select ....') : array();
    foreach ($results as $keys => $values) {
      $options[$keys] = $values;
    }
    return $options;
  }

  public function _format_dropdown_ajax($results, $key, $value) {
    $options = array();
    foreach ($results->result_array() as $rows) {
      array_push($options, array('id' => $rows[$key], 'name' => $rows[$value]));
    }
    return $options;
  }

  public function dashboard() {
    if (!$this->auth->logged_in()) {
      redirect($this->config->item('base_url'), 'refresh');
    }
    $this->auth->_have_permission('Dashboard.Joborder.Dashboard');
    $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

    $this->load->vars(array(
      'title' => "Job Orders::Dashboard",
      'option' => array(
        's_company' => $this->_format_dropdown($this->reference->referensi_company(), 'companyID', 'companyName'),
        's_type' => $this->_format_dropdown($this->reference->referensi_employment_type(), 'EmploymentTypeID', 'EmploymentType'),
        's_country' => $this->_format_dropdown($this->reference->referensi_negara(), 'CountryCode', 'CountryName'),
        's_province' => $this->_format_dropdown($this->reference->referensi_provinsi(), 'ProvinceCode', 'ProvinceName'),
        's_business_area' => $this->_format_dropdown($this->reference->referensi_business_area(), 'BusinessID', 'BusinessArea')
      )
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
        $this->load->view('js/get_dashboard', array(
          'total' => $this->joborder->count_all()), true), 'inline');
    Assets::add_js($this->load->view('js/um/ready', array('total' => $this->joborder->count_all()), true), 'inline');
    Assets::add_js('jquery.validate.min.js');

    if ($this->input->is_ajax_request()) {
      $this->joborder->record();
    }
    else {
      Template::set_view('joborder/index');
      Template::set($data);
      Template::render();
    }
  }

}
