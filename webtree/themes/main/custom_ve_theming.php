<?php
/**
 * Created by Eric van der Meulen, Delving B.V. http:www.delving.eu
 * Date: 5/23/2011
 * Time: 17:20 PM
 */

/*
 * Used to set/get all the necessary session variables
 */
function ve_session_vars($lang=null)
{
    if (isset($_COOKIE["ve_lang"])){
        $_SESSION[$lang] = $_COOKIE["ve_lang"];
    }
    else {
        $_SESSION[$lang] = "en";
    }

    // A dirty way to get the exhibit provider name from within various levels of the exhibit.
    // Used to display provider's name in the navigation breadcrumbs.
    // See: custom.php: ve_exhibit_breadcrumbs();
    $collection = collection('Name');
    if (trim($collection) != '') {
        $_SESSION["collection"] = $collection;
    } else {
        try {

            $item = get_current_item();
            $collection = get_collection_for_item($item);
            $_SESSION["collection"] = $collection->name;
        }
        catch (Exception $e) {
            // do nothing
        }

    }
}


function ve_set_exhibits_css()
{
		       
    queue_css('foundation/stylesheets/foundation');
    queue_css('foundation/stylesheets/app');
    
	queue_css(('reset'));
    queue_css(('text'));
    
    //queue_css(('960'));
    //queue_css('skeleton/stylesheets/base');
    //queue_css('skeleton/stylesheets/skeleton');

    
//    queue_css('collapse_files/responsive');
    
    
    queue_css('style');
    queue_css('commenting-overrides');

    
    
    //queue_css('blackbird/blackbird');

    // Dirty way of maintaining the theme. If there's a theme query string than use path to theme css
    if(!isset($_GET['theme'])) {
        queue_css('theme');
        queue_css('collapse_files/responsive');
        display_css();
    }
    else {
    	queue_css('collapse_files/responsive');
        display_css();
        
        echo '<link rel="stylesheet" type="text/css" media="all" href="' . WEB_ROOT . '/themes/' . $_GET['theme'] . '/css/theme.css' . '"/>';
     }
}

function ve_set_exhibit_js()
{
    echo display_js();
    // When browsing items, we move outside of the exhibit themes. The exhibit slug name should be appended to the url
    // so that we can grab the images with the exhibit theme path
    if (isset($_GET['theme'])) {
        echo '<script type="text/javascript">if(typeof(setThemePaths) != "undefined"){setThemePaths("'.$_GET['theme'].'");}</script>';
    }

    
    echo js('seadragon-min/seadragon-min');
    echo js('jquery.cookie');
    echo js('mediaelement/build/mediaelement-and-player');
    echo js('global');
//    echo js('blackbirdjs/blackbird');
}

/*
 * HELPER FUNCTION
 * Gets the provider array for information that cannot be housed elsewhere. Used for secondary branding and theming
 * And checking to see if a provider allows the IntenseDebate plugin to be active
 */
function ve_get_providers_key($provider, $key)
{
    include('custom_ve_providers.php');
    return $providers[$provider][$key];
}

/*
 * HELPER FUNCTION
 * Attempts to retrieve the logo of a given provider under an active theme
 */
function ve_get_provider_logo($logoName = null)
{
    try {
        $logo = img($logoName);
    }
    catch (Exception $e) {
        $logo = img("logo.png");
    }
    $html = '<div class="provider-logo">';
    $html .= '<img src="' . $logo . '"/>';
    $html .= '</div>';
    return $html;
}

/*
 * HELPER FUNCTION
 * Attempts to retrieve the provider logo for secondary branding
 */
function ve_exhibit_secondary_logo($exhibit = null)
{
    if (!$exhibit) {
        $exhibit = exhibit_builder_get_current_exhibit();
    }
    try {
        $logoSrc = img(ve_get_providers_key($exhibit->credits, 'logo'));
        $targetUrl = ve_get_providers_key($exhibit->credits, 'url');

        if (isset($logoSrc) && isset($targetUrl)) {
            return '<a href="' . $targetUrl . '" target="_blank"><img src="' . $logoSrc . '"/></a>';
        }
        else {
            return '';
        }
    }
    catch (Exception $e) {
        // do nothing
    }
}

