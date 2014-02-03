<?php
/**
* @file index.php
* Default layout file.
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<!--
	<base href="<?php echo $base ?>"> -->
	<title><?php echo $title ?></title>

	<!-- Metas, viewports, etc. -->
	<?php echo $head ?>

	<!-- Stylesheets -->
	<?php echo Assets::css() ?>

	<!-- Javascripts -->
	<?php echo Assets::js() ?>
	<!-- Messages -->
	<script type="text/javascript">
		$(function(){	
			<?php echo Template::message() ?>
		});
	</script>
</head>

<body>
    <div class="content">
    	<!-- Header region -->
        <?php echo Template::block('block_header_region') ?>
		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</a>
					<a class="brand" href="<?php echo base_url();?>"><img src="<?php echo base_url();?>public/assets/images/img/logo-trans.png" alt="Logo"/></a>
					<div class="nav-collapse collapse">
						<ul class="nav pull-right">
                            <?
                                if (!$this->auth->logged_in())
                                {
                            ?>
                            <li><a href="http://kompasgramedia.com/business">Business</a></li>
                            <li><a href="http://kompasgramedia.com/newsrelease">News Release</a></li>
                            <li><a href="http://kompasgramedia.com/socialcare">Social Care</a></li>
                			<li><a href="http://kompasgramedia.com/events">Events</a></li>
                			<li><a href="http://kompasgramedia.hbcareers.com/">Career</a></li>
                			<li><a href="<?php echo base_url();?>vacancy">Submit CV</a></li>
                			<li><a href="http://kompasgramedia.com/gallery/foto">Gallery</a></li>
                			<li><a href="http://kompasgramedia.com/community">Community</a></li>
                            <li class="sign-up"><a href="<?php echo base_url();?>register"><span class="white"> Log In</span></a></li>                            
                            <?
                                } else {
                            ?>      
                            
                            <li class="sign-up" id="nav-home"><a href="<?php echo base_url();?>"><span class="white"><i class="icon-home"></i></span></a></li>
                            <li>&nbsp;&nbsp;</li>
                            <li class="sign-up"><a href="<?php echo base_url();?>auth/logout"><span class="white">Log Out</span></a></li>
                            <?
                                }
                            ?>                            
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>
		
        <!-- Content -->
        <?php echo Template::yield() ?>
                  
        <!-- Footer region -->
        <?php echo Template::block('block_footer_region') ?>
        
        <!-- Profiler -->
        <div class="pull-right label">
            <i class="icon icon-time icon-white"></i>
            <strong>{elapsed_time}</strong> seconds
        </div>
    </div> <!-- /.content -->
</body>
</html>