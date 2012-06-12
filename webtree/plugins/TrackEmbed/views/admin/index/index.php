<?php head(array('title'=>'Track Embeds', 'bodyclass'=>'track-embeds')); ?>



<h1>Track Embeds</h1>

<!--
<form method="get" action="track-embed" style="width:190px;">
		<fieldset style="border:1px solid #446677; padding:5px;">
			<legend style="font-size:14px; margin-top:15px;">Choose a period</legend>
			<br/>
			<input type="submit" value="go" style="position:relative; top:-32px; "/>
		</fieldset>
</form>
-->

<form method="get" action="track-embed" style="width:250px; border:1px solid #446677; padding:11px 0 0 18px;">
	<select name="period" id="period">
	<?php foreach($periods as $key=>$period): ?>
		<option value="<?php echo $period->period;?>"><?php echo $period->period;?></option>
	<?php endforeach; ?>
	</select>
	<input type="submit" value="set period" style="position:relative; top:-8px; left:-20px;"/>
</form>


<script type="text/javascript">

	jQuery(document).ready(function(){
		// tidy up the labels in the select component and set the selected month
		var months = {
				"01":"January",
				"02":"February",
				"03":"March",
				"04":"April",
				"05":"May",
				"06":"June",
				"07":"July",
				"08":"August",
				"09":"September",
				"10":"October",
				"11":"November",
				"12":"December"};
		jQuery("#period option").each(function(){
			var text	= jQuery(this).html();
			var year	= text.substr(0,4);
			var month	= text.substr(4);
			jQuery(this).html( months[month] + "  " + year );
			if(text == window.location.href.substr(window.location.href.length-6)){
				jQuery(this).attr("selected", "selected");
			}
		});
	});

</script>


<table id="embeds">
	<col id="col-id" />
	<col id="col-referer" />
	<col id="col-resource" />
	<col id="col-date">
	<col id="col-period">
	<col id="col-count" />
	<thead>
		<tr>
		    <th>ID</th>
		    <th>Referer</th>
		    <th>Resource Id</th>
		    <th>Date</th>
		    <th>Period</th>
		    <th>Count</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($embeds as $key=>$embed): ?>
			<tr>
			    <td><?php echo html_escape($embed->id);?></td>
			    <td><?php echo html_escape( $embed->referer); ?></td>
			    <td><?php echo html_escape( $embed->resource); ?></td>
			    <td><?php echo html_escape( $embed->last_accessed); ?></td>
			    <td><?php echo html_escape( $embed->period); ?></td>
			    <td><?php echo html_escape( $embed->view_count); ?></td>
		    </tr>
	    <?php endforeach; ?>
    </tbody>
</table>