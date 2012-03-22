<?php head(array('title'=>'Browse Items','bodyid'=>'items','bodyclass' => 'browse')); ?>

	<div id="primary" class="grid_16">
		
		<h1>
            <?php echo ve_translate('items-browse', 'Browse Items');?>
            (<?php echo total_results(); ?> <?php echo ve_translate('items-total', 'total');?>)
        </h1>

		<div id="pagination-top" class="pagination clear"><?php echo pagination_links(); ?></div>
		
		<?php while (loop_items()): ?>
			<div class="grid_4 alpha">
				    
				<h2>
<!--                --><?php //echo link_to_item(item('Dublin Core', 'Title'), array('class'=>'permalink'), $action = 'show'); ?>
                    <a href="<?php echo uri('items/show').'/'.item('id').'?tags='.html_escape($exhibitName);?>"><?php echo item('Dublin Core', 'Title');?></a>
                </h2>

				<?php if (item_has_thumbnail()): ?>
    				<div class="item-img">
    				<?php echo link_to_item(item_square_thumbnail()); ?>						
    				</div>
				<?php endif; ?>
				
				<?php if ($text = item('Item Type Metadata', 'Text', array('snippet'=>250))): ?>
    				<div class="item-description">
    				<p><?php echo $text; ?></p>
    				</div>
				<?php elseif ($description = item('Dublin Core', 'Description', array('snippet'=>250))): ?>
    				<div class="item-description">
    				<?php echo $description; ?>
    				</div>
				<?php endif; ?>
				
				<?php echo plugin_append_to_items_browse_each(); ?>

			</div>
		<?php endwhile; ?>
	
		<div id="pagination-bottom" class="pagination"><?php echo pagination_links(); ?></div>
		
		<?php echo plugin_append_to_items_browse(); ?>
			
	</div><!-- end primary -->
	
<?php foot(); ?>