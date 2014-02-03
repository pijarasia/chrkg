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
	<script type="text/javascript">
	$(function(){
		<?php echo Template::message() ?>
	});
	</script>
</head>

<body class="<?php echo $body_classes ?>">
	<div class="container">
	   <div class="row">
            <div class="span12">
                <div>
					<!-- Content -->
					<?php echo Template::yield() ?>

					<!-- Footer region -->
				</div>

                <!-- Profiler -->
                <div class="pull-right label">
					<i class="icon icon-time icon-white"></i>
					<strong>{elapsed_time}</strong> seconds
				</div>
            </div> <!-- /.content -->
			</div> <!-- /.span12 -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->
</body>
</html>