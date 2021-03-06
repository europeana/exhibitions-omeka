<?php


class Tracking_OembedController extends Omeka_Controller_Action
{
	// This is a straight copy...

   	function parseRights($val, $linkOnly = false){
   		include_once('themes/main/custom_ve_helpers.php');
   		$html = '';
   	    
   	    $parsedRights = parseRightsValue($val, true);

   	    if($linkOnly){
   	    	return $parsedRights["lnk"];
   	    }
   	    
		if($parsedRights["lnk"]){
				$html	.=		'<a rel="license" href="'.$parsedRights["lnk"].'">';				
		}
		if($parsedRights["src"]){
			$html	.=		'<img src="'.$parsedRights["src"].'" '
					. 			'alt="Creative Commons License" ';
			$html	.=		'/>';								
		}
		if($parsedRights["lnk"]){
			$html	.=		'</a>';
		}
		
		return $html;
   	}
   	
    // http://localhost/ombad/webtree/service/oembed/8
    // http://localhost/webtree/service/oembed/8
   	public function oembedAction()
   	{
   		$this->_helper->viewRenderer->setNoRender();

		$request	= $this->getRequest();
        $fmt 		= $request->getParam('id');
        $url 		= $request->getParam('url');
        $url		= urldecode($url);
        $url		= str_replace('127.0.0.1', "", $url);

        if($fmt!="json"){
            return;
        }
        
        preg_match_all('!\d+!', $url, $itemId);
        
        $this->_helper->viewRenderer->setNoRender();
        
        if( sizeof($itemId) != 1 || sizeof($itemId[0]) != 1){
        	header("HTTP/1.0 404 Not Found");
        	echo "<h1>404 Not Found</h1>";
            echo "The page that you have requested could not be found.";
        	return;        	
        }
        
       	$itemId = $itemId[0][0];
       	$item = get_item_by_id($itemId);
       	$file = $item->Files[0];
       	$mime = null;
       	
       	set_current_item($item);
       	
       	if($file){
       		$mime = $file->getMimeType();
       	}

        // format rights
       	
        $rights			= null;
        $license		= null;
        $rightsDef		= "All rights reserved";
       	$license		= item(ELEMENT_SET_ITEM_TYPE, "license");
        $rights			= item('Dublin Core', 'Rights'); // 'Rights' => 'license'
        $finalRightsVal	= "";
        
        /* Logic for rights:
         * 
         * 				(1)		(2)		(3)		(4)
         * RIGHTS		 Y		 Y		 N		 N
         * LICENSE		 Y		 N		 Y		 N
         * 
         * (1)	Show both, separated by a ":"
         * (2)	Show neither (show default)
         * (3)	Show license
         * (4)	Show neither (show default)
         * 
         * 
         */
        if($rights && $license){
        	$finalRightsVal = $this->parseRights($license) . " : ";
        	
        	if($finalRightsVal == " : "){
        		$finalRightsVal = $license . " : ";
        	}

        	if(item_field_uses_html('Dublin Core', 'Rights')){
        		$finalRightsVal .= $this->parseRights($rights);
        	}
        	else{
        		$finalRightsVal .= $rights;
        	}
        }
        elseif($rights && !$license){
        	$finalRightsVal = $rightsDef;
        }
        elseif(!$rights && $license){
        	$finalRightsVal = $this->parseRights($license);
        }
        else{
        	$finalRightsVal = $rightsDef;
        }
        $finalRightsValHtml = $finalRightsVal;
        $finalRightsVal		= html_escape($finalRightsVal);
        $finalRightsVal		= json_encode($finalRightsVal);

    	// end rights
       	
       	
       	
        $map = array(
            // (dc | europeana) => oembed
            'Title' => 'title',
            'Creator' => 'author',
            'Source' => 'provider_name',
            'Description' => 'description'
         );
       	
        
        // HTML : depends on mime

        $dcFieldNames = array('Title', 'Description', 'Creator', 'Type', 'Subject', 'Source', 'Publisher', 'Date', 'Contributor', 'Format');
       	$elements = $item->getItemTypeElements();

       	// loop europeana metadata
        foreach ($elements as $element) {
           	if($map[$element->name]){
           		$val = item(ELEMENT_SET_ITEM_TYPE, $element->name);
           		if($val){
               		$oembedFieldName = $map[$element->name];
               		$jsonPair = array('"' . $oembedFieldName . '"', json_encode($val) );
               		$jsonPairs[] = $jsonPair;
           		}
           	}
        }

       	// loop dublin core metadata        
        foreach ($dcFieldNames as $dcFieldName) {
           	if($map[$dcFieldName]){
           		$oembedFieldName = $map[$dcFieldName];
                $val = item('Dublin Core', $dcFieldName);
                
                if($val){
                	
                	$jsonPair = null;
                	
               		if($oembedFieldName == "provider_name"){
                  		$jsonPair = array('"' . $oembedFieldName . '"', json_encode("Europeana: " . $val));                		
                	}
                	else{
                  		$jsonPair = array('"' . $oembedFieldName . '"', json_encode($val));                		
                	}
               		$jsonPairs[] = $jsonPair;                	                		
                }
           	}
        }
        
   		


        
        // Add hard-coded provider
  		$jsonPair = array('"provider_url"', '"' . WEB_ROOT . '"');                		
		$jsonPairs[] = $jsonPair;                	                		

        preg_match("/^image/", $mime, $imgMatches);
        preg_match("/^video/", $mime, $videoMatches);
        preg_match("/pdf/",   $mime, $pdfMatches);
        preg_match("/^audio/", $mime, $audioMatches);

        $rich = item(ELEMENT_SET_ITEM_TYPE, "oembed rich");
        
        if( sizeof($imgMatches) > 0 ){
        	
        	// image can be "rich" or "photo" - both require proportionate dimensions for maxwidth/maxheight parameters
        	$imgUrl			= html_escape(file_display_uri($file, 'fullsize'));
    		list($width, $height, $type, $attr) = getimagesize($imgUrl);
    		
    		$maxwidth	= $request->getParam("maxwidth");
    		$maxheight	= $request->getParam("maxheight");
    		
    		if($maxwidth){
    			if($width > $maxwidth){
    				$ratio = $maxwidth / $width;
    				$width = $maxwidth;
    				$height = $height * $ratio; 
    			}
    		}
    		
    		if($maxheight){
    			if($height > $maxheight){
    				$ratio = $maxheight / $height;
    				$height = $maxheight;
    				$width = $width * $ratio;
    			}
    		}

      		$jsonPair = array('"width"', '"' . $width . '"');                		
    		$jsonPairs[] = $jsonPair;

    		$jsonPair = array('"height"', '"' . $height . '"');                		
    		$jsonPairs[] = $jsonPair;

    		
	        if($rich){
	    		// "rich" has html and no thumbnail
	        	
	        	$html	=		'<div style="position:relative; width:'.$width.'px;height:'.$height.'px;">'
	        			.		 	'<a href="'.$url.'">'
	        			.				'<img width="100%" src="' . WEB_ROOT . '/track_embed/download/' . $item->id . '"/>'
	        			.			'</a>'
	        			.			'<div style="position: relative; top: -2.5em; margin-left: 1em; font-size:1.2em; font-weight:bold;">'
	        			.  				$finalRightsValHtml
	        			.			'</div>'
	        			.		'</div>';
	        			
   	        	$jsonPair = array('"html"',	json_encode($html) );                		
   	    		$jsonPairs[] = $jsonPair;
   	    		
	    		$jsonPair = array('"type"', '"rich"');                		
	    		$jsonPairs[] = $jsonPair;
	    		
	    		// full rights as well as html rights
	        	$jsonPair = array('"license"', $finalRightsVal);                		
	        	$jsonPairs[] = $jsonPair;

	        }
	        else{
	    		// Non "rich" item has thumbnail and no html

	        	$thumbnailUrl	= html_escape(file_display_uri($file, 'thumbnail'));
	
	        	list($thumbnailWidth, $thumbnailHeight, $type, $attr) = getimagesize($thumbnailUrl);
	
	        	$jsonPair = array('"thumbnail_url"',	json_encode($thumbnailUrl) );                		
	    		$jsonPairs[] = $jsonPair;                	                		
	    		$jsonPair = array('"thumbnail_width"',	json_encode($thumbnailWidth) );                		
	    		$jsonPairs[] = $jsonPair;                	                		
	    		$jsonPair = array('"thumbnail_height"',	json_encode($thumbnailHeight) );                		
	    		$jsonPairs[] = $jsonPair;                	                		
	      		$jsonPair = array('"url"', json_encode(WEB_ROOT . '/track_embed/download/' . $item->id) );                		
	    		$jsonPairs[] = $jsonPair;
	    		$jsonPair = array('"type"', '"photo"');                		
	    		$jsonPairs[] = $jsonPair;
	    		
	    		// only the url needed in the rights
	            if($rights && $license){
	            	$finalRightsVal = $this->parseRights($license, true) . " : ";
	            	
	            	if($finalRightsVal == " : "){
	            		$finalRightsVal = $license . " : ";
	            	}
	            	if(item_field_uses_html('Dublin Core', 'Rights')){
	            		$finalRightsVal .= $this->parseRights($rights, true);
	            	}
	            	else{
	            		$finalRightsVal .= $rights;
	            	}
	            }
	            elseif($rights && !$license){
	            	$finalRightsVal = $rightsDef;
	            }
	            elseif(!$rights && $license){
	            	$finalRightsVal = $this->parseRights($license, true);
	            }
	            else{
	            	$finalRightsVal = $rightsDef;
	            }
	    		
	            $finalRightsVal	= html_escape($finalRightsVal);
	            $finalRightsVal = json_encode($finalRightsVal);

	        	$jsonPair = array('"license"', $finalRightsVal);            		
	        	$jsonPairs[] = $jsonPair;
        	}
        }
        elseif( sizeof($videoMatches) > 0 ){

        	$width = 470;
        	$height = 400;
        	
        	$jsonPair = array('"width"', '"' . $width . '"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"height"', '"' . $height . '"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"type"', '"video"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$videoUrl = WEB_ROOT . '/track_embed/download/' . $itemId;		// via download controller
        	//$videoUrl = file_display_uri($file, $format = 'archive'); 	// via omeka uri
        	$videoUrl = json_encode($videoUrl);
        	
        	$videoUrl = str_replace('"', '', $videoUrl);
        	$videoHtml = '"\u003ciframe src=\"' . $videoUrl . '\" frameborder=\"0\" width=\"' . $width . '\" height=\"' . $height . '\" allowfullscreen\u003e\u003c\/iframe\u003e"';
        	
        	$jsonPair = array('"html"', $videoHtml);
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"license"', $finalRightsVal);                		
        	$jsonPairs[] = $jsonPair;
        }
        elseif( sizeof($pdfMatches) > 0 ){
        	$jsonPair = array('"type"', '"link"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"license"', $finalRightsVal);                		
        	$jsonPairs[] = $jsonPair;
        }
        elseif( sizeof($audioMatches) > 0 ){
        	$width = 470;
        	$height = 200;
        	
        	$jsonPair = array('"width"', '"' . $width . '"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"height"', '"' . $height . '"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"type"', '"rich"');                		
        	$jsonPairs[] = $jsonPair;

        	$audioUrl = WEB_ROOT . '/track_embed/download/' . $itemId;
        	$audioUrl = str_replace('"', '', $audioUrl);
        	
        	$audioHtml = '"\u003ciframe src=\"' . $audioUrl . '\" frameborder=\"0\" width=\"' . $width . '\" height=\"' . $height . '\" allowfullscreen\u003e\u003c\/iframe\u003e"';

        	$jsonPair = array('"html"', $audioHtml);
        	$jsonPairs[] = $jsonPair;

        	$jsonPair = array('"license"', $finalRightsVal);                		
        	$jsonPairs[] = $jsonPair;
        }

    	$jsonPair = array('"version"', '"1.0"');                		
    	$jsonPairs[] = $jsonPair;
        
        
        /*
        if($fmt=="xml"){
        	echo '<?xml version="1.0" encoding="utf-8" ?>';
        	echo '<oembed>';
            foreach ($jsonPairs as $jsonPair) {
            	$tag = trim($jsonPair[0], '"');
            	$val = trim($jsonPair[1], '"');
            	echo ("<" . $tag . ">" . $val . "</" . $tag . ">");
            }
        	echo '</oembed>';
        	return;
        }
        */
    	
    
    	
    	
        // output 
       
        $jsonVals = array();
        foreach ($jsonPairs as $jsonPair) {
        	$jsonVals[] = implode(":", $jsonPair);
        }
        
        $result =  '{' . implode(",", $jsonVals) . '}';
        $result = str_replace('<', "\u003c", $result);
        $result = str_replace('>', "\u003e", $result);
        
        //error_log("\n\nRESULT:\n" . $result);
        echo $result;
 	}
   	

}
