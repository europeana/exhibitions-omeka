<?php
/*
 * SET/GET ALL NECESSARY SESSION VARS
 */
ve_session_vars();

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

    <title><?php echo ve_exhibit_breadcrumbs($pageId = null, $exhibit = null, $section = null, $showAsTitle=true); ?></title>

    <!-- Meta -->
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="description" content="<?php echo settings('description'); ?>"/>
    <?php echo auto_discovery_link_tag(); ?>

    <!-- Plugin Stuff -->
    <?php plugin_header(); ?>

    <!-- Stylesheets -->
    <?php ve_set_exhibits_css();?>


    <script type="text/javascript">var web_root = "<?php echo WEB_ROOT; ?>";</script>
    
    
    <!--BEGIN RESPONSIVE CODE-->
   	<style>
	<?php
		$BREAKPOINTS = explode("~", get_option('euresponsive_breakpoints'));
		for ($i = 0; $i < sizeof($BREAKPOINTS); $i++) {
			$j=$i+1;
			echo (PHP_EOL);
			echo ("        @media all and (min-width: ".$BREAKPOINTS[$i]."px){".PHP_EOL);
			echo ("          .euresponsive {".PHP_EOL);
			echo ("            width: ".$j."px;".PHP_EOL);
			echo ("          }".PHP_EOL);
			echo ("        }".PHP_EOL);
		}
		
	?>
	</style>
	
	<?php echo js('euresponsive'); ?>
	<script type="text/javascript">
		<?php
		if(get_option('euresponsive_zoomit')){
			$IMAGEWIDTHS = explode("~", get_option('euresponsive_imagewidths'));
			echo("var euresponsive_zoomit = " . end($IMAGEWIDTHS) . ";".PHP_EOL);
		}
		else{
			echo("var euresponsive_zoomit = 0;".PHP_EOL);
		}
		?>
	</script>
    <!--END RESPONSIVE CODE-->
    
    
    
    
    <!-- JavaScripts -->
    <?php ve_set_exhibit_js(); ?>
</head>

<body<?php echo isset($bodyid) ? ' id="' . $bodyid . '"' : ''; ?><?php echo isset($bodyclass) ? ' class="' . $bodyclass . '"' : ''; ?>>


<div id="header" class="container">
    <div class="row">
        <div id="site-title" class="three columns">
        
        	<a href="http://www.europeana.eu" target="_blank" id="site-title"><img src="<?php echo img('logo.png'); ?>"></a>
	        
        </div>
        <div id="secondary-branding" class="nine columns">
        
            <?php echo ve_exhibit_secondary_logo(); ?>
            
        </div>
    </div>
</div>

<div class="clear"></div>

<div id="top-navigation"  class="container">
    <div class="row inner">
	    <div id="main-breadcrumbs" class="twelve columns">
	    
	    
	        <!--BEGIN RESPONSIVE CODE-->
		    <div id="site-title-small">
		        <a target="_blank" href="http://www.europeana.eu/">
		            <img src="<?php echo img('logo.png'); ?>"/>
		        </a>
		    </div>	    
	        <!--END RESPONSIVE CODE-->
	        
	         <?php echo ve_exhibit_breadcrumbs(); ?>
	    </div>
	    
     </div>
</div>


<div id="content" class="container">
    <div class="row">
