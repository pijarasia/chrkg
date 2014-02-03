<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author Gita D <gita.dwij@windowslive.com>
*
**/
class JobApply extends Admin_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('applicant/applicant_model','applicant',TRUE);
        $this->load->model('jobapply_model','jobapply',TRUE);
        $this->load->model('welcome/vacancy_model','vacancy',TRUE);

        if ($this->session->userdata('language') == "")
        {
            $this->session->set_userdata('language', "bahasa");
            $lang = "bahasa";
        }else
            $lang = $this->session->userdata('language');

        $this->lang->load('form',$lang);

		$this->load->vars(array(
			'title' => 'List of Job Applications',
			'navigation' => 'nav-candidates'
		));
    }

	public function index()
	{
		/*if (!$this->auth->logged_in())
		{
			redirect($this->config->item('base_url'), 'refresh');
		}
		else
		{
            $data["language"] = $this->session->userdata('language');

            $get_person = $this->applicant->get_person($this->session->userdata('email'))->row();
            if ($get_person->AppUserLevelLevelID == 10 || $get_person->AppUserLevelLevelID == 11) //level for internal/external candidates
            {
                $total = count($this->jobapply->get_jobapply($get_person->aplPersonID));
                $batas = 2;
                $n = ($total % $batas) == 0 ? 0:1;
                $jmlpage = (int)($total/$batas)+$n;
                $data["jmlpage"] = $jmlpage;

                $tampil  = $tmpl==''?$batas:$tmpl;
                $data["tampil"] = $tampil;

    			Assets::clear_cache();
    			//Assets::add_js( $this->load->view('js/js_apply', null, true),'inline');
    			Assets::add_js( $this->load->view('js/get_apply', null, true),'inline');
    			Assets::add_module_css('jobapply','custom.css');
    			Assets::add_css('style.css');
                Assets::add_css('custom.dialog.css');
                Assets::add_js('bootstrap.file-input.js');
        		Assets::add_js('jquery.bootpag.js');
            } else
                $data["pesan"] = lang('login_kandidat');
			Template::set($data);
			Template::render();
		}*/
            if (!$this->auth->logged_in())
            {
                redirect($this->config->item('base_url'), 'refresh');
            }

            $this->auth->_have_permission('Dashboard.JobApply.View');

            $data["language"] = $this->session->userdata('language');
            //set the flash data error message if there is one
			$data['message'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('message');

            $this->load->vars(array('title' => lang("daftar_lamar")));

			Assets::clear_cache();
			Assets::add_css('bootstrap-sortable.css');
			Assets::add_js('jquery.bootpag.js');
			Assets::add_js( $this->load->view('js/js_apply', null, true),'inline');
            Assets::add_js( $this->load->view('js/get_apply', array('total' => $this->jobapply->count_all()), true),'inline');
			Assets::add_js( $this->load->view('js/ready', array('total' => $this->jobapply->count_all()), true) , 'inline');
            Assets::add_css('custom.dialog.css'); //custom dialog style
            Assets::add_js('jquery.validate.min.js');
			if ($this->input->is_ajax_request()) {
                $get_person = $this->applicant->get_person($this->session->userdata('email'))->row();
                if ($get_person->AppUserLevelLevelID == 10 || $get_person->AppUserLevelLevelID == 11) //level for internal/external candidates
                    $this->jobapply->record($get_person->aplPersonID);
			}else {
				Template::set($data);
				Template::render();
			}
	}


	public function id()
	{
        $this->session->set_userdata('language', "bahasa");
        redirect('auth/register');
	}


	public function en()
	{
        $this->session->set_userdata('language', "english");
        redirect('auth/register');
	}

    public function tracking()
    {
        if (!$this->auth->logged_in())
        {
            redirect($this->config->item('base_url'), 'refresh');
        }
        $this->auth->_have_permission('Dashboard.JobApply.Tracking');
        $data["language"] = $this->session->userdata('language');

        $get_person = $this->applicant->get_person($this->session->userdata('email'))->row();
        if ($this->input->post("ajax")) {
            $apply = $this->input->post("apply");
            $jobOrder = $this->input->post("jobOrder");

            $tracking = $this->jobapply->tracking($apply);

            if($tracking->num_rows() > 0)
            {
                //tampung dulu yang ada
                $temp = array();
                $i = 0;
                foreach ($tracking->result() as $row)
                {
                    $temp[$i]["step"] = $row->processSelectionID;
                    $temp[$i]["date"] = $row->processDate;
                    $temp[$i]["place"] = $row->processPlace;
                    $temp[$i]["status"] = $row->StatusProcess;
                    $i++;
                }

                $row = $tracking->row();

                $vacan = $this->vacancy->details($row->joborderID);
                $row2 = $vacan->row();
                echo '<table class="table tblDalam">
                        <tr>
                            <td style="width: 200px">Perusahaan</td>
                            <td style="width: 5px">:</td>
                            <td>'.$row->companyName.'</td>
                        </tr>';
                    echo '<tr>
                            <td>Posisi</td>
                            <td>:</td>
                            <td>'.$row->joborderTitle.'</td>
                        </tr>';
                    echo '<tr>
                            <td>Periode Pembukaan Lowongan</td>
                            <td>:</td>
                            <td>'.substr(date("d M Y H:i:s", strtotime("$row2->joborderStartDate")),0,12).' s.d '.substr(date("d M Y H:i:s", strtotime("$row2->joborderEndDate")),0,12).'</td>
                        </tr>';
                    echo '<tr>
                            <td>Tanggal Lamar</td>
                            <td>:</td>
                            <td>'.date("d M Y H:i:s", strtotime("$row->applyDate")).'</td>
                        </tr>';
                echo '</table>';

                $steps =  $this->vacancy->get_all_steps($jobOrder);
                if ($steps->num_rows() > 0)
                {
                    echo "<table class='table table-hover table-bordered table-striped'>";
                        echo "<thead>
                                <tr>
                                    <th style='width: 20px;'>No</th>
                                    <th style='width: 300px;'>Proses</th>
                                    <th style='width: 150px;'>Waktu</th>
                                    <th style='width: 300px;'>Tempat</th>
                                    <th>Status</th>
                                </tr>
                            </thead>";

                    $i = 1;
                    foreach ($steps->result() as $row3)
                    {
                        $wkt = "-";
                        $tmpt = "-";
                        $stts = "-";

                        for($j = 0; $j < count($temp); $j++)
                        {
                            if ($temp[$j]["step"] == $row3->stepsID)
                            {
                                if (trim($temp[$j]["date"]) != "")
                                    $wkt = date("d M Y H:i:s", strtotime($temp[$j]['date']));

                                if (trim($temp[$j]["place"]) != "")
                                    $tmpt = $temp[$j]["place"];

                                if (trim($temp[$j]["status"]) != "")
                                    $stts = $temp[$j]["status"];
                            }
                        }
                        echo '<tr>
                                <td>'.$i.'.</td>
                                <td>'.$row3->Steps.'</td>
                                <td>'.$wkt.'</td>
                                <td>'.$tmpt.'</td>
                                <td>'.$stts.'</td>
                            </tr>';
                        $i++;
                    }
                    echo "</table>";
                }
                echo '<div style="text-align: right;">
                        <a class="btn btn-small" onclick="back()"><li class="icon-repeat"></li>&nbsp;Kembali</a>
                    </div>';

            }
        }
    }

    public function check()
    {
        if ($this->input->post('ajax'))
        {
            if ($this->session->userdata('email') != "") //if user login
            {
                $get_person = $this->applicant->get_person($this->session->userdata('email'))->row();
                if ($get_person->aplCompleteForm == 0)
                    echo "<script>
                            window.location.replace('".base_url()."applicant/form');
                        </script>";
                else
                    echo "OK";
            } else //do login
                echo "<script>
                        window.location.replace('".base_url()."auth/login');
                    </script>";
        }
    }

    public function cancel_apply()
    {
        if ($this->input->post('ajax'))
        {
            if ($this->session->userdata('email') != "") //if user login
            {
                $cek_apply = $this->vacancy->cek_apply($this->input->post('id'));
                $row = $cek_apply->row();

                $res = $this->vacancy->cancel_apply($this->input->post('id'));

                if ($res)
                {
                    $details = $this->vacancy->cek_apply($row->applyJobID);
                    $details = $details->row();

                    $direktori = dirname(dirname(dirname(__FILE__)))."\\archives\\cover_letter\\"; //window
                    //$direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archives/cover_letter/"; //linux
                    unlink($direktori.$row->applyCoverLetter);

                    $direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\archives\\curriculum_vitae\\"; //window

                    //$direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archives/curriculum_vitae/"; //linux
                    unlink($direktoriCV.$row->applyCurriculumVitae);
                    echo "Berhasil";
                }
                else
                    echo "Gagal";
            } else //do login
                echo "<script>
                        window.location.replace('".base_url()."auth/login');
                    </script>";
        }
    }
}