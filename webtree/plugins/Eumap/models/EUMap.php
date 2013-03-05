<?php

class EUMap extends Omeka_Record
{
    public $id;
    public $tag;
    public $img;
    public $nw_lat;
    public $nw_lon;
    public $se_lat;
    public $se_lon;

    
    public function getStoryPoints() 
    {
        $db = $this->getDb();
        $sql = "SELECT s.* FROM $db->EuMapStoryPoint s WHERE s.map_id = ?";
        return $this->getTable('EuMapStoryPoint')->fetchObjects($sql, array((int) $this->id));
    }
    
}