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