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
		
		<!--style>
			#in-focus {
			  xxxxmax-width: 100% !important;
			  
			  width: auto !important; /* remove 100% rule from responsive.css */ 
			}
			#in-focus img {
			  max-width: 100% !important;
			  
			  xxxxwidth: auto !important; /* remove 100% rule from responsive.css */ 
			}
		</style-->
		
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

										<div style="float:left; position:relative; max-width:100%;">
																
											<div id="exhibit-item-infocus-header">
												<?php echo ve_exhibit_builder_exhibit_display_item_info_link(array('imageSize' => 'fullsize')); ?>
											</div>
											
											<?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1'), false, true); ?>
								            <!--ve_exhibit_builder_exhibit_display_item_responsively(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1'));-->
								            
				            			</div>
				            			
				            			
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

		
		
		
		<?php endif; ?>
    
		<div class="clear"></div>
		<div id="exhibit-item-thumbnails">
			<?php echo ve_exhibit_builder_display_exhibit_thumbnail_gallery(1, 5, array('class' => 'thumb')); ?>
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

<?php
/*
try {
	echo("RECORD ID = " . $_POST['record_id']);
	commenting_echo_comments();
	commenting_echo_comment_form();
	
} catch (Exception $e) {
    echo('Error: ' . $e->getMessage());
}
*/	
?>
<script>
    var viewer = new Seadragon.Viewer("div#zoomit-container");
    viewer.openDzi("logo.dzi");
</script>


<script type="text/javascript">
//alert("layout\n(plugins ExhibitBuilder views shared exhibit_layouts europeana-story-section)\n\n try to make gallery");
var suffixes = {
	<?php
		//$BREAKPOINTS = explode("~", get_option('euresponsive_breakpoints'));
		$IMAGEWIDTHS = explode("~", get_option('euresponsive_imagewidths'));
		for ($i = 0; $i < sizeof($IMAGEWIDTHS); $i++) {
			$j = $i+1;
			if($IMAGEWIDTHS[$i]>-1){
			  echo "'".$j."': '_euresponsive_".$j.".jpg'";
			}
			else{
			  echo "'".$j."': 'z'".PHP_EOL;
			}
			if($j<sizeof($IMAGEWIDTHS)){
			 	echo ",";
			}
			echo PHP_EOL;

		}
	?>
};
responsiveGallery({
	scriptClass:	'dirty-script',
	testClass:		'euresponsive-width',
	initialSuffix:	'_euresponsive_1.jpg',
	suffixes :		suffixes
});

</script>