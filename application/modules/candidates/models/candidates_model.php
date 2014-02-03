<?php
class Candidates_Model extends MY_Model
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
		$this->load->library('session');
		$this->lang->load('user', 'english');
		$this->load->model('pagination_model','pag',TRUE);

		//initialize messages and error
		$this->messages = array();
		$this->errors = array();
		$this->message_start_delimiter = $this->config->item('message_start_delimiter', 'ion_auth');
		$this->message_end_delimiter   = $this->config->item('message_end_delimiter', 'ion_auth');
		$this->error_start_delimiter   = $this->config->item('error_start_delimiter', 'ion_auth');
		$this->error_end_delimiter     = $this->config->item('error_end_delimiter', 'ion_auth');
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


        $this->db->join("tbaAppUserLevel", "tbaAppUserLevel.AppUserLevelUserID= tbaAppUserList.AppUserListID");
        $this->db->where("(AppUserLevelLevelID = '10' or AppUserLevelLevelID = '11')");
        //$this->db->where("AppLevelListLevelID = 'internal_candidate' or AppLevelListLevelID = 'external_candidate'");

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
						onclick="deactiveG(\''.$row[$this->primary_key].'\')">Deactive</a>' : '<a class="btn btn-small btn-success"
						onclick="activateG(\''.$row[$this->primary_key].'\')">Active</a>';
	      	$js=htmlspecialchars(json_encode($serial));
	      	$action['change'] = $this->auth->_allowed('Dashboard.User.Modal.Password') ? '<div class="btn-group"> <a class="btn btn-small btn-success" onclick="changeP(\''.$row[$this->primary_key].'\')">Change</a>
		          </div>' : '';
		    $action['level'] = $this->auth->_allowed('Dashboard.User.Modal.Level') ? '<div class="btn-group"> <a class="btn btn-small btn-success" onclick="changeL(\''.$row[$this->primary_key].'\')">Change</a>
		          </div>' : '';
		    $action['edit'] = $this->auth->_allowed('Dashboard.User.Edit') ? '<a class="btn btn-small btn-success" onclick="editG(\''.$row[$this->primary_key].'\', \''.$js.'\')">Edit</a>' : '';
		    $action['active'] = $this->auth->_allowed('Dashboard.User.Activate') ? $active_flag : '';
	        
            //{$row[$this->_first_name]} {$row[$this->_last_name]}
            $link = '<a style="cursor:pointer;" onclick="choose(\''.$row[$this->primary_key].'\', \''.$row[$this->_email].'\')">'.$row[$this->_first_name].' '.$row[$this->_last_name].'</a>';
            
            $result['data'][] = array(
	          'name' => $link,
	          'email' => "{$row[$this->_email]}",
	          'groups' => $this->get_group_by_user_id($row[$this->primary_key]),
	          'join' => date('d M Y',$row[$this->_created_on])
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
}