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

   		//error_log("Delete action (".    $eumap->tag  .")");

   		$eumap->delete();
   		
   		$this->redirect->gotoUrl('eumap');
  		
   	}

}

