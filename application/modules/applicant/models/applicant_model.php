<?php
/**
 * @author Gita D <gita.dwij@windowslive.com>
 * 
 */
class Applicant_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }
    
    /*function get_person($email, $identitycard=""){
        $this->db->select('*, DATEDIFF(year, aplDateOfBirth, getdate()) - 
                                CASE
                                WHEN DATEADD(YY, DATEDIFF(YY, aplDateOfBirth, getdate()), aplDateOfBirth) > GETDATE()
                                then 1
                                else 0
                                end as Age');
        $this->db->like('aplEmail', $email);
        $this->db->like('aplIdentityNumber', $identitycard);
        $result = $this->db->get('tbmApplicant');
        return $result;
    }*/
    /*New*/     
    function get_person($email){
        $this->db->select('*, DATEDIFF(year, aplDateOfBirth, getdate()) - 
                                CASE
                                WHEN DATEADD(YY, DATEDIFF(YY, aplDateOfBirth, getdate()), aplDateOfBirth) > GETDATE()
                                then 1
                                else 0
                                end as Age');
        $this->db->where('AppUserListEmail', $email);
        $this->db->join("tbmApplicant", "tbmApplicant.aplPersonID = tbaAppUserList.AppUserListID");
        $this->db->join("tbaAppUserLevel", "tbaAppUserLevel.AppUserLevelUserID = tbaAppUserList.AppUserListID");
        $result = $this->db->get('tbaAppUserList');
        return $result;
    }
/*****************************
*
* Personal Data
*
******************************/
    /*
    * Get ID person from name and email
    */    
    /*public function check_idperson($name, $email)
    {
        $this->db->select("aplPersonID");
        $this->db->where('aplName', $name);
        $this->db->where('aplEmail', $email);
        $result = $this->db->get('tbmApplicant');        
        return $result;                   
    }*/
    public function check_idperson($email)
    {
        $this->db->select("AppUserListID");
        $this->db->where('AppUserListEmail', $email);
        $result = $this->db->get('tbaAppUserList');        
        return $result;                   
    }           
    
    /*function explode_name($name)
    {
        $epl = explode(" ", trim($name)); //explode name
        $explName = array();
        $j = 0;
        for($i = 0; $i < count($epl); $i++)
        {
            if ($i == 0)
            {
                $explName[$j] = $epl[$i];
                $j++;
            } else {
                $explName[$j] .= $epl[$i]." ";
            }
        }
        return $explName;
    }*/   
    
    /*
    * Add personal data when applicants register
    * 1. Filter person        
    * 2. Update data to tbaAppUserList.
    * 3. If applicant doesnt exist, data will be entered to tbmApplicant.
    * 4. If applicant exist, data will be updated to tbmApplicant. 
    */    
    function addfirst_personal($userID,$fname, $lname, $sex, $placeb, $dateb, $identity_number, $valid_until, $marital, $religion, $email, $alternate_email, $cellular, $alternate_cellular)
    {
        if ($fname != "" && $sex != "" && $placeb != "" && $dateb != "" && $identity_number != "" && $valid_until != "" && $marital != ""  && $religion != "" && $email != "" && $cellular != "")
        {
            $result = $this->get_person($email, $identity_number); //1
            $row = $result->row();
            
            //update to tbaAppUserList
            $this->db->set('AppUserListFirstName', $fname);
            $this->db->set('AppUserListLastName', $lname);
            $this->db->set('AppUserListEmail', $email);
            $this->db->set('AppUserListPhone', $cellular);                 
            $this->db->where('AppUserListID', $userID);
            $add = $this->db->update('tbaAppUserList'); //2

            //update to tbmApplicant
            $this->db->set('aplPersonID',$userID);
            $this->db->set('aplSex', $sex);
            $this->db->set('aplPlaceOfBirth', $placeb);
            $this->db->set('aplDateOfBirth', $dateb);
            $this->db->set('aplIdentityNumber', $identity_number);
            $this->db->set('aplIdentityValid', $valid_until);
            $this->db->set('aplMaritalStatus', $marital);
            $this->db->set('aplReligion', $religion);
            $this->db->set('aplAlternateEmail', $alternate_email);
            $this->db->set('aplAlternateCellular', $alternate_cellular);                 
    
            if ($result->num_rows() == 0) //3
            {
                $this->db->set('aplDateRegister', date('Y-m-d H:i:s'));                 
                $add2 = $this->db->insert('tbmApplicant');     
            }
            else //4
            {
                $this->db->where('aplPersonID', $row->aplPersonID);
                $add2 = $this->db->update('tbmApplicant');
            }   
            
            if ($add && $add2)
                return true;
            else
                return false;  
        } else
            return false;
    }        
    
/*
    * Add photo
    * 1. Filter        
    * 2. Update data to tbmApplicant
    */    
    function addphoto($id, $photo)
    {
        if ($id != "" && $photo != "") //
        {
            $this->db->set('aplPhoto', $photo);
            $this->db->where('aplPersonID', $id);
            $add = $this->db->update('tbmApplicant'); //2    
            if ($add)
                return true;
            else
                return false;  
        } else
            return false;
    }      
/*****************************
*
* End Personal Data
*
******************************/    
    
/*****************************
*
* Education Data
*
******************************/    
    /*
    * Get educationid from personid, level education, institution of education, major and year of education began
    */    
    public function check_education($personID, $level, $institution, $major, $start)
    {
        $this->db->select("aplEducationID");
        $this->db->where('aplPersonID', $personID);
        $this->db->where('aplEducationLevel', $level);
        $this->db->where('aplEducationInstitution', $institution);
        $this->db->where('aplEducationMajor', $major);
        $this->db->where('aplEducationYearStart', $start);
        $result = $this->db->get('tbmAplEducation');        
        return $result; 
    }
    
    /*
    * Get last educationid from personid 
    */    
    public function check_last_education($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $this->db->where('aplEducationStatus', '1');
        $result = $this->db->get('tbmAplEducation');        
        $row = $result->row();
        return $row;
    }    
    
    /*
    * View all education data 
    */    
    public function view_education($personID)
    {
        $this->db->select("*");
        $this->db->join('tbrEducationLevel', 'tbrEducationLevel.EducationLevelCode = tbmAplEducation.aplEducationLevel');
        $this->db->join('tbrCountry', 'tbrCountry.CountryCode = tbmAplEducation.aplEducationCountry');
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplEducation');     
        return $result;
    } 
	
    /*
    * Check education by id 
    */      
    public function check_education_id($id)
    {
        $this->db->select("*");
        $this->db->where('aplEducationID', $id);
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
    function add_education($email, $level, $institution, $major, $city, $country, $start, $end, $gpa, $certificate, $graduate, $degree, $position, $last)
    {
        if ($email != "" && $level != "" && $institution != "" && $city != "" && $country != "" && $start != "" && $end != "" && $gpa != "" && $certificate != "")
        { 
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {        
                $row = $check_person->row();
                
                $check_education = $this->check_education($row->AppUserListID, $level, $institution, $major, $start);
                $this->db->set('aplEducationLevel', $level);
                $this->db->set('aplEducationInstitution', $institution);
                $this->db->set('aplEducationMajor', $major);
                $this->db->set('aplEducationCity', $city);
                $this->db->set('aplEducationCountry', $country);
                $this->db->set('aplEducationYearStart', $start);
                $this->db->set('aplEducationYearEnd', $end);
                $this->db->set('aplEducationGPA', $gpa);
                $this->db->set('aplEducationCert', $certificate);
                if ($last)
                    $this->db->set('aplEducationStatus', 1);
                else
                    $this->db->set('aplEducationStatus', 0);                
                $this->db->set('aplEducationGraduate', $graduate);
                $this->db->set('aplEducationDegree', $degree);         
                $this->db->set('aplEducationDegreePos', $position);
    

                if ($check_education->num_rows() == 0) //3
                {        
                    $this->db->set('aplPersonID', $row->AppUserListID);
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
    * Update education
    * 1. Check id education
    * 2. If exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       	
    function update_education($id, $email, $level, $institution, $major, $city, $country, $start, $end, $gpa, $certificate, $graduate, $degree, $position, $last)
    {
        if ($id != "" && $email != "" && $level != "" && $institution != "" && $city != "" && $country != "" && $start != "" && $end != "" && $gpa != "" && $certificate != "")
        { 
			$check_education_id = $this->check_education_id($id); //1
            
            if ($check_education_id->num_rows() > 0) //2
            {
                $check_person = $this->check_idperson($email); //3
                if ($check_person->num_rows() > 0) //4
                {     
                    $person = $check_person->row();            
                    
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
					$this->db->set('aplEducationGraduate', $graduate);
					$this->db->set('aplEducationDegree', $degree);         
					$this->db->set('aplEducationDegreePos', $position);
                    if ($last)
                        $this->db->set('aplEducationStatus', 1);
                    else
                        $this->db->set('aplEducationStatus', 0);                      
                    $this->db->where("aplEducationID", $id);
                    $update = $this->db->update('tbmAplEducation');
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;			
        } else
            return false;
    }  	
	
    /*
    * Delete education
    * 1. Check id education
    * 2. If applicant exist, we can delete data
    */     
    function delete_education($id)
    {
        if ($id != "")
        {
            $check_education_id = $this->check_education_id($id); //1
            
            if ($check_education_id->num_rows() > 0) //2
            {
                $this->db->where('aplEducationID', $id);
                $delete = $this->db->delete('tbmAplEducation');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }   	
/*****************************
*
* End Education Data
*
******************************/       
    
/*****************************
*
* Course Data
*
******************************/  

    public function list_course($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplCourse');        
        $row = $result->row();
        return $row;
    }        
    /*
    * View course
    */    
    public function view_course($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplCourse');        
        return $result; 
    }    
    
    /*
    * Check course
    */      
    public function check_course($id)
    {
        $this->db->select("*");
        $this->db->where('aplCourseID', $id);
        $result = $this->db->get('tbmAplCourse');        
        return $result;                   
    }    
    
    /*
    * Add course data when applicants register
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    */   
    function add_course($email, $course, $organizer, $organizercity, $certificate, $courseStart, $courseEnd)
    {
        if ($email != "" && $course != "" && $organizer != "" && $organizercity != "" && $courseStart != "" && $courseEnd != "")
        { 
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {     
                $row = $check_person->row();            
                $this->db->set('aplPersonID', $row->AppUserListID);            
                $this->db->set('aplCourseName', $course);
                $this->db->set('aplCourseOrganizer', $organizer);
                $this->db->set('aplCourseCity', $organizercity);
                $this->db->set('aplCourseNoCertificate', $certificate);
                $this->db->set('aplCourseStart', $courseStart);
                $this->db->set('aplCourseEnd', $courseEnd);
                $add = $this->db->insert('tbmAplCourse');
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
    * Update couse
    * 1. Check id course
    * 2. If exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       
    function update_course($id, $email, $course, $organizer, $organizercity, $certificate, $courseStart, $courseEnd)
    {
        if ($id != "" && $email != "" && $course != "" && $organizer != "" && $organizercity != "" && $courseStart != "" && $courseEnd != "")
        { 
            $check_course = $this->check_course($id); //1
            
            if ($check_course->num_rows() > 0) //2
            {
                $check_person = $this->check_idperson($email); //3
                if ($check_person->num_rows() > 0) //4
                {     
                    $person = $check_person->row();            
                    
                    $this->db->set('aplPersonID', $person->AppUserListID);            
                    $this->db->set('aplCourseName', $course);
                    $this->db->set('aplCourseOrganizer', $organizer);
                    $this->db->set('aplCourseCity', $organizercity);
                    $this->db->set('aplCourseNoCertificate', $certificate);
                    $this->db->set('aplCourseStart', $courseStart);
                    $this->db->set('aplCourseEnd', $courseEnd);
                    $this->db->where("aplCourseID", $id);
                    $update = $this->db->update('tbmAplCourse');
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }     
    
    /*
    * Delete course
    * 1. Check id course
    * 2. If applicant exist, we can delete data
    */     
    function delete_course($id)
    {
        if ($id != "")
        {
            $check_course = $this->check_course($id); //1
            
            if ($check_course->num_rows() > 0) //2
            {
                $this->db->where('aplCourseID', $id);
                $delete = $this->db->delete('tbmAplCourse');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }    
/*****************************
*
* End Course Data
*
******************************/           
    
/*****************************
*
* Work Experience Data
*
******************************/           

    public function list_work($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplWorkExperience');        
        $row = $result->row();
        return $row;
    }  
    /*
    * Check work
    */      
    public function check_work($id)
    {
        $this->db->select("*");
        $this->db->where('aplWorkExperienceID', $id);
        $result = $this->db->get('tbmAplWorkExperience');        
        return $result;                   
    } 
      
    /*
    * Check work
    */      
    public function view_work($personid)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personid);
        $result = $this->db->get('tbmAplWorkExperience');        
        return $result;                   
    }       
        
    /*
    * Add work experience data when applicants register
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    */   
    
    function add_work_experience($email, $company, $company_address, $company_city, $company_phone, $spv, $position, $start, $end, $start_salary, $end_salary, $description, $reason)
    {
        if ($email != "" && $company != "" && $company_address != "" && $company_city != "" && $company_phone != "" && $spv != "" && $position!= "" && $start!= "" && $end != "" && $reason != "")
        { 
            $check_person = $this->check_idperson($email); //1
            $row = $check_person->row();            
            if ($check_person->num_rows() > 0) //2
            {     
                $row = $check_person->row();            
                
                if ($start_salary == "")
                    $start_salary = 0;
                if ($end_salary == "")
                    $end_salary = 0;

                $this->db->set('aplPersonID', $row->AppUserListID);            
                $this->db->set('aplWorkExCompany', $company);
                $this->db->set('aplWorkExAddress', $company_address);
                $this->db->set('aplWorkExCity', $company_city);
                $this->db->set('aplWorkPhoneNumber', $company_phone);
                $this->db->set('aplWorkExLastSpv', $spv);
                $this->db->set('aplWorkExPosition', $position);
                $this->db->set('aplWorkExStart', $start);
                $this->db->set('aplWorkExEnd', $end);
                $this->db->set('aplWorkExStartSalary', $start_salary);
                $this->db->set('aplWorkExEndSalary', $end_salary);
                $this->db->set('aplWorkExDescription', $description);
                $this->db->set('aplWorkExReasonLeave', $reason);
                $add = $this->db->insert('tbmAplWorkExperience');
                if ($add)
                    return true;
                else
                    return false;
                //return $name." ".$email." ".$company." ".$company_address." ".$company_city." ".$company_phone." ".$spv." ".$position." ".$start." ".$end." ".$salary." ".$description." ".$reason;
            } else
                return false;
        } else
            return false;
    }       
    
    /*
    * Update work experience
    * 1. Check id work
    * 2. Id exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       
    function update_work_experience($id, $email, $company, $company_address, $company_city, $company_phone, $spv, $position, $start, $end, $start_salary, $end_salary, $description, $reason)
    {
        if ($email != "" && $company != "" && $company_address != "" && $company_city != "" && $company_phone != "" && $spv != "" && $position!= "" && $start!= "" && $end != "" && $reason != "")
        { 
            $check_work = $this->check_work($id); //1
            
            if ($check_work->num_rows() > 0) //2
            {
                $work = $check_work->row();              
                
                $check_person = $this->check_idperson($email); //1
                if ($check_person->num_rows() > 0) //2
                {     
                    $person = $check_person->row();            
                    
                    if ($start_salary == "")
                        $start_salary = 0;
                    if ($end_salary == "")
                        $end_salary = 0;                    
                    
                    $this->db->set('aplPersonID', $person->AppUserListID);            
                    $this->db->set('aplWorkExCompany', $company);
                    $this->db->set('aplWorkExAddress', $company_address);
                    $this->db->set('aplWorkExCity', $company_city);
                    $this->db->set('aplWorkPhoneNumber', $company_phone);
                    $this->db->set('aplWorkExLastSpv', $spv);
                    $this->db->set('aplWorkExPosition', $position);
                    $this->db->set('aplWorkExStart', $start);
                    $this->db->set('aplWorkExEnd', $end);
                    $this->db->set('aplWorkExStartSalary', $start_salary);
                    $this->db->set('aplWorkExEndSalary', $end_salary);
                    $this->db->set('aplWorkExDescription', $description);
                    $this->db->set('aplWorkExReasonLeave', $reason);
                    $this->db->where("aplWorkExperienceID", $id);
                    $update = $this->db->update('tbmAplWorkExperience');                       
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;                    
        } else
            return false;
    }     
    
    /*
    * Delete work experience
    * 1. Check id course
    * 2. If applicant exist, we can delete data
    */     
    function delete_work_experience($id)
    {
        if ($id != "")
        {
            $check_work = $this->check_work($id); //1
            
            if ($check_work->num_rows() > 0) //2
            {
                $this->db->where('aplWorkExperienceID', $id);
                $delete = $this->db->delete('tbmAplWorkExperience');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }        
/*****************************
*
* End Work Experience Data
*
******************************/     
    
    /*
    * Add the others data when applicants register
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    * 3. If data exist, data will be updated
    */     
    function addother_data($email, $salary)
    {
        if ($email != "" && $salary != "")
        {      
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {        
                $row = $check_person->row();
                
                $this->db->set('aplExpectedSalary', $salary);
                $this->db->set('aplCompleteForm', 1);
                $this->db->where("aplPersonID", $row->AppUserListID);
                $add = $this->db->update('tbmApplicant'); //3
                if ($add)
                    return true;
                else
                    return false;
            }
        } else
            return false;
    }
    
    
/*****************************
*
* Family Data
*
******************************/       
    /*
    * View family
    */    
    public function view_family($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplFamily');        
        return $result; 
    }    
    
    /*
    * Check family
    */      
    public function check_family($id)
    {
        $this->db->select("*");
        $this->db->where('aplFamilyID', $id);
        $result = $this->db->get('tbmAplFamily');        
        return $result;                   
    }    
    
    /*
    * Add family data 
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    */   
    function add_family($email, $relation, $familyName, $sex, $place, $date, $education, $occupation)
    {
        if ($email != "" && $relation != "" && $familyName != "" && $sex != "" && $place != "" && $date != "" && $education != "" && $occupation != "")
        { 
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {     
                $row = $check_person->row();            
                $this->db->set('aplPersonID', $row->AppUserListID);            
                $this->db->set('aplFamilyRelation', $relation);
                $this->db->set('aplFamilyName', $familyName);
                $this->db->set('aplFamilySex', $sex);
                $this->db->set('aplFamilyPlaceOfBirth', $place);
                $this->db->set('aplFamilyDateOfBirth', $date);
                $this->db->set('aplFamilyEducation', $education);
                $this->db->set('aplFamilyOccupation', $occupation);
                $add = $this->db->insert('tbmAplFamily');
                if ($add)
                    return "true";
                else
                    return "false1".$email;
            } else
                return "false2".$email;
        } else
            return "false3".$email;
    }     
    
    /*
    * Update couse
    * 1. Check id family
    * 2. If exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       
    function update_family($id, $email, $relation, $familyName, $sex, $place, $date, $education, $occupation)
    {
        if ($id != "" && $email != "" && $relation != "" && $familyName != "" && $sex != "" && $place != "" && $date != "" && $education != "" && $occupation != "")
        { 
            $check_family = $this->check_family($id); //1
            
            if ($check_family->num_rows() > 0) //2
            {
                $check_person = $this->check_idperson($email); //3
                if ($check_person->num_rows() > 0) //4
                {     
                    $person = $check_person->row();            
                    
                    $this->db->set('aplPersonID', $person->AppUserListID);            
                    $this->db->set('aplFamilyRelation', $relation);
                    $this->db->set('aplFamilyName', $familyName);
                    $this->db->set('aplFamilySex', $sex);
                    $this->db->set('aplFamilyPlaceOfBirth', $place);
                    $this->db->set('aplFamilyDateOfBirth', $date);
                    $this->db->set('aplFamilyEducation', $education);
                    $this->db->set('aplFamilyOccupation', $occupation);
                    $this->db->where("aplFamilyID", $id);
                    $update = $this->db->update('tbmAplFamily');
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }     
    
    /*
    * Delete course
    * 1. Check id family
    * 2. If applicant exist, we can delete data
    */     
    function delete_family($id)
    {
        if ($id != "")
        {
            $check_family = $this->check_family($id); //1
            
            if ($check_family->num_rows() > 0) //2
            {
                $this->db->where('aplFamilyID', $id);
                $delete = $this->db->delete('tbmAplFamily');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }    
/*****************************
*
* End Family
*
******************************/        

/*****************************
*
* Language
*
******************************/       
    /*
    * View language
    */    
    public function view_language($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplLanguage');        
        return $result; 
    }    
    
    /*
    * Check language
    */      
    public function check_language($id)
    {
        $this->db->select("*");
        $this->db->where('aplLanguageID', $id);
        $result = $this->db->get('tbmAplLanguage');        
        return $result;                   
    }    
    
    /*
    * Add language data 
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    */   
    function add_language($email, $language, $writing, $understanding, $speaking, $reading)
    {
        if ($email != "" && $language != "" && $writing != "" && $understanding != "" && $speaking != "" && $reading != "")
        { 
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {     
                $row = $check_person->row();            
                $this->db->set('aplPersonID', $row->AppUserListID);            
                $this->db->set('aplLanguageName', $language);
                $this->db->set('aplLanguageWriting', $writing);
                $this->db->set('aplLanguageUnderstanding', $understanding);
                $this->db->set('aplLanguageSpeaking', $speaking);
                $this->db->set('aplLanguageReading', $reading);
                $add = $this->db->insert('tbmAplLanguage');
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
    * Update couse
    * 1. Check id language
    * 2. If exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       
    function update_language($id, $email, $language, $writing, $understanding, $speaking, $reading)
    {
        if ($id != "" && $email != "" && $language != "" && $writing != "" && $understanding != "" && $speaking != "" && $reading != "")
        { 
            $check_language = $this->check_language($id); //1
            
            if ($check_language->num_rows() > 0) //2
            {
                $check_person = $this->check_idperson($email); //3
                if ($check_person->num_rows() > 0) //4
                {     
                    $person = $check_person->row();            
                    
                    $this->db->set('aplPersonID', $person->AppUserListID);             
                    $this->db->set('aplLanguageName', $language);
                    $this->db->set('aplLanguageWriting', $writing);
                    $this->db->set('aplLanguageUnderstanding', $understanding);
                    $this->db->set('aplLanguageSpeaking', $speaking);
                    $this->db->set('aplLanguageReading', $reading);
                    $this->db->where("aplLanguageID", $id);
                    $update = $this->db->update('tbmAplLanguage');
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }     
    
    /*
    * Delete course
    * 1. Check id language
    * 2. If applicant exist, we can delete data
    */     
    function delete_language($id)
    {
        if ($id != "")
        {
            $check_language= $this->check_language($id); //1
            
            if ($check_language->num_rows() > 0) //2
            {
                $this->db->where('aplLanguageID', $id);
                $delete = $this->db->delete('tbmAplLanguage');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }    
/*****************************
*
* End Language
*
******************************/    

/*****************************
*
* Organization
*
******************************/       
    /*
    * View organization
    */    
    public function view_organization($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplOrganization');        
        return $result; 
    }    
    
    /*
    * Check organization
    */      
    public function check_organization($id)
    {
        $this->db->select("*");
        $this->db->where('aplOrganizationID', $id);
        $result = $this->db->get('tbmAplOrganization');        
        return $result;                   
    }    
    
    /*
    * Add organization data 
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    */   
    function add_organization($email, $organization, $field, $start, $end, $city, $position)
    {
        if ($email != "" && $organization != "" && $field != "" && $start != "" && $end != "" && $city != "" && $position != "")
        { 
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {     
                $row = $check_person->row();            
                $this->db->set('aplPersonID', $row->AppUserListID);            
                $this->db->set('aplOrganizationName', $organization);
                $this->db->set('aplOrganizationField', $field);
                $this->db->set('aplOrganisationStartYear', $start);
                $this->db->set('aplOrganisationEndYear', $end);
                $this->db->set('aplOrganizationCity', $city);
                $this->db->set('aplOrganizationPosition', $position);
                $add = $this->db->insert('tbmAplOrganization');
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
    * Update organization
    * 1. Check id organization
    * 2. If exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       
    function update_organization($id, $email, $organization, $field, $start, $end, $city, $position)
    {
        if ($email != "" && $organization != "" && $field != "" && $start != "" && $end != "" && $city != "" && $position != "")
        { 
            $check_organization = $this->check_organization($id); //1
            
            if ($check_organization->num_rows() > 0) //2
            {
                $check_person = $this->check_idperson($email); //3
                if ($check_person->num_rows() > 0) //4
                {     
                    $person = $check_person->row();            
                    
                    $this->db->set('aplPersonID', $person->AppUserListID);             
                    $this->db->set('aplOrganizationName', $organization);
                    $this->db->set('aplOrganizationField', $field);
                    $this->db->set('aplOrganisationStartYear', $start);
                    $this->db->set('aplOrganisationEndYear', $end);
                    $this->db->set('aplOrganizationCity', $city);
                    $this->db->set('aplOrganizationPosition', $position);
                    $this->db->where("aplOrganizationID", $id);
                    $update = $this->db->update('tbmAplOrganization');
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }     
    
    /*
    * Delete organization
    * 1. Check id organization
    * 2. If applicant exist, we can delete data
    */     
    function delete_organization($id)
    {
        if ($id != "")
        {
            $check_organization = $this->check_organization($id); //1
            
            if ($check_organization->num_rows() > 0) //2
            {
                $this->db->where('aplOrganizationID', $id);
                $delete = $this->db->delete('tbmAplOrganization');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }    
/*****************************
*
* End Organization
*
******************************/    

/*****************************
*
* Publication
*
******************************/       
    /*
    * View publication
    */    
    public function view_publication($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplPublication');        
        return $result; 
    }    
    
    /*
    * Check publication
    */      
    public function check_publication($id)
    {
        $this->db->select("*");
        $this->db->where('aplPublicationID', $id);
        $result = $this->db->get('tbmAplPublication');        
        return $result;                   
    }    
    
    /*
    * Add publication data 
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    */   
    function add_publication($email, $title, $remarks)
    {
        if ($email != "" && $title!= "" && $remarks!= "")
        { 
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {     
                $row = $check_person->row();            
                $this->db->set('aplPersonID', $row->AppUserListID);            
                $this->db->set('aplPublicationTitle', $title);
                $this->db->set('aplPublicationRemarks', $remarks);
                $add = $this->db->insert('tbmAplPublication');
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
    * Update publication
    * 1. Check id publication
    * 2. If exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       
    function update_publication($id, $email, $title, $remarks)
    {
        if ($email != "" && $title != "" && $remarks != "")
        { 
            $check_publication= $this->check_publication($id); //1
            
            if ($check_publication->num_rows() > 0) //2
            {
                $check_person = $this->check_idperson($email); //3
                if ($check_person->num_rows() > 0) //4
                {     
                    $person = $check_person->row();            
                    
                    $this->db->set('aplPersonID', $person->AppUserListID);             
                    $this->db->set('aplPublicationTitle', $title);
                    $this->db->set('aplPublicationRemarks', $remarks);
                    $this->db->where("aplPublicationID", $id);
                    $update = $this->db->update('tbmAplPublication');
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }     
    
    /*
    * Delete publication
    * 1. Check id publication
    * 2. If applicant exist, we can delete data
    */     
    function delete_publication($id)
    {
        if ($id != "")
        {
            $check_publication = $this->check_publication($id); //1
            
            if ($check_publication->num_rows() > 0) //2
            {
                $this->db->where('aplPublicationID', $id);
                $delete = $this->db->delete('tbmAplPublication');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }    
/*****************************
*
* End Publication
*
******************************/                      

/*****************************
*
* Achievements
*
******************************/       
    /*
    * View achievements
    */    
    public function view_achievements($personID)
    {
        $this->db->select("*");
        $this->db->where('aplPersonID', $personID);
        $result = $this->db->get('tbmAplAchievements');        
        return $result; 
    }    
    
    /*
    * Check achievements
    */      
    public function check_achievements($id)
    {
        $this->db->select("*");
        $this->db->where('aplAchievementsID', $id);
        $result = $this->db->get('tbmAplAchievements');        
        return $result;                   
    }    
    
    /*
    * Add achievements data 
    * 1. Get ID Person
    * 2. If applicant exist, we can add data
    */   
    function add_achievements($email, $field, $remarks)
    {
        if ($email != "" && $field!= "" && $remarks!= "")
        { 
            $check_person = $this->check_idperson($email); //1
            if ($check_person->num_rows() > 0) //2
            {     
                $row = $check_person->row();            
                $this->db->set('aplPersonID', $row->AppUserListID);            
                $this->db->set('aplAchievementsField', $field);
                $this->db->set('aplAchievementsRemarks', $remarks);
                $add = $this->db->insert('tbmAplAchievements');
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
    * Update achievements
    * 1. Check id achievements
    * 2. If exist, we can continue to the next process
    * 3. Check person 
    * 4. If applicant exist, we can update data
    */       
    function update_achievements($id, $email, $field, $remarks)
    {
        if ($email != "" && $field != "" && $remarks != "")
        { 
            $check_achievements = $this->check_achievements($id); //1
            
            if ($check_achievements->num_rows() > 0) //2
            {
                $check_person = $this->check_idperson($email); //3
                if ($check_person->num_rows() > 0) //4
                {     
                    $person = $check_person->row();            
                    
                    $this->db->set('aplPersonID', $person->AppUserListID);             
                    $this->db->set('aplAchievementsField', $field);
                    $this->db->set('aplAchievementsRemarks', $remarks);
                    $this->db->where("aplAchievementsID", $id);
                    $update = $this->db->update('tbmAplAchievements');
                    if ($update)
                        return true;
                    else
                        return false;
                } else
                    return false;
            } else
                return false;
        } else
            return false;
    }     
    
    /*
    * Delete achievements
    * 1. Check id achievements
    * 2. If applicant exist, we can delete data
    */     
    function delete_achievements($id)
    {
        if ($id != "")
        {
            $check_achievements = $this->check_achievements($id); //1
            
            if ($check_achievements->num_rows() > 0) //2
            {
                $this->db->where('aplAchievementsID', $id);
                $delete = $this->db->delete('tbmAplAchievements');
                if ($delete)
                    return true;
                else
                    return false;
            } else
                return false;
        }
        else
            return false;
    }    
/*****************************
*
* End Achievements
*
******************************/    
} 