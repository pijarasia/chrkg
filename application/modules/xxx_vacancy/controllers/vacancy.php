<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
* @author Gita Dwijayanti <gita.dwijayanti@hotmail.com>
*
**/
class Vacancy extends Front_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->helper('form');
        $this->load->model('vacancy_model','',TRUE);
        $this->load->model('applicant/applicant_model','',TRUE);
        $this->load->model('setting/reference_model','',TRUE);

        if ($this->session->userdata('language') == "")
        {
            $this->session->set_userdata('language', "english");
            $lang = "english";
        }else
            $lang = $this->session->userdata('language');

        $this->lang->load('form',$lang);
        $this->lang->load('validation',$lang);
    }

	public function _format_dropdown($results,$key,$value,$def = '',$caption='Please select...')
	{
		$options = $def == '' ? array('' => $caption) : array();
		foreach ($results->result_array() as $rows)
		{
			$options[$rows[$key]] = $rows[$value];
		}
//		while($rows = $results)
//		{
//			$options[$rows->$key] = $rows->$value;
//		}
		return $options;
	}

	public function index()
	{
        $data["language"] = $this->session->userdata('language');

        $total = count($this->vacancy_model->get_job());
        $n = ($total % 5) == 0 ? 0:1;
        $jmlpage = (int)($total/5)+$n;
        $data["jmlpage"] = $jmlpage;

        $tampil  = $tmpl==''?5:$tmpl;
        $data["tampil"] = $tampil;

        $data["pendidikan"] = $this->reference_model->referensi_pendidikan_utama();
        $data["bisnis"]		= $this->reference_model->referensi_area_bisnis();
        $data["tipe_kerja"] = $this->reference_model->referensi_tipe_pekerjaan();
		/* Derry :: Kota */
        $data["kota"]		= $this->reference_model->referensi_kota_ada_lowongan();
		//$data["kota"] = $this->_format_dropdown($this->reference_model->referensi_kota_ada_lowongan(),'joborderCity','joborderCity','', 'City...');

		Assets::clear_cache();
		Assets::add_js( $this->load->view('js/js_vacancy', null, true),'inline');
        Assets::add_module_css('vacancy','custom.css');
        Assets::add_css('custom.dialog.css');
        Assets::add_js('bootstrap.file-input.js');
		Assets::add_js('jquery.bootpag.js');

        Template::set($data);
		Template::render();
	}

	public function load_data()
	{
        if ($this->input->post('ajax'))
        {
            //$awal		= $this->input->post('awal')!=5?$this->input->post('awal'):5;
            //$tampil	= $this->input->post('tampil')!=0?$this->input->post('tampil'):0;

            //Derry
			//$hal		= $this->input->post("hal");
            //$tmpl		= $this->input->post("tampil");

            //$reqpage	= $hal ==''?1:$hal;
            //$tampil	= $tmpl==''?5:$tmpl;
            //$awal		= $reqpage==1?0:$tampil*($reqpage-1);
            //$total	= count($this->vacancy_model->get_job());
            //$n		=($total % $tampil)==0 ? 0:1;
            //$jmlpage	= (int)($total/$tampil)+$n;

            $job = $this->vacancy_model->get_job($awal, $tampil);

            if (count($job) > 0)
            {
                echo '<input type="hidden" name="total" id="total" value="'.$jmlpage.'"/>';
                echo '<table class="table table-hover" id="tableJob">';
                echo '<tr class="tebal" style="background-color: #e6e6e6;">';
				echo '<td colspan=2>#</td><td>Job Title</td><td>Location</td><td>Employment Type</td><td>Bussiness Area</td>';
				echo '</tr>';

				/*
                foreach ($job as $row)
                {
                    // - <span style="color: #aaa;">'.$row->joborderCity.', '.$row->joborderState.'</span>
                    echo '<tr>
                            <td onclick="vacancyDetails(\''.$row->joborderID.'\')" style="cursor: pointer;">
                                <table class="tblDalam">
                                    <tr>
                                        <td rowspan="3">
                                            <img src="'.base_url().'public/assets/images/company_logo/'.$row->companyLogo.'" width="80"/>
                                        </td>
                                        <td><span class="tebal">'.$row->companyName.'</span></td>
                                    </tr>
                                    <tr>
                                        <td>'.$row->joborderTitle.' - <i class="icon-time"></i> ';
                                    if ($row->RemainingTime == 0 || $row->RemainingTime == "")
                                    {
                                        echo 'Hari ini';
                                    } else {
                                        echo $row->RemainingTime." ".lang('hari_lagi');
                                    }
                                    echo "</td>
                                    </tr>
                                    <tr>
                                        <td>
                                            Job Type: ".ucwords($row->EmploymentType)."
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>";
                }
				*/
				$x = 1;
                foreach ($job as $row)
                {
					if ($row->RemainingTime == 0 || $row->RemainingTime == "")
					{
						$sisa_waktu = 'Hari ini';
					} else {
						$sisa_waktu = $row->RemainingTime." ".lang('hari_lagi');
					}
                    echo '<tr>
                            <td>
								<input type="checkbox" name="joborderApplyList[]" value='.$row->joborderID.'>
                            </td>
							<td>'.$x.'</td>
                            <td onclick="vacancyDetails(\''.$row->joborderID.'\')" style="cursor: pointer;">
							'.$row->joborderTitle.'<br><font size=1><i>'.$sisa_waktu.'</i></font>
							</td>
							<td>
							'.$row->joborderCity.'
							</td>
							<td>
							'.ucwords($row->EmploymentType).'
							</td>
							<td>
							'.ucwords($row->BusinessArea).'
							</td>
                        </tr>';
						$x++;
                }
                echo '<tr><td colspan="6"  style="background-color: #e6e6e6;">&nbsp;</td></tr>';
				echo '</table>';
            }else{
				echo '<p id="form_notice" style="color:gray; line-height:10px;margin-top:20px;">'.lang('form_param_too_tight').'</p>';
			}
        }
	}

	public function id()
	{
        $this->session->set_userdata('language', "bahasa");
        redirect('register');
	}


	public function en()
	{
        $this->session->set_userdata('language', "english");
        redirect('register');
	}

    public function details()
    {
        $data["language"] = $this->session->userdata('language');
		$data["en"] = base_url()."register/en";
		$data["id"] = base_url()."register/id";

		$id = $this->uri->segment(3);

        $data["details"] = $this->vacancy_model->details($id);


		if($this->session->userdata('email') != ""){
            $get_person = $this->applicant_model->get_person($this->session->userdata('email'))->row();
            $cek_apply = $this->vacancy_model->cek_apply_vacancy($get_person->aplPersonID, $id)->row();
            $data["cek_apply"] = $cek_apply;
		}

        $cek_person_apply = $this->vacancy_model->cek_person_apply($id)->row();
        $data["cek_person_apply"] = $cek_person_apply;

        //remove vacancy
        $this->session->set_userdata('vacancy', "");

		Assets::clear_cache();
		Assets::add_js( $this->load->view('js/js_vacancy', null, true),'inline');
        Assets::add_module_css('vacancy','custom.css');
        Assets::add_css('custom.dialog.css');
        Assets::add_js('bootstrap.file-input.js');

		Template::set($data);
		Template::render();
    }

    public function check()
    {
        if ($this->input->post('ajax'))
        {
            $this->session->set_userdata('vacancy', $this->input->post('id'));
            if ($this->session->userdata('email') != "") //if user login
            {
                $this->load->model('applicant/applicant_model','',TRUE);
                $get_person = $this->applicant_model->get_person($this->session->userdata('email'))->row();
                if ($get_person->aplCompleteForm == 0)
                    echo "<script>
                            window.location.replace('".base_url()."applicant/form');
                        </script>";
                else
                    echo "OK";
            } else //do login
                echo "<script>
                        window.location.replace('".base_url()."register');
                    </script>";
        }
    }

    public function apply()
    {
        if ($this->session->userdata('email') != "") //if user login
        {
            $appl = $this->applicant_model->get_person($this->session->userdata('email')); //1
            if ($appl->num_rows() > 0) //2
            {
                $row = $appl->row();

                if (!empty($_FILES['fileCoverLetter']) && !empty($_FILES['fileCV']))
                {
                    $tempFile = $_FILES['fileCoverLetter']['tmp_name'];
                    $fileSize = $_FILES['fileCoverLetter']['size'];

                    $tempFileCV = $_FILES['fileCV']['tmp_name'];
                    $fileSizeCV = $_FILES['fileCV']['size'];

					/*Derry :: $fileSize <= 200000 di ubah jadi 500000*/
                    if ($fileSize <= 200000)
                	{

                        $fileTypes = array("pdf", "doc", "docx"); // File extensions

                        $fileParts = pathinfo($_FILES['fileCoverLetter']['name']);

                        $filePartsCV = pathinfo($_FILES['fileCV']['name']);

                        //$direktori   = "D:\\Xampp\\htdocs\\career\\archives\\cover_letter\\"; //window
						//$direktoriCV = "D:\\Xampp\\htdocs\\career\\archives\\curriculum_vitae\\"; //window

                        //JANGAN DIGANTI LAGI! -Gita 9 Okt 2013-
                        $direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\archives\\cover_letter\\"; //window
						$direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\archives\\curriculum_vitae\\"; //window

                        //$direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archives/cover_letter"; //linux
                        //$direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archives/curriculum_vitae"; //linux

                        //$fileName = $_FILES['fileCoverLetter']['name'];
                        $fileName = "CL".$row->aplPersonID."_".$this->input->post('hiddenID').date("YmdHis", strtotime("now")).".".strtolower($fileParts['extension']);
                        $fileNameCV = "CV".$row->aplPersonID."_".$this->input->post('hiddenID').date("YmdHis", strtotime("now")).".".strtolower($filePartsCV['extension']);

                        $sourceFile = $direktori."/".$fileName;
                        $sourceFileCV = $direktoriCV."/".$fileNameCV;

                       	if (in_array(strtolower($fileParts['extension']), $fileTypes) && in_array(strtolower($filePartsCV['extension']), $fileTypes))
                        { //cek ekstensi file
                            $up = move_uploaded_file($tempFile, $sourceFile);
                            $upCV = move_uploaded_file($tempFileCV, $sourceFileCV);
                            if ($up && $upCV)
                            {
                                $res = $this->vacancy_model->apply($row->aplPersonID, $this->input->post('hiddenID'), $fileName, $fileNameCV);

                                //$cek_apply = $this->vacancy_model->cek_apply_vacancy($row->aplPersonID, $this->input->post('id'));
                                //$row2 = $cek_apply->row();
                                if ($res)
                                    echo "OK";
                                    //echo '<a class="btn btn-info 1" id="cancelApply" onclick="cancelApply(\''.$row2->applyID.'\')"><li class="icon-remove icon-white"></li>&nbsp;'.lang('batal').' '.lang('lamar').'</a>';
                                else {
                                    $cekApply2 = $this->vacancy_model->cek_apply_vacancy($row->aplPersonID, $this->input->post('hiddenID'));
                                    if ($cekApply2->num_rows() > 0){
                                        $row = $cekApply2->row();
                                        $this->vacancy_model->cancel_apply($row->applyID);

                                        $direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\archives\\cover_letter\\"; //window
                                        //$direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archieve/cover_letter/"; //linux
                                        unlink($direktori.$row->applyCoverLetter);

                                        $direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\archives\\curriculum_vitae\\"; //window
                                        //window
										//$direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archieve/curriculum_vitae/"; //linux
                                        unlink($direktoriCV.$row->applyCurriculumVitae);

                                        /*echo "<script>
                                                window.location.href = '".base_url()."/jobapply';
                                            </script>";*/
                                    }
                                    echo "Gagal memasukan lamaran";
                                    //echo '<a class="btn btn-info 1" id="confirmApply" onclick="confirmApply(\''.$row2->applyID.'\')"><li class="icon-hdd icon-white"></li>&nbsp;&nbsp;'.lang('lamar').'</a>';
                                }
                            }
                            else
                                echo 'File gagal diunggah.';
                            //chdir(dirname(dirname(dirname(dirname(dirname(__FILE__)))))); //kembali ke folder awal*/
                        } else {
                        	echo 'Ketentuan tipe file adalah .pdf atau .doc atau .docx';
                        }
                    }
                    else
                	{
					/* Derry :: kita tambahkan jadi maks 500kb */
                	   /*echo "File terlalu besar, maksimal 200Kb";*/
                	   echo "Ukuran total kedua File anda terlalu besar, maksimal 500Kb.";

                	}
                }
                else
                {
                    echo "File tidak boleh kosong";
                }
            } else
                echo "<script>
                        window.location.replace('".base_url()."register');
                    </script>";
        } else { //do login
            $this->session->set_userdata('vacancy', $this->input->post('hiddenID'));
            //echo "Login";
                echo "<script>
                        window.location.replace('".base_url()."login');
                    </script>";
        }
    }

    public function load_apply()
    {
        if ($this->input->post('ajax'))
        {
            if ($this->session->userdata('email') != "") //if user login
            {
                $appl = $this->applicant_model->get_person($this->session->userdata('email')); //1
                if ($appl->num_rows() > 0) //2
                {
                    $row = $appl->row();
                    $cek_apply = $this->vacancy_model->cek_apply_vacancy($row->aplPersonID, $this->input->post('id'));
                    $row2 = $cek_apply->row();

                    $details = $this->vacancy_model->details($this->input->post('id'));
                    $details = $details->row();
                    if ($this->input->post('content') == "OK")
                        echo '<a class="btn btn-info 1" id="cancelApply" onclick="cancelApply(\''.$row2->applyID.'\')"><li class="icon-remove icon-white"></li>&nbsp;'.lang('batal').' '.lang('lamar').'</a>
                             <a class="btn btn-info 1" id="listlApply" onclick="listApply(\''.$row2->applyID.'\')"><li class="icon-list-alt icon-white"></li>&nbsp;'.lang('listjob').'</a>';
                    else
                    {
                        if ($details->RemainingTime >= 0)
                            echo '<a class="btn btn-info 1" id="confirmApply" onclick="confirmApply(\''.$row2->applyID.'\')"><li class="icon-hdd icon-white"></li>&nbsp;&nbsp;'.lang('lamar').'</a>';
                    }
                }
            }
        }
    }

    public function cancel_apply()
    {
        if ($this->input->post('ajax'))
        {
            if ($this->session->userdata('email') != "") //if user login
            {
                $cek_apply = $this->vacancy_model->cek_apply($this->input->post('id'));
                $row = $cek_apply->row();

                $res = $this->vacancy_model->cancel_apply($this->input->post('id'));
                echo $res;
                /*if ($res)
                {
                    $details = $this->vacancy_model->details($row->applyJobID);
                    $details = $details->row();

                    if ($details->RemainingTime >= 0)
                        echo '<a class="btn btn-info 2" id="confirmApply" onclick="confirmApply(\''.$row->applyID.'\')"><li class="icon-hdd icon-white"></li>&nbsp;&nbsp;'.lang('lamar').'</a>';

                    $direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\archives\\cover_letter\\"; //window
                    //$direktori = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archieve/cover_letter/"; //linux
                    unlink($direktori.$row->applyCoverLetter);

					$direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."\\archives\\curriculum_vitae\\"; //window
                    //$direktoriCV = dirname(dirname(dirname(dirname(dirname(__FILE__)))))."/archives/curriculum_vitae/"; //linux
                    unlink($direktoriCV.$row->applyCurriculumVitae);
                }
                else
                    echo '<a class="btn btn-info 2" id="cancelApply" onclick="cancelApply(\''.$row->applyID.'\')"><li class="icon-remove icon-white"></li>&nbsp;'.lang('batal').' '.lang('lamar').'</a>
                        <a class="btn btn-info" id="listlApply" onclick="listApply()"><li class="icon-list-alt icon-white"></li>&nbsp;'.lang('listjob').'</a>';*/
            } else //do login
                echo "<script>
                        window.location.replace('".base_url()."register');
                    </script>";
        }
    }

    public function load_person()
    {
        $cek_person_apply = $this->vacancy_model->cek_person_apply($this->input->post('id'))->row();
        if ($cek_person_apply->Jml > 0)
            echo '- <i class="icon-user"></i> '.$cek_person_apply->Jml.' '.lang('telah_melamar');
        else
            echo "";
    }
}