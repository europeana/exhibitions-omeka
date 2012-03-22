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
        <div class="grid_6">
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
                      href="<?php echo uri('languages');?>"><?php echo ve_translate('languages', 'Languages');?>
                   </a>
               </li>
                
                 </ul>


        </div>
        <div class="grid_10" style="text-align: right;">
           <ul class="navigation">
            <li><a href="http://www.facebook.com/Europeana" target="_blank" title="Follow us on Facebook!"><img src="http://exhibitions.europeana.eu/themes/europeana/images/icon_Facebook.png" alt="Follow us on Facebook!"></a></li>
               <li><a href="http://twitter.com/EuropeanaEU" target="_blank" title="Follow us on Twitter!"><img src="http://exhibitions.europeana.eu/themes/europeana/images/icon_Twitter.png" alt="Follow us on Twitter!"></a></li>
               <li><!-- AddThis Button BEGIN -->
<div class="addthis_toolbox addthis_default_style " style="float: right; display: inline; padding-left: 30px;">
<a class="addthis_button_facebook_like" fb:like:layout="button_count"></a>
<a class="addthis_button_tweet"></a>
<a class="addthis_counter addthis_pill_style"></a>
</div>
</li>

           </ul>

           <script type="text/javascript">var addthis_config = {"data_track_clickback":true};</script>
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4d70f66c15fff6d0">
<!-- AddThis Button END -->
            var addthis_config = {
            ui_language: "en",
            ui_click: true,
            ui_cobrand: "Europeana"

            }
            </script>
 
            <script type="text/javascript">
  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-12776629-3']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();
</script>

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
