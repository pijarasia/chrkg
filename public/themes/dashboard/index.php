<?php
/**
* @file index.php
* Default layout file.
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
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

<body class="<?php echo $body_classes ?>">
	<!--[if lt IE 7]>
		<p class=chromeframe>Your browser is <em>ancient!</em> <a href="http://browsehappy.com/">Upgrade to a different browser</a> or
		<a href="http://www.google.com/chromeframe/?redirect=true">install Google Chrome Frame</a> to experience this site.</p>
	<![endif]-->
	<noscript>
		<p>Javascript is required to use.</p>
	</noscript>
	<div id="wrapper">
		<!-- Header region -->
		<?php echo theme_view('partials/_header'); ?>
		<div id="content">
			<div class="container">
				<div class="loader" style="display: none;" >
				</div>
				<div class="row">
						<!-- Content -->
						<?php echo Template::yield() ?>
						<!-- Profiler -->
						<div class="pull-right label">
							<i class="icon icon-time icon-white"></i>
							<strong>{elapsed_time}</strong> seconds
						</div>
				</div> <!-- /.row -->
			</div> <!-- /.container -->
		</div>
	<!-- Footer region -->
	<?php echo theme_view('partials/_footer'); ?>
	</div>

</body>
</html>