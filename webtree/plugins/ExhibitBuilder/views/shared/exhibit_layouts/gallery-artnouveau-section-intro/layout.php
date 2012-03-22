<?php
 //*************************************************************************************************************************
//Name: gallery-artnouveau-section-intro
//Description: An image gallery page, with text on the left and, on the right, one large image.
//Author: Eric van der Meulen, eric.meulen@gmail.com;
//*************************************************************************************************************************

if (!$page) {
    $page = exhibit_builder_get_current_page();
}
$section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
$exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
//echo $html;
$theme = $section->title;
$story = $page->title
?>

<div class="grid_9" id="story">


    <div id="exhibit-section-title">
        <div class="error">This layout is no longer used. Please use the 'Intro' layout</div>
        <h3>
            <?php echo $theme . ' - ' . $story; ?>
        </h3>
    </div>

    <div class="exhibit-text">
        <?php if ($text = exhibit_builder_page_text(1)) { echo exhibit_builder_page_text(1); } ?>
    </div>

    <div class="exhibit-page-nav">

        <?php echo ws_exhibit_builder_link_to_previous_exhibit_page("&larr;", array('class' => 'exhibit-text-nav'));?>

        <?php echo ws_exhibit_builder_page_nav(); ?>

        <?php echo ws_exhibit_builder_link_to_next_exhibit_page("&rarr;", array('class' => 'exhibit-text-nav'));?>

    </div>

</div>

<div class="grid_1 flush">
    <?php if (exhibit_builder_use_exhibit_page_item(1)): ?>
        <div id="exhibit-item-link">
            <?php echo ws_exhibit_builder_link_to_exhibit_item('Item information', array('name' => 'exhibit-item-metadata-1')); ?>
        </div>
    <?php endif; ?>
</div>
<div class="grid_6 flush" id="items">

    <?php if (exhibit_builder_use_exhibit_page_item(1)): ?>
        <div id="exhibit-item-in-focus" class="exhibit-item">
            <?php echo ws_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>
        </div>
    <?php endif; ?>

</div>

<?php if (exhibit_builder_use_exhibit_page_item(1)): ?>
    <?php echo ws_exhibit_builder_exhibit_item_meta_data(1, 5, array('class' => 'metadata'),true); ?>
<?php endif; ?>

<script type="text/javascript">
    $(document).ready(function() {
        var viewerHeight =  $(window).height()-100;
        switchStoryImage();
        //$("a[rel=fancybox]").fancybox();
        $("a.box").click(function() {
            $.fancybox([
                <?php
                    $output = '';
                    for ($i=(int)1; $i <= (int)1; $i++) {
                        if (exhibit_builder_use_exhibit_page_item($i)) {
                             $output .= "'" . item_uri() . "'";
                         }
                    }
                    echo $output;
                 ?>
             ], {
                'index'             : itemIndex,
                'padding'           : 0,
                'transitionIn'      : 'fade',
                'transitionOut'     : 'fade',
                'type'              : 'iframe',
                'changeFade'        : 0,
                'autoDimensions'    : false,
                'autoScale'         : false,
                'width'             : 620,
                'height'            : viewerHeight,
                'modal'             : false
            });
            return false;
        });
});
</script>


