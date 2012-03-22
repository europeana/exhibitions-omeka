<?php head(array('bodyid'=>'exhibit','bodyclass'=>'exhibit-item-show')); ?>

<link rel="stylesheet" href="<?php echo css('mediaelement/mediaelementplayer'); ?>"/>

<div class="items grid_16">
    <div class="return-nav">

           <?php echo ve_return_to_exhbit(); ?>

    </div>
<div class="grid_8 alpha">

    <?php echo ve_exhibit_builder_exhibit_display_item(array('imageSize' => 'fullsize'), array('class' => 'box', 'id' => 'img-large', 'name' => 'exhibit-item-metadata-1')); ?>

    <?php
        if(!$exhibit){
            $exhibit = exhibit_builder_get_current_exhibit();
        }
        $showComments = ve_get_providers_key($exhibit->credits,'comments');
    ?>

    <?php if ($showComments == true): ?>

    <script language="javascript" type="text/javascript">
	var idcomments_acct = 'd146fd0062a40da4872b2d1fb16aadae';
    var idcomments_post_id;
    var idcomments_post_url;
    </script>
    <span id="IDCommentsPostTitle" style="display:none"></span>
    <script type='text/javascript' src='http://www.intensedebate.com/js/genericCommentWrapperV2.js'></script>

    <?php endif; ?>
</div>

<div class="grid_8 omega">
<!--	--><?php //echo show_item_metadata(array('show_empty_elements' => false, 'return_type' => 'html')); ?>
	<?php echo ve_custom_show_item_metadata(array('show_empty_elements' => false, 'return_type' => 'html')); ?>
</div>

</div>

<div class="clear"></div>

<?php foot(); ?>