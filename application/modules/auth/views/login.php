<!DOCTYPE HTML>
<html lang="en-US">
<head>
    <title>Registrasi | Login | Kompas Recruitment</title>
</head>
<body style="background:url(<?php echo base_url();?>public/assets/images/login_bg.jpg);position: absolute;left: 0px;top: 0px;z-index: -1000;width: 1349px;height: 269px;center 0 no-repeat #f1f4f9;">
    <div class="span2"></div>
                <div class="loginarea">
                <?php
                    if ($forgot == false)
                    {
                ?>
                    <span id="logins">
                    <?php
                        if ($this->session->userdata('errorMsg') != "active")
                        {
                    ?>
                        <?php echo form_open("auth/login");?>
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
                        <div style="padding: 0 6px 5px 7px;"><a href="<?php echo base_url(); ?>register/forgot" style="cursor: pointer;"><?=lang('lupa_password')?></a></div>
                    <?php
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
                    <?php
                        }
                    ?>
                    </span>
                <?php
                    }
                    else
                    {
                ?>
                    <span id="forgots">
                        <?php
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
                            <?php
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
                            <?php
                                }
                            ?>
                            <div style="padding: 0 6px;">
                                <br />
                                <a href="register/back" style="cursor: pointer;"><?=lang('kembali_login')?></a>
                            </div>
                            <?php echo form_close();?>
                    </span>
                <?php
                    }
                ?>
                </div>
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