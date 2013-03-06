<?php


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

        $eumapSP = new EUMapStoryPoint();
        $eumapSP->setArray($_POST);
        $eumapSP->save();

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
   		
   		error_log("Edit point action (".$_POST['id'].")");
   		
   		$pointTable = get_db()->getTable('EUMapStoryPoint');

        $point = $pointTable->find($_POST['id']);

        $point->setArray($_POST);
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

   		$slug = $_GET['slug'];
   		
   		error_log( "slug =  " . $slug );
   		
		$exhibitTable = get_db()->getTable('Exhibit');
		$exhibit = $exhibitTable -> findBySlug($slug);

		error_log( "exhibit =  " . $exhibit -> title );
		
		foreach ($exhibit->Sections as $key => $exhibitSection) {
			
			error_log("  "  .   $exhibitSection->title );

			if ($exhibitSection->hasPages()) {

				foreach ($exhibitSection->Pages as $page) {
					$jsonPair	=  '{"id":"' . $page->id . '", "title" : "' . $page -> title . '", "url": "' . exhibit_builder_exhibit_uri($exhibit, $exhibitSection, $page) . '"}' ;
					$jsonPairs[] = $jsonPair;                		
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

   		
   		$page = get_db()->fetchRow("SELECT * FROM `omeka_section_pages` where id = " . $pageId);
		
		//if(count($pages)==1){
			
   		error_log("PAGE = " . $page);
   		
			//$page = reset($pages);
			
			$title		= $page['title'];
			
			
			error_log("SET THE TITLE TO "  . $page->title);//   $page['title']);
			
			$section_id	= $page['section_id'];
			
			$section = get_db()->fetchRow("SELECT * FROM `omeka_sections` where id = " . $section_id);
			
			//if(count($sections)==1){
				
				//$section = reset($sections);
				
				
				$exhibitTable = get_db()->getTable('Exhibit');
				
				error_log("EXHIBIT ID = " .  $section['exhibit_id']  );
				
				$exhibit = $exhibitTable -> find(26);// $section['exhibit_id'] );
			
				
				
				error_log('E' .  count($exhibit)  );
				error_log('S' .  count($section)  );
				error_log('P' .  count($page)  );
				
				// $url = 
				exhibit_builder_exhibit_uri( $exhibit, $section, $page);
				
		//	}
			
			// exhibit_id
			
		//}

		
   	   		
   		$result =	'RESULT FOR ' . $pageId . '<br/>TITLE: ' . $title . '<br/>URL: ' . $url . '<br/>IMG_URL: ' . $imgUrl;
   		
        echo $result;
        
   	}

   	
}

