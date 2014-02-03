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