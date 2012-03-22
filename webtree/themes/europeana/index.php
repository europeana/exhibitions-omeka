<?php
    //skip page, go directly to art-nouveau introduction
    header("Location: ".uri("exhibits/show/art-nouveau/introduction"));
    exit;
    head(array('bodyid'=>'home'));
?>

<div id="primary">
    <h1>Europeana Virtual Exhibitions</h1>
    <p>
       Lorem ipsum dolor sit amet, consectetur adipiscing elit. Duis et tellus vel nisi sagittis scelerisque sed nec eros.
        Curabitur ultrices porttitor dolor, sit amet fringilla justo dapibus nec. Sed nulla nisl, iaculis at ornare id,
        ultrices eu nunc. Proin egestas turpis et nibh bibendum convallis. Ut iaculis lacus nec lectus aliquet eget imperdiet
        lacus suscipit. Nulla vel justo a eros consequat venenatis a ut nisl. Aenean rutrum, mauris sit amet venenatis
        euismod, lectus nisi egestas turpis, sed vehicula elit mi a justo. Nullam volutpat elit at massa feugiat euismod.
        Mauris vel mi neque. Nam nibh justo, auctor ut semper sit amet, consequat a felis. 
    </p>

	<div id="recent-items">
		<h2>Recently Added Items</h2>

		<?php set_items_for_loop(recent_items(3)); ?>
		<?php if (has_items_for_loop()): ?>

		<div class="items-list">
			<ul>
			<?php while (loop_items()): ?>





				<?php if (item_has_thumbnail()): ?>
    				<li>
    				    <?php echo link_to_item(item_square_thumbnail()); ?>
    				</li>
				<?php endif; ?>



			<?php endwhile; ?>
                </ul>
		</div>

		<?php else: ?>
			<p>No recent items available.</p>

		<?php endif; ?>

		<p class="view-items-link"><a href="<?php echo html_escape(uri('items')); ?>">View All Items</a></p>

	</div><!--end recent-items -->
 
</div><!-- end primary -->

<div id="secondary">

    <!-- Featured Exhibit(s) -->
    <div id="featured-exhibit">
    <?php
    $exhibits = exhibit_builder_get_exhibits(array('featured' => true));
    echo exhibit_builder_display_random_featured_exhibit();
    /*
    foreach($exhibits as $exhibit) {
        echo $exhibit->title;
    }
    */
    ?>
    </div>

		
</div><!-- end secondary -->
	
<?php foot(); ?>