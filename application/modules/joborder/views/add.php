<div class='content-inner well'>
<div class="page-header">
</div>
<?php echo form_open(current_url(), 'class="form-horizontal" id="a_form"')
	.form_input($name)
	.form_dropdown($ba,$option['business_area']);
	if(!empty($refid)){
		echo form_dropdown_assisted($company,$option['company'],$refid);
	}else{
		echo form_dropdown($company,$option['company']);
	}
	echo form_input($owner)
	.form_dropdown($country,$option['country'])
	.form_dropdown($province,$option['province'])
	.form_textarea($address)
	.form_input($city)
	.form_input($zipcode)
	.'<div class="control-group ">
		<div class="controls">'
	.form_submit('submit', 'Create Joborder', 'class="btn-small btn-primary"')
	.'</div></div>'
	.form_close();
	?>
</div>