<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Candidates extends Admin_Controller {

	function __construct()
	{
		parent::__construct();
        $this->load->model('Candidates_Model','candidates',TRUE);
        $this->load->model('setting/reference_model','reference',TRUE);
        $this->load->model('auth/register_model','register',TRUE);
        $this->load->model('applicant/applicant_model','applicant',TRUE);
        $this->load->vars(array(
            'navigation' => 'nav-candidates'
        ));
	}

    public function index()
    {
        if (!$this->auth->logged_in())
        {
            redirect($this->config->item('base_url'), 'refresh');
        }
        $this->auth->_have_permission('Dashboard.Candidates.View');
        $data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

        $this->load->vars(array(
            'title' => "Candidates :: List",
            'option' => array(
                's_group' => $this->_format_dropdown($this->reference->referensi_group_candidate(),'AppLevelListID','AppLevelListLevelName'))
            ));
        $data = array(
            's_gr' => array('name' => 's_group',
                    'id' => 's_group',
                    'class' => 'selectpicker show-tick show-menu-arrow input-xlarge',
                    'label' => 'Group'
                    ),
        );

        Assets::clear_cache();
        Assets::add_css('bootstrap-sortable.css');
        Assets::add_module_css('usermanagement','custom.css');
        Assets::add_css('custom.dialog.css');
        Assets::add_js('jquery.bootpag.js');
        Assets::add_js(
            $this->load->view('js/get_candidates',
                array(
                    'total' => $this->candidates->count_all()), true),'inline');
        Assets::add_js( $this->load->view('js/ready', array('total' => $this->candidates->count_all()), true) , 'inline');
        Assets::add_js('jquery.validate.min.js');

        if ($this->input->is_ajax_request()) {
            $this->candidates->record();
        }else {
            Template::set($data);
            Template::render();
        }
    }

    public function _format_dropdown($results,$key,$value,$def = ''){
        $options = $def == '' ? array('' => 'Please select ....') : array();
        foreach ($results->result_array() as $rows)
        {
            $options[$rows[$key]] = $rows[$value];
        }
        return $options;
    }

    //Gita 6 Okt
    function view_profile()
    {
        if ($_POST["email"] != "")
        {
            $this->session->set_userdata("view_profil", $_POST["email"]);
            echo 1;
        } else
            echo 0;
    }

    function choose()
    {
        if ($_POST["ajax"])
        {
            if ($_POST["id"] != "")
            {
                $person = $this->applicant->get_person($_POST["email"]);
                $get_person = $person->row();
                if ($person->num_rows() > 0)
                {
                    $photo = $get_person->aplPhoto;
                }else{
                    $photo = "";
                }

                if ($photo == "")
                    $photo = base_url()."public/assets/images/icon-user.png";
                else
                {
                    //$rpath = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\archives\photo";
                    $base = base_url()."archives/photo/".$photo;
                    $exists = @fopen($base,"r");
                    if($exists){
                        $url = getimagesize($base);
                        if (is_array($url))
                            $photo = base_url()."archives/photo/".$photo;
                        else
                            $photo = base_url()."public/assets/images/icon-user.png";

                        fclose($datei);
                    } else
                        $photo = base_url()."public/assets/images/icon-user.png";
                }

                $cetak = '<div class="content-inner well" style="padding: 40px 20px; min-height: 530px;">
                            <div class="row-fluid">
                                <div class="span3" style="text-align: center;">
                                    <img src="'.$photo.'" width="180"/>
                                    <br />
                                    <h4>'.$get_person->AppUserListFirstName.' '.$get_person->AppUserListLastName.'</h4>
                                </div>
                                <div class="span9">
                                    <button class="btn btn-large btn-block btn-info" type="button" onclick="view_profile(\''.$_POST["email"].'\')">Profile Candidate</button>
                                    <button class="btn btn-large btn-block btn-info" type="button" onclick="view_job(\''.$_POST["email"].'\')">List of Job Application</button>
                                </div>

                            </div>
                            <div style="text-align: right;position:relative;top:300px;">
                                <a class="btn btn-small" onclick="back()"><li class="icon-repeat"></li>&nbsp;Kembali</a>
                            </div>
                        </div>';

                echo $cetak;
            }
        }
    }
}

