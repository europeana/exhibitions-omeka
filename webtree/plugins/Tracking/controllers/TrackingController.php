<?php

require_once 'Embed.php';

class Tracking_TrackingController extends Omeka_Controller_Action
{
    public function init()
    {
    	error_log("inside Tracking_TrackController init()");
        $this->_modelClass = 'Embed';
    }
    
    
   	public function downloadAction()
   	{        
        $request = $this->getRequest();
		
        
		// set the default timezone to use.
		date_default_timezone_set('UTC');
		$period = date('Ym');
		
   		if( $_SERVER['HTTP_REFERER']){
   			// update or create new....
   	        $embed = $this->getTable('Embed')->findBySql('referer = ? AND resource = ? AND period = ?', array($_SERVER['HTTP_REFERER'], $request->getParam('id'), $period ) );
				
   	        if($this->getTable('Embed')){   	        	
   	        	error_log("got table");
   	        }
   	        else{
   	        	
   	        	error_log("not got table");
   	        }

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

   		error_log("track embed loads file id " . $request->getParam('id'));
   		
        $item = $this->findById($request->getParam('id'), 'Item');
        $file = $item -> Files[0];
        
        // Get the archive path for the file
        //$path = $file->getWebPath('archive');
        $path = $file->getWebPath('fullsize');
        
        $this->getResponse()->setHeader('Location', $path);
         
        //Don't render anything 
        $this->_helper->viewRenderer->setNoRender();
    }
}