<div class="span2"></div>
<div class="wrapper span8">
	<div class="logo" style="margin: 10px 0 0 0;"></div>

	<div style="padding: 0 15px 15px 15px;">
		<div class="row-fluid">
			<div class="span10">
			</div>
			<div class="span2" style="text-align: right;padding-top: 10px;font-size: small;">
				<a style="color: black;" href="<?php echo $en; ?>">English</a> |
				<a style="color: black;" href="<?php echo $id; ?>">Bahasa</a>
			</div>
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
					<?php echo form_dropdown('gender',$gender,'large');?>
						 <!--select type="text" name="gender" id="gender" placeholder="Title'?>" class="input-xlarge "/>
							<option value=""> -- Gender -- </option>
							<option value="P">Pria</option>
							<option value="W">Wanita</option>
						 </select-->
					</div>
				</div>

				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<!--label class="control-label" for="nama"><?=lang('nama_lengkap')?> </label-->
					<div class="controls">
						 <input type="text" name="nama" id="nama" placeholder="<?=lang('form_nama_lengkap')?>" class="input-xlarge "/>
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
					<div class="controls">
					<?php //echo form_dropdown('gender',$gender,'large');?>
						<!--select name="country" id="country"  tabindex="8"class="input-xlarge">
						   <option value="-1" class="selected"><?=lang('form_negara_tinggal')?></option>
							<?
								foreach ($country->result() as $row)
								{
									if ($_POST["country"] == $row->CountryCode)
										$selected = "selected='selected'";
									else
										$selected = "";
									echo '<option value="'.$row->CountryCode.'"'.$selected.'>'.$row->CountryName.'</option>';;
								}
							?>
						</select-->
					</div>

				</div>
				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<div class="controls">
						 <input type="text" name="nama" id="nama" placeholder="<?=lang('kota')?>" class="input-xlarge "/>
					</div>
				</div>
				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<div class="controls">
					<?php //echo form_dropdown('nationality',$nationality,'x-large');?>
						<!--select name="nationality" id="nationality"  tabindex="8"class="input-xlarge">
						   <option value="-1" class="selected"><?=lang('form_kewarganegaraan')?></option>
							<?
								foreach ($nationality->result() as $row)
								{
									if ($_POST["nationality"] == $row->NationalityCode)
										$selected = "selected='selected'";
									else
										$selected = "";
									echo '<option value="'.$row->NationalityCode.'"'.$selected.'>'.$row->NationalityName.'</option>';;
								}
							?>
						</select-->
					</div>
				</div>

				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<div class="controls">
						 <input type="text" name="current_job" id="current_job" placeholder="<?=lang('pekerjaan_sekarang')?>" class="input-xlarge"/>
					</div>
				</div>

				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<div class="controls">
						<?php echo form_dropdown('gender',$gender,'large');?>
						<!--select name="education_lv" id="education_lv"  tabindex="8"class="input-xlarge">
						   <option value="-1" class="selected"><?=lang('form_education_lv')?></option>
							<?
								foreach ($education_lvl->result() as $row)
								{
									if ($_POST["education_lv"] == $row->EducationLevelCode)
										$selected = "selected='selected'";
									else
										$selected = "";
									echo '<option value="'.$row->EducationLevelCode.'"'.$selected.'>'.$row->EducationLevelName.'</option>';;
								}
							?>
						</select-->
					</div>
				</div>

				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
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
<script>
function checkvalue(val)
{
    if(val==="others")
       document.getElementById('other').style.display='block';
    else
       document.getElementById('other').style.display='none';
    if(val==="refered")
       document.getElementById('refered').style.display='block';
    else
       document.getElementById('refered').style.display='none';
}
</script>
	<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<div class="controls">
						<?php //echo form_dropdown('gender',$gender,'large');?>
						<!--select name="candidateSource" id="candidateSource"  tabindex="8"class="input-xlarge" onchange='checkvalue(this.value)'>
						   <option value="-1" class="selected"><?=lang('form_how_you_know')?></option>
							<option value="others">Other</option>
							<option value="refered">Employee Referred</option>
							<?
								foreach ($candidate_src->result() as $row)
								{
									if ($_POST["candidateSource"] == $row->CandidateSourcesID)
										$selected = "selected='selected'";
									else
										$selected = "";
									echo '<option value="'.$row->CandidatesSourceID.'"'.$selected.'>'.$row->CandidateSourcesName.'</option>';;
								}
							?>
						</select-->
					</div>
		</div>

	<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
			<input type="text" id="refered" value="" maxlength="100" name="personReferred" class="left" tabindex="7" title="Person who referred you"  placeholder="Person who referred you" style="display:none;">
	</div>
	<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
			<input type="text" id="other" value="" maxlength="100" name="other" class="left" tabindex="7" title="other"  placeholder="Other, please specify" style="display:none;">
	</div>

	<div class="control-group droppedField">
			<label>Work sought</label>
			<div id="workSought_Group">
				<input type="checkbox" name="workSought_permanent" class="checbox" id="workSought_permanent">Permanent</input>
				<input type="checkbox" name="workSought_parttime" class="checbox" id="workSought_parttime">Part-time</input>
				<input type="checkbox" name="workSought_contract" class="checbox" id="workSought_contract">Contract/Temp</input>
				<input type="checkbox" name="workSought_graduate" class="checbox" id="workSought_graduate">Graduate</input>
				<input type="checkbox" name="workSought_intership" class="checbox" id="workSought_intership">Internship</input>
				<input type="checkbox" name="workSought_graduate_h_s" class="checbox" id="workSought_graduate_h_s">Graduate High School</input>
			</div>
			<div class="ClearItem"></div>
	</div>

				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<div class="controls">
						<table>
							<tr>
								<td style="vertical-align: top;">
									 <div class="input-prepend">
										<input type="password" name="password" id="password" placeholder="<?=lang('password')?>" class="input-large "/>
									 </div>
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
					<div class="controls">
						<input type="password" name="confirm_password" id="confirm_password" placeholder="<?=lang('confirm_password')?>" class="input-large "/>
					</div>
				</div>
				<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
					<div class="controls">
						<span id="refresh-captcha"><?php echo $recaptcha ?></span>
						<span style="margin-top: -10px;"><button class="btn btn-small" id="refresh"><i class="icon-refresh"></i></button ></span>
						<br />
						<label style="margin-top: 5px;">Please enter the letters displayed:</label>
						<input type="text" id="captcha" name="captcha" placeholder="Captha"/>
					   <span id="errorCaptcha" style="color: red;"></span>
					</div>
				</div>
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
