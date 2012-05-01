<?php
/**
 * Created by Eric van der Meulen, Delving B.V. http:www.delving.eu
 * Date: 5/23/2011
 * Time: 17:11 PM
 */
/*
 * TRANSLATION FUNCTION:
 * @param $label - xml tag name to be grabbed - see /themes/main/translations.xml
 * @param $defaults - fallback text string to use if xml tag is not found, or if language within tag not available
 *
 */
/*
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
*/
/*
 * Display language dropdown.
 * Will return user to the index. onChange Functionality for this form is found in theme/main/javascripts/global.js
 * with the function setLanguage().
 */
/*
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
*/

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

/* Return a json object containing:
 *   any image tag $val contains (img)
 *   the href of any anchor wrapping the image (lnk)
 *   the $val with the image tag removed (rem)
 *   the src attribute of any image tag (src)
 * */
function parseRightsValue($val = ""){
    $src = array();
    $img = array();
    $lnk = array();
    $rem = "";
    
    preg_match_all('~<img [^>]*/>~', $val, $img ) ;
    $rem = preg_replace( '/<img[^>]+\>/i', '', $val ) ;
    preg_match( '/src="([^"]*)"/i', $val, $src ) ;

    preg_match( '~<a [^>]*>(.*)</a>~', $val, $lnk );	// 1st pass gets the <a...><img /></a>
    preg_match( '/href="([^"]*)"/i', $lnk[0], $lnk );	// 1st pass gets the @href

    if($lnk){
    	$rem = strip_tags($rem);						// Remove the empty anchor tag...
    }
    
    return array(
    	    'rem' => str_replace('"', '\"', $rem),
    	    'img' => str_replace('"', '\"', $img[0][0]),
    	    'lnk' => str_replace('"', '\"', $lnk[1]),
    	    'src' => str_replace('"', '\"', $src[1])
    	);


    
   // return 'var '.$var.'= {"img":"'.str_replace('"', '\"', $img[0][0]).'","rem":"'.str_replace('"', '\"', $rem).'","src":"'.str_replace('"', '\"', $src[1]).'","lnk":"'.str_replace('"', '\"', $lnk[1]).'"};';
}

function getAddThisAppId(){
	return 'ra-4d70f66c15fff6d0';
}

function getGoogleAnalyticsTrackerObjectJS(){
	$gaAccount = 'UA-12776629-3';	// production
	$gaAccount = 'UA-31316761-1';	// acceptance
	
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

/**
 * Google icon different to all the others, unfortunately.
 * 
 * An a with classes "addthis_button_google_plusone_badge at300bo" makes a nice button,
 * but we'd need a brand page....
 * 
 * */
function getAddThisMobile(){
	$buttons = '';
	$buttons .=	'<div id="wrapper" class="addthis addthis_32x32_style addthis_default_style">';
	
	// works but wrong size
	/*
	$buttons .=		'<a class="addthis_button_google_plusone" g:plusone:size="standard" g:plusone:annotation="none" g:plusone:name="AddThis"';
	//$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';
	// "g:plusone:href" is for the "brand" page
	$buttons .=			' g:plusone:href="https://plus.google.com/102383601500147943541/">';
	$buttons .=		'</a>';
	*/
	
	
	
	$buttons .=		'<a	class="addthis_button_facebook"';
	$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';
	$buttons .=		'<a	class="addthis_button_twitter"';
	$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';
	
	// bookmark
	
	//$buttons .=		'<a	class="addthis_button_google at300b"';
	//$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';
	
	// badge
	
	//$buttons .=		'<a class="addthis_button_google_plusone_badge" g:plusone:size="badge" g:plusone:href="https://plus.google.com/102383601500147943541/"></a>';

	
	$buttons .=	'<a class="addthis_button_google_plusone_share at300b" ';
	//$buttons .=	'href="http://www.addthis.com/bookmark.php?v=300&amp;';
	//$buttons .=	'winname=addthis&amp;pub=AddThis&amp;source=tbx-300&amp;lng=en&amp;s=google_plusone_share&amp;';
	//$buttons .=	'url=http%3A%2F%2Fsupport.addthis.com%2Fcustomer%2Fportal%2Farticles%2F381236-custom-buttons';
	//$buttons .=	'&amp;title=Custom%20Buttons&amp;';
	//$buttons .=	'ate=AT-AddThis/-/-/4f98559136134033/1/4f26d3873438b6d5&amp;';
	//$buttons .=	'frommenu=1&amp;ips=1&amp;uid=4f26d3873438b6d5&amp;ct=1&amp;';
	//$buttons .=	'pre=http%3A%2F%2Fwww.google.co.uk%2Furl%3Fsa%3Dt%26rct%3Dj%26q%3Daddthis%2520button%26source%3Dweb%26cd%3D2%26ved%3D0CDQQjBAwAQ%26url%3Dhttp%253A%252F%252Fsupport.addthis.com%252Fcustomer%252Fportal%252Farticles%252F381236-custom-buttons%26ei%3DjVWYT8-gBo_o-gblwP2-Bg%26usg%3DAFQjCNFwhkpRTdjFtYmMhqzMUdRxfIAj0A&amp;';
	$buttons .=	'tt=0" target="_blank" title="Send to Google+ Share"></a>';

	
	$buttons .=		'<a	class="addthis_button_compact"';
	$buttons .=			'href="http://www.addthis.com/bookmark.php?v=250&amp;username=' . $appId . '"></a>';	
	
	$buttons .=	'</div>';
	
	return getAddThis($buttons);
}

function getAddThisStandard($style = 'float:right; display:inline;'){
	$buttons = '';	
	$buttons .=	'<div class="addthis_toolbox addthis_default_style" style="' . $style . '">';
	
	
	
	/** FACEBOOK
	 * 
	 * at300b							= no difference
	 * fb:like:width="51"				= as in portal: causes bubble to overlap twitter
	 * fb:like:layout="button_count"	= ineffectual (default?)
	 * addthis_button_facebook_like		= wide image
	 * addthis_button_facebook			= square image
	 * */
							
	$buttons .= 	'<a class="addthis_button_facebook at300b" 					fb:like:layout="button_count" title="Send to Facebook_like"></a>';
	//$buttons .= 	'<a class="addthis_button_facebook_like at300b" 					fb:like:layout="button_count" title="Send to Facebook_like"></a>';
	//$buttons .= 	'<a class="addthis_button_facebook_like at300b" fb:like:width="51"	fb:like:layout="button_count" title="Send to Facebook_like"></a>';
	//$buttons .= 	'<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>';

	
	
	/** TWITTER
	 * 
	 * addthis_button_tweet				= rectangular button with count
	 * addthis_button_twitter at300b	= square button with no count
	 * 
	 * */
	$buttons .= 	'<a class="addthis_button_twitter at300b"></a>';
	//$buttons .= 	'<a class="addthis_button_tweet"></a>';
								
	
	/** GOOGLE PLUS
	 * addthis_button_google_plusone		= rectangular grey button
	 * addthis_button_google_plusone_share	= red square button
	 * 
	 * g:plusone:annotation="none"			= hide the bubble count	
	 * g:plusone:count="false"				= hide the bubble count (deprecataed?)
	 * */
	
	//addthis_button_preferred_3 addthis_button_google_plusone_share at300b						   
	$buttons .= 	'<a class="addthis_button_google_plusone_share at300b" g:plusone:annotation="none" g:plusone:size="small"></a>';
	//$buttons .= 	'<a class="addthis_button_google_plusone at300b" g:plusone:size="small" g:plusone:annotation="none"></a>';
	//$buttons .= 	'<a class="addthis_button_google_plusone at300b" g:plusone:size="small" g:plusone:annotation="none" g:plusone:count="false"></a>';
	//$buttons .= 	'<a class="addthis_button_google_plusone at300b" g:plusone:size="small" g:plusone:count="false"></a>';
	//$buttons .= 	'<a class="addthis_button_google_plusone at300b" g:plusone:size="small" ></a>';
	
	/** ADDTHIS
	 * 
	 * at300m
	 * 
	 * */
//	$buttons .= 	'<a class="addthis_button_google_plusone" g:plusone:size="medium"></a>';
	//$buttons .= 	'<a class="addthis_counter addthis_pill_style"></a>';
	//$buttons .= 	'<a class="addthis_counter addthis_bubble_style" style="display:block;"></a>';
	$buttons .= 	'<a class="addthis_button_compact at300m"></a>';
	
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
	$html .=			'"ui_click": true,';
	$html .=			'"pubid": "' . $appId . '",';
	$html .=			'"ui_cobrand": "Europeana",';
	$html .=			'"data_track_clickback": true,';
	$html .=			'"data_ga_tracker": _gaq';	// Google Analytics tracking object, or the name of a global variable that references it. If set, we'll send AddThis tracking events to Google, so you can have integrated reporting.
	$html .=		'}';
	$html .=	'</script>';
	return $html;
}

