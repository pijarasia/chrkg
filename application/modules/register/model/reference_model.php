<?php
/**
 * @author Gita D
 */
class Reference_Model extends CI_Model
{

    function referensi_agama()
    {
        $query = $this->db->get('tbrReligion');
        return $query;
    }

    function referensi_golDarah()
    {
        $query = $this->db->get('tbrBloodType');
        return $query;
    }

    function referensi_marital()
    {
        $query = $this->db->get('tbrMaritalStatus');
        return $query;
    }

    function referensi_negara()
    {
        $this->db->order_by("CountryName");
        $query = $this->db->get('tbrCountry');
        return $query;
    }

    function referensi_provinsi()
    {
        $query = $this->db->get('tbrProvince');
        return $query;
    }

    function referensi_jenjang_pendidikan()
    {
        $query = $this->db->get('tbrEducationLevel');
        return $query;
    }

    function referensi_pendidikan_utama()
    {
        $this->db->where("EducationLevelCategory", "College");
        $query = $this->db->get('tbrEducationLevel');
        return $query;
    }

    function referensi_tanda_pengenal()
    {
        $query = $this->db->get('tbrIdentityCard');
        return $query;
    }

    function referensi_bulan()
    {
        $query = $this->db->get('tbrMonth');
        return $query;
    }

    function referensi_nilai_bahasa()
    {
        $query = $this->db->get('tbrAplLanguageLiteracy');
        return $query;
    }

    function referensi_area_bisnis()
    {
        $query = $this->db->get('tbrBusinessArea');
        return $query;
    }

    function referensi_tipe_pekerjaan()
    {
        $query = $this->db->get('tbrEmploymentType');
        return $query;
    }

    function referensi_group()
    {
        $this->db->order_by("AppLevelListLevelName");
        $query = $this->db->get('tbaAppLevelList');
        return $query;
    }
        function referensi_jobprocess_status()
    {
        $query = $this->db->get('tbrJobProcessStatus');
        return $query;
    }

    function referensi_jobprocess_flow()
    {
        $query = $this->db->get('tbrJobProcessFlow');
        return $query;
    }

    function referensi_employment_type()
    {
        $query = $this->db->get('tbrEmploymentType');
        return $query;
    }

    function referensi_selection_step()
    {
        $query = $this->db->get('tbrSelectionSteps');
        return $query;
    }

    function referensi_business_area()
    {
        $query = $this->db->get('tbrBusinessArea');
        return $query;
    }

    function referensi_company()
    {
        $query = $this->db->get('tbmCompany');
        //$this->db->order_by("companyName");
        return $query;
    }
    function referensi_redirect()
    {
        $query = $this->db->get('tbaAppWebRedirect');
        return $query;
    }

    function referensi_group_candidate()
    {
        $this->db->where("AppLevelListLevelID = 'internal_candidate' or AppLevelListLevelID = 'external_candidate'");
        $this->db->order_by("AppLevelListLevelName");
        $query = $this->db->get('tbaAppLevelList');
        return $query;
    }

	/* :: Derry :: Get Available City*/
	public function referensi_kota_ada_lowongan()
	{
        $query = $this->db->get('vJobsAvailableAtCities');
        return $query;
	}

    public function referensi_location()
    {
        $this->db->order_by("Location");
        $query = $this->db->get('tbmLocation');
        return $query;
    }

    public function referensi_cost()
    {
        $this->db->order_by("CostCenterName");
        $query = $this->db->get('tbrCostCenter');
        return $query;
    }

    public function referensi_nationality()
    {
        $this->db->order_by("NationalityName");
        $query = $this->db->get('tbrNationality');
        return $query;
    }

    public function referensi_candidate_source()
    {
        $this->db->order_by("CandidateSourcesID");
        $query = $this->db->get('tbmCandidateSources');
        return $query;
    }

    public function referensi_candidate_sources()
    {
        $this->db->order_by("CandidateSourcesName");
        $query = $this->db->get('tbmCandidateSources');
        return $query;
    }
}