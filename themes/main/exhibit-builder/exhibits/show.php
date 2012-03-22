<?php head(array('bodyid'=>'exhibit','bodyclass'=>'show')); ?>

<div id="primary" class="sixteen columns alpha clearfix">

    <div id="content" xxxxclass="grid_16" class="sixteen columns alpha clearfix">


<!--    <div id="nav-container">-->
<!--    	--><?php //echo exhibit_builder_section_nav();?>
<!--    	--><?php //echo exhibit_builder_page_nav();?>
<!--    </div>-->

	<?php exhibit_builder_render_exhibit_page(); ?>

    </div>

</div>

<div class="clear"></div>
<?php foot(); ?>