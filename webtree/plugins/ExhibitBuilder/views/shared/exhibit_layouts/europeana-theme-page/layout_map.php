<?php
$_SESSION['themes_uri'] = str_replace("themes-map", "themes", uri());
?>

<style type="text/css">

	#map_container{
		padding-left:	10%;
		padding-right:	10%;
		padding-bottom:	3em;
	}
	
	#map{
		height:		380px;
		width:		80%;
	}
	
	.slider {
		margin:			1em 0;
		width:			80%;
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
				echo('markers[markers.length] = {"lat": "' . $storyPoint->lat . '", "lon": "' . $storyPoint->lon . '", "pageId":"' . $storyPoint->page_id . '"}; ' . PHP_EOL);
			}
		?>
		
	
		jQuery(document).ready(function(){
				var map			= new L.Map('map');
				var osmUrl		= 'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png';
				var osmAttrib	= 'Map data &copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors';
				
				var osm = new L.TileLayer(osmUrl,
						{
							minZoom: 12,
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

					var marker = L.marker(
							[
								parseFloat(ob.lat)
									,
								parseFloat(ob.lon)
							]
							)
					marker.addTo(map);
					

		    		marker.bindPopup('<div style="min-width:180px;height:0px;">');
		    		
					marker.on('click', function(e){

					jQuery.ajax({
						url:		"<?php echo(WEB_ROOT); ?>/eumap/map/test?pageId=" + ob.pageId,
						dataType:	"json"
						}).done(function ( data ) {
							marker._popup.setContent('<a href="' + data.url + '"><h5>' + data.title + '</h5><img src="' + data.imgUrl + '"/></a>');
						});
					});
				});
		});
	
	</script>
	
	
	
</div>
	
<!-- leave row open for footer to close -->