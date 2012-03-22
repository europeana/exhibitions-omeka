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

            // Cycle through all the Exhibit sections and list them as Themes.
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
                            $html .= '<div class="exhibit-theme-container right">' . $linkOpen ;
                            $html .= '<div class="exhibit-theme-image">' . ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title ,$errors) . '</div>';
                            $html .= '<div class="exhibit-theme-image-overlay"></div>';
                            $html .= '<div class="exhibit-theme-title"><h4>' . html_escape($exhibitSection->title, $errors) . '</h4></div>';
                            $html .= $linkClose . '</div></div>';
                        }
                        else {
                            $html .= '<div class="grid_7 prefix_1 alpha" style="text-align: right">';
                            $html .= '<div class="exhibit-theme-container left">' . $linkOpen ;
                            $html .= '<div class="exhibit-theme-title"><h4>' . html_escape($exhibitSection->title) . '</h4></div>';
                            $html .= '<div class="exhibit-theme-image">' . ve_get_theme_thumbnail($exhibitSection->slug, $exhibitSection->title, $errors) . '</div>';
                            $html .= '<div class="exhibit-theme-image-overlay"></div>';
                            $html .= $linkClose . '</div></div>';
                        }

                    }
                        // Odd nr section
                    else {
                        // Display in a row
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
            ?>
        </div>
    </div>

    THEME LAYOUT>...all pages
    
    
    <?php
try {
	
	commenting_echo_comments();
	commenting_echo_comment_form();
	
} catch (Exception $e) {
    echo('Error: ' . $e->getMessage());
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

