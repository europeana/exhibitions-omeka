<?php
 //*************************************************************************************************************************
//Name: gallery-artnouveau-section-page
//Description: An image gallery, with text on the left and, on the right, one large image with a thumbnail gallery below it.
//Author: Eric van der Meulen, eric.meulen@gmail.com;
//*************************************************************************************************************************
if (!$page) {
    $page = exhibit_builder_get_current_page();
}
$section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
$exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
$theme = $section->title;
$story = $page->title
?>

<link rel="stylesheet" href="<?php echo css('mediaelement/mediaelementplayer'); ?>"/>
<link rel="stylesheet" href="<?php echo css('mediaelement/mejs-skins'); ?>"/>


    <div id="exhibit-section-title">
        <h3>
            <?php echo $theme . ' - ' . $story; ?>
        </h3>
    </div>
</div> <!-- end row -->



<div class="row">

	<div class="six columns push-six" id="story">
		
		<?php if (exhibit_builder_use_exhibit_page_item(1)): ?>
		
		
		<div id="exhibit-item-infocus" class="exhibit-item">
			<table id="tbl-exhibit-item"> <!-- yes, a table! -->
				<tr>
					<td class="navigate">
						<?php echo ve_exhibit_builder_link_to_previous_exhibit_page("&larr;", array('class' => 'exhibit-text-nav'));?>
					</td>
					<td class="content">
						<div id="exhibit-item-infocus-item">
			
							<div class="theme-center-outer">		
								<div class="theme-center-middle">		
									<div class="theme-center-inner">		

										<div id="exhibit-item-infocus-header">
											<?php echo ve_exhibit_builder_exhibit_display_item_info_link(array('imageSize' => 'fullsize')); ?>
										</div>
										
										<?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1'), false, true); ?>

									</div>
								</div>
							</div>
			
							<!-- long titles can break the layout (by moving the info link out of the image) so displayed separately -->
			
							<div class="theme-center-outer">		
								<div class="theme-center-middle">		
									<div class="theme-center-inner">		
										<?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1'), true, false); ?>
									</div>
								</div>
							</div>
			
						</div>
					</td>
					<td class="navigate">
						<?php echo ve_exhibit_builder_link_to_next_exhibit_page("&rarr;", array('class' => 'exhibit-text-nav'));?>
					</td>
				</tr>
			</table>
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
		
		<?php endif; ?>
    
		<div class="clear"></div>
		<div class="theme-center-outer">		
			<div class="theme-center-middle">		
				<div class="theme-center-inner">		
		
					<div id="exhibit-item-thumbnails">
						<?php echo ve_exhibit_builder_display_exhibit_thumbnail_gallery(1, 5, array('class' => 'thumb')); ?>
					</div>
				</div>
			</div>
		</div>
					
	</div>

    
	<div class="six columns pull-six" id="items">
		<div class="exhibit-text">
			<div id="exhibit-section-title-small">
				<h3>
					<?php echo $theme . ' - ' . $story; ?>
				</h3>
			</div>

			<?php if ($text = exhibit_builder_page_text(1)) {
				echo exhibit_builder_page_text(1);
			} ?>
		</div>

		<div class="theme-center-outer">
			<div class="theme-center-middle">
				<div class="theme-center-inner">
					<div class="exhibit-page-nav">
						<?php echo ve_exhibit_builder_link_to_previous_exhibit_page("&larr;", array('class' => 'exhibit-text-nav'));?>
						<?php echo ve_exhibit_builder_page_nav(); ?>
						<?php echo ve_exhibit_builder_link_to_next_exhibit_page("&rarr;", array('class' => 'exhibit-text-nav'));?>
					</div>
				</div>
			</div>
		</div>

	</div>
	
	
<?php echo js('seadragon-min'); ?>
<?php echo js('story'); ?>



<div class="row">
	<div class="twelve columns">
		<?php
			//echo "plugins/ExhibitBuilder/views/shared/exhibit_layouts/europeana-section-intro-page/layout.php";
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



<script type="text/javascript">
	// TODO: check europeana object property
	jQuery(document).ready(function(){
		
		var zoomitEnabled = "<?php echo ve_exhibit_builder_is_zoomit_enabled() ?>";
		zoomitEnabled = true;
		//zoomitEnabled = false;
		
//		if(zoomitEnabled){
			story.initStory("<?php echo file_display_uri(get_current_item() -> Files[0]); ?>", zoomitEnabled);
	//	}
		//else{
			// responsive image is being shown
		//	jQuery("#media_wrapper img.full").removeClass("tmp-img");
	//	}
	});
</script>

