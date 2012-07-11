<?php


class Tracking_TestController extends Omeka_Controller_Action
{
    public function init()
    {
    }
    

    // http://localhost/ombad/webtree/service/test/8
   	public function indexAction()
   	{
   		queue_js('jquery.oembed.1.1.0/jquery.oembed.min');
   		echo "oembed test index!";
	}

}