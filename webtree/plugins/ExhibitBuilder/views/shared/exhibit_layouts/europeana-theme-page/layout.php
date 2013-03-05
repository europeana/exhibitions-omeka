<?php
	if($_SESSION['theme-map']){
		include 'layout_map.php'; 		
	}
	else{
		include 'layout_default.php'; 					
	}
?>


<div class="row">
	<div id="mobile_shares" class="twelve columns">
		<div class="theme-center-outer">
			<div class="theme-center-middle">
		    	<div class="theme-center-inner">
					<?php echo getAddThisMobile(); ?>
				</div>
			</div>
		</div>
	</div> <!-- leave row open for footer to close -->
