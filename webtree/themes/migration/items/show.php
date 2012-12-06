<?php
  $returnPoint = $_SERVER['HTTP_REFERER'];
//  $exhibit = exhibit_builder_get_current_exhibit();
//  $page = exhibit_builder_get_current_page();
//  $collection = collection('Name');
//  $exhibit =  html_escape(exhibit('title'));
//  $section =  exhibit_section('title');
//  $page = exhibit_page('title');
?>
<?php head(array('title' => item('Dublin Core', 'Title'), 'bodyid' => 'items', 'bodyclass'=>'exhibit-item-show')); ?>

<div id="primary" class="grid_16">

    <div id="top-nav">
        <?php if ($returnPoint): ?>
        <h2><a href="<?php echo uri('items/browse') . '?tags=' . $_GET['tags']; ?>"><?php echo ve_translate('back', 'Back');?><span
            class="icon arrow left"></span></a></h2>
        <?php endif; ?>
    </div>

    <div class="grid_8 alpha">
        <?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>
    </div>

    <div class="grid_8 omega">

<!--        <ul class="item-pagination navigation">-->
<!--            <li id="previous-item" class="previous">--><?php //echo link_to_previous_item('Previous Item'); ?><!--</li>-->
<!--            <li id="next-item" class="next">--><?php //echo link_to_next_item('Next Item'); ?><!--</li>-->
<!--        </ul>-->

        <?php echo show_item_metadata(array('show_empty_elements' => false, 'return_type' => 'html')); ?>
    </div>


</div><!-- end primary -->

<?php foot(); ?>