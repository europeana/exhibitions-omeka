<?php
require_once 'Omeka/Plugin/Abstract.php';
require_once HELPERS;


class EUResponsivePlugin extends Omeka_Plugin_Abstract
{    
    protected $_hooks = array(
        //'admin_append_to_items_show_primary', 
        'after_save_item', 
        //'public_append_to_items_show',
        'config_form', 
		'config'
    );
    
    /*
    public function hookAdminAppendToItemsShowPrimary(){$this->append('ADMIN');}
    public function hookPublicAppendToItemsShow(){$this->append('PUBLIC');}
	*/
 
 	// set admin-defined breakpoint options
    public function hookConfig()
    {
    	$BREAKPOINTS = array();
    	$IMAGEWIDTHS = array();
    	//$ZOOMIT		 = 0;
    	
    	$i = 0;
    	while($_POST['breakpoint_' . $i] && is_numeric($_POST['breakpoint_' . $i])){
			$BREAKPOINTS[] =  $_POST['breakpoint_' . $i];
	    	$i += 1;
    	}

    	$i = 0;
    	while($_POST['imagewidth_' . $i] && is_numeric($_POST['imagewidth_' . $i])){
			$IMAGEWIDTHS[] =  $_POST['imagewidth_' . $i];
	    	$i += 1;
    	}
    	
    			
        set_option('euresponsive_breakpoints',	implode("~", $BREAKPOINTS) );
        set_option('euresponsive_imagewidths',	implode("~", $IMAGEWIDTHS) );
        
        $collections = get_collections();
   		for ($i = 0; $i < sizeof($collections); $i++) {
 			$items = get_items($collections[$i], 500);
			
			error_log ('Generate responsive images for collection: ' .  $collections[$i]['name'] . " (" . sizeof($items) . " items)");
 			for ($j = 0; $j < sizeof($items); $j++) {
    			$this->generateResponsiveImagesForItem($items[$j]); 			
			}
		}
    }
   
    public function hookConfigForm()
    {
        include 'config_form.php';
    }

	// Generate images according to breakpoint-imagewidths
	// TODO: simplify this using $file->archive_filename
    public function hookAfterSaveItem($item)
    {
    	$this->generateResponsiveImagesForItem($item);
    }
    
    protected static function generateResponsiveImagesForItem($item)
	{
		// commented out by dan entous 2012-04-12
		// error_log("");
		
		$IMAGEWIDTHS = explode("~", get_option('euresponsive_imagewidths'));
	  	$path = item_fullsize(null, 0, $item);
		$istart = substr($path, stripos($path, '"') + 1);
		$fname = substr($istart, 0, stripos($istart, '"') );
		$fullpath = realpath("../archive/fullsize/" . basename($fname));
		$euresponsiveDir = realpath("../archive/") . "/euresponsive";
		
		if(! file_exists ( $euresponsiveDir ) ){
			mkDir($euresponsiveDir);
		}

		$nameStem = pathinfo($fname);
		$nameStem = $nameStem['filename'];

		for ($i = 0; $i < sizeof($IMAGEWIDTHS); $i++) {
			
			if(strlen($nameStem)>0){
				$j = $i+1;
				$newFilePath = $euresponsiveDir . "/" . $nameStem . "_euresponsive_" . $j . ".jpg";
		        $command = join(' ', array(
	        	     self::_getPathToImageMagick(),
	        	     $fullpath,
	        	     '-resize ' . escapeshellarg($IMAGEWIDTHS[$i].'>'),
	        	     $newFilePath
	       		));
				exec($command, $result_array, $result_value);
				error_log("EURESPONSIVE - generated image " . $IMAGEWIDTHS[$i]);
			}
			
 	       
 	       //error_log("EXEC imagemagick: result_array=".$result_array.", result_value=".$result_value);
 	       //error_log("Created image WIDTH=".$IMAGEWIDTHS[$i]."  ---> ". $j .".jpg");
		}
    }



    /**
     * Retrieve the directory path to the ImageMagick 'convert' executable.
     * Based on application/libraries/File/Derivative/Image
     * @since 1.0 The 'path_to_convert' setting must be the directory containing
     * the ImageMagick executable, not the path to the executable itself.
     */
    protected static function _getPathToImageMagick()
    {
        $rawPath = get_option('path_to_convert');
        
        // Assert that this is both a valid path and a directory (cannot be a script).
        if (($cleanPath = realpath($rawPath)) && is_dir($cleanPath)) {
            $imPath = rtrim($cleanPath, DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR . Omeka_File_Derivative_Image::IMAGEMAGICK_COMMAND;
            return $imPath;
        } else {
            throw new Omeka_File_Derivative_Exception('ImageMagick is not properly configured: invalid directory given for the ImageMagick command!');
        }
    }



/*
    public function append($msg)
    {
?>

<script type="text/javascript">
  alert("plugin append, MSG IS <?php echo $msg?>" );
</script>

<div>
    <h2>HELLO ANDY - <?php echo $msg; ?></h2>
</div>

<?php
    } // end append
*/    
    
} // end class
