<?php
/**
 * Created by Eric van der Meulen, Delving B.V. http:www.delving.eu
 * Date: 5/23/2011
 * Time: 17:53 PM
 */
function ve_exhibit_builder_link_to_exhibit($exhibit, $text = null, $props = array(), $section = null, $page = null)
{
    $uri = exhibit_builder_exhibit_uri($exhibit, $section, $page);
    $text = !empty($text) ? $text : $exhibit->title;
    //  return '<div><a href="' . html_escape($uri) . '" ' . _tag_attributes($props) . '>' . $text . '</a></div>';
    return '<a href="' . html_escape($uri) . '" ' . _tag_attributes($props) . '>' . $text . '</a>';
}

function ve_exhibit_builder_exhibit_display_item_info_link($linkProperties = array())
{
    $item = get_current_item();
    $page = exhibit_builder_get_current_page();
    // pass along page param as this is not available from the item page but is necessary for building seo title and meta fields
    $linkProperties['href'] = exhibit_builder_exhibit_item_uri($item) . '?page=' . urlencode($page->title);
    $html = '';
    $html .= '<a class="return-to" rel="' . uri() . '" id="info-link"' . _tag_attributes($linkProperties) . ' title="' . ve_translate('show-item-details', 'Show item details') . '">';
    $html .= '<img src="' . img('icon-info.png') . '"/></a>';
    // DISPLAY THE TITLE OF THE ITEM
    //    $html .= '<h3 class="title">' . item('Dublin Core', 'Title') . '</h3></a>';
    return $html;
}


function ve_exhibit_builder_zoomit_uri()
{
    $item = get_current_item();
    // check if this item has a 'zoom.it URI' metadata element
    $elements = $item->getItemTypeElements();
    $zoomURI = '';
    foreach ($elements as $element) {
        if (strtolower($element->name) == "zoom.it uri") {
            $zoomURI = $elementText[$element->name] = item(ELEMENT_SET_ITEM_TYPE, $element->name);
        }
    }
    return $zoomURI;
}

/* RESPONSIVE DESIGN ADDITION
 * 
 * Takes the result of ve_exhibit_builder_exhibit_display_item() and transforms it in the following way:
 * 		.jpg		->		_euresponsive_1.jpg
 * 		/fullsize/	->		/euresponsive/
 * 		/fullsize/	->		/euresponsive/
 * 		<img>		->		gets wrapped in noscript tag
 * 		<script>	->		gets inserted
 */
function ve_exhibit_builder_exhibit_display_item_responsively($displayFilesOptions = array(), $linkProperties = array())
{
	$result = ve_exhibit_builder_exhibit_display_item($displayFilesOptions, $linkProperties);
	
	$dom = new DOMDocument;
	$dom->loadHTML($result);
	
	$xpath			= new DOMXpath($dom);
	$divNode1		= $xpath->query("//html/body/div")->item(0);
	$divNode2		= $xpath->query("//html/body/div")->item(1);
	$imageNode		= $xpath->query("//html/body/div/img")->item(0);
	$scriptNode		= $dom->createElement('script', 'document.write("<" + "!--")');
	$noScriptNode	= $dom->createElement('noscript');
	
	$scriptNode		->setAttribute('class', 'euresponsive-script');
	$noScriptNode	->appendChild($imageNode);
	
	$divNode1->appendChild($scriptNode);
	$divNode1->appendChild($noScriptNode);
	
	$dom2 = new DOMDocument();
	$imported1 = $dom2->importNode($divNode1, true);
	$imported2 = $dom2->importNode($divNode2, true);
	$dom2->appendChild($imported1);
	$dom2->appendChild($imported2);
	
	$result = $dom2->saveHTML();
	
	$result = str_replace(".jpg", "_euresponsive_1.jpg",	$result);
	$result = str_replace("/fullsize/", "/euresponsive/",	$result);
	$result = str_replace("</noscript>", "</noscript -->",	$result);
	
	return $result;
	
	/*
	return '<div id="in-focus" class="image">'
				. '<script class="dirty-script">document.write("<" + "!--")</script>'
				. '<noscript>'
			 		. '<img src="http://127.0.0.1/ombad/archive/euresponsive/mastercraft_intro_11e5245b91_euresponsive_1.jpg" class="full" alt="Drageoir"/>'
				. '</noscript -->'
			. '</div>'
			. '<div id="exhibit-item-title"><h4>Drageoir </h4></div>';
	*/
}
// RESPONSIVE DESIGN ADDITION


function ve_exhibit_builder_exhibit_display_item($displayFilesOptions = array(), $linkProperties = array())
{
    $item = get_current_item();
    $fileIndex = 0; // Always just display the first file (may change this in future).
    $linkProperties['href'] = exhibit_builder_exhibit_item_uri($item);
    $displayFilesOptions['linkToFile'] = false; // Don't link to the file b/c it overrides the link to the item.
    $fileWrapperClass = null; // Pass null as the 3rd arg so that it doesn't output the item-file div.
    $file = $item->Files[$fileIndex];
    $zoomify = ve_exhibit_builder_zoomit_uri();
    $html = '';

    if ($file) {

        $mime = $file->getMimeType();

        if (preg_match("/^image/", $mime)) {
            // IMAGE
            $html .= '<div id="in-focus" class="image">';
            //            echo strlen($zoomify);
            // ZOOMABLE? Check if it's a zoomify image on intial load
            if (!strlen($zoomify) > 0) {
                $html .= display_file($file, $displayFilesOptions, $fileWrapperClass);
            }
            else {
                $html .= '<script type="text/javascript" language="javascript" src="' . $zoomify . '.js?width=auto"></script>';
            }
        }
        elseif (preg_match("/^audio/", $mime)) {
            // AUDIO
            $html .= '<div id="in-focus" class="player">';
            //            $html .= '<audio  controls="controls"  poster="' . file_display_uri($file, $format = 'fullsize') . '" type="audio/mp3" src="' . file_display_uri($file, $format = 'archive') . '" width="460" height="84"></audio>';
            $html .= '<audio  controls="controls"  type="audio/mp3" src="' . file_display_uri($file, $format = 'archive') . '" width="460" height="84"></audio>';
        }
        else {
            // VIDEO
            $html .= '<div id="in-focus" class="player">';
            $html .= '<video src="' . file_display_uri($file, $format = 'archive') . '" width="460" height="340"></video>';
        }
        $html .= '</div>';
        $html .= '<div id="exhibit-item-title"><h4>' . item('Dublin Core', 'Title') . '</h4></div>';
    } else {
        $html .= '<h2>' . item('Dublin Core', 'Title') . '</h2>';
    }


    return $html;
}

function ve_exhibit_builder_display_exhibit_thumbnail_gallery($start, $end, $props = array(), $thumbnail_type = "square_thumbnail")
{
    $html = '';
    for ($i = (int)$start; $i <= (int)$end; $i++) {
        if (exhibit_builder_use_exhibit_page_item($i)) {
            $html .= '<div class="exhibit-item">';
            $item = get_current_item();

            // check if this item has a 'zoom.it URI' metadata element
            $elements = $item->getItemTypeElements();
            $zoomURI = '';
            foreach ($elements as $element) {
                if (strtolower($element->name) == "zoom.it uri") {
                    $zoomURI = $elementText[$element->name] = item(ELEMENT_SET_ITEM_TYPE, $element->name);
                }
            }

            if (item_has_files()) {
                while (loop_files_for_item()) {


                    $file = get_current_file();

                    $thumbnail = item_image($thumbnail_type, array('alt' => item('Dublin Core', 'Title'), 'rel' => $file->getMimeType(), 'accesskey' => file_display_uri($file, $format = 'archive')));
                    //                    $hiddenInput = '<input type="hidden" name="zoomit" class="zoomit" value="' . $zoomURI . '"/>';
                    $hiddenInput = '<input type="hidden" name="zoomit" class="zoomit" value="' . str_replace("http://zoom.it/", "", $zoomURI) . '"/>';

                    if (preg_match("/^audio/", $file->getMimeType())) {
                        $thumbnail .= '<img src="' . img('icon-audio.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    if (preg_match("/^video/", $file->getMimeType())) {
                        $thumbnail .= '<img src="' . img('icon-video.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    $html .= exhibit_builder_link_to_exhibit_item($thumbnail, $props) . $hiddenInput;


                }

            }

            $html .= '</div>';
        }
    }
    $html = apply_filters('exhibit_builder_display_exhibit_thumbnail_gallery', $html, $start, $end, $props, $thumbnail_type);
    return $html;
}


function ve_link_to_item($text = null, $props = array(), $action = 'show', $item = null)
{
    if (!$item) {
        $item = get_current_item();
    }
    echo $item->getMimeType();
    $text = (!empty($text) ? $text : strip_formatting(item('Dublin Core', 'Title', array(), $item)));
    return link_to($item, $action, $text, $props);
}

/*
 * If in the theme config the list of desired metadata elements is set then use this function,
 * else just use the regular show_item_metadata
 */
if (!function_exists('ve_custom_show_item_metadata')) {

    function ve_custom_show_item_metadata(array $options = array(), $item = null)
    {
        if (!$item) {
            $item = get_current_item();
        }
    	if ($dcFieldsList = get_theme_option('display_dublin_core_fields')) {
    	    $html = '';
    	    $dcFields = explode(',', $dcFieldsList);
    	    foreach ($dcFields as $field) {
    	        $field = trim($field);
    	        if (element_exists('Dublin Core', $field)) {
        	        if ($fieldValues = item('Dublin Core', $field, 'all')) {
        	            $html .= '<div class="element" id="dublin-core-'. strtolower($field) .'"><h3>'.$field.'</h3>';
        	            foreach ($fieldValues as $key => $fieldValue) {
        	                if (!item_field_uses_html('Dublin Core', $field, $key)) {
        	                    $fieldValue = nls2p($fieldValue);
        	                }
        	                $html .= '<div class="element-text">'.$fieldValue.'</div>';
        	            }
                        $html .= '</div>';
        	        }
        	    }
     	        if (element_exists('Item Type Metadata', $field)) {
        	        if ($fieldValues = item('Item Type Metadata', $field, 'all')) {
        	            $html .= '<div class="element" id="dublin-core-'. strtolower($field) .'"><h3>'.$field.'</h3>';
        	            foreach ($fieldValues as $key => $fieldValue) {
        	                if (!item_field_uses_html('Item Type Metadata', $field, $key)) {
        	                    $fieldValue = nls2p($fieldValue);
        	                }
        	                $html .= '<div class="element-text">'.$fieldValue.'</div>';
        	            }
                        $html .= '</div>';
        	        }
        	    }
    	    }

    	    $html .= show_item_metadata(array('show_element_sets' => array('Europeana Object')));

    	    return $html;
    	}
        else {
    	    return show_item_metadata($options, $item);
        }

    }

}

