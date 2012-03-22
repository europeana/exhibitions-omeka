<?php
  $queryString = '?tags=' . $_GET['tags'] . '&theme=' . $_GET['theme'];
?>
<?php head(array('title' => 'Browse Items', 'bodyid' => 'items', 'bodyclass' => 'browse')); ?>

<link rel="stylesheet" href="<?php echo css('mediaelement/mediaelementplayer'); ?>"/>

<div id="primary" class="grid_16">
    <div class="return-nav">
    <?php echo ve_return_to_exhbit($queryString); ?>
    </div>
    <h1>
        <?php echo ve_translate('items-browse', 'Browse Items');?>
        (<?php echo total_results(); ?> <?php echo ve_translate('items-total', 'total');?>)
    </h1>

    <div id="pagination-top" class="pagination"><?php echo pagination_links(); ?></div>
    <?php $count = 1?>
    <?php while (loop_items()): ?>

    <div class="grid_4 alpha">

        <h4>
            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>"><?php echo item('Dublin Core', 'Title');?></a>
        </h4>

        <?php if (item_has_thumbnail()): ?>
        <div class="item-img">
            <a href="<?php echo uri('items/show') . '/' . item('id') . $queryString; ?>">
                <?php echo item_square_thumbnail(); ?>
            </a>
        </div>
        <?php endif; ?>

        <?php echo plugin_append_to_items_browse_each(); ?>

    </div>

        <?php if($count%4==0):?>
            <div class="clear"></div>
        <?php endif; ?>

    <?php $count++; ?>
    <?php endwhile; ?>

     <div class="clear"></div>


    <div id="pagination-bottom" class="pagination">
        <?php echo pagination_links(); ?>
    </div>

    <?php echo plugin_append_to_items_browse(); ?>

</div><!-- end primary -->

<div id="primary" class="grid_16">
<?php
try {
	echo("RECORD ID = " . $_POST['record_id']);
	
	commenting_echo_comments();
	commenting_echo_comment_form();
	
} catch (Exception $e) {
    echo('Error: ' . $e->getMessage());
}
		
?>
</div>


<?php foot(); ?>