<?php
$_SESSION['themes_uri'] = str_replace("themes-map", "themes", uri());
?>

<style type="text/css">

	#map_container{
		padding-bottom:	3em;
		position:		relative;
	}
	
	#map{
		height:		380px;
		width:		100%;
	}
	
	
	#layer-control{
		position:			absolute;
		top:				1em;
		right:				1em;
		padding:			1em;
		background-color:	#373737;
	}
	
	#layer-control div{
		background-color:	#373737;
		color:				red;
	}
		
	#overlay-control{
		position:			absolute;
		top:				1em;
		right:				1em;
		padding:			1em;
		background-color:	#373737;
		
		border-radius:		8px 8px 8px 8px;
	}
	
	.overlay-option{
		display:		block;
		margin:			0.25em 0;
	}
	
	.slider {
		margin:			1.5em 10% 1.5em 10%;
		width:			80%;
		border-width:	2px;
		display:		none;
	}
	
</style>
	


<div class="row">

	<div id="map_container" class="twelve columns inner">
		<div id="map"></div>
		
		<!-- 
		<div id="overlay-control"><div class="slider"></div></div>
		 -->
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
				
				$title		= item('Dublin Core', 'Title', null, $current);
				$nwLat		= getItemTypeMetadataEntry($current, "NW Latitude");
				$nwLon		= getItemTypeMetadataEntry($current, "NW Longitude");
				$seLat		= getItemTypeMetadataEntry($current, "SE Latitude");
				$seLon		= getItemTypeMetadataEntry($current, "SE Longitude");
				
				if( strlen($nwLat) > 0 && strlen($nwLon) > 0 && strlen($seLat) > 0 && strlen($seLon) > 0){
					if( count($current->Files) > 0){
						$uri = str_replace("/fullsize/", "/files/", file_display_uri($current->Files[0]));
						echo('mapOverlays[mapOverlays.length] = {"title":"' . $title .  '",  "nwLat":"' . $nwLat . '", "nwLon":"' . $nwLon . '", "seLat":"' . $seLat . '", "seLon":"' . $seLon . '", "uri":"' . $uri . '" };' . PHP_EOL);
					} 
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

			var osmAttrib	= '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors, <a href="http://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>';
			var mqTilesAttr = 'Tiles &copy; <a href="http://www.mapquest.com/" target="_blank">MapQuest</a> <img src="http://developer.mapquest.com/content/osm/mq_logo.png" />';
			
			var osm = new L.TileLayer(
				'http://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
				{
					minZoom: 12,
					maxZoom: 18,
					attribution: osmAttrib
				}
			);

			// map quest
			var mq = new L.TileLayer(
				'http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png',
				{
					minZoom: 12,
					maxZoom: 18,
					attribution: mqTilesAttr,
					subdomains: '1234',
					type: 'osm'
				}
			);
			

			// map quest aerial	
			/*		
			var mqa = new L.TileLayer(
				'http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png',
				{
					attribution: 'Imagery &copy; NASA/JPL-Caltech and U.S. Depart. of Agriculture, Farm Service Agency, ' + mqTilesAttr,
					subdomains: '1234',
					type: 'sat'
				}
			);
			*/
				

			//var map = new L.Map('map');

			var map = L.map('map', {
			    center: new L.LatLng(mapLatitude, mapLongitude),
			    zoom: 13,
			    layers: [osm, mq]
			});
					
//			map.setView(
//					new L.LatLng( mapLatitude, mapLongitude ),
//					13);
			//map.addLayer(osm);
			//map.addLayer(mqa);	

//			map.addLayer(mq);	
			

/*
			var baseMaps = {
				"Open Street Map":	osm,
				"Map Quest":		mq
			};
			L.control.layers(baseMaps).addTo(map);		
*/


			var EuropeanaLayerControl = function(map, ops){

				var self = this;
				
				self.ops = ops;
				self.map = map;
				 
				
				self._setLayer = function(index){
					var layer = self.ops[index].layer;
					self.map.clearLayers();
					self.map.addLayer(layer);
				};

				
				var html = '';
				
				jQuery.each(self.ops, function(i, ob){
					html += '<div class="' + i + '">' + ob.title + '</div>';
				});
				
				html = '<div id="layer-control">' + html + '</div>';
				
				self.cmp = jQuery(html);//.appendTo(self.map.getContainer());// jQuery(self.map.getContainer()).find('.leaflet-control-container') );

				jQuery('#layer-control div').each(function(){
					jQuery(this).click(function(){
						alert( jQuery(this).attr('class') );
					});
				});
				
				return {
					getCmp : function(index){
						return self.cmp; //self._setLayer(index);
					} 
				}
			}
			
			var baseMaps = [
				{
					"title": "Open Street Map",
					"layer": osm
				},
				{
					"title": "Map Quest",
					"layer": mq
				}
			];
			new EuropeanaLayerControl(map, baseMaps);
			//L.control.layers(baseMaps).addTo(map);		
				


			
				
			
			// Overview map - requires duplicate layer
			//var osm2 = new L.TileLayer(osmUrl, {minZoom: 0, maxZoom: 13, attribution: osmAttrib });
			new L.Control.MiniMap(
				new L.TileLayer(
					'http://otile{s}.mqcdn.com/tiles/1.0.0/{type}/{z}/{x}/{y}.png',
					{
						minZoom: 0,
						maxZoom: 13,
						attribution: mqTilesAttr,
						subdomains: '1234',
						type: 'osm'
					}),
				{toggleDisplay: true }
			).addTo(map);






			
			
			<?php if (current_user()): ?>	// coordinates utility
				var popup = L.popup();
				function onMapClick(e) {
				    popup
				        .setLatLng(e.latlng)
				        .setContent('<span style="color:black;">You clicked the map at ' + e.latlng.toString())
				        .openOn(map);
				}
				map.on('click', onMapClick);
			<?php endif; ?>

			
			// Overlay control
			
			
			var EuropeanaOverlayControl = function(map, selector){
				var self = this;

				self.defaultOpacity	= 80;
				self.map			= map;				
				self.addedOverlays	= {};
				
				self.activeOverlay	= null;

				var overlayControl	= jQuery('<div id="overlay-control">').appendTo(selector);
				var sliderDiv		= jQuery('<div class="slider">').appendTo(overlayControl);
				
				self.sliderDiv		= sliderDiv.slider({
		            value: 100,
		            slide: function(e, ui) {
			            
		            	self.activeOverlay.setOpacity(ui.value / 100);

		            	console.log("slide: " + ui.value);
		            	//e.stopPropagation();
		            	//e.preventDefault();
		            	//e.stopImmediatePropagation();
		                //e.cancelBubble = true;
		            }
		        });

				self.setActiveOverlay = function(){

					jQuery.each(self.addedOverlays, function(i, ob){  // clear all overlays
						ob.setOpacity(0);
					})
					
					var index		= parseInt( this.id.replace(/\D/g,'') );
					
					if(isNaN(index)){
						self.sliderDiv.hide();
					}
					else{
						var ob = null;	// restore or set new overlay
						
						if(self.addedOverlays["" + index]){
							ob = self.addedOverlays["" + index];
						}
						else{
							ob = mapOverlays[index];
							ob = L.imageOverlay(ob.uri, [[ob.nwLat, ob.nwLon], [ob.seLat, ob.seLon]] ).addTo(self.map);
							self.addedOverlays["" + index] = ob;
						}

						if(ob != null){
							ob.setOpacity(self.defaultOpacity/100);
							self.activeOverlay = ob;
						}
						
						jQuery(this).parent().after(self.sliderDiv);
						
						self.sliderDiv.slider('value', self.defaultOpacity);		// reposition the slider
						self.sliderDiv.show();
					}
				};

				function sortByTitle(a, b){
					var aTitle = a.title.toLowerCase();
					var bTitle = b.title.toLowerCase(); 
					return ((aTitle < bTitle) ? -1 : ((aTitle > bTitle) ? 1 : 0));
				}
				
				self.mapOverlays = mapOverlays.sort(sortByTitle);
				
				jQuery('<div class="overlay-option"><input id="rd" name="overlay" type="radio" checked="checked"/><label for="rd">None</label></div>').appendTo(overlayControl);  //'#overlay-control');

				jQuery.each(mapOverlays, function(i, ob){
					var overlayOption	= jQuery('<div class="overlay-option"><input id="rd' + i + '" name="overlay" type="radio"/><label for="rd' + i + '">' + ob.title + '</label></div>').appendTo(overlayControl);  //  '#overlay-control');
				});

				jQuery('input[type="radio"]').bind('click', self.setActiveOverlay);
						
			}

			new EuropeanaOverlayControl(map, '#map_container');


			
			// Markers
			
			
			jQuery.each(markers, function(i, ob){

				var marker = L.marker(
						[
							parseFloat(ob.lat)
								,
							parseFloat(ob.lon)
						]
				);
				
				marker.addTo(map);
	    		marker.bindPopup('<div style="min-width:180px;height:0px;">');
				marker.on('click', function(e){
					jQuery.ajax({
						url:		"<?php echo(WEB_ROOT); ?>/eumap/map/test?pageId=" + ob.pageId,
						dataType:	"json"
						}).done(function ( data ) {

							jQuery('<img src="' + data.imgUrl + '" />').appendTo('body').imagesLoaded(function($images, $proper, $broken){
								this.remove();
								marker._popup.setContent('<a href="' + data.url + '"><h5>' + data.title + '</h5><img style="' + jQuery($images[0]).width() + '" src="' + data.imgUrl + '"/></a>');
							});
						
					});
				});
			});
		});
	
	</script>
	
</div>
	
<!-- leave row open for footer to close -->