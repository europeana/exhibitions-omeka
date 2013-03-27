<?php $_SESSION['themes_uri'] = str_replace("themes-map", "themes", uri()); ?>

<style type="text/css">

	/* Leaflet overrides */
	
	.leaflet-popup-content-wrapper{
		border-radius:	1em;
		XXXtext-align:		center;
	}
	
	.leaflet-container a.leaflet-popup-close-button{
		color:		#999;
		padding:	3px 3px 0 0;
	}
	
	.leaflet-popup-content{
		margin:	1em 1em;
	}

	/* End leaflet overrides */

	#map-container{
		padding-bottom:	3em;
		position:		relative;
	}
	
	#map{
		height:		500px;
		width:		100%;
	}

	.read-story-link{
		display:	block;
		
	}
	
	#europeana-ctrls{
		position:			absolute;
		top:				0;
		right:				0;
		padding:			1em;
		color:				#E3D6B6;
	}
	
	#layer-ctrl>div{
		background-color:	#373737;
		border-radius:		8px 8px 8px 8px;
		margin-left:		1em;
		float:				right;
		padding:			0.5em;	
	}
	
	#layer-ctrl>div.active{
		font-weight:		bold;
	}
		
	#overlay-ctrl{
		background-color:	#373737;
		border-radius:		8px 8px 8px 8px;
		clear:				both;
		display:			none;
		float:				right;
		margin-top:			1em;
		padding:			0.5em 1em 1em 1em;
		position:			relative;
	}
	
	#overlay-ctrl.active{
		display:			block;
	}
	
	#overlay-toggle{
		background-color:	#373737;
		background-image:	url('<?php echo(WEB_ROOT); ?>/themes/main/javascripts/images/layers.png');
		border-radius:		4px 4px 4px 4px;
		border:				4px solid #373737;
		cursor:				pointer;
		float:				right;
		height:				2em;
		margin-top:			1em;
		width:				2em;
	}
	
	#overlay-toggle.active{
		margin-right:		1em;	
	}
	
	.overlay-label{
		display:		block;
		margin:			0 0 0.5em 0;
	}
	
	.overlay-option{
		display:		block;
		margin:			0.25em 0;
	}
	
	.slider,
	.slider-mobile{
		margin:			1.5em 10% 1.5em 10%;
		width:			80%;
		border-width:	2px;
		display:		none;
	}
	
	.slider-mobile.active{
		display:		block;
	}
	
	.leaflet-control-minimap{
		display:		none;
	}
	
	#mobile-test{
		width:		0px;
		height:		0px;
		display:	block;
	}
	
	@media only screen and ( min-width:	48em ){
		#mobile-test{
			display:	none;
		}
		.slider.active{
			display:	block;
		}
		.slider-mobile.active{
			display:	none;
		}
		.leaflet-control-minimap{
			display:	block;
		}
		#overlay-ctrl{		
			display:	block;
		}
		#overlay-toggle{		
			display:	none;
		}
	}
	
</style>
	


<div class="row">

	<div id="mobile-test"></div>
	<div id="map-container">
		<div id="map"></div>
	</div>

	
	<script type="text/javascript">

		function isMobileView(){
			return jQuery('#mobile-test').is(':visible');
		}
	
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
			
			echo('var mapOverlayLabel	= "' . ve_translate("view-historical-map", "") . '";' . PHP_EOL);
			echo('var mapStoryLinkLabel	= "' . ve_translate("read-story", "") . '";' . PHP_EOL);
			
			echo('var mapLatitude		= ' . $map->lat . ';' . PHP_EOL);
			echo('var mapLongitude		= ' . $map->lon . ';' . PHP_EOL);
			
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
				
			var map = L.map('map', {
			    center: new L.LatLng(mapLatitude, mapLongitude),
			    zoom: 13
			});

			
			var europeanaCtrls = jQuery('<div id="europeana-ctrls">').appendTo('#map-container');

			
			var EuropeanaLayerControl = function(map, ops){

				var self = this;
				
				self.ops = ops;
				self.map = map;
				self.grp = null;
				 
				self._setLayer = function(index){
					var layer = self.ops[index].layer;
					self.grp.clearLayers();
					self.grp.addLayer(layer);

					jQuery(self.cmp.find("div")).removeClass('active');
					jQuery(self.cmp.find("div").get(index)).addClass('active');
				};

				var html	= '';
				var layers	= [];
				
				jQuery.each(self.ops, function(i, ob){
					html += '<div class="' + i + '">' + ob.title + '</div>';
					layers[layers.length] = ob.layer;
				});

				
				self.cmp = jQuery('<div id="layer-ctrl">' + html + '</div>');

				self.cmp.find("div").each(function(){
					jQuery(this).click(function(){
						self._setLayer(parseInt(jQuery(this).attr('class')));
					});
				});

				self.grp = L.layerGroup(layers);
				self.grp.addTo(self.map);
				self._setLayer(0);

				
				return {
					getCmp : function(index){
						return self.cmp;
					} 
				}
			};

			
			var ctrlLayer = new EuropeanaLayerControl(map,
				[{
				    "title":	"Open Street Map",
					"layer":	osm
			    },
			    {
				    "title":	"Map Quest",
				    "layer":	mq
			    }]		 
			);
			
			europeanaCtrls.append(ctrlLayer.getCmp());
			
			
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

				var overlayControl	= jQuery('<div id="overlay-ctrl">')		.appendTo(selector);
				var overlayToggle	= jQuery('<div id="overlay-toggle">')	.appendTo(selector);
				var sliderDiv		= jQuery('<div class="slider">')		.appendTo(overlayControl);

				var sliderDivMobile	= jQuery('<div class="slider-mobile">');
				jQuery(self.map.getContainer()).after(sliderDivMobile);
				
//				var sliderDivMobile	= jQuery('<div class="slider-mobile">')	.appendTo(  selectorWrapper);
				
				//self.overlayToggle = overlayToggle;
				//self.
				overlayToggle.click(function(){
					jQuery(this).toggleClass('active');
					if(jQuery(this).hasClass('active')){
						overlayControl.addClass('active');
					}
					else{
						overlayControl.removeClass('active');
					}
				});
				
				
				self.sliderDiv = sliderDiv.slider({
		            value: 100,
		            slide: function(e, ui) {
		            	self.activeOverlay.setOpacity(ui.value / 100);
		            }
		        });
		        
				self.sliderDivMobile = sliderDivMobile.slider({
		            value: 100,
		            slide: function(e, ui) {
		            	self.activeOverlay.setOpacity(ui.value / 100);
		            }
		        });

				self.setActiveOverlay = function(){

					jQuery.each(self.addedOverlays, function(i, ob){  // clear all overlays
						ob.setOpacity(0);
					})
					
					var index		= parseInt( this.id.replace(/\D/g,'') );
					
					if(isNaN(index)){
						self.sliderDiv			.removeClass('active');
						self.sliderDivMobile	.removeClass('active');
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
						
						self.sliderDiv.slider		('value', self.defaultOpacity);		// reposition the slider
						self.sliderDivMobile.slider	('value', self.defaultOpacity);		// reposition the slider
						
						self.sliderDiv.addClass('active');
						self.sliderDivMobile.addClass('active');
					}
				};

				function sortByTitle(a, b){
					var aTitle = a.title.toLowerCase();
					var bTitle = b.title.toLowerCase(); 
					return ((aTitle < bTitle) ? -1 : ((aTitle > bTitle) ? 1 : 0));
				}
				
				self.mapOverlays = mapOverlays.sort(sortByTitle);
				
				jQuery('<span class="overlay-label">' + mapOverlayLabel + '</span><div class="overlay-option"><input id="rd" name="overlay" type="radio" checked="checked"/><label for="rd">None</label></div>').appendTo(overlayControl);

				jQuery.each(mapOverlays, function(i, ob){
					var overlayOption	= jQuery('<div class="overlay-option"><input id="rd' + i + '" name="overlay" type="radio"/><label for="rd' + i + '">' + ob.title + '</label></div>').appendTo(overlayControl);
				});

				jQuery('input[type="radio"]').bind('click', self.setActiveOverlay);
						
			}

			
			new EuropeanaOverlayControl(map, europeanaCtrls);


			
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
								
								marker._popup.setContent(
										'<a href="' + data.url + '">'
									+		'<h5>' + data.title + '</h5>'
									+	'</a>'
									+	'<a href="' + data.url + '">'
									+		'<img style="width:' + jQuery(this).width() + ';" src="' + data.imgUrl + '"/>'
									+	'</a>'
									+	'<a href="' + data.url + '" class="read-story-link">'
									+		mapStoryLinkLabel
									+	'</a>'
								);
								this.remove();
							});
						
					});
				});
			});
		});
	
	</script>
	
</div>
	
<!-- leave row open for footer to close -->