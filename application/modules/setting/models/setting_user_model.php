<?php
class Setting_User_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/

	public $_table = 'tbaAppUserList';
	public $_g_table = 'tbaAppLevelList';
	public $_ug_table = 'tbaAppUserLevel';

	public $primary_key = 'AppUserListID';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;

	//
    //
    // Columns Shortcut
    //
    //

	public $_username 			 =  'AppUserListUsername';
	public $_ip_address 			 =  'AppUserListIPAddress';
	public $_password 			 =  'AppUserListPassword';
	public $_salt 			 =  'AppUserListSalt';
	public $_email 			 =  'AppUserListEmail';
	public $_phone 			 =  'AppUserListPhone';
	public $_activation_code 			 =  'AppUserListActivationCode';
	public $_forgotten_password 			 =  'AppUserListForgottenPassword';
	public $_remember_code 			 =  'AppUserListRememberCode';
	public $_created_on 			 =  'AppUserListCreatedOn';
	public $_last_login 			 =  'AppUserListLastLogin';
	public $_active 			 =  'AppUserListActive';
	public $_first_name 			 =  'AppUserListFirstName';
	public $_last_name 			 =  'AppUserListLastName';
	public $_company 			 =  'AppUserListCompany';

	public $_g_id 			 =  'AppLevelListID';
	public $_g_level 			 =  'AppLevelListLevelID';
	public $_g_name 		 =  'AppLevelListLevelName';
	public $_g_refname		 =  'AppLevelListRefName';

	public $_ug_level_id = 'AppUserLevelLevelID';
	public $_ug_user_id = 'AppUserLevelUserID';
	public $_ug_ref_id = 'AppUserLevelLevelRefID';
	public $_ug_cost_id = 'AppUserLevelLevelCostID';
	public $_ug_user_group_id = 'AppUserLevelID';

	public $_aj = array('status' => NULL, 'response' => NULL, 'data' => NULL);

	/**
	 * Holds an array of tables used
	 *
	 * @var string
	 **/
	public $tables = array();

	/**
	 * Identity
	 *
	 * @var string
	 **/
	public $identity;

	/**
	 * Response
	 *
	 * @var string
	 **/
	protected $response = NULL;

	/**
	 * message (uses lang file)
	 *
	 * @var string
	 **/
	protected $messages;

	/**
	 * error message (uses lang file)
	 *
	 * @var string
	 **/
	protected $errors;

	/**
	 * error start delimiter
	 *
	 * @var string
	 **/
	protected $error_start_delimiter;

	/**
	 * error end delimiter
	 *
	 * @var string
	 **/
	protected $error_end_delimiter;

	public function __construct()
	{
		parent::__construct();
		$this->load->helper('cookie');
		$this->load->helper('text');
		$this->load->library('session');
		$this->load->model('pagination_model','pag',TRUE);

		//initialize messages and error
		$this->messages = array();
		$this->errors = array();
		$this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
		$this->message_end_delimiter   = $this->config->item('message_end_delimiter', 'ion_auth');
		$this->error_start_delimiter   = $this->config->item('error_start_delimiter', 'ion_auth');
		$this->error_end_delimiter     = $this->config->item('error_end_delimiter', 'ion_auth');
	}

	public function add(array $data)
	{
		if ($this->check($data[$this->_id])){
			$this->set_error('user_creation_duplicate_name');
			return FALSE;
		}
		$this->set_message('user_creation_successful');
		return $this->db->insert($this->_table, $data);
	}

	public function change(array $data,$id = null){
		$result = $this->db->where($this->primary_key, $id)
			->count_all_results($this->_table) > 0;
		if (count($result) == 0)
		{
			$this->set_error('user_change_unsuccessful');
			return FALSE;
		}
		$this->db->update($this->_table, $data, array($this->primary_key => $id));
		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->set_message('user_change_successful');
		}
		else
		{
			$this->set_error('user_change_unsuccessful');
		}
		return $return;
	}

	public function add_group($data = array(), $id = null){
		$check = $this->db->where($this->_ug_user_id, $id)
						->count_all_results($this->_ug_table) > 0;

		$result = array('check' => array(),'delete' => array());
		$query = $this->db->where($this->_ug_user_id, $id)
						->get($this->_ug_table)->result_array();

		if(count($query) > 0){
			foreach ($query as $rows) {
				$result['check'][] = $rows[$this->_ug_user_group_id];
			}
		}
		$target = array();
		if ($check && count($data) > 0) {
			foreach ($data as $rows) {
				$target[] = $rows['ug_id'];
				$check_ada = $this->db->where($this->_ug_user_group_id, $rows['ug_id'])
					->count_all_results($this->_ug_table) > 0;
				$check_sama = $this->db->where($this->_ug_level_id, $rows['group_id'])->where($this->_ug_ref_id, $rows['refid'])
					->count_all_results($this->_ug_table) > 0;
				$memo = array($this->_ug_user_id => $id, $this->_ug_level_id => $rows['group_id'], $this->_ug_ref_id => $rows['refid']);
				if ($check_ada) {
					$this->db->update($this->_ug_table, $memo, array($this->_ug_user_group_id => $rows['ug_id']));
				}else{
					if (!$check_sama) {
						$this->db->insert($this->_ug_table, $memo);
					}
				}
			}
			$result['delete'] = (array)array_diff($result['check'], $target);
			if (count($result['delete']) > 0) {
				foreach ($result['delete'] as $rows) {
					$this->db->delete($this->_ug_table, array($this->_ug_user_group_id => $rows));
				}
			}
			return true;
		}else{
			return false;
		}
	}

	public function check($name = '')
	{
		if (empty($name))
		{
			return FALSE;
		}
		return $this->db->where($this->_email, $name)
						->count_all_results($this->_table) > 0;
	}

	public function delete()
	{
		$form_data = array('id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$delete = $this->db->delete($this->_table, array($this->primary_key => $data['id']));
		if ($delete){
			$this->set_message('user_delete_successful');
            $this->_aj['status'] = 'success';
			$this->_aj['message'] = $this->messages;
		}else {
			$this->set_errpr('user_delete_successful');
            $this->_aj['status'] = 'error';
			$this->_aj['message'] = $this->errors;
		}
		echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }

	public function form(){
		$form_data = array('full_name','mobile_phone','hidden_id');
        foreach ($form_data as $val)
            $data[$val] = $this->input->post($val);

        $name = $this->register->explode_name($data['full_name']);
        $fname = $name[0];
        $lname = $name[1];

		$memo = array(
                $this->ref_user->_first_name => $fname,
                $this->ref_user->_last_name => $lname,
                $this->ref_user->_phone => $data['mobile_phone']
               );

		if($data['hidden_id'] != NULL){
			if($this->change($memo,$data['hidden_id'])){
				$this->_aj['status'] = 'success';
				$this->_aj['message'] = $this->messages;
			}else{
				$this->_aj['status'] = 'error';
				$this->_aj['message'] = $this->errors;
			}
		}else{
			if($this->add($memo) > 0){
				$this->_aj['status'] = 'success';
				$this->_aj['message'] = $this->messages;
			}else{
				$this->_aj['status'] = 'error';
				$this->_aj['message'] = $this->errors;
			}
		}
		$this->_aj['data'] = $memo;
		echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
	}

	public function get_group_by_user_id($id = null){
		$users_groups = $this->auth->get_users_groups($id)->result();
		$groups = array();
		foreach ($users_groups as $rows) {
			$groups[] = $rows->name;
		}
		return implode(',', array_unique($groups));
	}

	public function get_group_by_user($id = null, $target = array()){
		$query = $this->db
					->from($this->_ug_table)
					->where($this->_ug_user_id, $id)
					->get();
		if ($query->num_rows() > 0) {
			foreach ($query->result_array() as $rows) {
				array_push($target, array('group_id' => $rows[$this->_ug_level_id], 'company_id' => $rows[$this->_ug_ref_id], 'user_group_id' => $rows[$this->_ug_user_group_id], 'cost_id' => $rows[$this->_ug_cost_id]));
			}
		}
		return $target;
	}

	public function get_user($id = null){
		$query = $this->db->where($this->primary_key, $id)
			->get($this->_table);
		return $query->row_array();
	}


	public function record()
	{
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
	    // Where (query)

	    $total = $this->record_count($s_name,$s_group);
	    $npage = ceil($total / $dataperpage);

	    !empty($s_name) ? $this->db->where($this->_first_name, $this->db->escape_str($s_name)) : '';
	    if(!empty($s_group)){
	    	$this->db
	    		->join('tbaAppUserLevel', 'tbaAppUserList.AppUserListID = tbaAppUserLevel.AppUserLevelUserID')
	    		->where_in('tbaAppUserLevel.AppUserLevelLevelID', $this->db->escape_str($s_group));
	    }
	    // Order By
		switch ($skey) {
			case '_name':
				$this->db->order_by($this->_first_name, $stype);
				break;
			case '_email':
				$this->db->order_by($this->_email, $stype);
				break;
			default:
				$this->db->order_by($this->_email, 'ASC');
				break;
		}

		$record = $this->db
					->limit($dataperpage, $start)
					->get($this->_table);

		$now = base_url()."setting/user/";
		$this->pag->_pagination_init("{$now}index", $total, $dataperpage, $curpage+1);
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
	      $n = 1;
	      foreach ($record->result_array() as $row) {
	      	$serial = array(
	      		'name' => $row[$this->_id],
	      		'email' => $row[$this->_email]
	      		);
	      	$active_flag = $row[$this->_active] ? '<a class="btn btn-small btn-success"
						onclick="deactiveG(\''.$row[$this->primary_key].'\')"><i class="icon-check"></i></a>' : '<a class="btn btn-small btn-success"
						onclick="activateG(\''.$row[$this->primary_key].'\')"><i class="icon-check-empty"></i></a>';
	      	$js=htmlspecialchars(json_encode($serial));
	      	$action['change'] = $this->auth->_allowed('Dashboard.User.Modal.Password') ? '<div class="btn-group"> <a class="btn btn-small btn-success" onclick="changeP(\''.$row[$this->primary_key].'\')"><i class="icon-pencil"></i></a>
		          </div>' : '';
		    $action['level'] = $this->auth->_allowed('Dashboard.User.Modal.Level') ? '<div class="btn-group"> <a class="btn btn-small btn-success" onclick="changeL(\''.$row[$this->primary_key].'\')"><i class="icon-pencil"></i></a>
		          </div>' : '';
		    $action['edit'] = $this->auth->_allowed('Dashboard.User.Edit') ? '<a class="btn btn-small btn-success" onclick="editG(\''.$row[$this->primary_key].'\', \''.$js.'\')"><i class="icon-edit"></i></a>' : '';
		    $action['active'] = $this->auth->_allowed('Dashboard.User.Activate') ? $active_flag : '';
	        $result['data'][] = array(
	          'name' => "{$row[$this->_first_name]} {$row[$this->_last_name]}",
	          'email' => "{$row[$this->_email]}",
	          'groups' => word_limiter($this->get_group_by_user_id($row[$this->primary_key]),3),
	          'join' => date('Y-m-d',$row[$this->_created_on]),
	          'change' => "{$action['change']}",
	          'level_change' => "{$action['level']}",
	          'action' => "<div class='btn-group'>{$action['edit']}{$action['active']}</div>"
	        );
	        $n++;
	      }
	    }
	    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
	}

	public function record_count($s_name = NULL, $s_group = NULL){
	    // Where (query)
	    !empty($s_name) ? $this->db->where($this->_first_name, $this->db->escape_str($s_name)) : '';
	    if(!empty($s_group)){
	    	$this->db
	    		->join('tbaAppUserLevel', 'tbaAppUserList.AppUserListID = tbaAppUserLevel.AppUserLevelUserID')
	    		->where_in('tbaAppUserLevel.AppUserLevelLevelID', $this->db->escape_str($s_group));
	    }


	    $total = $this->count_all_results($this->_table);
	    return $total;
	}

	public function translate_user_group($target = array(), $option = array(), $result = array()){
		$translate = "";
		foreach ($target as $rows) {
			$translate .= "
					<div class='control-group'>
						<label for='' class='control-label'>Level/Company</label>
						<div class='controls'>
							<input type='hidden' name='hidden_ug_id[]'  value='{$rows['user_group_id']}' />
	                        <select name='level[]' class='input-large'>";
	                            foreach ($option['level'] as $key => $value) {
	                            	if($key == $rows['group_id']){
	                                	$translate .= "<option value='{$key}' selected='selected'>{$value}</option>";
		                            }else{
		                            	$translate .= "<option value='{$key}'>{$value}</option>";
		                            }
	                            }
	        $translate .=  "</select>
	                        <select name='costid[]' class='input-large'>";
	                            foreach ($option['cost'] as $key => $value) {
	                                if($key == $rows['cost_id']){
	                                	$translate .= "<option value='{$key}' selected='selected'>{$value}</option>";
		                            }else{
		                            	$translate .= "<option value='{$key}'>{$value}</option>";
		                            }
	                            }
	        $translate .=  "</select>
	                        <select name='refid[]' class='input-large'>";
	                            foreach ($option['company'] as $key => $value) {
	                                if($key == $rows['company_id']){
	                                	$translate .= "<option value='{$key}' selected='selected'>{$value}</option>";
		                            }else{
		                            	$translate .= "<option value='{$key}'>{$value}</option>";
		                            }
	                            }
	        $translate .=    "</select>
	                        <a class='btn btn-success' data-action='add'><i class='icon-plus'></i></a>
	                        <a class='btn btn-inverse' data-action='remove'><i class='icon-trash'></i></a>
	                    </div>
	                </div>
				";
		}
		return $translate;
	}

	public function translate_user_group_init($option = array(),$result = array()){
		$translate = "";
		$translate .= "
				<div class='control-group'>
					<label for='' class='control-label'>Level/Company</label>
					<div class='controls'>
						<input type='hidden' name='hidden_ug_id[]'  value='' />
                        <select name='level[]' class='input-large'>";
                            foreach ($option['level'] as $key => $value) {
                        		$translate .= "<option value='{$key}'>{$value}</option>";
                            }
        $translate .=  "</select>
                        <select name='costid[]' class='input-large'>";
                            foreach ($option['cost'] as $key => $value) {
                            	$translate .= "<option value='{$key}'>{$value}</option>";
                            }
        $translate .=  "</select>
                        <select name='refid[]' class='input-large'>";
                            foreach ($option['company'] as $key => $value) {
                            	$translate .= "<option value='{$key}'>{$value}</option>";
                            }
        $translate .=    "</select>
                        <a class='btn btn-success' data-action='add'><i class='icon-plus'></i></a>
                        <a class='btn btn-inverse' data-action='remove'><i class='icon-trash'></i></a>
                    </div>
                </div>
			";
		return $translate;
	}

	public function translate_data($target = array(), $result = array()){
		if (count($target) > 0) {
			for($i=0; $i < count($target['refid']); $i++){
				$refid = $target['refid'][$i] == 0 ? NULL : $target['refid'][$i];
				array_push($result, array('ug_id' => $target['hidden_ug_id'][$i], 'group_id' => $target['level'][$i], 'refid' => $refid));
			}
		}
		return $result;
	}
	/**
	 * set_message_delimiters
	 *
	 * Set the message delimiters
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/

	public function set_message_delimiters($start_delimiter, $end_delimiter)
	{
		$this->message_start_delimiter = $start_delimiter;
		$this->message_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	/**
	 * set_error_delimiters
	 *
	 * Set the error delimiters
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/

	public function set_error_delimiters($start_delimiter, $end_delimiter)
	{
		$this->error_start_delimiter = $start_delimiter;
		$this->error_end_delimiter   = $end_delimiter;

		return TRUE;
	}

	/**
	 * set_message
	 *
	 * Set a message
	 *
	 * @return void
	 * @author Ben Edmunds
	 **/

	public function set_message($message)
	{
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
	 **/

	public function messages()
	{
		$_output = '';
		foreach ($this->messages as $message)
		{
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
	 **/

	public function set_error($error)
	{
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
	 **/

	public function errors()
	{
		$_output = '';
		foreach ($this->errors as $error)
		{
            $errorLang = $this->lang->line($error) ? $this->lang->line($error) : '##' . $error . '##';
            $_output .= $this->error_start_delimiter . $errorLang . $this->error_end_delimiter;
		}

		return $_output;
	}

	function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
				$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}