<?php

class Ref_Blood_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/
	
	protected $_table = 'tbrBloodType';
	protected $primary_key = 'BloodType';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;


	//
    //
    // Columns Shortcut
    //
    //
	protected $_id 			 =  'BloodType';
	protected $_name 		 =  'BloodType';
    
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

	public function check_blood($name = '')
	{
		if (empty($name))
		{
			return FALSE;
		}
		
		return $this->db->where('BloodType', $name)
						->count_all_results($this->_table) > 0;
	}

	public function delete_blood($id)
	{
		$delete = $this->db->delete($this->_table, array('BloodType' => $id));
		if ($delete)
            return true;
        else
            return false;
    }

	public function add_blood($name, array $data)
	{
		if ($this->check_blood($name))
		{
			$this->set_error('group_creation_duplicate_name');
			return FALSE;
		}
		return $this->db->insert($this->_table, $data);
	}

	public function change_blood($id, array $data)
	{
		$result = $this->db->where('BloodType', $id)
			->count_all_results($this->_table) > 0;

		if (count($result) == 0)
		{
			$this->set_error('group_change_unsuccessful');
			return FALSE;
		}
		
		$this->db->update($this->_table, $data, array('BloodType' => $id));

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
	    
	    
	    $total = $this->count_all();
	    $npage = ceil($total / $dataperpage);
	    $start = $curpage * $dataperpage;
	    $end = $start + $dataperpage;
	    

	    // Where (query)
	    !empty($s_name) ? $this->db->like($this->_name, $this->db->escape_str($s_name)) : '';
	    
	    // Order By
		switch ($skey) {
			case '_name':
				$this->db->order_by($this->_name, $stype);
				break;
			default:
				$this->db->order_by($this->_name, 'ASC');
				break;
		}

		$record = $this->db
					->limit($dataperpage, $start)
					->get($this->_table);	
	
		// ChromePhp::log($this->db->last_query());
	    $result = array(
	      'data' => array(),
	      'pagination' => '',
	      'numpage' => $npage - 1,
	    );
        
        //Tambah Gita 27 Agustus untuk paging
	    if (!empty($s_name))
            $npage =  ceil($record->num_rows() / $dataperpage);         
	    
	    if ($record->num_rows() > 0) {
            $n = 1;
            foreach ($record->result() as $row) {
                $bool_change = $this->auth->_allowed('Dashboard.Reference.Blood.Change');
                $bool_delete = $this->auth->_allowed('Dashboard.Reference.Blood.Delete');                

                $text = "";
                if ($bool_change || $bool_delete)
                {
                    $text .= "<div class='btn-group'>";
                    if ($bool_change)
                        $text .= "<a class='btn btn-small btn-success' onclick='editB(\"".$row->BloodType."\")'>".lang('edit')."</a>";
                    if ($bool_delete)
                        $text .= "<a class='btn btn-small btn-success' onclick='deleteB(\"".$row->BloodType."\")'>".lang('hapus')."</a>";
                    $text .= "</div>";
                }
                
                $result['data'][] = array(
                    'name' => "{$row->BloodType}",
                    'action' => $text
                );
                $n++;
            }
	    }
	     
	    $result['npage'] = $npage;
	    $result['start'] = $start;
	    $result['end'] = $dataperpage;
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