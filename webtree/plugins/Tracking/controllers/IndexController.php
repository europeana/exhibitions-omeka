<?php

require_once 'Embed.php';

class Tracking_IndexController extends Omeka_Controller_Action
{    
    
    public function init()
    {
    	$this->_modelClass = 'Embed';
    }
    
    public function indexAction()
    {
    	$this->_modelClass = 'Embed';
    	
        if (empty($this->_modelClass)) {
            throw new Exception( 'Scaffolding class has not been specified' );
        }
        
        $pluralName	= $this->getPluralized();
        $params		= $this->_getAllParams();
        
        $recordsPerPage	= $this->_getBrowseRecordsPerPage();
        $currentPage	= $this->_getBrowseRecordsPage();
        
        $table = $this->getTable($this->_modelClass);
        
        
        $embedsTable = get_db()->getTable('Embed');
        $periods = $embedsTable->fetchObjects("SELECT distinct(period) FROM omeka_embeds order by period desc;");

        
        
        if($params['period']){        	
        	$records = $this->getTable('Embed')->findBySql('period = ?', array( $params['period'] ) );
        }
        else{
        	reset($periods);
        	$records = $this->getTable('Embed')->findBySql('period = ?', array( current($periods)->period ) );
        	reset($periods);
        }
        
        $totalRecords = $table->count($params);
        
        Zend_Registry::set($pluralName, $records);
        
        // Fire the plugin hook
        fire_plugin_hook('browse_' . strtolower(ucwords($pluralName)),  $records);
        
        // If we are using the pagination, we'll need to set some info in the
        // registry.
        if ($recordsPerPage) {
            $pagination = array('page'          => $currentPage, 
                                'per_page'      => $recordsPerPage, 
                                'total_results' => $totalRecords);
            Zend_Registry::set('pagination', $pagination);
        }

        $this->view->assign(array($pluralName		=> $records, 
                                  'total_records'	=> $totalRecords,
                                  periods			=> $periods
        ));
    }

}