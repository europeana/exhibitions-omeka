<?php
/**
 * File: Footer.php
 * Common footer shared across this theme and all themes that don't have this page defined
 */
    $currentExhibit = exhibit_builder_get_current_exhibit();
    $eName = ve_get_exhibit_name_from_slug($exhibit->slug);
    $pageSlug = 'credits-' . $eName;
    $creditsPage = ve_get_page_by_slug($pageSlug);
?>
</div><!-- end content  -->
</div><!-- end container -->

<div class="clear"></div>

<div id="footer">
    <div class="container_16" id="bottom-navigation"">
        <div class="grid_5">
           <ul class="navigation">
               <li>
                   <a href="<?php echo uri('contact');?>"><?php echo ve_translate('contact', 'Contact');?></a>
               </li>
                <?php if (exhibit_builder_get_current_exhibit()): ?>
                <li>
                    <a class="return-to" rel="<?php echo uri(); ?>"
                       href="<?php echo uri('items/browse') . '/?tags=' . ve_get_exhibit_name_from_slug($exhibit->slug) . '&theme=' . $currentExhibit->theme; ?>"><?php echo ve_translate("items-browse", "Browse items");?></a>
                </li>

                <?php if ($creditsPage):?>

                <li>
                    <a  class="return-to" rel="<?php echo uri(); ?>"
                        href="<?php echo uri('credits-' . $eName) . '?theme=' . $currentExhibit->theme;?>"><?php echo ve_translate('credits', 'Credits');?>
                    </a>
                </li>

                <?php endif; ?>
                <?php endif; ?>
                 <li>
                  <a
                      href="<?php echo uri('about-exhibitions');?>"><?php echo ve_translate("about-exhibitions", "About Exhibitions");?>
                   </a>
               </li>
                
                 </ul>


        </div>
        <div class="grid_11" style="text-align: right;">
           <ul class="navigation">
            <li><a href="http://www.facebook.com/Europeana" target="_blank" title="Follow us on Facebook!"><img src="http://exhibitions.europeana.eu/themes/europeana/images/icon_Facebook.png" alt="Follow us on Facebook!"></a></li>
            <li><a href="http://twitter.com/EuropeanaEU" target="_blank" title="Follow us on Twitter!"><img src="http://exhibitions.europeana.eu/themes/europeana/images/icon_Twitter.png" alt="Follow us on Twitter!"></a></li>
 			<li>
 				<?php echo getAddThisStandard(); ?>					 
 			</li>
           </ul>

        </div>
    </div>
</div>

<?php if (isset($_GET['theme'])): ?>
    <script type="text/javascript" language="javascript">
        jQuery(document).ready(function() {
            setThemePaths("<?php echo $_GET['theme']; ?>");
        });
    </script>
<?php endif; ?>
