<?php

class Ref_Education_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/
	
	protected $_table = 'tbrEducationLevel';
	protected $primary_key = 'EducationLevelCode';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;


	//
    //
    // Columns Shortcut
    //
    //
	protected $_id 			 =  'EducationLevelCode';
	protected $_name 		 =  'EducationLevelName';
	protected $_category     =  'EducationLevelCategory';
    
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

	public function check($name = '')
	{
		if (empty($name))
		{
			return FALSE;
		}
		
		return $this->db->where('EducationLevelName', $name)
						->count_all_results($this->_table) > 0;
	}

	public function check_id($id)
	{
		if (!empty($id))
		{
            return $this->db->where('EducationLevelCode', $id)->get($this->_table);
		}
	}

	public function delete($id)
	{
		$delete = $this->db->delete($this->_table, array('EducationLevelCode' => $id));
		if ($delete)
            return true;
        else
            return false;
    }

	public function add($name, array $data)
	{
		if ($this->check($name))
		{
			$this->set_error('group_creation_duplicate_name');
			return FALSE;
		}
		return $this->db->insert($this->_table, $data);
	}

	public function change($id, array $data)
	{
		$result = $this->db->where('EducationLevelCode', $id)
			->count_all_results($this->_table) > 0;

		if ($result == 0)
		{
            $level = $data["EducationLevelName"];
            $category = $data["EducationLevelCategory"];
            $add = array('EducationLevelCode' => $id, 'EducationLevelName' => $level, 'EducationLevelCategory' => $category);
            return $this->add($level, $add);
		} else {
    		$this->db->update($this->_table, $data, array('EducationLevelCode' => $id));
    
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
	    !empty($s_category) ? $this->db->like($this->_category, $this->db->escape_str($s_category)) : '';
	    
	    // Order By
		switch ($skey) {
			case '_name':
				$this->db->order_by($this->_name, $stype);
				break;
			case '_category':
				$this->db->order_by($this->_category, $stype);
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
	    if (!empty($s_name) || !empty($s_category))
            $npage =  ceil($record->num_rows() / $dataperpage);        
	    
	    if ($record->num_rows() > 0) {
	      $n = 1;
	      foreach ($record->result() as $row) {
                $bool_change = $this->auth->_allowed('Dashboard.Reference.Education.Change');
                $bool_delete = $this->auth->_allowed('Dashboard.Reference.Education.Delete');                

                $text = "";
                if ($bool_change || $bool_delete)
                {
                    $text .= "<div class='btn-group'>";
                    if ($bool_change)
                        $text .= "<a class='btn btn-small btn-success' onclick='editE(\"".$row->EducationLevelCode."\", \"".$row->EducationLevelName."\", \"".$row->EducationLevelCategory."\")'>".lang('edit')."</a>";
                    if ($bool_delete)
                        $text .= "<a class='btn btn-small btn-success' onclick='deleteE(\"".$row->EducationLevelCode."\", \"".$row->EducationLevelName."\")'>".lang('hapus')."</a>";
                    $text .= "</div>";
                }
                
                $result['data'][] = array(	
    	          'code' => "{$row->EducationLevelCode}",
    	          'name' => "{$row->EducationLevelName}",
    	          'category' => "{$row->EducationLevelCategory}",
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