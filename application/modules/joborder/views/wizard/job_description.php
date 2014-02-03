<?php echo form_open(current_url(), 'class="form-horizontal" id="dc_form"')
	.form_input($jobid)
	.form_textarea($description)
	.form_textarea($note)
	.form_input($keywords)
	.form_close();
	?>