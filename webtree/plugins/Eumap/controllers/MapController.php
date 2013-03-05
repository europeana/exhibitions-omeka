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
   	
   	
   	// /admin/eumap/map/data
   	
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
			  		$jsonPair = array('"' . $page -> title . '"', '"' . exhibit_builder_exhibit_uri($exhibit, $exhibitSection, $page) . '"');                		
					$jsonPairs[] = $jsonPair;                	                		
				}
			}
		}

        $jsonVals = array();
        foreach ($jsonPairs as $jsonPair) {
        	$jsonVals[] = implode(":", $jsonPair);
        }
        
        $result =  '{' . implode(",", $jsonVals) . '}';
        echo $result;
   	}

}

