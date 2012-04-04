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

<style>
	.browse-items-half-row{
		xbackground-color:red;
		xxborder:			1px solid #CCCCCC !important;
	}
	
	
	.theme-center-inner h4{
		height:	20px;
	}
	
	@media only screen and (max-width: 767px) {
		.theme-center-inner h4{
			height:	40px;
		}
		
		.browse-items-half-row{
			width:	100% !important;
		}
		.browse-items-item{
			width:	50%;
			max-width:	50%;
			min-width:	50%;
		}
	}
</style>
	        
<div class="row">
    <div class="six columns centered browse-items-half-row">
        <?php $count = 0?>
	    <?php while (loop_items()): ?>
	        <?php if($count>0):?>
		        <?php if($count%4==0):?>
		        		</div>
		        	</div>
		        	<div class="row">
					    <div class="six columns centered browse-items-half-row">
	        	<?php elseif($count%2==0):?>
		        		</div>
					    <div class="six columns centered browse-items-half-row">
		        <?php endif; ?>
	        <?php endif; ?>
		    <?php $count++; ?>

		    
			<div class="browse-items-item">
				<div class="theme-center-outer">
					<div class="theme-center-middle">
						<div class="theme-center-inner">
					        <h4>
					            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>"><?php echo item('Dublin Core', 'Title');?></a>
					        </h4>
					        <?php if (item_has_thumbnail()): ?>
					            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>">
					                <?php echo item_square_thumbnail(); ?>
					            </a>
					        <?php endif; ?>
					        <?php echo plugin_append_to_items_browse_each(); ?>
						</div>
					</div>
				</div>
			</div>
	    <?php endwhile; ?>
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


<link rel="stylesheet" href="<?php echo css('mediaelement/mediaelementplayer'); ?>"/>

<?php foot(); ?>



