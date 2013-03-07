<?php head(array('title'=>'EU Maps', 'bodyclass'=>'eumaps')); ?>


<h1>EU Maps</h1>

<style type="text/css">

	input[type=text]{
		width:	8em;
	}
	
	#map-name,
	.tag,
	.page_id{
		font-weight:	bold;
	}
	
	.page_id{
		text-align:	right;
	}
	
	.addNewMap,
	.addNewPoint{
		color:				#338899;
		text-decoration:	underline;
	}
	
	.deleteMap,
	.deletePoint,
	.editMap,
	.editPoint{
		color:	#CC5500;
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
				Exhibition:
			</td>
			<td>
				<select name="tag" id="tag">
					<?php
						/*
						$table		= get_db() -> getTable('Exhibit');
						$query		= $table -> getSelect() -> order("slug");
					    $exhibits	= $table -> fetchObjects( $query);
					    
					    echo('<option>Please select:</option>'); 
						foreach ($exhibits as $exhibit) {
					    	echo('<option value="' . $exhibit->slug . '">' . $exhibit->slug . '</option>'); 
					    }
						*/
						$table		= get_db() -> getTable('Tag');
						$query		= $table -> getSelect() -> order("name");
					    $tags		= $table -> fetchObjects( $query);
					    
					    echo('<option>Please select:</option>'); 
						foreach ($tags as $tag) {
					    	echo('<option value="' . $tag->name . '">' . $tag->name . '</option>'); 
					    }

						
					?>
				</select>
			</td>
		</tr>

		<tr>
			<td>
				Map Centre (latitude/longitude):
			</td>
			
			<td>
				(
				<input type="text"	name="lat"	id="lat"	value="41.89007"/>
				/ 
				<input type="text"	name="lon"	id="lon"	value="12.49188"/>
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
			
			
				<select name="page_id" id="page_id">
				</select>
				
				
			</td>
		</tr>
		
		<tr>
			<td>
				Latitude, Longitude:
			</td>
			
			<td>
				<input type="text"	name="lat"	id="lat"	value="41.88541"/>
				,
				<input type="text"	name="lon"	id="lon"	value="12.47068"/>
			</td>
		</tr>
		
		<tr>
			<td colspan="2" style="text-align:right;">
				<input type="hidden" name="id"		id="pointFormId"	value=""/>
				<input type="hidden" name="map_id"	id="map_id"			value=""/>
				<input type="submit" class="addOrEditPoint"				value=""/>
				<input type="submit" class="cancelAdd"					value="Cancel"/>
			</td>
		</tr>
		
	</table>
</form>



<script type="text/javascript">
	jQuery(document).ready(function(){
		
		function pointEdit(mapName, urlVal){
			alert(mapName);
			jQuery.ajax({
				url:		"eumap/map/data?tag=" + mapName,
				dataType:	"json"
				}).done(function ( data ) {
	
				jQuery("#page_id")[0].options.length = 0;
				
				var count = 0;
				
				jQuery.each( data, function(i, ob){
					if(i > 0){
						jQuery("#page_id")[0].options[count] = new Option(ob.title, ob.id);
					}
					count ++;
				});
				
				if(urlVal){
					jQuery("#page_id").val(urlVal);
				}
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
			var mapName	=  jQuery(this).closest("tr").prevAll('tr.map').find(".tag").html();
			
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
			
			jQuery("#lon").val(	row.find(".lon").html()	);
			jQuery("#lat").val(	row.find(".lat").html()	);
			
			jQuery("#tag").val(	row.find(".tag").html() );
			
			jQuery(".addOrEditMap").val("Edit Existing Map");
			jQuery("#pointForm").hide();
			jQuery("#mapForm").attr('action', 'eumap/map/edit');
			jQuery("#mapForm").show();

		});
		
		
		jQuery('.editPoint').click(function(){
			
			var row		= jQuery(this).parent().parent();
			var id		= jQuery(this).parent().attr("class");
			var mapId	= jQuery(this).closest("tr").attr("class");
			var mapName	= jQuery(this).closest("tr").prevAll('tr.map').find(".tag").html();
				
			pointEdit(mapName, row.find(".page_id_val").html());
			
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
	<col id="col-lat" />
	<col id="col-long" />
	<col id="col-edit" />
	<col id="col-delete" />
	<thead>
		<tr>
			<th>Tag &rarr; Page</th>
			<th>Latitude</th>
			<th>Longitude</th>
			<th></th>
			<th></th>
		</tr>
	</thead>
	<tbody>
		
	<?php if( count($eumaps) > 0 ): ?>
		<?php foreach($eumaps as $key=>$map): ?>
			<tr class="map">
				<td class="tag"
					><?php echo html_escape( $map->tag);			?></td>
				<td class="lat"
					><?php echo html_escape( $map->lat);			?></td>
				<td class="lon"
					><?php echo html_escape( $map->lon);			?></td>
				<td class="<?php echo $map->id	?>">
					<a class="editMap">Edit</a>
				</td>
				<td>
					<form method="post" action="eumap/map/delete">
						<input type="hidden" name="id" value="<?php echo $map->id	?>" />
						<a class="deleteMap" onClick="jQuery(this).parent().submit();">Delete</a>
					</form>
				</td>

			</tr>
						
			<?php
				$points = $map->getStoryPoints();
	
			    foreach ($points as $point): ?>
	
					<tr class="<?php  echo($map->id); ?>">
					
						<td class="page_id"
							><?php
									
								$pages = get_db()->fetchAll("SELECT * FROM `omeka_section_pages` where id = " . $point->page_id);
								
								if(count($pages)==1){
									$page = reset($pages);
									echo( $page['title']  );
								}
								
								echo( '<span style="display:none;" class="page_id_val">' . $point->page_id . '</span>' );
							
							?></td>
						
						<td class="lat"
							><?php  echo($point->lat); ?></td>
							
						<td class="lon"
							><?php  echo($point->lon); ?></td>
	
						<td class="<?php echo $point->id	?>"
							><a class="editPoint">Edit</a></td>
						</td>
	
						<td>
							<form method="post" action="eumap/map/deletePoint" id="">
								<input type="hidden" name="id" value="<?php echo $point->id	?>" />
								<a class="deletePoint" onClick="jQuery(this).parent().submit();">Delete</a>
							</form>
						</td>
					</tr>
					
			    <?php endforeach; ?>
	
			<tr>
				<td colspan="4"></td>
				<td class="<?php echo $map->id	?>">
					<a href="#form" class="addNewPoint">Add Point</a>
				</td>
			</tr>

		<?php endforeach; ?>	
	<?php endif; ?>

		<tr>
			<td colspan="4"></td>
			<td style="text-align:right">
				<a href="#form" class="addNewMap">Add map</a>
			</td>
		</tr>
	</tbody>
</table>


