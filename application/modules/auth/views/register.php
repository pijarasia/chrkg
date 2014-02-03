<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Registrasi | Login | Kompas Recruitment</title>
</head>
<body>
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

<div class="controls">
<?php echo form_dropdown('gender',$gender,'large');?><br>
</div>

                        <label class="control-label" for="nama"><?=lang('nama_lengkap')?> </label>
                        <div class="controls">
                             <!--<div class="input-prepend">
                                <span class="add-on" style="height: 22px;"><i class="icon-user icon-black"></i></span>
                                <input type="text" name="nama" id="nama" placeholder="<?=lang('nama_lengkap')?>" class="input-xlarge "/>
                             </div>-->
                             <input type="text" name="nama" id="nama" placeholder="<?=lang('form_nama_lengkap')?>" class="input-xlarge "/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <label class="control-label" for="email"><?=lang('email')?> </label>
                        <div class="controls">
                             <!--<div class="input-prepend">
                                <span class="add-on" style="height: 22px;"><i class="icon-envelope icon-black"></i></span>
                                <input type="text" name="email" id="email" placeholder="<?=lang('email')?>" class="input-xlarge"/>
                             </div>-->
                             <input type="text" name="email" id="email" placeholder="<?=lang('email')?>" class="input-xlarge"/>
                        </div>
                    </div>
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <label class="control-label" for="no_hp"><?=lang('no_hp')?> </label>
                        <div class="controls">
                             <!--<div class="input-prepend">
                                <span class="add-on" style="height: 22px;"><i class="icon-th icon-black"></i></span>
                                <input type="text" name="no_hp" id="no_hp" placeholder="<?=lang('no_hp')?>" class="input-xlarge hp"/>
                             </div>-->
                             <input type="text" name="no_hp" id="no_hp" placeholder="<?=lang('no_hp')?>" class="input-xlarge hp"/>
                        </div>
                    </div>
<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		<?php echo form_dropdown('candidate_src',$candidate_src,'input-xlarge');?>
	</div>
</div>
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
		<input type="text" id="refered" value="" maxlength="100" name="personReferred" class="left" tabindex="7" title="<?=lang('form_referrer')?>" placeholder="<?=lang('form_referrer')?>" style="display:none;">
	</div>
</div>
<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		<input type="text" id="other" value="" maxlength="100" name="other" class="left" tabindex="8" title="<?=lang('form_other')?>" placeholder="<?=lang('form_other')?>" style="display:none;">
	</div>
</div>

<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		<?php echo form_dropdown('country',$country,'large');?>
	</div>
</div>

<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		<?php echo form_dropdown('nationality',$nationality,'large');?>
	</div>
</div>

<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		 <input type="text" name="nama" id="nama" placeholder="<?=lang('kota')?>" class="input-xlarge "/>
	</div>
</div>

<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		<input type="text" name="current_job" id="current_job" placeholder="<?=lang('form_current_jobtitle')?>" class="input-xlarge"/>
	</div>
</div>

<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		 <input type="text" name="current_employer" id="current_employer" placeholder="<?=lang('form_current_employer')?>" class="input-xlarge"/>
	</div>
</div>

<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
		<?php echo form_dropdown('education_lv',$education_lvl,'large');?>
	</div>
</div>


<div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
	<div class="controls">
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
</div>

                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <label class="control-label" for="password"><?=lang('password')?> </label>
                        <div class="controls">
                            <table>
                                <tr>
                                    <td style="vertical-align: top;">
                                         <!--<div class="input-prepend">
                                            <span class="add-on" style="height: 22px;"><i class="icon-lock icon-black"></i></span>
                                            <input type="password" name="password" id="password" placeholder="<?=lang('password')?>" class="input-large "/>
                                         </div>-->
                                         <input type="password" name="password" id="password" placeholder="<?=lang('password')?>" class="input-large "/>
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
                        <label class="control-label" for="confirm_password"><?=lang('confirm_password')?> </label>
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
                </form>
                <div id="message">
                </div>
            </div>
            <!--id="selected-column-2" -->
            <div class="span3 droppedFields activeDroppable" style="z-index: 30;">
                <!--<legend class="legendwhite">Login</legend>
                <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                    <label class="control-label">Username</label><br/>
                    <input type="text" placeholder="Gunakan username/no. hp" class="ctrl-textbox pendek" name=""/`>
                </div>
                <div class="droppedField" style="z-index: 32;" id="CTRL-DIV-1002">
                    <label class="control-label">Password</label><br/>
                    <input type="password" placeholder="Password..." class="ctrl-passwordbox pendek"/>
                </div>
                <div class="droppedField" style="z-index: 43;" id="CTRL-DIV-1010">
                    <button class="btn ctrl-btn" name=""> Masuk</button>
                </div>-->
                <div class="loginarea">
                <?
                    if ($forgot == false)
                    {
                ?>
                    <span id="logins">
                    <?php
                        if ($this->session->userdata('errorMsg') != "active")
                        {
                    ?>
                        <?php echo form_open("register");?>
                        <legend class="legendwhite"><span style="padding: 0 5px;">Login</span></legend>
                        <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                            <label class="control-label"><?=lang('username')?></label><br />
                            <!--<?php echo form_input($identity);?>-->
                            <input type="text" id="identity" name="identity" value="<?php echo $this->form_validation->set_value('identity');?>" placeholder="<?=lang('username')?>" class="ctrl-textbox pendek"/>
                        </div>
                        <div class="droppedField" style="z-index: 32;" id="CTRL-DIV-1002">
                            <label class="control-label"><?=lang('password')?></label><br />
                            <!--<?php echo form_input($password);?>-->
                            <input type="password" id="password" name="password" placeholder="<?=lang('password')?>" class="ctrl-textbox pendek"/>
                        </div>
                        <div>
                            <?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><label for="remember" class="help-inline control-label" style="margin-left: -10px;"><?=lang('remember')?></label>
                            <br />
                            <div style="padding: 0 6px;"><?php echo form_submit('submit', lang('login'), 'class="btn btnN span2"');?></div>
                        </div>
                        <?php echo form_close();?>
                        <!--id="lupa_password"-->
                        <div style="padding: 0 6px 5px 7px;"><a href="register/forgot" style="cursor: pointer;"><?=lang('lupa_password')?></a></div>
                    <?
                        } else {
                    ?>
                        <?php echo form_open("register/activation");?>
                        <legend class="legendwhite"><span style="padding: 0 5px;"><?=lang('aktivasi')?></span></legend>
                        <div id="form_aktivasi">
                            <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                                <label class="control-label"><?=lang('kode_aktivasi')?></label><br />
                                <input type="text" id="kode" name="kode" placeholder="<?=lang('kode_aktivasi')?>"/>
                            </div>
                            <div style="padding: 0 6px;">
                                <?php echo form_submit('submit', lang('aktifkan'), 'class="btn btnN span2"');?>
                                <a href="register/login"><?=lang('kembali_login')?></a>
                                <br /><br />
                                <input type="hidden" id="email_ulang" name="email_ulang" value="<?php echo $this->session->userdata('emails');?>"/>
                                <a id="kirim_ulang" style="cursor: pointer;"><?=lang('kirim_ulang')?></a>
                            </div>
                        </div>
                        <?php echo form_close();?>
                    <?
                        }
                    ?>
                    </span>
                <?
                    }
                    else
                    {
                ?>
                    <span id="forgots">
                        <?
                        if ($change == false)
                        {
                        ?>
                        <form id="form_reset" name="form_reset" method="post">
                            <legend class="legendwhite"><span style="padding: 0 5px;"><?=lang('lupa_password')?></span></legend>
                            <div id="form_lupa">
                                <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                                    <label class="control-label"><?=lang('username')?></label><br />
                                    <input type="text" id="emailreset" name="emailreset" placeholder="<?=lang('email')?>"/>
                                </div>
                                <div>
                                    <div style="padding: 0 6px;">
                                        <!--<?php echo form_submit('submit', lang('reset_password'), 'class="btn btnN span2" style="cursor: pointer;"');?>-->
                                        <input type="submit" class="btn btnN ctrl-btn span2" name="reset" id="reset" value="<?=lang('reset_password')?>"/>
                                    </div>
                                </div>
                            </div>
                        </form>
                            <?
                                } else {
                            ?>
                        <form id="form_change" name="form_change" method="post">
                            <legend class="legendwhite"><span style="padding: 0 5px;"><?=lang('ubah_password')?></span></legend>
                            <div id="form_ubah">
                                <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                                    <label class="control-label" for="newpassword"><?=lang('new_password')?> </label>
                                    <div class="controls">
                                        <div style="vertical-align: top;">
                                            <input type="hidden" id="codeforgot" name="codeforgot" value="<?php echo $code_forgot;?>"/>
                                            <input type="hidden" id="emailchange" name="emailchange" value="<?php echo $emails;?>"/>
                                            <input type="password" name="newpassword" id="newpassword" placeholder="<?=lang('new_password')?>" class="input-large "/>
                                        </div>
                                        <div style="vertical-align: top;">
                                            <div id="shortc" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                                <div class="bar bar-danger" style="width: 10%;"></div>
                                            </div>
                                            <div id="weakc" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                                <div class="bar bar-danger" style="width: 33.3%;"></div>
                                            </div>
                                            <div id="goodc" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                                <div class="bar bar-warning" style="width: 66.6%;"></div>
                                            </div>
                                            <div id="strongc" class="progress progress-striped active" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                                <div class="bar bar-success" style="width: 80%;"></div>
                                            </div>
                                            <div id="very-strongc" class="progress" style="width: 80px;height: 12px;margin-top: 5px;display: none;">
                                                <div class="bar bar-success" style="width: 99.9%;"></div>
                                            </div>
                                        </div>
                                        <div id="info_password2" style="font-size: smaller;display: none;">
                                            <?=lang('info_password')?>
                                        </div>
                                    </div>
                                </div>
                                <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                                    <label class="control-label" for="confirm_new_password"><?=lang('confirm_password')?> </label>
                                    <div class="controls">
                                        <input type="password" name="confirm_new_password" id="confirm_new_password" placeholder="<?=lang('confirm_password')?>" class="input-large "/>
                                    </div>
                                </div>
                                <div>
                                    <div style="padding: 0 6px;">
                                        <input type="submit" class="btn btnN ctrl-btn span2" name="change" id="change" value="<?=lang('reset_password')?>"/>
                                    </div>
                                </div>
                            </div>
                            <?
                                }
                            ?>
                            <div style="padding: 0 6px;">
                                <br />
                                <a href="register/back" style="cursor: pointer;"><?=lang('kembali_login')?></a>
                            </div>
                            <?php echo form_close();?>
                    </span>
                <?
                    }
                ?>
                </div>
                <?php
                    if(!empty($vacancyCompany) && !empty($vacancyJob))
                    {
                ?>
                <div class="info">
                    <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                        <p>Anda akan melamar:</p>
                        <ul><li><?php echo $vacancyCompany." - ".$vacancyJob;?></li></ul>
						<br>
						<p>Silakan Daftar terlebih dahulu, atau Login jika telah memiliki account.</p>
                    </div>
                </div>
                <?
                    }
                ?>
            </div>
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