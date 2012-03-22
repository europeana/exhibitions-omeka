<?php
if (!$page) {
    $page = exhibit_builder_get_current_page();
}

?>

<div id="nav-container">
    <div id="exhibit-breadcrumb-nav" class="grid_16">
        <?php echo ws_an_main_navigation(); ?>
    </div>
</div>

<div class="grid_9" id="story">
    <img src="<?php echo img('an-header-title.png'); ?>" alt="Art Nouvea Virtual Exhibition"/>
    <?php
//this image item needs to be retreived manually by id, since it is not part of an exhibit section
    set_current_item(get_item_by_id(9));
    ?>
    <p>
        For a brief and brilliant period at the end of the 19th century Ð starting around 1890, and tailing off before
        World
        War One Ð Art Nouveau dominated the cultural scene. Everything from domestic furnishings and decorative art to
        architecture and advertising was characterised by its curvilinear elegance and organic forms inspired by nature.
        Even today, decades after the emergence of Art Nouveau, artists and designers continue to be inspired by the
        floral
        elements, natural features and colours of this enduring style.
    </p>

    <p>
        <a href="themes" title="Start Exhibition" class="page-next">
            Start Exhibition
        </a>
    </p>
</div>

<div class="grid_1 flush">
    <div id="exhibit-item-link">
        <?php echo ws_exhibit_builder_link_to_exhibit_item('Item information', array('name' => 'exhibit-item-metadata-1')); ?>
    </div>
</div>

<div class="grid_6 flush" id="items">

        <div id="exhibit-item-in-focus" class="exhibit-item">
            <?php echo ws_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>
        </div>

</div>

<?php echo ws_exhibit_item_metadata(1, 1, array('class' => 'metadata')); ?>

<script type="text/javascript">
    $(document).ready(function() {
        var viewerHeight = $(window).height() - 100;
        switchStoryImage();
        $("a[rel=fancybox]").fancybox();
        $("a.box").click(function() {
            $.fancybox([
                '<?php echo item_uri();?>'
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