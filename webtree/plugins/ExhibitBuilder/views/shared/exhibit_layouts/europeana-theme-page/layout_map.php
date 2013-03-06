
<style type="text/css">

	#map{
		height:		380px;
		width:		100%;
	}
	
	.slider {
		margin:			1em 0;
		width:			100%;
		border-width:	2px;
	}
	
</style>
	

<div class="row" style="text-align:center;">
	<h1>TEST MAP</h1>
</div>


<div class="row">

	<div id="map_container" class="twelve columns inner">
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
		
			/*
			 * Get map data, starting with the basic latitude and longitude
			 * 
			 *  - (for Rome this is  41.89007, 12.49188)
			 * 
			 * */
			
			$map = exhibit_map_data($exhibit);
			
			echo('var mapLatitude	= ' . $map->lat . ';' . PHP_EOL);
			echo('var mapLongitude	= ' . $map->lon . ';' . PHP_EOL);
			
			/* 
			 * Get overlay data from item metadata & write to json object:
			 * 
			 * See new meta fields:
			 * 		NW Latitude			(41.914)
			 * 		NW Longitude		(12.447)
			 * 		SE Latitude			(41.874)
			 * 		SE Longitude		(12.5135)
			 * 
			 * Note: map items have to be public or the map won't show!
			 * 
			 */
			
			echo('var mapOverlays = [];' . PHP_EOL);
			
			$items = get_items( array( 'tags' =>  ve_get_exhibit_name_from_slug($exhibit)), 0 );
			set_items_for_loop( $items );
			
			while(loop_items()){
				$current	= get_current_item();
				$nwLat		= getItemTypeMetadataEntry($current, "NW Latitude");
				$nwLon		= getItemTypeMetadataEntry($current, "NW Longitude");
				$seLat		= getItemTypeMetadataEntry($current, "SE Latitude");
				$seLon		= getItemTypeMetadataEntry($current, "SE Longitude");
				
				if( strlen($nwLat) > 0 && strlen($nwLon) > 0 && strlen($seLat) > 0 && strlen($seLon) > 0){
					$uri = str_replace("/fullsize/", "/files/", file_display_uri($current->Files[0]));
					echo('mapOverlays[mapOverlays.length] = {"nwLat":"' . $nwLat . '", "nwLon":"' . $nwLon . '", "seLat":"' . $seLat . '", "seLon":"' . $seLon . '", "uri":"' . $uri . '" };' . PHP_EOL);
				}
			}

			/*
			 *	Get marker data from story_points database table
			 * 
			 */
			
			echo('var markers = [];' . PHP_EOL);
			
			foreach($map -> getStoryPoints() as $storyPoint) {
				echo('markers[markers.length] = {"lat": "' . $storyPoint->lat . '", "lon": "' . $storyPoint->lon . '", "title":"' . $storyPoint->title . '", "url":"' . $storyPoint->url . '"}; ' . PHP_EOL);
			}
		?>
		
	
		jQuery(document).ready(function(){
				var map			= new L.Map('map');
				var osmUrl		= 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
				var osmAttrib	= 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
				
				var osm = new L.TileLayer(osmUrl,
						{
							minZoom: 8,
							maxZoom: 18,
							attribution: osmAttrib
						}
				);
				
				map.setView(
						new L.LatLng( mapLatitude, mapLongitude ),
						13);
				map.addLayer(osm);	

				<?php if (current_user()): ?>
					var popup = L.popup();
					function onMapClick(e) {
					    popup
					        .setLatLng(e.latlng)
					        .setContent("You clicked the map at " + e.latlng.toString())
					        .openOn(map);
					}
					map.on('click', onMapClick);
				<?php endif; ?>
				
				jQuery.each(mapOverlays, function(i, ob){
					var imgOverlay = L.imageOverlay(ob.uri, [[ob.nwLat, ob.nwLon], [ob.seLat, ob.seLon]] ).addTo(map);

					var sliderDiv = jQuery('<div class="slider">').appendTo('#map_container');
					
					sliderDiv.slider({
			            value: 100,
			            slide: function(e, ui) {
							imgOverlay.setOpacity(ui.value / 100);
			            }
			        });
			        
				
				});

				jQuery.each(markers, function(i, ob){

					//alert(	parseFloat(ob.lon) + ", " + parseFloat(ob.lat)	);

					L.marker(
							[
								parseFloat(ob.lat)
									,
								parseFloat(ob.lon)
							]
							)
							.addTo(map)
				          	.bindPopup(
				          		'<h5>' + ob.title + '</h5><a href="' + ob.url + '"><p>1st img from story goes here</p></a>'
							);
				});

/*
				
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
				*/
		});
	
	</script>
	
	
	
</div>
	
<!-- leave row open for footer to close -->