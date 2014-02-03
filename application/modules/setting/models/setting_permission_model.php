<?php
class Setting_Permission_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/

	protected $_table = 'tbaAppPermission';
	protected $_lp_table = 'tbaAppLevelPermission';
	protected $primary_key = 'AppPermissionID';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;


	//
    //
    // Columns Shortcut
    //
    //
	protected $_name		 =  'AppPermissionName';
	protected $_description 		 = 'AppPermissionDescription';
	protected $_status = 'AppPermissionStatus';

	protected $_level_permission_id = 'AppLevelPermissionID';
	protected $_permission_id = 'AppLevelPermissionPermissionID';
	protected $_permission_level_id = 'AppLevelPermissionLevelID';
	protected $_allowed = 'AppLevelPermissionAllowed';

	private $_aj = array('status' => NULL, 'response' => NULL, 'data' => NULL);
	private $_default_list = array();

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
		if ($this->check($data[$this->primary_key])){
			$this->set_error('permission_creation_duplicate_name');
			return FALSE;
		}
		$this->set_message('permission_creation_successful');
		return $this->db->insert($this->_table, $data);
	}

	public function change(array $data,$id = null){
		$result = $this->db->where($this->primary_key, $id)
			->count_all_results($this->_table) > 0;
		if (count($result) == 0)
		{
			$this->set_error('permission_change_unsuccessful');
			return FALSE;
		}
		$this->db->update($this->_table, $data, array($this->primary_key => $id));
		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->set_message('permission_change_successful');
		}
		else
		{
			$this->set_error('permission_change_unsuccessful');
		}
		return $return;
	}

	public function check($name = '')
	{
		if (empty($name))
		{
			return FALSE;
		}

		return $this->db->where($this->primary_key, $name)
						->count_all_results($this->_table) > 0;
	}

	public function delete()
	{
		$form_data = array('id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$delete = $this->db->delete($this->_table, array($this->primary_key => $data['id']));
		if ($delete){
			$this->set_message('permission_creation_successful');
            $this->_aj['status'] = 'success';
			$this->_aj['message'] = $this->messages;
		}else {
			$this->set_error('permission_creation_duplicate_name');
            $this->_aj['status'] = 'error';
			$this->_aj['message'] = $this->errors;
		}
		echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }

	public function get_id_by_name($name)
	{
  		$result = $this->db
  					->from($this->_table)
  					->where("{$this->_table}.{$this->_name}", $name)
  					->get()
  					->row_array();
  		$id = isset($result['AppPermissionID']) ? $result['AppPermissionID'] : 0;
  		return $id;
	}

	public function get_by_name_levid($name, $lev_id)
	{
  		$result = $this->db
  					->from($this->_table)
  					->join($this->_lp_table,"{$this->_table}.{$this->primary_key} = {$this->_lp_table}.{$this->_permission_id}")
  					->where("{$this->_table}.{$this->_name}", $name)
  					->where("{$this->_lp_table}.{$this->_permission_level_id}", $lev_id)
  					->get()
  					->result();
  		if ( ! isset($result[0]))
		{
			return false;
		}
		return $result[0];
	}

	public function form(){
		$form_data = array('name','description','status','hidden_id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$memo = array(
			$this->_name => $data['name'],
			$this->_description => $data['description'],
			$this->_status => $data['status']
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

	public function populate_permission($result = array())
	{
		$query = $this->db->from($this->_table)
						->order_by($this->_name)
						->get()
						->result_array();
		foreach ($query as $rows) {
			array_push($result, array('p_id' => $rows[$this->primary_key], 'name' => $rows[$this->_name], 'desc' => $rows[$this->_description]));
		}
		return $result;

	}
	public function populate_permission_by_level_id($lev_id = 0, $result = array())
	{
		$query = $this->db->from($this->_lp_table)
						->join($this->_table, "{$this->_lp_table}.{$this->_permission_id} = {$this->_table}.{$this->primary_key}")
						->order_by("{$this->_table}.{$this->_name}")
						->where("{$this->_lp_table}.{$this->_permission_level_id}",$lev_id)
						->get()
						->result_array();
		foreach ($query as $rows) {
			$result[] = $rows[$this->primary_key];
		}

		return $result;
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

	    $total = $this->record_count($s_name);
	    $npage = ceil($total / $dataperpage);

	    // Where (query)
	    !empty($s_name) ? $this->db->like($this->_name, $this->db->escape_str($s_name)) : '';
	    !empty($s_status) ? $this->db->like($this->_status, $this->db->escape_str($s_status)) : '';
	    // Order By
		switch ($skey) {
			case '_name':
				$this->db->order_by($this->_name, $stype);
				break;
			case '_status':
				$this->db->order_by($this->_status, $stype);
				break;
			default:
				$this->db->order_by($this->_name, 'ASC');
				break;
		}

		$record = $this->db
					->limit($dataperpage, $start)
					->get($this->_table);

		$now = base_url()."usermanagement/permission/";
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
	      		'name' => $row[$this->_name],
	      		'description' => $row[$this->_description],
	      		'status' => $row[$this->_status],
	      		);
	      	$js=htmlspecialchars(json_encode($serial));
	      	$action['edit'] = $this->auth->_allowed('Dashboard.Company.Form.Edit') ? '<a class="btn btn-small btn-success" onclick="editG(\''.$row[$this->primary_key].'\', \''.$js.'\')">Edit</a>' : '';
	      	$action['delete'] = $this->auth->_allowed('Dashboard.Company.Delete') ? '<a class="btn btn-small btn-success" onclick="deleteG(\''.$row[$this->primary_key].'\')">Delete</a>' : '';
	        $result['data'][] = array(
	          'name' => "{$row[$this->_name]}",
	          'description' => "{$row[$this->_description]}",
	          'status' => "{$row[$this->_status]}",
	          'action' => "<div class='btn-group'>{$action['edit']}{$action['delete']}</div>"
	        );
	        $n++;
	      }
	    }
	    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
	}

	public function record_count($s_name = NULL){
		// Where (query)
	    !empty($s_name) ? $this->db->like($this->_name, $this->db->escape_str($s_name)) : '';

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