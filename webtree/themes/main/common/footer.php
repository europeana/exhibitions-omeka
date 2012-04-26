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

<style>

	.wrap_at_320{
		float:			left;
		margin-right:	2em;
	}
	
	@media only screen and (max-width: 767px) {
		.wrap_at_320{
			display:	block;
			clear:		both;
			float:		none;
		}
		
	}
	
</style>

<div class="row" id="bottom-navigation">
	<div class="twelve columns">

		<div class="wrap_at_320">
			<a href="<?php echo uri('contact');?>"><?php echo ve_translate('contact', 'Contact');?></a>
		</div>
		
		<?php if (exhibit_builder_get_current_exhibit()): ?>
			<div class="wrap_at_320">
				<a class="return-to" rel="<?php echo uri(); ?>"
					href="<?php echo uri('items/browse') . '/?tags=' . ve_get_exhibit_name_from_slug($exhibit->slug) . '&theme=' . $currentExhibit->theme; ?>"><?php echo ve_translate("items-browse", "Browse items");?></a>
		
			</div>
			<?php if ($creditsPage):?>
				<div class="wrap_at_320">
					<a  class="return-to" rel="<?php echo uri(); ?>" href="<?php echo uri('credits-' . $eName) . '?theme=' . $currentExhibit->theme;?>"><?php echo ve_translate('credits', 'Credits');?></a>
				</div>
			<?php endif; ?>
		<?php endif; ?>
	
		<div class="wrap_at_320">
			<a href="<?php echo uri('about-exhibitions');?>"><?php echo ve_translate("about-exhibitions", "About Exhibitions");?></a>
		</div>

	</div>

	
	<!-- If this script tag is closed it makes the google icon bigger -->
	<!-- php messes this up, so put outside of custom_ve_helper for now -->
	<!--script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#pubid=ra-4d70f66c15fff6d0"-->
	<script type="text/javascript" src="http://s7.addthis.com/js/250/addthis_widget.js#username=ra-4d70f66c15fff6d0">
	</script>
            
            
        </div>
    </div>
</div>

<script type="text/javascript" language="javascript">

		// ipad fix for google docs iframe
		if (navigator.userAgent.match(/iPhone/i) || navigator.userAgent.match(/iPad/i)) {
		    var viewportmeta = document.querySelector('meta[name="viewport"]');
		    if (viewportmeta) {
		        viewportmeta.content = 'width=device-width, minimum-scale=1.0, maximum-scale=1.0, initial-scale=1.0';
				jQuery(document).bind('orientationchange',
					function () {
						if(window.orientation == 180 || window.orientation == 0){
							document.location.reload();
						}
					}
				);
		        
		        
		    }
		}
			

</script>


<?php if (isset($_GET['theme'])): ?>
    <script type="text/javascript" language="javascript">

        jQuery(document).ready(function() {
    		if(typeof(setThemePaths) != "undefined"){
	            setThemePaths("<?php echo $_GET['theme']; ?>");
       		}
        });
    </script>
<?php endif; ?>

</div><!-- end container -->

</body>
