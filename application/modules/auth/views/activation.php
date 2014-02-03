<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Registrasi | Login | Kompas Recruitment</title>
</head>
<body>
    <div class="wrapper">
        <div style="padding: 15px;">
            <div class="row-fluid">
                <div class="span10">
                </div>
                <div class="span2" style="text-align: right;padding-top: 10px;font-size: small;">
                    <a style="color: black;" href="<?php echo $en; ?>">English</a> |
                    <a style="color: black;" href="<?php echo $id; ?>">Bahasa</a>
                </div>
            </div>
        </div>
        <div class="row-fluid" style="z-index: 22;">
            <div id="selected-column-1" class="span4 droppedFields activeDroppable" style="z-index: 23;">
                <legend><?=lang('registrasi')?></legend>
                <form id="form_register" name="form_register" method="post">
                    <div class="control-group droppedField" style="z-index: 24;" id="CTRL-DIV-1003">
                        <label class="control-label" for="nama"><?=lang('nama_lengkap')?> </label>
                        <div class="controls">
                             <!--<div class="input-prepend">
                                <span class="add-on" style="height: 22px;"><i class="icon-user icon-black"></i></span>
                                <input type="text" name="nama" id="nama" placeholder="<?=lang('nama_lengkap')?>" class="input-xlarge "/>
                             </div>-->
                             <input type="text" name="nama" id="nama" placeholder="<?=lang('nama_lengkap')?>" class="input-xlarge "/>
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
                        <input type="submit" class="btn btnN ctrl-btn" name="simpan" id="simpan" value="<?=lang('buat_akun')?>"/>
                    </div>
                </form>
                <div id="message">
                </div>
            </div>
            <div id="selected-column-2" class="span5 droppedFields activeDroppable" style="z-index: 30;">
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
                    <?php echo form_open("register");?>
                    <legend class="legendwhite"><span style="padding: 0 5px;">Login</span></legend>
                    <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                        <label class="control-label"><?=lang('username')?></label>
                        <!--<?php echo form_input($identity);?>-->
                        <input type="text" id="identity" name="identity" value="<?php echo $this->form_validation->set_value('identity');?>" placeholder="<?=lang('username')?>" class="ctrl-textbox pendek"/>
                    </div>
                    <div class="droppedField" style="z-index: 32;" id="CTRL-DIV-1002">
                        <label class="control-label"><?=lang('password')?></label>
                        <!--<?php echo form_input($password);?>-->
                        <input type="password" id="password" name="password" placeholder="<?=lang('password')?>" class="ctrl-textbox pendek"/>
                    </div>
                    <div class="row-fluid" style="text-align: right">
                        <span><?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?><label for="remember" class="help-inline control-label">Remember me!</label></span>
                        <span><?php echo form_submit('submit', 'Masuk', 'class="btn btnN"');?></span>
                    </div>
                    <?php echo form_close();?>
                    <div><a href="auth/forgot_password">Forgot your password?</a></div>
                </div>
                <?php
                    if(!empty($vacancyCompany) && !empty($vacancyJob))
                    {
                ?>
                <div class="info">
                    <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                        <p>Anda akan melamar:</p>
                        <ul><li><?php echo $vacancyCompany." - ".$vacancyJob;?></li></ul>
						<p>Silakan membuat melakukan pendaftaran terlebih dahulu, atau Login jika telah memiliki account.</p>
                    </div>
                </div>
                <?
                    }
                ?>
            </div>
            <!--<div id="selected-column-2" class="span5 droppedFields activeDroppable info" style="z-index: 30;">
                <div class="droppedField" style="z-index: 31;" id="CTRL-DIV-1001">
                    <p>Anda akan melamar:</p>
                    <ul><li>K1J01 - Sistem Analis - Jakarta</li></ul>
                    <p>Anda diarahkan melalui:</p>
                    <ul><li>Twitter</li></ul>
                </div>
            </div>-->
        </div>
        <!-- Action bar - Suited for buttons on form -->
        <div class="row-fluid" style="z-index: 33;">
            <div id="selected-action-column" class="span10 action-bar droppedFields activeDroppable" style="min-height: 80px; z-index: 34;">
            </div>
        </div>
    </div>
</body>
</html>