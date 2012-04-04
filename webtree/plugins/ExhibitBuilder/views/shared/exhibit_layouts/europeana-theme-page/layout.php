<?php

   error_log("ANDY: plugins/exhibitbuilder/views/shared/exhibit_layouts/layout.php");


$_SESSION['themes_uri'] = uri();
//$exhibit  = exhibit_builder_set_current_exhibit();
//$page = exhibit_builder_set_current_page();
//echo $page->title;
?>





<div class="text-full" style="width:100%;">
    <div class="primary" style="width:100%;">
        <div class="exhibit-text exhibit-theme-wrapper" style="width:100%;">

            <h2><?php echo ve_translate('themes', 'Themes');?></h2>
            
            <?php echo exhibit_builder_page_text(); ?>

            <!--style>
            	.andy{
            		position:	absolute;
              		max-width:	100%;
            	}

            	.themes-right{				/* margin works with overlays!  */
            		margin-left:3px;	
            	}
            	
            	.themes-left, .themes-right{
            		max-width:30%;					/* simulate restricted real estate */
            	}
            	
            	/* further rules for scaling the images...... */
            	
            	.theme-center-inner, .theme-center-inner a img{
            		max-width:	100%;
            	}
            	
            </style-->
            
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
            
            $themesRight	= '';
            $themesLeft		= '';
            
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

            				
            				/*
            				$themesRight .= '<div class="theme-item">';
            				$themesRight .= 	'<div class="theme-image">';
            				$themesRight .=			'<div class="theme-center-outer">';
            				$themesRight .=				'<div class="theme-center-middle">';
            				$themesRight .=					'<div class="theme-center-inner">';
            				$themesRight .=						'<a href="'.$themeLink2.'">';

            				
            				$themesRight .=     					ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors); // force some space
            				$themesRight .=						'<div class="andy" style="z-index:2; top:0px;">';
            				$themesRight .=							'<img src="http://127.0.0.1/ombad/webtree/themes/judaica/images/circle-overlay-100.png" />';
            				$themesRight .=						'</div>';
            				
            				
            				
            				$themesRight .=						'</a>';
            				$themesRight .=					'</div>';
            				$themesRight .=				'</div>';
            				$themesRight .=			'</div>';
            				$themesRight .=     '</div>';
            				$themesRight .=		'<div class="theme-title">';
            				$themesRight .=			'<a href="'.$themeLink2.'">';
            				$themesRight .=				'<h4>'. html_escape($exhibitSection->title, $errors) .'</h4>';
            				$themesRight .=			'</a>';
            				$themesRight .=		'</div>';
            				$themesRight .=	'</div>';
            				*/
            				
            				// collapsed rows right
            				
            				$themesRight .= '<div class="theme-item">';
            				$themesRight .= 	'<div class="theme-image">';            				
            				$themesRight .=			'<div class="theme-center-outer">';
            				$themesRight .=				'<div class="theme-center-middle">';
            				$themesRight .=					'<div class="theme-center-inner">';
            				$themesRight .=						'<a href="'.$themeLink2.'">';
            				$themesRight .=     					ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors);
            				$themesRight .=							'<div class="theme-img-overlay"></div>';
            				$themesRight .=						'</a>';
            				$themesRight .=					'</div>';
            				$themesRight .=				'</div>';
            				$themesRight .=			'</div>';
            				$themesRight .=     '</div>';
            				$themesRight .=		'<div class="theme-title">';
            				$themesRight .=			'<a href="'.$themeLink2.'">';
            				$themesRight .=				'<h4>'. html_escape($exhibitSection->title, $errors) .'</h4>';
            				$themesRight .=			'</a>';
            				$themesRight .=		'</div>';
            				$themesRight .=	'</div>';

            			}
            			else {
            				$themeTitle1	= html_escape($exhibitSection->title, $errors);
            				$themeImage1	= ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors);
            				$themeLink1		= html_escape(exhibit_builder_exhibit_uri($exhibit, $exhibitSection));
            				
            				// collapsed rows left
            				$themesLeft .=	'<div class="theme-item">';
            				$themesLeft .=		'<div class="theme-image">';
            				$themesLeft .=			'<div class="theme-center-outer">';
            				$themesLeft .=				'<div class="theme-center-middle">';
            				$themesLeft .=					'<div class="theme-center-inner">';
            				$themesLeft .=						'<a href="'.$themeLink1.'">';
            				$themesLeft .=     						ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors);
            				$themesLeft .=							'<div class="theme-img-overlay"></div>';
            				$themesLeft .=						'</a>';
            				$themesLeft .=					'</div>';
            				$themesLeft .=				'</div>';
            				$themesLeft .=			'</div>';
 	          				$themesLeft .=		'</div>';
            				$themesLeft .=		'<div class="theme-title">';
            				$themesLeft .=			'<a href="'.$themeLink1.'">';
            				$themesLeft .=				'<h4>'. html_escape($exhibitSection->title, $errors) .'</h4>';
            				$themesLeft .=			'</a>';
            				$themesLeft .=		'</div>';
            				$themesLeft .=	'</div>';
            			}
            		}
            		// Odd nr section
            		else {
            			// Display in a row
            			echo '<h1 style="font-size:26px;">ODD NUMBER SECTION....</h1>';
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
            		
					// expanded rows
					            		
            		$rowHTML = '';
            		$rowHTML .= '<div class="row theme-title-row-expanded">';
            		$rowHTML .= 	'<div class="six columns right-text">';
            		$rowHTML .= 		'<div class="theme-item-wrapper right-text">';
            		$rowHTML .= 			'<a href="'.$themeLink1.'">';
            		$rowHTML .= 				'<h4>'.$themeTitle1.'</h4>';
            		$rowHTML .= 			'</a>';
            		$rowHTML .= 		'</div>';
            		
            		$rowHTML .= 		'<div class="theme-item-wrapper right-text">';
            		$rowHTML .= 			'<a href="'.$themeLink1.'">';
            		$rowHTML .= 				$themeImage1;
            		$rowHTML .= 				'<div class="theme-img-overlay"></div>';
            		$rowHTML .= 			'</a>';
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 	'</div>';
            		
            		$rowHTML .= 	'<div class="six columns left-text">';
            		$rowHTML .= 		'<div class="theme-item-wrapper left-text">';
            		$rowHTML .= 			'<a href="'.$themeLink2.'">';
            		$rowHTML .= 				$themeImage2;
            		$rowHTML .= 				'<div class="theme-img-overlay"></div>';
            		$rowHTML .= 			'</a>';
            		$rowHTML .= 		'</div>';
            		
            		$rowHTML .= 		'<div class="theme-item-wrapper left-text">';
            		$rowHTML .= 			'<a href="'.$themeLink2.'">';
            		$rowHTML .= 				'<h4>'.$themeTitle2.'</h4>';
            		$rowHTML .= 			'</a>';
            		$rowHTML .= 		'</div>';
            		$rowHTML .= 	'</div>';
            		$rowHTML .= '</div>';
            		
            		$themeHTML .= $rowHTML;
            	}
            }
            
            
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
            echo '<div class="row">';
            echo 	'<div class="twelve columns">';
            echo 		$themeHTML;
            echo 		'<div class="theme-centre-outer theme-title-row-collapsed">';
            echo 			'<div class="theme-center-middle">';
            echo 				'<div class="theme-center-inner">';
            echo 					'<div class="themes-left">';
            echo 						$themesLeft;
            echo 					'</div>';
            echo 					'<div class="themes-right">';
            echo 						$themesRight;
            echo 					'</div>';
            echo 				'</div>';
            echo 			'</div>';
            echo 		'</div>';
            echo 	'</div>';
            echo '</div>';
            
            ?>
    



<div class="row">
	<div id="mobile_shares" class="twelve columns">

		<div class="theme-center-outer">
			<div class="theme-center-middle">
    	    	<div class="theme-center-inner">
	
					<?php echo getAddThisMobile(); ?>
					<!-- COPIED FROM PORTAL MOBILE -->
					<!--The following snippet is needed to nake the google icon appear (but doesn't work)-->
					<!-- 
					<script type="text/javascript" src="http://apis.google.com/js/plusone.js">
					  {lang: 'en'}
					</script>
					<div id="wrapper" class="addthis addthis_32x32_style addthis_default_style">
						<a	class="addthis_button_facebook"
							href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4b4f08de468caf36"></a>
							    
						<a	class="addthis_button_twitter"
							href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4b4f08de468caf36"></a>
					
						<a	class="addthis_button_compact"
							href="http://www.addthis.com/bookmark.php?v=250&amp;username=xa-4b4f08de468caf36"></a>
					</div>
				
						
					<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=xa-4b4f08de468caf36"></script>
					<script type="text/javascript">
					    //ui_language: "${model.locale}",
					    //alert("${model.locale}");
					    var addthis_config = {
					        ui_language: "nl",
					        ui_click: true
					    }
					</script>
					-->
					<!-- END COPY FROM PORTAL MOBILE -->
				</div>
			</div>
		</div>
		
	</div> <!-- leave row open for foter to close -->



    <?php
try {
	
//	commenting_echo_comments();
//	commenting_echo_comment_form();
	
} catch (Exception $e) {
 //   echo('Error: ' . $e->getMessage());
}		
?>
    


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

