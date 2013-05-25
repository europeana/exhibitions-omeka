<?php

class EUMapStoryPoint extends Omeka_Record
{
    public $id;

    public $hash;		/* url hash for auto-open */
    public $map_id;		/* parent */
    public $lat;		/* pos */
    public $lon;		/* pos */
    public $page_id;	/* object for popup to open */
}

