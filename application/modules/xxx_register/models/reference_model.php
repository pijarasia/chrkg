<?php
/**
 * @author Gita D <gita.dwij@windowslive.com>
 * 
 */
class Reference_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();        
    }
    
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
} 