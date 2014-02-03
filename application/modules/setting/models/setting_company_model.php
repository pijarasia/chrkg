<?php
class Setting_Company_Model extends MY_Model
{
	/**
	 * Init protected variable for model
	 *
	 * @var string
	 **/

	protected $_table = 'tbmCompany';
	protected $primary_key = 'companyID';
	protected $soft_delete = FALSE;
    protected $soft_delete_key = 'deleted';
    protected $_temporary_with_deleted = FALSE;


	//
    //
    // Columns Shortcut
    //
    //
	protected $_name 		 =  'companyName';
	protected $_phone1		 =  'companyPhone1';
	protected $_phone2		 =  'companyPhone2';
	protected $_fax			 =  'companyFax';
	protected $_address		 =  'companyAddress';
	protected $_city		 =  'companyCity';
	protected $_state		 =  'companyState';
	protected $_postal_code	 =  'companyPostalCode';
	protected $_url		 	 =  'companyUrl';
	protected $_created	 	 =  'companyCreated';
	protected $_updated		 =  'companyUpdated';
	protected $_email		 =  'companyEmail';
	protected $_notes		 =  'companyNotes';
	protected $_logo		 =  'companyLogo';
	protected $_business_area =  'companyBusinessArea';


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
			$this->set_error('company_creation_duplicate_name');
			return FALSE;
		}
		$this->set_message('company_creation_successful');
		return $this->db->insert($this->_table, $data);
	}

	public function change(array $data,$id = null){
		$result = $this->db->where($this->primary_key, $id)
			->count_all_results($this->_table) > 0;
		if (count($result) == 0)
		{
			$this->set_error('company_change_unsuccessful');
			return FALSE;
		}
		unset($data[$this->_created]);
		$this->db->update($this->_table, $data, array($this->primary_key => $id));
		$return = $this->db->affected_rows() == 1;
		if ($return)
		{
			$this->set_message('company_change_successful');
		}
		else
		{
			$this->set_error('company_change_unsuccessful');
		}
		return $return;
	}


	public function check($name = '')
	{
		if (empty($name))
		{
			return FALSE;
		}

		return $this->db->where($this->_name, $name)
						->count_all_results($this->_table) > 0;
	}

	public function delete()
	{
		$form_data = array('id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$delete = $this->db->delete($this->_table, array($this->primary_key => $data['id']));
		if ($delete){
			$this->set_message('company_delete_successful');
            $this->_aj['status'] = 'success';
			$this->_aj['message'] = $this->messages;
		}else {
			$this->set_error('company_delete_unsuccessful');
            $this->_aj['status'] = 'error';
			$this->_aj['message'] = $this->errors;
		}
		echo json_encode($this->_aj, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
    }

	public function form(){
		$form_data = array('company_id','name','phone1','phone2', 'fax','address','city','state','postal_code','url','email','logo','business_area','hidden_id');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		$memo = array(
			$this->_name => $data['name'],
			$this->_phone1 => $data['phone1'],
			$this->_phone2 => $data['phone2'],
			$this->_fax => $data['fax'],
			$this->_address => $data['address'],
			$this->_city => $data['city'],
			$this->_state => $data['state'],
			$this->_postal_code => $data['postal_code'],
			$this->_url => $data['url'],
			$this->_created => date("Y-m-d H:i:s"),
			$this->_updated => date("Y-m-d H:i:s"),
			$this->_email => $data['email'],
			$this->_logo => $data['logo'],
			$this->_business_area => $data['business_area'],

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

	public function form_upload(){
		$form_data = array('hidden_id','image');
		foreach ($form_data as $val)
  			$data[$val] = $this->input->post($val);

		// Path to the front controller (this file)
		define('COMPANY_LOGO', FCPATH.'public/assets/images/company_logo');
		$config = array(
			'upload_path' => COMPANY_LOGO,
			'allowed_types' => 'gif|jpg|png',
			'max_size'	=> '100',
			'max_width'  => '1024',
			'max_height'  => '768',
			'overwrite' => true
		);
		$this->load->library('upload', $config);
		if ($this->upload->do_upload('image')){
			$image = $this->upload->data();
			if($this->db->update($this->_table, array($this->_logo => $image['file_name'].time()), array($this->primary_key => $data['hidden_id'])) == TRUE){
				$this->set_message('company_upload_successful');
	            $this->_aj['status'] = 'success';
				$this->_aj['message'] = $this->messages;
			}else{
				$this->set_error('company_upload_unsuccessful');
	            $this->_aj['status'] = 'error';
				$this->_aj['message'] = $this->errors;
			}
		}else {
			$this->set_error($this->upload->display_errors());
            $this->_aj['status'] = 'error';
			$this->_aj['message'] = $this->errors;
		}
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

	    $total = $this->record_count($s_name, $s_business_area);
	    $npage = ceil($total / $dataperpage);

	    !empty($s_name) ? $this->db->like($this->_name, $this->db->escape_str($s_name)) : '';
	    !empty($s_business_area) ? $this->db->like($this->_business_area, $this->db->escape_str($s_business_area)) : '';
	    // Order By
		switch ($skey) {
			case '_name':
				$this->db->order_by($this->_name, $stype);
				break;
			case '_url':
				$this->db->order_by($this->_url, $stype);
				break;
			case '_email':
				$this->db->order_by($this->_email, $stype);
				break;
			case '_phone1':
				$this->db->order_by($this->_phone1, $stype);
				break;
			case '_phone2':
				$this->db->order_by($this->_phone2, $stype);
				break;
			case '_fax':
				$this->db->order_by($this->_fax, $stype);
				break;
			default:
				$this->db->order_by($this->_name, 'ASC');
				break;
		}

		$record = $this->db
					->limit($dataperpage, $start)
					->get($this->_table);

		$now = base_url()."usermanagement/company/";
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
	      foreach ($record->result_array() as $row) {
	      	$logo = $row[$this->_logo] ? "<img src='".base_url()."public/assets/images/company_logo/{$row[$this->_logo]}' alt='Logo' width='50' class='img-rounded'>" : '';
	      	$serial = array(
	      		'name' => $row[$this->_name],
	      		'phone1' => $row[$this->_phone1],
	      		'phone2' => $row[$this->_phone2],
	      		'address' => $row[$this->_address],
	      		'fax' => $row[$this->_fax],
	      		'city' => $row[$this->_city],
	      		'state' => $row[$this->_state],
	      		'postal_code' => $row[$this->_postal_code],
	      		'url' => $row[$this->_url],
	      		'email' => $row[$this->_email],
	      		'notes' => $row[$this->_notes],
	      		'logo' => $row[$this->_logo],
	      		'business_area' => $row[$this->_business_area],
	      		);
	      	$js=htmlspecialchars(json_encode($serial));
	      	$action['edit'] = $this->auth->_allowed('Dashboard.Company.Form.Edit') ? '<a class="btn btn-small btn-success" onclick="editG(\''.$row[$this->primary_key].'\', \''.$js.'\')"><i class="icon-pencil"></i></a>' : '';
	      	$action['upload'] = $this->auth->_allowed('Dashboard.Company.Company.Permission') ? '<a class="btn btn-small btn-success" onclick="uploadG(\''.$row[$this->primary_key].'\', \''.$js.'\')"><i class="icon-paperclip"></i></a>' : '';
	      	$action['delete'] = $this->auth->_allowed('Dashboard.Company.Delete') ? '<a class="btn btn-small btn-success" onclick="deleteG(\''.$row[$this->primary_key].'\')"><i class="icon-trash"></i></a>' : '';
	        $result['data'][] = array(
	          'logo' => $logo,
	          'name' => "{$row[$this->_name]}",
	          'url' => "{$row[$this->_url]}",
	          'email' => "{$row[$this->_email]}",
	          'phone1' => "{$row[$this->_phone1]}",
	          'phone2' => "{$row[$this->_phone2]}",
	          'fax' => "{$row[$this->_fax]}",
	          'action' => "<div class='btn-group'>{$action['edit']}{$action['upload']}{$action['delete']}</div>"
	        );
	      }
	    }
	    echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
	}

	public function record_count($s_name = NULL, $s_business_area = NULL){
	    // Where (query)
	    !empty($s_name) ? $this->db->like($this->_name, $this->db->escape_str($s_name)) : '';
	    !empty($s_business_area) ? $this->db->like($this->_business_area, $this->db->escape_str($s_business_area)) : '';

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