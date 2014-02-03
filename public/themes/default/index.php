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
<!--</head>-->

<link rel="shortcut icon" href="favicon.png">
<meta name="generator" content="EditPlus">

<meta property="og:type" content="website">
<meta property="og:title" content="Kompas Gramedia">
<meta property="og:site_name" content="Kompas Gramedia">
<meta property="og:url" content="http://kompasgramedia.com/">

<meta name="dcterms.type" content="Text">
<meta name="dcterms.title" content="Kompas Gramedia">
<meta name="dcterms.format" content="text/html">
<meta name="dcterms.identifier" content="http://kompasgramedia.com/career/">

  <title>Kompas Gramedia |</title>

<link type="text/css" rel="stylesheet" href="/resources/css_7l.css" media="all">
<link type="text/css" rel="stylesheet" href="/resources/css_hF.css" media="all">
<link type="text/css" rel="stylesheet" href="/resources/css_te.css" media="all">
<link type="text/css" rel="stylesheet" href="/resources/kompasgramedia_hbcareers_com.css" media="all">

<!--[if lte IE 7]>
<link type="text/css" rel="stylesheet" href="/resources/ie.css" media="all" />
<![endif]-->

<!--[if IE 6]>
<link type="text/css" rel="stylesheet" href="/resources/ie6.css" media="all" />
<![endif]-->
<script id="twitter-wjs" src="/resources/widgets.js"></script>
<script type="text/javascript" async="" src="/resources/ga.js"></script>


</head>
<body class="html front not-logged-in one-sidebar sidebar-second page-node page-node- page-node-1708 node-type-front-page domain-kompasgramedia-hbcareers-com lcr i18n-en featured hboss-czr-logo-iframe-processed jquery-once-1-processed" id="dashboard" data-twttr-rendered="true">
  <div id="skip-link">
    <a href="http://kompasgramedia.hbcareers.com/#main-content" class="element-invisible element-focusable">Skip to main content</a>
  </div>
    <div id="page-wrapper"><div id="page">

  <div id="header-wrapper">
    <div id="header" class="without-secondary-menu">
      <div class="custombackground">
        <div class="section clearfix">
              <a href="/" title="Home" rel="home" id="logo">
          <img src="/resources/logo-trans.png" alt="Home">
        </a>
              <div id="name-and-slogan">
				<div id="site-name" class="element-invisible">
                <strong>
                  <a href="/" title="Home" rel="home"><span>Kompas Gramedia</span></a>
                </strong>
              </div>
        </div> <!-- /#name-and-slogan -->
          </div></div><!-- .section, .custombackground -->
          <div class="section clearfix">
        <div id="main-menu" class="navigation">

          <div class="menu-hack menu-hack-left">&nbsp;</div>
          <ul class="nice-menu nice-menu-down jquery-once-3-processed sf-js-enabled" id="nice-menu-0">
			<li class="menu-3954 menu-path-kompasgramediacom-career first odd"><a href="http://www.kompasgramedia.com/career" title="">ABOUT KG</a></li>
			<li class="menu-3973 menu-path-kompasgramediacom-business even"><a href="http://kompasgramedia.com/business" title="">BUSINESS</a></li>
			<li class="menu-3974 menu-path-kompasgramediacom-newsrelease odd"><a href="http://kompasgramedia.com/newsrelease" title="">NEWS RELEASE</a></li>
			<li class="menu-3975 menu-path-kompasgramediacom-socialcare even"><a href="http://kompasgramedia.com/socialcare" title="">SOCIAL CARE</a></li>
			<li class="menu-3976 menu-path-kompasgramediacom-events odd"><a href="http://kompasgramedia.com/events" title="">EVENTS</a></li>
			<li class="menu-3953 menu-path-front even"><a href="/career/" title="" class="active">CAREER</a></li>
			<li class="menu-3952 menu-path-kompasgramediacom-submitcv odd"><a id="tampil-frame" href="/career/vacancy/" title="">SUBMIT CV</a></li>
			<li class="menu-3977 menu-path-kompasgramediacom-gallery-foto even"><a href="http://kompasgramedia.com/gallery/foto" title="">GALLERY</a></li>
			<li class="menu-3978 menu-path-kompasgramediacom-community odd"><a href="http://kompasgramedia.com/community" title="">COMMUNITY</a></li>
			<li class="menu-3979 menu-path-kompasgramediacom-map even"><a href="http://kompasgramedia.com/map" title="">MAP</a></li>
			<li class="menu-3979 menu-path-kompasgramediacom-map odd last"><a href="/career/login/" title="">LOGIN</a></li>
		</ul>
          <!-- span class="feed-icon"></span -->
          <div class="menu-hack menu-hack-right">&nbsp;</div>
        </div> <!-- /#main-menu -->
      </div>
    </div> <!-- /#header -->
  </div><!-- /.#header-wrapper -->

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