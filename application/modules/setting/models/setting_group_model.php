<?php
class Setting_Group_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/

	protected $_table = 'tbaAppLevelList';
	protected $_lp_table = 'tbaAppLevelPermission';
	protected $primary_key = 'AppLevelListID';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;


	//
    //
    // Columns Shortcut
    //
    //
	protected $_id 			 =  'AppLevelListLevelID';
	protected $_name 		 =  'AppLevelListLevelName';
	protected $_refname		 =  'AppLevelListRefName';

	protected $_level_permission_id = 'AppLevelPermissionID';
	protected $_permission_id = 'AppLevelPermissionPermissionID';
	protected $_permission_level_id = 'AppLevelPermissionLevelID';
	protected $_permission_level_allowed = 'AppLevelPermissionAllowed';




	private $_aj = array('status' => NULL, 'response' => NULL, 'data' => NULL);

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
			$this->set_error('group_creation_duplicate_name');
			return FALSE;
		}
		$this->set_message('group_creation_successful');
		return $this->db->insert($this->_table, $data);
	}

	public function add_bulk_permission($per_id = array(), $lev_id){
		if (count($per_id) == 0){
			return FALSE;
		}
		$memo = array(
			$this->_permission_level_id => $lev_id,
			$this->_permission_level_allowed => 1
			);

		foreach ($per_id as $row) {
			$memo[$this->_permission_id] = $row;
			$this->db->insert($this->_lp_table, $memo);
		}
		return TRUE;
	}

	public function change(array $data,$id = null){
		$result = $this->db->where($this->primary_key, $id)
			->count_all_results($this->_table) > 0;
		if (count($result) == 0)
		{
			$this->set_error('group_change_unsuccessful');
			return FALSE;
		}
		$this->db->update($this->_table, $data, array($this->primary_key => $id));
		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->set_message('group_change_successful');
		}
		else
		{
			$this->set_error('group_change_unsuccessful');
		}
		return $return;
	}

	public function check($name = '')
	{
		if (empty($name))
		{
			return FALSE;
		}

		return $this->db->where($this->_id, $name)
						->count_all_results($this->_table) > 0;
	}

	public function delete()
	{
		$form_data = array('id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$delete = $this->db->delete($this->_table, array($this->primary_key => $data['id']));
		if ($delete){
			$this->set_message('group_delete_successful');
            $this->_aj['status'] = 'success';
			$this->_aj['message'] = $this->messages;
		}else {
			$this->set_errpr('group_delete_successful');
            $this->_aj['status'] = 'error';
			$this->_aj['message'] = $this->errors;
		}
		echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }

    public function delete_permission_by_lev_id($id = null)
	{
		$result = $this->db->where($this->_permission_level_id, $id)
			->count_all_results($this->_lp_table) > 0;
		if (count($result) == 0)
		{
			return FALSE;
		}
		$delete = $this->db->delete($this->_lp_table, array($this->_permission_level_id => $id));

		if($delete){
			return TRUE;
		}else{
			return FALSE;
		}
    }

	public function form(){
		$form_data = array('group_id','name','refname','hidden_id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$memo = array(
			$this->_id => $data['group_id'],
			$this->_name => $data['name'],
			$this->_refname => $data['refname']
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

	public function permission(){
		$input = array('id', 'hidden_id');

	    foreach ($input as $val)
	      	$data[$val] = $this->input->post($val);

	    if (count($data['id']) > 0) {
	    	if ($this->delete_permission_by_lev_id($data['hidden_id'])) {
	    		if($this->add_bulk_permission($data['id'],$data['hidden_id'])){
	    			$this->_aj['status'] = 'success';
					$this->_aj['message'] = 'hello world';
	    		}else{
	    			$this->_aj['status'] = 'error';
					$this->_aj['message'] = 'hello world of destruction';
	    		}
	    	}else{
	    		$this->_aj['status'] = 'error';
				$this->_aj['message'] = 'hello world of destruction';
	    	}
	    }else{
	    	$this->_aj['status'] = 'error';
			$this->_aj['message'] = 'hello world of destruction';
	    }
	    $this->_aj['redirect'] = base_url().'usermanagement/group';
	   	echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
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

	    $total = $this->record_count($s_id, $s_name, $s_refname);
	    $npage = ceil($total / $dataperpage);

	    !empty($s_id) ? $this->db->like($this->_id, $this->db->escape_str($s_id)) : '';
	    !empty($s_name) ? $this->db->like($this->_name, $this->db->escape_str($s_name)) : '';
	    !empty($s_refname) ? $this->db->like($this->_refname, $this->db->escape_str($s_refname)) : '';
	    // Order By
		switch ($skey) {
			case '_id':
				$this->db->order_by($this->_id, $stype);
				break;
			case '_name':
				$this->db->order_by($this->_name, $stype);
				break;
			case '_refname':
				$this->db->order_by($this->_refname, $stype);
				break;
			default:
				$this->db->order_by($this->_name, 'ASC');
				break;
		}

		$record = $this->db
					->limit($dataperpage, $start)
					->get($this->_table);

		$now = base_url()."usermanagement/group/";
	    $permission = base_url()."usermanagement/group_permission/";
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
	      		'id' => $row[$this->_id],
	      		'name' => $row[$this->_name],
	      		'refname' => $row[$this->_refname]
	      		);
	      	$js=htmlspecialchars(json_encode($serial));

	      	$action['edit'] = $this->auth->_allowed('Dashboard.Group.Form.Edit') ? '<a class="btn btn-small btn-success" onclick="editG(\''.$row[$this->primary_key].'\', \''.$js.'\')"><i class="icon-pencil"></i></a>' : '';
	      	$action['permission'] = $this->auth->_allowed('Dashboard.Group.Permission') ? '<a class="btn btn-small btn-success" href="'.$permission.$row[$this->primary_key].'"><i class="icon-file-text"></i></a>' : '';
	      	$action['delete'] = $this->auth->_allowed('Dashboard.Group.Delete') ? '<a class="btn btn-small btn-success" onclick="deleteG(\''.$row[$this->primary_key].'\')"><i class="icon-trash"></i></a>' : '';

	        $result['data'][] = array(
	          'id'	=> "{$row[$this->_id]}",
	          'name' => "{$row[$this->_name]}",
	          'refname' => "{$row[$this->_refname]}",
	          'action' => "<div class='btn-group'>{$action['edit']}{$action['permission']}{$action['delete']}</div>"
	        );
	        $n++;
	      }
	    }
	    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
	}

	public function record_count($s_id = NULL, $s_name = NULL, $s_refname = NULL){
		// Where (query)
	    !empty($s_id) ? $this->db->like($this->_id, $this->db->escape_str($s_id)) : '';
	    !empty($s_name) ? $this->db->like($this->_name, $this->db->escape_str($s_name)) : '';
	    !empty($s_refname) ? $this->db->like($this->_refname, $this->db->escape_str($s_refname)) : '';

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