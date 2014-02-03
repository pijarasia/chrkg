<?php
/**
 * @author Gita D <gita.dwij@windowslive.com>
 * View reference copy from file&structure Group(@author Trisna G.A.)
 */
class JobApply_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/
	
	protected $_table = 'tbtJobApply';
	protected $primary_key = 'applyID';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;


	//
    //
    // Columns Shortcut
    //
    //
	protected $_id 			 =  'applyID';
	protected $_jobTitle 	 =  'joborderTitle';
	protected $_company 	 =  'companyName';
	protected $_status      =  'StatusProcess';
    
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
		
		return $this->db->where('joborderTitle', $name)
						->count_all_results($this->_table) > 0;
	}

	public function delete($id)
	{
		$delete = $this->db->delete($this->_table, array('applyID' => $id));
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
		$result = $this->db->where('applyID', $id)
			->count_all_results($this->_table) > 0;

		if ($result == 0)
		{
            return false;
		} else {
    		$this->db->update($this->_table, $data, array('applyID' => $id));
    
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

    /**
    * View Tracking Job Apply
    */    
    public function tracking($apply)
    {
        $this->db->select("*");
        $this->db->where("processApplyID", $apply);
        $this->db->join("tbrJobProcessStatus", "tbrJobProcessStatus.StatusProcessID = tbtJobProcessApply.processStatus");
        $this->db->join("tbtSelectionSteps", "tbtSelectionSteps.stepsID = tbtJobProcessApply.processSelectionID");
        $this->db->join("tbmJoborder", "tbmJoborder.joborderID = tbtSelectionSteps.stepsJobID");
        $this->db->join("tbtJobApply", "tbtJobApply.applyID = tbtJobProcessApply.processApplyID");
        //$this->db->join("tbmCompanyDepartment", "tbmCompanyDepartment.companyDepartmentID = tbmJoborder.joborderCompanyDepartmentID");
        //$this->db->join("tbmCompany", "tbmCompanyDepartment.companyDepartmentCompanyID = tbmCompany.companyID");        
        $this->db->join("tbmCompany", "tbmCompany.companyID = tbmJoborder.jobOrderCompanyID");
        $this->db->join("tbrSelectionSteps", "tbtSelectionSteps.stepsSelectionID = tbrSelectionSteps.IDSteps");        
        $this->db->order_by("stepsOrder", "desc");
        $result = $this->db->get('tbtJobProcessApply');        
        return $result;            
    } 
    
    /**
    * View Status Job 
    */    
    public function status_tracking($apply, $joborder)
    {
        $this->db->select("*");
        $this->db->where("processApplyID", $apply);
        $this->db->where("jobOrderID", $joborder);
        $this->db->join("tbrJobProcessStatus", "tbrJobProcessStatus.StatusProcessID = tbtJobProcessApply.processStatus");
        $this->db->join("tbtSelectionSteps", "tbtSelectionSteps.stepsID = tbtJobProcessApply.processSelectionID");
        $this->db->join("tbmJoborder", "tbmJoborder.joborderID = tbtSelectionSteps.stepsJobID");
        $this->db->join("tbtJobApply", "tbtJobApply.applyID = tbtJobProcessApply.processApplyID");
        //$this->db->join("tbmCompanyDepartment", "tbmCompanyDepartment.companyDepartmentID = tbmJoborder.joborderCompanyDepartmentID");
        //$this->db->join("tbmCompany", "tbmCompanyDepartment.companyDepartmentCompanyID = tbmCompany.companyID");        
        $this->db->join("tbmCompany", "tbmCompany.companyID = tbmJoborder.jobOrderCompanyID");
        $this->db->join("tbrSelectionSteps", "tbtSelectionSteps.stepsSelectionID = tbrSelectionSteps.IDSteps");        
        $this->db->order_by("stepsOrder", "desc");
        $result = $this->db->get('tbtJobProcessApply');        
        return $result;            
    }     
    
    /*public function details($jobID)
    {
        $this->db->select("*, DATEDIFF(d, GETDATE(), DATEADD(DAY, joborderDuration, joborderStartDate)) AS RemainingTime, DATEADD(DAY, joborderDuration, cast(convert(char(8), joborderStartDate, 112) + ' 23:59:59.99' as datetime)) as joborderEndDate");
        $this->db->where("joborderID = '".$jobID."'");
        $this->db->join("tbtJobApply", "tbtJobApply.applyJobID = tbmJoborder.joborderID", "left");
        $this->db->join("tbmCompanyDepartment", "tbmCompanyDepartment.companyDepartmentID = tbmJoborder.joborderCompanyDepartmentID");
        $this->db->join("tbmCompany", "tbmCompanyDepartment.companyDepartmentCompanyID = tbmCompany.companyID");
        $this->db->join("tbrEmploymentType", "tbrEmploymentType.EmploymentTypeID = tbmJoborder.joborderType");
        $result = $this->db->get('tbmJoborder');        
        return $result;                   
    }*/
    
    
	public function record($applicant)
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
	    
        $this->db->where("applyApplicantID", $applicant);
        $this->db->where("applyCancel", 0);
        $this->db->join("tbmJoborder", "tbmJoborder.joborderID = tbtJobApply.applyJobID");
        //$this->db->join("tbmCompanyDepartment", "tbmCompanyDepartment.companyDepartmentID = tbmJoborder.joborderCompanyDepartmentID");
        //$this->db->join("tbmCompany", "tbmCompanyDepartment.companyDepartmentCompanyID = tbmCompany.companyID");
        $this->db->join("tbmCompany", "tbmCompany.companyID = tbmJoborder.jobOrderCompanyID");
        $this->db->join("tbrEmploymentType", "tbrEmploymentType.EmploymentTypeID = tbmJoborder.joborderType");
        /*$this->db->join("tbtJobProcessApply", "tbtJobApply.applyID = tbtJobProcessApply.processApplyID");
        $this->db->join("tbrJobProcessStatus", "tbtJobProcessApply.processStatus = tbrJobProcessStatus.StatusProcessID");*/

	    // Where (query)
	    if (!empty($s_posisi))
        { 
            $this->db->where($this->_jobTitle." like '%".$this->db->escape_str($s_posisi)."%' or ".$this->_company." like '%".$this->db->escape_str($s_posisi)."%' ");
        } else
            echo '';
	    
	    // Order By
		switch ($skey) {
			case '_jobTitle':
				$this->db->order_by($this->_jobTitle, $stype);
				break;
			case '_status':
				$this->db->order_by($this->_status, $stype);
				break;
			default:
				$this->db->order_by('applyDate', 'DESC');
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

	    if ($record->num_rows() > 0) {
	      $n = 1;
	      foreach ($record->result() as $row) {
	       
            $tracking = $this->tracking($row->applyID);
            $steps = "-";
            $status = "-";
            if($tracking->num_rows() > 0)
            {
                $rowt = $tracking->row();
                $steps = $rowt->Steps;                     
                $status = $rowt->StatusProcess;
            }
                           
            /*foreach ($recordJob->result() as $res)
            {
                $this->db->where("applyID", $res->applyID);
                $this->db->join("tbtJobProcessApply", "tbtJobApply.applyID = tbtJobProcessApply.processApplyID");
                $this->db->join("tbrJobProcessStatus", "tbtJobProcessApply.processStatus = tbrJobProcessStatus.StatusProcessID");
                $this->db->join("tbtSelectionSteps", "tbtJobProcessApply.processSelectionID = tbtSelectionSteps.stepsID");
                $result = $this->db->get('tbtJobApply');        
            }
            $record = $result;*/
                           
                       
            $result['data'][] = array(	
	          'id' => "{$row->applyID}",
	          'posisi' => '<a style="cursor:pointer;" onclick="vacancyDetails(\''.$row->joborderID.'\')">'.$row->joborderTitle.' ('.$row->companyName.')</a>',
	          'jenis' => "{$steps}",
	          'status' => "{$status}",
	          'action' => '<a class="btn btn-small" id="trackingApply" onclick="trackingApply(\''.$row->applyID.'\', \''.$row->joborderID.'\')"><li class="icon-list-alt"></li>&nbsp;'.lang("tracking").'</a>&nbsp
                            <a class="btn btn-small" id="cancelJob" onclick="cancelApply('.$row->applyID.')" ><li class="icon-remove"></li>&nbsp;'.lang("batal").'</a>'
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