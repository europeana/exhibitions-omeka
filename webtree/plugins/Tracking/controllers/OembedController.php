<?php


class Tracking_OembedController extends Omeka_Controller_Action
{
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

        /* OEMBED FIELDS
         * Provider URL: 	http://exhibitions.europeana.eu
       	 * Provider Name: 	Europeana
       	 * Type: 	link
       	 * Title: 	The bride takes leave of her mother by Pesovár Ernő (Collector) | Themes | Weddings In Eastern Europe | Exhibitions
       	 * Description: 	
       	 * URL: 	http://exhibitions.europeana.eu/exhibits/show/weddings-in-eastern-europe/husbands-house/item/325
       	 * Width: 	
       	 * Height: 	
       	 * HTML: 	
       	 * Thumbnail Url: 	http://exhibitions.europeana.eu/track_embed/download/325
       	 * Thumbnail Width: 	600
       	 * Thumbnail Height: 	395
       	 * Author: 	
       	 * Author url: 	
       	 * Display:
         */
       	
       	
        $map = array(
            // (dc | europeana) => oembed
            'Title' => 'title',
            'Creator' => 'author',
            'Source' => 'provider_name',
            'Description' => 'description',
            'Rights' => 'license'
        );
       	
        
        
        // HTML : depends on mime
        
        // thumbnail_url

        $dcFieldNames = array('Title', 'Description', 'Creator', 'Type', 'Subject', 'Source', 'Publisher', 'Date', 'Contributor', 'Rights', 'Format');
       	$elements = $item->getItemTypeElements();
       	$jsonPairs = array();

       	// loop europeana metadata
        foreach ($elements as $element) {
           	if($map[$element->name]){
           		$val = item(ELEMENT_SET_ITEM_TYPE, $element->name);
           		if($val){
               		$oembedFieldName = $map[$element->name];
               		
                	//$val = str_replace('&quot;', "'", $val);
                	//$val = str_replace('"', "'", $val);
               		//$jsonPair = array('"' . $oembedFieldName . '"', '"' . $val . '"');

               		error_log("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");
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
                	//$val = str_replace('&quot;', "'", $val);
                	//$val = str_replace('"', "'", $val);
                	
               		if($oembedFieldName == "provider_name"){
                  		$jsonPair = array('"' . $oembedFieldName . '"', json_encode($val));                		
                	}
                	else{
                  		$jsonPair = array('"' . $oembedFieldName . '"', json_encode($val));                		
                	}
               		$jsonPairs[] = $jsonPair;                	                		
                }
           	}
        }
        
        
        // Add hard-coded provider
  		//$jsonPair = array('"provider_url"', '"' . str_replace("/","\\/", WEB_ROOT) . '"');                		
  		$jsonPair = array('"provider_url"', '"' . WEB_ROOT . '"');                		
		$jsonPairs[] = $jsonPair;                	                		

        preg_match("/^image/", $mime, $imgMatches);
        preg_match("/^video/", $mime, $videoMatches);
        preg_match("/pdf/",   $mime, $pdfMatches);
        
        if( sizeof($imgMatches) > 0 ){
        	
        	$thumbnailUrl	= html_escape(file_display_uri($file, 'thumbnail'));
        	$imgUrl			= html_escape(file_display_uri($file, 'archive'));

        	list($thumbnailWidth, $thumbnailHeight, $type, $attr) = getimagesize($thumbnailUrl);

        	//$jsonPair = array('"thumbnail_url"', '"' . str_replace("/","\\/", $thumbnailUrl) . '"');                		
        	$jsonPair = array('"thumbnail_url"',	json_encode($thumbnailUrl) );                		
    		$jsonPairs[] = $jsonPair;                	                		
    		$jsonPair = array('"thumbnail_width"',	json_encode($thumbnailWidth) );                		
    		$jsonPairs[] = $jsonPair;                	                		
    		$jsonPair = array('"thumbnail_height"',	json_encode($thumbnailHeight) );                		
    		$jsonPairs[] = $jsonPair;                	                		

        	/**********************************/
        	
      		$jsonPair = array('"url"', json_encode($imgUrl) );                		
    		$jsonPairs[] = $jsonPair;                	                		

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

    		$jsonPair = array('"type"', '"photo"');                		
    		$jsonPairs[] = $jsonPair;
    		
        }
        elseif( sizeof($videoMatches) > 0 ){					// TODO 				ANDY
        	
        	$width = 470;
        	$height = 400;
        	
        	$jsonPair = array('"width"', '"' . $width . '"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"height"', '"' . $height . '"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"type"', '"video"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$videoUrl = WEB_ROOT . '/track_embed/download/' . $itemId;
        	$videoUrl = json_encode($videoUrl);
        	//$videoUrl = str_replace('"', '\\"', $videoUrl);
        	//$videoHtml = '"\u003ciframe src=' . $videoUrl . ' frameborder=\"0\" width=\"' . $width . '\" height=\"' . $height . '\" allowfullscreen\u003e\u003c\/iframe\u003e"';
        	$videoHtml = '"\u003ciframe src=' . $videoUrl . ' frameborder="0" width="' . $width . '" height="' . $height . '" allowfullscreen\u003e\u003c\/iframe\u003e"';
        	$jsonPair = array('"html"', $videoHtml);
        	$jsonPairs[] = $jsonPair;
        }
        elseif( sizeof($pdfMatches) > 0 ){
        	$jsonPair = array('"type"', '"link"');                		
        	$jsonPairs[] = $jsonPair;
        }

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
        
        //error_log("<http://google.co.uk>");
        //error_log(json_encode('<http://google."co".uk>'));
        //echo utf8_encode( $result );
        //echo json_encode( $result );
        echo $result;

	}
}
