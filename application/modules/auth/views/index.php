<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Registrasi | Kompas Recruitment</title>
</head>
<body>
    <div class="span2"></div>
    <div class="wrapper span8">
        <div class="logo" style="margin: 10px 0 0 0;"></div>

        <div style="padding: 0 15px 15px 15px;">
            <div class="row-fluid">
                <div class="span10">
                </div>
                <!--div class="span2" style="text-align: right;padding-top: 10px;font-size: small;">
                    <a style="color: black;" href="<?php echo $en; ?>">English</a> |
                    <a style="color: black;" href="<?php echo $id; ?>">Bahasa</a>
                </div-->
            </div>
        </div>

        <div class="row" style="z-index: 22;">
            <!--id="selected-column-1" -->
            <div class="span4 droppedFields activeDroppable" style="z-index: 23;margin-right: 90px;">
                <legend><?=lang('registrasi')?></legend>
                <form id="form_register" name="form_register" method="post">
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="nama"><?=lang('nama_lengkap')?> </label-->
                        <div class="controls">
                             <select type="text" name="nama" id="nama" placeholder="Title'?>" class="input-xlarge "/>
								<option value=""> -- Gender -- </option>
								<option value="P">Pria</option>
								<option value="W">Wanita</option>
							 </select>
                        </div>
                    </div>

					<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="nama"><?=lang('nama_lengkap')?> </label-->
                        <div class="controls">
                             <input type="text" name="nama" id="nama" placeholder="<?=lang('nama_lengkap').' sesuai Akte Kelahiran'?>" class="input-xlarge "/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="email"><?=lang('email')?> </label-->
                        <div class="controls">
                             <input type="text" name="email" id="email" placeholder="<?=lang('email')?>" class="input-xlarge"/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="no_hp"><?=lang('no_hp')?> </label-->
                        <div class="controls">
                             <input type="text" name="no_hp" id="no_hp" placeholder="<?=lang('no_hp')?>" class="input-xlarge hp"/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="no_hp"><?=lang('no_hp')?> </label-->
                        <div class="controls">
                             <input type="text" name="no_hp" id="no_hp" placeholder="<?=lang('no_hp')?>" class="input-xlarge hp"/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="no_hp"><?=lang('no_hp')?> </label-->
                        <div class="controls">
                             <input type="text" name="no_hp" id="no_hp" placeholder="<?=lang('no_hp')?>" class="input-xlarge hp"/>
                        </div>
                    </div>
                <!--/form-->
                <div id="message">
                </div>
            </div>

        <div class="row" style="z-index: 22;">
            <!--id="selected-column-2" -->
            <div class="span3 droppedFields activeDroppable" style="z-index: 30; margin-top:60px;">
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="nama"><?=lang('nama_lengkap')?> </label-->
                        <div class="controls">
                             <input type="text" name="nama" id="nama" placeholder="<?=lang('negara')?>" class="input-xlarge "/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="nama"><?=lang('nama_lengkap')?> </label-->
                        <div class="controls">
                             <input type="text" name="nama" id="nama" placeholder="<?=lang('kota')?>" class="input-xlarge "/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="email"><?=lang('email')?> </label-->
                        <div class="controls">
                             <input type="text" name="email" id="email" placeholder="<?=lang('kewarganegaraan')?>" class="input-xlarge"/>
                        </div>
                    </div>

                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="no_hp"><?=lang('no_hp')?> </label-->
                        <div class="controls">
                             <input type="text" name="current_job" id="current_job" placeholder="<?=lang('pekerjaan_sekarang')?>" class="input-xlarge"/>
                        </div>
                    </div>

                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="no_hp"><?=lang('no_hp')?> </label-->
                        <div class="controls">
						<select class="right none_character" name="education" id="education" tabindex="13" title="Your education qualifications">
							<option value="-1" selected="selected">---Your education qualifications---</option>
								<option value="1">Doctorate</option>
								<option value="2">Master</option>
								<option value="3">Post Grad Diploma</option>
								<option value="4">Degree</option>
								<option value="5">Diploma</option>
								<option value="6">ITE/Tech/Teaching Cert</option>
								<option value="7">Professional Qualification</option>
								<option value="8">N/O/A</option>
								<option value="9">Incomplete Sec Education</option>
								<option value="10">Primary</option>
								<option value="11">No Formal Education</option>
						</select>
                        </div>
                    </div>

                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="no_hp"><?=lang('no_hp')?> </label-->
                        <div class="controls">
                             <input type="text" name="current_employer" id="current_employer" placeholder="<?=lang('tempat_kerja_sekarang')?>" class="input-xlarge"/>
                        </div>
                    </div>

					</form>
                <?php
                    if(!empty($vacancyCompany) && !empty($vacancyJob))
                    {
                ?>
                <div class="info">
                    <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                        <p>Anda akan melamar:</p>
                        <ul><li><?php echo $vacancyCompany." - ".$vacancyJob;?></li></ul>
                    </div>
                </div>
                <?
                    }
                ?>
            </div>
        </div>
		<!-- END of 2nd Column-->

		<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
				<select id="refCompany" class="left" name="candidateSourceId" title="Referring Company" tabindex="6">
						<option value="-1" selected="">--- How did you hear about this job?  ---</option>
						<option value="32814">Airlangga Career Fair</option>
						<option value="32779">Career Expo UI XVI</option>
						<option value="32817">ITB Integrated Career Days</option>
						<option value="32769">Job Fair KKF Balai Kartini Agustus 2013</option>
						<option value="32842">Jobfair UNDIP</option>
						<option value="32805">Jobfair universitas brawijaya malang 2013</option>
						<option value="32819">KG Job Vaganza Yogyakarta</option>
						<option value="32668">Kompas Gramedia Careersite</option>
						<option value="32683">Kompas Karier.com</option>
						<option value="32718">Other</option>
						<option value="32789">Semarak Bali</option>
						<option value="32818">UGM Career Days</option>
				</select>
                <span class="left star">*</span>
  				  <input tabindex="13" id="employeeReferal" type="checkbox" class="checbox left" name="isEmployeeReferal">
                  <div class="left employeeReferral"><span class="employeeReferral">Employee referral</span></div>
			</div>

		<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
				<input type="text" value="" maxlength="100" name="personReferred" class="left" tabindex="7" title="Person who referred you"  placeholder="Person who referred you">
		</div>

		<div class="row WorkSoughtWrap">
				<label>Work sought</label>
				<div id="workSought_Group">
					<label for="workSought_permanent" class="RadioCheckboxDefault">Permanent<input type="checkbox" name="workSought_permanent" class="checbox" id="workSought_permanent"></label>
					<label class="workSought_padding RadioCheckboxDefault" for="workSought_parttime">Part-time<input type="checkbox" name="workSought_parttime" class="checbox" id="workSought_parttime"></label>
					<label class="workSought_padding RadioCheckboxDefault" for="workSought_contract">Contract/Temp<input type="checkbox" name="workSought_contract" class="checbox" id="workSought_contract"></label>
	                <label class="workSought_padding RadioCheckboxDefault" for="workSought_graduate">Graduate<input type="checkbox" name="workSought_graduate" class="checbox" id="workSought_graduate"></label>
	                <label class="workSought_padding RadioCheckboxDefault" for="workSought_intership">Internship<input type="checkbox" name="workSought_intership" class="checbox" id="workSought_intership"></label>
	                <label class="workSought_padding RadioCheckboxDefault" for="workSought_graduate_h_s">Graduate High School<input type="checkbox" name="workSought_graduate_h_s" class="checbox" id="workSought_graduate_h_s"></label>
                </div>
                <div class="ClearItem"></div>
		</div>

                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="password"><?=lang('password')?> </label-->
                        <div class="controls">
                            <table>
                                <tr>
                                    <td style="vertical-align: top;">
                                         <div class="input-prepend">
                                            <span class="add-on" style="height: 22px;"><i class="icon-lock icon-black"></i></span>
                                            <input type="password" name="password" id="password" placeholder="<?=lang('password')?>" class="input-large "/>
                                         </div>
                                         <!--<input type="password" name="password" id="password" placeholder="<?=lang('password')?>" class="input-large "/>-->
                                    </td>
                                    <td  style="vertical-align: top;">
                                        <div id="short" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                            <div class="bar bar-danger" style="width: 10%;"></div>
                                        </div>
                                        <div id="weak" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                            <div class="bar bar-danger" style="width: 33.3%;"></div>
                                        </div>
                                        <div id="good" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                            <div class="bar bar-warning" style="width: 66.6%;"></div>
                                        </div>
                                        <div id="strong" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                            <div class="bar bar-success" style="width: 80%;"></div>
                                        </div>
                                        <div id="very-strong" class="progress" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                            <div class="bar bar-success" style="width: 99.9%;"></div>
                                        </div>
                                    </td>
                                </tr>
                            </table>
                            <div id="info_password" style="font-size: smaller;display: none;">
                                <?=lang('info_password')?>
                            </div>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <!--label class="control-label" for="confirm_password"><?=lang('confirm_password')?> </label-->
                        <div class="controls">
                            <!--<div class="input-prepend">
                                <span class="add-on" style="height: 22px;"><i class="icon-lock icon-black"></i></span>
                                <input type="password" name="confirm_password" id="confirm_password" placeholder="<?=lang('confirm_password')?>" class="input-large "/>
                            </div>-->
                            <input type="password" name="confirm_password" id="confirm_password" placeholder="<?=lang('confirm_password')?>" class="input-large "/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <div class="controls">
                            <span id="refresh-captcha"><?php echo $recaptcha ?></span>
                            <span style="margin-top: -10px;"><button class="btn btn-small" id="refresh"><i class="icon-refresh"></i></button ></span>
                            <br />
                            <label style="margin-top: 5px;">Please enter the letters displayed:</label>
                            <!--<div class="input-prepend">
                                <span class="add-on" style="height: 22px;"><i class="icon-font icon-black"></i></span>
                                <input type="text" id="captcha" name="captcha"/>
                            </div>-->
                            <input type="text" id="captcha" name="captcha" placeholder="Captha"/>
    	                   <span id="errorCaptcha" style="color: red;"></span>
                        </div>
                    </div>
                    <!--<div class="droppedField" style="z-index: 29;" id="CTRL-DIV-1009">
                        <button class="btn btnN ctrl-btn" name="">Daftar</button>
                    </div>-->
                    <div class="droppedField" style="z-index: 29;text-align: right;" id="CTRL-DIV-1009">
                        <input type="submit" class="btn btnN ctrl-btn span2" name="simpan" id="simpan" value="<?=lang('registrasi')?>"/>
                    </div>
        <!-- Action bar - Suited for buttons on form -->
        <div class="row-fluid" style="z-index: 33;">
            <div id="selected-action-column" class="span10 action-bar droppedFields activeDroppable" style="min-height: 80px; z-index: 34;">
            </div>
        </div>
    </div>
    <div class="span2"></div>
</body>
</html>