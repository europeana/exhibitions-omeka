<?php head(array('title'=>'EU Maps', 'bodyclass'=>'eumaps')); ?>


<h1>EU Maps</h1>


<form method="post" action="eumap/map/add" style="width:250px; border:1px solid #446677; padding:11px 0 0 18px;">

	Tag target: <input type="text" name="tag" value="wiki-loves-art-nouveau"/>
	<br/>
	NW long: <input type="text" name="nw_lon" value="50,1"/>
	<br/>
	NW lat: <input type="text" name="nw_lat"  value="50,2"/>
	<br/>
	SE long: <input type="text" name="se_lon"  value="50,3"/>
	<br/>
	SE lat: <input type="text" name="se_lat"  value="50,4"/>
	<br/>
	<br/>
	<input type="submit" value="Add map"/>
	
</form>


<script type="text/javascript">
	jQuery(document).ready(function(){

	});
</script>

<?php echo( count($eumaps) . " maps in total" ); ?>

<table id="maps">
	<col id="col-tag" />
	<col id="col-nw-long" />
	<col id="col-nw-lat" />
	<col id="col-se-long" />
	<col id="col-se-lat" />
	<col id="col-delete" />
	<thead>
		<tr>
		    <th>Tag</th>
		    <th>NW longitude</th>
		    <th>NW latitude</th>
		    <th>SE longitude</th>
		    <th>SE latitude</th>
		    <th></th>
		</tr>
	</thead>
	<tbody>
		
	<?php if( count($eumaps) > 0 ): ?>
		<?php foreach($eumaps as $key=>$map): ?>
			<tr>
			    <td><?php echo html_escape( $map->tag);		?></td>
			    <td><?php echo html_escape( $map->nw_lat);	?></td>
			    <td><?php echo html_escape( $map->nw_lon);	?></td>
			    <td><?php echo html_escape( $map->se_lon);	?></td>
			    <td><?php echo html_escape( $map->se_lat);	?></td>
			    <td>
			    	<form method="post" action="eumap/map/delete">
			    		<input type="hidden" name="id" value="<?php echo $map->id	?>" />
			    		<input type="submit" value="Delete"/>
			    	</form>
			    </td>
		    </tr>
		<?php endforeach; ?>	
	<?php endif; ?>
	    
    </tbody>
</table>
