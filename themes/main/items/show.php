<?php
  $returnPoint = $_SERVER['HTTP_REFERER'];
  $queryString = '?tags=' . $_GET['tags'] . '&theme=' . $_GET['theme'];
?>

<?php head(array('title' => item('Dublin Core', 'Title'), 'bodyid' => 'items', 'bodyclass'=>'exhibit-item-show')); ?>
<link rel="stylesheet" href="<?php echo css('mediaelement/mediaelementplayer'); ?>"/>

<div id="primary" class="grid_16">

    <div class="return-nav">
            <div class="grid_8 alpha"><?php echo ve_return_to_exhbit(); ?></div>
            <?php if ($returnPoint): ?>
                <div class="grid_8 omega t-right"><a class="widget" href="<?php echo uri('items/browse') . $queryString; ?>"><span class="icon arrow left"></span><?php echo ve_translate('back', 'Back');?></a></div>
           <?php endif; ?>

    </div>

    <div class="clear"></div>

    <div class="grid_8 alpha">
        <?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>
    </div>

    <div class="grid_8 omega">

<!--        <ul class="item-pagination navigation">-->
<!--            <li id="previous-item" class="previous">--><?php //echo link_to_previous_item('Previous Item'); ?><!--</li>-->
<!--            <li id="next-item" class="next">--><?php //echo link_to_next_item('Next Item'); ?><!--</li>-->
<!--        </ul>-->

        <!--<?php //echo show_item_metadata(array('show_empty_elements' => false, 'return_type' => 'html')); ?> -->
        <?php echo ve_custom_show_item_metadata(array('show_empty_elements' => false, 'return_type' => 'html')); ?>

    </div>

    <div id="primary" class="grid_16">
		<php commenting_echo_comments(); >
		<php commenting_echo_comment_form(); >
	</div>
	
<?php
try {
	echo("RECORD ID = " . $_POST['record_id']);
	
	commenting_echo_comments();
	commenting_echo_comment_form();
	
} catch (Exception $e) {
    echo('Error: ' . $e->getMessage());
}

		
?>
	
    

</div><!-- end primary -->
<script type="text/javascript">
jQuery(document).ready(function() {
   setThemePaths("<?php echo $_GET['theme']; ?>");
});
</script>
<?php foot(); ?>