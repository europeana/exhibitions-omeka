<?php

add_plugin_hook('install', 'intense_debate_comments_install');
add_plugin_hook('uninstall', 'intense_debate_comments_uninstall');
add_plugin_hook('config', 'intense_debate_comments_config');
add_plugin_hook('config_form', 'intense_debate_comments_config_form');

add_plugin_hook('public_append_to_items_show', 'intense_debate_comments_public_append_to_items_show');

function intense_debate_comments_install()
{
    set_option('intense_debate_comments_add_comments_to_item_show_pages', '1');
}

function intense_debate_comments_uninstall()
{
    delete_option('intense_debate_comments_site_acct');
    delete_option('intense_debate_comments_add_comments_to_item_show_pages');
}

function intense_debate_comments_config()
{
    set_option('intense_debate_comments_site_acct', $_POST['intense_debate_comments_site_acct']);
    set_option('intense_debate_comments_add_comments_to_item_show_pages', $_POST['intense_debate_comments_add_comments_to_item_show_pages']);
}

function intense_debate_comments_config_form()
{  
    $siteAccountId = get_option('intense_debate_comments_site_acct');
?>
    <div class="field">
        <label for="intense_debate_comments_idcomments_acct">IntenseDebate site acct:</label>
        <?php echo __v()->formText('intense_debate_comments_site_acct', $siteAccountId, null);?>
        <p class="explanation">Enter your <a href="http://intensedebate.com">IntenseDebate</a> site acct id located in the Site Key section of your IntenseDebate account.</p>
    </div>
    <div class="field">
        <label for="simple_pages_filter_page_content">Add Comments To All Item Pages?</label>
        <?php echo __v()->formCheckbox('intense_debate_comments_add_comments_to_item_show_pages', true, 
        array('checked'=>(boolean)get_option('intense_debate_comments_add_comments_to_item_show_pages'))); ?>
        <p class="explanation">If checked, comments will be added to all item show pages.</p>
    </div>
<?php
}

function intense_debate_comments_public_append_to_items_show()
{
    $appendToItemShowPages = (boolean)get_option('intense_debate_comments_add_comments_to_item_show_pages');
    if ($appendToItemShowPages) {
        echo intense_debate_comments_display_comments();
    }
}

function intense_debate_comments_display_comments() 
{
    $idcommentsAcct = trim(get_option('intense_debate_comments_site_acct'));
    if ($idcommentsAcct == '') {
        return '';
    }
    
    ob_start();
?>
    <script>
    var idcomments_acct = '<?php echo $idcommentsAcct; ?>';
    var idcomments_post_id;
    var idcomments_post_url;
    </script>
    <span id="IDCommentsPostTitle" style="display:none"></span>
    <script type='text/javascript' src='http://www.intensedebate.com/js/genericCommentWrapperV2.js'></script>
<?php
    $ht = ob_get_contents();
    ob_end_clean();
    return $ht;
}