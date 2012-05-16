	var globalElementWidth		= 0;
	var globalElementWidthLarge = 0;


	var calculateElementWidth = function(){

   		var noCols = 0;
    	var containerWidth = jQuery("#section-container").width();
//alert(containerWidth)
    	if(containerWidth <= 980){ // fullsize for foundation: iPad landscape
    	   	noCols = 5;
    	}
    	if(containerWidth <= 800){ // portrait iPad & galaxy are 760
    		noCols = 4;
		}
    	if(containerWidth < 728){ // anything smaller than iPad portrait
    		noCols = 3;
		}
    	if(containerWidth < 700){ // anything smaller than iPad portrait
    		noCols = 2;
		}
    	if(containerWidth < 450){ // anything smaller than iPad portrait
    		noCols = 1;
		}

		var margin = 5;
		var marginTotal = (2 * noCols) * margin;
		
		var elementWidth = (containerWidth - marginTotal) / noCols;	
		
		globalElementWidth		= parseInt(elementWidth);
		globalElementWidthLarge	= parseInt((elementWidth * 2) + 10);
		
    	if(noCols <= 2){ // anything smaller than iPad portrait and "large" is the same size as normal
			globalElementWidthLarge	= globalElementWidth;
		}
		
		jQuery(".element").css("width",		globalElementWidth);
		jQuery(".element").css("height",	globalElementWidth);
			
		jQuery(".element.large").css("width",	globalElementWidthLarge);
		jQuery(".element.large").css("height",	globalElementWidthLarge);
		//alert("calculate width:\n\nnoCols =\t" + noCols + "\ncontainerWidth =\t" + containerWidth + "\nmarginTotal =\t" + marginTotal + "\nelementWidth =\t" + elementWidth + "\nlargeWidth=\t" + globalElementWidthLarge);
		isotopeInit();
	}


	jQuery(window).bind('orientationchange',function(event){
		/* since ipad fires this event after the new window size has been calculated and galaxy does it before, a full refresh is needed. */
		//calculateElementWidth();
		window.location.reload();
	});


	//	Isotope script - isotope.metafizzy.co - for more information
	var isotopeInit = function(){

		var $container = $('#section-container');

		try{
	        //$container.isotope('destroy');
		}
		catch(e){}
        
		/* Andy: the "1" setting seems to foce isotope to calculate not on the 1st col (or row) width (or height), but to fit all spaces  */

		$container.isotope({
			itemSelector : '.element',

			masonry : {
				columnWidth : 1
			},
			masonryHorizontal : {
				rowHeight: 1
			},
			cellsByRow : {
				columnWidth : 1,
				rowHeight : 1
			},
			cellsByColumn : {
				columnWidth : 1,
				rowHeight : 1
			},
			getSortData : {
				name : function ( $elem ) {
					return $elem.find('.name').text();
				}
			}
		});
	};



	jQuery(document).ready(function(){

		jQuery("#section-container").delegate( '.element', 'click', function(){
		
			jQuery(this).toggleClass('large');
			
			if(jQuery(this).hasClass('large')){
				jQuery(this).css("width", globalElementWidthLarge + "px");
				jQuery(this).css("height", globalElementWidthLarge + "px");
			}
			else{
				jQuery(this).css("width", globalElementWidth + "px");
				jQuery(this).css("height", globalElementWidth + "px");
			}
			jQuery("#section-container").isotope('reLayout');
		});


		var buildSection = function(definition){
			var html = '';
			html += '<div contextmenu="' + definition.contextmenu + '" class="clickable">';
			html += 	'<div class="' + (definition.featured ? 'element large' : 'element inner-transition') + '"  style="background-image:url(\'' + definition.img + '\'); background-repeat:no-repeat;" >';


			if(definition.overlay_class){
				html += 		'<img class="' + definition.overlay_class + '" src="' + definition.overlay + '">';
			}
			else{
				html += 		'<img class="overlay" src="' + definition.overlay + '">';
			}

			if(definition.partner_overlay){
				html += '<img class="partner-overlay" src="' + definition.partner_overlay + '">';
			}

			// name, languages and partners
			html +=	'<div class="title-wrapper">';
			html += 	'<table class="title-table"><tr><td>';
			html +=			'<h5 class="name dark">' + definition.name + '</h5>';
			html += 	'</td></tr></table>';
			html +=	'</div>';


			html += '<div class="languages">';
			html +=		'<table class="language-table"><tr><td>';

			if(definition.languages){	

				
				for(var i=0; i<definition.languages.length; i++){
					var language = definition.languages[i];
					html += '<h4 style="display:inline; font-weight:normal;"><a class="' + language.class + '" href="' + language.link + '">' + language.label + '</a></h4>';
					if(i+1<definition.languages.length){
						html += ' &nbsp; ';
					}
				}
			}
			if(definition.partner){
				html += '<h3 style="display:inline; font-weight:normal;"><a target="_blank" href="' + definition.partner.site + '">' + definition.partner.label + '</a></h3>';
			}
			
			html +=		'</td></tr></table>';
			html += '</div>';

			html += 		'<menu type="context" id="' + definition.contextmenu + '">';
			html += 			'<menu label="' + definition.menu.label + '" icon="' + definition.menu.icon + '">';

			for(var i=0; i<definition.menu.items.length; i++){
				var item = definition.menu.items[i];
				html +=				'<menuitem label="' + item.label + '" icon="' + item.icon + '" onclick="goTo(\'' + item.goto + '\')">';
				html +=				'</menuitem>';
			}

			html += 			'</menu>';
			html += 		'</menu>';
		
			html += 	'</div>';
			html += '</div>';
			jQuery("#section-container").append(html);
		}


		/* 1914-1918 */

		var nineteenfourteen = { "contextmenu" : "europeana-1914-1918", "featured": true, "img": "splash/img/19141918_main.jpg", "overlay": "splash/logos/logo-white.png", "name": "Untold stories of the First World War", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Untold stories of the First World War: http://exhibitions.europeana.eu/exhibits/show/europeana-1914-1918-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/europeana-1914-1918-en" } ] }, "languages":[{"class":"language-en-main", "link":"exhibits/show/europeana-1914-1918-en", "label":"English"}, {"class":"language-fr-dada", "link":"exhibits/show/europeana-1914-1918-fr", "label":"Fran&ccedil;ais"}, {"class":"language-de-dada", "link":"exhibits/show/europeana-1914-1918-de", "label":"Deutsch"}, {"class":"language-sl-dada", "link":"exhibits/show/europeana-1914-1918-sl", "label":"Slovenian"}]   };


		/* wiki loves art nouveau */

		var wikiLoves = { "contextmenu" : "wiki-loves-artnouveau", "featured": false, "img": "splash/img/img21.jpg", "overlay": "splash/logos/logo-white.png", "partner_overlay":"splash/logos/logo_wiki_loves_monuments.png", "name": "Wiki Loves Art Nouveau", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Wiki Loves Art Nouveau: http://exhibitions.europeana.eu/exhibits/show/wiki-loves-art-nouveau" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/wiki-loves-art-nouveau" } ] }, "languages":[{"class":"language-en-main", "link":"exhibits/show/wiki-loves-art-nouveau", "label":"English"}, {"class":"language-ru-main", "link":"exhibits/show/wiki-loves-art-ru", "label":"Russian"}]   };


		/* expeditions */

		var expeditions = { "contextmenu" : "expeditions", "featured": false, "img": "splash/img/bhl_img1.jpg", "overlay": "splash/logos/logo-bhl.png", "overlay_class":"overlay-tel", "name": "Expeditions", "partner": {"site":"http://expeditions.biodiversityexhibition.com/", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Expeditions: http://expeditions.biodiversityexhibition.com/" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://expeditions.biodiversityexhibition.com/" } ] }   };


		/* weddings in eastern europe */

		var weddings = { "contextmenu" : "weddings-in-eastern-europe", "featured": false, "img": "splash/img/img31.jpg", "overlay": "splash/logos/logo.png", "partner_overlay":"splash/logos/logo-dismarc.png", "name": "Weddings in Eastern Europe", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Weddings in Eastern Europe: http://exhibitions.europeana.eu/exhibits/show/weddings-in-eastern-europe" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/weddings-in-eastern-europe" } ] }, "languages":[{"class":"language-en", "link":"exhibits/show/weddings-in-eastern-europe", "label":"English"}]   };


		/* from dada to surrealism */

		var dada = { "contextmenu" : "from-dada-to-surrealism", "featured": false, "img": "splash/img/img11.jpg", "overlay": "splash/logos/logo-white.png", "partner_overlay":"splash/logos/logo-jewish-historical-museum.png", "name": "From Dada to Surrealism", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=From Dada to Surrealism: http://exhibitions.europeana.eu/exhibits/show/dada-to-surrealism-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/dada-to-surrealism-en" } ] }, "languages":[{"class":"language-en-dada", "link":"exhibits/show/dada-to-surrealism-en", "label":"English"}, {"class":"language-fr-dada", "link":"exhibits/show/dada-to-surrealism-fr", "label":"Fran&ccedil;ais"}, {"class":"language-de-dada", "link":"exhibits/show/dada-to-surrealism-de", "label":"Deutsch"}, {"class":"language-es-dada", "link":"exhibits/show/dada-to-surrealism-es", "label":"Espa&ntilde;ol"}, {"class":"language-nl-dada", "link":"exhibits/show/dada-to-surrealism-nl", "label":"Nederlands"} ]   };


		/* mimo */

		var mimo = { "contextmenu" : "musical-instruments", "featured": false, "img": "splash/img/img61.jpg", "overlay": "splash/logos/logo.png", "partner_overlay":"splash/logos/logo-mimo.png", "name": "Explore the World of Musical Instruments", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Explore the World of Musical Instruments: http://exhibitions.europeana.eu/exhibits/show/musical-instruments-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/musical-instruments-en" } ] }, "languages":[{"class":"language-en-dada", "link":"exhibits/show/musical-instruments-en", "label":"English"}, {"class":"language-fr-dada", "link":"exhibits/show/musical-instruments-fr", "label":"Fran&ccedil;ais"}, {"class":"language-de-dada", "link":"exhibits/show/musical-instruments-de", "label":"Deutsch"}, {"class":"language-it-music", "link":"exhibits/show/musical-instruments-it", "label":"Italiano"}, {"class":"language-nl-dada", "link":"exhibits/show/musical-instruments-nl", "label":"Nederlands"}, {"class":"language-sv-music", "link":"exhibits/show/musical-instruments-sv", "label":"Svenska"} ]   };


		/* yiddish theater */

		var yiddish = { "contextmenu" : "yiddish-theatre", "featured": false, "img": "splash/img/img41.jpg", "overlay": "splash/logos/logo-white.png", "partner_overlay":"splash/logos/logo-jewish-museum-london.png", "name": "Yiddish Theatre in London", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Yiddish Theatre in London: http://exhibitions.europeana.eu/exhibits/show/yiddish-theatre-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/yiddish-theatre-en" } ] }, "languages":[{"class":"language-en-dada", "link":"exhibits/show/yiddish-theatre-en", "label":"English"}, {"class":"language-fr-dada", "link":"exhibits/show/yiddish-theatre-fr", "label":"Fran&ccedil;ais"}, {"class":"language-de-dada", "link":"exhibits/show/yiddish-theatre-de", "label":"Deutsch"}, {"class":"language-es-dada", "link":"exhibits/show/yiddish-theatre-es", "label":"Espa&ntilde;ol"} ]   };


		/* art nouveau */

		var nouveau = { "contextmenu" : "art-nouveau", "featured": false, "img": "splash/img/img51.jpg", "overlay": "splash/logos/logo.png", "name": "Art Nouveau", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "'//twitter.com/intent/tweet?text=Art Nouveau: http://exhibitions.europeana.eu/exhibits/show/art-nouveau-en'" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/art-nouveau-en" } ] }, 		
		"languages":[
		{"class":"language-en-dada", "link":"exhibits/show/art-nouveau-en", "label":"English"},
		{"class":"language-fr-dada", "link":"exhibits/show/art-nouveau-fr", "label":"Fran&ccedil;ais"},
		{"class":"language-nl-dada", "link":"exhibits/show/art-nouveau-nl", "label":"Nederlands"},
		{"class":"language-pl-art-nouveau", "link":"exhibits/show/art-nouveau-pl", "label":"Polski"},
		{"class":"language-es-dada", "link":"exhibits/show/art-nouveau-es", "label":"Espa&ntilde;ol"},
		{"class":"language-lv-artnouveau", "link":"exhibits/show/art-nouveau-lv", "label":"Latvie&scaron;u"}
		]};

		/* traveling thrugh history */
		
		var travelling = { "contextmenu" : "travelling-through-history", "featured": false, "img": "splash/img/tel_img21.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel", "name": "Travelling Through History", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition-travel-history/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Travelling Through History: http://www.theeuropeanlibrary.org/exhibition-travel-history/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition-travel-history/index.html" } ] }   };

		/* Reading Europe */

		var reading = { "contextmenu" : "reading-europe", "featured": false, "img": "splash/img/tel_img31.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel", "name": "Reading Europe", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition-reading-europe/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Reading Europe: http://www.theeuropeanlibrary.org/exhibition-reading-europe/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition-reading-europe/index.html" } ] }   };

		/* A Roma Journey */

		var roma = { "contextmenu" : "roma-journey", "featured": false, "img": "splash/img/tel_img61.jpg", "overlay": "splash/logos/logo-tel-white.png", "overlay_class":"overlay-tel", "name": "A Roma Journey", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/roma_journey/eng/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=A Roma Journey: http://www.theeuropeanlibrary.org/exhibition/roma_journey/eng/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/roma_journey/eng/index.html" } ] }   };

		/* Napoleonic Wars */

		var napoleon = { "contextmenu" : "napoleonic-wars", "featured": false, "img": "splash/img/tel_img5.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel",  "name": "Napoleonic Wars", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/roma_journey/eng/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Napoleonic Wars: http://www.theeuropeanlibrary.org/exhibition/napoleonic_wars/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/napoleonic_wars/index.html" } ] }   };

		/* Treasures */

		var treasures = { "contextmenu" : "treasures", "featured": false, "img": "splash/img/tel_img4.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel", "name": "Treasures", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/treasures/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Treasures: http://www.theeuropeanlibrary.org/exhibition/treasures/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/treasures/index.html" } ] }   };

		/* Buildings */

		var buildings = { "contextmenu" : "buildings", "featured": false, "img": "splash/img/tel_img11.jpg", "overlay": "splash/logos/logo-tel-white.png", "overlay_class":"overlay-tel", "name": "Buildings", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/buildings/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Buildings: http://www.theeuropeanlibrary.org/exhibition/buildings/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/buildings/index.html" } ] }   };

		/* Athena */

		var athena =  { "contextmenu" : "a-voyage-with-the-gods", "featured": false, "img": "splash/img/athena_img1.jpg", "overlay": "splash/logos/logo-athena.png", "name": "A Voyage With The Gods", "partner": {"site":"http://151.12.58.141/virtualexhibition/", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=A Voyage With The Gods: http://151.12.58.141/virtualexhibition/" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://151.12.58.141/virtualexhibition/" } ] }   };

		/* spices */

		var spices = { "contextmenu" : "spices", "featured": false, "img": "splash/img/bhl_img2.jpg", "overlay": "splash/logos/logo-bhl.png", "overlay_class":"overlay-tel", "name": "Spices", "partner": {"site":"http://spices.biodiversityexhibition.com/", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Spices: http://spices.biodiversityexhibition.com/" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://spices.biodiversityexhibition.com/" } ] }   };

		
		jQuery("#section-container").html(""); // clear non-js seo stuff
		buildSection(nineteenfourteen);
		buildSection(wikiLoves);
		buildSection(weddings);
		buildSection(dada);
		buildSection(mimo);
		buildSection(yiddish);
		buildSection(nouveau);
		buildSection(travelling);
		buildSection(reading);
		buildSection(roma);
		buildSection(napoleon);
		buildSection(treasures);
		buildSection(buildings);
		buildSection(athena);
		buildSection(spices);
		buildSection(expeditions);

		calculateElementWidth();


		// language hooks: take language from parent class

		jQuery("a").each(function(){
			jQuery(this).click(function(){

				try{
					//var parentClass = jQuery(this).parent().attr("class");
					var parentClass = jQuery(this).attr("class");
					var exp = /[-](.*?)[-]/;
					var language = parentClass.match(exp)[1];
					setLanguage(language);
				}catch(e){
					//var parentClass = jQuery(this).parent().attr("class");
					var parentClass = jQuery(this).attr("class");
					var arr = parentClass.split("-");
					var language =  arr[arr.length-1];
					setLanguage(language);
				}
				return true;

			});  // end click handler
		});  // end for each

	});  // end ready handler

	function goTo(url) { window.open(url, "shareWindow"); }
	
