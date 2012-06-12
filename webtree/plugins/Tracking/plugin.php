<?php

add_plugin_hook('install',			'tracking_install');
add_plugin_hook('uninstall',		'tracking_uninstall');
add_plugin_hook('define_routes',	'tracking_define_routes');

add_filter('admin_navigation_main', 'tracking_admin_navigation_main');


/**
 * Add the Track Embed link to the admin main navigation.
 * 
 * @param array Navigation array.
 * @return array Filtered navigation array.
 */

function tracking_admin_navigation_main($nav)
{
    $nav['Track Embeds'] = uri('track-embed');
    return $nav;
}


function tracking_install()
{
    $db = get_db();
    $sql = "
   		CREATE TABLE IF NOT EXISTS `$db->TEmbeds` (
          `id`				int(10) unsigned NOT NULL AUTO_INCREMENT,
          `referer`			tinytext COLLATE utf8_unicode_ci NOT NULL,
          `resource`		tinytext COLLATE utf8_unicode_ci NOT NULL,
          `last_accessed`	timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
          `view_count`		int(15)	unsigned NOT NULL,
          `period`			int(6)	unsigned NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ";
    $db->exec($sql);
    error_log("Created tracking database");
}

function tracking_uninstall()
{
    $db = get_db();
    $sql = "DROP TABLE IF EXISTS `$db->TEmbeds`";
    $db->exec($sql);
}



function tracking_define_routes($router)
{
	error_log("Embed route (1)");
    $router->addRoute(
        'track_embed_download_route', 
        new Zend_Controller_Router_Route(
            'track_embed/download/:id', 
            array(
                'module'       => 'tracking', 
                'controller'   => 'Tracking',
                'action'        => 'download'
                )
        )
	);
    error_log("Embed route (2)");
}