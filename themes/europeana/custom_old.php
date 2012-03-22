<?php 
// Use this file to define customized helper functions, filters or 'hacks' defined
// specifically for use in your Omeka theme. Note that helper functions that are
// designed for portability across themes should be grouped into a plugin whenever
// possible.

        add_filter(array('Display', 'Item', 'Dublin Core', 'Title'), 'show_untitled_items');


        function show_untitled_items($title)
        {
            // Remove all whitespace and formatting before checking to see if the title
            // is empty.
            $prepTitle = trim(strip_formatting($title));
            if (empty($prepTitle)) {
                return '[Untitled]';
            }
            return $title;
        }

/*
 * Helper function to display class object content
 *
 */
        function ws_object_values($oId) {
            foreach($oId as $key => $value) {
                echo "$key => $value<br/>";
            }

        }

        /**
         * Returns Breadcrumb navigation for Header navigation within the Exhibit
         * @return string
         */
        function ws_an_main_navigation(){
            $whereami = uri();
            $slugsArray = explode("/", $whereami);
            $length = count($slugsArray);
            $exhibit = $slugsArray[$length-2];
            $current = $slugsArray[$length-1];
            $location = $exhibit.'/'.$current;
            $html .= '<ul>';
            switch($location){
                case "art-nouveau/introduction":
                    $html .= '<li class="first">Introduction</li>';
                    break;
                case "art-nouveau/themes":
                    $html .= '<li class="first"><a href="' . uri('exhibits/show/art-nouveau/introduction') . '">Introduction</a></li>';
                    $html .= '<li>Themes</li>';
                    break;
                default:
                    if (!$section) {
                        if (!($section = exhibit_builder_get_current_section())) {
                            return;
                        }
                        if (!($page = exhibit_builder_get_current_page())) {
                            return;
                        }
                    }
                    $html .= '<li class="first"><a href="' . uri('exhibits/show/art-nouveau/introduction') . '">Introduction</a></li>';
                    $html .= '<li><a href="' . uri('exhibits/show/art-nouveau/themes') . '">Themes</a></li>';
                    $html .= '<li>'. $section->title . '</li>';
                    $html .= '<li>'. $page->title . '</li>';
            }
            $html .= '</ul>';


            return $html;
        }


        /**
         * Returns Exhibit Section Titles (Themes)
         * @param  $exhibitId
         * @return string
         *
         * TODO: Add Images for Themes
         */
        function ws_exhibit_builder_display_exhibit_themes($lang){

            switch($lang){
                case "en":
                    $id = 1;
                    $themeTitleImg = "theme_en.png";
                    break;
                case "lv":
                    $id = 3;
                    $themeTitleImg = "theme_lv.png";
                    break;
                case "nl":
                    $id = 4;
                    $themeTitleImg = "theme_nl.png";
                    break;
                case "fr":
                    $id = 5;
                    $themeTitleImg = "theme_fr.png";
                    break;
                case "pl":
                    $id = 6;
                    $themeTitleImg = "theme_pl.png";
                    break;
                default:
                    $id = 1;
                    $themeTitleImg = "theme_en.png";
            }
            $exhibit = exhibit_builder_get_exhibit_by_id($id);
            $html = '<div class="exhibit-themes-list ">';
            $counter = 0;
            foreach ($exhibit->Sections as $key => $section) {
                $themeTitle =  html_escape($section->title);
                $themeUri =   html_escape(exhibit_builder_exhibit_uri($exhibit, $section));

                $themeImgArray = array(
                    "an-themes-mastercrafts.png",
                    "an-themes-influences-and-inspirations.png",
                    "an-themes-world-of-new-interiors.png",
                    "an-themes-muses-and-mysticism.png",
                    "an-themes-in-print.png",
                    "an-themes-commerce-and-collectives.png",
                    "an-themes-architecture-and-cityscapes.png",
                    "an-themes-context.png"
                );

                if($counter==0){
                    $html .= '<h1 class="title"><img src="' . img($themeTitleImg) . '"/></h1>';
                    $html .=  '<div class="grid_6 alpha prefix_2 left">';
                }
                if($counter <= 3) {
                    $html .= '<div>';
                    $html .= '<a href="' . $themeUri .  '" title="' . $themeTitle . '">';
                    $html .= $themeTitle;
                    $html .= '<img src="' . img($themeImgArray[$counter]) . '" alt="' . $themeTitle . '">';
                    $html .= '</a>';
                    $html .= '</div>';
                    if($counter == 3) {
                        $html .= '</div>';
                        $html .= '<div class="grid_6 suffix_2 omega right">';
                    }
                } else {
                    $html .= '<div>';
                    $html .= '<a href="' . $themeUri .  '" title="' . $themeTitle . '">';
                    $html .= '<img src="' . img($themeImgArray[$counter]) .  '" alt="' . $themeTitle . '">';
                    $html .= $themeTitle;
                    $html .= '</a>';
                    $html .= '</div>';
                    if($counter==7){
                        $html .= '</div>';
                    }
                }
                $counter++;
            }
            $html .= '</div>';
            return $html;
        }

        function ws_exhibit_builder_exhibit_theme_link($themeName,$imgName,$orientation ){
            $output = "";

        }

        /**
         * Returns Exhibit Section Page Image Item Thumbnails
         * @param  $start
         * @param  $end
         * @param array $props
         * @param string $thumbnail_type
         * @return string
         */
        function ws_exhibit_builder_display_exhibit_thumbnail_gallery($start, $end, $props=array(), $thumbnail_type="square_thumbnail")
        {

            $output = '';
            for ($i=(int)$start; $i <= (int)$end; $i++) {
                if (exhibit_builder_use_exhibit_page_item($i)) {
                    $output .= '<div class="exhibit-item">';
                    $thumbnail = item_image($thumbnail_type, $props);
                    $output .= exhibit_builder_link_to_exhibit_item($thumbnail, $props);
                    $output .= '</div>';
                }
            }
            return $output;
        }

        function ws_exhibit_builder_add_hidden_lightbox_links($start, $end, $props=array(), $thumbnail_type="square_thumbnail")
        {
            $output = '';
            for ($i=(int)$start; $i <= (int)$end; $i++) {
                if (exhibit_builder_use_exhibit_page_item($i)) {
                    $item = get_current_item();
                    $uri = exhibit_builder_exhibit_item_uri($item);
                    //$output .= "'http://localhost/" . html_escape($uri) . "',\n";
                    $output .= item_uri();
                }
            }
            return $output;
        }

        /**
         * Returns Exhibit Section Page (story) Item metadata for items called in the ExhibitBuilder plugin
         * Writes hidden divs that are activated when the "i" link is clicked for the item in focus
         * @param  $start
         * @param  $end
         * @param array $props
         * @param $isExhibit: true or false - true used on SimplePages, false used in Exhibit layouts
         * @return array|string
         */

        function ws_exhibit_builder_exhibit_item_meta_data($start, $end, $props=array(), $isExhibit){

            for ($i=(int)$start; $i <= (int)$end; $i++) {
                if($isExhibit==true){
                    if (exhibit_builder_use_exhibit_page_item($i)) {
                        $output .= '<div class="exhibit-item-metadata" id="exhibit-item-metadata-'.$i.'">';
                        $output .= '<table cellpadding="0" cellpacing="0"><tr><td>';
                        $output .= '<img class="hidedata" src="' . img('icon-info.png') . '" alt="hide info"></td><td>';
                        $output .= '<div class="page-out">';
                        $output .= '<div class="item-metadata">';
                        $output .= show_item_metadata();
                        $output .= '</div></div></td></tr></table></div>';
                    }
                } else {
                        $output .= '<div class="exhibit-item-metadata" id="exhibit-item-metadata-'.$i.'">';
                        $output .= '<table cellpadding="0" cellpacing="0"><tr><td>';
                        $output .= '<img class="hidedata" src="' . img('icon-info.png') . '" alt="hide info"></td><td>';
                        $output .= '<div class="page-out">';
                        $output .= '<div class="item-metadata">';
                        $output .= show_item_metadata();
                        $output .= '</div></div></td></tr></table></div>';
                }
            }
            return $output;
        }

        /**
         * Returns Item metadata for items called from SimplePage plugin
         * Writes hidden divs that are activated when the "i" link is clicked for the item in focus
         * @param  $start
         * @param  $end
         * @param array $props
         * @return array|string
         */
        function ws_exhibit_item_metadata($start, $end, $props=array()){

            for ($i=(int)$start; $i <= (int)$end; $i++) {

                $output .= '<div class="exhibit-item-metadata" id="exhibit-item-metadata-'.$i.'">';
                $output .= '<div class="action"><img id="hidedata" src="' . img('icon-info.png') . '" alt="hide info"></div>';
                $output .= '<div class="page-out">';
                $output .= '<div class="item-metadata">';
                $output .= show_item_metadata();
                $output .= '</div></div></div>';

            }
            return $output;
        }


        /**
         * Returns a link to the item within the exhibit.
         *
         * @param string $text
         * @param array $props
         * @return string
         **/
        function ws_exhibit_builder_link_to_exhibit_item($text = null, $props=array('class' => 'exhibit-item-link'))
        {
            //if(exhibit_builder_use_exhibit_page_item(1)) {



            $item = get_current_item();
            $uri = exhibit_builder_exhibit_item_uri($item);
            $text = (!empty($text) ? $text : strip_formatting(item('Dublin Core', 'Title')));
            $icon = '<img src="' . img('icon-info.png') . '" alt="' . $text . '" />';
            return '<a href="' . html_escape($uri) . '" '. _tag_attributes($props) . '>' . $icon . '</a>';
//    }else{
//        return "something is wrong";
//    }
}

        /**
         * Returns the html code an exhibit item
         *
         * @param array $displayFilesOptions
         * @param array $linkProperties
         * @return string
         **/
        function ws_exhibit_builder_exhibit_display_item($displayFilesOptions = array(), $linkProperties = array())
        {
            $item = get_current_item();

            // Always just display the first file (may change this in future).
            $fileIndex = 0;
            $linkProperties['href'] = exhibit_builder_exhibit_item_uri($item);
            $html ='';
            // Don't link to the file b/c it overrides the link to the item.
            $displayFilesOptions['linkToFile'] = false;
            //$html .= '<div class="title"><p>'. item('Dublin Core', 'Title').'</p></div>';
            $html .= '<a ' . _tag_attributes($linkProperties) . '>';

            // Pass null as the 3rd arg so that it doesn't output the item-file div.
            $fileWrapperClass = null;
            $file = $item->Files[$fileIndex];
            $itemHtml = '';
            if ($file) {
                $itemHtml .= display_file($file, $displayFilesOptions, $fileWrapperClass);
            } else {
                $itemHtml = item('Dublin Core', 'Title');
            }

            $html .= $itemHtml;

            $html .= '</a>';
            $html .= '<div class="title"><p>'. item('Dublin Core', 'Title').'</p ></div>';
            return $html;
        }

        /**
         ***********************************************************************************************************************
         *
         *  EXHIBIT STORY NAVIGATION
         *  Navigation within an exhibit theme between the exhibit theme stories.
         *
         ***********************************************************************************************************************
         *
         *  Returns the HTML code of the exhibit page navigation
         *
         *  @return string
         *
         **/
        function ws_exhibit_builder_page_nav($section = null, $linkTextType='title')
        {
            $linkTextType = strtolower(trim($linkTextType));
            if (!$section) {
                if (!($section = exhibit_builder_get_current_section())) {
                    return;
                }
            }
            if ($section->hasPages()) {

                $html = '';
                foreach ($section->Pages as $page) {
                    switch($linkTextType) {
                        case 'order':
                            $linkText = $page->order;
                            break;
                        case 'title':
                        default:
                            $linkText = $page->title;
                            break;

                    }

                    if(exhibit_builder_is_current_page($page)){
                        $icon = '<img src="' . img('icon-page-current.png') . '" alt="' . $linkText . '" />';
                    } else {
                        $icon = '<img src="' . img('icon-page-default.png') . '" alt="' . $linkText . '" />';
                    }

                    $html .= '<a title="' . $linkText  . '" href="'. html_escape(exhibit_builder_exhibit_uri($section->Exhibit, $section, $page)) . '">';
                    $html .=  $icon .'</a>';
                }
                return $html;
            }
            return false;
        }

        /**
         * Returns a link to the next exhibit page
         *
         * @param string $text The label for the next page link
         * @param array $props
         * @return string
         **/
        function ws_exhibit_builder_link_to_next_exhibit_page($text="Next Page &rarr;", $props=array(), $page = null)
        {
            if (!$page) {
                $page = exhibit_builder_get_current_page();
            }
            $section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
            $exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
            $icon = '<img src="' . img('icon-page-next.png') . '" alt="' . $text . '" />';
            // if page object exists, grab link to next exhibit page if exists. If it doesn't, grab
            // a link to the first page on the next exhibit section, if it exists.
            if ($nextPage = $page->next()) {
                return ws_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title'=>$nextPage->title), $section, $nextPage);
            } elseif ($nextSection = $section->next()) {
                return ws_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title'=>$nextSection->title), $nextSection);
            }
        }

        /**
         * Returns a link to the previous exhibit page
         *
         * @param string $text The label for the previous page link
         * @param array $props
         * @return string
         **/
        function ws_exhibit_builder_link_to_previous_exhibit_page($text="&larr; Previous Page", $props=array(), $page = null)
        {
            if (!$page) {
                $page = exhibit_builder_get_current_page();
            }

            $section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
            $exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
            $icon = '<img src="' . img('icon-page-previous.png') . '" alt="' . $text . '" />';
            // if page object exists, grab link to previous exhibit page if exists. If it doesn't, grab
            // a link to the last page on the previous exhibit section, if it exists.
            if ($previousPage = $page->previous()) {
                return ws_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title'=>$previousPage->title), $section, $previousPage);
            }
            elseif ($previousSection = $section->previous()) {
                return ws_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title'=>$previousSection->title), $previousSection);
            }
        }

        function ws_exhibit_builder_link_to_exhibit($exhibit, $text=null, $props=array(), $section=null, $page = null)
        {
            $uri = exhibit_builder_exhibit_uri($exhibit, $section, $page);
            $text = !empty($text) ? $text : $exhibit->title;
            return '<div><a href="' . html_escape($uri) .'" '. _tag_attributes($props) . '>' . $text . '</a></div>';
        }

        function ws_get_introduction_text($lang){
            $linkText = "Start Exhibition";
            $linkURI = "themes";
            switch($lang){
                case "en":
                    $id = 1;
                    $linkText = "Start Exhibition";
                    break;
                case "lv":
                    $id = 3;
                    break;
                case "nl":
                    $id = 4;
                    $linkText = "Begin de Tentoonstelling";
                    break;
                case "fr":
                    $id = 5;
                    break;
                case "pl":
                    $id = 6;
                    break;
                default:
                    $id = 1;
            }

            $exhibit = exhibit_builder_get_exhibit_by_id($id);
            $output = "<p>" . $exhibit->description . "</p>";
            $output .= '<p><a href="'. $linkURI .'" class="page-next" title="'. $linkText .'">' . $linkText . '</a></p>';
            return $output;
        }

function ws_language_select(){

    $output = '';
    $output .=  '<select id="lang" name="lang" onchange="setLanguage(this.value);" id="langSelect">';
    $output .=  '<option value="en">English (eng)</option>';
    $output .=  '<option value="fr">Fran&#231;ais (fre)</option>';
    $output .=  '<option value="lv">Latvie&#353;u (lav)</option>';
    $output .=  '<option value="nl">Nederlands (dut)</option>';
    $output .=  '<option value="pl">Polski (pol)</option>';
    $output .=  '</select>';
    $output .=  '<script>$("select#lang").val("'. $_SESSION[$lang] .'");</script>';
    return $output;
}