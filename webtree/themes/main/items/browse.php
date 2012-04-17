<?php head(array('title' => 'Browse Items', 'bodyid' => 'items', 'bodyclass' => 'browse')); ?>

<?php
  $queryString = '?tags=' . $_GET['tags'] . '&theme=' . $_GET['theme']; 
?>


	<div class="twelve columns">
	    <div class="return-nav">
		    <?php echo ve_return_to_exhbit($queryString); ?>
	    </div>
	    
	    <h1>
	        <?php echo ve_translate('items-browse', 'Browse Items');?>
	        (<?php echo total_results(); ?> <?php echo ve_translate('items-total', 'total');?>)
	    </h1>	    
	</div>
</div>


<div class="row">
    <div class="twelve columns">
	    <div id="pagination-top" class="pagination">
	    	<?php echo pagination_links(); ?>
	    </div>
	</div>
</div>


<div class="row">
    <div class="six columns">
    	<ul class="block-grid two-up">
    	
        <?php $count = 0?>
	    <?php while (loop_items()): ?>
	    
	        <?php if($count>0):?>
	        
		        <?php if($count%4==0):?>
		        
		        				</ul>		<!-- close ul-->
		        			</div>			<!-- close six columns-->
		        		</div>				<!-- close row -->
		        		<div class="row">
		        			<div class="six columns">
		        				<ul class="block-grid two-up">
					    
	        	<?php elseif($count%2==0):?>
	        	
	        					</ul>		<!-- close ul-->
	        				</div>			<!-- close six columns-->
		        			<div class="six columns">
		        				<ul class="block-grid two-up">
					    
		        <?php endif; ?>
		         
	        <?php endif; ?>
	        
		    <?php $count++; ?>

			<li class="browsed-item-wrapper">
		        <?php if (item_has_thumbnail()): ?>
		            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>">
		                <?php echo item_square_thumbnail(); ?>
		            </a>
	        	<?php else:?>
	        	
	        		<?php
	        			$item = get_current_item();
	        			$file = $item->Files[0];
	        			$mime = $file->getMimeType();
	        			
	        			if (preg_match("/^application/", $mime)){
	        				echo '<a href="' . uri('items/show') . '/' . item('id') . $queryString . '" ><img class="icon-pdf" src="' . img('icon-pdf.png') . '"/></a>';
	        			}
	        			elseif (preg_match("/^video/", $mime)){
	        				echo '<a href="' . uri('items/show') . '/' . item('id') . $queryString . '" ><img class="icon-vid" src="' . img('icon-video.png') . '"/></a>';
	        			}
	        			elseif (preg_match("/^audio/", $mime)){
	        				echo '<a href="' . uri('items/show') . '/' . item('id') . $queryString . '" ><img class="icon-audio" src="' . img('icon-audio.png') . '"/></a>';
	        			}
	        			
	        			 
	        		?>
	        		
		        <?php endif; ?>
		        <?php echo plugin_append_to_items_browse_each(); ?>
		        

		        <h4>
		            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>"><?php echo item('Dublin Core', 'Title');?></a>
		        </h4>
			</li>
			
	    <?php endwhile; ?>
	</div>
</div>
		
<div class="row">
	<div id="mobile_shares" class="twelve columns">
		<div class="theme-center-outer">
			<div class="theme-center-middle">
   	    		<div class="theme-center-inner">
					<?php echo getAddThisMobile(); ?>
				</div>
			</div>
		</div>
	</div>
</div>


<div class="row">
	<div class="twelve columns">
	    <div id="pagination-bottom" class="pagination">
	        <?php echo pagination_links(); ?>
	    </div>
	    <?php echo plugin_append_to_items_browse(); ?>
	</div>
</div>


<?php foot(); ?>



