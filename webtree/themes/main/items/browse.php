<?php head(array('title' => 'Browse Items', 'bodyid' => 'items', 'bodyclass' => 'browse')); ?>

<?php
  $queryString = '?tags=' . $_GET['tags'] . '&theme=' . $_GET['theme']; 
?>


	<div class="twelve columns">
	    <div class="return-nav">
	        <?php echo ve_return_to_exhbit($queryString); ?>
	    </div>
	    
	    <p class="h1simulate styled-text">
	        <?php echo ve_translate('items-browse', 'Browse Items');?>
	        (<?php echo total_results(); ?> <?php echo ve_translate('items-total', 'total');?>)
	    </p>
	</div>
</div>

<!--[if lte IE 7]>

<style type="text/css">
	body{
		/* disable responsive behaviour (limit size to stop layout breaking) */
		min-width:	768px;
	}
	
	.six{
		max-width:	45%;
	}
	
	.browsed-item-wrapper a img{
		width:		100%;
		width: 		auto\9; /* ie8 */
		max-width:	100%;	
	}

	ul.block-grid{
		width:	100% !important;
		margin-left:0px;
	}

	.block-grid.two-up, .block-grid.two-up > li{
		margin-left:	0px;
	}

</style>

<![endif]-->



<div class="row">
    <div class="twelve columns">
	    <div id="pagination-top" class="pagination">
	    	<?php echo pagination_links(); ?>
	    </div>
	</div>
</div>




<!-- START REWORK -->
<!--
{
	"contextmenu" : "buildings",
	"featured": false,
	"img": "splash/img/tel_img11.jpg",
	"name": "Buildings",
	"label":"Open partner exhibition"
	"menu":{
		"label" : "Share on...",
		"icon": "splash/img/share_icon.gif",
		"items":[
		         {	"label": "Twitter",
		        	"icon": "splash/img/twitter_icon.gif",
		        	"goto": "//twitter.com/intent/tweet?text=Buildings: http://www.theeuropeanlibrary.org/exhibition/buildings/index.html"
		         },
		         {
		        	 "label": "Facebook",
		        	 "icon": "splash/img/facebook_icon.gif",
		        	 "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/buildings/index.html"
		        }
		        ]
			}
};

-->
<br/>
<br/>



<?php
	$data = array();
?>

<?php while (loop_items()){ // construct json data
	
	$item = get_current_item();
	$file = $item->Files[0];
	$json = "";
	
	if(!is_null($file)){

		$name = preg_replace('/&quot;/', "\"", item('Dublin Core', 'Title'));	// handle html quotes by making them normal quotes
		$name = preg_replace('/\"/', "\\\"", $name );							// handle normal quotes by escaping them with a backslash	
		$json .= "{";
		$json .= '"contextmenu" : "' . $name . '",';
		$json .= '"overlay": "splash/logos/logo-white.png",';		// or black or none
		$json .= '"featured": false,';
		
		if (item_has_thumbnail()){
			$json .= '"img": "' . WEB_ROOT . '/archive/square_thumbnails/' . $file->getDerivativeFilename() . '",';
		}
		else{
   			$mime = $file->getMimeType();
   			
   			if(!is_null($mime)){
      			if (preg_match("/^application/", $mime)){
      				$json .= '"img": "' . img('icon-pdf.png') . '", ';
      			}
      			elseif (preg_match("/^video/", $mime)){
      				$json .= '"img": "' . img('icon-video.png') . '", ';
      			}
      			elseif (preg_match("/^audio/", $mime)){
      				$json .= '"img": "' . img('icon-audio.png') . '", ';
      			}
   			}
		}
		$json .= '"name":"' . $name . '"';
		$json .= '}'; // close json item
		$data[] = $json;
	} 
} ?>

<?php
		/*
	$res = join($data, ",");
	echo('[' . $res . ']');
	echo('<script type="text/javascript">');
	echo('var splashData = [' . $res . '];');
	echo('</script>');
		*/
?>


<!-- END REWORK -->


<script type="text/javascript">
	jQuery(document).ready(function(){
		//alert(typeof eu_europeana_mortar);
		//eu_europeana_mortar.init(splashData, "#splash_here");
	});
</script>





<div class="row" id="splash_here">
    <div class="six columns">
    	<ul class="block-grid two-up">
    	
        <?php $count = 0?>
	    <?php while (loop_items()): ?>
	    
	        <?php if($count>0):?>
	        
		        <?php if($count%4==0):?>
		        
		        				</ul>		<!-- close ul-->
		        			</div>			<!-- close six columns-->
		        		</div>				<!-- close row -->
		        		<div class="row">
		        			<div class="six columns">
		        				<ul class="block-grid two-up">
					    
	        	<?php elseif($count%2==0):?>
	        	
	        					</ul>		<!-- close ul-->
	        				</div>			<!-- close six columns-->
		        			<div class="six columns">
		        				<ul class="block-grid two-up">
					    
		        <?php endif; ?>
		         
	        <?php endif; ?>
	        
		    <?php $count++; ?>

			<li class="browsed-item-wrapper meta">
		        <?php if (item_has_thumbnail()): ?>
		            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>">
		                <?php echo item_square_thumbnail(array('alt'=>item('Dublin Core', 'Title'))); ?>
		            </a>
	        	<?php else:?>
	        		<?php
	        			$item = get_current_item();
	        		
	        			if(!is_null($item)){
	        				
	        				$file = $item->Files[0];
	        				
	        				if(!is_null($file)){
	        					
	    	        			$mime = $file->getMimeType();
	    	        			if(!is_null($mime)){
	    		        			if (preg_match("/^application/", $mime)){
	    		        				echo '<a href="' . uri('items/show') . '/' . item('id') . $queryString . '" ><img alt="view pdf" class="icon-pdf" src="' . img('icon-pdf.png') . '"/></a>';
	    		        			}
	    		        			elseif (preg_match("/^video/", $mime)){
	    		        				echo '<a href="' . uri('items/show') . '/' . item('id') . $queryString . '" ><img alt="view video" class="icon-vid" src="' . img('icon-video.png') . '"/></a>';
	    		        			}
	    		        			elseif (preg_match("/^audio/", $mime)){
	    		        				echo '<a href="' . uri('items/show') . '/' . item('id') . $queryString . '" ><img alt="listen to audio" class="icon-audio" src="' . img('icon-audio.png') . '"/></a>';
	    		        			}
	    	        			}
	        				}
	        			}
	        			 
	        		?>
	        		
		        <?php endif; ?>
		        <?php echo plugin_append_to_items_browse_each(); ?>

		        <h2>
		            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>"><?php echo item('Dublin Core', 'Title');?></a>
		        </h2>
			</li>
			
	    <?php endwhile; ?>
	</div>
</div>
		
<div class="row">
	<div id="mobile_shares" class="twelve columns">
		<div class="theme-center-outer">
			<div class="theme-center-middle">
   	    		<div class="theme-center-inner">
					<?php echo getAddThisMobile(); ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="twelve columns">
	    <div id="pagination-bottom" class="pagination">
	        <?php echo pagination_links(); ?>
	    </div>
	    <?php echo plugin_append_to_items_browse(); ?>
	</div>
</div>


<?php foot(); ?>



