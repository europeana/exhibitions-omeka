<?php

add_plugin_hook('install',			'eumap_install');
add_plugin_hook('uninstall',		'eumap_uninstall');
add_plugin_hook('define_routes',	'eumap_define_routes');


add_filter('admin_navigation_main', 'eumap_admin_navigation_main');

function eumap_admin_navigation_main($nav)
{
    $nav['EU Maps'] = uri('eumap');
    return $nav;
}


function eumap_install()
{
	error_log("Create EUMap database.....");
    $db = get_db();
    $sql = "
   		CREATE TABLE IF NOT EXISTS `$db->EUMap` (
          `id`				int(10) unsigned NOT NULL AUTO_INCREMENT,
          `tag`				varchar(255) NOT NULL,
          `nw_lat`			varchar(7) NOT NULL,
          `nw_lon`			varchar(7) NOT NULL,
          `se_lat`			varchar(7) NOT NULL,
          `se_lon`			varchar(7) NOT NULL,
          PRIMARY KEY (`id`)
        ) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
    ";
    $db->exec($sql);
    error_log(".....created EUMap database");
}

function eumap_uninstall()
{
    $db = get_db();
    $sql = "DROP TABLE IF EXISTS `$db->EUMap`";
    $db->exec($sql);
}

function eumap_define_routes($router)
{
	
    $router->addRoute(
        'eumap_add_route', 
        new Zend_Controller_Router_Route(
            'service/eumap/:id', 
            array(
                'module'       => 'eumap', 
                'controller'   => 'Map',
                'action'       => 'add'
                )
        )
   	);

}
