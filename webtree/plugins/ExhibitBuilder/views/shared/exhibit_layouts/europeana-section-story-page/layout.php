<?php
 //*************************************************************************************************************************
//Name: gallery-artnouveau-section-page
//Description: An image gallery, with text on the left and, on the right, one large image with a thumbnail gallery below it.
//Author: Eric van der Meulen, eric.meulen@gmail.com;
//*************************************************************************************************************************
if (!$page) {
    $page = exhibit_builder_get_current_page();
}
$section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
$exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
$theme = $section->title;
$story = $page->title
?>

<link rel="stylesheet" href="<?php echo css('mediaelement/mediaelementplayer'); ?>"/>
<link rel="stylesheet" href="<?php echo css('mediaelement/mejs-skins'); ?>"/>
<style type="text/css">




</style>
<div class="grid_8 alpha" id="story">

    <div id="exhibit-section-title">

        <h3>
            <?php echo $theme . ' - ' . $story; ?>
        </h3>
    </div>

    <div class="exhibit-text">
        <?php if ($text = exhibit_builder_page_text(1)) {
        echo exhibit_builder_page_text(1);
    } ?>
    </div>

    <div class="exhibit-page-nav">

        <?php echo ve_exhibit_builder_link_to_previous_exhibit_page("&larr;", array('class' => 'exhibit-text-nav'));?>

        <?php echo ve_exhibit_builder_page_nav(); ?>

        <?php echo ve_exhibit_builder_link_to_next_exhibit_page("&rarr;", array('class' => 'exhibit-text-nav'));?>

    </div>

</div>

<div class="grid_8 omega" id="items">
    <?php if (exhibit_builder_use_exhibit_page_item(1)): ?>

    <div id="exhibit-item-infocus" class="exhibit-item">
        <div id="exhibit-item-infocus-header">
            <?php echo ve_exhibit_builder_exhibit_display_item_info_link(array('imageSize' => 'fullsize')); ?>
        </div>
        <div id="exhibit-item-infocus-item">

            <?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>
            <ve_exhibit_builder_exhibit_display_item_responsively(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1'));>
            
        </div>
    </div>
    <?php endif; ?>
    <div class="clear"></div>
    <div id="exhibit-item-thumbnails">
        <?php echo ve_exhibit_builder_display_exhibit_thumbnail_gallery(1, 5, array('class' => 'thumb')); ?>
    </div>
</div>
<?php echo js('seadragon-min'); ?>
<?php echo js('story'); ?>

	<h1>
		plugins/ExhibitBuilder/views/shared/exhibit_layouts/europeana-section-story-page/layout.php
	</h1>
	<h1>
    	europeana section story page...
	</h1>
    <br>
    ORANGE
    <br>
<?php
/*
try {
	echo("RECORD ID = " . $_POST['record_id']);
	commenting_echo_comments();
	commenting_echo_comment_form();
	
} catch (Exception $e) {
    echo('Error: ' . $e->getMessage());
}
*/	
?>
<script>
    var viewer = new Seadragon.Viewer("div#zoomit-container");
    viewer.openDzi("logo.dzi");
</script>


<script type="text/javascript">
alert("layout\n(plugins ExhibitBuilder views shared exhibit_layouts europeana-story-section)\n\n try to make gallery");
var suffixes = {
	<?php
		//$BREAKPOINTS = explode("~", get_option('euresponsive_breakpoints'));
		$IMAGEWIDTHS = explode("~", get_option('euresponsive_imagewidths'));
		for ($i = 0; $i < sizeof($IMAGEWIDTHS); $i++) {
			$j = $i+1;
			if($IMAGEWIDTHS[$i]>-1){
			  echo "'".$j."': '_euresponsive_".$j.".jpg'";
			}
			else{
			  echo "'".$j."': 'z'".PHP_EOL;
			}
			if($j<sizeof($IMAGEWIDTHS)){
			 	echo ",";
			}
			echo PHP_EOL;

		}
	?>
};
responsiveGallery({
	scriptClass:	'dirty-script',
	testClass:		'euresponsive-width',
	initialSuffix:	'_euresponsive_1.jpg',
	suffixes :		suffixes
});

</script>