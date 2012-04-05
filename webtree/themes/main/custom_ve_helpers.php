<?php
/**
 * Created by Eric van der Meulen, Delving B.V. http:www.delving.eu
 * Date: 5/23/2011
 * Time: 17:11 PM
 */

   error_log("ANDY: themes/main/custom ve helpers 0 underscores");

/*
 * TRANSLATION FUNCTION:
 * @param $label - xml tag name to be grabbed - see /themes/main/translations.xml
 * @param $defaults - fallback text string to use if xml tag is not found, or if language within tag not available
 *
 */
function ve_translate($label, $default)
{
    // set the language
    $lang = isset($_COOKIE['ve_lang']) ? $_COOKIE['ve_lang'] : 'en';
    //load xml file with translations as array
//    $xml = simplexml_load_file(WEB_THEME . '/main/translations.xml');
    // Set the system path to here
    $dir = dirname(__FILE__);
    $xml = simplexml_load_file($dir . '/translations.xml');
//    $xml = simplexml_load_file("translations.xml");
//       $translation = $xml->{strtolower(trim($label))}->$lang;
    $translation = $xml->{strtolower(trim($label))}->$lang;
    //    print_r($translation);
    if (trim($translation) != '') {
        return $translation;
    }
    else {
        return $default;
    }
}

/*
 * Display language dropdown.
 * Will return user to the index. onChange Functionality for this form is found in theme/main/javascripts/global.js
 * with the function setLanguage().
 */
function ve_language_select()
{
    $html = '<form id="setLang" name="setLang" action="" method="POST">';
    $html .= '<select name="lang" id="lang" onchange="setLanguage(this.value)">';
    $html .= '<option value="">' . ve_translate("choose-a-language", "Choose a language") . '</option>';
    $html .= '<option value="de">Deutsch (deu)</option>';
    $html .= '<option value="nl">Nederlands (dut)</option>';
    $html .= '<option value="en">English (eng)</option>';
    $html .= '<option value="es">Espa&#241;ol (esp)</option>';
    $html .= '<option value="fr">Fran&#231;ais (fre)</option>';
  	$html .= '<option value="it">Italiano (ita)</option>'; 
    $html .= '<option value="lv">Latvie&#353;u (lav)</option>';
    $html .= '<option value="pl">Polski (pol)</option>';
	$html .= '<option value="ru">Russian (rus)</option>';
	$html .= '<option value="sv">Svenska (sve/swe)</option>';
    $html .= '</select></form>';
    return $html;
}


/*
 * Used to display untitled items
 */
 
 // Andy - delete this add_filter???
 //add_filter(array('Display', 'Item', 'Dublin Core', 'Title'), 'show_untitled_items');
 

/*
 * Used to simple page object to use it's values outside of the SimplePage environment
 */
function ve_get_page_by_slug($pageSlug)
{
    $table = get_db()->getTable('SimplePagesPage');
    $select = $table->getSelect();
    $select->where('s.slug = ?', array($pageSlug));
    $pages = $table->fetchObjects($select);
    if ($pages) {
        $page = $pages[0];
        return $page;
    } else {
        return null;
    }
}

/*
 * DEBUG HELPER FUNCTION:
 * @param: $item object
 * Displays values contained within the object.
 *
 */
function ve_show_object_values($item)
{
    $html = '<dl>';
    $html .= '<dt>Item Values</dt>';
    foreach ($item as $key => $value) {
        $html .= '<dd>';
        $html .= $key . ': ' . strip_tags($value);
        $html .= '</dd>';
    }
    //    if(item_has_files($item)){
    //        $html .= '<dt>Item Files</dt>';
    //        $fileIndex = 0;
    //        foreach ($item->Files as $file) {
    //            $fileLocation = file_display_uri($file, $format = 'archive');
    //            $html .= '<dd>path: ' . $fileLocation . '</dd>';
    //            $html .= '<dd>archive_filename: ' . $file->archive_filename . '</dd>';
    //            $html .= '<dd>MIME type: ' . $file->getMimeType() . '</dd>';
    //            $html .= '<dd>' . display_file($item->Files[$fileIndex]) . '</dd>';
    //            $fileIndex++;
    //        }
    //    }
    $html .= '</dl>';

    return $html;
}

/* HELPER FUNCTION
 * Gets current page name
 */
function ve_get_current_page_name()
{
    $where = uri();
    $arWhere = explode("/", $where);
    $current = $arWhere[count($arWhere) - 1];
    return $current;
}

/*
 * HELPER FUNCTION
 * Retrieves the Exhibit name based on the Exhibit slug.
 * The Exhibit slug will in most cases within the Europeana environment have a language extension.
 * We see slugs in the form of exhibit-name-lang. This function gives back the exhibit-name part.
 */
function ve_get_exhibit_name_from_slug($exhibit = null)
{
    if (!isset($exhibit)) {
        $exhibit = get_current_exhibit();
    }
    // grab the slug and tear it apart
    $slugs = explode("-", $exhibit->slug);
    // remove the language section from the end
    array_pop($slugs);
    // and piece the string back together. Now we have the section name
    $name = implode("-", $slugs);
    return $name;
}


/*
 * HELPER FUNCTION
 * Retrieves item information and thumbnail based on a give tag
 * @param $tag: tag string
 * @param $format: image format
 */
function ve_get_exhibit_item_info_by_tag($tag = null, $format = 'square_thumbnail')
{
    $items = get_items(array('tags' => $tag));
    set_items_for_loop($items);
    $itemInfo = Array();
    while (loop_items()) {
        if (item_has_files()) {
            $item = get_current_item();
            $file = $item->Files[0];
            $src = file_display_uri($file, $format = $format);
            $itemInfo['src'] = $src;
            $itemInfo['title'] = item('Dublin Core', 'Title');
        }
        else {
            $itemInfo = '';
        }
    }
    return $itemInfo;
}

function getAddThisAppId(){
	return 'ra-4d70f66c15fff6d0';
}

function getGoogleAnalyticsTrackerObjectJS(){
	$gaAccount = 'UA-12776629-3';
	
	$js	= 'var _gaq = _gaq || [];'.PHP_EOL;
	$js	.= '_gaq.push(["_setAccount", "' . $gaAccount . '"]);'.PHP_EOL;	
	$js	.= '_gaq.push(["_trackPageview"]);'.PHP_EOL;
		
	$js	.= '(function() {'.PHP_EOL;
	$js	.= 'var ga = document.createElement("script");'.PHP_EOL;	
	$js	.= 'ga.type = "text/javascript";'.PHP_EOL;
	$js	.= 'ga.async = true;'.PHP_EOL;
	$js	.= 'ga.src = ("https:" == document.location.protocol ? "https://ssl" : "http://www") + ".google-analytics.com/ga.js";'.PHP_EOL;	
	$js	.= 'var s = document.getElementsByTagName("script")[0];'.PHP_EOL;
	$js	.= 's.parentNode.insertBefore(ga, s);'.PHP_EOL;
	$js	.= '})();'.PHP_EOL;
	return $js;	
}

function getAddThisMobile(){
	$buttons = '';
	$buttons .=	'<div id="wrapper" class="addthis addthis_32x32_style addthis_default_style">';
	$buttons .=		'<a	class="addthis_button_facebook"';
	$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';
	$buttons .=		'<a	class="addthis_button_twitter"';
	$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';
	$buttons .=		'<a	class="addthis_button_compact"';
	$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';	
	$buttons .=	'</div>';
	
	return getAddThis($buttons);
}

function getAddThisStandard($style = 'float:right; display:inline; padding-left:30px;'){
	$buttons = '';	
	$buttons .=	'<div class="addthis_toolbox addthis_default_style" style="' . $style . '">';
	$buttons .= 	'<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>';
	$buttons .= 	'<a class="addthis_button_tweet"></a>';
	$buttons .= 	'<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>';
	$buttons .= 	'<a class="addthis_counter addthis_pill_style"></a>';
	$buttons .=	'</div>';
	
	return getAddThis($buttons);	
}


function getAddThis($buttons){
	$appId = getAddThisAppId();
	
	$html = '';
	$html .=	'<script type="text/javascript">';
	$html .=		getGoogleAnalyticsTrackerObjectJS();
	$html .=	'</script>';
	$html .= 	$buttons;
	$html .=	'<script type="text/javascript">';
	$html .=		'var addthis_config = {';
	$html .=			'"ui_language": "en",';
	$html .=			'"ui_click": false,';
	$html .=			'"pubid": "' . $appId . '",';
	$html .=			'"ui_cobrand": "Europeana",';
	$html .=			'"data_track_clickback": true,';
	$html .=			'"data_ga_tracker": _gaq';	// Google Analytics tracking object, or the name of a global variable that references it. If set, we'll send AddThis tracking events to Google, so you can have integrated reporting.
	$html .=		'}';
	$html .=	'</script>';
	$html .=	'<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=' . $appId .'"></script>';
	return $html;
}

