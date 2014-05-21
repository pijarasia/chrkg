<?php

if (!defined('BASEPATH'))
  exit('No direct script access allowed');

class Joborder_Model extends MY_Model {

  /**
   * Init protected variable for model
   *
   * @var string
   * */
  //  Table
  protected $_table = 'tbmJoborder';
  protected $_table_a = 'tbmApplicant';
  protected $_table_ja = 'tbtJobApply';
  protected $_table_au = 'tbaAppUserList';
  protected $_table_ss = 'tbtSelectionSteps';
  protected $_table_jpa = 'tbtJobProcessApply';
  protected $primary_key = 'joborderID';
  protected $soft_delete = FALSE;
  protected $soft_delete_key = 'deleted';
  protected $_temporary_with_deleted = FALSE;
  //
  //
  // Columns Shortcut
  //
  //
	public $_id = 'joborderID';
  public $_title = 'joborderTitle';
  public $_ba = 'joborderBusinessAreaID';
  public $_company = 'joborderCompanyID';
  // public $_department	 = 	'joborderCompanyDepartmentID';
  // public $_contact		 =  'joborderContact';
  public $_country = 'joborderCountryID';
  public $_city = 'joborderCity';
  public $_province = 'joborderProvinceID';
  public $_address = 'joborderAddress';
  public $_zipcode = 'joborderZipCode';
  // public $_recruiter	 =  'joborderRecruiter';
  public $_owner = 'joborderOwner';
  public $_startdate = 'joborderStartDate';
  public $_enddate = 'joborderEndDate';
  public $_created = 'joborderCreated';
  public $_modified = 'joborderUpdated';
  public $_duration = 'joborderDuration';
  public $_exsalarymax = 'joborderMaxRate';
  public $_exsalarymin = 'joborderMinRate';
  public $_facilities = 'joborderFacilitiesID';
  public $_type = 'joborderType';
  public $_step = 'joborderSelectionStepID';
  public $_status = 'joborderProgressStatusID';
  public $_opening = 'joborderOpenings';
  public $_description = 'joborderDescription';
  public $_note = 'jobOrderNotes';
  public $_reqruitments = 'joborderReqruitments';
  public $_keywords = 'joborderKeywords';
  public $_minexe = 'joborderExperienceMin';
  public $_minedu = 'joborderLevelEducationMinID';
  public $_priority = 'joborderPriority';
  public $_employment_type = 'joborderEmploymentType';
  public $_sources = 'joborderCandidateSources';
  // Tabel Selection Step
  public $_step_id = 'stepsID';
  public $_step_name = 'steps';
  public $_step_job_id = 'stepsJobID';
  public $_step_selection_id = 'stepsSelectionID';
  public $_step_order = 'stepsOrder';
  public $refid = '';
  private $_aj = array('status' => NULL, 'response' => NULL, 'data' => NULL);

  /**
   * Holds an array of tables used
   *
   * @var string
   * */
  public $tables = array();

  /**
   * Identity
   *
   * @var string
   * */
  public $identity;

  /**
   * Response
   *
   * @var string
   * */
  protected $response = NULL;

  /**
   * message (uses lang file)
   *
   * @var string
   * */
  protected $messages;

  /**
   * error message (uses lang file)
   *
   * @var string
   * */
  protected $errors;

  /**
   * error start delimiter
   *
   * @var string
   * */
  protected $error_start_delimiter;

  /**
   * error end delimiter
   *
   * @var string
   * */
  protected $error_end_delimiter;

  /**
   * email variables
   *
   * @var string
   * */
  protected $mailer, $transporter;
  protected $now, $appl;

  public function __construct() {
    parent::__construct();
    $this->load->helper('cookie');
    $this->load->library('session');
    $this->lang->load('joborder/joborder');
    $this->load->model('pagination_model', 'pag', TRUE);

    $this->now = base_url() . 'joborder/';
    $this->appl = base_url() . "applicant/";
    $this->refid = $this->session->userdata("refid");

    //initialize messages and error
    $this->messages = array();
    $this->errors = array();
    $this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
    $this->message_end_delimiter = $this->config->item('message_end_delimiter', 'ion_auth');
    $this->error_start_delimiter = $this->config->item('error_start_delimiter', 'ion_auth');
    $this->error_end_delimiter = $this->config->item('error_end_delimiter', 'ion_auth');

    $this->load->config('swiftmailer', TRUE);
    $email_config = $this->config->item('email_config', 'swiftmailer');

    $this->transporter = Swift_SmtpTransport::newInstance($email_config['smtp'], $email_config['port'], $email_config['secure'])
        ->setUsername($email_config['username'])
        ->setPassword($email_config['password']);
  }

  public function action_acc() {
    $form_data = array('id');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $query = $this->db->select('tbtJobApply.*')
        ->where('tbtJobApply.ApplyID', (int) $data['id'])
        ->get('tbtJobApply');

    if ($query->num_rows() > 0) {
      $row = $query->row_array();
      $this->_aj['data'] = array(
        'path' => base_url() . 'archives/cover_letter/',
        'doc' => $row['applyCoverLetter']
      );
      $this->_aj['status'] = 'success';
    }
    else {
      $this->_aj['status'] = 'error';
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_cl() {
    $form_data = array('id');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $query = $this->db->select('tbtJobApply.*')
        ->where('tbtJobApply.ApplyID', (int) $data['id'])
        ->get('tbtJobApply');

    if ($query->num_rows() > 0) {
      $row = $query->row_array();
      $this->_aj['data'] = array(
        'path' => base_url() . 'archives/cover_letter/',
        'doc' => $row['applyCoverLetter']
      );
      $this->_aj['status'] = 'success';
    }
    else {
      $this->_aj['status'] = 'error';
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_cv() {
    $form_data = array('id');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $query = $this->db->select('tbtJobApply.*')
        ->where('tbtJobApply.ApplyID', (int) $data['id'])
        ->get('tbtJobApply');

    if ($query->num_rows() > 0) {
      $row = $query->row_array();
      $this->_aj['data'] = array(
        'path' => base_url() . 'archives/curriculum_vitae/',
        'doc' => $row['applyCurriculumVitae']
      );
      $this->_aj['status'] = 'success';
    }
    else {
      $this->_aj['status'] = 'error';
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_delete() {
    $form_data = array('id', 'jobid', 'form', 'action');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    if ($data['action'] == 'loads') {
      $this->_aj['record'] = $this->get_process_apply((int) $data['id']);
      $this->_aj['last_step'] = $this->get_last_selection_step((int) $data['id']);
      $this->_aj['last_step']['name'] = $this->get_name_selection_step($this->_aj['last_step']['stepsID']);
      $this->_aj['order'] = $this->get_max_order_selection_step((int) $data['jobid']);
      if ((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1 <= (int) $this->_aj['order']['max_value']) {
        $this->_aj['next_step'] = $this->get_unique_selection_step_by_order((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1, (int) $data['jobid']);
        $this->_aj['next_step']['name'] = $this->get_name_selection_step($this->_aj['next_step']['stepsID']);
      }
      $this->_aj['status'] = 'success';
    }
    else {
      foreach ($data['form'] as $keys => $values)
        $form[$keys] = $values;

      $memo = array(
        'applyStatus' => 0
      );
      $result = $this->db->where('applyID', $id)->count_all_results($this->_table_ja) > 0;
      if (count($result) == 0) {
        $this->_aj['status'] = 'error';
        $this->_aj['message'] = "Move Job Apply {$id} to Pool Unsuccessful";
      }
      else {
        $this->db->update($this->_table_ja, $memo, array('applyID' => $id));
        $return = $this->db->affected_rows() == 1;
        if ($return) {
          $this->_aj['status'] = 'success';
          $this->_aj['message'] = "Move Job Apply {$id} to Pool Successful";
        }
        else {
          $this->_aj['status'] = 'error';
          $this->_aj['message'] = "Move Job Apply {$id} to Pool Unsuccessful";
        }
      }
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_detail() {
    $form_data = array('id', 'jobid');
    $this->load->model('jobapply/jobapply_model', 'jobapply', TRUE);
    $this->load->model('welcome/vacancy_model', 'vacancy', TRUE);
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $tracking = $this->jobapply->tracking((int) $data['id']);
    $t = '';
    if ($tracking->num_rows() > 0) {
      //tampung dulu yang ada
      $temp = array();
      $i = 0;
      foreach ($tracking->result() as $row) {
        $temp[$i]->step = $row->processSelectionID;
        $temp[$i]->date = $row->processDate;
        $temp[$i]->place = $row->processPlace;
        $temp[$i]->status = $row->StatusProcess;
        $i++;
      }
      $row = $tracking->row();
      $vacan = $this->vacancy->details($row->joborderID);
      $row2 = $vacan->row();
      $t .= '<table class="table tblDalam">
                        <tr>
                            <td style="width: 200px">Perusahaan</td>
                            <td style="width: 5px">:</td>
                            <td>' . $row->companyName . '</td>
                        </tr>';
      $t .= '<tr>
                            <td>Posisi</td>
                            <td>:</td>
                            <td>' . $row->joborderTitle . '</td>
                        </tr>';
      $t .= '<tr>
                            <td>Periode Pembukaan Lowongan</td>
                            <td>:</td>
                            <td>' . date("d M Y H:i:s", strtotime("$row2->joborderStartDate")) . ' s.d ' . date("d M Y H:i:s", strtotime("$row2->joborderEndDate")) . '</td>
                        </tr>';
      $t .= '<tr>
                            <td>Tanggal Lamar</td>
                            <td>:</td>
                            <td>' . date("d M Y H:i:s", strtotime("$row->applyDate")) . '</td>
                        </tr>';
      $t .= '</table>';
      $steps = $this->vacancy->get_all_steps((int) $data['jobid']);
      if ($steps->num_rows() > 0) {
        $t .= "<table class='table table-hover table-bordered table-striped'>";
        $t .= "<thead>
                                <tr>
                                    <th style='width: 20px;'>No</th>
                                    <th style='width: 180px;'>Proses</th>
                                    <th>Waktu</th>
                                    <th>Tempat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>";
        $i = 1;
        foreach ($steps->result() as $row3) {
          $wkt = "-";
          $tmpt = "-";
          $stts = "-";
          for ($j = 0; $j < count($temp); $j++) {
            if ($temp[$j]->step == $row3->stepsID) {
              if (trim($temp[$j]->date) != "")
                $wkt = date("d M Y H:i:s", strtotime($temp[$j]->date));

              if (trim($temp[$j]->place) != "")
                $tmpt = $temp[$j]->place;

              if (trim($temp[$j]->status) != "")
                $stts = $temp[$j]->status;
            }
          }
          $t .= '<tr>
                                <td>' . $i . '.</td>
                                <td>' . $row3->Steps . '</td>
                                <td>' . $wkt . '</td>
                                <td>' . $tmpt . '</td>
                                <td>' . $stts . '</td>
                            </tr>';
          $i++;
        }
        $t .= "</table>";
      }
    }
    $this->_aj['data'] = $t;
    $this->_aj['status'] = 'success';
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_email() {
    $form_data = array('id');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $this->_aj['status'] = 'success';
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_pdf() {
    $form_data = array('id');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $query = $this->db->select('tbtJobApply.*')
        ->where('tbtJobApply.ApplyID', (int) $data['id'])
        ->get('tbtJobApply');

    if ($query->num_rows() > 0) {
      $row = $query->row_array();
      $this->_aj['data'] = array(
        'path' => base_url() . 'archives/curriculum_vitae/',
        'doc' => $row['applyCurriculumVitae']
      );
      $this->_aj['status'] = 'success';
    }
    else {
      $this->_aj['status'] = 'error';
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_prev() {
    $form_data = array('id', 'jobid', 'form', 'action', 'body');

    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $this->config->load('swiftmailer');
    $email_config = $this->config->item('email_config', 'swiftmailer');

    if ($data['action'] == 'loads') {
      $this->_aj['last_step'] = $this->get_last_selection_step((int) $data['id']);
      $this->_aj['last_step']['name'] = $this->get_name_selection_step($this->_aj['last_step']['max_value']);
      $this->_aj['last_step']['rate'] = $this->get_rate_selection_step($this->_aj['last_step']['max_value']);
      $this->_aj['order'] = $this->get_max_order_selection_step((int) $data['jobid']);
      if ((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1 <= (int) $this->_aj['order']['max_value']) {
        $this->_aj['next_step'] = $this->get_unique_selection_step_by_order((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1, (int) $data['jobid']);
        $this->_aj['next_step']['name'] = $this->get_name_selection_step($this->_aj['next_step']['stepsID']);
      }
      $this->_aj['status'] = 'success';
    }
    else {
      foreach ($data['form'] as $keys => $values)
        $form[$keys] = $values;

      if ($form['action'] == 'email') {
        $applicant = $this->get_detail_applicant_by_apply($form['process_apply_id']);
        $date = $form['from_year'] . "-" . $form['from_month'] . "-" . $form['from_date'];
        $time = $form['from_hour'] . ":" . $from['minute'];

        $to = array(
          "{$applicant['AppUserListEmail']}" => "{$applicant['AppUserListFirstName']} {$applicant['AppUserListLastName']}"
        );
        $subject = $form['process_subject'];
        $body = $data['body'];

        $body = str_replace("[name]", "{{$applicant['AppUserListFirstName']} {$applicant['AppUserListLastName']}", $body);
        $body = str_replace("[where]", "{$form['process_place']}", $body);
        $body = str_replace("[when]", "{$date} {$time}", $body);
        $status = $this->_sendemail($to, $subject, $body);

        $this->db->update($this->_table_jpa, array('processDate' => date('Y-m-d'), 'processStatus' => 2, 'processPlace' => $form['process_place']), array('processID' => (int) $form['process_last_step']));

        if ($status) {
          $this->_aj['status'] = 'success';
          $this->_aj['message'] = "Email Send And Change Process Apply ID {$form['process_apply_id']} Successful";
        }
        else {
          $this->_aj['status'] = 'error';
          $this->_aj['message'] = "Email Send And Change Process Apply ID {$form['process_apply_id']} Unsuccessful";
        }
      }
      else {
        $result = $this->db->where('processApplyID', $form['process_apply_id'])->count_all_results($this->_table_jpa) > 0;
        if (count($result) == 0) {
          $this->_aj['status'] = 'error';
          $this->_aj['message'] = "Change Process Apply ID {$form['process_apply_id']} Unsuccessful 1";
        }
        else {
          $this->db->update($this->_table_jpa, array('processComment' => $form['process_comment'], 'processStatus' => 2), array('processID' => (int) $form['process_last_step']));
          $return = $this->db->affected_rows() == 1;
          if ($return) {
            $this->_aj['status'] = 'success';
            $this->_aj['message'] = "Change Process Apply ID {$form['process_apply_id']} Successful 2";
          }
          else {
            $this->_aj['status'] = 'error';
            $this->_aj['message'] = "Change Process Apply ID {$form['process_apply_id']} Unsuccessful 3";
          }
        }
      }
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_next() {
    $form_data = array('id', 'jobid', 'form', 'action', 'body');

    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $data['body'];

    if ($data['action'] == 'loads') {
      $this->_aj['record'] = $this->get_process_apply((int) $data['id']);
      $this->_aj['last_step'] = $this->get_last_selection_step((int) $data['id']);
      $this->_aj['last_step']['name'] = $this->get_name_selection_step($this->_aj['last_step']['stepsID']);
      $this->_aj['order'] = $this->get_max_order_selection_step((int) $data['jobid']);
      $this->_aj['last_step']['status'] = 1;
      if ((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1 <= (int) $this->_aj['order']['max_value']) {
        $this->_aj['next_step'] = $this->get_unique_selection_step_by_order((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1, (int) $data['jobid']);
        $this->_aj['next_step']['name'] = $this->get_name_selection_step($this->_aj['next_step']['stepsID']);
        $this->_aj['last_step']['status'] = 0;
      }
      $this->_aj['status'] = 'success';
    }
    else {
      foreach ($data['form'] as $keys => $values)
        $form[$keys] = $values;

      $result = $this->db->where('processApplyID', $form['process_apply_id'])->count_all_results($this->_table_jpa) > 0;
      $date = $form['from_year'] . "-" . $form['from_month'] . "-" . $form['from_date'];
      $time = $form['from_hour'] . ":" . $from['minute'];
      $where = $form['process_place'];

      if (count($result) == 0) {
        $this->_aj['status'] = 'error';
        $this->_aj['message'] = "Change Process Status Apply ID {$form['process_apply_id']} Unsuccessful";
      }
      else {
        $memo = array('processStatus' => 3);
        $memo2 = array('processApplyID' => $form['process_apply_id'], 'processSelectionID' => $form['process_next_step'], 'processDate' => date('Y-m-d'), 'processStatus' => 1, 'processPlace' => $form['processPlace']);
        $this->db->update($this->_table_jpa, $memo, array('processID' => $form['process_last_step']));
        $return = $this->db->affected_rows() == 1;

        if (!empty($form['process_next_step'])) {
          $this->db->insert($this->_table_jpa, $memo2);
        }

        if ($return) {
          $applicant = $this->get_detail_applicant_by_apply($form['process_apply_id']);
          $date = $form['from_year'] . "-" . $form['from_month'] . "-" . $form['from_date'];
          $time = $form['from_hour'] . ":" . $from['minute'];
          $to = array(
            "{$applicant['AppUserListEmail']}" => "{$applicant['AppUserListFirstName']} {$applicant['AppUserListLastName']}"
          );
          $subject = $form['process_subject'];
          $body = $data['body'];
          $body = str_replace("[name]", "{{$applicant['AppUserListFirstName']} {$applicant['AppUserListLastName']}", $body);
          $body = str_replace("[where]", "{$form['process_place']}", $body);
          $body = str_replace("[when]", "{$date} {$time}", $body);
          $status = $this->_sendemail($to, $subject, $body);
          if ($status) {
            $this->_aj['status'] = 'success';
            $this->_aj['message'] = "Email Send And Change Process Apply ID {$form['process_apply_id']} Successful";
          }
          else {
            $this->_aj['status'] = 'error';
            $this->_aj['message'] = "Email Send And Change Process Apply ID {$form['process_apply_id']} Unsuccessful";
          }
        }
        else {
          $this->_aj['status'] = 'error';
          $this->_aj['message'] = "Change Process Status Apply ID {$form['process_apply_id']} Unsuccessful";
        }
      }
    }

    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_note() {
    $form_data = array('id');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $query = $this->db->select('tbtJobProcessApply.*, tbrSelectionSteps.*')
        ->from('tbtJobProcessApply')
        ->join('tbrSelectionSteps', 'tbtJobProcessApply.processSelectionID = tbrSelectionSteps.IDSteps')
        ->where('tbtJobProcessApply.processApplyID', (int) $data['id'])
        ->get();
    $this->_aj['data'] = array();
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $n = 1;
        $this->_aj['data'][] = array(
          'order' => $n,
          'name' => $row['Steps'],
          'comment' => $row['processComment']
        );
        $n++;
      }
      $this->_aj['status'] = 'success';
    }
    else {
      $this->_aj['status'] = 'error';
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_stop() {
    $form_data = array('id', 'jobid', 'form', 'action');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    if ($data['action'] == 'loads') {
      $this->_aj['record'] = $this->get_process_apply((int) $data['id']);
      $this->_aj['last_step'] = $this->get_last_selection_step((int) $data['id']);
      $this->_aj['last_step']['name'] = $this->get_name_selection_step($this->_aj['last_step']['max_value']);
      $this->_aj['order'] = $this->get_max_order_selection_step((int) $data['jobid']);
      if ((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1 <= (int) $this->_aj['order']['max_value']) {
        $this->_aj['next_step'] = $this->get_unique_selection_step_by_order((int) $this->_aj['last_step']['unique']['stepsOrder'] + 1, (int) $data['jobid']);
        $this->_aj['next_step']['name'] = $this->get_name_selection_step($this->_aj['next_step']['stepsID']);
      }
      $this->_aj['status'] = 'success';
    }
    else {
      foreach ($data['form'] as $keys => $values)
        $form[$keys] = $values;

      $result = $this->db->where('processApplyID', $form['process_apply_id'])->count_all_results($this->_table_jpa) > 0;
      if (count($result) == 0) {
        $this->_aj['status'] = 'error';
        $this->_aj['message'] = "Change Process Status Apply ID {$form['process_apply_id']} Unsuccessful";
      }
      else {
        $memo = array('processStatus' => 4);
        $this->db->update($this->_table_jpa, $memo, array('processApplyID' => $form['process_apply_id']));
        $return = $this->db->affected_rows() == 1;
        if ($return) {
          $this->_aj['status'] = 'success';
          $this->_aj['message'] = "Change Process Status Apply ID {$form['process_apply_id']} Successful";
        }
        else {
          $this->_aj['status'] = 'error';
          $this->_aj['message'] = "Change Process Status Apply ID {$form['process_apply_id']} Unsuccessful";
        }
      }
    }
  }

  public function action_template() {
    $form_data = array('email_id');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $detail = $this->get_detail_email($data['email_id']);
    $this->_aj['subject'] = $detail['EmailTmplSubject'];
    $this->_aj['content'] = $detail['EmailTmplContent'];
    $this->_aj['status'] = 'success';
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function action_view() {
    $form_data = array('email');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $this->session->set_userdata("view_profil", $data['email']);
    $this->_aj['status'] = 'success';
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function add($template = null) {
    $form_data = array('title', 'ba', 'company', 'owner', 'country', 'province', 'address', 'city', 'zipcode');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);
    $memo = array(
      $this->_title => $data['title'],
      $this->_ba => $data['ba'],
      $this->_company => $data['company'],
      $this->_owner => $data['owner'],
      $this->_country => $data['country'],
      $this->_city => $data['city'],
      $this->_province => $data['province'],
      $this->_address => $data['address'],
      $this->_city => $data['city'],
      $this->_zipcode => $data['zipcode']
    );
    if ($this->check_joborder($data['title'])) {
      $this->_aj['status'] = 'error';
      $this->_aj['message'] = $this->lang->line('joborder_creation_unsuccessful');
      $this->_aj['id'] = null;
    }
    else {
      if ($template !== null) {
        $record = (array) $this->joborder->get($template);
        $records = array(
          $this->_title => $record['title'],
          $this->_ba => $record['ba'],
          $this->_company => $record['company'],
          $this->_owner => $record['owner'],
          $this->_country => $record['country'],
          $this->_city => $record['city'],
          $this->_province => $record['province'],
          $this->_address => $record['address'],
          $this->_city => $record['city'],
          $this->_zipcode => $record['zipcode'],
          $this->_description => $record['description'],
          $this->_note => $record['note'],
          // $this->_keywords => serialize(explode(',', $record['keywords']
          $this->_opening => $record['opening'],
          // $this->_timeline => $record['timeline'],
          $this->_minedu => $record['minedu'],
          $this->_minexe => $record['minexe'],
          $this->_type => $record['type'],
          // $this->_step => serialize($record['step']),
          $this->_status => $record['status'],
          $this->_exsalarymin => $record['exsalarymin'],
          $this->_exsalarymax => $record['exsalarymax']
        );
        $this->db->insert($this->_table, $records);
      }
      else {
        $this->db->insert($this->_table, $memo);
      }
      $this->_aj['id'] = (int) $this->_last_id();
      $this->_aj['data'] = $data;
      $this->_aj['status'] = 'success';
      $this->_aj['message'] = $this->lang->line('joborder_creation_successful');
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function add_selection_step($selection_step = array(), $id = null) {
    $i = 1;
    foreach ($selection_step as $row) {
      $records = array($this->_step_job_id => $id, $this->_step_selection_id => (int) $row, $this->_step_order => $i++);
      $this->db->insert($this->_table_ss, $records);
    }
  }

  public function calendar_events() {
    $form_data = array('from', 'to');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $from = $data['from'] / 1000;
    $to = $data['to'] / 1000;
    $from = date('Y-m-d H:i:s', $from);
    $to = date('Y-m-d H:i:s', $to);
    $this->db->join('tbtSelectionSteps', 'tbtJobProcessApply.processSelectionID = tbtSelectionSteps.stepsID')
        ->join('tbrSelectionSteps', 'tbtSelectionSteps.stepsSelectionID = tbrSelectionSteps.IDSteps')
        ->join('tbtJobApply', 'tbtJobProcessApply.processApplyID = tbtJobApply.applyID')
        ->join('tbmJoborder', 'tbtJobApply.applyJobID = tbmJoborder.joborderID')
        ->join('tbmCompany', 'tbmJoborder.joborderCompanyID = tbmCompany.companyID')
        ->join('tbaAppUserList', 'tbtJobApply.applyApplicantID = tbaAppUserList.AppUserListID')
        ->where("processDate BETWEEN '{$from}' AND '{$to}'")
        ->where("processStatus", 2);
    !empty($this->refid) ? $this->db->where("tbmJoborder.{$this->_company}", $this->refid) : '';
    $query = $this->db->get('tbtJobProcessApply');

    $url = base_url() . 'joborder/candidate/';
    if ($query->num_rows() > 0) {
      $aj['success'] = 1;
      $aj['result'] = array();
      foreach ($query->result_array() as $rows) {
        array_push($aj['result'], array(
          'id' => "{$rows['processID']}",
          'title' => "{$rows['Steps']} for {$rows['AppUserListFirstName']} {$rows['AppUserListLastName']} from vacancy {$rows['joborderTitle']} at {$rows['companyName']}",
          'url' => "{$url}{$rows['applyJobID']}/{$rows['applyID']}",
          'class' => "event-warning",
          'start' => strtotime($rows['processDate']) . '000',
          'end' => strtotime($rows['processDate']) . '000',
        ));
      }
    }
    else {
      $aj['success'] = 1;
      $aj['result'] = array();
    }
    echo json_encode($aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function check_joborder($title = '') {
    if (empty($title)) {
      return FALSE;
    }

    return $this->db->where('joborderTitle', $title)
            ->count_all_results($this->_table) > 0;
  }

  public function delete_joborder($id) {
    $this->db->trans_begin();

    $this->db->delete($this->_table, array('joborderID' => $id));

    if ($this->db->trans_status() === FALSE) {
      $this->db->trans_rollback();
      $this->set_error('delete_unsuccessful');
      return FALSE;
    }

    $this->db->trans_commit();
    $this->set_message('delete_successful');
    return TRUE;
  }

  public function delete_selection_step($id = null, $target = array(), $result = array('update' => array(), 'insert' => array(), 'delete' => array(), 'updates' => array())) {
    $query = $this->db->where(array($this->_step_job_id => $id))->get($this->_table_ss)->result_array();

    $target = array_map('intval', $target);

    if (count($query) > 0) {
      foreach ($query as $rows) {
        if (in_array($rows[$this->_step_selection_id], $target)) {
          array_push($result['update'], array('id' => $rows[$this->_step_id], 'sel' => $rows[$this->_step_selection_id]));
          $result['updates'][] = $rows[$this->_step_selection_id];
        }
        else {
          array_push($result['delete'], array('id' => $rows[$this->_step_id], 'sel' => $rows[$this->_step_selection_id]));
        }
      }
      count($result['updates']) && $result['insert'] = array_diff($target, $result['updates']);

      if (count($result['delete']) > 0) {
        foreach ($result['delete'] as $rows) {
          $this->db->delete($this->_table_ss, array($this->_step_id => $rows['id']));
        }
      }
      count($result['insert']) > 0 && $this->add_selection_step((array) $result['insert'], $id);
      $this->update_selection_step($id);
    }
    else {
      $this->add_selection_step($target, $id);
    }
    return TRUE;
  }

  public function update_selection_step($id = null, $result = array(), $n = 1) {
    $query = $this->db->where(array($this->_step_job_id => $id))->get($this->_table_ss)->result_array();
    foreach ($query as $rows) {
      array_push($result, array('id' => $rows[$this->_step_id], 'sel' => $rows[$this->_step_selection_id]));
    }
    $result = $this->_sort_by_key_value($result, 'sel');
    foreach ($result as $rows) {
      $this->db->update($this->_table_ss, array($this->_step_order => $n), array($this->_step_id => $rows['id']));
      $n++;
    }
    return TRUE;
  }

  public function form_wizard($type = 1, $id = null) {
    $data = array();
    switch ($type) {
      case 1:
        $form_data = array('title', 'ba', 'company', 'owner', 'country', 'province', 'address', 'city', 'zipcode');
        foreach ($form_data as $val)
          $data[$val] = $this->input->post($val);
        $memo = array(
          $this->_title => $data['title'],
          $this->_ba => $data['ba'],
          $this->_company => $data['company'],
          $this->_owner => $data['owner'],
          $this->_country => $data['country'],
          $this->_city => $data['city'],
          $this->_province => $data['province'],
          $this->_address => $data['address'],
          $this->_city => $data['city'],
          $this->_zipcode => $data['zipcode']
        );
        break;
      case 2:
        $form_data = array('jobid', 'description', 'note', 'keywords');
        foreach ($form_data as $val)
          $data[$val] = $this->input->post($val);
        $memo = array(
          $this->_description => $data['description'],
          $this->_note => $data['note'],
          $this->_keywords => serialize(explode(',', $data['keywords']))
        );
        break;
      case 3:
        $form_data = array('opening', 'from_date', 'from_month', 'from_year', 'to_date', 'to_month', 'to_year', 'minedu', 'minexe');
        foreach ($form_data as $val)
          $data[$val] = $this->input->post($val);
        $from = $data['from_year'] . "-" . $data['from_month'] . "-" . $data['from_date'];
        $to = $data['to_year'] . "-" . $data['to_month'] . "-" . $data['to_date'];
        $memo = array(
          $this->_opening => $data['opening'],
          $this->_startdate => date('Y-m-d H:i:s', strtotime($from)),
          $this->_enddate => date('Y-m-d H:i:s', strtotime($to)),
          $this->_minedu => $data['minedu'],
          $this->_minexe => $data['minexe'],
        );
        break;
      case 4:
        $form_data = array('type', 'step', 'status', 'priority');
        foreach ($form_data as $val)
          $data[$val] = $this->input->post($val);
        $selection_step = serialize($data['step']);
        $memo = array(
          $this->_type => $data['type'],
          $this->_status => $data['status'],
          $this->_priority => $data['priority']
        );
        break;
      case 5:
        $form_data = array('exsalarymin', 'exsalarymax');
        foreach ($form_data as $val)
          $data[$val] = $this->input->post($val);
        $memo = array(
          $this->_exsalarymin => $data['exsalarymin'],
          $this->_exsalarymax => $data['exsalarymax']
        );
        break;
      default:
        # code...
        break;
    }

    $result = $this->db->where($this->_id, $id)->count_all_results($this->_table) > 0;
    if (count($result) == 0) {
      $this->_aj['status'] = 'error';
      $this->_aj['message'] = $this->lang->line('joborder_change_unsuccessful');
    }
    else {
      if ($type == 4 && !empty($selection_step)) {
        $selection_step = unserialize($selection_step);
        $selection_step = $this->delete_selection_step($id, $selection_step);
      }

      $this->db->update($this->_table, $memo, array($this->_id => $id));
      $return = $this->db->affected_rows() == 1;
      if ($return) {
        $this->_aj['status'] = 'success';
        $this->_aj['message'] = $this->lang->line('joborder_change_successful');
        $this->_aj['data'] = $data;
      }
      else {
        $this->_aj['status'] = 'error';
        $this->_aj['message'] = $this->lang->line('joborder_change_unsuccessful');
      }
    }
    echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function format_get_selection_step_with_info($results = array()) {
    $t = "";
    $class = array(1 => 'label-inverse', 2 => 'label-warning', 3 => 'label-success', 4 => 'label-important', 5 => 'label-inverse');
    if (count($results) > 0) {
      foreach ($results as $rows) {
        $t .= "<span class='label {$class[$rows['process_status']]}'>{$rows['process_steps']}</span><br />";
      }
    }

    return $t;
  }

  protected function get_detail_applicant($id = null) {
    $row = array();
    $query = $this->db
        ->where("AppUserListID", $id)
        ->get("tbaAppUserList");
    if ($query->num_rows() > 0) {
      $row = $query->row_array();
    }
    return $row;
  }

  protected function get_detail_applicant_by_apply($id = null, $row = array()) {
    $query = $this->db
        ->where("processApplyID", $id)
        ->join("tbtJobApply", "tbtJobProcessApply.processApplyID = tbtJobApply.applyID")
        ->join("tbaAppUserList", "tbtJobApply.applyApplicantID = tbaAppUserList.AppUserListID")
        ->get("tbtJobProcessApply");
    if ($query->num_rows() > 0) {
      $row = $query->row_array();
    }
    return $row;
  }

  protected function get_detail_email($id = null, $row = array()) {
    $query = $this->db
        ->where("EmailTmplID", $id)
        ->get("tbrEmailTemplate");
    if ($query->num_rows() > 0) {
      $row = $query->row_array();
    }
    return $row;
  }

  public function get_last_selection_step($id = null) {
    $query = $this->db->where('processApplyID', $id)
        ->get('tbtJobProcessApply');

    $result = array();
    $order = array();
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $result[$row['processID']] = $row['processSelectionID'];
      }
    }
    $index = array_keys($result, max($result));
    return array('max_value' => $result[$index[0]], 'max_index' => $index[0], 'unique' => $this->get_unique_selection_step($result[$index[0]]));
  }

  public function get_max_order_selection_step($id = null) {
    $query = $this->db->where($this->_step_job_id, $id)
        ->get($this->_table_ss);
    ChromePhp::log($this->db->last_query());
    $result = array();
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $result[$row[$this->_step_id]] = $row[$this->_step_order];
      }
    }
    count($result) > 0 && $index = array_keys($result, max($result));
    $result[$index[0]] = isset($result[$index[0]]) ? $result[$index[0]] : '';
    $index[0] = isset($index[0]) ? $index[0] : '';
    return array('max_value' => $result[$index[0]], 'max_index' => $index[0]);
  }

  public function get_process_apply($id = null, $results = array()) {
    $query = $this->db->where('processApplyID', $id)
        ->get('tbtJobProcessApply');

    if ($query->num_rows() > 0) {
      $results = $query->row_array();
    }
    return $results;
  }

  public function get_selection_step($id = null, $results = array()) {
    $query = $this->db->where($this->_step_job_id, $id)
        ->get($this->_table_ss);
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $row) {
        $results[] = $row[$this->_step_selection_id];
      }
    }
    return $results;
  }

  public function get_selection_step_with_info($id = null, $jobid = null, $results = array()) {
    $query = $this->db
        ->select('jp.*, tss.*, ss.*')
        ->from('tbtJobProcessApply AS jp')
        ->join('tbtSelectionSteps AS tss', 'jp.processSelectionID = tss.stepsID', 'left')
        ->join('tbrSelectionSteps AS ss', 'tss.stepsSelectionID = ss.IDSteps', 'left')
        ->where('processApplyID', $id)
        ->where('stepsJobID', $jobid)
        ->get();
    if ($query->num_rows() > 0) {
      foreach ($query->result_array() as $rows) {
        array_push($results, array(
          'process_id' => $rows['processID'],
          'process_apply_id' => $rows['processApplyID'],
          'process_selection_id' => $rows['processSelectionID'],
          'process_selection_id' => $rows['processSelectionID'],
          'process_order' => $rows['stepsOrder'],
          'process_steps' => $rows['Steps'],
          'process_status' => $rows['processStatus'],
        ));
      }
    }
    return $results;
  }

  public function get_unique_selection_step($id = null, $results = array()) {
    $query = $this->db->where($this->_step_id, $id)
        ->get($this->_table_ss);
    if ($query->num_rows() > 0) {
      $results = $query->row_array();
    }
    return $results;
  }

  public function get_unique_selection_step_by_order($id = null, $jobid = null, $results = array()) {
    $query = $this->db
        ->where($this->_step_job_id, $jobid)
        ->where($this->_step_order, $id)
        ->get($this->_table_ss);
    if ($query->num_rows() > 0) {
      $results = $query->row_array();
    }
    return $results;
  }

  public function get_name_selection_step($id = null, $results = '') {
    $query = $this->db->where('IDSteps', $id)
        ->get('tbrSelectionSteps');
    if ($query->num_rows() > 0) {
      $results = $query->row_array();
      $results = $results['Steps'];
    }

    return $results;
  }

  public function get_rate_selection_step($id = null, $results = '') {
    $query = $this->db->where('processID', $id)
        ->get($this->_table_jpa);
    if ($query->num_rows() > 0) {
      $results = $query->row_array();
      $results = $results['processRate'];
    }

    return $results;
  }

  public function get_applicant_by_selection_step($id = null, $job_id = null, $status = null) {
    $query = $this->db
        ->join($this->_table_ja, "{$this->_table}.{$this->primary_key} = {$this->_table_ja}.applyJobID")
        ->join($this->_table_au, "{$this->_table_ja}.applyApplicantID = {$this->_table_au}.AppUserListID")
        ->join($this->_table_jpa, "{$this->_table_ja}.applyID = {$this->_table_jpa}.processApplyID")
        ->join('tbtSelectionSteps', "{$this->_table_jpa}.processSelectionID = tbtSelectionSteps.stepsID")
        ->where(
            array(
              "{$this->_table_ja}.applyJobID" => $job_id,
              "tbtSelectionSteps.stepsSelectionID" => $id,
              "{$this->_table_jpa}.processStatus" => $status
        ))
        ->order_by("{$this->_table_au}.AppUserListFirstName")
        ->get($this->_table)
        ->result_array();
    return $query;
  }

  public function populate($type = null) {
    $this->load->model('Setting/Reference_model', 'reference', TRUE);
    switch ($type) {
      case 'ba':
        return $this->populate_array($this->reference->referensi_area_bisnis()->result_array(), 'BusinessID', 'BusinessArea');
        break;
      case 'state':
        return $this->populate_array($this->reference->referensi_provinsi()->result_array(), 'ProvinceCode', 'ProvinceName');
        break;
      case 'company':
        return $this->populate_array($this->reference->referensi_company()->result_array(), 'companyID', 'companyName');
        break;
      case 'employment_type':
        return $this->populate_array($this->reference->referensi_employment_type()->result_array(), 'EmploymentTypeID', 'EmploymentType');
        break;
      case 'country':
        return $this->populate_array($this->reference->referensi_negara()->result_array(), 'CountryCode', 'CountryName');
        break;
      case 'sources':
        return $this->populate_array($this->reference->referensi_candidate_sources()->result_array(), 'CandidateSourcesID', 'CandidateSourcesName');
        break;
      case 'flow':
        return $this->populate_array($this->reference->referensi_candidate_sources()->result_array(), 'FlowProcessID', 'FlowProcess');
        break;
      case 'owner':
        # code...
        break;
    }
  }

  public function populate_array($target = array(), $key, $value, $results = array()) {
    foreach ($target as $rows) {
      $results[$rows[$key]] = $rows[$value];
    }
    return $results;
  }

  public function populate_applicant_by_selection_step($id = null, $all = array(), $result = array('black' => '', 'yellow' => '', 'red' => '', 'green' => '')) {

    $url = base_url();
    $all = Underbar\ArrayImpl::chain($all)->where(array('stepsSelectionID' => $id));
    $black = Underbar\ArrayImpl::chain($all)->where(array('processStatus' => 1));
    $yellow = Underbar\ArrayImpl::chain($all)
        ->where(array('processStatus' => 2));
    $red = Underbar\ArrayImpl::chain($all)
        ->where(array('processStatus' => 4));
    $green = Underbar\ArrayImpl::chain($all)
        ->where(array('processStatus' => 3));

    if (count($black) > 0) {
      $sum = count($black);
      if (count($black) > 1) {
        $result['black'] .= "<a href='{$url}joborder/candidate/{$job_id}/0/{$rows['processSelectionID']}/{$rows['processStatus']}'><span class='label label-default'>{$sum} Candidates<i class='icon-male align-right'></i></span></a>";
      }
      else {
        foreach ($black as $rows) {
          $result['black'] .= "<a href='{$url}joborder/candidate/{$job_id}/{$rows['applyID']}' rel='tooltip' title='{$rows['AppUserListFirstName']}  {$rows['AppUserListLastName']} {$rows['AppUserListPhone']} {$rows['AppUserListEmail']}'><span class='label label-default'>{$rows['AppUserListFirstName']} {$rows['AppUserListLastName']} 10</span></a>";
        }
      }
      $result['black'] .= '<br />';
    }

    if (count($yellow) > 0) {
      $sum = count($yellow);
      if (count($yellow) > 1) {
        $result['yellow'] .= "<a href='{$url}joborder/candidate/{$job_id}/0/{$rows['processSelectionID']}/{$rows['processStatus']}'><span class='label label-warning'>{$sum} Candidates<i class='icon-male align-right'></i></span></a>";
      }
      else {
        foreach ($yellow as $rows) {
          $result['yellow'] .= "<a href='{$url}joborder/candidate/{$job_id}/{$rows['applyID']}' rel='tooltip' title='{$rows['AppUserListFirstName']}  {$rows['AppUserListLastName']} {$rows['AppUserListPhone']} {$rows['AppUserListEmail']}'><span class='label label-warning'>{$rows['AppUserListFirstName']}  {$rows['AppUserListLastName']} 10</span></a>";
        }
      }
      $result['yellow'] .= '<br />';
    }

    if (count($red) > 0) {
      $sum = count($red);
      if (count($red) > 1) {
        $result['red'] .= "<a href='{$url}joborder/candidate/{$job_id}/0/{$rows['processSelectionID']}/{$rows['processStatus']}'><span class='label label-important'>{$sum} Candidates<i class='icon-male align-right'></i></span></a>";
      }
      else {
        foreach ($red as $rows) {
          $result['red'] .= "<a href='{$url}joborder/candidate/{$job_id}/{$rows['applyID']}' rel='tooltip' title='{$rows['AppUserListFirstName']}  {$rows['AppUserListLastName']} {$rows['AppUserListPhone']} {$rows['AppUserListEmail']}'><span class='label label-important'>{$rows['AppUserListFirstName']}  {$rows['AppUserListLastName']} 10</span></a>";
        }
      }
      $result['red'] .= '<br />';
    }

    if (count($green) > 0) {
      $sum = count($green);
      if (count($green) > 1) {
        $result['green'] .= "<a href='{$url}joborder/candidate/{$job_id}/0/{$rows['processSelectionID']}/{$rows['processStatus']}'><span class='label label-success'>{$sum} Candidates<i class='icon-male align-right'></i></span></a>";
      }
      else {
        foreach ($green as $rows) {
          $result['green'] .= "<a href='{$url}joborder/candidate/{$job_id}/{$rows['applyID']}' rel='tooltip' title='{$rows['AppUserListFirstName']}  {$rows['AppUserListLastName']} {$rows['AppUserListPhone']} {$rows['AppUserListEmail']}'><span class='label label-success'>{$rows['AppUserListFirstName']}  {$rows['AppUserListLastName']} 10</span></a>";
        }
      }
      $result['green'] .= '<br />';
    }
    return $result['black'] . $result['yellow'] . $result['green'] . $result['stop'];
  }

  public function rating_process() {
    $form_data = array('apply_id', 'process_id', 'score');
    foreach ($form_data as $val)
      $data[$val] = $this->input->post($val);

    $memo = array(
      'processRate' => $data['score']
    );
    $result = $this->db->where('processID', $data['process_id'])->count_all_results($this->_table_jpa) > 0;
    if (count($result) == 0) {
      $result['status'] = 'error';
    }
    else {
      $this->db->update($this->_table_jpa, $memo, array('processID' => $data['process_id']));
      $return = $this->db->affected_rows() == 1;
      if ($return) {
        $result = $this->db->where(array('processApplyID' => $data['apply_id']))->where('processRate IS NOT NULL')->get($this->_table_jpa)->result_array();
        if (count($result) > 0) {
          $n = 1;
          foreach ($result as $rows) {
            $rate[] = $rows['processRate'];
            $n++;
          }
          $avg = array_sum($rate) / ($n - 1);
          $this->db->update($this->_table_ja, array('applyRate' => $avg), array('applyID' => $data['apply_id']));
          $result['avg'] = $avg;
        }
      }
      $result['status'] = 'success';
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function referensi_email() {
    $query = $this->db
        ->where('EmailTmplGroup', 11)
        ->like('EmailTmplSubject', 'Kompas Career', 'after')
        ->get('tbrEmailTemplate');
    return $query;
  }

  public function record() {
    $input = array('dataperpage', 'query', 'curpage', 'skey', 'stype');

    // asign value automaticaly for $input
    foreach ($input as $val)
      $$val = $this->input->post($val);

    isset($query) or $query = json_decode($query, true);
    foreach ($query as $key => $value) {
      $$key = $value;
    }

    $start = $curpage * $dataperpage;
    $end = $start + $dataperpage;

    $total = $this->record_count($s_title, $s_company, $s_owner, $s_employment_type, $s_state, $s_city, $s_end);
    $npage = ceil($total / $dataperpage);

    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';
    !empty($s_company) ? $this->db->like($this->_company, $this->db->escape_str($s_company)) : '';
    !empty($s_owner) ? $this->db->like($this->_owner, $this->db->escape_str($s_owner)) : '';
    !empty($s_employment_type) ? $this->db->like($this->_employment_type, $this->db->escape_str($s_employment_type)) : '';
    !empty($s_state) ? $this->db->like($this->_state, $this->db->escape_str($s_state)) : '';
    !empty($s_city) ? $this->db->like($this->_city, $this->db->escape_str($s_city)) : '';
    !empty($s_start) ? $this->db->like($this->_start, $this->db->
                    escape_str($s_start)) : '';
    !empty($s_end) ? $this->db->like($this->_end, $this->db->
                    escape_str($s_end)) : '';
    !empty($this->refid) ? $this->db->where($this->_company, $this->refid) : '';
    // Order By
    switch ($skey) {
      case '_title':
        $this->db->order_by($this->_title, $stype);
        break;
      case '_company':
        $this->db->order_by($this->_company, $stype);
        break;
      case '_owner':
        $this->db->order_by($this->_owner, $stype);
        break;
      case '_state':
        $this->db->order_by($this->_state, $stype);
        break;
      case '_city':
        $this->db->order_by($this->_city, $stype);
        break;
      case '_employment_type':
        $this->db->order_by($this->_employment_type, $stype);
        break;
      case '_start':
        $this->db->order_by($this->_start, $stype);
        break;
      case '_end':
        $this->db->order_by($this->_end, $stype);
        break;
      default:
        $this->db->order_by($this->_title, 'ASC');
        break;
    }

    $record = $this->db
        ->limit($dataperpage, $start)
        ->get($this->_table);

    $url = base_url() . 'joborder/';
    $this->pag->_pagination_init("{$url}index", $total, $dataperpage, $curpage + 1);
    $result = array(
      'data' => array(),
      'pagination' => '',
      'numpage' => $npage - 1,
      'npage' => $npage,
      'start' => $start,
      'end' => $dataperpage,
      'pagination' => $this->pagination->create_links(),
    );
    $company = $this->populate('company');
    $state = $this->populate('state');
    $ba = $this->populate('ba');
    $employment_type = $this->populate('employment_type');
    if ($record->num_rows() > 0) {
      foreach ($record->result_array() as $row) {
        $action['edit'] = $this->auth->_allowed('Dashboard.Joborder.Form.Edit') ? "<a class='btn btn-small btn-success' href='{$url}form/{$row[$this->_id]}' rel='tooltip' title='Edit'><i class='icon-pencil'></i></a>" : '';
        $action['delete'] = $this->auth->_allowed('Dashboard.Joborder.Delete') ? "<a class='btn btn-small btn-success' rel='tooltip' title='Delete' href='{$url}delete/{$row[$this->_id]}'><i class='icon-trash'></i></a>" : '';
        $action['acc'] = $this->auth->_allowed('Dashboard.Joborder.Status') ? "<a onclick='action_acc(\"{$row[$this->_id]}\", \"{$url}action_acc/{$row[$this->_id]}\",\"loads\")' class='btn btn-small btn-success actions' rel='tooltip' title='ACC' id='action_acc-{$row[$this->_id]}' data-target='#accModal'><i class='icon-microphone'></i></a>" : '';

        $result['data'][] = array(
          'checkbox' => "<input type='checkbox' name='id[]' id='id' value='{$row[$this->_id]}'>",
          'name' => "<a href='{$this->now}candidate/{$row[$this->_id]}'>{$row[$this->_title]}</a>",
          'jobs' => $row[$this->_opening],
          'company' => $company[(int) $row[$this->_company]],
          'state' => $state[$row[$this->_province]],
          'city' => $row[$this->_city],
          'employment_type' => $employment_type[$row[$this->_type]],
          'start' => $row[$this->_startdate],
          'end' => $row[$this->_enddate],
          'business_area' => $ba[$row[$this->_ba]],
          'action' => "<div class='btn-group'>{$action['edit']}{$action['delete']}{$action['acc']}</div>"
        );
      }
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function record_count($s_title = '', $s_company = '', $s_owner = '', $s_employment_type = '', $s_state = '', $s_city = '', $s_start = '', $s_end = '') {
    // Where (query)
    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';
    !empty($s_company) ? $this->db->like($this->_company, $this->db->escape_str($s_company)) : '';
    !empty($s_owner) ? $this->db->like($this->_owner, $this->db->escape_str($s_owner)) : '';
    !empty($s_employment_type) ? $this->db->like($this->_employment_type, $this->db->escape_str($s_employment_type)) : '';
    !empty($s_state) ? $this->db->like($this->_state, $this->db->escape_str($s_state)) : '';
    !empty($s_city) ? $this->db->like($this->_city, $this->db->escape_str($s_city)) : '';
    !empty($s_start) ? $this->db->like($this->_start, $this->db->
                    escape_str($s_start)) : '';
    !empty($s_end) ? $this->db->like($this->_end, $this->db->
                    escape_str($s_end)) : '';
    !empty($this->refid) ? $this->db->where($this->_company, $this->refid) : '';

    $total = $this->count_all_results($this->_table);
    return $total;
  }

  public function record_candidate() {
    $input = array('ids', 'dataperpage', 'query', 'curpage', 'skey', 'stype', 'apply_id', 'step', 'status');

    // asign value automaticaly for $input
    foreach ($input as $val)
      $$val = $this->input->post($val);

    isset($query) or $query = json_decode($query, true);
    foreach ($query as $key => $value) {
      $$key = $value;
    }

    $start = $curpage * $dataperpage;
    $end = $start + $dataperpage;

    $total = $this->record_candidate_count($s_title, $step, $apply_id, $status, $ids);
    $npage = ceil($total / $dataperpage);

    // Where (query)
    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';
    // Order By
    switch ($skey) {
      case '_name':
        $this->db->order_by("{$this->_table_au}.AppUserListFirstName", $stype);
        break;
      case '_dom':
        $this->db->order_by("{$this->_table_a}.aplAddressCity", $stype);
        break;
      case '_age':
        $this->db->order_by("{$this->_table_a}.aplDateOfBirth", $stype);
        break;
      case '_rate':
        $this->db->order_by("{$this->_table_ja}.applyRate", $stype);
        break;
      case '_created':
        $this->db->order_by("{$this->_table_ja}.applyDate", $stype);
        break;
      default:
        $this->db->order_by("{$this->_table_a}.aplPersonID", 'ASC');
        break;
    }

    $this->db
        ->select("{$this->_table_a}.* , {$this->_table_ja}.*, {$this->_table_au}.*")
        ->from($this->_table_a)
        ->join($this->_table_ja, "{$this->_table_a}.aplPersonID = {$this->_table_ja}.applyApplicantID")
        ->join($this->_table_au, "{$this->_table_a}.aplPersonID = {$this->_table_au}.AppUserListID");

    if (!empty($step)) {
      $this->db
          ->join($this->_table_jpa, "{$this->_table_ja}.applyID = {$this->_table_jpa}.processApplyID")
          ->where("{$this->_table_jpa}.processSelectionID", $this->db->escape_str($step));
      if (!empty($data['status'])) {
        $this->db->where("{$this->_table_jpa}.processStatus", $this->db->escape_str($status));
      }
    }

    (!empty($apply_id) && $apply_id != 0) ? $this->db->where("{$this->_table_ja}.applyID", $this->db->escape_str($apply_id)) : '';

    $record = $this->db->where("{$this->_table_ja}.applyJobID", $ids)
            ->limit($dataperpage, $start)->get();

    $now = base_url() . "joborder/";
    $this->pag->_pagination_init("{$now}candidate", $total, $dataperpage, $curpage + 1);
    $result = array(
      'data' => array(),
      'pagination' => '',
      'numpage' => $npage - 1,
      'npage' => $npage,
      'start' => $start,
      'end' => $dataperpage,
      'pagination' => $this->pagination->create_links(),
    );

    if ($record->num_rows() > 0) {
      foreach ($record->result() as $row) {
        $age = date('Y-m-d', strtotime($row->aplDateOfBirth));
        $last_step = $this->get_last_selection_step($row->applyID);
        $steps = $this->get_selection_step_with_info($row->applyID, $row->applyJobID);
        // $js=htmlspecialchars(json_encode($serial));
        //

	        $action['cv'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.CV') ? "<a onclick='action_cv(\"{$row->applyID}\", \"{$this->now}action_cv/{$row->applyID}\")' class='btn' rel='tooltip' title='Curriculum Vitae' id='action_cv-{$row->applyID}' data-target='#cvModal'><i class='icon-paper-clip'></i></a>" : '';
        $action['cl'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.CL') ? "<a onclick='action_cl(\"{$row->applyID}\", \"{$this->now}action_cl/{$row->applyID}\")' class='btn' rel='tooltip' title='Cover Letter' id='action_cl-{$row->applyID}' data-target='#clModal'><i class='icon-unlink'></i></a>" : '';
        $action['note'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Note') ? "<a onclick='action_note(\"{$row->applyID}\", \"{$this->now}action_note/{$row->applyID}\")' class='btn' rel='tooltip' title='Notes' id='action_note-{$row->applyID}' data-target='#noteModal'><i class='icon-info'></i></a>" : '';
        $action['detail'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Detail') ? "<a onclick='action_detail(\"{$row->applyID}\", \"{$row->applyJobID}\",\"{$this->now}action_detail/{$row->applyID}\")' class='btn' rel='tooltip' title='Detail' id='action_detail-{$row->applyID}' data-target='#detailModal'><i class='icon-male'></i></a>" : '';
        $action['prev'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Prev') ? "<a onclick='action_prev(\"{$row->applyID}\",\"{$row->applyJobID}\", \"{$this->now}action_prev/{$row->applyID}\",\"loads\")' class='btn actions' rel='tooltip' title='Process Step' id='action_prev-{$row->applyID}' data-target='#prevModal'><i class='icon-pause'></i></a>" : '';
        $action['next'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Next') ? "<a onclick='action_next(\"{$row->applyID}\",\"{$row->applyJobID}\", \"{$this->now}action_next/{$row->applyID}\",\"loads\")' class='btn actions' rel='tooltip' title='Next Step' id='action_next-{$row->applyID}' data-target='#nextModal'><i class='icon-step-forward'></i></a>" : '';
        $action['stop'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Stop') ? "<a onclick='action_stop(\"{$row->applyID}\", \"{$row->applyJobID}\", \"{$this->now}action_stop/{$row->applyID}\",\"loads\")' class='btn actions' rel='tooltip' title='Stop' id='action_stop-{$row->applyID}' data-target='#stopModal'><i class='icon-stop'></i></a>" : '';
        $action['delete'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Delete') ? "<a onclick='action_delete(\"{$row->applyID}\", \"{$this->now}action_delete/{$row->applyID}\",\"{$row->applyJobID}\",\"loads\")' rel='tooltip' title='Delete' class='btn actions' id='action_delete-{$row->applyID}' data-target='#deleteModal'><i class='icon-trash'></i></a>" : '';
        $result['data'][] = array(
          'checkbox' => "<input type='checkbox' name='id[]' id='id' value='{$row->applyID}'>",
          'id' => $row->applyID,
          'name' => "<a style='cursor:pointer;' onclick='action_view(\"{$row->AppUserListEmail}\", \"{$this->now}action_view/{$row->applyID}\")' rel='tooltip' title='{$row->AppUserListFirstName}  {$row->AppUserListLastName} {$row->AppUserListPhone} {$row->AppUserListEmail}'>{$row->AppUserListFirstName}  {$row->AppUserListLastName}</a>",
          'step' => $this->format_get_selection_step_with_info($steps),
          'age' => calculate_age($age),
          'dom' => $row->aplAddressCity,
          'created' => date('Y-m-d', strtotime($row->applyDate)),
          'rate' => $row->applyRate,
          'archive' => "
				<div class='btn-group'>{$action['cv']}</div>
			    <div class='btn-group'>{$action['cl']}</div>
	          ",
          'note' => "
				<div class='btn-group'>{$action['note']}</div>
	          ",
          'action' => "
				  <div class='btn-group'>{$action['detail']}</div>
			      <div class='btn-group'>{$action['prev']}</div>
			      <div class='btn-group'>{$action['next']}</div>
			      <div class='btn-group'>{$action['stop']}</div>
			      <div class='btn-group'>{$action['delete']}</div>
	          "
        );
      }
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function record_candidate2() {
    $input = array('ids', 'dataperpage', 'query', 'curpage', 'skey', 'stype', 'apply_id', 'step', 'status');

    // asign value automaticaly for $input
    foreach ($input as $val)
      $$val = $this->input->post($val);

    $start = $curpage * $dataperpage;
    $end = $start + $dataperpage;

    $total = $this->record_candidate_count($s_title, $step, $apply_id, $status, $ids);
    $npage = ceil($total / $dataperpage);

    // Where (query)
    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';
    // Order By
    switch ($skey) {
      case '_name':
        $this->db->order_by("{$this->_table_au}.AppUserListFirstName", $stype);
        break;
      case '_dom':
        $this->db->order_by("{$this->_table_a}.aplAddressCity", $stype);
        break;
      case '_age':
        $this->db->order_by("{$this->_table_a}.aplDateOfBirth", $stype);
        break;
      case '_rate':
        $this->db->order_by("{$this->_table_ja}.applyRate", $stype);
        break;
      case '_created':
        $this->db->order_by("{$this->_table_ja}.applyDate", $stype);
        break;
      default:
        $this->db->order_by("{$this->_table_a}.aplPersonID", 'ASC');
        break;
    }

    $this->db
        ->select("{$this->_table_a}.* , {$this->_table_ja}.*, {$this->_table_au}.*")
        ->from($this->_table_a)
        ->join($this->_table_ja, "{$this->_table_a}.aplPersonID = {$this->_table_ja}.applyApplicantID")
        ->join($this->_table_au, "{$this->_table_a}.aplPersonID = {$this->_table_au}.AppUserListID");

    if (!empty($step)) {
      $this->db
          ->join($this->_table_jpa, "{$this->_table_ja}.applyID = {$this->_table_jpa}.processApplyID")
          ->where("{$this->_table_jpa}.processSelectionID", $this->db->escape_str($step));
      if (!empty($data['status'])) {
        $this->db->where("{$this->_table_jpa}.processStatus", $this->db->escape_str($status));
      }
    }

    (!empty($apply_id) && $apply_id != 0) ? $this->db->where("{$this->_table_ja}.applyID", $this->db->escape_str($apply_id)) : '';

    $record = $this->db->where("{$this->_table_ja}.applyJobID", $ids)
            ->limit($dataperpage, $start)->get();

    $now = base_url() . "joborder/candidate/";
    $this->pag->_pagination_init("{$now}index", $total, $dataperpage, $curpage + 1);
    $result = array(
      'data' => array(),
      'pagination' => '',
      'numpage' => $npage - 1,
      'npage' => $npage,
      'start' => $start,
      'end' => $dataperpage,
      'pagination' => $this->pagination->create_links(),
    );

    if ($record->num_rows() > 0) {
      foreach ($record->result() as $row) {
        $age = date('Y-m-d', strtotime($row->aplDateOfBirth));
        $last_step = $this->get_last_selection_step($row->applyID);
        $steps = $this->get_selection_step_with_info($row->applyID, $row->applyJobID);
        // $js=htmlspecialchars(json_encode($serial));
        //

	        $action['cv'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.CV') ? "<a onclick='action_cv(\"{$row->applyID}\", \"{$this->now}action_cv/{$row->applyID}\")' class='btn' rel='tooltip' title='Curriculum Vitae' id='action_cv-{$row->applyID}' data-target='#cvModal'><i class='icon-paper-clip'></i></a>" : '';
        $action['cl'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.CL') ? "<a onclick='action_cl(\"{$row->applyID}\", \"{$this->now}action_cl/{$row->applyID}\")' class='btn' rel='tooltip' title='Cover Letter' id='action_cl-{$row->applyID}' data-target='#clModal'><i class='icon-unlink'></i></a>" : '';
        $action['note'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Note') ? "<a onclick='action_note(\"{$row->applyID}\", \"{$this->now}action_note/{$row->applyID}\")' class='btn' rel='tooltip' title='Notes' id='action_note-{$row->applyID}' data-target='#noteModal'><i class='icon-info'></i></a>" : '';
        $action['detail'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Detail') ? "<a onclick='action_detail(\"{$row->applyID}\", \"{$row->applyJobID}\",\"{$this->now}action_detail/{$row->applyID}\")' class='btn' rel='tooltip' title='Detail' id='action_detail-{$row->applyID}' data-target='#detailModal'><i class='icon-male'></i></a>" : '';
        $action['prev'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Prev') ? "<a onclick='action_prev(\"{$row->applyID}\",\"{$row->applyJobID}\", \"{$this->now}action_prev/{$row->applyID}\",\"loads\")' class='btn actions' rel='tooltip' title='Process Step' id='action_prev-{$row->applyID}' data-target='#prevModal'><i class='icon-pause'></i></a>" : '';
        $action['next'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Next') ? "<a onclick='action_next(\"{$row->applyID}\",\"{$row->applyJobID}\", \"{$this->now}action_next/{$row->applyID}\",\"loads\")' class='btn actions' rel='tooltip' title='Next Step' id='action_next-{$row->applyID}' data-target='#nextModal'><i class='icon-step-forward'></i></a>" : '';
        $action['stop'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Stop') ? "<a onclick='action_stop(\"{$row->applyID}\", \"{$row->applyJobID}\", \"{$this->now}action_stop/{$row->applyID}\",\"loads\")' class='btn actions' rel='tooltip' title='Stop' id='action_stop-{$row->applyID}' data-target='#stopModal'><i class='icon-stop'></i></a>" : '';
        $action['delete'] = $this->auth->_allowed('Dashboard.Joborder.Candidate.View.Delete') ? "<a onclick='action_delete(\"{$row->applyID}\", \"{$this->now}action_delete/{$row->applyID}\",\"{$row->applyJobID}\",\"loads\")' rel='tooltip' title='Delete' class='btn actions' id='action_delete-{$row->applyID}' data-target='#deleteModal'><i class='icon-trash'></i></a>" : '';
        $result['data'][] = array(
          'checkbox' => "<input type='checkbox' name='id[]' id='id' value='{$row->applyID}'>",
          'id' => $row->applyID,
          'name' => "<a style='cursor:pointer;' onclick='action_view(\"{$row->AppUserListEmail}\", \"{$this->now}action_view/{$row->applyID}\")' rel='tooltip' title='{$row->AppUserListFirstName}  {$row->AppUserListLastName} {$row->AppUserListPhone} {$row->AppUserListEmail}'>{$row->AppUserListFirstName}  {$row->AppUserListLastName}</a>",
          'step' => $this->format_get_selection_step_with_info($steps),
          'age' => calculate_age($age),
          'dom' => $row->aplAddressCity,
          'created' => date('Y-m-d', strtotime($row->applyDate)),
          'rate' => $row->applyRate,
          'archive' => "
				<div class='btn-group'>{$action['cv']}</div>
			    <div class='btn-group'>{$action['cl']}</div>
	          ",
          'note' => "
				<div class='btn-group'>{$action['note']}</div>
	          ",
          'action' => "
				  <div class='btn-group'>{$action['detail']}</div>
			      <div class='btn-group'>{$action['prev']}</div>
			      <div class='btn-group'>{$action['next']}</div>
			      <div class='btn-group'>{$action['stop']}</div>
			      <div class='btn-group'>{$action['delete']}</div>
	          "
        );
      }
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function record_candidate_count($s_title = '', $step = '', $apply_id = '', $status = '', $ids) {
    // Where (query)
    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';

    $this->db
        ->select("{$this->_table_a}.* , {$this->_table_ja}.*, {$this->_table_au}.*")
        ->from($this->_table_a)
        ->join($this->_table_ja, "{$this->_table_a}.aplPersonID = {$this->_table_ja}.applyApplicantID")
        ->join($this->_table_au, "{$this->_table_a}.aplPersonID = {$this->_table_au}.AppUserListID");

    if (!empty($step)) {
      $this->db
          ->join($this->_table_jpa, "{$this->_table_ja}.applyID = {$this->_table_jpa}.processApplyID")
          ->where("{$this->_table_jpa}.processSelectionID", $this->db->escape_str($step));
      if (!empty($data['status'])) {
        $this->db->where("{$this->_table_jpa}.processStatus", $this->db->escape_str($status));
      }
    }

    (!empty($apply_id) && $apply_id != 0) ? $this->db->where("{$this->_table_ja}.applyID", $this->db->escape_str($apply_id)) : '';

    $record = $this->db->where("{$this->_table_ja}.applyJobID", $ids)
        ->get();

    $total = count($record->result_array());
    return $total;
  }

  public function record_dashboard() {
    $input = array('dataperpage', 'query', 'curpage', 'skey', 'stype');

    // asign value automaticaly for $input
    foreach ($input as $val)
      $$val = $this->input->post($val);

    isset($query) or $query = json_decode($query, true);
    foreach ($query as $key => $value) {
      $$key = $value;
    }

    $start = $curpage * $dataperpage;
    $end = $start + $dataperpage;

    $total = $this->record_count($s_title, $s_company, $s_owner, $s_employment_type, $s_state, $s_city, $s_start, $s_end);
    $npage = ceil($total / $dataperpage);

    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';
    !empty($s_company) ? $this->db->like($this->_company, $this->db->escape_str($s_company)) : '';
    !empty($s_owner) ? $this->db->like($this->_owner, $this->db->escape_str($s_owner)) : '';
    !empty($s_employment_type) ? $this->db->like($this->_employment_type, $this->db->escape_str($s_employment_type)) : '';
    !empty($s_state) ? $this->db->like($this->_state, $this->db->escape_str($s_state)) : '';
    !empty($s_city) ? $this->db->like($this->_city, $this->db->escape_str($s_city)) : '';
    !empty($s_start) ? $this->db->like($this->_start, $this->db->
                    escape_str($s_start)) : '';
    !empty($s_end) ? $this->db->like($this->_end, $this->db->
                    escape_str($s_end)) : '';

    !empty($this->refid) ? $this->db->where($this->_company, $this->refid) : '';

    // Order By
    switch ($skey) {
      case '_title':
        $this->db->order_by($this->_title, $stype);
        break;
      case '_company':
        $this->db->order_by($this->_company, $stype);
        break;
      case '_owner':
        $this->db->order_by($this->_owner, $stype);
        break;
      case '_state':
        $this->db->order_by($this->_state, $stype);
        break;
      case '_city':
        $this->db->order_by($this->_city, $stype);
        break;
      case '_employment_type':
        $this->db->order_by($this->_employment_type, $stype);
        break;
      case '_start':
        $this->db->order_by($this->_start, $stype);
        break;
      case '_end':
        $this->db->order_by($this->_end, $stype);
        break;
      default:
        $this->db->order_by($this->_title, 'ASC');
        break;
    }

    $record = $this->db
        ->limit($dataperpage, $start)
        ->get($this->_table);

    $now = base_url() . "joborder/";
    $this->pag->_pagination_init("{$now}dashboard", $total, $dataperpage, $curpage + 1);
    $result = array(
      'data' => array(),
      'pagination' => '',
      'numpage' => $npage - 1,
      'npage' => $npage,
      'start' => $start,
      'end' => $dataperpage,
      'pagination' => $this->pagination->create_links(),
    );

    $sources = $this->populate('sources');
    if ($record->num_rows() > 0) {
      foreach ($record->result_array() as $row) {
        $all = $this->get_applicant_by_selection_step($row[$this->_id]);
        $flow = $this->_expiring($row[$this->_enddate]) ? 'expiring' : $row['joborderProcessFlow'];
        $result['data'][] = array(
          'flow' => $flow,
          'priority' => $row[$this->_priority],
          'name' => "<a href='{$this->now}candidate/{$row[$this->_id]}'>{$row[$this->_title]}</a>",
          'sources' => $sources[(int) $row[$this->_sources]],
          'selection_cv' => $this->populate_applicant_by_selection_step(1, $all),
          'interview_hr' => $this->populate_applicant_by_selection_step(2, $all),
          'interview_user' => $this->populate_applicant_by_selection_step(3, $all),
          'interview_user2' => $this->populate_applicant_by_selection_step(4, $all),
          'test_bidang' => $this->populate_applicant_by_selection_step(5, $all),
          'psikotes' => $this->populate_applicant_by_selection_step(6, $all),
          'mcu' => $this->populate_applicant_by_selection_step(7, $all),
          'persentasi' => $this->populate_applicant_by_selection_step(8, $all),
          'hiring' => $this->populate_applicant_by_selection_step(9, $all));
      }
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function record_template() {
    $input = array('dataperpage', 'query', 'curpage', 'skey', 'stype');

    // asign value automaticaly for $input
    foreach ($input as $val)
      $$val = $this->input->post($val);
    
    

    isset($query) or $query = json_decode($query, true);
    if (is_array($query)) {
      foreach ($query as $key => $value) {
        $$key = $value;
      }
    }

    $start = $curpage * $dataperpage;
    $end = $start + $dataperpage;

    $total = $this->record_count($s_title, $s_company, $s_owner, $s_employment_type, $s_state, $s_city, $s_start, $s_end);
    $npage = ceil($total / $dataperpage);
    
    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';
    !empty($s_company) ? $this->db->like($this->_company, $this->db->escape_str($s_company)) : '';
    !empty($s_owner) ? $this->db->like($this->_owner, $this->db->escape_str($s_owner)) : '';
    !empty($s_employment_type) ? $this->db->like($this->_employment_type, $this->db->escape_str($s_employment_type)) : '';
    !empty($s_state) ? $this->db->like($this->_state, $this->db->escape_str($s_state)) : '';
    !empty($s_city) ? $this->db->like($this->_city, $this->db->escape_str($s_city)) : '';
    !empty($s_start) ? $this->db->like($this->_start, $this->db->
                    escape_str($s_start)) : '';
    !empty($s_end) ? $this->db->like($this->_end, $this->db->
                    escape_str($s_end)) : '';

    !empty($this->refid) ? $this->db->where($this->_company, $this->refid) : '';

    // Order By
    switch ($skey) {
      case '_title':
        $this->db->order_by($this->_title, $stype);
        break;
      case '_company':
        $this->db->order_by($this->_company, $stype);
        break;
      case '_owner':
        $this->db->order_by($this->_owner, $stype);
        break;
      case '_state':
        $this->db->order_by($this->_state, $stype);
        break;
      case '_city':
        $this->db->order_by($this->_city, $stype);
        break;
      case '_employment_type':
        $this->db->order_by($this->_employment_type, $stype);
        break;
      case '_start':
        $this->db->order_by($this->_start, $stype);
        break;
      case '_end':
        $this->db->order_by($this->_end, $stype);
        break;
      default:
        $this->db->order_by($this->_title, 'ASC');
        break;
    }
    $record = $this->db
        ->limit($dataperpage, $start)
        ->get($this->_table);

    $now = base_url() . "joborder/";
    $this->pag->_pagination_init("{$now}add", $total, $dataperpage, $curpage + 1);
    $result = array(
      'data' => array(),
      'pagination' => '',
      'numpage' => $npage - 1,
      'npage' => $npage,
      'start' => $start,
      'end' => $dataperpage,
      'pagination' => $this->pagination->create_links(),
    );

    $company = $this->populate('company');
    $state = $this->populate('state');
    $ba = $this->populate('ba');
    $employment_type = $this->populate('employment_type');

    if ($record->num_rows() > 0) {
      foreach ($record->result_array() as $row) {
        $result['data'][] = array(
          'name' => "{$row[$this->_title]}",
          'jobs' => $row[$this->_opening],
          'company' => $company[(int) $row[$this->_company]],
          'state' => $state[$row[$this->_province]],
          'city' => $row[$this->_city],
          'employment_type' => $employment_type[$row[$this->_type]],
          'business_area' => $ba[$row[$this->_ba]],
          'url' => "{$this->now}add/{$row[$this->_id]}"
        );
      }
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }
  
  public function record_search() {
    $input = array('dataperpage', 'query', 'curpage', 'skey', 'stype','param');

    // asign value automaticaly for $input
    foreach ($input as $val)
      $$val = $this->input->post($val);

    isset($query) or $query = json_decode($query, true);
    if (is_array($query)) {
      foreach ($query as $key => $value) {
        $$key = $value;
      }
    }

    $start = $curpage * $dataperpage;
    $end = $start + $dataperpage;

    $total = $this->record_count($s_title, $s_company, $s_owner, $s_employment_type, $s_state, $s_city, $s_start, $s_end);
    $npage = ceil($total / $dataperpage);
    
    !empty($s_title) ? $this->db->like($this->_title, $this->db->escape_str($s_title)) : '';
    !empty($s_name) ? $this->db->like($this->_title, $this->db->escape_str($s_name)) : '';
    !empty($s_company) ? $this->db->like($this->_company, $this->db->escape_str($s_company)) : '';
    !empty($s_owner) ? $this->db->like($this->_owner, $this->db->escape_str($s_owner)) : '';
    !empty($s_employment_type) ? $this->db->like($this->_employment_type, $this->db->escape_str($s_employment_type)) : '';
    !empty($s_state) ? $this->db->like($this->_state, $this->db->escape_str($s_state)) : '';
    !empty($s_city) ? $this->db->like($this->_city, $this->db->escape_str($s_city)) : '';
    !empty($s_start) ? $this->db->like($this->_start, $this->db->
                    escape_str($s_start)) : '';
    !empty($s_end) ? $this->db->like($this->_end, $this->db->
                    escape_str($s_end)) : '';

    !empty($this->refid) ? $this->db->where($this->_company, $this->refid) : '';

    // Order By
    switch ($skey) {
      case '_title':
        $this->db->order_by($this->_title, $stype);
        break;
      case '_company':
        $this->db->order_by($this->_company, $stype);
        break;
      case '_owner':
        $this->db->order_by($this->_owner, $stype);
        break;
      case '_state':
        $this->db->order_by($this->_state, $stype);
        break;
      case '_city':
        $this->db->order_by($this->_city, $stype);
        break;
      case '_employment_type':
        $this->db->order_by($this->_employment_type, $stype);
        break;
      case '_start':
        $this->db->order_by($this->_start, $stype);
        break;
      case '_end':
        $this->db->order_by($this->_end, $stype);
        break;
      default:
        $this->db->order_by($this->_title, 'ASC');
        break;
    }
    $record = $this->db
        ->limit($dataperpage, $start)
        ->get($this->_table);

    $now = base_url() . "joborder/";
    $this->pag->_pagination_init("{$now}add", $total, $dataperpage, $curpage + 1);
    $result = array(
      'data' => array(),
      'pagination' => '',
      'numpage' => $npage - 1,
      'npage' => $npage,
      'start' => $start,
      'end' => $dataperpage,
      'pagination' => $this->pagination->create_links(),
    );

    $company = $this->populate('company');
    $state = $this->populate('state');
    $ba = $this->populate('ba');
    $employment_type = $this->populate('employment_type');

    if ($record->num_rows() > 0) {
      foreach ($record->result_array() as $row) {
        $result['data'][] = array(
          'name' => "{$row[$this->_title]}",
          'jobs' => $row[$this->_opening],
          'openDate' => date('j M Y',strtotime($row[$this->_startdate])),
          'company' => $company[(int) $row[$this->_company]],
          'state' => $state[$row[$this->_province]],
          'city' => $row[$this->_city],
          'employment_type' => $employment_type[$row[$this->_type]],
          'business_area' => $ba[$row[$this->_ba]],
          'url' => "{$this->now}add/{$row[$this->_id]}"
        );
      }
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
  }

  public function _last_id() {
    $query = $this->db->query("SELECT IDENT_CURRENT('tbmJoborder') as last_id");
    $res = $query->result();
    return $res[0]->last_id;
  }

  public function _sendemail($to = array(), $subject, $msg) {
    $this->mailer = Swift_Mailer::newInstance($this->transporter);
    $logger = new Swift_Plugins_Loggers_ArrayLogger();
    $this->mailer->registerPlugin(new Swift_Plugins_LoggerPlugin($logger));

    $this->config->load('swiftmailer');
    $swift_config = $this->config->item('email_config', 'swiftmailer');
    $from = array("{$swift_config['from']}" => 'No Reply Kompas Gramedia');

    $message = Swift_Message::newInstance();
    $message->setSubject($subject)
        ->setFrom($from)
        ->setTo($to)
        ->setBody($msg, 'text/html');

    $status = $this->mailer->send($message) ? TRUE : FALSE;
    return $status;
  }

  public function _sort_by_key_value($data, $sortKey, $sort_flags = SORT_ASC) {
    if (empty($data) or empty($sortKey))
      return $data;
    $ordered = array();
    foreach ($data as $key => $value)
      $ordered[$value[$sortKey]] = $value;
    ksort($ordered, $sort_flags);
    return array_values($ordered);
  }

  public function _expiring($data = "") {
    return TRUE;
  }

  /**
   * set_message_delimiters
   *
   * Set the message delimiters
   *
   * @return void
   * @author Ben Edmunds
   * */
  public function set_message_delimiters($start_delimiter, $end_delimiter) {
    $this->message_start_delimiter = $start_delimiter;
    $this->message_end_delimiter = $end_delimiter;

    return TRUE;
  }

  /**
   * set_error_delimiters
   *
   * Set the error delimiters
   *
   * @return void
   * @author Ben Edmunds
   * */
  public function set_error_delimiters($start_delimiter, $end_delimiter) {
    $this->error_start_delimiter = $start_delimiter;
    $this->error_end_delimiter = $end_delimiter;

    return TRUE;
  }

  /**
   * set_message
   *
   * Set a message
   *
   * @return void
   * @author Ben Edmunds
   * */
  public function set_message($message) {
    $this->messages[] = $message;

    return $message;
  }

  /**
   * messages
   *
   * Get the messages
   *
   * @return void
   * @author Ben Edmunds
   * */
  public function messages() {
    $_output = '';
    foreach ($this->messages as $message) {
      $messageLang = $this->lang->line($message) ? $this->lang->line($message) : '##' . $message . '##';
      $_output .= $this->message_start_delimiter . $messageLang . $this->message_end_delimiter;
    }

    return $_output;
  }

  /**
   * set_error
   *
   * Set an error message
   *
   * @return void
   * @author Ben Edmunds
   * */
  public function set_error($error) {
    $this->errors[] = $error;

    return $error;
  }

  /**
   * errors
   *
   * Get the error message
   *
   * @return void
   * @author Ben Edmunds
   * */
  public function errors() {
    $_output = '';
    foreach ($this->errors as $error) {
      $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
      $_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
    }

    return $_output;
  }

}
