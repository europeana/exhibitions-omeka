<?php head(array('title' => item('Dublin Core', 'Title'), 'bodyid' => 'items', 'bodyclass'=>'exhibit-item-show')); ?>
<?php
  $returnPoint = $_SERVER['HTTP_REFERER'];
  $queryString = '?tags=' . $_GET['tags'] . '&theme=' . $_GET['theme'];
?>

<!-- <div class="row"> opened in header.... -->

	<div class="twelve columns">
	    <div class="return-nav">
			<div class="" style="float:left;">
				<?php echo ve_return_to_exhbit(); ?>
			</div>
		
			<?php if($returnPoint): ?>
				<div style="float:right;">
					<a class="widget" href="<?php echo uri('items/browse') . $queryString; ?>">
						<span class="icon arrow left"></span>
						<?php echo ve_translate('back', 'Back');?>
					</a>
				</div>
			<?php endif; ?>
	
		</div>
	</div>
</div>	<!-- end row -->


<div class="row">

	<div class="six columns single-item"  style="margin-bottom:3em;">
	
	
    <?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>

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
	</div>
    
    <div class="six columns" style="margin-bottom:3em;">
        <?php echo ve_custom_show_item_metadata(array('show_empty_elements' => false, 'return_type' => 'html')); ?>
    </div>
</div>



<div class="row">
	<div class="six columns push-six">
		<div class="wiki-citation">
			<h2><?php echo ve_translate("cite-on-wikipeia", "Cite on Wikipedia"); ?></h2>
			<?php
				try {
					wikicite_for_item();
				}
				catch (Exception $e) {
				    echo('Error: ' . $e->getMessage());
				}		
			?>
		</div>
	
		<?php echo ve_custom_show_embed(); ?>    
	</div>
	
	<div class="six columns pull-six">
		<?php
			try {
				commenting_echo_comments();
				commenting_echo_comment_form();	
			}
			catch (Exception $e) {
			    echo('Error: ' . $e->getMessage());
			}		
		?>
	</div>
</div>




<!--
<div class="row">
	<div class="twelve columns">
		<?php
			try {
				commenting_echo_comments();
				commenting_echo_comment_form();	
			}
			catch (Exception $e) {
			    echo('Error: ' . $e->getMessage());
			}		
		?>
	</div>
</div>
-->

<script type="text/javascript">
	// fix for disappearing styling bug following comment submission. 
	var pathField = jQuery("#path");
	var themeParams = window.document.location.href;
	themeParams = themeParams.substr(themeParams.indexOf("?"), themeParams.length);
	pathField.val(pathField.val() + themeParams);
</script>




<?php echo js('seadragon-min'); ?>
<?php echo js('story'); ?>

<script type="text/javascript">

	jQuery(document).ready(function() {
		
		if(typeof setThemePaths != "undefined"){
			setThemePaths("<?php echo $_GET['theme']; ?>");
		}

		var zoomitEnabled = 0;
		var isMedia		  = 0;
		if("<?php echo ve_exhibit_builder_is_zoomit_enabled() ?>".length > 0){
			zoomitEnabled = "<?php echo ve_exhibit_builder_is_zoomit_enabled() ?>";
		}
		if(zoomitEnabled){
			story.initStory("<?php echo file_display_uri(get_current_item() -> Files[0]); ?>", zoomitEnabled);
		}
		else{
			if(jQuery('audio, video').length == 0){ // this code breaks media-element, so we don't run the two together
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
			}
		}

	});
	
</script>


<?php foot(); ?>

