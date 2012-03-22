<?php
/*
 * SET/CHECK LANGUAGE
 */
if (isset($_COOKIE["ve_lang"]))
  $_SESSION[$lang] = $_COOKIE["ve_lang"];
else
  $_SESSION[$lang] = "en";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo settings('site_title'); echo $title ? ' | ' . $title : ''; ?></title>

<!-- Meta -->
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="<?php echo settings('description'); ?>" />

<?php echo auto_discovery_link_tag(); ?>

<!-- Stylesheets -->
<!--<link rel="stylesheet" media="screen" href="--><?php //echo html_escape(css('screen')); ?><!--" />-->
<!--<link rel="stylesheet" media="print" href="--><?php //echo html_escape(css('print')); ?><!--" />-->
    <link rel="stylesheet" media="screen" href="<?php echo html_escape(css('reset-text-grid')); ?>" />
    <link rel="stylesheet" media="screen" href="<?php echo html_escape(css('colors')); ?>" />
     <link rel="stylesheet" media="screen" href="<?php echo html_escape(css('fancybox/jquery.fancybox-1.3.1')); ?>" />
    <link rel="stylesheet" media="screen" href="<?php echo html_escape(css('style')); ?>" />

<!-- JavaScripts -->
<?php
    echo js('jquery');
    echo js('jquery.cookie');
    echo js('jquery.fancybox-1.3.1.pack');
    echo js('art-nouveau-scripts');
//    echo js('euresponsive');
?>

<style type="text/css">
/* IE */

#fancybox-loading.fancybox-ie div	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_loading.png");?>', sizingMethod='scale'); }
.fancybox-ie #fancybox-close		{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_close.png");?>', sizingMethod='scale'); }

.fancybox-ie #fancybox-title-over	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_title_over.png");?>', sizingMethod='scale'); zoom: 1; }
.fancybox-ie #fancybox-title-left	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_title_left.png");?>', sizingMethod='scale'); }
.fancybox-ie #fancybox-title-main	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_title_main.png");?>', sizingMethod='scale'); }
.fancybox-ie #fancybox-title-right	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_title_right.png");?>', sizingMethod='scale'); }

.fancybox-ie #fancybox-left-ico		{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_nav_left.png");?>', sizingMethod='scale'); }
.fancybox-ie #fancybox-right-ico	{ background: transparent; filter: progid:DXImageTransform.Microsoft.AlphaImageLoader(src='<?php echo uri("themes/europeana/css/fancybox/fancy_nav_right.png");?>', sizingMethod='scale'); }

.fancybox-ie .fancy-bg { background: transparent !important; }
</style>
<!-- Plugin Stuff -->
<?php echo plugin_header(); ?>

</head>
<body<?php echo $bodyid ? ' id="'.$bodyid.'"' : ''; ?><?php echo $bodyclass ? ' class="'.$bodyclass.'"' : ''; ?>>

<div class="container container_16">

	<div id="header" class="grid_16">

		<div id="site-title" class="grid_12 alpha">
            <a href="http://www.europeana.eu"><img src="<?php echo img('logo.png'); ?>"></a>
            <?php //echo link_to_home_page(); ?>
        </div>

        <div id="exhibit-title" class="grid_4 omega">
            <img src="<?php echo img('an-header-title.png'); ?>" alt="Art Nouvea Virtual Exhibition">
        </div>

	</div><!-- end header -->

    <div class="clear"></div>

    <div id="content">