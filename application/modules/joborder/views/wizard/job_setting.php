<?php echo form_open(current_url(), 'class="form-horizontal" id="s_form"')
	.form_dropdown($type, $option['employment_type'])
	.form_dropdown_multiple($step, $option['selection_step'])
	.form_dropdown($status, $option['jobprocess_flow'])
	.form_dropdown($priority, $option['priority'])
	.form_close();
	?>