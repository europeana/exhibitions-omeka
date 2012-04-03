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
<link rel="stylesheet" href="<?php echo css('mediaelement/mediaelementplayer'); ?>"/>
<link rel="stylesheet" href="<?php echo css('mediaelement/mejs-skins'); ?>"/>

		
<div class="row">
	<div class="six columns push-six">
	
	
		<!-- style>
			#in-focus {
			  xxxxmax-width: 100% !important;
			  
			  xxxwidth: auto !important; /* remove 100% rule from responsive.css */ 
			}
			#in-focus img {
			  max-width: 100% !important;
			  
			  xxxxwidth: auto !important; /* remove 100% rule from responsive.css */ 
			}
		</style-->
	
		
	    <?php if (exhibit_builder_use_exhibit_page_item(1)): ?>

	    <div id="exhibit-item-infocus" class="exhibit-item">
	    	<table id="tbl-exhibit-item">
	        	<tr>
	        		<td class="navigate">
						<?php echo ve_exhibit_builder_link_to_previous_exhibit_page("&larr;", array('class' => 'exhibit-text-nav'));?>
					</td>
					
					<td class="content">
				        
				        <div id="exhibit-item-infocus-item" style="text-align:center;">
				        
							<div class="theme-center-outer" andy="section-intro">		
								<div class="theme-center-middle">		
									<div class="theme-center-inner">
				        

																		
									        <div id="exhibit-item-infocus-header">
									            <?php echo ve_exhibit_builder_exhibit_display_item_info_link(array('imageSize' => 'fullsize')); ?>
									        </div>
				
											<script type="text/javascript">
											  window.imgUrl = "<?php echo file_display_uri(get_current_item() -> Files[0]); ?>";
											</script>
				
								            <?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1'), false, true); ?>
								            <?php //echo ve_exhibit_builder_exhibit_display_item_responsively(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>


								            							            
							            
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
	</div>
	
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


	</div>
	
</div>

</div>

<div class="row">


<?php echo js('seadragon-min'); ?>
<?php echo js('story'); ?>


	<div class="twelve columns">
		<?php
			echo "plugins/ExhibitBuilder/views/shared/exhibit_layouts/europeana-section-intro-page/layout.php";
			try {
				commenting_echo_comments();
				commenting_echo_comment_form();	
			}
			catch (Exception $e) {
			    echo('Error: ' . $e->getMessage());
			}		
		?>
	</div>
	
		
	<!-- script type="text/javascript">
		// fix for disappearing styling bug following comment submission.
		var pathField = jQuery("#path");
		function endsWith(str, suffix) {
		    return str.indexOf(suffix, str.length - suffix.length) !== -1;
		}
		if(endsWith(pathField.val(), "/introduction")){
			var newPath = pathField.val().substr(0, pathField.val().length-("/introduction").length);
			pathField.val(newPath);
		}
		
	//	alert( endsWith(pathField.val(), "/introduction") );
	//	var themeParams = window.document.location.href;
	//	themeParams = themeParams.substr(themeParams.indexOf("?"), themeParams.length);
	//	pathField.val(pathField.val() + themeParams);
	</script-->
		
</div>


<script type="text/javascript">

	jQuery(document).ready(function(){
		initZoomit();
	});

</script>	
