
		(function() {
			function escapeRegex(text) {
				return text.replace(/[-[\]{}()*+?.,\\^$|#\s]/g, "\\$&");
			}

			function hasClass(elm, className) {
				return (' ' + elm.className + ' ').indexOf( className ) != -1;
			}

			function addListener(elm, type, callback) {
				if (elm.addEventListener) {
					elm.addEventListener( type, callback, false );
				}
				else if (elm.attachEvent) {
					elm.attachEvent( 'on' + type, callback );
				}
			}

			function Gallery(script) {
				this.htmlStr = script.nextSibling.nodeValue.slice( 10, -11 );
				this.container = document.createElement( 'div' );
				script.parentNode.insertBefore( this.container, script.nextSibling );
			}

			
			Gallery.prototype.changeLayout = function(escapedInitialSuffix, newSuffix, useZoomit) {
				
				var newHtmlStr = this.htmlStr.replace(
					new RegExp('(src="[^"]*)' + escapedInitialSuffix + '"', 'g'),
					'$1' + newSuffix + '"'
				);


				if(useZoomit){ // zoomify: here we hard code the sample, integration with current europeana plugin will involve obtaining the correct zoomit url
					var x = ""
						 + "<div id=\"exhibit-item-infocus-item\">"
						 +   "<div class=\"image\" id=\"in-focus\">"
						 +     "<script src=\"http://zoom.it/Omrd.js?width=auto\" language=\"javascript\" type=\"text/javascript\"><\/script>"
						 
//						 +     "<div style=\"width: auto; height: 400px; border: 1px solid black; background: black; color: white; margin: 0px; padding: 0px;\" class=\"__seadragon\" id=\"__seadragon1\">"
						 +     "<div style=\"width:" + useZoomit + "px; height:" + useZoomit + "px; border: 1px solid black; background: black; color: white; margin: 0px; padding: 0px;\" class=\"__seadragon\" id=\"__seadragon1\">"
						 
						 +       "<div style=\"background: none repeat scroll 0% 0% transparent; border: medium none; margin: 0px; padding: 0px; position: static; width: 100%; height: 100%;\">"
						 +         "<object width=\"100%\" height=\"100%\" data=\"data:application\/x-silverlight,\" type=\"application\/x-silverlight\" id=\"deepZoomEmbed1898620221\">"
						 +           "<param value=\"transparent\" name=\"background\">"
						 
						 +           "<param value=\"true\" name=\"enableHtmlAccess\"><param value=\"false\" name=\"windowless\">"
						 +           "<param value=\"http:\/\/zoom.it\/scripts\/DeepZoomViewer.xap\" name=\"source\">"
						 
//						 +           "<param value=\"url=http:\/\/cache.zoom.it\/content\/Omrd.dzi,height=1600\" name=\"initParams\">"
						 +           "<param value=\"url=http:\/\/cache.zoom.it\/content\/r2a8.dzi,height=1600\" name=\"initParams\">"
						 
						 
						 +           "<param value=\"__slEvent0\" name=\"onLoad\"><param value=\"__slEvent1\" name=\"onError\">"
						 + 		   "<\/object>"
						 +       "<\/div>"
						 +     "<\/div>"
						 +   "<\/div>"
						 +   "<div id=\"exhibit-item-title\">"
						 +     "<h4>Iparmvszeti Mzeum (1070. szm memlk)<\/h4>"
						 +   "<\/div>"
						 + "<\/div>";
					this.container.innerHTML = x;	
				}
				else{
					this.container.innerHTML = newHtmlStr;
					//this.container.innerHTML = "<img src=\"\/archive\/euresponsive\/" + imageStem + newSuffix + "\" \/>";
				}
			};
			
			
			
			window.responsiveGallery = function(args) {
				
				// fn to measure the size of the suffixes associative array
				if(typeof Object.prototype.size == "undefined"){					
					Object.prototype.size = function () {
						var len = this.length ? --this.length : -1;
						for (var k in this)
							len++;
						return len;
					}
				}
				
				var testDiv = document.createElement( 'div' ),
					scripts = document.getElementsByTagName( 'script' ),
					lastSuffix,
					escapedInitialSuffix = escapeRegex( args.initialSuffix || '' ),
					galleries = [];

				// Add the test div to the page
				testDiv.className = args.testClass || 'gallery-test';
				testDiv.style.cssText = 'position:absolute;top:-100em';
				document.body.insertBefore( testDiv, document.body.firstChild );

				// Init galleries
				for ( var i = scripts.length; i--; ) {
					var script = scripts[i];
					
					if ( hasClass(script, args.scriptClass) ) {
						galleries.push( new Gallery(script) );
					}
				}

				function respond() {
					var newSuffix = args.suffixes[testDiv.offsetWidth] || args.initialSuffix;
					
					if (newSuffix === lastSuffix) {
						return;
					}
					
					
					for (var i = galleries.length; i--;) {
						galleries[i].changeLayout(escapedInitialSuffix, newSuffix, (newSuffix==args.suffixes[args.suffixes.size() + ""] && euresponsive_zoomit) ? euresponsive_zoomit : false);
					}
					lastSuffix = newSuffix;
					
					// RESPONSIVE BREADCRUMBS
					var breadcrumbs = jQuery("#main-breadcrumbs");
					if(breadcrumbs){
						breadcrumbs.html(breadcrumbs.html().replace(/&gt; /g, ''));
						
						var crumbs			= breadcrumbs.find("a").filter(function(){
							if(this.parent().id=="site-title-small"){
								return false;
							}
							return true;
						});
						
						crumbs.each(function(){
							console.log(this.html());
						})
						
						
						var suffixNumber	= parseInt(newSuffix.replace(/[^0-9]/g, ''));

//						site-title-small
						
						jQuery.fn.reverse = [].reverse;	// add reverse functionality to "each()"
						crumbs.reverse().each(function(index, crumb){
							crumb = jQuery(crumb); 
							if(index<suffixNumber){
								crumb.show();
								crumb.after("&gt; ");
							}
							else{
								jQuery(crumb).hide();
							}
						});
					}
				}

				
				
				
				respond();
				addListener(window, 'resize', respond);
			};
		})();
		
		
		