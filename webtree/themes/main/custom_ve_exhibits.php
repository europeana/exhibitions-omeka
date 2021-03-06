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
    $html .= '<img alt="info" src="' . img('icon-info.png') . '"/></a>';


    // skip info link if viewing a pdf
    /*
    $file = $item->Files[0];
    if ($file) {
        $mime = $file->getMimeType();
        if(preg_match("/^application/", $mime)){
        	$html = '';
        }
    }
    */
    return $html;
}


function getItemTypeMetadataEntry($item, $fName){
    $elements = $item->getItemTypeElements();
    $result = null;
    
    foreach ($elements as $element) {
        if (strtolower($element->name) == strtolower($fName)){
        	$result = item(ELEMENT_SET_ITEM_TYPE, $element->name);
        }
    }
    return $result;
}


function ve_exhibit_builder_zoomit_enabled()
{
	$result = getItemTypeMetadataEntry(get_current_item(), "zoomit_enabled");
	if(!$result){
		$result = 0;
	}
	return $result;
}


function ve_exhibit_builder_license_info($item)
{
	if($item){
		return getItemTypeMetadataEntry($item, "license");		
	}
	else{
		return getItemTypeMetadataEntry(get_current_item(), "license");
	}
}





function endsWith($haystack,$needle,$case=true) {
    if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
    return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
}



function ve_exhibit_builder_exhibit_display_item($displayFilesOptions = array(), $linkProperties = array(), $titleOnly = false, $withoutTitle = false)
{
    $item = get_current_item();
    $fileIndex = 0; // Always just display the first file (may change this in future).
    $linkProperties['href'] = exhibit_builder_exhibit_item_uri($item);
    $displayFilesOptions['linkToFile'] = false; // Don't link to the file b/c it overrides the link to the item.
    $fileWrapperClass = null; // Pass null as the 3rd arg so that it doesn't output the item-file div.
    $file = $item->Files[$fileIndex];
    $zoomit_enabled = ve_exhibit_builder_zoomit_enabled();
    $html = '';

    if ($file) {
    	
    	
    	$mime = $file->getMimeType();
    	
    	if($titleOnly){ /* responsive change */
    		
    		if (preg_match("/^application/", $mime)){ // pdf don't have the info link, so we make the title a link
    			// pass along page param as this is not available from the item page but is necessary for building seo title and meta fields
    		    $page = exhibit_builder_get_current_page();
    		    $linkProperties['href'] = exhibit_builder_exhibit_item_uri($item) . '?page=' . urlencode($page->title);
    		    $html .= '<a class="return-to" rel="' . uri() . '" id="info-link"' . _tag_attributes($linkProperties) . ' title="' . ve_translate('show-item-details', 'Show item details') . '">';
    		    $html .= '<h6>';
    		    $html .= item('Dublin Core', 'Title');
    		    $html .= '</h6></a>';
    			return '<div id="exhibit-item-title-only">' . $html . '</div>';

   			}
    		else{    			
    			return '<div id="exhibit-item-title-only" class="meta"><h2>' . item('Dublin Core', 'Title') . '</h2></div>';
    		}
    	}
    	 

        if (preg_match("/^image/", $mime)) {
            // IMAGE
			$imgHtml	= display_file($file, $displayFilesOptions, $fileWrapperClass);
			
			$imgHtml	= str_replace('.jpg', '_euresponsive_1.jpg',			$imgHtml);
			$imgHtml	= str_replace('/fullsize/', '/euresponsive/',			$imgHtml);
			$imgHtml	= str_replace('class="full"', 'class="full tmp-img"',	$imgHtml);
			$imgHtml	= str_replace('alt=""', 'alt="' . item('Dublin Core', 'Title') . '"',	$imgHtml);

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
            $html .= '<audio  controls="controls"  type="audio/mp3" src="' . file_display_uri($file, $format = 'archive') . '" width="460" height="84" style="width:100%; height:100%;"></audio>';
        }
        elseif (preg_match("/^application/", $mime)) {
        	
        	// ipad fix
        	$html .= '<style>';
        	$html .= '#exhibit-item-infocus-item .theme-center-middle, #exhibit-item-infocus-item .theme-center-inner{width:100%;}';
        	$html .= '</style>';
        	
        	
        	$html .= '<div id="in-focus" class="pdf-viewer">';
       		if (class_exists('DocsViewerPlugin')){       			
       		   $docsViewer = new DocsViewerPlugin;
       			$html .= $docsViewer->getEmbed();
       		}
        }
        else {
            // VIDEO
        	
        	$videoSrc = file_display_uri($file, $format = 'archive'); 
        	
            $html .= '<div id="in-focus" class="player">';
            //$html .= '<a id="video-logo-link" href="http://europeana.eu"><img src="' . img("europeana-logo-en.png") . '"></a>';
            $html .= '<style>.mejs-overlay-loading{width:88px!important;}</style>';
            $html .= '<video  width="460" height="340" style="width:100%; height:100%;">';

            if(endsWith($videoSrc, '.mp4')){
            	$html .= '<source type="video/mp4" src="' . $videoSrc . '" />';
            }
            if(endsWith($videoSrc, '.webm')){
            	$html .= '<source type="video/webm" src="' . $videoSrc . '" />';
            }
            if(endsWith($videoSrc, '.ogv')){
            	$html .= '<source type="video/ogg" src="' . $videoSrc . '" />';
            }
            if(endsWith($videoSrc, '.ogv')){
            	$html .= '<source type="video/ogg" src="' . $videoSrc . '" />';
            }

            $html .=	'<object type="application/x-shockwave-flash" data="'.WEB_ROOT.'/themes/main/javascripts/mediaelement-2.7/build/flashmediaelement.swf">';
           	$html .=	'<param name="movie" value="'.WEB_ROOT.'/themes/main/javascripts/mediaelement-2.7/build/flashmediaelement.swf" />';
       		$html .=	'<param name="flashvars" value="controls=true&amp;file='. $videoSrc .'" />'; 		
   			$html .=	'<img src="'.WEB_ROOT.'/media/echo-hereweare.jpg" width="100%" height="auto;" alt="No video playback capabilities" title="No video playback capabilities" />';
			$html .=	'</object>';
            $html .= '</video>';
            
        }
        $html .= '</div>';
        
        error_log($html);
        
        if(!$withoutTitle){ /* responsive change */
        	$html .= '<div id="exhibit-item-title"><h4>' . item('Dublin Core', 'Title') . '</h4></div>';
        }
        
    } else {
        $html .= '<h1>' . item('Dublin Core', 'Title') . '</h1>';
    }    
    return $html;
}

function ve_exhibit_builder_display_exhibit_thumbnail_gallery($start, $end, $props = array(), $thumbnail_type = "square_thumbnail")
{
	$noItems = 0;
    $html = '<table id="exhibit-item-thumbnails"><tr>';
    
    for ($i = (int)$start; $i <= (int)$end; $i++) {
        if (exhibit_builder_use_exhibit_page_item($i)) {
            $item = get_current_item();

            $zoomitEnabled = ve_exhibit_builder_zoomit_enabled();

            if (item_has_files()) {
                while (loop_files_for_item()) {
                	$html .= '<td>';
                	
                	$noItems += 1;
                    $file = get_current_file();

                    $thumbnail = item_image($thumbnail_type, array('alt' => item('Dublin Core', 'Title'), 'rel' => $file->getMimeType(), 'accesskey' => file_display_uri($file, $format = 'archive')));
                    $hiddenInput = '<input type="hidden" name="zoomit" class="zoomit" value="' . $zoomitEnabled . '"/>';
                    
                    
                    if (preg_match("/^audio/", $file->getMimeType())) {
                        $thumbnail .= '<img class="icon-audio" src="' . img('icon-audio.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    if (preg_match("/^video/", $file->getMimeType())) {
                        $thumbnail .= '<img class="icon-vid" src="' . img('icon-video.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    if (preg_match("/^application/", $file->getMimeType())) {
                        $thumbnail = '<img  class="icon-pdf" src="' . img('icon-pdf.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    $html .= exhibit_builder_link_to_exhibit_item($thumbnail, $props) . $hiddenInput;
                    
                    $html .= '</td>';
                }
            }
            
        }
    }
    $html .= '</tr></table>';
    $html .= '<script type="text/javascript">var galleryItemCount = ' . $noItems . ';</script>';
    $html = apply_filters('exhibit_builder_display_exhibit_thumbnail_gallery', $html, $start, $end, $props, $thumbnail_type);
    
    return $html;
    
/*
    $html = '';
    for ($i = (int)$start; $i <= (int)$end; $i++) {
        if (exhibit_builder_use_exhibit_page_item($i)) {
            $html .= '<div class="exhibit-item">';
            $item = get_current_item();

            $zoomitEnabled = ve_exhibit_builder_zoomit_enabled();

            if (item_has_files()) {
                while (loop_files_for_item()) {

                    $file = get_current_file();

                    $thumbnail = item_image($thumbnail_type, array('alt' => item('Dublin Core', 'Title'), 'rel' => $file->getMimeType(), 'accesskey' => file_display_uri($file, $format = 'archive')));
                    $hiddenInput = '<input type="hidden" name="zoomit" class="zoomit" value="' . $zoomitEnabled . '"/>';
                    
                    if (preg_match("/^audio/", $file->getMimeType())) {
                        $thumbnail .= '<img class="icon-audio" src="' . img('icon-audio.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    if (preg_match("/^video/", $file->getMimeType())) {
                        $thumbnail .= '<img class="icon-vid" src="' . img('icon-video.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    if (preg_match("/^application/", $file->getMimeType())) {
                        $thumbnail = '<img  class="icon-pdf" src="' . img('icon-pdf.png') . '" rel="' . $file->getMimeType() . '" alt="' . item('Dublin Core', 'Title') . '" accesskey="' . file_display_uri($file, $format = 'archive') . '"/>';
                    }
                    $html .= exhibit_builder_link_to_exhibit_item($thumbnail, $props) . $hiddenInput;
                }
            }
            $html .= '</div>';
        }
    }
    $html = apply_filters('exhibit_builder_display_exhibit_thumbnail_gallery', $html, $start, $end, $props, $thumbnail_type);
    
    return $html;
*/
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


function removeAttribute($tag, $attr){
	$pattern = '/ '.$attr.'=[\B\n\r\f ]*"[\w :#;-]+"/';
	
	//preg_replace('/style\s*=\s*(\'|").+(\'|")/i', '', $img);
	
	$pattern = '/'.$attr.'\s*=\s*(\'|").+(\'|")/i'; 
	return preg_replace($pattern, '', $tag);
}

function getAttribute($tag, $attr){
	$pattern = '/'.$attr.'\s*=\s*(\'|").+(\'|")/i';
	$result = "";
	preg_match($pattern, $tag, $result);
	return $result;
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
		$imgHtml	= '';
		
		$fileIndex	= 0; // Always just display the first file (may change this in future).
		$file		= $item->Files[$fileIndex];

		if($file){
			$mime = $file->getMimeType();
			
			error_log("MIME TYPE IS " . $mime );
			
			$licenseVal		= getItemTypeMetadataEntry(get_current_item(), "license");
			$embedEligible	= strrpos( strtolower($licenseVal), "http://creativecommons.org/")>-1;
			if($embedEligible){

				if (preg_match("/^video/", $mime)) {
					
					$html	.=	'<div id="embedded">';
					$html	.=		'<h4>' . ve_translate("embed-code", "Embed Code") .'</h4>';
					$html	.=		'<textarea rows="5">';	// start embed code
					$html	.=			'<iframe id="europeana-iframe" src="' . WEB_ROOT . '/track_embed/download/' . $item->id . '?linkback=' . abs_uri() . '" style="width:400px; height:410px; border:none; overflow:hidden;" frameBorder="0" scroll="no" allowTransparency="true">';
					$html	.=		'</iframe>';
					$html	.=		'</textarea>';	// end embed code
					$html	.=	'</div>';
					
				}
			
				elseif (preg_match("/^audio/", $mime)) {
					
					$html	.=	'<div id="embedded">';
					$html	.=		'<h4>' . ve_translate("embed-code", "Embed Code") .'</h4>';
					$html	.=		'<textarea rows="5">';	// start embed code
					$html	.=			'<iframe src="' . WEB_ROOT . '/track_embed/download/' . $item->id . '?linkback=' . abs_uri() . '" style="width:400px; height:160px; border:none; overflow:hidden;" frameBorder="0" scroll="no" allowTransparency="true">';
					$html	.=		'</iframe>';
					$html	.=		'</textarea>';	// end embed code
					$html	.=	'</div>';
					
				}
			
				elseif (preg_match("/^image/", $mime)) {

					if($dcFieldsList = get_theme_option('display_dublin_core_fields')){
						
						$dcFields = explode(',', str_replace(' ','',$dcFieldsList));

						// Title, Creator, Data Provider, Provider, CC-license.
						
						$html	.=	'<div id="embedded">';
						$html	.=		'<h4>' . ve_translate("embed-code", "Embed Code") .'</h4>';
						$html	.=		'<textarea rows="5">';	// start embed code

						// image div
						$embedFields = array("title", "creator", "data provider", "provider", "source");
						$html	.=		'<div style="position:relative;float:left;">';
						
						$itemUri		= "";
						$googleTracking = "utm_source=embeddeditem&utm_medium=externalsite&utm_campaign=exhibitionembed";
						
						if(html_escape($exhibitName)){
							$itemUri = abs_uri();
		                    $itemUri .= "&".$googleTracking;	// add google tracking								                    	
						}
						else{
							$itemUri = abs_uri();
		                    $itemUri .= "?".$googleTracking;	// add google tracking								                    														
						}
						
						$altText = ve_exhibit_breadcrumbs($pageId = null, $exhibit = null, $section = null, $showAsTitle=true);
						$altText = explode("|", $altText);
						
						// New code
						$fileImgHtml	= '<img width="100%" src="' . WEB_ROOT . '/track_embed/download/' . $item->id . '"/>';
						$fileImgHtml	= 	'<a href="'.$itemUri.'">' . $fileImgHtml . '</a>';

						
						// Old code
						/*
						$fileImgHtml	=	item_fullsize($file);
						$fileImgHtml	=	str_replace('<img ', '<img style="width:100%;" alt="' . addslashes(current($altText)) . '" ', $fileImgHtml);
						
						$fileImgHtml	=	removeAttribute($fileImgHtml, "archive_filename");
						$fileImgHtml	=	removeAttribute($fileImgHtml, "original_filename");
						$fileImgHtml	=	removeAttribute($fileImgHtml, "authentication");
						$fileImgHtml	=	removeAttribute($fileImgHtml, "mime_browser");
						$fileImgHtml	=	removeAttribute($fileImgHtml, "mime_os");
						$fileImgHtml	=	removeAttribute($fileImgHtml, "type_os");
						$fileImgHtml	=	removeAttribute($fileImgHtml, "added");
						$fileImgHtml	=	removeAttribute($fileImgHtml, "modified");
						$fileImgHtml	= 	'<a href="'.$itemUri.'">' . $fileImgHtml . '</a>';
						*/

						
						$html	.=		$fileImgHtml;
						
						$licenseInfo = ve_exhibit_builder_license_info($item);
						$licenseInfo =  parseRightsValue($licenseInfo);
						if($licenseInfo["lnk"]){
							$html	.=		'<a rel="license" href="'.$licenseInfo["lnk"].'">';								
						}
						if($licenseInfo["src"]){
							$html	.=		'<img style="border-width:0; position:absolute; bottom:1em; right:1em;" src="'.$licenseInfo["src"].'" alt="Creative Commons License" />';								
						}
						if($licenseInfo["lnk"]){
							$html	.=		'</a>';								
						}
						
						$html	.=		'</div>';
						
						// end image div
						// start field list
						
						$html	.=			'<ul style="display:block;clear:both;list-style-type:none;padding:0px;margin:0px;padding-top:0.5em;line-height:1em;font-family:Chevin,\'Trebuchet MS\',Helvetica,sans-serif;">';
						
						foreach($dcFields as $field){
							$field = trim($field);
							if (element_exists('Dublin Core', $field)){
								if( in_array(strtolower($field), $embedFields)  ){
									if($fieldValues = item('Dublin Core', $field, 'all')){

										foreach ($fieldValues as $key => $fieldValue){
											if(!item_field_uses_html('Dublin Core', $field, $key)){
												$fieldValue = nls2p($fieldValue);
											}
											$html .= '<li style="margin-left:0px!important;"><span style="font-weight:bold;">'.$field.':</span> ';

											if(strtolower($field) == "title"){
												$fieldValue = '<a href="'.$itemUri.'">' . $fieldValue . "</a>";
											}

											$fieldValue = str_replace('<p>',	'',	$fieldValue);
											$fieldValue = str_replace('</p>',	'',	$fieldValue);
											$fieldValue = str_replace('<br>',	'',	$fieldValue);
											$fieldValue = str_replace('<br/>',	'',	$fieldValue);
											$fieldValue = str_replace('<br />',	'',	$fieldValue);
											$html .= $fieldValue;
											$html .= '</li>';
										}

										$fieldValue =  $licenseInfo["rem"];

									}
								}
							}
						} // end field list
						
						$source = getItemTypeMetadataEntry($item, "Source");
						if(strlen($provider) > 0 ){
							$html .= '<li style="margin-left:0px!important;"><span style="font-weight:bold;">Source:</span> '.$source.'</li>';
						}

						$provider = getItemTypeMetadataEntry($item, "Provider");
						if(strlen($provider) > 0 ){
							$html .= '<li style="margin-left:0px!important;"><span style="font-weight:bold;">Provider:</span> '.$provider.'</li>';
						}						
						
						$html	.=				'</ul>';	// end field list
						$html	.=		'</textarea>';	// end embed code
						$html	.=	'</div>';
					}
				}
			}
		}
		return $imgHtml . $html;
	}
}

/*
 * If in the theme config the list of desired metadata elements is set then use this function,
 * else just use the regular show_item_metadata
 */
/*
if (!function_exists('ve_custom_show_item_metadataxxx')) {

    function ve_custom_show_item_metadataxxx(array $options = array(), $item = null)
    {
    	$my_string = <<<TEST

    	
    	<div style="margin-bottom:3em;" class="six columns meta">

        	<div id="dublin-core-title" class="element">
        		<h1>Title</h1>
        		<p class="element-text">
        			Polish wedding
        		</p>
        	</div>
        	<div id="dublin-core-creator" class="element">
        		<h2>Creator</h2>
        		<p class="element-text">
        			Photographer unknown
        		</p>
        	</div>
        	<div id="dublin-core-description" class="element">
        		<h6>Description</h6>
        		<p class="element-text">
        			In the background, there is a fiddler and a three-row accordion player (a drummer is also present but not visible in this picture). This line-up is characteristic for the 20th century, especially for central Poland. The accordion the first appeared in the original ensemble setting (consisting of fiddle and one-side drum) in the Lowicz region (probably towards the end of 19th century). In this picture, we can see a reconstruction of the traditional wedding ceremony.
        			
        		</p>
        	</div>
        	<div id="dublin-core-date" class="element">
        		<h6>Date</h6>
        		<p class="element-text">
        			1929
        		</p>
        	</div>
        	<div id="dublin-core-source" class="element">
        		<h6>Source</h6>
        		<p class="element-text">
        			Sound Archive of ISPAN; Poland
        		</p>
        	</div>
        	<div id="dublin-core-provider" class="element">
        		<h6>Provider</h6>
        		<p class="element-text">
        			DISMARC - EuropeanaConnect
        		</p>
        	</div>        
        </div>
TEST;
    	return $my_string;
    }
}
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
        	        	
        	        	$html .= '<div class="element" id="dublin-core-'. strtolower($field) .'">';
        	        	
        	        	if(strtolower($field) == "rights"){
        	        		
        	        		 //   any image tag $val contains (img)
        	        		 //   the href of any anchor wrapping the image (lnk)
        	        		 //   the $val with the image tag removed (rem)
        	        		 //   the src attribute of any image tag (src)
        	        		 //
        	        		
        	        		$parsedRights = parseRightsValue($fieldValues[0]);
        	        		/*
        	        		$html .= '<div class="metadata-rights">';
        	        		$html .= 	'<table><tr>';
        	        		$html .= 		'<td>';
        	        		$html .= 			'<h6>'.$field.'</h6>';
        	        		$html .= 		'</td>';
        	        		$html .= 		'<td>';
                            $html .= 			'<p class="element-text">'.$parsedRights["rem"].'</p>';
                             
 							if($parsedRights["lnk"]){
 								$html	.=		'<a rel="license" href="'.$parsedRights["lnk"].'">';								
							}
							if($parsedRights["src"]){
								$html	.=		'<img src="'.$parsedRights["src"].'" alt="Creative Commons License" />';								
							}
							if($parsedRights["lnk"]){
								$html	.=		'</a>';
							}
							
                            $html .= 		'<p>&nbsp;</p>';
                            
                            $html .= 		'</td>';
                            $html .=	'</tr>';
                            $html .=   '</table>';
                            $html .= '</div>';
                             */
        	        		
        	        		
        	        		$html .= '<div class="metadata-rights">';

        	        		$html .= 			'<h6>'.$field.'</h6>';
        	        		
                            $html .= 			'<p class="element-text">'.$parsedRights["rem"].'</p>';
                             
 							if($parsedRights["lnk"]){
 								$html	.=		'<a rel="license" href="'.$parsedRights["lnk"].'">';								
							}
							if($parsedRights["src"]){
								$html	.=		'<img src="'.$parsedRights["src"].'" alt="Creative Commons License" />';								
							}
							if($parsedRights["lnk"]){
								$html	.=		'</a>';
							}
							
                            
                            $html .= '</div>';
                            
                            
                            
        	        	}
        	        	else{
        	        		/*
        	        		 * H4 overrides needed:
        	        		 * 		text.css (39, 59)											OK
        	        		 * 
        	        		 * 		text.css (54)
        	        		 * 			h3 font-size (media query rewrite needed)				OK
        	        		 * 
        	        		 * H3 has some special styling that needs replicated for h4:
        	        		 * 		styles.css (346)											OK
        	        		 * 			element h3:after
        	        		 * 		styles.css (330)											OK
        	        		 * 			.element h3
        	        		 * 
        	        		 * 		
        	        		 * **/
        	        		
     

        	        		
        	        		$html .= '<h6>'.$field.'</h6>';
        	        		foreach ($fieldValues as $key => $fieldValue) {
        	        			
        	        			if (!item_field_uses_html('Dublin Core', $field, $key)) {
        	        				
	                	        	if(strtolower($field) == "title"){	// SEO optimisation: this h1 isn't really all that big 
	                	        		$html .= '<h1 style="margin-bottom:0">'	.	$fieldValue	.	'</h1>';
	                	        	}
	                	        	else if(strtolower($field) == "creator"){
	                	        		$html .= '<h2>'	.	 $fieldValue	.	'</h2>';
	                	        	}
	                	        	else{
	                	        		$html .= '<p class="element-text">'.  $fieldValue .'</p>';
	                	        	}
        	        			}
        	        			else{
	                	        	if(strtolower($field) == "creator"){
	                	        		$html .= '<h2>'	.	 $fieldValue	.	'</h2>';
	                	        		
	                	        	}
	                	        	else{
	                	        		//$html .= '<p class="element-text">'.        nls2p($fieldValue) .'</p>';
	                	        		$html .= '<p class="element-text">'.        $fieldValue .'</p>';
	                	        		
	                	        	}
        	        			}
        	        		}

        	        		
        	        	}
                        $html .= '</div>';
                        
                        
        	        }
        	    }
     	        if (element_exists('Item Type Metadata', $field)) {
        	        if ($fieldValues = item('Item Type Metadata', $field, 'all')) {
        	            $html .= '<div class="element" id="dublin-core-'. strtolower($field) .'"><h6>'.$field.'</h6>';
        	            
        	            $html .= '<p class="element-text">';
        	            
        	            foreach ($fieldValues as $key => $fieldValue) {
        	                if (!item_field_uses_html('Item Type Metadata', $field, $key)) {
        	                    $fieldValue = nls2p($fieldValue);
        	                }
        	                $html .= '<div class="element-text">'.$fieldValue.'</div>';
        	                //$html .= '$fieldValue;
        	            }
        	            $html .= '</p>';
        	            
        	            
        	            
                        $html .= '</div>';
        	        }
        	    }
    	    }

    	    $html .= show_item_metadata(array('show_element_sets' => array('Europeana Object')));


   
    	    
    	    $elements = $item->getItemTypeElements();
    	    
    	    foreach ($elements as $element) {
    	        if (strtolower($element->name) == "license"){
    	        	$licenseVal = item(ELEMENT_SET_ITEM_TYPE, $element->name);

    	        	if( strlen($licenseVal) > 0  ){
       	        		 //   any image tag $val contains (img)
       	        		 //   the href of any anchor wrapping the image (lnk)
       	        		 //   the $val with the image tag removed (rem)
       	        		 //   the src attribute of any image tag (src)
       	        		$parsedLicense = parseRightsValue($licenseVal);
       	        		/*
        	        	$html .= '<div class="element" id="dublin-core-license">';
       	        		$html .= 	'<div class="metadata-rights">';
       	        		$html .= 		'<table><tr>';
       	        		$html .= 			'<td>';
       	        		$html .= 				'<h6>License</h6>';
       	        		$html .= 			'</td>';
       	        		$html .= 			'<td>';
                        $html .= 				'<p class="element-text">'.$parsedLicense["rem"].'</p>';
                            
						if($parsedLicense["lnk"]){
							$html .=			'<a rel="license" href="'.$parsedLicense["lnk"].'">';								
						}
						if($parsedLicense["src"]){
							$html	.=			'<img src="'.$parsedLicense["src"].'" alt="Creative Commons License" />';								
						}
						if($parsedLicense["lnk"]){
							$html	.=			'</a>';
						}
                        $html .= 			'</td>';
                        $html .=   		'</tr></table>';
                        $html .= 	'</div>';
                        $html .= '</div>';    	        
                        */
       	        		$html .= '<div class="element" id="dublin-core-license">';
       	        		$html .= 	'<div class="metadata-rights">';

       	        		$html .= 				'<h6>License</h6>';

                        $html .= 				'<p class="element-text">' . $parsedLicense["rem"];
                            
						if($parsedLicense["lnk"]){
							$html .=			'<a rel="license" href="'.$parsedLicense["lnk"].'">';								
						}
						if($parsedLicense["src"]){
							$html	.=			'<img src="'.$parsedLicense["src"].'" alt="Creative Commons License" />';								
						}
						if($parsedLicense["lnk"]){
							$html	.=			'</a>';
						}
						$html .= 		'</p>';
						$html .= 	'</div>';
						$html .= '</div>';
       	        		
    	        	}
    	        		
    	        	
                    
    	        }
    	    }
    	    return $html;
    	}
        else {
    	    return show_item_metadata($options, $item);
        }

    }

}

