<?php head(array('title'=>'EU Maps', 'bodyclass'=>'eumaps')); ?>


<h1>EU Maps</h1>

<style type="text/css">

	input[type=text]{
		width:	50px;
	}
	
	#map-name,
	.tag{
		font-weight:	bold;
	}
	
</style>

<form method="post" action="eumap/map/add" id="mapForm" style="display:none;">

	<table style="width:100%; margin-bottom:5em;">
		<tr>
			<td colspan="2" style="color:#A74C29">
				Map Configuration
			</td>
		</tr>
		<tr>
			<td>
				Tag target:
			</td>
			<td>
				<select name="tag" id="tag">
					<?php

							
						$table		= get_db() -> getTable('Exhibit');
						$query		= $table -> getSelect() -> order("slug");
					    $exhibits	= $table -> fetchObjects( $query);
					    
					    echo('<option>Please select:</option>'); 
						foreach ($exhibits as $exhibit) {
					    	echo('<option value="' . $exhibit->slug . '">' . $exhibit->slug . '</option>'); 
					    }
						
					?>
				</select>
			</td>
		</tr>
		
		<tr>
			<td>
				Image:
			</td>
			
			<td>
				<select name="img" id="img">
					<?php
						if($handle = opendir(EUMAP_IMG_DIR_ADMIN)){
							
						    echo('<option>Please select:</option>');
						    
							while (false !== ($entry = readdir($handle))) {
								if($entry != '.' && $entry != '..'){
									echo ('<option value="' . $entry . '">' . $entry . '</option>');					
								}
							}
							closedir($handle);
						}
					?>
				</select>

			</td>
		</tr>
	
		<tr>
			<td>
				NW (long/lat), SE (long/lat):
			</td>
			
			<td>
				(
				<input type="text"	name="nw_lon"	id="nw_lon"	value="51.490"/>
				/ 
				<input type="text"	name="nw_lat"	id="nw_lat"	value="-0.122"/>
				)
				,
				(
				<input type="text"	name="se_lon"	id="se_lon"	value="51.510"/>
				/
			 	<input type="text"	name="se_lat"	id="se_lat"	value="-0.078"/>
				)
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="text-align:right;">
				<input type="hidden" name="id"	id="mapFormId" value=""/>
				<input type="submit" class="addOrEditMap"	/>
				<input type="submit" class="cancelAdd"		value="Cancel"/>
			</td>
		</tr>
		
	</table>
</form>




<form method="post" id="pointForm" style="display:none;">
	<table style="width:100%; margin-bottom:5em;">
	
		<tr>
			<td colspan="2" style="color:#A74C29">
				Configure story point for map: <span id="map-name"></span>
			</td>
		</tr>

		<tr>
			<td>
				Story:
			</td>
			<td>
				<select name="url" id="url">
				</select>
			</td>
		</tr>
		
		<tr>
			<td>
				Longitude, Latitude:
			</td>
			
			<td>
				<input type="text"	name="lon"	id="lon"	value="-0.122"/>
				,
				<input type="text"	name="lat"	id="lat"	value="51.510"/>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="text-align:right;">
				<input type="hidden" name="id"		id="pointFormId"	value=""/>
				<input type="hidden" name="map_id"	id="map_id"			value=""/>
				<input type="hidden" name="title"	id="title"			value=""/>
				<input type="submit" class="addOrEditPoint"				value=""/>
				<input type="submit" class="cancelAdd"					value="Cancel"/>
			</td>
		</tr>
		
	</table>
</form>



<script type="text/javascript">
	jQuery(document).ready(function(){
		
		function pointEdit(mapName, urlVal){
			jQuery.ajax({
				url:		"eumap/map/data?slug=" + mapName,
				dataType:	"json"
				}).done(function ( data ) {
					
					
					jQuery("#url")[0].options.length = 0;
					
					var count = 0;
					jQuery.each( data, function(i, ob){
						
						if(i != "Themes"){
							jQuery("#url")[0].options[count] = new Option(i, ob);
						}
						count ++;
					});
					
					if(urlVal){
						jQuery("#url").val(urlVal);
					}
					
					jQuery("#url").unbind("change");
					jQuery("#url").bind("change", function(){
						
						var val = jQuery("#url").val();
						jQuery.each( data, function(i, ob){
							if(ob == val){
								jQuery("#title").val(i);
							}
						});
					});
				});
		}
		
		jQuery('.addNewMap').click(function(){
			jQuery("#mapFormId").val("");
			
			jQuery(".addOrEditMap").val("Add New Map");
			jQuery("#pointForm").hide();
			jQuery("#mapForm").attr('action', 'eumap/map/add');
			jQuery("#mapForm").show();
		});

		
		jQuery('.addNewPoint').click(function(){
			
			var mapId	= jQuery(this).parent().attr("class");
			
			var mapName	=  jQuery(this).closest("table").closest('tr').prev('tr').find(".tag").html();
			
			pointEdit(mapName);
			
			jQuery("#map-name").html(mapName);
			
			jQuery(".addOrEditPoint").val("Add New Story Point");
			
			jQuery("#map_id").val(mapId);
			jQuery("#mapForm").hide();
			jQuery("#pointForm").attr('action', 'eumap/map/addPoint');
			
			
			jQuery("#pointForm").show();
			
		});
		
		jQuery('.editMap').click(function(){
			
			var row	= jQuery(this).parent().parent();
			var id	= jQuery(this).parent().attr("class");
			
			jQuery("#mapFormId").val(id);
			
			jQuery("#nw_lon").val(	row.find(".nw_lon").html()	);
			jQuery("#nw_lat").val(	row.find(".nw_lat").html()	);
			jQuery("#se_lon").val(	row.find(".se_lon").html()	);
			jQuery("#se_lat").val(	row.find(".se_lat").html()	);
			
			jQuery("#tag").val(	row.find(".tag").html() );
			jQuery("#img").val(	row.find(".img").html() );
			
			jQuery(".addOrEditMap").val("Edit Existing Map");
			jQuery("#pointForm").hide();
			jQuery("#mapForm").attr('action', 'eumap/map/edit');
			jQuery("#mapForm").show();

		});
		
		
		
		jQuery('.editPoint').click(function(){
			var row		= jQuery(this).parent().parent();
			var id		= jQuery(this).parent().attr("class");
			var mapId	= jQuery(this).closest("tr").attr("class");
			var mapName	=  jQuery(this).closest("table").closest('tr').prev('tr').find(".tag").html();
			
			
			pointEdit(mapName, row.find(".url").html());
			
			jQuery("#map-name")		.html(mapName);
			jQuery("#map_id")		.val(mapId);
			jQuery("#pointFormId")	.val(id);

			jQuery(".addOrEditPoint").val("Edit Story Point")
			
			jQuery("#lon").val(	row.find(".lon").html()	);
			jQuery("#lat").val(	row.find(".lat").html()	);
			
			jQuery("#mapForm").hide();
			jQuery("#pointForm").attr('action', 'eumap/map/editPoint');
			jQuery("#pointForm").show();

		});

		
		
		jQuery('.cancelAdd').click(function(e){
			
			jQuery("#mapForm").hide();
			jQuery("#pointForm").hide();
			e.preventDefault();
			
		});
		
		

		
	});
</script>








<?php echo( count($eumaps) . " maps in total" ); ?>

<table id="maps">
	<col id="col-tag" />
	<col id="col-nw-long" />
	<col id="col-nw-lat" />
	<col id="col-se-long" />
	<col id="col-se-lat" />
	<col id="col-edit" />
	<col id="col-delete" />
	<thead>
		<tr>
			<th>Tag</th>
			<th>Image</th>
			<th>NW longitude</th>
			<th>NW latitude</th>
			<th>SE longitude</th>
			<th>SE latitude</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
	<?php if( count($eumaps) > 0 ): ?>
		<?php foreach($eumaps as $key=>$map): ?>
			<tr>
				<td class="tag"
					><?php echo html_escape( $map->tag);			?></td>
				<td class="img"
					><?php echo html_escape( $map->img);			?></td>
				<td class="nw_lat"
					><?php echo html_escape( $map->nw_lat);			?></td>
				<td class="nw_lon"
					><?php echo html_escape( $map->nw_lon);			?></td>
				<td class="se_lon"
					><?php echo html_escape( $map->se_lon);			?></td>
				<td class="se_lat"
					><?php echo html_escape( $map->se_lat);			?></td>
				<td class="<?php echo $map->id	?>"
					><input type="submit" class="editMap" value="Edit"	/></td>
				<td>
					<form method="post" action="eumap/map/delete">
						<input type="hidden" name="id" value="<?php echo $map->id	?>" />
						<input type="submit" value="Delete"/>
					</form>
				</td>

			</tr>
			
			<tr>
				<td></td>
				<td colspan="7">
					<table>
					
						<?php
							
							$points = $map->getStoryPoints();

							if (count($points) > 0 ): ?>
					    
							<thead>
								<tr>
									<th>Title</th>
									<th>Url</th>
									<th>NW longitude</th>
									<th>NW latitude</th>
									<th></th>
									<th></th>
								</tr>
							</thead>
						
					    <?php endif; ?>

						
						<?php
						    foreach ($points as $point): ?>
						    
								<tr class="<?php  echo($map->id); ?>">
								
									<td class="title"
										><?php  echo($point->title); ?></td>
									
									<td class="url"
										><?php  echo($point->url); ?></td>
									
									<td class="lon"
										><?php  echo($point->lon); ?></td>

									<td class="lat"
										><?php  echo($point->lat); ?></td>

									<td class="<?php echo $point->id	?>"
										><a class="editPoint">Edit</a></td>
									</td>

									<td>
										<form method="post" action="eumap/map/deletePoint" id="">
											<input type="hidden" name="id" value="<?php echo $point->id	?>" />
											<a onClick="jQuery(this).parent().submit();">Delete</a>
										</form>
									</td>
								</tr>
								
						    <?php endforeach; ?>

						<tr>
							<td colspan="5" style="width:100%; text-align:right;" class="<?php echo $map->id	?>">
								<a href="#form" class="addNewPoint">Add Point</a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			
		<?php endforeach; ?>	
	<?php endif; ?>
		
	</tbody>
</table>

<input type="submit" class="addNewMap" value="Add map"/>
