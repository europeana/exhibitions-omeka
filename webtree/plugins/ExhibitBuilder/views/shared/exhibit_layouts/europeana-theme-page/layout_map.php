
<style type="text/css">
	#map{
		height:		280px;
		width:		100%;
	}
</style>
	

<div class="row" style="text-align:center;">
	<h1>TEST MAP</h1>
</div>


<div class="row">

	<div class="twelve columns inner">
		<div id="map">
		</div>
	</div>

	
	<script type="text/javascript">
		<?php  
			if (!$exhibit) {
				if (!($exhibit = exhibit_builder_get_current_exhibit())) {
					return;
				}
			}
		
		
		
///////////////////		GET STORIES TO PLOT THEM ONTO THE MAP	//////////////////////////////////////////
			error_log("TITLES: ");
			foreach ($exhibit->Sections as $key => $exhibitSection) {

				error_log("<br/> TITLE: " . $exhibitSection->title );

				/*
				 *  For each story section we need:
				 *  	- point coordinates (to add to model)
				 *  	- link to open
				 *  
				 */
				
				if ($exhibitSection->hasPages()) {

					foreach ($exhibitSection->Pages as $page) {
						
						//error_log("____PAGE: slug = " . $page -> slug . ", title =  "  .  $page -> title  );

						error_log("____LINK_HREF = " . html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection, $page)));
						
					}
				}
				
				
			}
		
//////////////////////////////////////////////////////////////////////////////////////////////////////////
		
		
////////	GET ITEMS THAT HAVE SPECIFIED A MAP LAYER IN THEIR METADATA	////////////////////////////////// 
		
			$mapData = exhibit_map_data($exhibit);
			echo('var mapImg = "' . EUMAP_IMG_DIR . $mapData->img . '";' . PHP_EOL);
			echo('var imageBounds = [[' . $mapData->nw_lon . ', ' . $mapData->nw_lat . '], [' . $mapData->se_lon . ', ' . $mapData->se_lat . ']];' . PHP_EOL);


			$mapMarkerData = exhibit_map_marker_data( $exhibit->slug );
			
			echo('var marker = "' . count($mapMarkerData) . '";'); 
			error_log('var marker = "' . count($mapMarkerData) . '";');
			
			$test = get_items( array( 'tags' =>  ve_get_exhibit_name_from_slug($exhibit)), 0 );

			error_log("TEST SIZE "  .	count($test)  ) ;
			
			set_items_for_loop($test);
			
			while(loop_items()){
				
				$metaTest = getItemTypeMetadataEntry(get_current_item(), "zoomit_enabled");

				error_log("TEST ITEM: " .	$metaTest  );
			}

			
			foreach ($mapMarkerData as $mapMarker) {
				echo('var marker = "' . $mapMarker -> title . '";' . PHP_EOL);
			}
//////////////////////////////////////////////////////////////////////////////////////////////////////////		

		?>
	
		jQuery(document).ready(function(){
			
				var map = L.map('map').setView([51.500, -0.100], 15.4);
				
				L.imageOverlay(mapImg, imageBounds).addTo(map);
				
				L.marker([51.5, -0.09]).addTo(map)
					.bindPopup(
						"<h2>Rome</h2><p>This is a place in Rome, you could add paragraphs of text if you like.</p>"
					);
				
				L.circle([51.5, -0.1], 60, {
							color: 'blue',
							fillColor: 'blue',
							fillOpacity: 0.3
						})
					.addTo(map)
					.bindPopup(
						"<h2>Rome</h2><p>This is a place in Rome, you could add paragraphs of text here if you like.</p>"
					);
				
		});
	
	</script>
	
	
	
</div>
	
<!-- leave row open for footer to close -->