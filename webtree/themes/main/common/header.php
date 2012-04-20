<?php
/*
 * SET/GET ALL NECESSARY SESSION VARS
 */
ve_session_vars();

?>

<!doctype html>
	<head>
	<meta charset="utf-8" />
	<title>Europeana - Exhibitions</title>
	
	
	<meta http-equiv="X-UA-Compatible" value="IE=9">
	
	<meta name="description" content="Europeana Exhibitions, a place for Europeana and their partners to showcase their exhibitions.">
	<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
	<meta name="author" content="Dean Birkett">
	<meta name="author" content="Andy MacLean">


<?php
	$pageURL = "http://".$_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
?>



<?php if ($pageURL == WEB_ROOT."/"): ?>

	<!--
		Splash page body comes from SimplePages, which wraps everything in a div with the id "primary".
		Here we open the body tag and leave the simple page to write the rest.
	-->
	
	<!--[if lt IE 9]><script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script><![endif]-->	
	
	<link rel="stylesheet" href="splash/css/style.css" />
	<!--[if IE 7]><link rel="stylesheet" type="text/css" href="splash/css/ie7.css" /><![endif]-->
	<!-- wut no JS? -->
	 
	<noscript><style>
	 
	/* Below are messy fixes to place the language links. I did it this way as I couldn't get Isotope to cleanly place multiple links */
	/* Languages */
	p.language-en-main{
		left: 0.5em;
		bottom: 2.5em;
	}

	p.language-ru-main{
		left: 4em;
		bottom: 2.5em;
	}

	/* Language - English */
	p.language-en{
		left: 0.5em;
		bottom: 2.5em;
		display: block;
	}

	/* Language - Dada */
	p.language-en-dada{
		left: 0.5em;
		bottom: 3.5em;
		display: block;
	}

	p.language-fr-dada{
		left: 4em;
		bottom: 3.5em;
		display: block;
	}

	p.language-de-dada{
		left: 8em;
		bottom: 3.5em;
		display: block;
	}

	p.language-es-dada{
		left: 0.5em;
		bottom: 2em;
		display: block;
	}

	p.language-nl-dada{
		left: 4em;
		bottom: 2em;
		display: block;
	}

	/* Language - MIMO */

	p.language-it-music{
		left: 0.5em;
		bottom: 2em;
		display: block;
	}

	p.language-sv-music{
		left: 9em;
		bottom: 2em;
		display: block;
	}

	/* Language - Art Nouveau */

	p.language-pl-artnouveau
	{
		left: 8em;
		bottom: 3.5em;
		display: block;
	}

	p.language-lv-artnouveau{
		left: 9em;
		bottom: 2em;
		display: block;
	}

	/* Links to external partners pages */

	p.partner-site{
		left: 0.5em;
		bottom: 2.5em;
		display: block;
		width: 90%;
	}

	/* Exhibition name */

	.element .name {
		bottom: 3.5em;
	}

	a{
		background: #000;
	} /* Background colour changed to make all links have a black background */
	 
	</style></noscript>
	 
		<!-- scripts at bottom of page (see Simple Page) -->

	</head>
	<body>


<?php else: ?>

	<!--DEFAULT HEAD / BODY-->
		
	<html lang="en" xmlns="http://www.w3.org/1999/xhtml" xmlns:fb="http://www.facebook.com/2008/fbml">
	<head>
	    <title><?php echo ve_exhibit_breadcrumbs($pageId = null, $exhibit = null, $section = null, $showAsTitle=true); ?></title>

	    <!-- Meta -->
	    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=5"/>
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

			// ipad fix
			if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
			    var viewportmeta = document.querySelector('meta[name="viewport"]');
			    if (viewportmeta) {
			        viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
			        document.body.addEventListener('gesturestart', function () {
			            viewportmeta.content = 'width=device-width, minimum-scale=0.25, maximum-scale=1.6';
			        }, false);
			    }
			}

		</script>
	    <!--END RESPONSIVE CODE-->
	    
	    
	    
	    
	    <!-- JavaScripts -->
	    <?php ve_set_exhibit_js(); ?>
	</head>

	<body<?php echo isset($bodyid) ? ' id="' . $bodyid . '"' : ''; ?><?php echo isset($bodyclass) ? ' class="' . $bodyclass . '"' : ''; ?>>
	
	<div class="container">
	    <div id="header" class="row">
	        <div class="twelve columns">
	        	<div id="site-title" class="twelve columns">
					<a href="http://www.europeana.eu" target="_blank" xxxxid="site-title"><img src="<?php echo img('logo.png'); ?>"></a>
	        	</div>
	        	
		        <div id="secondary-branding" style="float:right;">
		            <?php echo ve_exhibit_secondary_logo(); ?>
		        </div>
	        	
	        </div>
	    </div>
	
	    
		<div id="top-navigation" class="row">
		    <div id="main-breadcrumbs" class="twelve columns inner">
		    
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
	
		<div id="content" class="row" andy="header file ends here">

<?php endif; ?>

