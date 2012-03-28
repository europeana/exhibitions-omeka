<?php
// Check if the querystring is available to see for what provider we need to show exhibits
if(isset($_GET['tags'])) {
    $tags = $_GET['tags'];
    // set the cookie with the provider name from the tags so that we can return to it via the breadcrumbs
//    setcookie("ve_browse", $tags, time()+3600);
    setcookie("ve_browse", $tags);
}
elseif (!isset($_GET['tags']) && isset($_COOKIE['ve_browse'])){
    // most likely we are returning to this page via a breadcrumb, we must use the cookie to load the proper exhibits
   $tags =  $_COOKIE['ve_browse'];
}

$exhibits = exhibit_builder_get_exhibits(array('tags' => $tags));


$html = '<h1 class="grid_16">' . ve_translate("exhibits-browse", "Browse Exhibits") . '</h1>';
$html .= '<div id="exhibit-summary-container" class="grid_16">';



if (sizeof($exhibits) > 0) {
    $counter = 0;
    foreach ($exhibits as $exhibit) {
        $eName = ve_get_exhibit_name_from_slug($exhibit);
        $itemInfo = ve_get_exhibit_item_info_by_tag($eName.'-featured', 'square_thumbnail');
        $src = $itemInfo['src'];

        $html .= '<div class="exhibit-summary grid_4 exhibit-theme-container">';

        if($src!=''){
            $html .= '<div class="exhibit-theme-image">'. exhibit_builder_link_to_exhibit($exhibit, '<img src="' . $src . '" />') . '</div>';
            $html .= '<div class="exhibit-theme-image-overlay"></div>';
        }
        else {
            if(get_theme_option('display_admin_errors')){
                $html .= '<div style="height:200px" class="error">';
                $html .= '<p>There is no item file (image) associated with the Exhibit Section: <strong>' . $exhibit->title  . '</strong></p>';
                $html .= '<p>Tag an image used in this exhibit section with the following: <strong>'. ve_get_exhibit_name_from_slug($exhibit)  . '-featured</strong></p>';
                $html .= '</div>';
            }
        }
        $html .= '<h3>' . exhibit_builder_link_to_exhibit($exhibit, $exhibit->title . '', $props = array('class' => 'widget')) . '</h3>';
        $html .= snippet($exhibit->description, 0, 200);

        $html .= '</div>';
    }
}
else {
    $html .= ve_translate('exhibits-none-this-language', "There are currently no exhibits available in this language");
}

$html .= '</div>';
?>
<?php head(array('title' => html_escape('Browse Exhibits'), 'bodyid' => 'exhibit', 'bodyclass' => 'browse')); ?>

<!-- div id="primary" -->

<div class="twelve columns">
	<?php  echo $html; ?>
</div>

<!--/div-->

<div class="clear"></div>

<?php foot(); ?>

<?php



?>