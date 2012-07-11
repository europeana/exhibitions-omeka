<?php


class Tracking_OembedController extends Omeka_Controller_Action
{
    public function init()
    {
    }
    

    // http://localhost/ombad/webtree/service/oembed/8
    // http://localhost/webtree/service/oembed/8
   	public function oembedAction()
   	{
		$request = $this->getRequest();
        $fmt = 		$request->getParam('format');
        
        if($fmt=="xml"){
        	
        	header('Content-type: xml');
        	
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
        
        else{//if($fmt == "json"){
        	
        	header('Content-type: application/json');
        	
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
        }
        
        $this->_helper->viewRenderer->setNoRender();
	}
   	
}