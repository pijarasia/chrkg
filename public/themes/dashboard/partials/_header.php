<div id="topbar">
	<div class="container">
		<div id="top-nav">
			<ul class="pull-right">
				<li><a href="javascript:;"><i class="icon-user"></i> Logged in as <?php echo $this->session->userdata('username');?></a></li>
				<li><a href="/career/register/login_as">Role as <?php echo $this->session->userdata('group_active');?></a></li>
				<li><a href="<?php echo base_url();?>auth/logout">Logout</a></li>

			</ul>
		</div> <!-- /#top-nav -->
	</div> <!-- /.container -->
</div>
<div id="header">
	<?php echo theme_view('partials/_navigation'); ?>
</div>