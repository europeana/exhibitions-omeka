<?php
/**
 * File: europeana-section-intro-page
 * Description: The first page in a exhibit
 * Author: Eric van der Meulen, Delving B.V., eric@delving.eu
 */

if (!$page) {
  $page = exhibit_builder_get_current_page();
}
$section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
//$exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
//echo $html;
$theme = $section->title;
$story = $page->title
?>

</div> <!-- end row -->


<!--[if IE 8]>

	<style type="text/css">
		#exhibit-item-thumbnails .exhibit-item {
			float:none !important;	
		}
		#exhibit-item-thumbnails{
			white-space:nowrap;
		}
	</style>
	
	
	<script type="text/javascript">
	
		jQuery(document).ready(function(){
		});

	</script>
<![endif]-->

	
	






<div class="row">
	<div class="six columns push-six">

	<?php if (exhibit_builder_use_exhibit_page_item(1)): ?>

		<div id="exhibit-item-infocus" class="exhibit-item">
			<table id="tbl-exhibit-item">
				<tr>
					<td class="navigate">
						<?php echo ve_exhibit_builder_link_to_previous_exhibit_page("&larr;", array('class' => 'exhibit-text-nav'));?>
					</td>
					<td class="content">
						<div id="exhibit-item-infocus-item" style="text-align:center;">
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
				        </div>
					</td>
					<td class="navigate">
						<?php echo ve_exhibit_builder_link_to_next_exhibit_page("&rarr;", array('class' => 'exhibit-text-nav'));?>
					</td>
				</tr>
				<tr>
					<td class="navigate">
					</td>
					<td>
						<div class="theme-center-outer">		
							<div class="theme-center-middle">		
								<div class="theme-center-inner" style="text-align:center;">
									<br>		
									<?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1'), true, false); ?>
								</div>
							</div>
						</div>
					</td>
					<td class="navigate">
					</td>
				</tr>
			</table>
		</div> <!-- end exhibit item -->
		
		<div class="row"> <!-- embedded row -->
			<div id="mobile_shares" class="twelve columns">
				<div class="theme-center-outer">
					<div class="theme-center-middle">
						<div class="theme-center-inner">
							<?php echo getAddThisMobile(); ?>
						</div>
					</div>
				</div>
			</div>
		</div> <!-- end embedded row -->
		
		
		<?php endif; ?>
	</div> <!-- end six columns -->
	
	<div class="six columns pull-six" id="story">
		<div id="exhibit-section-title">
			<h3>
				<?php echo $theme . ' - ' . $story; ?>
			</h3>
		</div>
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
	</div> <!-- end six columns -->
	
</div> <!-- end row -->

<!--?php //echo( "this is the id...." .  get_current_item()->id ); ?-->

<?php echo js('seadragon-min'); ?>
<?php echo js('story'); ?>


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



<script type="text/javascript">
	jQuery(document).ready(function(){
		var zoomitEnabled = 0;
		if("<?php echo ve_exhibit_builder_is_zoomit_enabled() ?>".length > 0){
			zoomitEnabled = "<?php echo ve_exhibit_builder_is_zoomit_enabled() ?>";
		}
		story.initStory("<?php echo file_display_uri(get_current_item() -> Files[0]); ?>", zoomitEnabled);
	});
</script>	
