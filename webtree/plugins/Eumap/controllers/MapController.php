<?php

require_once 'EuMapStoryPoint.php';
require_once 'ExhibitSectionTable.php';


class Eumap_MapController extends Omeka_Controller_Action
{
	
   	public function addAction(){

   		error_log("Add action");

        $eumap = new EUMap();

        $eumap->setArray($_POST);
        $eumap->save();

        $this->redirect->gotoUrl('eumap');

   	}

   	public function deleteAction(){
   		
   		error_log("Delete action (".$_POST['id'].")");
   		
   		$mapTable = get_db()->getTable('EUMap');

        $eumap = $mapTable->find($_POST['id']);

        $points = $eumap -> getStoryPoints();
        
		foreach ($points as $point) {
			$point -> delete();
		}
        
   		$eumap->delete();
   		
   		$this->redirect->gotoUrl('eumap');
  		
   	}

   	public function editAction(){
   		
   		error_log("Edit action (".$_POST['id'].")");
   		   	 
   		$mapTable = get_db()->getTable('EUMap');

        $eumap = $mapTable->find($_POST['id']);

        $eumap->setArray($_POST);
        $eumap->save();
        
        $this->redirect->gotoUrl('eumap');
   	}
   	
   	
   	public function addpointAction(){

   		$point = new EUMapStoryPoint();
   		$point->setArray($_POST);
        
   		$hash			= explode("/", $_POST['hash'] );
   		$hash			= $hash[count($hash)-2] . '/' . $hash[count($hash)-1];
        $point['hash']	= $hash;

        $point->save();

   		$this->redirect->gotoUrl('eumap');
   	}

   	
   	public function deletepointAction(){
   		
   		error_log("Delete action (".$_POST['id'].")");
   		
   		$pointTable = get_db()->getTable('EUMapStoryPoint');

        $point = $pointTable->find($_POST['id']);

        $point->delete();
   		
   		$this->redirect->gotoUrl('eumap');
  		
   	}

   	
   	public function editpointAction(){
   		
   		error_log("Edit point action (".$_POST['id'].")"  . "    " . $_POST['hash']);
   		
   		$pointTable = get_db()->getTable('EUMapStoryPoint');

        $point = $pointTable->find($_POST['id']);

        $point->setArray($_POST);
        
   		$hash	= explode("/", $_POST['hash'] );
   		$hash	= $hash[count($hash)-2] . '/' . $hash[count($hash)-1];
        $point['hash'] = $hash;
        
        
        $point->save();
   		
   		$this->redirect->gotoUrl('eumap');
  		
   	}
   	
   	

   	/* For a given exhibition slug:
   	 * 	- get the exhibition
   	 * 		- loop each section
   	 * 			- loop each section's pages
   	 * 				- build json pairs array ["title" : "public-url"]
   	 * 
   	 * */
   	
   	// /admin/eumap/map/data?slug=xxxx
   	
   	public function dataAction(){
   	
   		$this->_helper->viewRenderer->setNoRender();

   		$tag	= $_GET['tag'];
   		$tagId	= '';
   		//error_log( "tag =  " . $tag );

   		
   		// get items for exhibition that has tag (param)
   		// exhibit id is 18
   		

		$tagTable = get_db()->getTable('Tag');
		$tags = $tagTable->fetchObjects("select * from omeka_tags where name = '" . $tag . "'");

		foreach ($tags as $tag) {
			error_log('tag ' . $tag->name . ', id = ' . $tag->id);
			$tagId = $tag->id; 
		}


		$taggingsTable = get_db()->getTable('Taggings');

		$joinQuery = "SELECT relation_id FROM omeka_taggings where type = 'Exhibit' and tag_id = " . $tagId . "";

		
		$exhibitTable	= get_db()->getTable('Exhibit');
		$exhibitQuery = 'select * from omeka_exhibits where id in (' . $taggingsTable->fetchOne($joinQuery) . ')';
		$exhibits		= $exhibitTable->fetchObjects($exhibitQuery);
				
		foreach($exhibits as $exhibit){
			foreach ($exhibit->Sections as $key => $exhibitSection){				
				if ($exhibitSection->hasPages()) {
					foreach ($exhibitSection->Pages as $page) {
						error_log("    "  .   $page -> title );
						$jsonPair	=  '{"id":"' . $page->id . '", "title" : "' . $page -> title . '", "url": "' . exhibit_builder_exhibit_uri($exhibit, $exhibitSection, $page) . '"}' ;
						$jsonPairs[] = $jsonPair;                		
					}
				}
			}
		}


		$result =  '[' . implode(",", $jsonPairs) . ']';
        echo $result;
        
   	}
   	

   	
   	// test function: we need to get the page title, url and the 1st image - all from the page id - for use in the admin tool and in the markers
   	
   	// /admin/eumap/map/test?pageId=615
   	
   	public function testAction(){
   	
   		$this->_helper->viewRenderer->setNoRender();
   		
   		$pageId = $_GET['pageId'];
   		
   		$title  =	'';
   		$url	= 	'';
   		$imgUrl =	'';

   		
   		// load
   		
   		$page		= get_db() -> getTable('ExhibitPage') -> find($pageId);
		$section	= get_db() -> getTable('ExhibitSection') -> find($page->section_id);
		$exhibit	= get_db() -> getTable('Exhibit') -> find($section->exhibit_id);

		
		// read
		
		$item_id	= reset($page -> getPageEntries()) -> item_id;
		$file		= reset( get_db() -> getTable('Item') -> find($item_id) -> Files );
		
		
		// write
		
		$title		= $page->title;
		$url		= exhibit_builder_exhibit_uri( $exhibit, $section, $page);
		
		$hash		= explode("/", $url);
		$hash		= $hash[count($hash)-2] . '/' . $hash[count($hash)-1];
		
		$imgUrl		= file_display_uri($file, $format = 'square_thumbnail');
		
   		$result =	'RESULT FOR ' . $pageId . '<br/>TITLE: ' . $title . '<br/>URL: ' . $url . '<br/>IMG_URL: ' . $imgUrl;
   		
        //echo $result;
        echo '{"title":"' . $title . '","url":"' . $url . '", "imgUrl":"' . $imgUrl . '", "hash": "' . $hash .'"}';
   	}
   	
}

