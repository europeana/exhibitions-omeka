<?php
$name = ve_get_exhibit_name_from_slug();
$itemInfo = ve_get_exhibit_item_info_by_tag($name.'-featured', 'archive');
$src = $itemInfo['src'];
$title = $itemInfo['title'];
$exhibit = get_current_exhibit();
unset($_SESSION['themes_uri']);
?>
<?php head(array('bodyid' => 'exhibit', 'bodyclass' => 'summary')); ?>
<?php //head(array('title' => html_escape(ve_title_crumbs()), 'bodyid' => 'exhibit', 'bodyclass' => 'summary')); ?>

	<div id="primary" class="twelve columns">
	    <h1><?php echo html_escape(exhibit('title')); ?></h1>
	</div>
</div>




<!--[if lte IE 7]>

<style type="text/css">

	body{
		/* disable responsive behaviour (limit size to stop layout breaking) */
		min-width:	768px;
		width:	768px;
	}

</style>

<![endif]-->




<div class="row">

    <div class="six columns push-six">
        
        
        <?php set_exhibit_sections_for_loop_by_exhibit(get_current_exhibit()); ?>

        <?php
        // make a flag for the fist page in the section. This is what we want to link to
        $firstpage = false;
        while (loop_exhibit_sections() && $firstpage == false):
            ?>
            <?php if (exhibit_builder_section_has_pages()): ?>
            	<?php $firstpage = true; ?>
            	
            	<?php $themesUrl = exhibit_builder_exhibit_uri(get_current_exhibit(), get_current_exhibit_section()); ?>
            	
            <?php endif; ?>
        <?php endwhile; ?>
        <div id="exhibit-image-wrapper">
        
        
            <div id="exhibit-image-border"></div>
     		<img id="exhibit-shadow" src="">

            <div id="crop-div" style="line-height:0px; font-size:0px;">

            	<?php
            		$imgSrc	= str_replace(".jpg", "_euresponsive_1.jpg",	$src);
            		$imgSrc	= str_replace("/files/", "/euresponsive/",		$imgSrc);
            	?>
            	
            	<?php if(! fopen($imgSrc, "r")): ?>
            			<img src="<?php echo $src ?>"/>
            	<?php endif; ?>
            	
            	<?php if(  fopen($imgSrc, "r")): ?>
            	
            			<script class="euresponsive-script">document.write("<" + "!--")</script>
						<noscript>
            			<img src="<?php echo $imgSrc; ?>"/>
						</noscript -->
            	
            	<?php endif; ?>
            </div>
            
            <script type="text/javascript">

	            var cropDiv = document.getElementById("crop-div");
	            
	            jQuery("#exhibit-image-wrapper").css("visibility", "hidden");
	            
            	// set the correct overlay source
            	var elRef = document.getElementById("exhibit-image-border");
            	var imgUrl = "";
            	if(elRef.currentStyle) {		// IE / Opera
            		imgUrl = elRef.currentStyle.backgroundImage;
           		}
           		else {							// Firefox needs the full css code to work
            		imgUrl = getComputedStyle(elRef,'').getPropertyValue('background-image');
           		}
            	var urlVal = imgUrl.replace(/\"/g, '').replace(/url\(/g, '').replace(/\)/g, '');
            	document.getElementById("exhibit-shadow").src = urlVal; 

				// add resize listener
				function addListener(elm, type, callback) {
					if (elm.addEventListener) {
						elm.addEventListener( type, callback, false );
					}
					else if (elm.attachEvent) {
						elm.attachEvent( 'on' + type, callback );
					}
				}
				
				// define resize function
				var adjustOverlay = function(){
					var shadow  = document.getElementById("exhibit-shadow");
					cropDiv.style.height = shadow.offsetHeight-1 + "px";
		            jQuery("#exhibit-image-wrapper").css("visibility", "visible");
				}
				
				// attach listener
				addListener(window, 'resize', function(){
					adjustOverlay();
				});
				
				addListener(window, 'load', function(){
					adjustOverlay();
				});

				
				(jQuery)(document).ready(function(){
				// invoke to tidy up initial display
					//adjustOverlay();
					
					responsiveGallery({
						scriptClass: 'euresponsive-script',
						testClass: 'euresponsive',
						initialSuffix: '_euresponsive_1.jpg',
						suffixes: {
							'1': '_euresponsive_1.jpg',
							'2': '_euresponsive_2.jpg',
							'3': '_euresponsive_3.jpg',
							'4': '_euresponsive_4.jpg'
						}
					});
				});
				
			</script>
			
 			<div id="exhibit-item-infocus-header">
                <?php
                    try {
                        echo ve_exhibit_builder_exhibit_display_item_info_link(array('imageSize' => 'square_thumbnail'));
                    }
                    catch (Exception $e) {
                        if(get_theme_option('display_admin_errors')){
                            echo '<div class="error">There is no item file (image) associated with the Exhibit Section: <strong>' . $exhibit->title . '</strong>.<br/>'
                            . 'Tag an image used in this exhibit section with: <strong><em>' . ve_get_exhibit_name_from_slug($exhibit) . '-featured</em></strong></div>';
                        }
                    }

                ?>
            </div>
        </div>
        
        
        		
		<div class="row">
			<div id="mobile_shares" class="twelve columns">
				<div class="theme-center-outer">
					<div class="theme-center-middle">
	    	    		<div class="theme-center-inner">
							<?php //echo getAddThisMobile(); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
        
        
    </div>
    
    
    
    
    <div class="six columns pull-six">
         <?php echo exhibit('description'); ?>
		<h3>
			<a class='widget'
				href="<?php echo $themesUrl; ?>">
				
				<!-- 
				 href="<php echo exhibit_builder_exhibit_uri(get_current_exhibit(), get_current_exhibit_section()); >">
				 -->
				
				<?php echo ve_translate('exhibit-start', 'Start Exhibit'); ?><img src="<?php echo img('arrow-right.png');?>"/>
			</a>
		</h3>

        
        
        
    </div>
</div>
<div class="clear"></div>

<?php foot(); ?>

