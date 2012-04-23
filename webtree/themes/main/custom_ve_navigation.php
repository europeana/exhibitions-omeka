<?php
/**
 * Created by Eric van der Meulen, Delving B.V. http:www.delving.eu
 * Date: 5/23/2011
 * Time: 17:41 PM
 */

/**
 * Returns Breadcrumb navigation
 * @return html string
 */
		
/*
 * PAGE			USES
 * info			3 & 7
 * themes		3 & 6
 * item			numeric
 * summary		3 & 4
 * browse		3
 * 
*/
function ve_exhibit_breadcrumbs($pageId = null, $exhibit = null, $section = null, $showAsTitle=null)
{
    $current = ve_get_current_page_name();

    $navCrumbs = array();
    $titleCrumbs = array();
    $html = '';
    global $titleCrumbs;

    // We are home
    if (preg_match("/^index/", $current) || $current == "") {

//error_log("ONE");    	
        unset($_SESSION['collection']);
        unset($_SESSION['themes_uri']);
        $navCrumbs[] = $titleCrumbs[] = ve_translate("virtual-exhibitions", "Virtual Exhibitions");
    }
    elseif ($current == 'contact') {
    	
//error_log("TWO");    	
    	
        $navCrumbs[] = '<a href="' . WEB_ROOT . '">' . ve_translate("virtual-exhibitions", "Virtual Exhibitions") . '</a>';
        $titleCrumbs[] =  ve_translate("virtual-exhibitions", "Virtual Exhibitions");
        $navCrumbs[] = $titleCrumbs[] = ve_translate('contact-us-title', 'Contact Us');
    }
        // We are not home
    else {

//error_log("THREE");    	

        // We are on the browse exhibit page
        if ($current == 'browse' && isset($_GET['tags']) && !isset($_GET['theme'])) {

//error_log("FOUR");    	

            $navCrumbs[] = '<a href="' . WEB_ROOT . '">' . ve_translate("virtual-exhibitions", "Virtual Exhibitions") . '</a>';
            $titleCrumbs[] =  ve_translate("virtual-exhibitions", "Virtual Exhibitions");
            
            
            if(isset($_SESSION["collection"])){
                $navCrumbs[] = $titleCrumbs[] = $_SESSION["collection"];
            }
            else {
                $navCrumbs[] = $titleCrumbs[] = ve_translate("exhibits-browse", "Browse Exhibits");
            }
        }

        else {
        	
//error_log("FIVE");

            // We are in an exhbit
            if ($exhibit === null) {

//error_log("SIX");

                $exhibit = exhibit_builder_get_current_exhibit();
                $section = exhibit_builder_get_current_section();
                $sectionSlug=$section->slug;
                $findme  = 'theme';
                $iamtheme = strpos($sectionSlug, $findme);

                $navCrumbs[] = '<a href="' . WEB_ROOT . '">' . ve_translate("virtual-exhibitions", "Virtual Exhibitions") . '</a>';
                

                $titleCrumbs [] = ve_translate("virtual-exhibitions", "Virtual Exhibitions");
                
                
                // Remove wiki/mimo/dismark etc.
                //$titleCrumbs[] = $_SESSION["collection"];

                
                // Exhibit Summary Page
                if ($exhibit->title && !$section->title) {
                	
//error_log("SEVEN");

                    $navCrumbs[] = $titleCrumbs[] = $exhibit->title;
                }
                // Exhibit Start
                if ($exhibit->title && $section->title && $iamtheme==true) {

//error_log("EIGHT");

                    $navCrumbs[] = '<a href="' . WEB_ROOT . '/exhibits/show/' . $exhibit->slug . '">' . $exhibit->title . '</a>';

                    $titleCrumbs[] = $exhibit->title;
                    // not on themes page
                    if($iamtheme==false){
                    	
//error_log("NINE");

                        $navCrumbs[] = $titleCrumbs[] = $section->title;
                    }
                    // on themes page
                    else {
                    	
//error_log("TEN");

                        $navCrumbs[] =  $titleCrumbs[] = ve_translate('themes', 'Themes');
                    }

                }
                
//error_log("WEDDINGS_DIF: exhibittitle= " .($exhibit->title). " sectiontitle=".$section->title. " iamthemfalse=".($iamtheme==false). " issetThemesUri=" . isset($_SESSION['themes_uri'])   );
                
                
                 if ($exhibit->title && $section->title && $iamtheme==false && isset($_SESSION['themes_uri'])) {

//error_log("ELEVEN");

                	 // start original code
                	 /*
                     $navCrumbs[] = '<a href="' . WEB_ROOT . '/exhibits/show/' . $exhibit->slug . '">' . $exhibit->title . " iamtheme:". $iamtheme  . '</a>';

                     $navCrumbs[] = '<a href="' . $_SESSION['themes_uri']  . '">' . ve_translate('themes', 'Themes')."5" . '</a>';  // used in mimo story intro & page 

                     $titleCrumbs[] = $exhibit->title ."(1.5)";
                     
                     $titleCrumbs[] = ve_translate('themes', 'Themes') ."(2)";
                     
                     
                     $navCrumbs[] = $titleCrumbs[] = $section->title ."(3)-sec";
					*/
                	 // end original code
                	 
                	 // start mimo/connect fix code
                	 if($section->title == 'Themes'){

//error_log("TWELVE");
                         $navCrumbs[] = '<a href="' . WEB_ROOT . '/exhibits/show/' . $exhibit->slug . '">' . $exhibit->title . '</a>';
                         $titleCrumbs[] = $exhibit->title;
                         $navCrumbs[] = $titleCrumbs[] = $section->title;
                		 
                	 }
                	 else{

//error_log("THIRTEEN (themes_uri = ".($_SESSION['themes_uri']).")");


                         $navCrumbs[] = '<a href="' . WEB_ROOT . '/exhibits/show/' . $exhibit->slug . '">' . $exhibit->title . '</a>';
                         $navCrumbs[] = '<a href="' . $_SESSION['themes_uri']  . '">' . ve_translate('themes', 'Themes') . '</a>';  // used in mimo story intro & page
                         $titleCrumbs[] = $exhibit->title;
                         
                         $titleCrumbs[] = ve_translate('themes', 'Themes');
                         $navCrumbs[] = $titleCrumbs[] = $section->title;
                		 
                	 }
                	 // end mimo/connect fix code

                 }
                 else{
                	 if($exhibit->title && count($navCrumbs) == 1 && !$iamtheme && $section->title ){

//error_log("FOURTEEN");
	
						$titleCrumbs[] =  $exhibit->title;

                         $navCrumbs[] = '<a href="' . WEB_ROOT . '/exhibits/show/' . $exhibit->slug . '">' . $exhibit->title . '</a>';
                         $navCrumbs[] =  $titleCrumbs[] = ve_translate('themes', 'Themes');
                	 }
                 }

            }
        }
        // Item page
        try {
            // Only do this on an item pages who's uri is numeric
            if (preg_match("/^[0-9]/", ve_get_current_page_name())) {
            	
//error_log("FIFTEEN");

                $item = get_current_item();
                $title = item('Dublin Core', 'Title') ? item('Dublin Core', 'Title') : '';
                $creator = item('Dublin Core', 'Creator') ? ' by ' . item('Dublin Core', 'Creator') : '';
                
                $titleCrumbs[] = $title . strip_tags($creator);

            }
        }
        catch (Exception $e) {
            //do nothing
        }

    }
    if(!isset($showAsTitle)){

        $html .= implode(html_escape(" > "), $navCrumbs);
    }
    elseif($showAsTitle=true) {
        $html .= implode(html_escape(" | "), array_reverse($titleCrumbs));
    }
    return $html;
}

function ve_show_title_crumbs(){
      global $titleCrumbs;
     $html = $titleCrumbs;
    return $html;

}

/*
 * Used to return to the exhibit when having navigated to a page (like credits, or browse items) that falls outside of the
 * internal exhibits navigational structure
 */
function ve_return_to_exhbit($querystring = null)
{
    $returnTo = $_COOKIE['ve_return_to'];
    $html = '';
    if ($returnTo) {
        $html .= '<a class="widget" href="' . $returnTo . $querystring . '"><img class="arrow-left" src="' . img('arrow-left.png'). '"/>' . ve_translate('return-to-exhibit', 'Return to Exhibit') . '</a>';
    }
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
 * @return string
 *
 **/
function ve_exhibit_builder_page_nav($section = null, $linkTextType = 'title')
{
    $linkTextType = strtolower(trim($linkTextType));
    if (!$section) {
        if (!($section = exhibit_builder_get_current_section())) {
            return;
        }
    }
    if ($section->hasPages()) {

        $html = '';
        $counter = 1;
        foreach ($section->Pages as $page) {

            switch ($linkTextType) {
                case 'order':
                    $linkText = $page->order;
                    break;
                default:
                    $linkText = $page->title;
                    break;

            }
            //            $html .= '<a title="' . $linkText . '" href="' . html_escape(exhibit_builder_exhibit_uri($section->Exhibit, $section, $page)) . '" ' . (exhibit_builder_is_current_page($page) ? ' class="current"' : '') . '>';
            //            $html .= $counter . '</a>';
            //            $counter++;
            if (exhibit_builder_is_current_page($page)) {
                $icon = '<img src="' . img('nav-page-current.png') . '" alt="' . $linkText . '" />';
                $class = "current";
            } else {
                $icon = '<img src="' . img('nav-page-default.png') . '" alt="' . $linkText . '" />';
                $class = "";
            }
            //
            $html .= '<a title="' . $linkText . '" class="' . $class . '" href="' . html_escape(exhibit_builder_exhibit_uri($section->Exhibit, $section, $page)) . '">';
            $html .= $icon . '</a>';


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
function ve_exhibit_builder_link_to_next_exhibit_page($text = "Next Page", $props = array(), $page = null)
{
    if (!$page) {
        $page = exhibit_builder_get_current_page();
    }
    $section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
    $exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
    $icon = '<img src="' . img('nav-page-next.png') . '" alt="' . $text . '" />';
    // if page object exists, grab link to next exhibit page. If it doesn't, grab
    // a link to the first page on the next exhibit section, if it exists.
    $next = ve_translate("Next", "Next");
    if ($nextPage = $page->next()) {
        //    return delving_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $nextPage->title), $section, $nextPage);
        return ve_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $nextPage->title), $section, $nextPage);
    } elseif ($nextSection = $section->next()) {
        //    return delving_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $nextSection->title), $nextSection);
        return ve_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $nextSection->title), $nextSection);
    }
}

/**
 * Returns a link to the previous exhibit page
 *
 * @param string $text The label for the previous page link
 * @param array $props
 * @return string
 **/
function ve_exhibit_builder_link_to_previous_exhibit_page($text = "&larr; Previous Page", $props = array(), $page = null)
{
    if (!$page) {
        $page = exhibit_builder_get_current_page();
    }

    $section = exhibit_builder_get_exhibit_section_by_id($page->section_id);
    $exhibit = exhibit_builder_get_exhibit_by_id($section->exhibit_id);
    $icon = '<img src="' . img('nav-page-previous.png') . '" alt="' . $text . '" />';
    $previous = ve_translate("Previous", "Previous");
    // if page object exists, grab link to previous exhibit page if exists. If it doesn't, grab
    // a link to the last page on the previous exhibit section, if it exists.
    if ($previousPage = $page->previous()) {
        //    return delving_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $previousPage->title), $section, $previousPage);
        return ve_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $previousPage->title), $section, $previousPage);
    }
    elseif ($previousSection = $section->previous()) {
        //    return delving_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $previousSection->title), $previousSection);
        return ve_exhibit_builder_link_to_exhibit($exhibit, $icon, array('title' => $previousSection->title), $previousSection);
    }
}

 
