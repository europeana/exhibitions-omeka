<?php head(array('bodyid'=>'home', 'bodyclass' =>'two-col')); ?>
<div id="primary">
    <?php if ($homepageText = get_theme_option('Homepage Text')): ?>
    <p><?php echo $homepageText; ?></p>
    <?php endif; ?>
    <?php if (get_theme_option('Display Featured Item') == 1): ?>
    <!-- Featured Item -->
    <div id="featured-item">
        <?php echo display_random_featured_item(); ?>
    </div><!--end featured-item-->
    <?php endif; ?>

    <!-- Recent Items -->
    <div id="recent-items">
      <?php
//      $collections = get_collections();
//
//      foreach ($collections as $collection) {
//        echo '<h2>' . $collection->name . '</h2>';
//        echo '<p>' . $collection->description . '</p>';
//      }
      ?>
       <?php
//      echo WEB_DIR;

      ?>
<?php set_collections_for_loop(recent_collections(3)); ?>
<?php while (loop_collections()): ?>
	<div id="collection">
		<div class="item">
			<?php while (loop_items_in_collection(1)): ?>
    				<?php if (item_has_thumbnail()): ?>
    					<div class="item-img">
			    			<?php echo link_to_collection(item_square_thumbnail(array('alt'=>item('Dublin Core', 'Title')))); ?>
			    		</div>
    				<?php endif; ?><?php endwhile; ?>
				<h2><?php echo link_to_collection() ?></h2>
	        		<div class="element">
 	 	          		<div class="element-text">
					<?php echo nls2p(collection('Description', array('snippet'=>300))); ?>
					</div>
       			</div>

		</div>

		<div class="element">
            	<?php if(collection_has_collectors()): ?>
            		<h3>Collector(s)</h3>
				<div class="element-text">
                    		<p><?php echo collection('Collectors', array('delimiter'=>', ')); ?></p>
	           		</div>
            	<?php endif; ?>
	 	</div>

	<?php echo plugin_append_to_collections_browse_each(); ?>

	</div><!-- end class="collection" -->
<?php endwhile; ?>

</div><!-- end primary -->
<div id="secondary">
    <?php if (get_theme_option('Display Featured Collection')): ?>
    <!-- Featured Collection -->
    <div id="featured-collection">
        <?php echo display_random_featured_collection(); ?>
    </div><!-- end featured collection -->
    <?php endif; ?>
    <?php if ((get_theme_option('Display Featured Exhibit')) && function_exists('exhibit_builder_display_random_featured_exhibit')): ?>
    <!-- Featured Exhibit -->
    <?php echo exhibit_builder_display_random_featured_exhibit(); ?>
    <?php endif; ?>
    </div><!-- end recent-collections -->
</div><!-- end secondary -->
<?php foot(); ?>