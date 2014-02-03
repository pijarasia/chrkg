<?php
	echo form_open(current_url(), 'class="form-horizontal" id="o_form"')
	.form_input($exsalarymin)
	.form_input($exsalarymax)
	// .form_dropdown($facilities,$option['facilities'])
	.form_close();
	?>