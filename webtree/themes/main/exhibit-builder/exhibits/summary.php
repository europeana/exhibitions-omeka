
<?php
$name = ve_get_exhibit_name_from_slug();
$itemInfo = ve_get_exhibit_item_info_by_tag($name.'-featured', 'archive');
$src = $itemInfo['src'];
$title = $itemInfo['title'];
$exhibit = get_current_exhibit();
unset($_SESSION['themes_uri']);
?>
<?php head(array('bodyid' => 'exhibit', 'bodyclass' => 'summary')); ?>
<?php //head(array('title' => html_escape(ve_title_crumbs()), 'bodyid' => 'exhibit', 'bodyclass' => 'summary')); ?>
<div id="primary" class="grid_16">
    <div class="grid_8 alpha">
        <h1><?php echo html_escape(exhibit('title')); ?></h1>
        <?php echo exhibit('description'); ?>
        <?php set_exhibit_sections_for_loop_by_exhibit(get_current_exhibit()); ?>

        <?php
        // make a flag for the fist page in the section. This is what we want to link to
        $firstpage = false;
        while (loop_exhibit_sections() && $firstpage == false):
            ?>
            <?php if (exhibit_builder_section_has_pages()): ?>
            <?php $firstpage = true; ?>
            <h3><a class='widget'
                href="<?php echo exhibit_builder_exhibit_uri(get_current_exhibit(), get_current_exhibit_section()); ?>"><?php echo ve_translate('exhibit-start', 'Start Exhibit'); ?><img src="<?php echo img('arrow-right.png');?>"/></a>
            </h3>
            <?php endif; ?>
        <?php endwhile; ?>

    </div>
    <div class="grid_8 omega">
        <div id="exhibit-image-wrapper">
            <div id="exhibit-image-border"></div>
            <div id="exhibit-image" style="background-image: url('<?php echo $src; ?>')"></div>
            <div id="exhibit-item-infocus-header">
                <?php
                    try {
                        echo ve_exhibit_builder_exhibit_display_item_info_link(array('imageSize' => 'square_thumbnail'));
                    }
                    catch (Exception $e) {
                        if(get_theme_option('display_admin_errors')){
                            echo '<div class="error">There is no item file (image) associated with the Exhibit Section: <strong>' . $exhibit->title . '</strong>.<br/>'
                            . 'Tag an image used in this exhibit section with: <strong><em>' . ve_get_exhibit_name_from_slug($exhibit) . '-featured</em></strong></div>';
                        }
                    }

                ?>
            </div>
        </div>
    </div>
</div>
<div class="clear"></div>
<?php foot(); ?>
