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
                //if ($getPerson->AppUserLevelLevelID == 10 || $getPerson->AppUserLevelLevelID == 11) //level for internal/external candidates
                if ($this->session->userdata('xyz') == 10 || $this->session->userdata('xyz') == 11) 
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
    

    /**
* Load View Form
*/        
    public function profile()
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
                $getPerson = $this->applicant->get_person($this->session->userdata('email'))->row();
    
                if ($this->session->userdata('xyz') == 10 || $this->session->userdata('xyz') == 11) 
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
                    $getLastCourse = $this->applicant->list_course($getPerson->aplPersonID); 
                   // var_dump($getLastCourse);exit();
                    if (count($getLastCourse) > 0){
                        $data["aplCourseName"] = $getLastCourse->aplCourseName ;
                        $data["aplCourseStart"] = $getLastCourse->aplCourseStart ;
                        $data["aplCourseEnd"] = $getLastCourse->aplCourseEnd ;
                        $data["aplCourseOrganizer"] = $getLastCourse->aplCourseOrganizer ;
                        $data["aplCourseCity"] = $getLastCourse->aplCourseCity ;            
                        $data["aplCourseNoCertificate"] = $getLastCourse->aplCourseNoCertificate ;  
                    }
                    else{
                        $data["aplCourseName"] = "";
                        $data["aplCourseStart"] = "";
                        $data["aplCourseEnd"] = "";
                        $data["aplCourseOrganizer"] = "";
                        $data["aplCourseCity"] = "";            
                        $data["aplCourseNoCertificate"] = ""; 
                    }
                   // $data["allCourse"] = $this->applicant->view_course($getPerson->aplPersonID);
                    $getLastWork = $this->applicant->list_work($getPerson->aplPersonID);
                    //var_dump($getLastWork);exit();
                    if (count($getLastWork) > 0) {
                        $data["aplWorkExCompany"] = $getLastWork->aplWorkExCompany;
                        $data["aplWorkExAddress"] = $getLastWork->aplWorkExAddress;
                        $data["aplWorkExCity"] = $getLastWork->aplWorkExCity;
                        $data["aplWorkPhoneNumber"] = $getLastWork->aplWorkPhoneNumber;
                        $data["aplWorkExLastSpv"] = $getLastWork->aplWorkExLastSpv;
                        $data["aplWorkExPosition"] = $getLastWork->aplWorkExPosition;
                        $data["aplWorkExStart"] = $getLastWork->aplWorkExStart;
                        $data["aplWorkExEnd"] = $getLastWork->aplWorkExEnd;
                        $data["aplWorkExStartSalary"] = $getLastWork->aplWorkExStartSalary;
                        $data["aplWorkExEndSalary"] = $getLastWork->aplWorkExEndSalary;
                        $data["aplWorkExDescription"] = $getLastWork->aplWorkExDescription;
                        $data["aplWorkExReasonLeave"] = $getLastWork->aplWorkExReasonLeave;
                    }
                    else{
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
                    }
                    //$data["allWork"] = $this->applicant->view_work($getPerson->aplPersonID);
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
            $userID = $this->session->userdata('user_id');
            $this->load->model('auth/register_model','',TRUE);        
            $name = $this->register_model->explode_name($nama);
            echo $this->applicant->addfirst_personal($userID,$name[0], $name[1], $jk, $tmptlahir, $tgllahir, $no_identitas, $berlaku, $statusMarital, $agama, $email, $alternatif_email, $nohp, $alternatif_nohp);
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
            //if ($get_person->AppUserLevelLevelID == 10 || $get_person->AppUserLevelLevelID == 11) //level for internal/external candidates
            if ($this->session->userdata('xyz') == 10 || $this->session->userdata('xyz') == 11) 
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
                echo $this->applicant->add_education($email, $jenjang, $institusi, $jurusan, $kota, $negara, $tahunMasuk, $tahunLulus, $nilai, $no_ijazah, $lulus, $gelar, $letak, $last);
            else
                echo $this->applicant->update_education($id, $email, $jenjang, $institusi, $jurusan, $kota, $negara, $tahunMasuk, $tahunLulus, $nilai, $no_ijazah, $lulus, $gelar, $letak, $last);
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
                //$res .= '<table class="table table-hover" id="">'; 
                    $res .='    <div class="tab-pane" id="education" style="padding: 15px;">
                                    <div id="pendidikan"  style="margin-left:15%;">  
                                        <div style="float:left;margin-top:-20px;">
                                        <h4 >'. lang('Pendidikan').'</h4>
                                        </div>';           
                
                $view = $this->session->userdata('view');
                $i=1;               
                foreach ($allEducation->result() as $row)
                {
                    if ($row->aplEducationDegreePos=="D") {
                        $checkdepan='checked';
                        $checkbelakang='';
                    }
                    if ($row->aplEducationDegreePos=="B") {
                        $checkdepan='';
                        $checkbelakang='checked';
                    }
                     $res.='<div>                                      
                                <div class="modal-header">
                                    <div style="padding-right:0;margin-right:0;float:right" >
                                        <a data-toggle="modal" href="#education_edit'.$row->aplEducationID.'" class="btn"><i class="icon-edit"></i>&nbsp;'. lang('edit').'</a>
                                    </div>
                                    <div style="padding-right:0;margin-right:0;float:right" >
                                        <a data-toggle="modal" href="#dialog-pendidikan" class="btn"><i class="icon-edit"></i>&nbsp;'. lang('tambah').'</a>
                                    </div>
                                    <div style="padding-right:0;margin-right:0;float:right" >
                                        <a data-toggle="modal" href="" onClick="educationDelete('.$row->aplEducationID.',\''. $row->EducationLevelName.'\')"  class="btn"><i class="icon-remove"></i>&nbsp;'. lang('hapus').'</a>                                                
                                    </div>
                                </div>

                                <div class="form-horizontal" style="padding-top: 10px;">
                                    <div class="control-group">
                                        <label class="control-label" for="jenjang"><b>'.lang('jenjang').' : </b></label> <label class="control-label-isi" >'. $row->EducationLevelName.'</label>                                        
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="institusi"><b>'.lang('institusi').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationInstitution.'</label>                                         
                                    </div>
                                    <div class="control-group" id="jur">
                                        <label class="control-label" for="jurusan"><b>'.lang('jurusan').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationMajor.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="jurusan"><b>'.lang('kota').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationCity.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="negara"><b>'.lang('negara').' : </b></label> <label class="control-label-isi" >'. $row->CountryName.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunMasuk"><b>'.lang('tahun_masuk').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationYearStart.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunLulus"><b>'.lang('tahun_lulus').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationYearEnd.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="no_ijazah"><b>'.lang('no_ijazah').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationCert.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="lulus"><b>'.lang('lulus').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationGraduate.'</label>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="gelar"><b>'.lang('gelar').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationDegree.'</label>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="nilai"><b>'.lang('nilai_akhir').'/'.lang('ipk').' : </b></label> <label class="control-label-isi" >'. $row->aplEducationGPA.'</label> 
                                    </div>                                        
                                </div>';

    /*==============================Education Edit==========================*/
                        $res.='<div id="education_edit'.$row->aplEducationID.'" class="modal custom hide fade in" style="display: none; width: 750px;height:95%;overflow:scroll;top:2% !important;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4>'.lang('Pendidikan').'</h4>
                                    </div>';  
                        $res.='<div class="form-horizontal" style="padding-top: 10px;">
                                    <div class="control-group">
                                        <label class="control-label" for="jenjang'.$row->aplEducationID.'">'.lang('jenjang').'</label>
                                        <div class="controls">
                                            <select name="jenjang" id="jenjang'.$row->aplEducationID.'" class="input-medium">
                                                <option value="">'.lang('pilih').'</option>
                        ';
                        $pendidikan = $this->reference->referensi_jenjang_pendidikan(); 

                                                    foreach ($pendidikan->result() as $row2)
                                                    {
                                                        if ($row->aplEducationLevel == $row2->EducationLevelCode)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";
                                                        $res.= '<option value="'.$row2->EducationLevelCode.'"'.$selected.'>'.$row2->EducationLevelName.'</option>';
                                                    }
                        $res .='                        
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="institusi'.$row->aplEducationID.'">'.lang('institusi').'</label>
                                        <div class="controls">
                                            <input type="text" name="institusi" id="institusi'.$row->aplEducationID.'" class="input-xlarge" placeholder="'.lang('institusi').'" value="'.$row->aplEducationInstitution.'"/>
                                        </div>
                                    </div>
                                    <div class="control-group" id="jur">
                                        <label class="control-label" for="jurusan'.$row->aplEducationID.'">'.lang('jurusan').'</label>
                                        <div class="controls">
                                            <input type="text" name="jurusan" id="jurusan'.$row->aplEducationID.'" class="input-xlarge" placeholder="'.lang('jurusan').'" value="'.$row->aplEducationMajor.'"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="kota'.$row->aplEducationID.'">'.lang('kota').'</label>
                                        <div class="controls">
                                            <input type="text" name="kota" id="kota'.$row->aplEducationID.'" class="input-xlarge" placeholder="'.lang('kota').'" value="'.$row->aplEducationCity.'"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="negara'.$row->aplEducationID.'">'.lang('negara').'</label>
                                        <div class="controls">
                                            <select name="negara" id="negara'.$row->aplEducationID.'" class="padd5AB">
                                                <option value="">'.lang('pilih').' '.lang('negara').'</option>';
                                                
                                                    $negara = $this->reference->referensi_negara();   
                                                    foreach ($negara->result() as $row2)
                                                    {
                                                        if ($row->aplEducationCountry == $row2->CountryCode)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";
                                                        $res .= '<option value="'.$row2->CountryCode.'"'.$selected.'>'.ucwords(strtolower($row2->CountryName)).'</option>';
                                                    }
                                                
                        $res .='                    </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunMasuk'.$row->aplEducationID.'">'.lang('tahun_masuk').'</label>
                                        <div class="controls">
                                            <select name="tahunMasuk" id="tahunMasuk'.$row->aplEducationID.'" class="input-small">
                                                <option value="">'.lang('pilih').'</option>';
                                                
                                                    $tahunAkhir = (date("Y")-15);
                                                    for ($i = (date("Y")+1); $i--; $i > $tahunAkhir)
                                                    {

                                                        if ($row->aplEducationYearStart == $i)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";

                                                        if ($i >= $tahunAkhir)
                                                            $res .= '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
                                                    }
                                                
                        $res .='            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunLulus'.$row->aplEducationID.'">'.lang('tahun_lulus').'</label>
                                        <div class="controls">
                                            <select name="tahunLulus" id="tahunLulus'.$row->aplEducationID.'" class="input-small">
                                                <option value="">'.lang('pilih').'</option>';
                                                
                                                    $tahunAkhir = (date("Y")-15);
                                                    for ($i = (date("Y")+1); $i--; $i > $tahunAkhir)
                                                    {
                                                        if ($row->aplEducationYearEnd == $i)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";

                                                        if ($i >= $tahunAkhir)
                                                            $res .= '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';
                                                    }
                                        $res .='</select>

                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="no_ijazah'.$row->aplEducationID.'">'.lang('no_ijazah').'</label>
                                        <div class="controls">
                                            <input type="text" name="no_ijazah" id="no_ijazah'.$row->aplEducationID.'" class="input-large" placeholder="'.lang('no_ijazah').'" value="'.$row->aplEducationCert.'"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="lulus'.$row->aplEducationID.'">'.lang('lulus').'</label>
                                        <div class="controls">
                                            <input type="text" name="lulus" id="lulus'.$row->aplEducationID.'" class="input-large" placeholder="'.lang('lulus').'" value="'.$row->aplEducationGraduate.'"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="gelar'.$row->aplEducationID.'">'.lang('gelar').'</label>
                                        <div class="controls">
                                            <input type="text" name="gelar" id="gelar'.$row->aplEducationID.'" class="input-small" placeholder="'.lang('gelar').'" value="'. $row->aplEducationDegree.'"/>
                                        </div>
                                    </div>

                                    <div class="control-group">
                                        <label class="control-label" for="letak_gelar'.$row->aplEducationID.'">'.lang('letak_gelar').'</label>
                                        <div class="controls">
                                            <label class="radio inline padd5AB">
                                                <input type="radio" name="letak_gelar" id="letakd'.$row->aplEducationID.'" value="D" checked="'.$checkdepan.'"/>
                                                '.lang('gelar_depan').'
                                            </label>
                                            <label class="radio inline padd5AB">
                                                <input type="radio" name="letak_gelar" id="letakb'.$row->aplEducationID.'" value="B" checked="'.$checkbelakang.'"/>
                                                '.lang('gelar_belakang').'
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="nilai'.$row->aplEducationID.'">'.lang('nilai_akhir').'/'.lang('ipk').'</label>
                                        <div class="controls">
                                            <input type="text" name="nilai" id="nilai'.$row->aplEducationID.'" class="input-small" placeholder="'.lang('nilai_akhir').'" value="'.$row->aplEducationGPA.'"/>
                                            <div class="alert alert-success" style="width: 200px;margin-top: 10px;">'.lang('pisah').'</div>
                                        </div>
                                        <div class="controls">
                                            <input type="checkbox" name="last" id="last'.$row->aplEducationID.'" value="L" checked="'.$checkdepan.'"/>
                                                Is Last Education?
                                        </div>  
                                    </div>                            
                                </div>
                                <div class="modal-footer">
                                        <input type="hidden" name="hiddenIDEducation" id="hiddenIDEducation'.$row->aplEducationID.'" value="'.$row->aplEducationID.'"/>
                                        <input type="submit" class="btn btn-info" name="simpan_Education" onClick="edit_education('.$row->aplEducationID.')" id="simpan_educationedit'.$row->aplEducationID.'" value="'.lang('simpan').'" />
                                        <a class="btn" data-dismiss="modal">'.lang('batal').'</a>
                                </div>
                            </div>
                        </div>';

                        /*==============================Education Edit End======================*/
                            if ($bool_change || $bool_delete)        
                            {                                
                                $res .= '
                                                <div class="btn-group">';
                                        if ($bool_change)
                                        {
                                            $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="workExEdit('.$row->aplEducationID.')"><i class="icon-pencil "></i></a>';
                                        }
                                        if ($bool_delete)
                                        {
                                            $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-work" title="'.lang('hapus').'" onclick="workExDelete(\''.$row->aplEducationID.'\', \''.$row->aplEducationInstitution.'\')"><i class="icon-trash "></i></a>';
                                        }
                                        $res .= '</div>';
                            }                        
                                $i++;
                        }
                        $res .= '</div></div>';            
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
                $res .='    <div class="tab-pane" id="course" style="padding: 15px;">
                                <div id="pendidikan"  style="margin-left:15%;">
                                        <div style="float:left;margin-top:-20px;">
                                        <h4 >'. lang('pelatihan').'</h4>
                                        </div>';            
            
                $view = $this->session->userdata('view');

                foreach ($allCourse->result() as $row)   
                {
                    $res.=' <div>                                       
                                <div class="modal-header">
                                    <div style="padding-right:0;margin-right:0;float:right" >
                                        <a data-toggle="modal" href="#course_edit'.$row->aplCourseID.'" class="btn"><i class="icon-edit"></i>&nbsp;'. lang('edit').'</a>
                                    </div>
                                    <div style="padding-right:0;margin-right:0;float:right" >
                                        <a data-toggle="modal" href="#dialog-non-pendidikan" class="btn"><i class="icon-plus"></i>&nbsp;'. lang('tambah').'</a>
                                    </div>
                                    <div style="padding-right:0;margin-right:0;float:right" >
                                        <a data-toggle="modal" href="" onClick="courseDelete('.$row->aplCourseID.',\''. $row->aplCourseName.'\')"  class="btn"><i class="icon-remove"></i>&nbsp;'. lang('hapus').'</a>
                                        
                                    </div>
                                </div>

                                <div class="form-horizontal" style="padding-top: 10px;">
                                    <div class="control-group">
                                        <label class="control-label" for="jenjang"><b>'.lang('pelatihan').' : </b></label> <label class="control-label-isi" >'. $row->aplCourseName.'</label>                                        
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="institusi"><b>'.lang('penyelenggara').' : </b></label> <label class="control-label-isi" >'. $row->aplCourseOrganizer.'</label>                                         
                                    </div>
                                    <div class="control-group" id="jur">
                                        <label class="control-label" for="jurusan"><b>'.lang('kota').' : </b></label> <label class="control-label-isi" >'. $row->aplCourseCity.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="jurusan"><b>'.lang('sertifikat').' : </b></label> <label class="control-label-isi" >'. $row->aplCourseNoCertificate.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunMasuk"><b>'.lang('tanggal_awal').' : </b></label> <label class="control-label-isi" >'. $row->aplCourseStart.'</label> 
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunLulus"><b>'.lang('tanggal_akhir').' : </b></label> <label class="control-label-isi" >'. $row->aplCourseEnd.'</label> 
                                    </div>                                      
                                </div>
                            </div>';
                            /*==============================Course Edit==========================*/
                        $res.='<div id="course_edit'.$row->aplCourseID.'" class="modal custom hide fade in" style="display: none; width: 680px;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4>'.lang('pelatihan').'</h4>
                                    </div>'; 


                        $res.=  '
                                        <div class="form-horizontal" style="margin-left: -50px;">';
                                            $res.=  '<div class="control-group">
                                                <label class="control-label" for="pelatihan">'.lang('pelatihan').'</label>
                                                <div class="controls">
                                                    <textarea name="pelatihan" id="pelatihan'.$row->aplCourseID.'" placeholder="'.lang('pelatihan').'" rows="3" style="width: 300px;">'.$row->aplCourseName.'</textarea>
                                                </div>
                                            </div>';
                                            $res.=  '<div class="control-group">
                                                <label class="control-label" for="penyelenggara">'.lang('penyelenggara').'</label>
                                                <div class="controls">
                                                    <input type="text" name="penyelenggara" id="penyelenggara'.$row->aplCourseID.'" class="input-xlarge" placeholder="'.lang('penyelenggara').'" value="'. $row->aplCourseOrganizer.'"/>
                                                </div>
                                            </div>';
                                            $res.=  '<div class="control-group">
                                                <label class="control-label" for="kota_penyelenggara">'.lang('kota').' '.lang('penyelenggara').'</label>
                                                <div class="controls">
                                                    <input type="text" name="kota_penyelenggara" id="kota_penyelenggara'.$row->aplCourseID.'" class="input-xlarge" placeholder="'.lang('kota').' '.lang('penyelenggara').'" value="'.$row->aplCourseCity.'"/>
                                                </div>
                                            </div>';
                                            $res.=  '<div class="control-group">
                                                <label class="control-label" for="sertifikat">'.lang('sertifikat').'</label>
                                                <div class="controls">
                                                    <input type="text" name="sertifikat" id="sertifikat'.$row->aplCourseID.'" class="input-xlarge" placeholder="'.lang('sertifikat').'" value="'.$row->aplCourseNoCertificate.'"/>
                                                </div>
                                            </div>';
                                            $res.=  '<div class="control-group">
                                                <label class="control-label" for="tanggal_awal">'.lang('tanggal_awal').'</label>
                                                <div class="controls">
                                                    <select name="tanggalPelatihanAwal" id="tanggalPelatihanAwal'.$row->aplCourseID.'" style="width: 100px;" onchange="courseStartDate()">
                                                        <option value="">'.lang('tanggal').'</option>';
                                                        
                                                            $tgl = 1;
                                                            for($tgl == 1; $tgl <= 31; $tgl++)
                                                            {
                                                                if ($row->aplCourseStart != "")
                                                                    $date = date('d', strtotime($row->aplCourseStart));
                                                                else
                                                                    $date = "";
                                                                if ($date == $tgl)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";
                                                                $res .= '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
                                                            }
                                                        
                                            $res .='        </select>
                                                    <select name="bulanPelatihanAwal" id="bulanPelatihanAwal'.$row->aplCourseID.'" style="width: 110px;" onchange="courseStartDate()">
                                                        <option value="">'.lang('bulan').'</option>';
                                                        
                                                        $bulan = $this->reference->referensi_bulan();   
                                                            foreach ($bulan->result() as $row2)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row2->MonthNameID;
                                                                else
                                                                    $bln = $row2->MonthNameEN;

                                                                if ($row->aplCourseStart != "")
                                                                    $month = date('m', strtotime($row->aplCourseStart));
                                                                else
                                                                    $month = "";

                                                                if ($month == $row2->MonthID)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                $res .= '<option value="'.$row2->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                            }
                                                        
                                            $res .='</select>
                                                    <select name="tahunPelatihanAwal" id="tahunPelatihanAwal'.$row->aplCourseID.'" class="input-small" onchange="courseStartDate()">
                                                        <option value="">'.lang('tahun').'</option>';
                                                        
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                if ($row->aplCourseStart != "")
                                                                    $year = date('Y', strtotime($row->aplCourseStart));
                                                                else
                                                                    $year = "";

                                                                if ($year == $thn)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                $res .='<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                            }
                                                        
                                            $res .='</select>
                                                </div>
                                            </div>';
                                            $res.=  '<div class="control-group">
                                                <label class="control-label" for="tanggal_akhir">'.lang('tanggal_akhir').'</label>
                                                <div class="controls">
                                                    <select name="tanggalPelatihanAkhir" id="tanggalPelatihanAkhir'.$row->aplCourseID.'" style="width: 100px;" onchange="courseStartEnd()">
                                                        <option value="">'.lang('tanggal').'</option>';
                                                        
                                                            $tgl = 1;
                                                            for($tgl == 1; $tgl <= 31; $tgl++)
                                                            {
                                                                if ($row->aplCourseEnd != "")
                                                                    $date = date('d', strtotime($row->aplCourseEnd));
                                                                else
                                                                    $date = "";
                                                                if ($date == $tgl)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";
                                                                $res .= '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
                                                            }
                                                        
                                            $res .='</select>
                                                    <select name="bulanPelatihanAkhir" id="bulanPelatihanAkhir'.$row->aplCourseID.'" style="width: 110px;" onchange="courseStartEnd()">
                                                        <option value="">'.lang('bulan').'</option>';
                                                        
                                                            foreach ($bulan->result() as $row2)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row2->MonthNameID;
                                                                else
                                                                    $bln = $row2->MonthNameEN;

                                                                if ($row->aplCourseEnd != "")
                                                                    $month = date('m', strtotime($row->aplCourseEnd));
                                                                else
                                                                    $month = "";

                                                                if ($month == $row2->MonthID)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                $res .= '<option value="'.$row2->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                            }
                                                        
                                            $res .='</select>
                                                    <select name="tahunPelatihanAkhir" id="tahunPelatihanAkhir'.$row->aplCourseID.'" class="input-small" onchange="courseStartEnd()">
                                                        <option value="">'.lang('tahun').'</option>';
                                                        
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                if ($row->aplCourseEnd != "")
                                                                    $year = date('Y', strtotime($row->aplCourseEnd));
                                                                else
                                                                    $year = "";

                                                                if ($year == $thn)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                $res .= '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                            }
                                                        
                                            $res .='</select>
                                                </div>

                                            </div>
                                        </div>
                                <div class="modal-footer">
                                        <input type="hidden" name="hiddenIDCourse" id="hiddenIDCourse'.$row->aplCourseID.'" value="'.$row->aplCourseID.'"/>
                                        <input type="submit" class="btn btn-info" name="simpan_course" onClick="edit_course('.$row->aplCourseID.')" id="simpan_courseEdit'.$row->aplCourseID.'" value="'.lang('simpan').'" />
                                        <a class="btn" data-dismiss="modal">'.lang('batal').'</a>
                                </div></div>';
                            /*=================================Course Edit End===========================*/        

                }
                $res .= '</div></div></div>';                  
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

    public function edit_course()
    {

        if ($this->input->post('ajax'))
        {  
            $id = $this->input->post('id');            
            
            $getPerson = $this->load_person();
            $email = $getPerson->AppUserListEmail;
                            
            $name = $this->input->post('name');
            $penyelenggara = $this->input->post('penyelenggara');
            $kota_penyelenggara = $this->input->post('kota');
            $sertifikat = $this->input->post('sertifikat');
            $start = $this->input->post('start');
            $end = $this->input->post('end');
            //echo $nama." - ".$email." - ".$perusahaan." - ".$alamat_perusahaan." - ".$kota_perusahaan." - ".$telp_perusahaan." - ".$atasan
            //." - ".$posisi." - ".$mulai." - ".$akhir." - ".$gaji_awal." - ".$gaji_akhir." - ".$deskripsi." - ".$alasan_keluar;
            
            if ($id == "")
                echo $this->applicant->add_course($email, $name, $penyelenggara, $kota_penyelenggara, $sertifikat, $start, $end);
            else
                echo $this->applicant->update_course($id, $email, $name, $penyelenggara, $kota_penyelenggara, $sertifikat, $start, $end);
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
    public function edit_work_experience()
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
                /*$res .= 
                '
                <div class="alert alert-success hide" id="success_work">
                    Data berhasil dimasukan.
                </div>
                <div class="alert alert-error hide" id="error_work">
                    Data gagal dimasukan, silakan coba lagi.
                </div>';  */
                $res .='<div class="tab-pane" id="pengalaman_kerja" style="padding: 15px;">
                                        <div style="float:left;margin-top:-20px;">
                                        <h4 >'. lang('pengalaman_kerja').'</h4>
                                        </div>
                                    ';

                //$res .= '<table class="table table-hover">';
                $view = $this->session->userdata('view');
                $i=1;
                foreach ($allWork->result() as $row)
                {


/*=================================================*/



                                    $res.='                                        
                                        <div class="modal-header">
                                            <div style="padding-right:0;margin-right:0;float:right" >
                                                <a data-toggle="modal" href="#pengalaman_kerja_edit'.$i.'" class="btn"><i class="icon-edit"></i>&nbsp;'. lang('edit').'</a>
                                            </div>
                                            <div style="padding-right:0;margin-right:0;float:right" >
                                                <a data-toggle="modal" href="#dialog-pengalaman" class="btn"><i class="icon-edit"></i>&nbsp;'. lang('tambah').'</a>
                                            </div>
                                            <div style="padding-right:0;margin-right:0;float:right" >
                                                <a data-toggle="modal" href="" onClick="workExDelete('.$row->aplWorkExperienceID.',\''. $row->aplWorkExCompany.'\')"  class="btn"><i class="icon-remove"></i>&nbsp;'. lang('hapus').'</a>
                                                
                                            </div>
                                        </div>
                                        <div id="pengalaman"  style="margin-left:15%;">
                                            <div class="form-horizontal" style="margin-left: -40px;">
                                                <div class="control-group">
                                                    <label class="control-label" for="perusahaan"><b>'. lang('perusahaan').' '.$i.' : </b></label> <label  class="control-label-isi" >'. $row->aplWorkExCompany.'</label>                                   
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="alamat_perusahaan"><b>'. lang('alamat').' : </b></label> <label class="control-label-isi" >'.  $row->aplWorkExAddress .'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="kota_perusahaan"><b>'.  lang('kota'). ' : </b></label> <label class="control-label-isi" >'. $row->aplWorkExCity.'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="telp_perusahaan"><b>'.  lang('no_telp').' : </b></label> <label class="control-label-isi" >'. $row->aplWorkPhoneNumber.'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="atasan"><b>'. lang('atasan').' : </b></label> <label class="control-label-isi" >'.  $row->aplWorkExLastSpv.'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="posisi"><b>'. lang('posisi').' : </b></label> <label class="control-label-isi" >'.  $row->aplWorkExPosition.'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="periode_kerja"><b>'. lang('periode').' : </b></label>';
                                                if ($row->aplWorkExEnd != "Sekarang")
                                                {
                                                    $row->aplWorkExEnd = date('M Y', strtotime($row->aplWorkExEnd));
                                                    $end = new DateTime($row->aplWorkExEnd);
                                                }
                                                else
                                                    $end = new DateTime();
                                                $datestart = new DateTime($row->aplWorkExStart);
                                                $dateend = $end;
                                                $interval = date_diff($datestart, $dateend);
                                                $intr = $interval->format("(%y ".lang('tahun').", %mm ".lang('bulan').", %d ".lang('hari').")");
                                        $res .= '   <label class="control-label-isi" >'.date('M Y', strtotime($row->aplWorkExStart)).' '.lang('s.d').' '.$row->aplWorkExEnd.' '.$intr.'</label>';
                                        $res .=        '
                                                </div>

                                                <div class="control-group">
                                                    <label class="control-label" for="gaji_awal"><b>'.lang('gaji_awal').' : </b></label> <label class="control-label-isi" >' .$row->aplWorkExStartSalary.'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="gaji_akhir"><b>'.lang('gaji_akhir').' : </b></label> <label class="control-label-isi" >'.$row->aplWorkExEndSalary.'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="deskripsi"><b>'.lang('deskripsi').' : </b></label> <label class="control-label-isi" >'.$row->aplWorkExDescription.'</label>
                                                </div>
                                                <div class="control-group">
                                                    <label class="control-label" for="alasan_keluar"><b>'.  lang('alasan_keluar').' : </b></label> <label class="control-label-isi" >'.  $row->aplWorkExReasonLeave.'</label>
                                                </div>
                                            </div>
                                        </div>';

                                $res.='<div id="pengalaman_kerja_edit'.$row->aplWorkExperienceID.'" class="modal custom hide fade in" style="display: none; width: 680px;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4>'.lang('pengalaman_kerja').'</h4>
                                    </div>';                                    
                                $res.='<div class="modal-body">
                                        <div class="form-horizontal" style="margin-left: -40px;">
                                            <div class="control-group">
                                                <label class="control-label" for="perusahaan">'.lang('perusahaan').'</label>
                                                <div class="controls">
                                                    <input type="text" name="perusahaan" id="perusahaan'.$row->aplWorkExperienceID.'" class="input-xlarge" placeholder="'.lang('perusahaan').'"  value="'.$row->aplWorkExCompany.'"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="alamat_perusahaan">'.lang('alamat').'</label>
                                                <div class="controls">
                                                    <textarea name="alamat_perusahaan" id="alamat_perusahaan'.$row->aplWorkExperienceID.'" placeholder="'.lang('alamat').'" rows="3" style="width: 300px;">'.$row->aplWorkExAddress.'</textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="kota_perusahaan">'.lang('kota').'</label>
                                                <div class="controls">
                                                    <input type="text" name="kota_perusahaan" id="kota_perusahaan'.$row->aplWorkExperienceID.'" class="input-xlarge" placeholder="'.lang('kota').'"  value="'. $row->aplWorkExCity.'"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="telp_perusahaan">'.lang('no_telp').'</label>
                                                <div class="controls">
                                                    <input type="text" name="telp_perusahaan" id="telp_perusahaan'.$row->aplWorkExperienceID.'" class="input-xlarge hp" placeholder="'.lang('no_telp').'"  value="'.$row->aplWorkPhoneNumber.'"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="atasan">'.lang('atasan').'</label>
                                                <div class="controls">
                                                    <input type="text" name="atasan" id="atasan'.$row->aplWorkExperienceID.'" class="input-xlarge" placeholder="'.lang('atasan').'"  value="'.$row->aplWorkExLastSpv.'"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="posisi">'.lang('posisi').'</label>
                                                <div class="controls">
                                                    <input type="text" name="posisi" id="posisi'.$row->aplWorkExperienceID.'" class="input-xlarge" placeholder="'.lang('posisi').'"  value="'.$row->aplWorkExPosition.'"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="periode_kerja">'.lang('periode').'</label>
                                                <div class="controls">
                                                    <select name="bulanKerjaAwal" id="bulanKerjaAwal'.$row->aplWorkExperienceID.'" style="width: 110px;" onchange="courseStartDate()">
                                                        <option value="">'.lang('bulan').'</option>';
                                                        $bulan = $this->reference->referensi_bulan();   
                                                            foreach ($bulan->result() as $row2)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row2->MonthNameID;
                                                                else
                                                                    $bln = $row2->MonthNameEN;

                                                                if ($row->aplWorkExStart != "")
                                                                    $month = date('m', strtotime($row->aplWorkExStart));
                                                                else
                                                                    $month = "";

                                                                if ($month == $row2->MonthID)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                $res.='<option value="'.$row2->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                            }
                                                       
                                                $res.='</select>';
                                                $res.='<select name="tahunKerjaAwal" id="tahunKerjaAwal'.$row->aplWorkExperienceID.'" class="input-small" onchange="courseStartDate()">
                                                        <option value="">'.lang('tahun').'</option>';
                                                        
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                if ($row->aplWorkExStart != "")
                                                                    $year = date('Y', strtotime($row->aplWorkExStart));
                                                                else
                                                                    $year = "";

                                                                if ($year == $thn)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                             $res.= '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                            }
                                                        
                                                $res.='</select>
                                                    s.d
                                                    <select name="bulanKerjaAkhir" id="bulanKerjaAkhir'.$row->aplWorkExperienceID.'" style="width: 110px;" onchange="courseStartEnd()">
                                                        <option value="">'.lang('bulan').'</option>';
                                                        
                                                            foreach ($bulan->result() as $row2)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row2->MonthNameID;
                                                                else
                                                                    $bln = $row2->MonthNameEN;

                                                                if ($row->aplWorkExEnd != "")
                                                                    $month = date('m', strtotime($row->aplWorkExEnd));
                                                                else
                                                                    $month = "";

                                                                if ($month == $row2->MonthID)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                $res.= '<option value="'.$row2->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                            }
                                                        
                                                $res.='</select>
                                                    <select name="tahunKerjaAkhir" id="tahunKerjaAkhir'.$row->aplWorkExperienceID.'" class="input-small" onchange="courseStartEnd()">
                                                        <option value="">'.lang('tahun').'</option>';
                                                        
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                if ($row->aplWorkExEnd != "")
                                                                    $year = date('Y', strtotime($row->aplWorkExEnd));
                                                                else
                                                                    $year = "";

                                                                if ($year == $thn)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                $res.='<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                            }
                                                        
                                                $res.='</select>
                                                    <label for="masih_bekerja">
                                                        <input type="checkbox" name="masih_bekerja" id="masih_bekerja'.$row->aplWorkExperienceID.'"/>
                                                        '.lang('masih_bekerja').'
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="gaji_awal">'.lang('gaji_awal').'</label>
                                                <div class="controls">
                                                    <input type="text" name="gaji_awal" id="gaji_awal'.$row->aplWorkExperienceID.'" class="input-medium gaji" placeholder="'.lang('gaji_awal').'" value="'. $row->aplWorkExStartSalary.'"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="gaji_akhir">'.lang('gaji_akhir').'</label>
                                                <div class="controls">
                                                    <input type="text" name="gaji_akhir" id="gaji_akhir'.$row->aplWorkExperienceID.'" class="input-medium gaji" placeholder="'.lang('gaji_akhir').'" value="'. $row->aplWorkExEndSalary.'"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="deskripsi">'.lang('deskripsi').'</label>
                                                <div class="controls">
                                                    <textarea name="deskripsi" id="deskripsi'.$row->aplWorkExperienceID.'" placeholder="'.lang('deskripsi').'" rows="3" style="width: 300px;">'.$row->aplWorkExDescription.'</textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="alasan_keluar">'.lang('alasan_keluar').'</label>
                                                <div class="controls">
                                                    <textarea name="alasan_keluar" id="alasan_keluar'.$row->aplWorkExperienceID.'" placeholder="'.lang('alasan_keluar').'" rows="3" style="width: 300px;">'.$row->aplWorkExReasonLeave.'</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>';
                            $res.= '<div class="modal-footer">
                                        <input type="hidden" name="hiddenIDPengalaman" id="hiddenIDPengalaman'.$row->aplWorkExperienceID.'" value="'.$row->aplWorkExperienceID.'"/>
                                        <input type="submit" class="btn btn-info" name="simpan_pengalaman" onClick="edit_work('.$row->aplWorkExperienceID.')" id="simpan_pengalamanEdit'.$row->aplWorkExperienceID.'" value="'.lang('simpan').'" />
                                        <a class="btn" data-dismiss="modal">'.lang('batal').'</a>
                                    </div>
                                </div>';


/*=================================================*/


















                    
                            if ($bool_change || $bool_delete)        
                            {                                
                                $res .= '
                                                <div class="btn-group">';
                                        if ($bool_change)
                                        {
                                            $res .= '<a class="btn enabled" href="#" title="'.lang('edit').'" onclick="workExEdit('.$row->aplWorkExperienceID.')"><i class="icon-pencil "></i></a>';
                                        }
                                        if ($bool_delete)
                                        {
                                            $res .= '<a class="btn enabled"  data-toggle="modal"  href="#dialog-delete-work" title="'.lang('hapus').'" onclick="workExDelete(\''.$row->aplWorkExperienceID.'\', \''.$row->aplWorkExCompany.'\')"><i class="icon-trash "></i></a>';
                                        }
                                        $res .= '</div>';
                            }                      
                                $i++;
                }
              //  $res .= '</table>';            
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