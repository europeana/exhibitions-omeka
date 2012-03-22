<?php head(array('title' => html_escape(exhibit('title') . ' : '. exhibit_page('title')), 'bodyid'=>'exhibit','bodyclass'=>'show')); ?>
<div id="primary">


<h1>HELLO from plugins/Exhibit/views/public/exhibits/show</h1>
<?php error_log("HELLO from plugins/Exhibit/views/public/exhibits/show"); ?>

	<h1><?php echo link_to_exhibit(); ?></h1>

    <div id="nav-container">
    	<?php echo exhibit_builder_section_nav();?>
    	<?php echo exhibit_builder_page_nav();?>
    </div>

	<h2><?php echo exhibit_page('title'); ?></h2>
	
	<?php exhibit_builder_render_exhibit_page(); ?>
	
	<div id="exhibit-page-navigation">
	   	<?php echo exhibit_builder_link_to_previous_exhibit_page(); ?>
    	<?php echo exhibit_builder_link_to_next_exhibit_page(); ?>
	</div>
</div>	
<?php foot(); ?>
<h1>GOODBYE from plugins/Exhibit/views/public/exhibits/show</h1>
