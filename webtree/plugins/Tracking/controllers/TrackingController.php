<?php

require_once 'Embed.php';

class Tracking_TrackingController extends Omeka_Controller_Action
{
    public function init()
    {
        $this->_modelClass = 'Embed';
    }
    
    public function endsWith($haystack,$needle,$case=true) {
        if($case){return (strcmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);}
        return (strcasecmp(substr($haystack, strlen($haystack) - strlen($needle)),$needle)===0);
    }

    // http://localhost/webtree/track_embed/download/185?linkback=http://localhost/webtree/items/show/185
   	public function downloadAction()
   	{
   	    include('themes/main/custom_ve_exhibits.php');
   	    include('themes/main/custom_ve_helpers.php');

   		// get item from request
   		
		$request = $this->getRequest();
        $item = $this->findById($request->getParam('id'), 'Item');
        
        set_current_item($item);
        
        $file = $item -> Files[0];
    	$mime = $file->getMimeType();

		// set the default time zone to use
    	
		date_default_timezone_set('UTC');
		$period = date('Ym');
		
   		if( $_SERVER['HTTP_REFERER']){
   			
   			// record activity in database: either update or create new
   			
   	        $embed = $this->getTable('Embed')->findBySql('referer = ? AND resource = ? AND period = ?', array($_SERVER['HTTP_REFERER'], $request->getParam('id'), $period ) );

   			if($embed && count($embed) > 0 ){
   				$embed = reset($embed);
   				$embed->view_count = $embed->view_count + 1;	// bump view_count
   				$embed->last_accessed = NULL;					// force update in the db by nullifying here
   				$embed->save();
   			}
   			else{
   				$embed = new Embed();
   				$data = array(
   						"referer" => $_SERVER['HTTP_REFERER'],
   						"resource" => $request->getParam('id'),
   						"period" => $period,
   						"view_count" => 1
   						);
   				$embed->setArray($data);
   				$embed->save();
   			}
   		}
   		else{
   			error_log("No http referer = no tracking");
   		}
   		
       	if(preg_match("/^image/", $mime)) {
       		// for images we use a simple redirect
            $path = $file->getWebPath('fullsize');
            $this->getResponse()->setHeader('Location', $path);
        }
        else{

        	// if it's not an image then we're embedding media - load the media-elements player
        	
	    	echo '<html>';
	    	echo 	'<head>';
	   		echo 		'<link href="' . WEB_ROOT . '/themes/main/css/mediaelement-2.7/mediaelementplayer.css" media="all" rel="stylesheet" type="text/css">';
	   		echo 		'<link href="' . WEB_ROOT . '/themes/main/css/mediaelement-2.7/mejs-skins.css" media="all" rel="stylesheet" type="text/css" >';
	   		echo 		'<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>';
	   		echo 		'<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.8.16/jquery-ui.min.js"></script>';
	   		echo 		'<script type="text/javascript" src="' . WEB_ROOT . '/themes/main/javascripts/mediaelement-2.7/build/mediaelement-and-player.js"></script>';
	   		echo 	'</head>';
	   		echo 	'<body style="background:transparent">';
	   		echo 		'<style>.mejs-overlay-loading{width:88px!important;}</style>';
	   		
	   		if (preg_match("/^audio/", $mime)) {
	   			$audioSrc = file_display_uri($file, $format = 'archive'); 
	   			echo '<div id="player" class="player">';
	            echo 	'<audio  controls="controls"  type="audio/mp3" src="' . $audioSrc . '" width="460" height="84" style="width:100%; height:100%;"></audio>';
	            echo '</div>';
	   		}
	   		else{
		   		$videoSrc = file_display_uri($file, $format = 'archive'); 
		   		
		   		echo '<div id="player" class="player">';
		   		echo 	'<video  width="0" height="0" style="width:100%; height:100%;" preload="none">';
		   		
	            if($this->endsWith($videoSrc, '.mp4')){
	            	echo	'<source type="video/mp4" src="' . $videoSrc . '" />';
	            }
	            if($this->endsWith($videoSrc, '.webm')){
	            	echo	'<source type="video/webm" src="' . $videoSrc . '" />';
	            }
	            if($this->endsWith($videoSrc, '.ogv')){
	            	echo	'<source type="video/ogg" src="' . $videoSrc . '" />';
	            }
	            if($this->endsWith($videoSrc, '.ogv')){
	            	echo	'<source type="video/ogg" src="' . $videoSrc . '" />';
	            }
		   		
		   		echo		'<object type="application/x-shockwave-flash" data="' . WEB_ROOT . '/themes/main/javascripts/mediaelement-2.7/build/flashmediaelement.swf">';
		   		echo			'<param name="movie" value="' . WEB_ROOT . '/themes/main/javascripts/mediaelement-2.7/build/flashmediaelement.swf" />';
		   		echo			'<param name="flashvars" value="controls=true&amp;file=' . $videoSrc .  '" />';
		   		echo		'</object>';
		   		echo 	'</video>';
		   		echo '</div>';
	   		}
	   		
	   		
	   		// START META-FIELDS
	   		
			$embedFields = array("title", "creator", "data provider", "provider", "source");

			echo '<ul style="display:block;clear:both;list-style-type:none;padding:0px;margin:0px;padding-top:0.5em;line-height:1em;font-family:Chevin,\'Trebuchet MS\',Helvetica,sans-serif;">';

			$licenseInfo = ve_exhibit_builder_license_info($item);
			$licenseInfo =  parseRightsValue($licenseInfo);
			
			if($licenseInfo["lnk"] && $licenseInfo["src"]){
				echo '<span style="font-weight:bold;">License: </span>';			
				echo '<a rel="license" href="'.$licenseInfo["lnk"].'">';								
				echo 	'<img style="border-width:0;" src="'.$licenseInfo["src"].'" alt="Creative Commons License" />';								
				echo '</a>';								
			}
			
			if($dcFieldsList = get_theme_option('display_dublin_core_fields')){
				$dcFields = explode(',', str_replace(' ','',$dcFieldsList));
				foreach($dcFields as $field){
					$field = trim($field);
					if (element_exists('Dublin Core', $field)){
						if( in_array(strtolower($field), $embedFields) ){
							if($fieldValues = item('Dublin Core', $field, 'all')){

							foreach ($fieldValues as $key => $fieldValue){
								if(!item_field_uses_html('Dublin Core', $field, $key)){
									$fieldValue = nls2p($fieldValue);
								}
								
								echo '<li style="margin-left:0px!important;"><span style="font-weight:bold;">'.$field.':</span> ';
								
								$linkback		= $_GET["linkback"];
								$googleTracking = "utm_source=embeddeditem&utm_medium=externalsite&utm_campaign=exhibitionembed";
								$linkback		.= "?" . $googleTracking;
								
								if(strtolower($field) == "title"){
									$fieldValue = '<a href="'.$linkback.'" target="_parent">' . $fieldValue . "</a>";
								}

								$fieldValue = str_replace('<p>',	'',	$fieldValue);
								$fieldValue = str_replace('</p>',	'',	$fieldValue);
								$fieldValue = str_replace('<br>',	'',	$fieldValue);
								$fieldValue = str_replace('<br/>',	'',	$fieldValue);
								$fieldValue = str_replace('<br />',	'',	$fieldValue);
								echo $fieldValue;
								echo '</li>';
							}
							$fieldValue =  $licenseInfo["rem"];
						}
					}
				}
			} // end field list
			
			$source = getItemTypeMetadataEntry($item, "Source");
			if(strlen($provider) > 0 ){
				echo '<li style="margin-left:0px!important;"><span style="font-weight:bold;">Source:</span> '.$source.'</li>';
			}

			$provider = getItemTypeMetadataEntry($item, "Provider");
			if(strlen($provider) > 0 ){
				echo '<li style="margin-left:0px!important;"><span style="font-weight:bold;">Provider:</span> '.$provider.'</li>';
			}						
			echo	'</ul>';	// end field list
	   		
	   		// END META-FIELDS
	        
	   		echo '<script>';
	   		echo 	'jQuery("audio,video").mediaelementplayer({';
	   		echo 		'audioHeight: 30,';
	   		echo 		'plugins: ["flash","silverlight"],';
	   		echo 		'features: ["playpause", "progress", "current", "duration", "volume", "fullscreen"],';
	   		echo 		'success: function(player, node) {';
	   		echo 		'if(jQuery("div#player").width() == 0){'; // IE7 fix
	   		echo 			'jQuery("div#player").width("350px");';
	   		echo 			'player.setVideoSize(350, "auto");';
	   		echo 		'mejs.MediaElementPlayer.prototype.buildoverlays();';
	   		echo 	'}';
	   		echo '}';
	   		echo '});';
	   		echo '</script>';
        }

   		echo '</body>';
    	echo '</html>';

        $this->_helper->viewRenderer->setNoRender();
    }
}
}