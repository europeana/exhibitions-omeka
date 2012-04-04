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



<div class="row" id="bottom-navigation"  style="background-color:red!important">
	<div class="six columns">
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
		<div class="six columns" style="text-align: right;">
			<ul class="navigation">
				<!--   <li><a href="http://www.facebook.com/Europeana" target="_blank" title="Follow us on Facebook!"><img src="http://exhibitions.europeana.eu/themes/europeana/images/icon_Facebook.png" alt="Follow us on Facebook!"></a></li>
				<li><a href="http://twitter.com/EuropeanaEU" target="_blank" title="Follow us on Twitter!"><img src="http://exhibitions.europeana.eu/themes/europeana/images/icon_Twitter.png" alt="Follow us on Twitter!"></a></li> -->
				<li><!-- AddThis Button BEGIN -->
 
 
 <script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f7c39d46532bd4d"></script>
 
 
 

 
 					<style type="text/css">
 					/*
						.addthis_toolbox .at15t_compact {
 							margin-right: 0;
						}
 					
 					*/
 					</style>
 
						 
					<div class="addthis_toolbox addthis_default_style " style="float:right; display: inline; padding-left: 30px;">
						<a class="addthis_button_facebook"></a>
						<a class="addthis_button_twitter"></a>
						<a class="addthis_button_facebook_like"></a>
						
						<!-- a class="addthis_button_google_plusone at300b" g:plusone:count="false" g:plusone:size="small"></a-->
						
						<a class="addthis_button_google_plusone" g:plusone:size="medium"></a> 
						  <!-- Place this tag where you want the +1 button to render -->
						<!-- g:plusone size="small" annotation="inline"></g:plusone-->
						
						<a class="addthis_counter addthis_pill_style"></a>  <!--  "addthis_pill_style" -->
					</div>
  

  
 <!-- 
					<div class="addthis_toolbox addthis_default_style ">
						<a class="addthis_button_preferred_1"></a>
						<a class="addthis_button_preferred_2"></a>

												<a class="addthis_button_preferred_4"></a>
						<a class="addthis_button_compact"></a>
						<a class="addthis_counter addthis_bubble_style"></a>
					</div>
  -->
  
  
<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=xa-4f7c39d46532bd4d"></script>
<!-- AddThis Button END -->

<!-- Place this render call where appropriate -->
<script type="text/javascript">
  (function() {
    var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
    po.src = 'https://apis.google.com/js/plusone.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
  })();
</script>

				</li>
			</ul>
	
 




			<script type="text/javascript">
	            var addthis_config = {
	            	"pubid":				'ra-4d70f66c15fff6d0',	// xa-4b4f08de468caf36 
		            "ui_language":			'en',
		            "ui_click":				false,					// click to reveal men or show on  mouse over?
		            "ui_cobrand":			'Europeana',
					"data_track_clickback":	true,
					"data_ga_tracker":		null					// Google Analytics tracking object, or the name of a global variable that references it. If set, we'll send AddThis tracking events to Google, so you can have integrated reporting.
	            }
	            
			</script>
			<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4d70f66c15fff6d0"></script>


						
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

            

   	<script type="text/javascript">
//	alert("call responsive gallery in main/common/footer");
	
	responsiveGallery({
		scriptClass: 'euresponsive-script',
		testClass: 'euresponsive',
		initialSuffix: '_euresponsive_1.jpg',
		suffixes: {
			'1': '_euresponsive_1.jpg',
			'2': '_euresponsive_2.jpg',
			'3': '_euresponsive_3.jpg',
			'4': '_euresponsive_4.jpg'
		}
	});
	</script>
            
            
        </div>
    </div>
</div>

<?php if (isset($_GET['theme'])): ?>
    <script type="text/javascript" language="javascript">

        jQuery(document).ready(function() {
    		//alert("main/common/footer     setThemePaths();");
    		if(typeof(setThemePaths) != "undefined"){
	            setThemePaths("<?php echo $_GET['theme']; ?>");
       		}
        });
    </script>
<?php endif; ?>

</div><!-- end container -->
