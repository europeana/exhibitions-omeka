<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<?php
		// helper function
		function selfURL(){
			if(!isset($_SERVER['REQUEST_URI'])){
				$serverrequri = $_SERVER['PHP_SELF'];
			}
			else{
				$serverrequri = $_SERVER['REQUEST_URI'];
			}
			$s = empty($_SERVER["HTTPS"]) ? '' : ($_SERVER["HTTPS"] == "on") ? "s" : "";
			$protocol = strleft(strtolower($_SERVER["SERVER_PROTOCOL"]), "/").$s;
			$port = ($_SERVER["SERVER_PORT"] == "80") ? "" : (":".$_SERVER["SERVER_PORT"]);
			return $protocol."://".$_SERVER['SERVER_NAME'].$port.$serverrequri;
		}
		
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>jquery-oembed link replace example</title>
        <meta http-equiv="content-type" content="text/html; charset=utf-8"/>
    	<link rel="alternate" type="application/json+oembed"
    		href="<?php echo(WEB_ROOT); ?>/service/oembed/8?url=<?php urlencode(selfURL);?>;format=json"
    		title="Andy's test title json" />
    	
    	<link rel="alternate" type="text/xml+oembed"
    		href="<?php echo(WEB_ROOT); ?>/service/oembed/8?url=http%3a%2f%2facceptance.exhibit.eanadev.org%2ftrack_embed%2fdownload%2f185&amp;format=xml"
    		title="Andy's test title xml" />

    	
        <?php display_js(); ?>
</head>
<body>

<br>
public/test/index
<br>

<br>
<script type="text/javascript">
        jQuery(document).ready(function(){
        	jQuery("a.oembed").oembed();
        });
</script>

<div><a href="<?php echo(WEB_ROOT); ?>" class="oembed">Europeana</a></div>

<!--
<div><a href="http://www.flickr.com/photos/14516334@N00/345009210/" class="oembed">Flickr Image</a></div>
<div><a href="http://vimeo.com/3108686" class="oembed">Vimeo Video</a></div>
-->




	
</body>
</html>