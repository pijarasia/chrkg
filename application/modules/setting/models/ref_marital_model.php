<?php

class Ref_Marital_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/
	
	protected $_table = 'tbrMaritalStatus';
	protected $primary_key = 'MaritalCode';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;


	//
    //
    // Columns Shortcut
    //
    //
	protected $_id 		   =  'MaritalCode';
	protected $_name 	   =  'MaritalName';
	protected $_english    =  'MaritalEnglish';
	protected $_order      =  'MaritalOrder';
    
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
		
		return $this->db->where('MaritalName', $name)
						->count_all_results($this->_table) > 0;
	}

	public function check_id($id)
	{
		if (!empty($id))
		{
            return $this->db->where('MaritalCode', $id)->get($this->_table);
		}
	}

	public function delete($id)
	{
		$cek = $this->db->where('MaritalCode', $id)->get($this->_table)->row();
        $delete = $this->db->delete($this->_table, array('MaritalCode' => $id));
        
        $this->change_order($cek->MaritalOrder, "delete");
        
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
        $this->change_order($data["MaritalOrder"], "insert");
        $insert = $this->db->insert($this->_table, $data);
		return $insert;
	}

	public function change($id, array $data)
	{
		$result = $this->db->where('MaritalCode', $id)
			->count_all_results($this->_table) > 0;

		if ($result == 0)
		{
            $name = $data["MaritalName"];
            $english = $data["MaritalEnglish"];
            $order = $data["MaritalOrder"];
            $add = array('MaritalCode' => $id, 'MaritalName' => $name, 'MaritalEnglish' => $english, 'MaritalOrder' => $order);
            return $this->add($level, $add);
		} else {
            $this->change_order($data["MaritalOrder"], "update");		  
    		$this->db->update($this->_table, $data, array('MaritalCode' => $id));
    
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
    
	public function check_order($order = '')
	{
		if (empty($order))
			return FALSE;
		
		return $this->db->where('MaritalOrder', $order)->get($this->_table);
	}    
    
	public function change_order($order, $stts)
	{
		$result = $this->db->where('MaritalOrder', $order)->count_all_results($this->_table);

		if ($result == 0)
        {
            if ($stts == "delete")
            {
                $cek_data = $this->db->count_all_results($this->_table);
                $tmbh = ((int)$order)+1; //5
                do{
                    $cek = $this->check_order($tmbh)->num_rows();  
                    $row = $this->check_order($tmbh)->row();
                    $krg = ((int)$tmbh)-1; //4
                    $this->db->update($this->_table, array('MaritalOrder' => $krg), array('MaritalCode' => $row->MaritalCode));
                    $tmbh++;
                } while(($tmbh-1) == $cek_data);
            }
		} 
        else 
        {
            $cek = 1;
            $cek_data = $this->db->count_all_results($this->_table);
            do{
                $cek = $this->check_order($order)->num_rows(); //3 //4   
                $row = $this->check_order($order)->row(); //3 //4
                $tmbh = ((int)$row->MaritalOrder)+1; //4 //5
                if (($tmbh <= $cek_data && $stts == "update") || $stts == "insert")
                {
                    $this->change_order($tmbh, $stts); //4 //5
                    $this->db->update($this->_table, array('MaritalOrder' => $tmbh), array('MaritalCode' => $row->MaritalCode));
                }
            } while($cek == 0);
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
	    if (!empty($s_name))
        { 
            $this->db->where($this->_name." like '%".$this->db->escape_str($s_name)."%' or ".$this->_english." like '%".$this->db->escape_str($s_name)."%' ");
        } else
            echo '';
	    
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
                $bool_change = $this->auth->_allowed('Dashboard.Reference.Marital.Change');
                $bool_delete = $this->auth->_allowed('Dashboard.Reference.Marital.Delete');                

                $text = "";
                if ($bool_change || $bool_delete)
                {
                    $text .= "<div class='btn-group'>";
                    if ($bool_change)
                        $text .= "<a class='btn btn-small btn-success' onclick='editM(\"".$row->MaritalCode."\", \"".$row->MaritalName."\", \"".$row->MaritalEnglish."\", \"".$row->MaritalOrder."\")'>".lang('edit')."</a>";
                    if ($bool_delete)
                        $text .= "<a class='btn btn-small btn-success' onclick='deleteM(\"".$row->MaritalCode."\", \"".$row->MaritalName."\")'>".lang('hapus')."</a>";
                    $text .= "</div>";
                }
           
                $result['data'][] = array(	
    	          'code' => "{$row->MaritalCode}",
    	          'name' => "{$row->MaritalName}",
    	          'english' => "{$row->MaritalEnglish}",
    	          'order' => "{$row->MaritalOrder}",
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