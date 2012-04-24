<?php head(array('title' => item('Dublin Core', 'Title'), 'bodyid' => 'items', 'bodyclass'=>'exhibit-item-show')); ?>
<?php
  $returnPoint = $_SERVER['HTTP_REFERER'];
  $queryString = '?tags=' . $_GET['tags'] . '&theme=' . $_GET['theme'];
?>



	<div class="twelve columns">
	    <div class="return-nav">
			<div class="" style="float:left;">
				<?php echo ve_return_to_exhbit(); ?>
			</div>
	    </div>
	</div>
	
</div>	<!-- end row -->



<!--[if lte IE 7]>

<style type="text/css">

	body{
		/* disable responsive behaviour (limit size to stop layout breaking) */
		min-width:	768px;
		width:	768px;
	}

	img.tmp-img{
		width:	100%;
		height:	auto;
	}

</style>

<![endif]-->


<div class="row">
	<div class="six columns single-item"  style="margin-bottom:3em;">
	
		<!-- START ITEM -->
	
		<?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>
		
		
		<!-- END ITEM -->
		
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
			<h3><?php echo ve_translate("cite-on-wikipeia", "Cite on Wikipedia"); ?></h3>
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
			if(ve_get_comments_allowed(exhibit_builder_get_current_exhibit()->title)){
				try {
					commenting_echo_comments();
					commenting_echo_comment_form();	
				}
				catch (Exception $e) {
				    echo('Error: ' . $e->getMessage());
				}		
			}
		?>
	</div>
	
</div>



<?php echo js('seadragon-min'); ?>
<?php echo js('story'); ?>


<script type="text/javascript">
alert("item ")
	jQuery(document).ready(function() {
		if(typeof setThemePaths != "undefined"){
			setThemePaths("<?php echo $_GET['theme']; ?>");
		}
		
		var zoomitEnabled = 0;
		if("<?php echo ve_exhibit_builder_is_zoomit_enabled() ?>".length > 0){
			zoomitEnabled = "<?php echo ve_exhibit_builder_is_zoomit_enabled() ?>";
		}
		if(zoomitEnabled){
			story.initStory("<?php echo file_display_uri(get_current_item() -> Files[0]); ?>", zoomitEnabled);
		}
		else{
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
		
	});
</script>

<?php foot(); ?>
