<div class='content-inner well' style="padding: 10px;min-height: 530px;">
    <?php echo $pesan!=""?"<div style='text-align:center;color:blue;border:1px solid #ddd;padding: 20px 10px;margin:40px;'>".$pesan."</div>":"";?>

    <?php
        if ($pesan == "")
        {
    ?>
    <div id="firstwizard" style="margin-top: 10px;">
        <div class="row">
            <div class="span12">
                <!--<div style="border: 1px solid #eee;">-->
                <div class="tab-content">
                    <form name="form_data" id="form_data"  method="get" action="">
                        <ul>
                            <li id="data_diri"><a href="#tab1" data-toggle="tab"><span class="label">1</span> <?php echo lang('data_diri')?></a></li>
                            <li id="data_pendidikan"><a href="#tab2" data-toggle="tab"><span class="label">2</span> <?php echo lang('pendidikan_terakhir')?></a></li>
                			<li id="data_pelatihan"><a href="#tab3" data-toggle="tab"><span class="label">3</span> <?php echo lang('non_pendidikan')?></a></li>
                            <li id="data_pengalaman"><a href="#tab4" data-toggle="tab"><span class="label">4</span> <?php echo lang('pengalaman_kerja')?></a></li>
                			<li id="data_lain"><a href="#tab5" data-toggle="tab"><span class="label">5</span> <?php echo lang('form_lain')?></a></li>
    					</ul>
    					<div class="tab-content">
    					    <div class="tab-pane" id="tab1" class="form-vertical" style="padding: 15px;"> <!--Data Diri-->
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="nama"><?php echo lang('nama_lengkap')?> </label>
                                            <div class="controls">
                                                <input type="text" name="nama" id="nama" placeholder="<?php echo lang('nama_lengkap')?>" class="input-xlarge padd5AB" value="<?php echo $aplName; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="jk"><?php echo lang('jk')?> </label>
                                            <div class="controls">
                                                <label class="radio inline padd5AB">
                                                    <input type="radio" name="jk" id="jkl" value="L" <?php echo $aplSex=="L"?"checked='checked'":""; ?>/>
                                                    <?php echo lang('pria')?>
                                                </label>
                                                <label class="radio inline padd5AB">
                                                    <input type="radio" name="jk" id="jkp" value="P" <?php echo $aplSex=="P"?"checked='checked'":""; ?>/>
                                                    <?php echo lang('wanita')?>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="tmpt_lahir"><?php echo lang('tmpt_lahir')?> </label>
                                            <div class="controls">
                                                <input type="text" name="tmptlahir" id="tmptlahir" placeholder="<?php echo lang('tmpt_lahir')?>" class="input-large padd5AB" value="<?php echo $aplPlaceOfBirth; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="tgl_lahir"><?php echo lang('tgl_lahir')?> </label>
                                            <div class="controls">
                                                <select name="tanggal" id="tanggal" style="width: 100px;">
                                                    <option value=""><?php echo lang('tanggal')?></option>
                                                    <?php
                                                        $tgl = 1;
                                                        for($tgl == 1; $tgl <= 31; $tgl++)
                                                        {
                                                            if ($aplDateOfBirth != "")
                                                                $date = date('d', strtotime($aplDateOfBirth));
                                                            else
                                                                $date = "";
                                                            if ($date == $tgl)
                                                                $selected = "selected";
                                                            else
                                                                $selected = "";
                                                            echo '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <select name="bulan" id="bulan" style="width: 110px;">
                                                    <option value=""><?php echo lang('bulan')?></option>
                                                    <?php
                                                        foreach ($bulan->result() as $row)
                                                        {
                                                            if ($language=="bahasa")
                                                                $bln = $row->MonthNameID;
                                                            else
                                                                $bln = $row->MonthNameEN;

                                                            if ($aplDateOfBirth != "")
                                                                $month = date('m', strtotime($aplDateOfBirth));
                                                            else
                                                                $month = "";

                                                            if ($month == $row->MonthID)
                                                                $selected = "selected";
                                                            else
                                                                $selected = "";

                                                            echo '<option value="'.$row->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <select name="tahun" id="tahun" class="input-small">
                                                    <option value=""><?php echo lang('tahun')?></option>
                                                    <?php
                                                        $tahun = date('Y');
                                                        $thn = date('Y')-17; //min 17 yrs old
                                                        $tahun56 = date('Y')-56; //min 56 yrs old
                                                        for($thn == date('Y'); $thn >= $tahun56; $thn--)
                                                        {
                                                            if ($aplDateOfBirth != "")
                                                                $year = date('Y', strtotime($aplDateOfBirth));
                                                            else
                                                                $year = "";

                                                            if ($year == $thn)
                                                                $selected = "selected";
                                                            else
                                                                $selected = "";

                                                            echo '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="no_identitas"><?php echo lang('no_ktp')?> </label>
                                            <div class="controls">
                                                <input type="text" name="no_identitas" id="no_identitas" placeholder="<?php echo lang('no_ktp')?>" class="padd5AB" value="<?php echo $aplIdentityNumber; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="identitas_berlaku"><?php echo lang('identitas_berlaku')?> </label>
                                            <div class="controls">
                                                <select name="tanggalberlaku" id="tanggalberlaku" style="width: 100px;">
                                                    <option value=""><?php echo lang('tanggal')?></option>
                                                    <?php
                                                        $tgl = 1;
                                                        for($tgl == 1; $tgl <= 31; $tgl++)
                                                        {
                                                            if ($aplIdentityValid != "")
                                                                $date = date('d', strtotime($aplIdentityValid));
                                                            else
                                                                $date = "";
                                                            if ($date == $tgl)
                                                                $selected = "selected";
                                                            else
                                                                $selected = "";
                                                            echo '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <select name="bulanberlaku" id="bulanberlaku" style="width: 110px;">
                                                    <option value=""><?php echo lang('bulan')?></option>
                                                    <?php
                                                        foreach ($bulan->result() as $row)
                                                        {
                                                            if ($language=="bahasa")
                                                                $bln = $row->MonthNameID;
                                                            else
                                                                $bln = $row->MonthNameEN;

                                                            if ($aplIdentityValid != "")
                                                                $month = date('m', strtotime($aplIdentityValid));
                                                            else
                                                                $month = "";

                                                            if ($month == $row->MonthID)
                                                                $selected = "selected";
                                                            else
                                                                $selected = "";

                                                            echo '<option value="'.$row->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                                <select name="tahunberlaku" id="tahunberlaku" class="input-small">
                                                    <option value=""><?php echo lang('tahun')?></option>
                                                    <?php
                                                        $tahun = date('Y')+5;
                                                        $tahun56 = date('Y')-56; //min 56 yrs old
                                                        for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                        {
                                                            if ($aplIdentityValid != "")
                                                                $year = date('Y', strtotime($aplIdentityValid));
                                                            else
                                                                $year = "";

                                                            if ($year == $thn)
                                                                $selected = "selected";
                                                            else
                                                                $selected = "";

                                                            echo '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="statusMarital"><?php echo lang('status')?> </label>
                                            <div class="controls">
                                                <select name="statusMarital" id="statusMarital" class="padd5AB">
                                                    <option value=""><?php echo lang('pilih')?> <?php echo lang('status')?></option>
                                                    <?php
                                                        foreach ($marital->result() as $row)
                                                        {
                                                            if ($language=="bahasa")
                                                                $status = $row->MaritalName;
                                                            else
                                                                $status = $row->MaritalEnglish;

                                                            if ($aplMaritalStatus == $row->MaritalCode)
                                                                $selected = "selected='selected'";
                                                            else
                                                                $selected = "";
                                                            echo '<option value="'.$row->MaritalCode.'"'.$selected.'>'.$status.'</option>';;
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="agama"><?php echo lang('agama')?> </label>
                                            <div class="controls">
                                                <select name="agama" id="agama" class="padd5AB">
                                                    <option value=""><?php echo lang('pilih')?> <?php echo lang('agama')?></option>
                                                    <?php
                                                        foreach ($agama->result() as $row)
                                                        {
                                                            if ($aplReligion == $row->ReligionCode)
                                                                $selected = "selected='selected'";
                                                            else
                                                                $selected = "";
                                                            echo '<option value="'.$row->ReligionCode.'"'.$selected.'>'.$row->ReligionName.'</option>';;
                                                        }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="email"><?php echo lang('email')?> </label>
                                            <div class="controls">
                                                <input type="text" name="email" id="email" placeholder="<?php echo lang('email')?>" class="input-xlarge padd5AB" value="<?php echo $aplEmail; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="alternatif_email"><?php echo lang('email2')?> </label>
                                            <div class="controls">
                                                <input type="text" name="alternatif_email" id="alternatif_email" placeholder="<?php echo lang('email2')?>" class="input-xlarge padd5AB" value="<?php echo $aplAlternateEmail; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row-fluid">
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="nohp"><?php echo lang('no_hp')?> </label>
                                            <div class="controls">
                                                <input type="text" name="nohp" id="nohp" placeholder="<?php echo lang('no_hp')?>" class="hp padd5AB" value="<?php echo $aplCellular; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="span6">
                                        <div class="control-group">
                                            <label class="control-label" for="alternatif_nohp"><?php echo lang('no_hp2')?> </label>
                                            <div class="controls">
                                                <input type="text" name="alternatif_nohp" id="alternatif_nohp" placeholder="<?php echo lang('no_hp2')?>" class="hp padd5AB" value="<?php echo $aplAlternateCellular; ?>"/>
                                            </div>
                                        </div>
                                    </div>
                                </div>
    					    </div>
    					    <div class="tab-pane" id="tab2" style="padding: 10px;"> <!--Data Pendidikan-->
                                <div class="form-horizontal" style="padding-top: 10px;">
                                    <div class="control-group">
                                        <label class="control-label" for="jenjang"><?php echo lang('jenjang')?> </label>
                                        <div class="controls">
                                            <select name="jenjang" id="jenjang" class="input-medium">
                                                <option value=""><?php echo lang('pilih')?></option>
                                                <?php
                                                    foreach ($pendidikan->result() as $row)
                                                    {
                                                        if ($aplEducationLevel == $row->EducationLevelCode)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";
                                                        echo '<option value="'.$row->EducationLevelCode.'"'.$selected.'>'.$row->EducationLevelName.'</option>';;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="institusi"><?php echo lang('institusi')?> </label>
                                        <div class="controls">
                                            <input type="text" name="institusi" id="institusi" class="input-xlarge" placeholder="<?php echo lang('institusi')?>" value="<?php echo $aplEducationInstitution; ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group" id="jur">
                                        <label class="control-label" for="jurusan"><?php echo lang('jurusan')?> </label>
                                        <div class="controls">
                                            <input type="text" name="jurusan" id="jurusan" class="input-xlarge" placeholder="<?php echo lang('jurusan')?>" value="<?php echo $aplEducationMajor; ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="jurusan"><?php echo lang('kota')?> </label>
                                        <div class="controls">
                                            <input type="text" name="kota" id="kota" class="input-xlarge" placeholder="<?php echo lang('kota')?>" value="<?php echo $aplEducationCity; ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="negara"><?php echo lang('negara')?> </label>
                                        <div class="controls">
                                            <select name="negara" id="negara" class="padd5AB">
                                                <option value=""><?php echo lang('pilih')?> <?php echo lang('negara')?></option>
                                                <?php
                                                    foreach ($negara->result() as $row)
                                                    {
                                                        if ($aplEducationCountry == $row->CountryCode)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";
                                                        echo '<option value="'.$row->CountryCode.'"'.$selected.'>'.ucwords(strtolower($row->CountryName)).'</option>';;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunMasuk"><?php echo lang('tahun_masuk')?> </label>
                                        <div class="controls">
                                            <select name="tahunMasuk" id="tahunMasuk" class="input-small">
                                                <option value=""><?php echo lang('pilih')?></option>
                                                <?php
                                                    $tahunAkhir = (date("Y")-15);
                                                    for ($i = (date("Y")+1); $i--; $i > $tahunAkhir)
                                                    {

                                                        if ($aplEducationYearStart == $i)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";

                                                        if ($i >= $tahunAkhir)
                                                            echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="tahunLulus"><?php echo lang('tahun_lulus')?> </label>
                                        <div class="controls">
                                            <select name="tahunLulus" id="tahunLulus" class="input-small">
                                                <option value=""><?php echo lang('pilih')?></option>
                                                <?php
                                                    $tahunAkhir = (date("Y")-15);
                                                    for ($i = (date("Y")+1); $i--; $i > $tahunAkhir)
                                                    {
                                                        if ($aplEducationYearEnd == $i)
                                                            $selected = "selected='selected'";
                                                        else
                                                            $selected = "";

                                                        if ($i >= $tahunAkhir)
                                                            echo '<option value="'.$i.'"'.$selected.'>'.$i.'</option>';;
                                                    }
                                                ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="no_ijazah"><?php echo lang('no_ijazah')?> </label>
                                        <div class="controls">
                                            <input type="text" name="no_ijazah" id="no_ijazah" class="input-large" placeholder="<?php echo lang('no_ijazah')?>" value="<?php echo $aplEducationCert; ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="lulus"><?php echo lang('lulus')?> </label>
                                        <div class="controls">
                                            <input type="text" name="lulus" id="lulus" class="input-large" placeholder="<?php echo lang('lulus')?>" value="<?php echo $aplEducationGraduate; ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="gelar"><?php echo lang('gelar')?> </label>
                                        <div class="controls">
                                            <input type="text" name="gelar" id="gelar" class="input-small" placeholder="<?php echo lang('gelar')?>" value="<?php echo $aplEducationDegree; ?>"/>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="letak_gelar"><?php echo lang('letak_gelar')?> </label>
                                        <div class="controls">
                                            <label class="radio inline padd5AB">
                                                <input type="radio" name="letak_gelar" id="letakd" value="D" <?php echo $aplEducationDegreePos=="D"?"checked='checked'":""; ?>/>
                                                <?php echo lang('gelar_depan')?>
                                            </label>
                                            <label class="radio inline padd5AB">
                                                <input type="radio" name="letak_gelar" id="letakb" value="B" <?php echo $aplEducationDegreePos=="B"?"checked='checked'":""; ?>/>
                                                <?php echo lang('gelar_belakang')?>
                                            </label>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label" for="nilai"><?php echo lang('nilai_akhir')?>/<?php echo lang('ipk')?> </label>
                                        <div class="controls">
                                            <input type="text" name="nilai" id="nilai" class="input-small" placeholder="<?php echo lang('nilai_akhir')?>" value="<?php echo $aplEducationGPA; ?>"/>
                                            <div class="alert alert-success" style="width: 200px;margin-top: 10px;"><?php echo lang('pisah')?></div>
                                        </div>
                                    </div>
        					    </div>
                            </div>
    						<div class="tab-pane" id="tab3" style="padding: 15px;">
                                <br />
                                <div id="loadButtonCourse">
                                    <a data-toggle="modal" href="#dialog-non-pendidikan" class="btn"><i class="icon-plus"></i> <?php echo lang('tambah')?></a>
                                </div>
                                <br />
                                <div id="dialog-non-pendidikan" class="modal custom hide fade in" style="display: none;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4><?php echo lang('non_pendidikan')?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-horizontal" style="margin-left: -50px;">
                                            <div class="control-group">
                                                <label class="control-label" for="pelatihan"><?php echo lang('pelatihan')?> </label>
                                                <div class="controls">
                                                    <textarea name="pelatihan" id="pelatihan" placeholder="<?php echo lang('pelatihan')?>" rows="3" style="width: 300px;"><?php echo $aplCouseName; ?></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="penyelenggara"><?php echo lang('penyelenggara')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="penyelenggara" id="penyelenggara" class="input-xlarge" placeholder="<?php echo lang('penyelenggara')?>" value="<?php echo $aplCourseOrganizer; ?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="kota_penyelenggara"><?php echo lang('kota')?> <?php echo lang('penyelenggara')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="kota_penyelenggara" id="kota_penyelenggara" class="input-xlarge" placeholder="<?php echo lang('kota')?> <?php echo lang('penyelenggara')?>" value="<?php echo $aplCourseCity; ?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="sertifikat"><?php echo lang('sertifikat')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="sertifikat" id="sertifikat" class="input-xlarge" placeholder="<?php echo lang('sertifikat')?>" value="<?php echo $aplCourseNoCertificate; ?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="tanggal_awal"><?php echo lang('tanggal_awal')?> </label>
                                                <div class="controls">
                                                    <select name="tanggalPelatihanAwal" id="tanggalPelatihanAwal" style="width: 100px;" onchange="courseStartDate()">
                                                        <option value=""><?php echo lang('tanggal')?></option>
                                                        <?php
                                                            $tgl = 1;
                                                            for($tgl == 1; $tgl <= 31; $tgl++)
                                                            {
                                                                if ($aplCourseStart != "")
                                                                    $date = date('d', strtotime($aplCourseStart));
                                                                else
                                                                    $date = "";
                                                                if ($date == $tgl)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";
                                                                echo '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <select name="bulanPelatihanAwal" id="bulanPelatihanAwal" style="width: 110px;" onchange="courseStartDate()">
                                                        <option value=""><?php echo lang('bulan')?></option>
                                                        <?php
                                                            foreach ($bulan->result() as $row)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row->MonthNameID;
                                                                else
                                                                    $bln = $row->MonthNameEN;

                                                                if ($aplCourseStart != "")
                                                                    $month = date('m', strtotime($aplCourseStart));
                                                                else
                                                                    $month = "";

                                                                if ($month == $row->MonthID)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                echo '<option value="'.$row->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <select name="tahunPelatihanAwal" id="tahunPelatihanAwal" class="input-small" onchange="courseStartDate()">
                                                        <option value=""><?php echo lang('tahun')?></option>
                                                        <?php
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                if ($aplCourseStart != "")
                                                                    $year = date('Y', strtotime($aplCourseStart));
                                                                else
                                                                    $year = "";

                                                                if ($year == $thn)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                echo '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" name="pelatihanAwal" id="pelatihanAwal"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="tanggal_akhir"><?php echo lang('tanggal_akhir')?> </label>
                                                <div class="controls">
                                                    <select name="tanggalPelatihanAkhir" id="tanggalPelatihanAkhir" style="width: 100px;" onchange="courseStartEnd()">
                                                        <option value=""><?php echo lang('tanggal')?></option>
                                                        <?php
                                                            $tgl = 1;
                                                            for($tgl == 1; $tgl <= 31; $tgl++)
                                                            {
                                                                if ($aplCourseEnd != "")
                                                                    $date = date('d', strtotime($aplCourseEnd));
                                                                else
                                                                    $date = "";
                                                                if ($date == $tgl)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";
                                                                echo '<option value="'.$tgl.'"'.$selected.'>'.$tgl.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <select name="bulanPelatihanAkhir" id="bulanPelatihanAkhir" style="width: 110px;" onchange="courseStartEnd()">
                                                        <option value=""><?php echo lang('bulan')?></option>
                                                        <?php
                                                            foreach ($bulan->result() as $row)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row->MonthNameID;
                                                                else
                                                                    $bln = $row->MonthNameEN;

                                                                if ($aplCourseEnd != "")
                                                                    $month = date('m', strtotime($aplCourseEnd));
                                                                else
                                                                    $month = "";

                                                                if ($month == $row->MonthID)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                echo '<option value="'.$row->MonthID.'"'.$selected.'>'.$bln.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <select name="tahunPelatihanAkhir" id="tahunPelatihanAkhir" class="input-small" onchange="courseStartEnd()">
                                                        <option value=""><?php echo lang('tahun')?></option>
                                                        <?php
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                if ($aplCourseEnd != "")
                                                                    $year = date('Y', strtotime($aplCourseEnd));
                                                                else
                                                                    $year = "";

                                                                if ($year == $thn)
                                                                    $selected = "selected";
                                                                else
                                                                    $selected = "";

                                                                echo '<option value="'.$thn.'"'.$selected.'>'.$thn.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <input type="hidden" name="pelatihanAkhir" id="pelatihanAkhir"/>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hiddenIDPelatihan" id="hiddenIDPelatihan" />
                                        <input type="submit" class="btn btn-info btn-small" name="simpan_pelatihan" id="simpan_pelatihan" value="<?php echo lang('simpan')?>" />
                                        <a href="#" class="btn btn-small" data-dismiss="modal"><?php echo lang('batal')?></a>
                                    </div>
                                </div>
                                <?php
                                    /*if ($allCourse->num_rows() == 0)
                                    {
                                ?>
                                <div class="alert alert-error" style="margin-right: 20px;">
                                    <?php echo lang('kosong')?>
                                </div>
                                <?php
                                    } else {*/
                                ?>
                                <div class="alert alert-success hide" id="success_course">
                                    Data berhasil dimasukan.
                                </div>
                                <div class="alert alert-error hide" id="error_course">
                                    Data gagal dimasukan, silakan coba lagi.
                                </div>

                                <table class="table table-hover" id="tblcourse">
                                </table>
                                <?php
                                    //}
                                ?>
    					    </div>
    						<div class="tab-pane" id="tab4" style="padding: 15px;">
                                <br />
                                <div id="loadButtonWork">
                                    <a data-toggle="modal" href="#dialog-pengalaman" class="btn"><i class="icon-plus"></i>&nbsp;<?php echo lang('tambah')?></a>
                                </div>
                                <br />
                                <div id="dialog-pengalaman" class="modal custom hide fade in" style="display: none; width: 680px;">
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                        <h4><?php echo lang('pengalaman_kerja')?></h4>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-horizontal" style="margin-left: -40px;">
                                            <div class="control-group">
                                                <label class="control-label" for="perusahaan"><?php echo lang('perusahaan')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="perusahaan" id="perusahaan" class="input-xlarge" placeholder="<?php echo lang('perusahaan')?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="alamat_perusahaan"><?php echo lang('alamat')?> </label>
                                                <div class="controls">
                                                    <textarea name="alamat_perusahaan" id="alamat_perusahaan" placeholder="<?php echo lang('alamat')?>" rows="3" style="width: 300px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="kota_perusahaan"><?php echo lang('kota')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="kota_perusahaan" id="kota_perusahaan" class="input-xlarge" placeholder="<?php echo lang('kota')?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="telp_perusahaan"><?php echo lang('no_telp')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="telp_perusahaan" id="telp_perusahaan" class="input-xlarge hp" placeholder="<?php echo lang('no_telp')?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="atasan"><?php echo lang('atasan')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="atasan" id="atasan" class="input-xlarge" placeholder="<?php echo lang('atasan')?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="posisi"><?php echo lang('posisi')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="posisi" id="posisi" class="input-xlarge" placeholder="<?php echo lang('posisi')?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="periode_kerja"><?php echo lang('periode')?> </label>
                                                <div class="controls">
                                                    <select name="bulanKerjaAwal" id="bulanKerjaAwal" style="width: 110px;">
                                                        <option value=""><?php echo lang('bulan')?></option>
                                                        <?php
                                                            foreach ($bulan->result() as $row)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row->MonthNameID;
                                                                else
                                                                    $bln = $row->MonthNameEN;

                                                                echo '<option value="'.$row->MonthID.'">'.$bln.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <select name="tahunKerjaAwal" id="tahunKerjaAwal" class="input-small">
                                                        <option value=""><?php echo lang('tahun')?></option>
                                                        <?php
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                echo '<option value="'.$thn.'">'.$thn.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    s.d
                                                    <select name="bulanKerjaAkhir" id="bulanKerjaAkhir" style="width: 110px;">
                                                        <option value=""><?php echo lang('bulan')?></option>
                                                        <?php
                                                            foreach ($bulan->result() as $row)
                                                            {
                                                                if ($language=="bahasa")
                                                                    $bln = $row->MonthNameID;
                                                                else
                                                                    $bln = $row->MonthNameEN;

                                                                echo '<option value="'.$row->MonthID.'">'.$bln.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <select name="tahunKerjaAkhir" id="tahunKerjaAkhir" class="input-small">
                                                        <option value=""><?php echo lang('tahun')?></option>
                                                        <?php
                                                            $tahun = date('Y');
                                                            $tahun56 = date('Y')-56; //min 56 yrs old
                                                            for($thn = $tahun; $thn >= $tahun56; $thn--)
                                                            {
                                                                echo '<option value="'.$thn.'">'.$thn.'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                    <label for="masih_bekerja">
                                                        <input type="checkbox" name="masih_bekerja" id="masih_bekerja"/>
                                                        <?php echo lang('masih_bekerja')?>
                                                    </label>
                                                </div>
                                            </div>

                                            <div class="control-group">
                                                <label class="control-label" for="gaji_awal"><?php echo lang('gaji_awal')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="gaji_awal" id="gaji_awal" class="input-medium gaji" placeholder="<?php echo lang('gaji_awal')?>" value="<?php ?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="gaji_akhir"><?php echo lang('gaji_akhir')?> </label>
                                                <div class="controls">
                                                    <input type="text" name="gaji_akhir" id="gaji_akhir" class="input-medium gaji" placeholder="<?php echo lang('gaji_akhir')?>" value="<?php ?>"/>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="deskripsi"><?php echo lang('deskripsi')?> </label>
                                                <div class="controls">
                                                    <textarea name="deskripsi" id="deskripsi" placeholder="<?php echo lang('deskripsi')?>" rows="3" style="width: 300px;"></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label" for="alasan_keluar"><?php echo lang('alasan_keluar')?> </label>
                                                <div class="controls">
                                                    <textarea name="alasan_keluar" id="alasan_keluar" placeholder="<?php echo lang('alasan_keluar')?>" rows="3" style="width: 300px;"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <input type="hidden" name="hiddenIDPengalaman" id="hiddenIDPengalaman" />
                                        <input type="submit" class="btn btn-info" name="simpan_pengalaman" id="simpan_pengalaman" value="<?php echo lang('simpan')?>" />
                                        <a class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
                                    </div>
                                </div>
                                <div class="alert alert-success hide" id="success_work">
                                    Data berhasil dimasukan.
                                </div>
                                <div class="alert alert-error hide" id="error_work">
                                    Data gagal dimasukan, silakan coba lagi.
                                </div>
                                <table class="table table-hover" id="tblwork">
                                </table>
                                <?php
                                    //}
                                ?>
    					    </div>
    						<div class="tab-pane" id="tab5" style="padding: 15px;">
                                <div class="control-group">
                                    <label class="control-label" for="gaji"><?php echo lang('gaji_harapan')?> </label>
                                    <div class="controls">
										<!-- derry :: biar masukinnya lebih enak -->
                                        <!--input type="text" name="gaji" id="gaji" value="<?php echo $aplExpectedSalary;?>"/-->
										<input type="number" step="500000" name="gaji" id="gaji" value="<?php echo $aplExpectedSalary;?>"/>
                                    </div>
                                </div>
    					    </div>
                            <ul class="pager wizard">
                    			<li class="previous"><a href="javascript:;"><i class="icon-circle-arrow-left"></i>&nbsp;&nbsp;Previous</a></li>
                    		  	<li class="next"><a href="javascript:;">Next&nbsp;&nbsp;<i class="icon-circle-arrow-right"></i></a></li>
                    			<li class="next finish" style="display:none;"><a href="javascript:;">Finish&nbsp;&nbsp;<i class="icon-flag"></i></a></li>
                    		</ul>
    					</div>
                    </form>
                </div>
            <!--</div>-->
            </div>
	   </div>
    </div>

    <!--Dialog Delete Course-->
    <div id="dialog-delete-course" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('pelatihan')?></h4>
        </div>
        <div class="modal-body" style="padding: 10px;" id="body-delete-course">
        </div>
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_pelatihan" id="hidden_del_pelatihan" />
            <input type="submit" class="btn btn-info" name="hapus_pelatihan" id="hapus_pelatihan" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>


    <!--Dialog Delete Work-->
    <div id="dialog-delete-work" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <h4><?php echo lang('hapus')?> <?php echo lang('pengalaman_kerja')?></h4>
        </div>
        <div class="modal-body" style="padding: 10px;" id="body-delete-work">
        </div>
        <div class="modal-footer">
            <input type="hidden" name="hidden_del_pengalaman" id="hidden_del_pengalaman" />
            <input type="submit" class="btn btn-info" name="hapus_pengalaman" id="hapus_pengalaman" value="<?php echo lang('hapus')?>" />
            <a href="#" class="btn" data-dismiss="modal"><?php echo lang('batal')?></a>
        </div>
    </div>

    <!--Dialog Notif-->
    <div id="dialog-notif" class="modal custom hide fade in" style="display: none;">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
            <h4><?php echo lang('lamaran')?></h4>
        </div>
        <div class="modal-body" style="padding:20px;" id="body-notif">
        </div>
        <div class="modal-footer">
            <a href="#" class="btn" data-dismiss="modal">OK</a>
        </div>
    </div>
    <div id="res"></div>
    <?php
        }
    ?>
</div>