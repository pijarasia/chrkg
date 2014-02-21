<div class="span2"></div>
	<div class="forgotarea">
		<span id="logins">
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
		</span>
	</div>