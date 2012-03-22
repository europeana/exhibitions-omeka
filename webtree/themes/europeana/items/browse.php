<?php head(array('title'=>'Browse Items','bodyid'=>'items','bodyclass' => 'browse')); ?>

<div class="nav-container">
    <div id="exhibit-breadcrumb-nav" class="grid_16">
        <ul>
            <li class="first">
                <a href="<?php echo uri('exhibits/show/art-nouveau/introduction');?>">Introduction</a>
            </li>
            <li>Browse all items</li>
        </ul>
    </div>
</div>

	<div id="primary" class="grid_16">
		
		<h2>Browse Items (<?php echo total_results(); ?> total)</h2>
		
		<div id="pagination-top" class="pagination"><?php //echo pagination_links(array('per_page' => '12')); ?></div>
		   <?php echo  pagination_links(array(null, null, '10', null, null, '20'));?>
		<?php $counter = 1; while (loop_items()): ?>
<?php
$class="";
if ($counter==1||$counter==5||$counter==9){$class="alpha";}
if ($counter==4||$counter==8||$counter==12){$class="omega";}
?>
                <div class="item entry grid_4 <?php echo $class;?>">
                    <div class="item-meta">

                    <?php if (item_has_thumbnail()): ?>
                        <div class="item-img">
                        <?php echo link_to_item(item_square_thumbnail(),array('class' => 'fancybox', 'rel' => 'fancybox')); ?>
                        </div>
                    <?php endif; ?>


                    <?php if ($title = item('Dublin Core', 'Title', array('snippet'=>150))): ?>
                        <div class="item-title">
                            <label>Title: </label><?php echo $title; ?>
                        </div>
                    <?php endif; ?>

                    <?php if ($description = item('Dublin Core', 'Description', array('snippet'=>150))): ?>
                        <div class="item-description">
                            <label>Description: </label><?php echo $description; ?>
                        </div>
                    <?php elseif ($text = item('Item Type Metadata', 'Text', array('snippet'=>150))): ?>
                        <div class="item-description">
                            <label>Description: </label><?php echo $text; ?>
                        </div>
                    <?php endif; ?>

                    <?php if (item_has_type('Europeana Object')): ?>
                         <label>Provider: </label><?php echo item('Item Type Metadata', 'Provider'); ?>
                     <?php endif; ?>

                    <?php if (item_has_tags()): ?>
                        <div class="tags"><p><strong>Tags:</strong>
                        <?php echo item_tags_as_string(); ?></p>
                        </div>
                    <?php endif; ?>

                    <?php echo plugin_append_to_items_browse_each(); ?>

                    </div><!-- end class="item-meta" -->
                </div><!-- end class="item hentry" -->

            <?php if ($counter==4||$counter==8):?>
                <div class="clear"></div>
            <?php endif; ?>
		<?php $counter++; endwhile; ?>
	    <div class="clear"></div>
		<div id="pagination-bottom" class="pagination"><?php //echo pagination_links($options = array('per_page'=>12)); ?></div>
		
		<?php echo plugin_append_to_items_browse(); ?>
			
	</div><!-- end primary -->
<script type="text/javascript">
    $(document).ready(function() {
        var viewerHeight =  $(window).height()-100;
        switchStoryImage();
        $("a.fancybox").fancybox({
                'padding'           : 0,
                'transitionIn'      : 'fade',
                'transitionOut'     : 'fade',
                'type'              : 'iframe',
                'changeFade'        : 0,
                'autoDimensions'    : false,
                'autoScale'         : false,
                'width'             : 620,
                'height'            : viewerHeight,
                'modal'             : false,
                'titleShow'         : false
        });

});
</script>
<?php foot(); ?>