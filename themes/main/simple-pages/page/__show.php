<?php 

$bodyclass = 'page simple-page';
if (simple_pages_is_home_page(get_current_simple_page())) {
    $bodyclass .= ' simple-page-home';
}


?>

<?php head(array('title' => html_escape(simple_page('title')), 'bodyclass' => $bodyclass, 'bodyid' => html_escape(simple_page('slug')))); ?>
<div id="primary">
    <?php echo eval('?>' . simple_page('text')); ?>
</div>

<?php echo foot(); ?>