<?php
/**
 * @author Gita D <gita.dwij@windowslive.com>
 * @author Trisna Gelar A <balaplumpat@@gmail.com> @mang_gibenk
 */
class Register_Model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    public function dynamic_filter($param, $value, $tabel)
    {
        $this->db->where($param, $value);
        $result = $this->db->get($tabel);
        return $result;
    }

    /*
    * Filter person by identity number, email and celular
    * So there are no double applicant
    */
    public function filter_person($email, $cellular){
        $check_email = $this->dynamic_filter("AppUserListEmail", $email, "tbaAppUserList"); //2
		if ($check_email->num_rows() > 0)
            return false;
        else
        {
	        $check_al_email = $this->dynamic_filter("aplAlternateEmail", $email, "tbmApplicant"); //4
            if ($check_al_email->num_rows() > 0)
                return false;
            else
            {
				$check_cellular = $this->dynamic_filter("AppUserListPhone", $cellular, "tbaAppUserList"); //6
                if ($check_cellular->num_rows() > 0)
                    return false;
                else
                {
                    $check_al_cellular = $this->dynamic_filter("aplAlternateCellular", $cellular, "tbmApplicant"); //7
                    if ($check_al_cellular->num_rows() > 0)
                        return false;
                    else
                        return true;
                }
            }
        }
    }

    public function login_as(){
        $this->load->library('session');
        $this->load->model('setting/reference_model','reference',TRUE);

        $result = array();
        $input = array('ulid', 'id', 'name', 'refid','costid');
        foreach ($input as $val)
            $data[$val] = $this->input->post($val);

        $groups = $this->translate_group($this->reference->referensi_group());
        $redirects = $this->translate_redirect($this->reference->referensi_redirect());

        $session_data = array(
            'group_active'             => $data['name'],
            'xyz'           => $groups[$data['name']],
            'costid'             => $data['costid'],
            'refid'             => $data['refid'],
        );
        $this->session->set_userdata($session_data);

        $result['redirect'] = $redirects[$groups[$data['name']]];
        echo json_encode($result, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);

    }

    public function register($id, $name, $subscribe)
    {
        if ($name != "")
        {
            $this->db->set('aplPersonID', $id);
            $this->db->set('aplSubscribe', $subscribe);
            $this->db->set('aplDateRegister', date('Y-m-d H:i:s'));
            $this->db->set('aplCompleteForm', 0);
            $add = $this->db->insert('tbmApplicant');
            if ($add)
                return true;
            else
                return false;
        } else
            return false;
    }

    public function explode_name($name)
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
    }

/**
 * Verification code by Scott
 ***/
    public function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 0)
            return $min; // not so random...
        $log = log($range, 2);
        $bytes = (int) ($log / 8) + 1; // length in bytes
        $bits = (int) $log + 1; // length in bits
        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd >= $range);
        return $min + $rnd;
    }

    public function getToken($length){
        $token = "";
        $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet.= "abcdefghijklmnopqrstuvwxyz";
        $codeAlphabet.= "0123456789";
        for($i=0;$i<$length;$i++){
            $token .= $codeAlphabet[$this->crypto_rand_secure(0,strlen($codeAlphabet))];
        }
        return $token;
    }

    public function checkToken($token)
    {
        $check = $this->dynamic_filter("AppUserListActivationCode", $token, "tbaAppUserList");
        if ($check->num_rows() > 0)
            return false;
        else
            return true;
    }

    public function translate_group($group, $result = array()){
        $query = $group->result_array();
        foreach ($query as $rows) {
            $result[$rows['AppLevelListLevelID']] = $rows['AppLevelListID'];
        }
        return $result;
    }

    public function translate_company($company, $result = array()){
        $query = $company->result_array();
        foreach ($query as $rows) {
            $result[$rows['companyID']] = $rows['companyName'];
        }
        return $result;
     }

    public function translate_cost($cost, $result = array()){
        $query = $cost->result_array();
        foreach ($query as $rows) {
            $result[$rows['CostCenterID']] = $rows['CostCenterName'];
        }
        return $result;
    }

    public function translate_redirect($redirect, $result = array()){
        $query = $redirect->result_array();
        foreach ($query as $rows) {
            $result[$rows['AppWebRedirectLevelID']] = $rows['AppWebRedirectTargetID'];
        }
        return $result;
     }

	public function check_email($group, $subject)
	{
        $this->db->where("EmailTmplGroup = '".$group."' and EmailTmplSubject = '".$subject."'");
        $result = $this->db->get("tbrEmailTemplate");
        return $result;
	}

    public function get_old_password($email)
    {
        $query = $this->db->select('AppUserListID, AppUserListPassword, AppUserListSalt')
                        ->where('AppUserListEmail', $email)
		                ->get("tbaAppUserList");
        return $query;
    }
}