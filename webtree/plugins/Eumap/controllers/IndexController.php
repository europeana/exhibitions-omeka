<?php

require_once 'EUMap.php';


class Eumap_IndexController extends Omeka_Controller_Action
{    
    
    public function init()
    {
    	$this->_modelClass = 'EUMap';
    }
    
    public function indexAction()
    {
        $mapTable = get_db()->getTable('EUMap');

        $eumaps = $mapTable->fetchObjects( $mapTable->getSelect() );

        $pluralName	= $this->getPluralized();
        $this->view->assign(array($pluralName		=> $pluralName, 
                                  'total_records'	=> $totalRecords,
                                  'eumaps'			=> $eumaps
        ));
        
   		
   	}
}
