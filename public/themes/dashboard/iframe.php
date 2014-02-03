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
	<meta charset="utf-8">

	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<meta name="robots" content="noindex" />

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
<body style="background-color: #f5f5f5;">
	<div class="container" style='margin-top:30px;'>
		<div class="row">
			<div class="span12">
				<div class="content">
					<!-- Header region -->
					<!--<?php echo Template::block('block_header_region') ?>-->

					<!-- Content -->
					<?php echo Template::yield() ?>

					<!-- Footer region -->
					<!--<?php echo Template::block('block_footer_region') ?>-->

					<!-- Profiler -->
                    <!--Tutup Gita 25 Agustus 2013-->
					<!--<div class="pull-right label">
						<i class="icon icon-time icon-white"></i>
						<strong>{elapsed_time}</strong> seconds
					</div>-->
				</div> <!-- /.content -->

			</div> <!-- /.span12 -->
		</div> <!-- /.row -->
	</div> <!-- /.container -->

</body>
<!-- Javascripts -->
<?php echo Assets::js() ?>
</html>