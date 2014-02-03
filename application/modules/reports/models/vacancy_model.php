<?php
/**
 * @author Gita Dwijayanti <gita.dwijayanti@hotmail.com>
 * @lastedit 16 July, 2013
 */
class Vacancy_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    /**
    * View All Job
    */
    public function get_job($awal=null, $tampil=null)
    {
        $this->db->select("*, DATEDIFF(d, GETDATE(), DATEADD(DAY, DATEDIFF(D, joborderStartDate, joborderEndDate)+DATEDIFF(M, joborderStartDate, joborderEndDate)+DATEDIFF(YY, joborderStartDate, joborderEndDate), joborderStartDate)) AS RemainingTime");
        //$this->db->where("GETDATE() between joborderStartDate and DATEADD(DAY, joborderDuration, cast(convert(char(8), joborderStartDate, 112) + ' 23:59:59.99' as datetime))");
        $this->db->where("GETDATE() between joborderStartDate and DATEADD(DAY, DATEDIFF(D, joborderStartDate, joborderEndDate)+DATEDIFF(M, joborderStartDate, joborderEndDate), cast(convert(char(8), joborderStartDate, 112) + ' 23:59:59.99' as datetime))");
        $this->db->where("(joborderTitle like '%".$_POST['cari']."%' or companyName like '%".$_POST['cari']."%')");
        //$this->db->like("joborderLevelEducationMinID", $_POST["jenjang"]);
        if (!empty($_POST["tipe_kerja"]))
            $this->db->like("joborderType", $_POST["tipe_kerja"]);
        if (!empty($_POST["bisnis"]))
            $this->db->like("companyBusinessArea", $_POST["bisnis"]);
        $this->db->like("joborderCity", $_POST["kota"]);
        //$this->db->join("tbmCompanyDepartment", "tbmCompanyDepartment.companyDepartmentID = tbmJoborder.joborderCompanyDepartmentID");
        //$this->db->join("tbmCompany", "tbmCompanyDepartment.companyDepartmentCompanyID = tbmCompany.companyID");
        $this->db->join("tbmCompany", "tbmCompany.companyID = tbmJoborder.jobOrderCompanyID");
        $this->db->join("tbrEmploymentType", "tbrEmploymentType.EmploymentTypeID = tbmJoborder.joborderType","LEFT");
        $this->db->join("tbrBusinessArea", "tbrBusinessArea.BusinessID = tbmCompany.companyBusinessArea");
        $query = $this->db->get('tbmJoborder');

        /*foreach($result->result() as $row2 ){
            //lihat di selection steps
            $this->db->where("stepsJobID", $row2->joborderID);
            $cek_selection = $this->db->get('tbtSelectionSteps');
            if ($cek_selection->num_rows() > 0)
                $result2[] = $result;
        }*/

        $i=0;
		$end  = ($awal === null ? null : $awal + $tampil);   //5 //10
        foreach($query->result() as $row ){
            //lihat di selection steps
            $this->db->where("stepsJobID", $row->joborderID);
            $cek_selection = $this->db->get('tbtSelectionSteps');
            if ($cek_selection->num_rows() > 0)
            {
                if ($awal == null && $end == null) {
                    $result[] = $row;
                } else {
                    if($i >= $awal && $i < $end) { //i>0 && i<5 //i>=5 &&  i<10
                        $result[] = $row;
                    }
                    $i++;
                }
            }
        }
        if(count($result) == 1 && !is_null($start) && $rows < 2) {
			$result = $result[0];
		}

        return $result;
    }

    /**
    * View Detail Vacancy
    */
    public function details($jobID)
    {
        $this->db->select("*, DATEDIFF(d, GETDATE(), DATEADD(DAY, DATEDIFF(D, joborderStartDate, joborderEndDate)+DATEDIFF(M, joborderStartDate, joborderEndDate)+DATEDIFF(YY, joborderStartDate, joborderEndDate), joborderStartDate)) AS RemainingTime");
        // $this->db->select("*, DATEDIFF(d, GETDATE(), DATEADD(DAY, joborderDuration, joborderStartDate)) AS RemainingTime, DATEADD(DAY, joborderDuration, cast(convert(char(8), joborderStartDate, 112) + ' 23:59:59.99' as datetime)) as joborderEndDate");
        $this->db->where("joborderID = '".$jobID."'");
        $this->db->join("tbtJobApply", "tbtJobApply.applyJobID = tbmJoborder.joborderID", "left");
        //$this->db->join("tbmCompanyDepartment", "tbmCompanyDepartment.companyDepartmentID = tbmJoborder.joborderCompanyDepartmentID");
        //$this->db->join("tbmCompany", "tbmCompanyDepartment.companyDepartmentCompanyID = tbmCompany.companyID");
        $this->db->join("tbmCompany", "tbmCompany.companyID = tbmJoborder.jobOrderCompanyID");
        $this->db->join("tbrEmploymentType", "tbrEmploymentType.EmploymentTypeID = tbmJoborder.joborderType");
        $result = $this->db->get('tbmJoborder');
        return $result;
    }

    function cek_apply($idApply)
    {
        $this->db->select("*");
        $this->db->where("applyID", $idApply);
        $result = $this->db->get('tbtJobApply');
        return $result;

    }

    function cek_apply_vacancy($applicantID, $jobID)
    {
        $this->db->select("*");
        $this->db->where("applyApplicantID", $applicantID);
        $this->db->where("applyJobID", $jobID);
        $result = $this->db->get('tbtJobApply');
        return $result;

    }

    /**
    * Apply Vacancy
    */
    function apply($applicantID, $id, $coverLetter, $cv)
    {
        if ($applicantID != "" && $id != "" && $coverLetter != "")
        {
            $cekApply = $this->cek_apply_vacancy($applicantID, $id);
            if ($cekApply->num_rows() == 0)
            {
                $this->db->set('applyJobID', $id);
                $this->db->set('applyApplicantID', $applicantID);
                $this->db->set('applyCoverLetter', $coverLetter);
                $this->db->set('applyCurriculumVitae', $cv);
                $this->db->set('applyDate', date('Y-m-d H:i:s', strtotime('now')));
                $add = $this->db->insert('tbtJobApply');
                if ($add)
                {
                    $process = $this->process_apply($applicantID, $id);
                    if ($process)
                        return true;
                    else //jika gagal, batalkan
                    {
                        //Cari ID
                        $this->db->select("applyID");
                        $this->db->where("applyJobID", $id);
                        $this->db->where("applyApplicantID", $applicantID);
                        $get = $this->db->get('tbtJobApply');
                        $row = $get->row();
                        $this->cancel_apply($row->applyID);
                        return false;
                    }
                } else
                    return false;
            } else {
                $this->db->set('applyCoverLetter', $coverLetter);
                $this->db->set('applyCurriculumVitae', $cv);
                $this->db->set('applyDate', date('Y-m-d H:i:s', strtotime('now')));
                $this->db->set("applyCancel", 0);
                $this->db->set("applyCancelDate", NULL);
                $this->db->where('applyJobID', $id);
                $this->db->where('applyApplicantID', $applicantID);
                $update = $this->db->update('tbtJobApply');
                if ($update)
                    return true;
                else
                    return false;
            }
        } else
            return false;
    }


    /**
    * Cancel Apply
    */
    function cancel_apply($jobApplyID)
    {
        if ($jobApplyID != "")
        {
            $cekApply = $this->cek_apply($jobApplyID);
            if ($cekApply->num_rows() > 0)
            {
                $cekProcessApply = $this->cek_process_apply($jobApplyID);
                if ($cekProcessApply->num_rows() > 0)
                {
                    $processApply = $cekProcessApply->row();
                    //jika steps = seleksi CV dan status proses = belum diproses, maka dapat dilakukan penghapusan
                    if ($processApply->stepsSelectionID == 1 && $processApply->processStatus == 1)
                    {
                        $this->db->where('applyID', $jobApplyID);
                        $delete = $this->db->delete('tbtJobApply');
                        if ($delete)
                        {
                            $cancel_process = $this->cancel_process($jobApplyID);
                            if($cancel_process)
                                return true;
                            else
                                return "false1";
                        } else
                            return "false2";
                    } else { //jika selain diatas, maka hanya diberi flag pembatalan
                        $this->db->set('applyCancel', 1);
                        $this->db->set('applyCancelDate', date('Y-m-d H:i:s', strtotime('now')));
                        $this->db->where('applyID', $jobApplyID);
                        $update_process = $this->db->update('tbtJobApply');

                        if($update_process)
                            return true;
                        else
                            return "false3";
                    }
                }else
                    return "false4";
            }else
                return "false5";
        } else
            return "false6";
    }

    /**
    * Check person apply
    */
    function cek_person_apply($idJob)
    {
        $this->db->select("count(*) as Jml");
        $this->db->where("applyJobID", $idJob);
        $result = $this->db->get('tbtJobApply');
        return $result;
    }

    /**
     * Get All Selection Steps -- sementara disini
     */
    function get_all_steps($id)
    {
        $this->db->where("StepsJobID", $id);
        $this->db->join("tbrSelectionSteps", "tbrSelectionSteps.IDSteps = tbtSelectionSteps.stepsSelectionID");
        $result = $this->db->get('tbtSelectionSteps');
        return $result;
    }

    /**
     * Get Selection Steps -- sementara disini
     */
    function get_steps($id, $steps)
    {
        $this->db->where("StepsJobID", $id);
        $this->db->where("stepsOrder", $steps);
        $this->db->join("tbrSelectionSteps", "tbrSelectionSteps.IDSteps = tbtSelectionSteps.stepsSelectionID");
        $result = $this->db->get('tbtSelectionSteps');
        return $result;
    }

    /**
     * Cek process apply
     */
    function cek_process_apply($applyID)
    {
        $this->db->select("TOP 1 *");
        $this->db->join("tbtSelectionSteps", "tbtJobProcessApply.processSelectionID = tbtSelectionSteps.stepsID");
        $this->db->where("processApplyID", $applyID);
        $this->db->order_by("processID", "desc");
        $result = $this->db->get('tbtJobProcessApply');
        return $result;
    }

    /**
     * Cek process apply step CV
     */
    function cek_process_apply_stepcv($cek)
    {
        $this->db->select("TOP 1 *");
        $this->db->join("tbtSelectionSteps", "tbtJobProcessApply.processSelectionID = tbtSelectionSteps.stepsID");
        $this->db->join("tbtJobApply", "tbtJobProcessApply.processApplyID = tbtJobApply.applyID");
        $this->db->join("tbaAppUserList", "tbaAppUserList.AppUserListID = tbtJobApply.applyApplicantID");
        $this->db->where("AppUserListEmail", $cek);
        //stepsSelectionID = seleksi cv dan processStatus = lulus atau stepsSelectionID selain seleksi cv dan processStatus = lulus
        $this->db->where("(stepsSelectionID = 1 and processStatus = 3) or (stepsSelectionID != 1 and processStatus = 3)");
        $this->db->order_by("processID", "desc");
        $result = $this->db->get('tbtJobProcessApply');
        return $result;
    }

    /**
     * Process Apply
     */
    function process_apply($applicantID, $id)
    {
        if ($applicantID != "" && $id != "")
        {
            $cekApply = $this->cek_apply_vacancy($applicantID, $id);
            if ($cekApply->num_rows() > 0)
            {
                $row = $cekApply->row();
                $step = $this->get_steps($id, 1);
                if ($step->num_rows() > 0)
                {
                    $rowStep = $step->row();
                    $this->db->set('processApplyID', $row->applyID);
                    $this->db->set('processSelectionID', $rowStep->stepsID);
                    $this->db->set('processStatus', 1); //1 = Belum Diproses
                    $add = $this->db->insert('tbtJobProcessApply');
                    if ($add)
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

    /**
     * Cancel Process
     */
    function cancel_process($applyID)
    {
        if ($applyID != "")
        {
            $this->db->where('processApplyID', $applyID);
            $delete = $this->db->delete('tbtJobProcessApply');
            if ($delete)
                return true;
            else
                return false;
        } else
            return false;
    }
}