<?php

   error_log("ANDY: plugins/exhibitbuilder/views/shared/exhibit_layouts/layout.php");


$_SESSION['themes_uri'] = uri();
//$exhibit  = exhibit_builder_set_current_exhibit();
//$page = exhibit_builder_set_current_page();
//echo $page->title;
?>

<div class="text-full">
    <div class="primary">
        <div class="exhibit-text exhibit-theme-wrapper">

        
<style>
#container {
	background-color:orange;
	height:200px;
    display: table;
    width: 100%;
}
    
.middle {
    display: inline-block;
    vertical-align: middle;
}

.left-text {
	text-align:left;
}
.right-text {
	text-align:right;
}
.center-text {
	text-align:center;
}




</style>

        
        <br style="clear:both;">

        <!-- 
        <div class="container">
			<div class="row theme-title-row-expanded">
			
				<div class="six columns right-text">
					<div class="middle right-text">
						item one expanded blah blah
					</div>
					<div class="middle right-text">
	        			<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/mastercraft_intro_11e5245b91.jpg"/>
	        			<div class="theme-img-overlay"></div>
        			</div>
       			</div>
				<div class="six columns left-text">
				
					<div class="middle left-text">
						<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/ip_intro_9debd21edb.jpg"/>
	        			<div class="theme-img-overlay"></div>
						</div>
        			<div class="middle left-text">
						item 2 expanded
					</div>
				</div>

			</div>
        
	        <div class="row  theme-title-row-collapsed">
		        <div class="twelve columns center-text">
        			<div class="middle">
	        			<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/mastercraft_intro_11e5245b91.jpg"/>
	        			<div class="theme-img-overlay"></div>
        			</div>  
        			<div class="middle">
	        			<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/ip_intro_9debd21edb.jpg"/>
	        			<div class="theme-img-overlay"></div>
	              	</div> 
        		</div>
       		</div>
	        <div class="row  theme-title-row-collapsed">
		    	<div class="twelve columns center-text">
	        		<div  class="middle">
		            	item one in collapsed		       
		            </div>  
	        		<div  class="middle">
		            	item two in collapsed		       
		            </div> 
	        	</div>
	        </div>
	        
	        
	        
   			<div class="row theme-title-row-expanded">
			
				<div class="six columns" style="background-color:red; text-align:right;">
					<div class="middle" style="text-align:right;">
						item one expanded blah blah
					</div>
					<div class="middle" style="text-align:right;">
	        			<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/mastercraft_intro_11e5245b91.jpg"/>
	        			<div class="theme-img-overlay"></div>
	        			
        			</div>
       			</div>
				<div class="six columns" style="background-color:red; text-align:left;">
				
					<div class="middle" style="text-align:left;">
						<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/ip_intro_9debd21edb.jpg"/>
						<div class="theme-img-overlay"></div>
					</div>
        			<div class="middle" style="text-align:left;">
						item 2 expanded
					</div>
				</div>

			</div>
        
	        <div class="row  theme-title-row-collapsed">
		        <div class="twelve columns" style="background-color:red;  text-align:center;">
        			<div class="middle">
	        			<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/mastercraft_intro_11e5245b91.jpg"/>
	        			<div class="theme-img-overlay"></div>
        			</div>  
        			<div class="middle">
	        			<img src="http://127.0.0.1/ombad/webtree/archive/square_thumbnails/ip_intro_9debd21edb.jpg"/>
	        			<div class="theme-img-overlay"></div>
	              	</div> 
        		</div>
       		</div>
	        <div class="row  theme-title-row-collapsed">
		    	<div class="twelve columns" zzstyle="background-color:red; width:100%; text-align:center;">
	        		<div  class="middle">
		            	item one in collapsed		       
		            </div>  
	        		<div  class="middle">
		            	item two in collapsed		       
		            </div> 
	        	</div>
	        </div>
        </div>
        
        <br>
        <br>
        <br>
        <br>
        <br>
        
         -->
        
 

            <h2><?php echo ve_translate('themes', 'Themes');?></h2>

            <?php echo exhibit_builder_page_text(); ?>

            <?php
         /**
         * Get the current exhibit and find the first section.
         * The first section would be the 'theme' page.
         */
            if (!$exhibit) {
                if (!($exhibit = exhibit_builder_get_current_exhibit())) {
                    return;
                }
            }

            
          
            
            $key = 0;
            $errors = array();
            // Check the number of sections -1 (the theme section where we are)
            $nrSections = sizeof($exhibit->Sections) - 1;
            
            
            $themeTitle1	= '';
            $themeTitle2	= '';
            $themeImage1	= '';
            $themeImage2	= '';
            $themeLink1		= '';
            $themeLink2		= '';
            $rowCount		= 0;
            $themeHTML		= '';
            
            // Cycle through all the Exhibit sections and list them as Themes.
            foreach ($exhibit->Sections as $key => $exhibitSection) {
            	
            	// skip the first one because this is the exhibit section (themes) we are currently on
            	if ($exhibitSection->hasPages() && ($exhibitSection->order > 1)) {
            	
            	
            		// Even nr sections
            		if (!($nrSections & 1)) {
            			$colClass = '';
            	
            			if($key%2==1){
            				$themeTitle2	= html_escape($exhibitSection->title, $errors);
            				$themeImage2	= ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors);
            				$themeLink2		= html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection));
            			}
            			else {
            				$themeTitle1	= html_escape($exhibitSection->title, $errors);
            				$themeImage1	= ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors);
            				$themeLink1		= html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection));
            			}
            		}
            		// Odd nr section
            		else {
            			// Display in a row
            			//$html .= '<h1>ANDY: TODO<h1>';
            			//$html .= '<div class="exhibit-theme-container" style="margin: 1em;">';
            			//$html .= $linkOpen . '<div class="exhibit-theme-image">' .  ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title, $errors) . '</div>';
            			//$html .= '<div class="exhibit-theme-image-overlay" id="overlay-'.$exhibitSection->slug.'"></div>';
            			//$html .= '<div class="exhibit-theme-title"><h4>' . html_escape($exhibitSection->title) . '</h4></div>' . $linkClose;;
            			//$html .= '</div>';
            		}
            	}  

            	
            	// output here
            	$rowCount = $rowCount +1;
            	if($rowCount > 0 && $rowCount%2==1){
            		//echo 'output double rows here ('.$rowCount.')<br style="clear:both;"/>';
            		//echo '>>'.$themeImage1.'<<';
            		//echo '>>'.$themeImage2.'<<';
            		//echo '<br/>';
            		
            		
					// expanded rows
					            		
            		$rowHTML = '';
            		$rowHTML .= '<div class="row theme-title-row-expanded">';
            		$rowHTML .= 	'<div class="six columns right-text">';
            		$rowHTML .= 		'<div class="middle right-text">';
            		$rowHTML .= 			$themeTitle1;
            		$rowHTML .= 		'</div>';
            		
            		$rowHTML .= 		'<div class="middle right-text">';
            		$rowHTML .= 			$themeImage1;
            		$rowHTML .= 			'<div class="theme-img-overlay"></div>';
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 	'</div>';
            		
            		$rowHTML .= 	'<div class="six columns left-text">';
            		$rowHTML .= 		'<div class="middle left-text">';
            		$rowHTML .= 			$themeImage2;
            		$rowHTML .= 			'<div class="theme-img-overlay"></div>';
            		$rowHTML .= 		'</div>';
            		
            		$rowHTML .= 		'<div class="middle left-text">';
            		$rowHTML .= 			$themeTitle2;
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 	'</div>';
            		$rowHTML .= '</div>';
            		
            		// collapsed rows
  
            		$rowHTML .= '<div class="row  theme-title-row-collapsed">';
            		$rowHTML .= 	'<div class="twelve columns center-text">';
            		$rowHTML .= 		'<div class="middle">';
            		$rowHTML .= 			$themeImage1;
            		$rowHTML .= 			'<div class="theme-img-overlay"></div>';
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 		'<div class="middle">';
            		$rowHTML .= 			$themeImage2;
            		$rowHTML .= 			'<div class="theme-img-overlay"></div>';
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 	'</div>';
            		$rowHTML .= '</div>';
            		$rowHTML .= '<div class="row  theme-title-row-collapsed">';
            		$rowHTML .= 	'<div class="twelve columns">';
            		$rowHTML .= 		'<div class="middle">';
            		$rowHTML .= 			$themeTitle1;
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 		'<div class="middle">';
            		$rowHTML .= 			$themeTitle2;
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 	'</div>';
            		$rowHTML .= '</div>';
            		

            		$themeHTML .= $rowHTML;
            	}
            }
            
            echo '<div class="container">';
            echo 	$themeHTML;
            echo '</div>';
            

            
            
            // Cycle through all the Exhibit sections and list them as Themes.
            /*
            foreach ($exhibit->Sections as $key => $exhibitSection) {

                $html = '';
                
                // skip the first one because this is the exhibit section (themes) we are currently on
                if ($exhibitSection->hasPages() && ($exhibitSection->order > 1)) {

                    $linkOpen = '<a class="exhibit-section-title" href="' . html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection)) . '">';
                    $linkClose = '</a>';

                    // Even nr sections
                    if (!($nrSections & 1)) {
                        // Display in two collumns
                        $colClass = '';

                        
                        
                        if($key%2==1){
                            $html .= '<div class="grid_7 suffix_1 omega" style="text-align: left;">';
                            $html .= 	'<div class="exhibit-theme-container right">' . $linkOpen ;
                            $html .= 		'<div class="exhibit-theme-image">' . ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors) . '</div>';
                            $html .= 		'<div class="exhibit-theme-image-overlay"></div>';
                            $html .= 		'<div class="exhibit-theme-title"><h4>' . html_escape($exhibitSection->title, $errors) . '</h4></div>';
                            $html .= 		$linkClose;
                            $html .= 	'</div>';
                            $html .= '</div>';
                        }
                        else {
                            $html .= '<div class="grid_7 prefix_1 alpha" style="text-align: right">';
                            $html .= 	'<div class="exhibit-theme-container left">' . $linkOpen ;
                            $html .= 		'<div class="exhibit-theme-title"><h4>' . html_escape($exhibitSection->title) . '</h4></div>';
                            $html .= 		'<div class="exhibit-theme-image">' . ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title, $errors) . '</div>';
                            $html .= 		'<div class="exhibit-theme-image-overlay"></div>';
                            $html .= 		$linkClose;
                            $html .=  	'</div>';
                            $html .= '</div>';
                        }

                    }
                        // Odd nr section
                    else {
                        // Display in a row
                        $html .= '<h1>ANDY: TODO<h1>';
                        $html .= '<div class="exhibit-theme-container" style="margin: 1em;">';
                        $html .= $linkOpen . '<div class="exhibit-theme-image">' .  ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title, $errors) . '</div>';
                        $html .= '<div class="exhibit-theme-image-overlay" id="overlay-'.$exhibitSection->slug.'"></div>';
                        $html .= '<div class="exhibit-theme-title"><h4>' . html_escape($exhibitSection->title) . '</h4></div>' . $linkClose;;
                        $html .= '</div>';

                    }
                    echo $html;
                }
            }

            if(count($errors) > 0){

                foreach($errors as $error) {
                    echo '<div>' .$error . '</div>';
                }
            }
            */
            ?>
        </div>
    </div>
    
    
    <?php
try {
	
//	commenting_echo_comments();
//	commenting_echo_comment_form();
	
} catch (Exception $e) {
 //   echo('Error: ' . $e->getMessage());
}

		
?>
    
</div>


<?php
function ve_get_theme_thumbnail($slug, $eTitle, $errors)
{
    $html = '';
    set_items_for_loop(get_items(array('tags' => $slug . '-theme')));

    if (has_items_for_loop()) {

        while (loop_items()) {
            if (item_square_thumbnail()) {
                $html .= item_square_thumbnail();
            }
        }
        return $html;
    }
    else {
        if(get_theme_option('display_admin_errors')){
         $errors[] = '<div class="error">There is no item file (image) associated with the Exhibit Section: <strong>' . $eTitle . '</strong>.<br/>'
                  . 'Tag an image used in this exhibit section with: <strong><em>' . $slug . '-theme</em></strong></div>';
        }

    }

}

?>

