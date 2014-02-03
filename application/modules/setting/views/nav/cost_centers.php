<?php echo modules::run('setting/menu'); ?>

<div class="span12 well">
	<button class="btn btn-large pull-right" data-toggle="modal" data-target="#dialog" href="#dialog" id="add" type='button'><i class="icon-money"></i> Create new cost center <i class='icon-plus'></i></button>
</div>

<div class="span12 well">
	<div class="accordion" id="document-data">
	</div>
</div>

<?php echo modules::run('setting/cost_centers_modal'); ?>
