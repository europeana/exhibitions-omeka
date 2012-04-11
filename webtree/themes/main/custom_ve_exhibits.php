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


function ve_exhibit_builder_is_zoomit_enabled()
{
	$item = get_current_item();
	
//	echo "ITEM ID IS $item->id";
	// check if this item has a 'zoom.it URI' metadata element
	$elements = $item->getItemTypeElements();
	$zoomEnabled = false;
	foreach ($elements as $element) {
		if (strtolower($element->name) == "zoomit_enabled") {
			$zoomEnabled = $elementText[$element->name] = item(ELEMENT_SET_ITEM_TYPE, $element->name);
		}
	}
	return $zoomEnabled;
}



function ve_exhibit_builder_exhibit_display_item($displayFilesOptions = array(), $linkProperties = array(), $titleOnly = false, $withoutTitle = false)
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
    	
    	if($titleOnly){ /* responsive change */
    		return '<div id="exhibit-item-title-only"><h4>' . item('Dublin Core', 'Title') . '</h4></div>';
    	}
    	 
        $mime = $file->getMimeType();

        if (preg_match("/^image/", $mime)) {
            // IMAGE
			$imgHtml	= display_file($file, $displayFilesOptions, $fileWrapperClass);
			$imgHtml	= str_replace('.jpg', '_euresponsive_1.jpg',			$imgHtml);
			$imgHtml	= str_replace('/fullsize/', '/euresponsive/',			$imgHtml);
			$imgHtml	= str_replace('class="full"', 'class="full tmp-img"',	$imgHtml);

            $html .= '<div id="in-focus" class="image">';
			$html .= '<div id="media_wrapper">';
			$html .= 	'<div id="zoomit_window" style="width: 100%; height: 100%;">';
			$html .=	'</div>';
			$html .= 	'<script class="euresponsive-script">document.write("<" + "!--")</script>';
			$html .= 		'<noscript>';
			$html .=			$imgHtml;
			$html .=	'</noscript -->';                
			$html .= '</div>';

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
        
        if(!$withoutTitle){ /* responsive change */
        	$html .= '<div id="exhibit-item-title"><h4>' . item('Dublin Core', 'Title') . '</h4></div>';
        }
        
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
 *  Display the embed button only for items with a Creative Commons license. 
    Display embed button only when the item is an image
    In the embedded item display the creative commons license as a badge with a link to its license statement and also include the correct CC-rel markup
    Add a GA-tracking code to the URL-back to exhibition.
        (Dean will create a tracking code)
        
        
    The following metadata per item needs to be included (when extant): Title, Creator, Data Provider, Provider, CC-license.
    When the item is tiled the embed functions must include an untiled image
        So we need to be able to call for that in the Omeka backend
        
 * */
if(!function_exists('ve_custom_show_embed')){
	function ve_custom_show_embed(){
		
		$item		= get_current_item();
		$html		= '';
		$fileIndex	= 0; // Always just display the first file (may change this in future).
		$file		= $item->Files[$fileIndex];

		if($file){
			$mime = $file->getMimeType();
			if (preg_match("/^image/", $mime)) {
				if($dcFieldsList = get_theme_option('display_dublin_core_fields')){
					
					$embedEligible = false;
					$dcFields = explode(',', $dcFieldsList);
					
					foreach($dcFields as $field){
						$field = trim($field);

						if (element_exists('Dublin Core', $field)){
							if(strtolower($field) == 'rights'){
								if($fieldValues = item('Dublin Core', $field, 'all')){
									foreach ($fieldValues as $key => $fieldValue){
										if(!item_field_uses_html('Dublin Core', $field, $key)){
											$fieldValue = nls2p($fieldValue);
										}

										if(strrpos($fieldValue, "creativecommons")>-1){
											$embedEligible = true;
										}
									}
								}
							}
						}
					}

					if($embedEligible){

						// Title, Creator, Data Provider, Provider, CC-license.
						
						$html	.=	'<ul id="embedded">';
						$html	.=		'<textarea>';
						$html	.=			'<style type="text/css">';
						$html	.=				'#embedded span.field-name{';
						$html	.=					'font-weight:bold;';
						$html	.=				'}';
						$html	.=			'</style>';
						$html	.=			'<div id="embedded">';
						$html	.=				item_fullsize($file);
						
						$embedFields = array("title", "creator", "data provider", "provider", "rights");
						
						foreach($dcFields as $field){
							$field = trim($field);
							if (element_exists('Dublin Core', $field)){
								if( in_array(strtolower($field), $embedFields)  ){
									if($fieldValues = item('Dublin Core', $field, 'all')){
										foreach ($fieldValues as $key => $fieldValue){
											if(!item_field_uses_html('Dublin Core', $field, $key)){
												$fieldValue = nls2p($fieldValue);
											}
											$val = $fieldValue;
											$val = str_replace('<p>', '',			$val);
											$val = str_replace('</p>', '',			$val);
											$val = str_replace('<br>', '',			$val);
											$val = str_replace('<br/>', '',			$val);
											$val = str_replace('<br />', '',		$val);
											
											$html .= '<li><span class="field-name">'.$field.':</span> '.$val.'</li>';
										}
									}
								}
							}
						}
						$html	.=			'</ul>';
						$html	.=		'</textarea>';
						$html	.=	'</div>';
					}
				}
			}
		}

		return $html;
	}
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

