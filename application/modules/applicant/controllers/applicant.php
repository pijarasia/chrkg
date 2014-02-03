<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author Gita D <gita.dwij@windowslive.com>
* @created 10 May, 2013
* 
**/
class Applicant extends Admin_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('applicant_model','applicant',TRUE);
        $this->load->model('setting/reference_model','reference',TRUE);
        $this->load->model('setting/ref_marital_model','ref_marital',TRUE);
        $this->load->model('setting/ref_religion_model','ref_religion',TRUE);
        $this->load->model('setting/ref_education_model','ref_education',TRUE);
        $this->load->model('vacancy/vacancy_model','vacancy',TRUE);

        if ($this->session->userdata('language') == "")
        {
            $this->session->set_userdata('language', "bahasa");
            $lang = "bahasa";
        }else
            $lang = $this->session->userdata('language');
        
        $this->lang->load('form',$lang);     
        
		$this->load->vars(array(
			'title' => 'Candidates',
			'navigation' => 'nav-candidates'
		));                                       
    }
    
/**
* Load View Form
*/        
	public function form()
	{
		if (!$this->auth->logged_in() || $this->auth->is_admin())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}
		else
		{
            $cek_step = $this->vacancy->cek_process_apply_stepcv($this->session->userdata('email'))->num_rows();
            if ($cek_step > 0)
                Template::redirect('applicant/data');
            else
            {		  
                $data["language"] = $this->session->userdata('language'); 
                     
                $this->load->vars(array('title' => lang("lamaran")));
                
                $data["agama"] = $this->reference->referensi_agama();
                $data["golDarah"] = $this->reference->referensi_golDarah();
                $data["marital"] = $this->reference->referensi_marital();
                $data["bulan"] = $this->reference->referensi_bulan();   
                $data["tanda_pengenal"] = $this->reference->referensi_tanda_pengenal();   
                $data["pendidikan"] = $this->reference->referensi_jenjang_pendidikan(); 
                $data["negara"] = $this->reference->referensi_negara();   
        
                //$getPerson = $this->applicant->get_person($this->session->userdata('email'), "123456789"); //ganti dg email session
                //$getPerson = $this->applicant->get_person($this->session->userdata('email')); //ganti dg email session
                //$getPerson = $getPerson->row();
                $getPerson = $this->applicant->get_person($this->session->userdata('email'))->row();
    
                //if (count($getPerson) > 0)
                //{
                if ($getPerson->AppUserLevelLevelID == 10 || $getPerson->AppUserLevelLevelID == 11) //level for internal/external candidates
                {
                    /*Tab 1*/
                    $data["aplName"] = $getPerson->AppUserListFirstName." ".$getPerson->AppUserListLastName;
                    $data["Age"] = $getPerson->Age;
                    $data["aplSex"] = $getPerson->aplSex;
                    $data["aplPlaceOfBirth"] = $getPerson->aplPlaceOfBirth;
                    $data["aplDateOfBirth"] = $getPerson->aplDateOfBirth;
                    $data["aplIdentityNumber"] = $getPerson->aplIdentityNumber;
                    $data["aplIdentityValid"] = $getPerson->aplIdentityValid;
                    $data["aplMaritalStatus"] = $getPerson->aplMaritalStatus;
                    $data["aplReligion"] = $getPerson->aplReligion;
                    $data["aplEmail"] = $getPerson->AppUserListEmail;
                    $data["aplAlternateEmail"] = $getPerson->aplAlternateEmail;
                    $data["aplCellular"] = $getPerson->AppUserListPhone;
                    $data["aplAlternateCellular"] = $getPerson->aplAlternateCellular;
        
                    //Tab 5
                    $data["aplExpectedSalary"] = $getPerson->aplExpectedSalary;
                    /*End Tab 1*/
                    
                    /*Tab 2*/
                    $getLastEducation = $this->applicant->check_last_education($getPerson->aplPersonID);       
                    if (count($getLastEducation) > 0)
                    {        
                        $data["aplEducationLevel"] = $getLastEducation->aplEducationLevel;
                        $data["aplEducationInstitution"] = $getLastEducation->aplEducationInstitution;
                        $data["aplEducationMajor"] = $getLastEducation->aplEducationMajor;
                        $data["aplEducationCity"] = $getLastEducation->aplEducationCity;
                        $data["aplEducationCountry"] = $getLastEducation->aplEducationCountry;
                        $data["aplEducationYearStart"] = $getLastEducation->aplEducationYearStart;
                        $data["aplEducationYearEnd"] = $getLastEducation->aplEducationYearEnd;
                        $data["aplEducationGPA"] = $getLastEducation->aplEducationGPA;
                        $data["aplEducationCert"] = $getLastEducation->aplEducationCert;
                        $data["aplEducationDegree"] = $getLastEducation->aplEducationDegree;
                        $data["aplEducationDegreePos"] = $getLastEducation->aplEducationDegreePos;
                        $data["aplEducationGraduate"] = $getLastEducation->aplEducationGraduate;
                    } else {
                        $data["aplEducationLevel"] = "";
                        $data["aplEducationInstitution"] = "";
                        $data["aplEducationMajor"] = "";
                        $data["aplEducationCity"] = "";
                        $data["aplEducationCountry"] = "";
                        $data["aplEducationYearStart"] = "";
                        $data["aplEducationYearEnd"] = "";
                        $data["aplEducationGPA"] = "";
                        $data["aplEducationCert"] = "";                   
                        $data["aplEducationDegree"] = "";
                        $data["aplEducationDegreePos"] = "";
                        $data["aplEducationGraduate"] = "";                            
                    }
                    /*End Tab 2*/
                    
                    /*Tab 3*/
                    $data["aplCouseName"] = "";
                    $data["aplCourseStart"] = "";
                    $data["aplCourseEnd"] = "";
                    $data["aplCourseOrganizer"] = "";
                    $data["aplCourseCity"] = "";            
                    $data["aplCourseNoCertificate"] = "";  
                    
                    $data["allCourse"] = $this->applicant->view_course($getPerson->aplPersonID);
                    
                    $data["aplWorkExCompany"] = "";
                    $data["aplWorkExAddress"] = "";
                    $data["aplWorkExCity"] = "";
                    $data["aplWorkPhoneNumber"] = "";
                    $data["aplWorkExLastSpv"] = "";            
                    $data["aplWorkExPosition"] = "";             
                    $data["aplWorkExStart"] = "";
                    $data["aplWorkExEnd"] = "";
                    $data["aplWorkExStartSalary"] = "";
                    $data["aplWorkExEndSalary"] = "";
                    $data["aplWorkExDescription"] = "";            
                    $data["aplWorkExReasonLeave"] = "";               
        
                    $data["allWork"] = $this->applicant->view_work($getPerson->aplPersonID);
                } else {  
                    $data["pesan"] = lang('login_kandidat');
    
                    $data["aplName"] = "";
                    $data["Age"] = "";            
                    $data["aplSex"] = "";
                    $data["aplPlaceOfBirth"] = "";
                    $data["aplDateOfBirth"] = "";
                    $data["aplIdentityNumber"] = "";
                    $data["aplMaritalStatus"] = "";
                    $data["aplReligion"] = "";
                    $data["aplEmail"] = "";
                    $data["aplAlternateEmail"] = "";
                    $data["aplCellular"] = "";
                    $data["aplAlternateCellular"] = "";
                    
                    $data["aplEducationLevel"] = "";
                    $data["aplEducationInstitution"] = "";
                    $data["aplEducationMajor"] = "";
                    $data["aplEducationCity"] = "";
                    $data["aplEducationCountry"] = "";
                    $data["aplEducationYearStart"] = "";
                    $data["aplEducationYearEnd"] = "";
                    $data["aplEducationGPA"] = "";
                    $data["aplEducationCert"] = "";   
                    $data["aplEducationDegree"] = "";
                    $data["aplEducationDegreePos"] = "";
                    $data["aplEducationGraduate"] = "";                            
                                    
                    $data["aplCouseName"] = "";
                    $data["aplCourseStart"] = "";
                    $data["aplCourseEnd"] = "";
                    $data["aplCourseOrganizer"] = "";
                    $data["aplCourseCity"] = "";            
                    $data["aplCourseNoCertificate"] = "";    
                    
                    $data["aplWorkExCompany"] = "";
                    $data["aplWorkExAddress"] = "";
                    $data["aplWorkExCity"] = "";
                    $data["aplWorkPhoneNumber"] = "";
                    $data["aplWorkExLastSpv"] = "";            
                    $data["aplWorkExPosition"] = "";             
                    $data["aplWorkExStart"] = "";
                    $data["aplWorkExEnd"] = "";
                    $data["aplWorkExStartSalary"] = "";
                    $data["aplWorkExEndSalary"] = "";
                    $data["aplWorkExDescription"] = "";            
                    $data["aplWorkExReasonLeave"] = "";             
        
                    $data["allCourse"] = "";                                   
        
                    $data["aplExpectedSalary"] = "";
                } 
                
                Assets::clear_cache();
                Assets::add_js('jquery.validate.min.js'); 
                Assets::add_js('jquery.bootstrap.wizard.js'); 
                Assets::add_js( $this->load->view('js/js_form', null, true),'inline'); 
                Assets::add_css('custom.css'); 
                Assets::add_module_css('applicant','custom.css'); 
                Assets::add_css('custom.dialog.css'); 
                                
                Template::set($data);
                Template::render();
            }
        }	           
	}       
    
    /*
    * Add Personal Data
    */        
    public function addfirst_personal()
    {
        if ($this->input->post('ajax'))
        {
            $nama = $this->input->post('nama');
            $jk = $this->input->post('jk');
            $tmptlahir = $this->input->post('tmptlahir');
            $tanggal = $this->input->post('tanggal');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $tgllahir = $tahun."-".$bulan."-".$tanggal;            
            $no_identitas = $this->input->post('no_identitas');
            $tanggalberlaku = $this->input->post('tanggalberlaku');
            $bulanberlaku = $this->input->post('bulanberlaku');
            $tahunberlaku = $this->input->post('tahunberlaku');
            $berlaku = $tahunberlaku."-".$bulanberlaku."-".$tanggalberlaku;            
            $statusMarital = $this->input->post('statusMarital');
            $agama = $this->input->post('agama');
            $email = $this->input->post('email');
            $alternatif_email = $this->input->post('alternatif_email');
            $nohp = $this->input->post('nohp');
            $alternatif_nohp = $this->input->post('alternatif_nohp');
            
            $this->load->model('auth/register_model','',TRUE);        
            $name = $this->register_model->explode_name($nama);
            echo $this->applicant->addfirst_personal($name[0], $name[1], $jk, $tmptlahir, $tgllahir, $no_identitas, $berlaku, $statusMarital, $agama, $email, $alternatif_email, $nohp, $alternatif_nohp);
        }
    }    
    
/**
* Load View data
*/    
	public function data()
	{
	    if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}
		else
		{	  
            //set the flash data error message if there is one
    		$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');
    	          	
            $this->load->vars(array('title' => lang("lamaran")."<span id='data'> :: Data Diri</span>"));
    
            $data["language"] = $this->session->userdata('language');
    
        	//$this->auth->_have_permission('FrontEnd.Photo.View');
                                        
            //$getPerson = $this->load_person();
            $person = $this->applicant->get_person($this->session->userdata('email'));
            $get_person = $person->row();
            if ($get_person->AppUserLevelLevelID == 10 || $get_person->AppUserLevelLevelID == 11) //level for internal/external candidates
            {                
                $cek_step = $this->vacancy->cek_process_apply_stepcv($this->session->userdata('email'))->num_rows();
                if ($cek_step == 0)
                    Template::redirect('applicant/form');
                else
                {
                    if ($person->num_rows() > 0)
                    {
                        $photo = $get_person->aplPhoto;
                        $person = $get_person->aplPersonID;
                    }else{
                        $photo = "";            
                        $person = "";
                    }
                        
                    if ($photo == "")
                        $photo = base_url()."public/assets/images/icon-user.png";
                    else
                    {
                        $url = getimagesize(base_url()."archives/photo/".$photo);
                                            
                        if (is_array($url))
                            $photo = base_url()."archives/photo/".$photo;
                        else 
                            $photo = base_url()."public/assets/images/icon-user.png";
                    }
                                                    
                    $data["photo"] = $photo;
                    $data["person"] = $person;
        
                    $data["bool_upload"] = $this->auth->_allowed('FrontEnd.Photo.Upload');
                                             
                    Assets::clear_cache();
                    Assets::add_js('jquery.validate.min.js'); 
                    Assets::add_js( $this->load->view('js/js_data', null, true),'inline'); 
                    Assets::add_module_css('applicant','custom.css'); 
                    Assets::add_css('custom.dialog.css'); 
                    Assets::add_js('bootstrap.file-input.js');     
                }
            } 
            else
            {
                //$this->session->set_userdata("view_profil", "gita.dwijayanti@yahoo.com");
                if ($this->session->userdata('view_profil') != "")
                {
                    $person = $this->applicant->get_person($this->session->userdata('view_profil'));
                    $get_person = $person->row();
        
                    if ($person->num_rows() > 0)
                    {
                        $photo = $get_person->aplPhoto;
                        $person = $get_person->aplPersonID;
                    }else{
                        $photo = "";            
                        $person = "";
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
                                                    
                    $data["photo"] = $photo;
                    $data["person"] = $person;

                    $data["bool_upload"] = $this->auth->_allowed('FrontEnd.Photo.Upload');
                } else
                    redirect($this->config->item('base_url'), 'refresh');       
                                            
                Assets::clear_cache();
                Assets::add_js('jquery.validate.min.js'); 
                Assets::add_js( $this->load->view('js/js_data', null, true),'inline'); 
                Assets::add_module_css('applicant','custom.css'); 
                Assets::add_css('custom.dialog.css'); 
                Assets::add_js('bootstrap.file-input.js');                 
            }
            Template::set($data);
            Template::render();    
        }        
	}        
    
    public function load_person()
    {
        //jika view profil tidak kosong, artinya sedang berstatus admin yang akan melihat profil 
        if ($this->session->userdata('view_profil') != "") {
            $lihat = $this->session->userdata('view_profil');
            //hanya melihat
            $this->session->set_userdata("view", true);
        } else {
            $lihat = $this->session->userdata('email');     
            //hanya melihat
            $this->session->set_userdata("view", false);
        }
        
        $getPerson = $this->applicant->get_person($lihat); 
        $getPerson = $getPerson->row();
        if (count($getPerson) > 0)
            return $getPerson;
        else
            return null;
    }
    
	public function data_diri()
	{
        $data["language"] = $this->session->userdata('language');      
        
        
        $data["agama"] = $this->reference->referensi_agama();
        $data["golDarah"] = $this->reference->referensi_golDarah();
        $data["marital"] = $this->reference->referensi_marital();
        $data["bulan"] = $this->reference->referensi_bulan();   
        $data["tanda_pengenal"] = $this->reference->referensi_tanda_pengenal();   

		$this->auth->_have_permission('FrontEnd.PersonalData.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.PersonalData.Add');

        $getPerson = $this->load_person();
        if (count($getPerson) > 0)
        {
            /*Tab 1*/
            $data["aplName"] = $getPerson->AppUserListFirstName." ".$getPerson->AppUserListLastName;
            $data["Age"] = $getPerson->Age;
            $data["aplSex"] = $getPerson->aplSex;
            $data["aplPlaceOfBirth"] = $getPerson->aplPlaceOfBirth;
            $data["aplDateOfBirth"] = $getPerson->aplDateOfBirth;
            $data["aplIdentityNumber"] = $getPerson->aplIdentityNumber;
            $data["aplIdentityValid"] = $getPerson->aplIdentityValid;
            $data["aplMaritalStatus"] = $getPerson->aplMaritalStatus;

            if ($getPerson->aplMaritalStatus != "")
            {
                $cek_marital = $this->ref_marital->check_id($getPerson->aplMaritalStatus)->row();
                if ($data["language"]=="bahasa")
                    $status = $cek_marital->MaritalName;
                else
                    $status = $cek_marital->MaritalEnglish;                                                        
                $data["aplMaritalStatusName"] = $status;
            }

            if ($getPerson->aplReligion != "")
            {
                $data["aplReligion"] = $getPerson->aplReligion;
                $cek_agama = $this->ref_religion->check_id($getPerson->aplReligion)->row();
                $data["aplReligionName"] = $cek_agama->ReligionName;
            }
            
            $data["aplEmail"] = $getPerson->AppUserListEmail;
            $data["aplAlternateEmail"] = $getPerson->aplAlternateEmail;
            $data["aplCellular"] = $getPerson->AppUserListPhone;
            $data["aplAlternateCellular"] = $getPerson->aplAlternateCellular;                                  
        }

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_data_diri', null, true),'inline'); 
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline'); 
        Assets::add_module_css('applicant','custom.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}     
    
	public function data_pelatihan()
	{
        $data["language"] = $this->session->userdata('language');      
        
        $data["bulan"] = $this->reference->referensi_bulan();   
                
		$this->auth->_have_permission('FrontEnd.Course.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Course.Add');
                
        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_pelatihan', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}      
    
	public function data_pengalaman()
	{
        $data["language"] = $this->session->userdata('language');      
        
        $data["bulan"] = $this->reference->referensi_bulan();   

		$this->auth->_have_permission('FrontEnd.Work.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Work.Add');
                
        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_pengalaman', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}      
	
	public function data_pendidikan()
	{
        $data["language"] = $this->session->userdata('language');      
        
        $data["ref_pendidikan"] = $this->reference->referensi_jenjang_pendidikan(); 
        $data["negara"] = $this->reference->referensi_negara();

		$this->auth->_have_permission('FrontEnd.Education.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Education.Add');
        
        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_pendidikan', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css');
        
        Template::set($data);
        Template::render('iframe');
	}      	
    
	public function data_keluarga()
	{
        $data["language"] = $this->session->userdata('language');      
        
        $data["ref_pendidikan"] = $this->reference->referensi_jenjang_pendidikan(); 
        $data["bulan"] = $this->reference->referensi_bulan();   
        
		$this->auth->_have_permission('FrontEnd.Family.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Family.Add');

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_keluarga', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}      
    
	public function data_bahasa()
	{
        $data["language"] = $this->session->userdata('language');      
        
        
        $data["nilai_bahasa"] = $this->reference->referensi_nilai_bahasa(); 
        
		$this->auth->_have_permission('FrontEnd.Language.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Language.Add');

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_bahasa', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}       
    
	public function data_organisasi()
	{
        $data["language"] = $this->session->userdata('language');      
        
        
		$this->auth->_have_permission('FrontEnd.Organization.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Organization.Add');

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_organisasi', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}  
    
	public function data_karya()
	{
        $data["language"] = $this->session->userdata('language');      
        
        
		$this->auth->_have_permission('FrontEnd.Publication.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Publication.Add');

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_karya', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}        

	public function data_prestasi()
	{
        $data["language"] = $this->session->userdata('language');      
        
		$this->auth->_have_permission('FrontEnd.Achievements.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Achievements.Add');

        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_prestasi', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        Assets::add_css('custom.dialog.css'); 
        
        Template::set($data);
        Template::render('iframe');
	} 
    
   	public function data_lain()
	{
        $data["language"] = $this->session->userdata('language');      
 
         
		$this->auth->_have_permission('FrontEnd.Other.View');
		$data["bool_add"] = $this->auth->_allowed('FrontEnd.Other.Add');

        $getPerson = $this->load_person();
        if (count($getPerson) > 0)
        {
            $data["aplExpectedSalary"] = $getPerson->aplExpectedSalary;
        }
                
        Assets::clear_cache();
        Assets::add_js('jquery.validate.min.js'); 
        Assets::add_js( $this->load->view('js/js_lain', null, true),'inline');          
        Assets::add_js( $this->load->view('js/js_data', null, true),'inline');
        Assets::add_module_css('applicant','custom.css'); 
        
        Template::set($data);
        Template::render('iframe');
	}        
    
	public function id()
	{
        $this->session->set_userdata('language', "bahasa");
        redirect('applicant');        
	}    
        
    
	public function en()
	{
        $this->session->set_userdata('language', "english");
        redirect('applicant');
	}    
    
/**
* Education
*/    
    /*
    * Add Last Education
    */      
    public function add_education()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');		
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');
			
            $getPerson = $this->load_person();
            if ($email == "")
                $email = $getPerson->AppUserListEmail;
			
            $jenjang = $this->input->post('jenjang');
            $institusi = $this->input->post('institusi');
            $jurusan = $this->input->post('jurusan');
            $kota = $this->input->post('kota');
            $negara = $this->input->post('negara');
            $tahunMasuk = $this->input->post('tahunMasuk');
            $tahunLulus = $this->input->post('tahunLulus');
            $nilai = $this->input->post('nilai');
            $no_ijazah = $this->input->post('no_ijazah');
            $lulus = $this->input->post('lulus');
            $gelar = $this->input->post('gelar');
            $letak = $this->input->post('letak');
            $last = $this->input->post('last');            
            
			if ($id == "")
				echo "A".$this->applicant->add_education($email, $jenjang, $institusi, $jurusan, $kota, $negara, $tahunMasuk, $tahunLulus, $nilai, $no_ijazah, $lulus, $gelar, $letak, $last);
            else
				echo "B".$this->applicant->update_education($id, $email, $jenjang, $institusi, $jurusan, $kota, $negara, $tahunMasuk, $tahunLulus, $nilai, $no_ijazah, $lulus, $gelar, $letak, $last);
        }
    }    
    
    /*
    * Delete Education
    */    
    public function delete_education()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_education($id);
        }
    }  	
	
    /*
    * View Education
    */    
	public function view_education()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $check_education_id = $this->applicant->check_education_id($id);
            if ($check_education_id->num_rows() > 0) //2
            {        
                $row = $check_education_id->row();

                echo "<script>
                        $('#jenjang').val('".$row->aplEducationLevel."');
                        $('#institusi').val('".$row->aplEducationInstitution."')
                        $('#jurusan').val('".$row->aplEducationMajor."');   
                        $('#jenjang').change();
                        $('#kota').val('".$row->aplEducationCity."');   
                        $('#negara').val('".$row->aplEducationCountry."');
                        $('#tahunMasuk').val('".$row->aplEducationYearStart."');
                        $('#tahunLulus').val('".$row->aplEducationYearEnd."');
                        $('#nilai').val(".$row->aplEducationGPA.");
                        $('#no_ijazah').val('".$row->aplEducationCert."');
                        $('#lulus').val('".$row->aplEducationGraduate."');
                        $('#gelar').val('".$row->aplEducationDegree."');";
                        if ($row->aplEducationDegreePos == "D")
                            echo "$('#letakd').prop('checked', true);";
                        else if ($row->aplEducationDegreePos == "B")
                            echo "$('#letakb').prop('checked', true);";                                                                    
                echo "</script>";
            }
        }
    }        
    
    public function load_education()
    {
        $res = "";
        $bool_change = $this->auth->_allowed('FrontEnd.Education.Change');
        $bool_delete = $this->auth->_allowed('FrontEnd.Education.Delete');                
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $allEducation = $this->applicant->view_education($getPerson->aplPersonID);
            
            if ($allEducation->num_rows() > 0)
            {            
                $res .= 
                '<div class="alert alert-success hide" id="success_education">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_education">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                //tblDalam
                $res .= '<table class="table table-hover" id="">';            
                
                $view = $this->session->userdata('view');
                               
                foreach ($allEducation->result() as $row)
                {
                    $res .= "<tr>
                                <td style='padding: 10px;'>
                                    <table class='span8 tblDalam'>
                                        <tr>
                                            <td style='font-weight: bold;font-size: medium;' colspan='2'>".$row->aplEducationInstitution.", ".$row->aplEducationCity.", ".ucwords(strtolower($row->CountryName))."</td>
                                        </tr>
                                        <tr>
                                            <td style='font-weight: bold;font-size: small;' colspan='2'>".$row->EducationLevelName." ".$row->aplEducationMajor."</td>
                                        </tr>
                                        <tr>
                                            <td colspan='2'>".$row->aplEducationYearStart." ".lang('s.d')." ".$row->aplEducationYearEnd."</td>
                                        </tr>
                                        <tr>
                                            <td colspan='2'>".lang('ipk').": ".$row->aplEducationGPA."</td>
                                        </tr>";
                                    if (trim($row->aplEducationCert) != ""){
                                $res .= '<tr>
                                            <td colspan="2">No. Ijazah: '.$row->aplEducationCert.'</td>
                                        </tr>';
                                    }
                            if ($bool_change || $bool_delete)        
                            {
                                $res .= '<tr>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right;">
                                                <div class="btn-group">';
                                                if ($bool_change)
                                                {
                                                    $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="educationEdit('.$row->aplEducationID.')"><i class="icon-pencil "></i></a>';
                                                }
                                                if ($bool_delete)
                                                {
                                                    $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-education" title="'.lang('hapus').'" onclick="educationDelete(\''.$row->aplEducationID.'\', \''.$row->EducationLevelName.'\', \''.$row->aplEducationMajor.'\', \''.$row->aplEducationInstitution.'\')"><i class="icon-trash "></i></a>';
                                                }
                                       $res .= '</div>
                                            </td>  
                                        </tr>';
                            }                                           
                            $res .= '</table>                        
                                </td>
                            </tr>';
                }
                $res .= '</table>';                  
            } else {
                $res .= '<div class="alert alert-error">
                            '.lang('kosong').'
                        </div>';                
            }
            echo $res;
        }
    }
/**
* End Education
*/    

/**
* Course
*/    	
    /*
    * Add Course
    */ 
    public function add_course()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $nama = $this->input->post('nama');
            $email = $this->input->post('email');

            $getPerson = $this->load_person();
            if ($email == "")
                $email = $getPerson->AppUserListEmail;
            
            $pelatihan = $this->input->post('pelatihan');
            $penyelenggara = $this->input->post('penyelenggara');
            $kota_penyelenggara = $this->input->post('kota_penyelenggara');
            $sertifikat = $this->input->post('sertifikat');
            $tanggalPelatihanAwal = $this->input->post('tanggalPelatihanAwal');
            $bulanPelatihanAwal = $this->input->post('bulanPelatihanAwal');
            $tahunPelatihanAwal = $this->input->post('tahunPelatihanAwal');
            $periodeAwal = $tahunPelatihanAwal."-".$bulanPelatihanAwal."-".$tanggalPelatihanAwal;
            $tanggalPelatihanAkhir = $this->input->post('tanggalPelatihanAkhir');
            $bulanPelatihanAkhir = $this->input->post('bulanPelatihanAkhir');
            $tahunPelatihanAkhir = $this->input->post('tahunPelatihanAkhir');
            $periodeAkhir = $tahunPelatihanAkhir."-".$bulanPelatihanAkhir."-".$tanggalPelatihanAkhir;
            if ($id == "")
                echo $this->applicant->add_course($email, $pelatihan, $penyelenggara, $kota_penyelenggara, $sertifikat, $periodeAwal, $periodeAkhir);
            else
                echo $this->applicant->update_course($id, $email, $pelatihan, $penyelenggara, $kota_penyelenggara, $sertifikat, $periodeAwal, $periodeAkhir);
            //echo $nama." ".$email." ".$pelatihan." ".$penyelenggara." ".$kota_penyelenggara." ".$sertifikat." ".$periodeAwal." ".$periodeAkhir;
        }
    }
            
    /*
    * Delete Course
    */    
    public function delete_course()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_course($id);
        }
    }  
    
    /*
    * View Course
    */    
    public function view_course()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $check_course = $this->applicant->check_course($id);
            if ($check_course->num_rows() > 0) //2
            {        
                $row = $check_course->row();

                echo "<script>
                        $('#pelatihan').val('".$row->aplCourseName."');
                        $('#penyelenggara').val('".$row->aplCourseOrganizer."')
                        $('#kota_penyelenggara').val('".$row->aplCourseCity."');   
                        $('#sertifikat').val('".$row->aplCourseNoCertificate."');   
                        $('#tanggalPelatihanAwal').val(".date('d', strtotime($row->aplCourseStart)).");
                        $('#bulanPelatihanAwal').val(".rtrim(date('m', strtotime($row->aplCourseStart)),0).");
                        $('#tahunPelatihanAwal').val('".rtrim(date('Y', strtotime($row->aplCourseStart)),0)."');
                        $('#tanggalPelatihanAkhir').val(".date('d', strtotime($row->aplCourseEnd)).");
                        $('#bulanPelatihanAkhir').val(".rtrim(date('m', strtotime($row->aplCourseEnd)),0).");
                        $('#tahunPelatihanAkhir').val('".rtrim(date('Y', strtotime($row->aplCourseEnd)),0)."');
                     </script>";
            }
        }
    }         
    
    public function load_course()
    {
        $bool_change = $this->auth->_allowed('FrontEnd.Course.Change');
        $bool_delete  = $this->auth->_allowed('FrontEnd.Course.Delete');                
        
        $res = "";
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $allCourse = $this->applicant->view_course($getPerson->aplPersonID);
            
            if ($allCourse->num_rows() > 0)
            {
                $res .= 
                '<div class="alert alert-success hide" id="success_course">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_course">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                $res .= '<table class="table table-hover" id="">';            
            
                $view = $this->session->userdata('view');

                foreach ($allCourse->result() as $row)
                {
                    $res .= "<tr>
                                <td style='padding: 10px;'>
                                    <table class='span8 tblDalam'>
                                        <tr>
                                            <td style='font-weight: bold;font-size: small;' colspan='2'>".$row->aplCourseOrganizer.", ".$row->aplCourseCity."</td>
                                        </tr>
                                        <tr>
                                            <td style='font-weight: bold;font-size: medium;' colspan='2'>".$row->aplCourseName."</td>
                                        </tr>
                                        <tr>
                                            <td colspan='2'>".date('d M Y', strtotime($row->aplCourseStart))." ".lang('s.d')." ".date('d M Y', strtotime($row->aplCourseEnd))."</td>
                                        </tr>";
                                    if (trim($row->aplCourseNoCertificate) != ""){
                                $res .= '<tr>
                                            <td colspan="2">No: '.$row->aplCourseNoCertificate.'</td>
                                        </tr>';
                                    }
                            if ($bool_change || $bool_delete)        
                            {
                                $res .= '<tr>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right;">
                                                <div class="btn-group">';
                                                    if ($bool_change)
                                                    {
                                                        $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="courseEdit('.$row->aplCourseID.')"><i class="icon-pencil "></i></a>';
                                                    }
                                                    if ($bool_delete)
                                                    {
                                                        $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-course" title="'.lang('hapus').'" onclick="courseDelete(\''.$row->aplCourseID.'\', \''.$row->aplCourseName.'\')"><i class="icon-trash "></i></a>';
                                                    }
                                        $res .= '</div>
                                            </td>  
                                        </tr>';
                            }                                                                    
                            $res .= '</table>                        
                                </td>
                            </tr>';
                }
                $res .= '</table>';                  
            } else {
                $res .= '
                        <script>$("#success_course").hide();</script>
                        <div class="alert alert-error">
                            '.lang('kosong').'
                        </div>
                        ';
            }            
            echo $res;
        }
    }    
/**
* End Course
*/    

/**
* Work Experience
*/        
    /*
    * Add/Edit Work Experience
    */    
    public function refresh_work_experience()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $data["allWork"] = $this->applicant->view_work($id);
        }
    }     
        
    
    public function add_work_experience()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');            
            
            $getPerson = $this->load_person();
            $email = $getPerson->AppUserListEmail;
                            
            $perusahaan = $this->input->post('perusahaan');
            $alamat_perusahaan = $this->input->post('alamat_perusahaan');
            $kota_perusahaan = $this->input->post('kota_perusahaan');
            $telp_perusahaan = $this->input->post('telp_perusahaan');
            $atasan = $this->input->post('atasan');
            $posisi = $this->input->post('posisi');
            $bulanKerjaAwal = $this->input->post('bulanKerjaAwal');
            $tahunKerjaAwal = $this->input->post('tahunKerjaAwal');
            $bulanKerjaAkhir = $this->input->post('bulanKerjaAkhir');
            $tahunKerjaAkhir = $this->input->post('tahunKerjaAkhir');
            $masih_bekerja = $this->input->post('masih_bekerja');
            $mulai = $tahunKerjaAwal."-".$bulanKerjaAwal;
            if ($masih_bekerja == "true")
                $akhir = "Sekarang";
            else
                $akhir = $tahunKerjaAkhir."-".$bulanKerjaAkhir;
            
            $gaji_awal = $this->input->post('gaji_awal');
            $gaji_akhir = $this->input->post('gaji_akhir');
            $deskripsi = $this->input->post('deskripsi');
            $alasan_keluar = $this->input->post('alasan_keluar');

            //echo $nama." - ".$email." - ".$perusahaan." - ".$alamat_perusahaan." - ".$kota_perusahaan." - ".$telp_perusahaan." - ".$atasan
            //." - ".$posisi." - ".$mulai." - ".$akhir." - ".$gaji_awal." - ".$gaji_akhir." - ".$deskripsi." - ".$alasan_keluar;
            
            if ($id == "")
                echo $this->applicant->add_work_experience($email, $perusahaan, $alamat_perusahaan, $kota_perusahaan, $telp_perusahaan, $atasan, $posisi, $mulai, $akhir, $gaji_awal, $gaji_akhir, $deskripsi, $alasan_keluar);
            else
                echo $this->applicant->update_work_experience($id, $email, $perusahaan, $alamat_perusahaan, $kota_perusahaan, $telp_perusahaan, $atasan, $posisi, $mulai, $akhir, $gaji_awal, $gaji_akhir, $deskripsi, $alasan_keluar);
        }
    }          
    
    /*
    * Delete Work Experience
    */    
    public function delete_work_experience()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_work_experience($id);
        }
    }          
    
    /*
    * View Work
    */    
    public function view_work()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $check_work = $this->applicant->check_work($id);
            if ($check_work->num_rows() > 0) //2
            {        
                $row = $check_work->row();
                echo "<script>
                        $('#perusahaan').val('".$row->aplWorkExCompany."');
                        $('#alamat_perusahaan').val('".$row->aplWorkExAddress."');
                        $('#kota_perusahaan').val('".$row->aplWorkExCity."');   
                        $('#telp_perusahaan').val('".$row->aplWorkPhoneNumber."');   
                        $('#atasan').val('".$row->aplWorkExLastSpv."');
                        $('#posisi').val('".$row->aplWorkExPosition."');
                        $('#bulanKerjaAwal').val(".rtrim(date('m', strtotime($row->aplWorkExStart)),0).");
                        $('#tahunKerjaAwal').val(".date('Y', strtotime($row->aplWorkExStart)).");";

                        if ($row->aplWorkExEnd != "Sekarang")
                    echo "$('#bulanKerjaAkhir').val(".rtrim(date('m', strtotime($row->aplWorkExEnd)),0).");
                            $('#tahunKerjaAkhir').val(".date('Y', strtotime($row->aplWorkExEnd)).");";
                        else
                    echo "$('#masih_bekerja').prop('checked', true);";

                echo "$('#gaji_awal').val('".$row->aplWorkExStartSalary."');
                        $('#gaji_akhir').val('".$row->aplWorkExEndSalary."');
                        $('#deskripsi').val('".$row->aplWorkExDescription."');
                        $('#alasan_keluar').val('".$row->aplWorkExReasonLeave."');                        
                     </script>";
                  
            }
        }
    }             
    
    public function load_work()
    {
        $res = "";
        $bool_change = $this->auth->_allowed('FrontEnd.Work.Change');
        $bool_delete = $this->auth->_allowed('FrontEnd.Work.Delete');                

        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $allWork = $this->applicant->view_work($getPerson->aplPersonID);

            if ($allWork->num_rows() > 0)
            {
                $res .= 
                '<div class="alert alert-success hide" id="success_work">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_work">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                $res .= '<table class="table table-hover">';
                $view = $this->session->userdata('view');
                foreach ($allWork->result() as $row)
                {
                    $res .= "<tr>
                                <td style='padding: 10px;'>
                                    <table class='span8 tblDalam'>
                                        <tr>
                                            <td style='font-weight: bold;font-size: small;' colspan='2'>".$row->aplWorkExPosition."</td>
                                        </tr>
                                        <tr>
                                            <td style='font-weight: bold;font-size: medium;' colspan='2'>".$row->aplWorkExCompany.", ".$row->aplWorkExCity."</td>
                                        </tr>
                                        <tr>";
                                        if ($row->aplWorkExEnd != "Sekarang")
                                        {
                                            $row->aplWorkExEnd = date('M Y', strtotime($row->aplWorkExEnd));
                                            $end = new DateTime($row->aplWorkExEnd);
                                        }else
                                            $end = new DateTime();
                                        $datestart = new DateTime($row->aplWorkExStart);
                                        $dateend = $end;
                                        $interval = date_diff($datestart, $dateend);
                                        $intr = $interval->format("(%y ".lang('tahun').", %m ".lang('bulan').", %d ".lang('hari').")");
                                    $res .= '<td colspan="2">'.date('M Y', strtotime($row->aplWorkExStart)).' '.lang('s.d').' '.$row->aplWorkExEnd.' '.$intr.'</td>
                                        </tr>
                                        <tr>';
                                        if ($row->aplWorkExDescription != "")
                                        {
                                    $res .= '<td colspan="2">Description: '.$row->aplWorkExDescription.'</td>';
                                        }                                    
                                $res .= '</tr>';
                            if ($bool_change || $bool_delete)        
                            {                                
                                $res .= '<tr>
                                            <td>&nbsp;</td>
                                            <td style="text-align: right;">
                                                <div class="btn-group">';
                                        if ($bool_change)
                                        {
                                            $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="workExEdit('.$row->aplWorkExperienceID.')"><i class="icon-pencil "></i></a>';
                                        }
                                        if ($bool_delete)
                                        {
                                            $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-work" title="'.lang('hapus').'" onclick="workExDelete(\''.$row->aplWorkExperienceID.'\', \''.$row->aplWorkExCompany.'\')"><i class="icon-trash "></i></a>';
                                        }
                                        $res .= '</div>
                                            </td>  
                                        </tr>';
                            }                        
                                $res .= '</table>                        
                                </td>
                            </tr>';
                }
                $res .= '</table>';            
            } else {
                $res .= '<script>$("#success_work").hide();</script>
                        <div class="alert alert-error">
                            '.lang('kosong').'
                        </div>';
            }            
            echo $res;
        }
    }        
/**
* End Work Experience
*/        

/**
* Other Data
*/            
    public function addother_data()
    {
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $email = $getPerson->AppUserListEmail;
                            
            $gaji = $this->input->post('gaji');
            echo $this->applicant->addother_data($email, $gaji);
        }
    }        
/**
* End Other Data
*/    

/**
* Family
*/                        
    /*
    * Add Family
    */      
    public function add_family()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');		
            $email = $this->input->post('email');
			
            $getPerson = $this->load_person();
            if (count($getPerson) > 0)
            {
                if ($email == "")
                    $email = $getPerson->AppUserListEmail;
            }
			
            $hubungan = $this->input->post('hubungan');
            $namaKeluarga = $this->input->post('namaKeluarga');
            $jk = $this->input->post('jk');
            $tmptlahir = $this->input->post('tmptlahir');
            $tanggal = $this->input->post('tanggal');
            $bulan = $this->input->post('bulan');
            $tahun = $this->input->post('tahun');
            $tanggallahir = $tahun."-".$bulan."-".$tanggal;
            $pendidikan = $this->input->post('pendidikan');
            $pekerjaan = $this->input->post('pekerjaan');         
            
			if ($id == "")
				echo $this->applicant->add_family($email, $hubungan, $namaKeluarga, $jk, $tmptlahir, $tanggallahir, $pendidikan, $pekerjaan);
            else
				echo $this->applicant->update_family($id, $email, $hubungan, $namaKeluarga, $jk, $tmptlahir, $tanggallahir, $pendidikan, $pekerjaan);
        }
    }    
    
    /*
    * Delete Family
    */    
    public function delete_family()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_family($id);
        }
    }  	
	
    /*
    * View Family
    */    
	public function view_family()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $view_family = $this->applicant->check_family($id);
            //echo $view_family->num_rows();
            if ($view_family->num_rows() > 0) //2
            {        
                $row = $view_family->row();

                echo "<script>
                        $('#hubungan').val('".$row->aplFamilyRelation."');
                        $('#namaKeluarga').val('".$row->aplFamilyName."')
                        $('#kelamin').val('".$row->aplFamilySex."');   
                        $('#tmptlahir').val('".$row->aplFamilyPlaceOfBirth."');   
                        $('#tanggal').val(".date('d', strtotime($row->aplFamilyDateOfBirth)).");
                        $('#bulan').val(".rtrim(date('m', strtotime($row->aplFamilyDateOfBirth)),0).");
                        $('#tahun').val('".rtrim(date('Y', strtotime($row->aplFamilyDateOfBirth)),0)."');                       
                        $('#pendidikan').val('".$row->aplFamilyEducation."');
                        $('#pekerjaan').val('".$row->aplFamilyOccupation."');
                    </script>";
            }
        }
    }        
    
    public function load_family()
    {
        $res = "";
        $bool_change = $this->auth->_allowed('FrontEnd.Family.Change');
        $bool_delete = $this->auth->_allowed('FrontEnd.Family.Delete');                
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $allFamily = $this->applicant->view_family($getPerson->aplPersonID);
            $view = $this->session->userdata('view');
            
            if ($allFamily->num_rows() > 0)
            {
                $res .= 
                '<div class="alert alert-success hide" id="success_family">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_family">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                $res .= '<table class="table table-hover table-bordered table-striped" id="">';
                $res .= '<thead>
                        <tr>
                            <th>'.lang('hubungan').'</th>
                            <th>'.lang('nama').'</th>
                            <th>'.lang('jk').'</th>
                            <th>'.lang('tmpt_lahir').', '.lang('tgl_lahir').'</th>
                            <th>'.lang('pendidikan').'</th>
                            <th>'.lang('pekerjaan').'</th>';
                

                if ($bool_change || $bool_delete)        
                {
                    $res .= '<th></th>';
                }
                $res .= '</tr>
                        </thead>';
                foreach ($allFamily->result() as $row)
                {
                    
                    if (trim($row->aplFamilySex)=="P")
                        $kl = "Wanita";
                    else if (trim($row->aplFamilySex)=="L")
                        $kl = "Pria";
                    else
                        $kl = "";

                    $cek_education = $this->ref_education->check_id($row->aplFamilyEducation)->row();

                    $res .= '<tr>
                                <td>'.ucwords($row->aplFamilyRelation).'</td>
                                <td>'.$row->aplFamilyName.'</td>
                                <td>'.$kl.'</td>
                                <td>'.$row->aplFamilyPlaceOfBirth.', '.date('d M Y', strtotime($row->aplFamilyDateOfBirth)).'</td>
                                <td>'.$cek_education->EducationLevelName.'</td>
                                <td>'.$row->aplFamilyOccupation.'</td>';
                            if ($bool_change || $bool_delete)        
                            {
                        $res .= '<td style="text-align: right;">
                                    <div class="btn-group">';
                                    if ($bool_change)
                                    {
                                        $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="familyEdit('.$row->aplFamilyID.')"><i class="icon-pencil "></i></a>';
                                    }
                                    if ($bool_delete)
                                    {
                                        $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-family" title="'.lang('hapus').'" onclick="familyDelete(\''.$row->aplFamilyID.'\', \''.$row->aplFamilyRelation.'\', \''.$row->aplFamilyName.'\')"><i class="icon-trash "></i></a>';
                                    }
                            $res .= '</div>
                                </td>';
                            }  
                    $res .= '</tr>';
                }
                $res .= '</table>';            
            } else {
                $res .= '<div class="alert alert-error">
                            '.lang('kosong').'
                        </div>';
            }
            echo $res;
        }
    }
/**
* End Family
*/        

/**
* Language
*/                        
    /*
    * Add Family
    */      
    public function add_language()
    {
        if ($this->input->post('ajax'))
        {             
            $id = $this->input->post('id');		
            $email = $this->input->post('email');
           
            $getPerson = $this->load_person();
            if ($email == "")
                $email = $getPerson->AppUserListEmail;
            
            $bahasa = $this->input->post('bahasa');
            $writing = $this->input->post('writing');
            $understanding = $this->input->post('understanding');
            $speaking = $this->input->post('speaking');
            $reading = $this->input->post('reading');     

			if ($id == "")
				echo $this->applicant->add_language($email, $bahasa, $writing, $understanding, $speaking, $reading);
            else
				echo $this->applicant->update_language($id, $email, $bahasa, $writing, $understanding, $speaking, $reading);            
        }
    }    
    
    /*
    * Delete Language
    */    
    public function delete_language()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_language($id);
        }
    }  	
	
    /*
    * View Language
    */    
	public function view_language()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $check_language = $this->applicant->check_language($id);

            if ($check_language->num_rows() > 0) //2
            {        
                $row = $check_language->row();

                echo "<script>
                        $('#bahasa').val('".$row->aplLanguageName."');";

                if ($row->aplLanguageWriting == "P")
                    echo "$('#writingp').prop('checked', true);";
                else if ($row->aplLanguageWriting == "F")
                    echo "$('#writingf').prop('checked', true);";                                                                    
                else if ($row->aplLanguageWriting == "G")
                    echo "$('#writingg').prop('checked', true);";                                                                    
                else if ($row->aplLanguageWriting == "E")
                    echo "$('#writinge').prop('checked', true);";                                                                    

                if ($row->aplLanguageUnderstanding == "P")
                    echo "$('#understandingp').prop('checked', true);";
                else if ($row->aplLanguageUnderstanding == "F")
                    echo "$('#understandingf').prop('checked', true);";                                                                    
                else if ($row->aplLanguageUnderstanding == "G")
                    echo "$('#understandingg').prop('checked', true);";                                                                    
                else if ($row->aplLanguageUnderstanding == "E")
                    echo "$('#understandinge').prop('checked', true);";                                                                    
                        
                if ($row->aplLanguageSpeaking == "P")
                    echo "$('#speakingp').prop('checked', true);";
                else if ($row->aplLanguageSpeaking == "F")
                    echo "$('#speakingf').prop('checked', true);";                                                                    
                else if ($row->aplLanguageSpeaking == "G")
                    echo "$('#speakingg').prop('checked', true);";                                                                    
                else if ($row->aplLanguageSpeaking == "E")
                    echo "$('#speakinge').prop('checked', true);";                                                                    

                if ($row->aplLanguageReading == "P")
                    echo "$('#readingp').prop('checked', true);";
                else if ($row->aplLanguageReading == "F")
                    echo "$('#readingf').prop('checked', true);";                                                                    
                else if ($row->aplLanguageReading == "G")
                    echo "$('#readingg').prop('checked', true);";                                                                    
                else if ($row->aplLanguageReading == "E")
                    echo "$('#readinge').prop('checked', true);";                                                                    
                echo "</script>";
            }
        }
    }        
    
    public function load_language()
    {
        $res = "";
        $bool_change = $this->auth->_allowed('FrontEnd.Language.Change');
        $bool_delete = $this->auth->_allowed('FrontEnd.Language.Delete');                
        
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $aplLanguage = $this->applicant->view_language($getPerson->aplPersonID);
            $view = $this->session->userdata('view');
            
            if ($aplLanguage->num_rows() > 0)
            {
                $res .= 
                '<div class="alert alert-success hide" id="success_language">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_language">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                $res .= '<table class="table table-hover table-bordered table-striped" style="text-align: center;">';            
                $res .= '<thead>
                        <tr class="abu">
                            <th rowspan="3" style="text-align:center;vertical-align:middle;">'.lang('bahasa').'</th>
                            <th colspan="16" style="text-align:center;">'.lang('kemampuan').'</th>
                            <th rowspan="3"></th>
                        </tr>';
                $res .= '<tr class="abu">
                            <th colspan="4" style="text-align:center;">'.lang('writing').'</th>
                            <th colspan="4" style="text-align:center;">'.lang('understanding').'</th>
                            <th colspan="4" style="text-align:center;">'.lang('speaking').'</th>
                            <th colspan="4" style="text-align:center;">'.lang('writing').'</th>
                        </tr>';
                $res .= '<tr class="abu">
                            <th style="text-align:center;">'.lang('k').'</th>
                            <th style="text-align:center;">'.lang('c').'</th>
                            <th style="text-align:center;">'.lang('b').'</th>
                            <th style="text-align:center;">'.lang('s').'</th>
    
                            <th style="text-align:center;">'.lang('k').'</th>
                            <th style="text-align:center;">'.lang('c').'</th>
                            <th style="text-align:center;">'.lang('b').'</th>
                            <th style="text-align:center;">'.lang('s').'</th>

                            <th style="text-align:center;">'.lang('k').'</th>
                            <th style="text-align:center;">'.lang('c').'</th>
                            <th style="text-align:center;">'.lang('b').'</th>
                            <th style="text-align:center;">'.lang('s').'</th>
                            
                            <th style="text-align:center;">'.lang('k').'</th>
                            <th style="text-align:center;">'.lang('c').'</th>
                            <th style="text-align:center;">'.lang('b').'</th>
                            <th style="text-align:center;">'.lang('s').'</th>                                                        
                        </tr>
                        </thead>';            
                foreach ($aplLanguage->result() as $row)
                {
                    $writing = '<a title="'.$row->aplLanguageWriting.'>" style="text-decoration: none; cursor: pointer; color: #62D419; font-size: large;">&#10004;</a>';
                    $understanding = '<a title="'.$row->aplLanguageUnderstanding.'>" style="text-decoration: none; cursor: pointer; color: #62D419; font-size: large;">&#10004;</a>';
                    $speaking = '<a title="'.$row->aplLanguageSpeaking.'>" style="text-decoration: none; cursor: pointer; color: #62D419; font-size: large;">&#10004;</a>';
                    $reading = '<a title="'.$row->aplLanguageReading.'>" style="text-decoration: none; cursor: pointer; color: #62D419; font-size: large;">&#10004;</a>';
    
                    $res .= '<tr>
                                <td>'.$row->aplLanguageName.'</td>';
                                if ($row->aplLanguageWriting == "P")
                        $res .= '<td style="text-align:center;">'.$writing.'</td>
                                <td></td><td></td><td></td>';
                                else if ($row->aplLanguageWriting == "F")
                        $res .= '<td></td>
                                <td style="text-align:center;">'.$writing.'</td>
                                <td></td><td></td>';
                                else if ($row->aplLanguageWriting == "G")
                        $res .= '<td></td>
                                <td></td>
                                <td style="text-align:center;">'.$writing.'</td><td></td>';
                                else if ($row->aplLanguageWriting == "E")
                        $res .= '<td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;">'.$writing.'</td>';
    
                                if ($row->aplLanguageUnderstanding == "P")
                        $res .= '<td style="text-align:center;">'.$understanding.'</td>
                                <td></td><td></td><td></td>';
                                else if ($row->aplLanguageUnderstanding == "F")
                        $res .= '<td></td>
                                <td style="text-align:center;">'.$understanding.'</td>
                                <td></td><td></td>';
                                else if ($row->aplLanguageUnderstanding == "G")
                        $res .= '<td></td>
                                <td></td>
                                <td style="text-align:center;">'.$understanding.'</td><td></td>';
                                else if ($row->aplLanguageUnderstanding == "E")
                        $res .= '<td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;">'.$understanding.'</td>';
    
                                if ($row->aplLanguageSpeaking == "P")
                        $res .= '<td style="text-align:center;">'.$speaking.'</td>
                                <td></td><td></td><td></td>';
                                else if ($row->aplLanguageSpeaking == "F")
                        $res .= '<td></td>
                                <td style="text-align:center;">'.$speaking.'</td>
                                <td></td><td></td>';
                                else if ($row->aplLanguageSpeaking == "G")
                        $res .= '<td></td>
                                <td></td>
                                <td style="text-align:center;">'.$speaking.'</td><td></td>';
                                else if ($row->aplLanguageSpeaking == "E")
                        $res .= '<td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;">'.$speaking.'</td>';
    
                                if ($row->aplLanguageReading == "P")
                        $res .= '<td style="text-align:center;">'.$reading.'</td>
                                <td></td><td></td><td></td>';
                                else if ($row->aplLanguageReading == "F")
                        $res .= '<td></td>
                                <td style="text-align:center;">'.$reading.'</td>
                                <td></td><td></td>';
                                else if ($row->aplLanguageReading == "G")
                        $res .= '<td></td>
                                <td></td>
                                <td style="text-align:center;">'.$reading.'</td><td></td>';
                                else if ($row->aplLanguageReading == "E")
                        $res .= '<td></td>
                                <td></td>
                                <td></td>
                                <td style="text-align:center;">'.$reading.'</td>';
    
                    if ($bool_change || $bool_delete)        
                    {
                        $res .= '<td style="text-align: center;">
                                    <div class="btn-group">';
                                    if ($bool_change)
                                    {
                                        $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="languageEdit('.$row->aplLanguageID.')"><i class="icon-pencil "></i></a>';
                                    }
                                    if ($bool_delete)
                                    {
                                        $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-language" title="'.lang('hapus').'" onclick="languageDelete(\''.$row->aplLanguageID.'\', \''.$row->aplLanguageName.'\')"><i class="icon-trash "></i></a>';
                                    }
                            $res .= '</div>
                                </td>';
                    }            
                    $res .= '</tr>';
                }
                $res .= '</table>'.
                        lang('keterangan').":".lang('ketPenguasaan');
            } else {
                $res .= '<div class="alert alert-error">
                            '.lang('kosong').'
                        </div>';                
            }
            echo $res;
        }
    }
/**
* End Language
*/      
            
/**
* Organization
*/    	
    /*
    * Add Organization
    */ 
    public function add_organization()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');

            $getPerson = $this->load_person();
            $email = $getPerson->AppUserListEmail;
            
            $organisasi = $this->input->post('organisasi');
            $bidang = $this->input->post('bidang');
            $mulai = $this->input->post('tahun_masuk');
            $akhir = $this->input->post('tahun_lulus');
            $kota = $this->input->post('kota_organisasi');
            $posisi = $this->input->post('posisi');
            //echo $nama." ".$email." ".$organisasi." ".$bidang." ".$mulai." ".$akhir." ".$kota." ".$posisi;
            if ($id == "")
                echo $this->applicant->add_organization($email, $organisasi, $bidang, $mulai, $akhir, $kota, $posisi);
            else
                echo $this->applicant->update_organization($id, $email, $organisasi, $bidang, $mulai, $akhir, $kota, $posisi);
        }
    }
            
    /*
    * Delete Organization
    */    
    public function delete_organization()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_organization($id);
        }
    }  
    
    /*
    * View Organization
    */    
    public function view_organization()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $check_organization = $this->applicant->check_organization($id);
            if ($check_organization->num_rows() > 0) //2
            {        
                $row = $check_organization->row();

                echo "<script>
                        $('#organisasi').val('".$row->aplOrganizationName."');
                        $('#bidang').val('".$row->aplOrganizationField."')
                        $('#tahun_masuk').val('".$row->aplOrganisationStartYear."');   
                        $('#tahun_lulus').val('".$row->aplOrganisationEndYear."');   
                        $('#kota_organisasi').val('".$row->aplOrganizationCity."');   
                        $('#posisi').val('".$row->aplOrganizationPosition."');   
                     </script>";
            }
        }
    }         
    
    public function load_organization()
    {
        $res = "";
        $bool_change = $this->auth->_allowed('FrontEnd.Organization.Change');
        $bool_delete = $this->auth->_allowed('FrontEnd.Organization.Delete');                
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $allOrganization = $this->applicant->view_organization($getPerson->aplPersonID);
            $view = $this->session->userdata('view');
            
            if ($allOrganization->num_rows() > 0)
            {
                $res .= 
                '<div class="alert alert-success hide" id="success_organization">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_organization">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                $res .= '<table class="table table-hover">';       
                foreach ($allOrganization->result() as $row)
                {
                    $res .= "<tr>
                                <td style='padding: 10px;'>
                                    <table class='span8 tblDalam'>
                                        <tr>
                                            <td style='width: 80px;'>Organisasi</td>
                                            <td style='width: 10px;'>:</td>
                                            <td>".$row->aplOrganizationName."</td>
                                        </tr>
                                        <tr>
                                            <td>Bidang</td>
                                            <td>:</td>
                                            <td>".$row->aplOrganizationField."</td>
                                        </tr>
                                        <tr>
                                            <td>Periode</td>
                                            <td>:</td>
                                            <td>".$row->aplOrganisationStartYear." ".lang('s.d')." ".$row->aplOrganisationEndYear."</td>
                                        </tr>
                                        <tr>
                                            <td>Kota</td>
                                            <td>:</td>
                                            <td>".$row->aplOrganizationCity."</td>
                                        </tr>
                                        <tr>
                                            <td>Posisi</td>
                                            <td>:</td>
                                            <td>".$row->aplOrganizationPosition."</td>
                                        </tr>";
                            if ($bool_change || $bool_delete)        
                            {
                                $res .= '<tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td style="text-align: right;">
                                                <div class="btn-group">';
                                                if ($bool_change)        
                                                {
                                                    $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="organizationEdit('.$row->aplOrganizationID.')"><i class="icon-pencil "></i></a>';
                                                }
                                                if ($bool_delete)        
                                                {
                                                    $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-organization" title="'.lang('hapus').'" onclick="organizationDelete(\''.$row->aplOrganizationID.'\', \''.$row->aplOrganizationName.'\')"><i class="icon-trash "></i></a>';
                                                }
                                        $res .= '</div>
                                            </td>  
                                        </tr>';
                            }                                      
                            $res .= '</table>                        
                                </td>
                            </tr>';
                }
                $res .= '</table>';                  
            } else {
                $res .= '<div class="alert alert-error">
                            '.lang('kosong').'
                        </div>';                
            }
            echo $res;
        }
    }    
/**
* End Organization
*/

/**
* Publication
*/    	
    /*
    * Add publication
    */ 
    public function add_publication()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');

            $getPerson = $this->load_person();
            $email = $getPerson->AppUserListEmail;
            
            $judul = $this->input->post('judul');
            $keterangan = $this->input->post('keterangan');
            if ($id == "")
                echo $this->applicant->add_publication($email, $judul, $keterangan);
            else
                echo $this->applicant->update_publication($id, $email, $judul, $keterangan);
        }
    }
            
    /*
    * Delete publication
    */    
    public function delete_publication()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_publication($id);
        }
    }  
    
    /*
    * View publication
    */    
    public function view_publication()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $check_publication = $this->applicant->check_publication($id);
            if ($check_publication->num_rows() > 0) //2
            {        
                $row = $check_publication->row();

                echo "<script>
                        $('#judul').val('".$row->aplPublicationTitle."');
                        $('#keterangan ').val('".$row->aplPublicationRemarks."');
                     </script>";
            }
        }
    }         
    
    public function load_publication()
    {
        $res = "";
        $bool_change = $this->auth->_allowed('FrontEnd.Publication.Change');
        $bool_delete = $this->auth->_allowed('FrontEnd.Publication.Delete');                
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();;
            $allPublication = $this->applicant->view_publication($getPerson->aplPersonID);
            $view = $this->session->userdata('view');
            if ($allPublication->num_rows() > 0)
            {
                $res .= 
                '<div class="alert alert-success hide" id="success_publication">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_publication">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                $res .= '<table class="table table-hover">';            
                foreach ($allPublication->result() as $row)
                {
                    $res .= "<tr>
                                <td style='padding: 10px;'>
                                    <table class='span8 tblDalam'>
                                        <tr>
                                            <td style='width: 80px;'>Judul</td>
                                            <td style='width: 10px;'>:</td>
                                            <td>".$row->aplPublicationTitle."</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>:</td>
                                            <td>".$row->aplPublicationRemarks."</td>
                                        </tr>";
                            if ($bool_change || $bool_delete)        
                            {
                                $res .= '<tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td style="text-align: right;">
                                                <div class="btn-group">';
                                                if ($bool_change)        
                                                {
                                                    $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="publicationEdit('.$row->aplPublicationID.')"><i class="icon-pencil "></i></a>';
                                                }
                                                if ($bool_delete)        
                                                {
                                                    $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-publication" title="'.lang('hapus').'" onclick="publicationDelete(\''.$row->aplPublicationID.'\', \''.$row->aplPublicationTitle.'\')"><i class="icon-trash "></i></a>';
                                                }
                                        $res .= '</div>
                                            </td>  
                                        </tr>';
                            }
                            $res .= '</table>                        
                                </td>
                            </tr>';
                }
                $res .= '</table>';  
            } else {
                $res .= '<div class="alert alert-error">
                            '.lang('kosong').'
                        </div>';                
            }
            echo $res;
        }
    }    
/**
* End Publication
*/ 

/**
* Achievements
*/    	
    /*
    * Add achievements
    */ 
    public function add_achievements()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');

            $getPerson = $this->load_person();
            $email = $getPerson->AppUserListEmail;
            
            $bidang = $this->input->post('bidang');
            $keterangan = $this->input->post('keterangan');
            if ($id == "")
                echo $this->applicant->add_achievements($email, $bidang, $keterangan);
            else
                echo $this->applicant->update_achievements($id, $email, $bidang, $keterangan);
        }
    }
            
    /*
    * Delete achievements
    */    
    public function delete_achievements()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            echo $this->applicant->delete_achievements($id);
        }
    }  
    
    /*
    * View achievements
    */    
    public function view_achievements()
    {
        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');
            $check_achievements = $this->applicant->check_achievements($id);
            if ($check_achievements->num_rows() > 0) //2
            {        
                $row = $check_achievements->row();

                echo "<script>
                        $('#bidang').val('".$row->aplAchievementsField."');
                        $('#keterangan ').val('".$row->aplAchievementsRemarks."');
                     </script>";
            }
        }
    }         
    
    public function load_achievements()
    {
        $res = "";
        $bool_change = $this->auth->_allowed('FrontEnd.Achievements.Change');
        $bool_delete = $this->auth->_allowed('FrontEnd.Achievements.Delete');                
        if ($this->input->post('ajax'))
        {  
            $getPerson = $this->load_person();
            $allAchievements = $this->applicant->view_achievements($getPerson->aplPersonID);
            $view = $this->session->userdata('view');
            if ($allAchievements->num_rows() > 0)
            {
                $res .= 
                '<div class="alert alert-success hide" id="success_achievements">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_achievements">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  
                $res .= '<table class="table table-hover">';            
                foreach ($allAchievements->result() as $row)
                {
                    $res .= "<tr>
                                <td style='padding: 10px;'>
                                    <table class='span8 tblDalam'>
                                        <tr>
                                            <td style='width: 80px;'>Bidang</td>
                                            <td style='width: 10px;'>:</td>
                                            <td>".$row->aplAchievementsField."</td>
                                        </tr>
                                        <tr>
                                            <td>Keterangan</td>
                                            <td>:</td>
                                            <td>".$row->aplAchievementsRemarks."</td>
                                        </tr>";
                            if ($bool_change || $bool_delete)        
                            {
                                $res .= '<tr>
                                            <td colspan="2">&nbsp;</td>
                                            <td style="text-align: right;">
                                                <div class="btn-group">';
                                                if ($bool_change)        
                                                {
                                                    $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="achievementsEdit('.$row->aplAchievementsID.')"><i class="icon-pencil "></i></a>';
                                                }
                                                if ($bool_delete)        
                                                {
                                                    $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-achievements" title="'.lang('hapus').'" onclick="achievementsDelete(\''.$row->aplAchievementsID.'\', \''.$row->aplAchievementsField.'\')"><i class="icon-trash "></i></a>';
                                                }
                                        $res .= '</div>
                                            </td>  
                                        </tr>';
                            }        
                            $res .= '</table>                        
                                </td>
                            </tr>';
                }
                $res .= '</table>';                            
            } else {
                $res .= '<div class="alert alert-error">
                            '.lang('kosong').'
                        </div>';                
            }
            echo $res;
        }
    }    
/**
* End Achievements
*/ 

    public function foto()
    {
        if ($this->session->userdata('email') != "") //if user login
        {
            $appl = $this->applicant->get_person($this->session->userdata('email')); //1
            if ($appl->num_rows() > 0) //2
            {
                $row = $appl->row();                
                if (!empty($_FILES['fileFoto']))
                {                
                    $tempFile = $_FILES['fileFoto']['tmp_name'];
                    $fileSize = $_FILES['fileFoto']['size']; 
        
                    if ($fileSize <= 200000)
                    {        	           	                                 
                        $fileTypes = array("jpg", "jpeg"); // File extensions
                                		
                        $fileParts = pathinfo($_FILES['fileFoto']['name']);
                                        
                        $direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archives/photo"; //linux
                                
                        $fileName = "Photo".$row->aplPersonID.".".strtolower($fileParts['extension']);
        
                        $sourceFile = $direktori."/".$fileName;
                                          
                       	if (in_array(strtolower($fileParts['extension']), $fileTypes)) 
                        { 
                            $up = move_uploaded_file($tempFile, $sourceFile);
                            if ($up)
                            {   
                                $res = $this->applicant->addphoto($row->aplPersonID, $fileName);                                
                                if ($res)
                                    echo "OK";
                                else
                                    echo "Gagal";
                            }
                            else
                                echo 'File gagal diunggah.';
                        } else {
                            echo 'Ketentuan tipe file adalah .jpg atau .jpeg';
                        }                                   
                    }
                    else 
                    {
                        echo "File terlalu besar, maksimal 200Kb";
                    }           
                } 
                else 
                {
                    echo "File tidak boleh kosong";
                }
            }
        }            
    }
    
    public function load_photo()
    {
        if ($this->input->post('ajax'))
        {  
            if ($this->session->userdata('email') != "") //if user login
            {
                $appl = $this->applicant->get_person($this->session->userdata('email')); //1
                if ($appl->num_rows() > 0) //2
                {
                    $row = $appl->row();      
                    $photo = $row->aplPhoto;

                    if (trim($photo) == "")
                        $photo = base_url()."public/assets/images/icon-user.png";
                    else
                    {
                        $url = getimagesize(base_url()."archives/photo/".$photo);
                        if (is_array($url))
                            $photo = base_url()."archives/photo/".$photo;
                        else 
                            $photo = base_url()."public/assets/images/icon-user.png";
                    }                    
                          
                    echo '<img src="'.$photo.'" width="150"/>';
                }
            }
        }
    }    
    
    public function load_add_course()
    {
        $getPerson = $this->load_person();
        $jmlAllCourse = $this->applicant->view_course($getPerson->aplPersonID)->num_rows();
        //Batas 5 data
        if ($jmlAllCourse < 5)
            echo '<a data-toggle="modal" href="#dialog-non-pendidikan" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_pelatihan'); 
        
    }   
    
    public function load_add_work()
    {
        $getPerson = $this->load_person();
        $jmlAllWork = $this->applicant->view_work($getPerson->aplPersonID)->num_rows();
        //Batas 4 data
        if ($jmlAllWork < 4)
            echo '<a data-toggle="modal" href="#dialog-pengalaman" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_pengalaman'); 
        
    }   
    
    public function load_add_education()
    {
        $getPerson = $this->load_person();
        $jmlAllEducation = $this->applicant->view_education($getPerson->aplPersonID)->num_rows();
        //Batas 5 data
        if ($jmlAllEducation < 2)
            echo '<a data-toggle="modal" href="#dialog-pendidikan" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_pendidikan');       
    }         

    public function load_add_achievements()
    {
        $getPerson = $this->load_person();
        $jmlAllAchievements = $this->applicant->view_achievements($getPerson->aplPersonID)->num_rows();
        //Batas 3 data
        if ($jmlAllAchievements < 3)
            echo '<a data-toggle="modal" href="#dialog-prestasi" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_prestasi'); 
    }         

    public function load_add_publication()
    {
        $getPerson = $this->load_person();
        $jmlAllAchievements = $this->applicant->view_publication($getPerson->aplPersonID)->num_rows();
        //Batas 3 data
        if ($jmlAllAchievements < 3)
            echo '<a data-toggle="modal" href="#dialog-publikasi" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_publikasi');   
    }         

    public function load_add_organization()
    {
        $getPerson = $this->load_person();
        $jmlAllOrganization = $this->applicant->view_organization($getPerson->aplPersonID)->num_rows();
        //Batas 4 data
        if ($jmlAllOrganization < 4)
            echo '<a data-toggle="modal" href="#dialog-organisasi" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_organisasi'); 
               
    } 
    
    public function load_add_language()
    {
        $getPerson = $this->load_person();
        $jmlAllLanguage = $this->applicant->view_language($getPerson->aplPersonID)->num_rows();
        //Batas 3 data
        if ($jmlAllLanguage < 3)
            echo '<a data-toggle="modal" href="#dialog-bahasa" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_bahasa'); 
    }   
    
    public function load_add_family()
    {
        $getPerson = $this->load_person();
        $jmlAllFamily = $this->applicant->view_family($getPerson->aplPersonID)->num_rows();
        //Batas 10 data
        if ($jmlAllFamily < 10)
            echo '<a data-toggle="modal" href="#dialog-keluarga" class="btn"><i class="icon-plus"></i> '.lang('tambah').'</a>
                    <br /><br />'.lang('ket_data_keluarga');   
    }       
}