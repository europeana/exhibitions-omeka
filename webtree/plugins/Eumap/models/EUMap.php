<?php

//require_once dirname(__FILE__) . 'EUMapStoryPoint.php';

class EUMap extends Omeka_Record
{
	
    public $id;
    public $tag;
    public $lat;
    public $lon;

    
    public function getStoryPoints() 
    {
        $db = $this->getDb();
        $sql = "SELECT s.* FROM $db->EuMapStoryPoint s WHERE s.map_id = ?";
        return $this->getTable('EuMapStoryPoint')->fetchObjects($sql, array((int) $this->id));
    }
    
}