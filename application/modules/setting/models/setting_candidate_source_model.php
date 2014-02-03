<?php
class Setting_Candidate_Source_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/

	protected $_table = 'tbmLocation';
	protected $primary_key = 'LocationID';
	protected $soft_delete = FALSE;
  protected $soft_delete_key = 'deleted';
  protected $_temporary_with_deleted = FALSE;

	protected $_name 		 =  'Location';
	protected $_hbkode		 =  'HBKode';

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

	public function add(array $data){
		if ($this->check($data[$this->_name])){
			$this->set_error('candidate_source_creation_duplicate_name');
			return FALSE;
		}
		$this->set_message('candidate_source_creation_successful');
		return $this->db->insert($this->_table, $data);
	}

	public function change(array $data,$id = null){
		$result = $this->db->where($this->primary_key, $id)
			->count_all_results($this->_table) > 0;
		if (count($result) == 0)
		{
			$this->set_error('candidate_source_change_unsuccessful');
			return FALSE;
		}
		$this->db->update($this->_table, $data, array($this->primary_key => $id));
		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->set_message('candidate_source_change_successful');
		}
		else
		{
			$this->set_error('candidate_source_change_unsuccessful');
		}
		return $return;
	}

	public function check($name = ''){
		if (empty($name))
		{
			return FALSE;
		}
		return $this->db->where($this->_name, $name)
						->count_all_results($this->_table) > 0;
	}

	public function delete(){
		$form_data = array('id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);
		// $delete = $this->db->delete($this->_table, array($this->primary_key => $data['id']));
		if ($delete){
			$this->set_message('candidate_source_delete_successful');
      $this->_aj['status'] = 'success';
			$this->_aj['message'] = $this->messages;
		}else {
			$this->set_errpr('candidate_source_delete_successful');
      $this->_aj['status'] = 'error';
			$this->_aj['message'] = $this->errors;
		}
		echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

  }

	public function form(){
		$form_data = array('name','hidden_id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$memo = array(
			$this->_name => $data['name'],
			// $this->_hbcode => $data['hbcode']
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

	public function record()
	{
		$record = $this->db
					->order_by($this->_name,'ASC')
					->get($this->_table);
		$result = array(
			'data' => array()
	    );
    if ($record->num_rows() > 0) {
      foreach ($record->result_array() as $row) {
      	$serial = array(
      		'name' => $row[$this->_name],
      		// 'hbcode' => $row[$this->_hbcode],
      		);
      	$js=htmlspecialchars(json_encode($serial));
      	$action['edit'] = $this->auth->_allowed('Dashboard.Vertical.Form.Edit') ? '<a class="btn btn-link" onclick="editG(\''.$row[$this->primary_key].'\', \''.$js.'\')">Edit</a>' : '';
      	$action['delete'] = $this->auth->_allowed('Dashboard.Vertical.Delete') ? '<a class="btn btn-link" onclick="deleteG(\''.$row[$this->primary_key].'\')">Delete</a>' : '';

        $result['data'][] = array(
        		'id' => $row[$this->primary_key],
        		'name' => $row[$this->_name],
        		'action' => "{$action['edit']} {$action['delete']}",
        	);
      }
    }
    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
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