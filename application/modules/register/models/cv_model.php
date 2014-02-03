<?php
/**
 * @author Gita D <gita.dwij@windowslive.com>
 * @lastedit 16 June, 2013
 */
class CV_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }
    
    function get_person($email){
        $this->db->where('aplEmail', $email);
        $result = $this->db->get('tbmApplicant');
        $row = $result->row();
        return $row;
    }    
    
    
    /*
    * Filter person by name, place and date of birth, email and ..
    * So there are no double applicant
    */
    function filter_person($name, $placeb, $dateb, $email){
        $this->db->where('aplNama', $name);
        $result = $this->db->get('tbmApplicant');        
        if ($result->num_rows() == 0)
            return $result;   
        else
        {
            $this->db->where('aplNama', $name);
            $this->db->where('aplTempatLahir', $placeb);
            $this->db->where('aplTanggalLahir', $dateb);
            $result = $this->db->get('tbmApplicant');        
            if ($result->num_rows() == 0)
                return $result;   
            else
            {
                $this->db->where('aplNama', $name);
                $this->db->where('aplTempatLahir', $placeb);
                $this->db->where('aplTanggalLahir', $dateb);
                $this->db->where('aplEmail', $email);
                $result = $this->db->get('tbmApplicant');        
                return $result;   
            }            
        }
    }
    
    /*
    * Add personal data when applicants register
    * 1. Filter person
    * 2. If applicant doesnt exist, data will be entered
    */    
    function register($name, $placeb, $dateb, $email, $celular, $identity, $identity_num, $password, $subscribe, $sex, $status, $religion)
    {
        if ($name != "" && $placeb != "" && $dateb != "" && $email != "" && $celular != "" && $identity != "" && $identity_num != "" && $password != "" && $sex != "" && $status != "" && $religion != "")
        {
            $result = $this->filter_person($name, $placeb, $dateb, $email); //1
            
            $this->db->set('aplNama', $name);
            $this->db->set('aplTempatLahir', $placeb);
            $this->db->set('aplTanggalLahir', $dateb);
            $this->db->set('aplEmail', $email);
            $this->db->set('aplHP', $celular);
            $this->db->set('aplKartuIdentitasJenis', $identity);
            $this->db->set('aplKartuIdentitasNo', $identity_num);
            $this->db->set('aplPassword', $password);                 
            $this->db->set('aplSubscribe', $subscribe);                 
            $this->db->set('aplKelamin', $sex);                 
            $this->db->set('aplStatusMarital', $status);                 
            $this->db->set('aplAgama', $religion);                 
    
            if ($result->num_rows() == 0) //2
            {
                $this->db->set('aplTglDaftar', date('Y-m-d H:i:s'));                 
                $add = $this->db->insert('tbmApplicant');     
                if ($add)
                    return true;
                else
                    return false;  
            } else 
                return false;
        } else
            return false;                            
    }        
    
    /*
    * Add personal data when applicants register
    * 1. Filter person
    * 2. If applicant doesnt exist, data will be entered
    * 3. If applicant exist, data will be updated. 
    */    
    function addfirst_personal($name, $placeb, $dateb, $sex, $religion, $marital, $email, $code, $phone, $celular)
    {
        if ($name != "" && $placeb != "" && $dateb != "" && $sex != "" && $religion != "" && $marital != "" && $email != "" && $celular != "")
        {
            $result = $this->filter_person($name, $placeb, $dateb, $email); //1
            
            $this->db->set('aplNama', $name);
            $this->db->set('aplTempatLahir', $placeb);
            $this->db->set('aplTanggalLahir', $dateb);
            $this->db->set('aplKelamin', $sex);
            $this->db->set('aplAgama', $religion);
            $this->db->set('aplStatusMarital', $marital);
            $this->db->set('aplEmail', $email);
            $this->db->set('aplTelpKodeDaerah', $code);
            $this->db->set('aplTelpNomor', $phone);
            $this->db->set('aplHP', $celular);                 
    
            if ($result->num_rows() == 0) //2
            {
                $this->db->set('aplTglDaftar', date('Y-m-d H:i:s'));                 
                $add = $this->db->insert('tbmApplicant');     
            }
            else //3
            {
                $row = $result->row();
                $this->db->where('aplNoDaftar', $row->aplNoDaftar);
                $add = $this->db->update('tbmApplicant');
            }   
            
            if ($add)
                return true;
            else
                return false;  
        } else
            return false;                            
    }    
    
    /*
    * Get ID person from name and email
    */    
    public function check_idperson($name, $email)
    {
        $this->db->select("aplNoDaftar");
        $this->db->where('aplNama', $name);
        $this->db->where('aplEmail', $email);
        $result = $this->db->get('tbmApplicant');        
        return $result;                   
    }
    
    /*
    * Get educationid from personid, level education, institution of education, major and year of education began
    */    
    public function check_education($personID, $level, $institution, $major, $start)
    {
        $this->db->select("aplEducationID");
        $this->db->where('aplPersonID', $level);
        $this->db->where('aplEducationLevel', $institution);
        $this->db->where('aplEducationMajor', $major);
        $this->db->where('aplEducationYearStart', $start);
        $result = $this->db->get('tbmAplEducation');        
        return $result; 
    }
    
    /*
    * Add education data when applicants register
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    * 3. If education doesnt exist, data will be entered
    * 4. If education exist, data will be updated
    */     
    function addfirst_education($name, $email, $level, $institution, $major, $city, $country, $start, $end, $gpa, $certificate)
    {
        if ($name != "" && $email != "" && $level != "" && $institution != "" && $city != "" && $country != "" && $start != "" && $end != "" && $gpa != "" && $certificate != "")
        { 
            $check_person = $this->check_idperson($name, $email); //1
            if ($check_person->num_rows() > 0) //2
            {        
                $row = $check_person->row();
                
                $check_education = $this->check_education($row->aplNoDaftar, $level, $institution, $major, $start);
    
                $this->db->set('aplEducationLevel', $level);
                $this->db->set('aplEducationInstitution', $institution);
                $this->db->set('aplEducationMajor', $major);
                $this->db->set('aplEducationCity', $city);
                $this->db->set('aplEducationCountry', $country);
                $this->db->set('aplEducationYearStart', $start);
                $this->db->set('aplEducationYearEnd', $end);
                $this->db->set('aplEducationGPA', $gpa);
                $this->db->set('aplEducationCert', $certificate);         
                $this->db->set('aplEducationStatus', 1);
    
                if ($check_education->num_rows() == 0) //3
                {        
                    $this->db->set('aplPersonID', $row->aplNoDaftar);
                    $add = $this->db->insert('tbmAplEducation');    
                } else { //4 
                    $rowED = $check_education->row();
                    $this->db->where("aplEducationID", $rowED->aplEducationID);
                    $add = $this->db->update('tbmAplEducation');
                }
                if ($add)
                    return true;
                else
                    return false;
            }
        } else
            return false;
    }    
    
    /*
    * Add the others data when applicants register
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    * 3. If data exist, data will be updated
    */     
    function addfirst_data($name, $email, $salary)
    {
        if ($name != "" && $email != "" && $salary != "")
        {      
            $check_person = $this->check_idperson($name, $email); //1
            if ($check_person->num_rows() > 0) //2
            {        
                $row = $check_person->row();
                
                $this->db->set('aplGajiDiharapkan', $salary);
                $this->db->where("aplNoDaftar", $rowED->aplNoDaftar);
                $add = $this->db->update('tbmApplicant'); //3
                if ($add)
                    return true;
                else
                    return false;
            }
        } else
            return false;
    }        
} 