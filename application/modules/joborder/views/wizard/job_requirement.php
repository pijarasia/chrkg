<?php echo form_open(current_url(), 'class="form-horizontal" id="r_form"')
	.form_input($opening)
	."
<div class='control-group '>
	<label class='control-label' for='from'>From</label>
	<div class='controls'>
        <select name='from_date' id='from_date' style='width: 100px;'>
            <option value=''>Date</option>
            ".option_date($startdate)."
        </select>
        <select name='from_month' id='from_month' style='width: 110px;'>
            <option value=''>Month</option>
            ".option_month($startdate)."
        </select>
        <select name='from_year' id='from_year' class='input-small'>
            <option value=''>Year</option>
            ".option_year($startdate)."
        </select>
    </div>
</div>
	"
	."
<div class='control-group '>
	<label class='control-label' for='to'>To</label>
	<div class='controls'>
        <select name='to_date' id='to_date' style='width: 100px;'>
            <option value=''>Date</option>
            ".option_date($enddate)."
        </select>
        <select name='to_month' id='to_month' style='width: 110px;'>
            <option value=''>Month</option>
            ".option_month($enddate)."
        </select>
        <select name='to_year' id='to_year' class='input-small'>
            <option value=''>Year</option>
            ".option_year($enddate)."
        </select>
    </div>
</div>
	"
	.form_dropdown($minedu,$option['minedu'])
	.form_input($minexe)
	.form_close();
?>