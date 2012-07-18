<?php


class Tracking_OembedController extends Omeka_Controller_Action
{
    // http://localhost/ombad/webtree/service/oembed/8
    // http://localhost/webtree/service/oembed/8
   	public function oembedAction()
   	{
		$request	= $this->getRequest();
        $fmt 		= $request->getParam('id');
        $url 		= $request->getParam('url');
        $url		= urldecode($url);
        $url		= str_replace('127.0.0.1', "", $url);
        
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
       	 * Title: 	The bride takes leave of her mother by PesovÃ¡r ErnÅ‘ (Collector) | Themes | Weddings In Eastern Europe | Exhibitions
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
       	
       	
       	// TODO: see David for full mapping
        $map = array(
            // (dc | europeana) => oembed
            'Title' => 'title',
            'Creator' => 'author',
            'Source' => 'provider_name',
            'Description' => 'description'
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
               		
                	$val = str_replace('&quot;', "'", $val);
                	$val = str_replace('"', "'", $val);

               		$jsonPair = array('"' . $oembedFieldName . '"', '"' . $val . '"');
               		
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
                	$val = str_replace('&quot;', "'", $val);
                	$val = str_replace('"', "'", $val);
                	
                	
                	
                	
               		if($oembedFieldName == "provider_name"){
                  		$jsonPair = array('"' . $oembedFieldName . '"', '"Europeana; ' . $val . '"');                		
                	}
//               		elseif($oembedFieldName == "title"){
  //                		$jsonPair = array('"' . $oembedFieldName . '"', '"faketitle--' . $val . '"');                		
    //            	}
                	else{
                  		$jsonPair = array('"' . $oembedFieldName . '"', '"DEF EMBED FIELD--' . $val . '"');                		
                	}
               		$jsonPairs[] = $jsonPair;                	                		
                }
           	}
        }

        
        
        // Add hard-coded provider
  		$jsonPair = array('"provider_url"', '"http://exhibitions.europeana.eu"');                		
		$jsonPairs[] = $jsonPair;                	                		

        preg_match("/^image/", $mime, $imgMatches);
        preg_match("/^video/", $mime, $videoMatches);
        
        
        if( sizeof($imgMatches) > 0 ){
        	
        	//$thumbnail = html_escape(file_display_uri($file, 'square_thumbnail'));
        	//$thumbnail = html_escape(file_display_uri($file, 'archive'));
        	$thumbnail = html_escape(file_display_uri($file, 'thumbnail'));

      		$jsonPair = array('"thumbnail_url"', '"' . $thumbnail . '"');                		
    		$jsonPairs[] = $jsonPair;                	                		

    		list($width, $height, $type, $attr) = getimagesize($thumbnail);
    		
      		$jsonPair = array('"width"', '"' . $width . '"');                		
    		$jsonPairs[] = $jsonPair;

    		$jsonPair = array('"height"', '"' . $height . '"');                		
    		$jsonPairs[] = $jsonPair;

    		$jsonPair = array('"type"', '"photo"');                		
    		$jsonPairs[] = $jsonPair;
    		
        }
        elseif( sizeof($videoMatches) > 0 ){
        	
        	$jsonPair = array('"width"', '"470"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"height"', '"550"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	$jsonPair = array('"type"', '"video"');                		
        	$jsonPairs[] = $jsonPair;
        	
        	//     width=\"480\" height=\"270\"
        	
        	//$escapedWebroot = str_replace('\', "\/", WEB_ROOT);
        	//$escapedWebroot = str_replace('/', "\/", WEB_ROOT);
        	
        	
        	$videoUrl = WEB_ROOT . '/track_embed/download/' . $itemId;

        	error_log("VIDEO URL = " . $videoUrl);

        	$videoUrl = json_encode($videoUrl);
        	//$videoUrl = str_replace('"', "", $videoUrl);

        	error_log("VIDEO URL = " . $videoUrl);
        	

        	$videoUrl = str_replace('"', '\\"', $videoUrl);
        	
        	
        	
//        	$videoUrl = str_replace('"', "", $videoUrl);
        	
        	$videoHtml = '"\u003ciframe src=' . $videoUrl . ' frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e"';
        	
        	error_log("VIDEO HTML = " . $videoHtml);

        	
  //     	    $escape = Zend_Utf8::escape($string);
        	
        	$jsonPair = array('"html"', $videoHtml);
        	
        	$jsonPairs[] = $jsonPair;
        }
		
		
        
        if($fmt=="xml"){
        	
        	//header('Content-type: xml');
        	
        	echo '<?xml version="1.0" encoding="utf-8" ?>';
        	echo '<oembed>';
        	
        	
        	echo '<provider_url>http:\/\/acceptance.exhibit.eanadev.org\/</provider_url>';
        	echo '<thumbnail_url>http:\/\/acceptance.exhibit.eanadev.org\/splash\/img\/landscape-logo.png</thumbnail_url>';
        	echo '<title>Andy oembed test</title>';
        	echo '<html>this is where the embed goes here</html>';
        	echo '<author_name>Andy MacLean</author_name>';
        	echo '<height>270</height>';
        	echo '<thumbnail_width>180</thumbnail_width>';
        	echo '<width>180</width>';
        	echo '<version>1.0</version>';
        	echo '<author_url>http:\/\/acceptance.exhibit.eanadev.org</author_url>';
        	echo '<provider_name>Europeana - embed service</provider_name>';
        	echo '<type>link</type>';
        	echo '<thumbnail_height>360</thumbnail_height>';
        	
        	
        	echo '</oembed>';
        	
        }
        
        else{
        	
            $jsonVals = array();
            foreach ($jsonPairs as $jsonPair) {
            	$jsonVals[] = implode(":", $jsonPair);
            }
            //echo '{' . implode(",", $jsonVals) . '}';
            
            
            
            // cs‡rd‡sy
            // changed provider_url
            // added thumbnail dimensions
            // removed accented 'a'
            // matched provider url to test

            $x=   '{"title":"Slow and quick csardasy‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡",' .
					'"description":"Slow and quick csardasy - most entertaining dances are dances for couples‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡‡,",' .
					'"author":"DEF EMBED FIELD--Performed by unknown dancers",' .
					'"provider_name":"Europeana; Hungarian Academy of Sciences Institute for Musicology; Hungary",' .
					//'"provider_url":"http:\/\/test.exhibit.eanadev.org",' .
					'"width":"470","height":"550",' .
					'"thumbnail_width": 480, "thumbnail_width": 360,' .
					'"type":"video",' .
					'"html":"\u003ciframe src=\"http:\/\/127.0.0.1\/ombad\/webtree\/track_embed\/download\/269\" frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e"' .
					'} ';
            echo $x;

            /*
        	$youtube =  '{"provider_url": "http:\/\/www.youtube.com\/", ' . 
            			 '"title": "Amazing Nintendo Facts", ' .
            			 '"html": "\u003ciframe width=\"480\" height=\"270\" src=\"http:\/\/www.youtube.com\/embed\/M3r2XDceM6A?fs=1\u0026feature=oembed\" frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e", ' .
            			 '"author_name": "ZackScott", "height": 270, ' .
            			 '"width": 480, ' . 
            			 '"author_url": "http:\/\/www.youtube.com\/user\/ZackScott", ' .
            			 '"provider_name": "YouTube", ' . 
            			 '"type": "video" ' .
            			 '}';
        	echo $youtube;
        	*/
            
            
       		//	http://test.exhibit.eanadev.org/archive/files/0b340967b52ebf255b8669702fa2fe83.mp4
   			//  http:\/\/test.exhibit.eanadev.org\/archive\/files\/0b340967b52ebf255b8669702fa2fe83.mp4
   			//  http:\/\/test.exhibit.eanadev.org\/track_embed\/download\/269
/*   				
           	$youtube =     '{"provider_url": "http:\/\/www.youtube.com\/", ' . 
           		            '"thumbnail_url": "http:\/\/i2.ytimg.com\/vi\/M3r2XDceM6A\/hqdefault.jpg", ' . 
           		            '"title": "Amazing Europeana Facts", ' .
            		        '"html": "\u003ciframe width=\"480\" height=\"270\" src=\"http:\/\/test.exhibit.eanadev.org\/track_embed\/download\/269\" frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e", ' .
            		        '"author_name": "ZackScott", "height": 270, "thumbnail_width": 480, "width": 480, "version": "1.0", ' .
            		        '"author_url": "http:\/\/www.youtube.com\/user\/ZackScott", ' .
            		        '"provider_name": "YouTube", "type": "video", "thumbnail_height": 360}';
*/
/*  
            
            '{"title":"DEF EMBED FIELD--Slow and quick cs‡rd‡sy",'.
            '	"description":"DEF EMBED FIELD--Slow and quick cs‡rd‡sy - most entertaining dances are dances for couples,",'.
            ' 	"author":"DEF EMBED FIELD--Performed by unknown dancers",'.
            '	"provider_name":"Europeana; Hungarian Academy of Sciences Institute for Musicology; Hungary",'.
            ' 	"provider_url":"http://exhibitions.europeana.eu",'.
            '	"width":"470","height":"550",'.
            '	"type":"video",'.
            '	"html":"\u003ciframe src=\"http:\/\/127.0.0.1\/ombad\/webtree\/track_embed\/download\/269\" '.
            '			"frameborder=\"0\" '.
            '			" allowfullscreen\u003e\u003c\/iframe\u003e"} '
            
*/            
            
            	/*
        	$youtube =     '{"provider_url": "http:\/\/www.youtube.com\/", ' . 
        		            '"thumbnail_url": "http:\/\/i2.ytimg.com\/vi\/M3r2XDceM6A\/hqdefault.jpg", ' . 
        		         '"title": "Amazing Nintendo Facts", ' .
        		            '"html": "\u003ciframe width=\"480\" height=\"270\" src=\"http:\/\/www.youtube.com\/embed\/M3r2XDceM6A?fs=1\u0026feature=oembed\" frameborder=\"0\" allowfullscreen\u003e\u003c\/iframe\u003e", ' .
        		         '"author_name": "ZackScott", "height": 270, "thumbnail_width": 480, "width": 480, "version": "1.0", ' .
        		            '"author_url": "http:\/\/www.youtube.com\/user\/ZackScott", ' .
        		         '"provider_name": "YouTube", "type": "video", "thumbnail_height": 360}';
        	*/
            
        	//error_log($youtube);
        	
        	//echo $youtube;

            
            
            
            
            
        	//header('Content-type: application/json');
        	/*
       		echo '{';
       		echo '"provider_url": "http:\/\/acceptance.exhibit.eanadev.org\/",';
       		
       		echo '    "thumbnail_url": "http:\/\/acceptance.exhibit.eanadev.org\/splash\/img\/landscape-logo.png",';
       		echo '    "title": "Andy oembed test",';
       		echo '    "html": "this is where the embed goes",';
       		echo '    "author_name": "Andy MacLean",';
       		echo '    "height": 270,';
       		echo '    "thumbnail_width": 180,';
       		echo '    "width": 180,';
       		echo '    "version": "1.0",';
       		echo '    "author_url": "http:\/\/acceptance.exhibit.eanadev.org",';
       		echo '    "provider_name": "Europeana - embed service",';
       		echo '    "type": "link",';
       		echo '    "thumbnail_height": 360';
       		echo '}';
       		*/        	
        }
        
        $this->_helper->viewRenderer->setNoRender();
	}
   	
}