var goTo = function(url){
  window.location = url;	
};

var splashData = function(){

    var toMyPeoples = {
		"img" : "splash/img/AnMeineVolker-tile.jpg",
		"featured" : true,
		"name" : "To My Peoples",
		"overlay" : "splash/logos/logo-white.png",
		"partner_overlay":"splash/logos/logo-ONB.png",
		"languages" : [
			{"langClass" : "language-en-main", "link":"https://www.google.com/culturalinstitute/exhibit/to-my-peoples/gQyspHgL?hl=en-GB", "label":"English"},
			{"langClass" : "language-de-main", "link":"https://www.google.com/culturalinstitute/exhibit/to-my-peoples/gQyspHgL?hl=de", "label":"German"}
		]
	}
	
	var picasso = {
		"img" : "splash/img/picasso.jpg",
		"featured" : false,
		"overlay" : "splash/logos/hazu_logo02.png",
		"name" : "Pablo Picasso",
		"languages" : [
			{"langClass" : "language-en-main", "link":"http://dizbi.hazu.hr/picasso/", "label":"Open partner exhibition"}
		]
	}



    var darwin = {
		"context-menu" : "",
		"img" : "splash/img/darwin.jpg",
                    "featured" : true,
		"name" : "Darwinism: Reception in Spain and Catalonia",
        "overlay" : "splash/logos/logo-white.png",
        "partner_overlay":"splash/logos/ateneu-logo.png",
        "languages" : [
		      {"langClass" : "language-en-main", "link":"exhibits/show/darwin-darwinism", "label":"English"},
		      {"langClass" : "language-es-main", "link":"exhibits/show/darwin-darwinism-es", "label":"Spanish"},
		      {"langClass" : "language-es-main", "link":"exhibits/show/darwin-darwinism-ca", "label":"Catalan"}
	      ]
	}


    var romeInFesta = {
		"context-menu" : "",
		"img" : "splash/img/Rome.jpg",
                    "featured" : false,
		"name" : "Rome in Festa",
                    "overlay" : "splash/logos/logo-white.png",
		"languages" : [{"langClass" : "language-en-main", "link":"exhibits/show/festa-in-roma", "label":"English"}]
	}




		/* German site WWI */

                var firstWorldWar = {
			"context-menu" : "",
   			"img" : "splash/img/world-war-one.jpg",
                        "featured" : false,
			"OLDname" : "Der Erste Weltkrieg - Orte des &#220;bergangs",
                        "name" : "The First World War - Places of Transit",
                        "overlay" : "splash/logos/logo-white.png",
			"languages" : [
				{"langClass" : "language-en-main", "link":"exhibits/show/14-18-collections-en", "label":"English"},
				{"langClass" : "language-de-main", "link":"exhibits/show/14-18-collections-de", "label":"Deutsch"}
			]
		}




		/* past not as ypu know it */

                var pnayki = {
			"context-menu" : "past-not-as-you-know",
   			"img" : "splash/img/pig.jpg",
                        "featured" : true,
			"name" : "The Past But Not As You Know It",
                        "overlay" : "splash/logos/logo-white.png",
                        "menu" : {"label": "Share on...", "icon":"splash/img/share_icon.gif", "items":
[
                                            {   "label": "Twitter", "icon": "splash/img/twitter_icon.gif",
                                                 "goto": "//twitter.com/intent/tweet?text=European Sports: http://exhibitions.europeana.eu/exhibits/show/past-not-as-you-know" },

                                            {   "label": "Facebook", "icon": "splash/img/facebook_icon.gif",
                                                "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/past-not-as-you-know" } ]

                         },
			"languages" : [{"langClass" : "language-en-main", "link":"exhibits/show/past-not-as-you-know", "label":"English"}]
		}	

		/* glam */

		var glam = {
				"contextmenu" : "wiki-loves-glam",
				"featured": false,
				
				"img": "splash/img/UniversityLibraryBucharest.jpg",
				"overlay": "splash/logos/logo-white.png",
				"name": "Wiki Loves Glam",
				"menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif",
					"items":[
					    {	"label": "Twitter", "icon": "splash/img/twitter_icon.gif",
					    	 "goto": "//twitter.com/intent/tweet?text=European Sports: http://exhibitions.europeana.eu/exhibits/show/wiki-loves-glam" },
					    	 
					    {	"label": "Facebook", "icon": "splash/img/facebook_icon.gif",
					    	"goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/wiki-loves-glam" } ] }, 
				
				"languages":[
			             {"langClass":"language-en-main", "link":"exhibits/show/wiki-loves-glam", "label":"English"}
	             ]   
	
		}; 


	
		/* dpla migration exhibition */

		var migration = {
				"contextmenu" : "migration",
				"featured": false,
				"img": "splash/img/migration.jpg",
				"overlay": "splash/logos/logo-white.png",
				"partner_overlay":"splash/logos/logo-dpla.png",
				"name": "Leaving Europe: A new life in America",
				"menu":{	
					"label" : "Share on...", "icon": "splash/img/share_icon.gif",
					"items":[
					         {
					        	 "label": "Twitter", "icon": "splash/img/twitter_icon.gif",
					        	 "goto": "//twitter.com/intent/tweet?text=Leaving Europe - A new life in America: http://exhibitions.europeana.eu/exhibits/show/europe-america-en"
					         },
					         {
					        	 "label": "Facebook", "icon": "splash/img/facebook_icon.gif",
					        	 "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/europe-america-en"
					         }
					         ]
				}, 
				"languages":[
					{"langClass":"language-en-main", "link":"exhibits/show/europe-america-en", "label":"English"},
					{"langClass":"language-fr-main", "link":"exhibits/show/europe-america-fr", "label":"Fran&ccedil;ais"}
				 ]   

		}; 


		/* royal book collections */

		var royalbookcollections = { "contextmenu" : "royalbookcollections", "featured": false, "img": "splash/img/royalbookcollections.jpg", "overlay": "splash/logos/logo-white.png", "name": "Royal Book Collections", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Royal Book Collections: http://exhibitions.europeana.eu/exhibits/show/royal-book-collections-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/royal-book-collections-en" } ] }, 
				
				"languages":[
				             {"langClass":"language-en-main", "link":"exhibits/show/royal-book-collections-en", "label":"English"},
				    		 {"langClass":"language-fr-main", "link":"exhibits/show/royal-book-collections-fr", "label":"Fran&ccedil;ais"}
				             ]   

		}; 


		/* sports */

		var sports = { "contextmenu" : "sports", "featured": false, "img": "splash/img/sports.jpg", "overlay": "splash/logos/logo-white.png", "name": "European Sport Heritage", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=European Sports: http://exhibitions.europeana.eu/exhibits/show/european-sports" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/european-sports-en" } ] }, 
				
				"languages":[
				             {"langClass":"language-en-main", "link":"exhibits/show/european-sports-en", "label":"English"},
				     		 {"langClass":"language-es-main", "link":"exhibits/show/european-sports-es", "label":"Espa&ntilde;ol"},
				    		 {"langClass":"language-fr-main", "link":"exhibits/show/european-sports-fr", "label":"Fran&ccedil;ais"},
				    		 {"langClass":"language-de-main", "link":"exhibits/show/european-sports-de", "label":"Deutsch"}
				             ]   

		}; 
	
		/* 1914-1918 */

		var nineteenfourteen = { "contextmenu" : "europeana-1914-1918", "featured": false, "img": "splash/img/19141918_main.jpg", "overlay": "splash/logos/logo-white.png", "name": "Untold stories of the First World War", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Untold stories of the First World War: http://exhibitions.europeana.eu/exhibits/show/europeana-1914-1918-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/europeana-1914-1918-en" } ] }, "languages":[{"langClass":"language-en-main", "link":"exhibits/show/europeana-1914-1918-en", "label":"English"}, {"langClass":"language-fr-dada", "link":"exhibits/show/europeana-1914-1918-fr", "label":"Fran&ccedil;ais"}, {"langClass":"language-de-dada", "link":"exhibits/show/europeana-1914-1918-de", "label":"Deutsch"}, {"langClass":"language-sl-dada", "link":"exhibits/show/europeana-1914-1918-sl", "label":"Slovenian"}]   };


		/* wiki loves art nouveau */



		var wikiLoves = { "contextmenu" : "wiki-loves-artnouveau", "featured": false, "img": "splash/img/img21.jpg", "overlay": "splash/logos/logo-white.png", "partner_overlay":"splash/logos/logo_wiki_loves_monuments.png", "name": "Wiki Loves Art Nouveau", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Wiki Loves Art Nouveau: http://exhibitions.europeana.eu/exhibits/show/wiki-loves-art-nouveau" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/wiki-loves-art-nouveau" } ] }, "languages":[{"langClass":"language-en-main", "link":"exhibits/show/wiki-loves-art-nouveau", "label":"English"}, {"langClass":"language-ru-main", "link":"exhibits/show/wiki-loves-art-ru", "label":"Russian"}]   };


		
		
		/* expeditions */

		var expeditions = { "contextmenu" : "expeditions", "featured": false, "img": "splash/img/bhl_img1.jpg", "overlay": "splash/logos/logo-bhl.png", "overlay_class":"overlay-tel", "name": "Expeditions", "partner": {"site":"http://expeditions.biodiversityexhibition.com/", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Expeditions: http://expeditions.biodiversityexhibition.com/" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://expeditions.biodiversityexhibition.com/" } ] }   };


		/* weddings in eastern europe */

		var weddings = { "contextmenu" : "weddings-in-eastern-europe", "featured": false, "img": "splash/img/img31.jpg", "overlay": "splash/logos/logo.png", "partner_overlay":"splash/logos/logo-dismarc.png", "name": "Weddings in Eastern Europe", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Weddings in Eastern Europe: http://exhibitions.europeana.eu/exhibits/show/weddings-in-eastern-europe" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/weddings-in-eastern-europe" } ] }, "languages":[{"langClass":"language-en", "link":"exhibits/show/weddings-in-eastern-europe", "label":"English"}]   };


		/* from dada to surrealism */

		var dada = { "contextmenu" : "from-dada-to-surrealism", "featured": false, "img": "splash/img/img11.jpg", "overlay": "splash/logos/logo-white.png", "partner_overlay":"splash/logos/logo-jewish-historical-museum.png", "name": "From Dada to Surrealism", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=From Dada to Surrealism: http://exhibitions.europeana.eu/exhibits/show/dada-to-surrealism-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/dada-to-surrealism-en" } ] }, "languages":[{"langClass":"language-en-dada", "link":"exhibits/show/dada-to-surrealism-en", "label":"English"}, {"langClass":"language-fr-dada", "link":"exhibits/show/dada-to-surrealism-fr", "label":"Fran&ccedil;ais"}, {"langClass":"language-de-dada", "link":"exhibits/show/dada-to-surrealism-de", "label":"Deutsch"}, {"langClass":"language-es-dada", "link":"exhibits/show/dada-to-surrealism-es", "label":"Espa&ntilde;ol"}, {"langClass":"language-nl-dada", "link":"exhibits/show/dada-to-surrealism-nl", "label":"Nederlands"} ]   };


		/* mimo */

		var mimo = { "contextmenu" : "musical-instruments", "featured": false, "img": "splash/img/img61.jpg", "overlay": "splash/logos/logo.png", "partner_overlay":"splash/logos/logo-mimo.png", "name": "Explore the World of Musical Instruments", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Explore the World of Musical Instruments: http://exhibitions.europeana.eu/exhibits/show/musical-instruments-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/musical-instruments-en" } ] }, "languages":[{"langClass":"language-en-dada", "link":"exhibits/show/musical-instruments-en", "label":"English"}, {"langClass":"language-fr-dada", "link":"exhibits/show/musical-instruments-fr", "label":"Fran&ccedil;ais"}, {"langClass":"language-de-dada", "link":"exhibits/show/musical-instruments-de", "label":"Deutsch"}, {"langClass":"language-it-music", "link":"exhibits/show/musical-instruments-it", "label":"Italiano"}, {"langClass":"language-nl-dada", "link":"exhibits/show/musical-instruments-nl", "label":"Nederlands"}, {"langClass":"language-sv-music", "link":"exhibits/show/musical-instruments-sv", "label":"Svenska"} ]   };


		/* yiddish theater */

		var yiddish = { "contextmenu" : "yiddish-theatre", "featured": false, "img": "splash/img/img41.jpg", "overlay": "splash/logos/logo-white.png", "partner_overlay":"splash/logos/logo-jewish-museum-london.png", "name": "Yiddish Theatre in London", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Yiddish Theatre in London: http://exhibitions.europeana.eu/exhibits/show/yiddish-theatre-en" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/yiddish-theatre-en" } ] }, "languages":[{"langClass":"language-en-dada", "link":"exhibits/show/yiddish-theatre-en", "label":"English"}, {"langClass":"language-fr-dada", "link":"exhibits/show/yiddish-theatre-fr", "label":"Fran&ccedil;ais"}, {"langClass":"language-de-dada", "link":"exhibits/show/yiddish-theatre-de", "label":"Deutsch"}, {"langClass":"language-es-dada", "link":"exhibits/show/yiddish-theatre-es", "label":"Espa&ntilde;ol"} ]   };


		/* art nouveau */

		var nouveau = { "contextmenu" : "art-nouveau", "featured": false, "img": "splash/img/img51.jpg", "overlay": "splash/logos/logo.png", "name": "Art Nouveau", "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "'//twitter.com/intent/tweet?text=Art Nouveau: http://exhibitions.europeana.eu/exhibits/show/art-nouveau-en'" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://exhibitions.europeana.eu/exhibits/show/art-nouveau-en" } ] }, 		
		"languages":[
		{"langClass":"language-en-dada", "link":"exhibits/show/art-nouveau-en", "label":"English"},
		{"langClass":"language-fr-dada", "link":"exhibits/show/art-nouveau-fr", "label":"Fran&ccedil;ais"},
		{"langClass":"language-nl-dada", "link":"exhibits/show/art-nouveau-nl", "label":"Nederlands"},
		{"langClass":"language-pl-art-nouveau", "link":"exhibits/show/art-nouveau-pl", "label":"Polski"},
		{"langClass":"language-es-dada", "link":"exhibits/show/art-nouveau-es", "label":"Espa&ntilde;ol"},
		{"langClass":"language-lv-artnouveau", "link":"exhibits/show/art-nouveau-lv", "label":"Latvie&scaron;u"}
		]};

		/* flying machines */
		
		var flyingMachines = { 
				"contextmenu" : "science-and-machines",
				"featured": false,
				"img": "splash/img/TEL.jpg",
				"overlay": "splash/logos/logo-tel-white.png",
				"overlay_class":"overlay-tel",
				"name": "Science & Machines",
				"partner": {
					"site":"http://www.theeuropeanlibrary.org/tel4/virtual/science",
					"label":"Open partner exhibition"
				},
				"menu":{
					"label" : "Share on...", "icon": "splash/img/share_icon.gif",
					"items":[
					         {	"label": "Twitter",
					        	 "icon": "splash/img/twitter_icon.gif",
					        	 "goto": "//twitter.com/intent/tweet?text=Science & Machines: http://www.theeuropeanlibrary.org/tel4/virtual/science"
					         },
					         {
					        	 "label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/tel4/virtual/science" 
					        }
					         ]
					} 
				};
		
		/* traveling thrugh history */
		
		var travelling = { "contextmenu" : "travelling-through-history", "featured": false, "img": "splash/img/tel_img21.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel", "name": "Travelling Through History", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition-travel-history/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Travelling Through History: http://www.theeuropeanlibrary.org/exhibition-travel-history/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition-travel-history/index.html" } ] }   };

		/* Reading Europe */

		var reading = { "contextmenu" : "reading-europe", "featured": false, "img": "splash/img/tel_img31.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel", "name": "Reading Europe", "partner": {"site":"http://www.theeuropeanlibrary.org/tel4/virtual/reading-europe", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Reading Europe: http://www.theeuropeanlibrary.org/exhibition-reading-europe/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition-reading-europe/index.html" } ] }   };

		/* A Roma Journey */

		var roma = { "contextmenu" : "roma-journey", "featured": false, "img": "splash/img/tel_img61.jpg", "overlay": "splash/logos/logo-tel-white.png", "overlay_class":"overlay-tel", "name": "A Roma Journey", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/roma_journey/eng/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=A Roma Journey: http://www.theeuropeanlibrary.org/exhibition/roma_journey/eng/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/roma_journey/eng/index.html" } ] }   };

		/* Napoleonic Wars */

		var napoleon = { "contextmenu" : "napoleonic-wars", "featured": false, "img": "splash/img/tel_img5.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel",  "name": "Napoleonic Wars", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/napoleonic_wars/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Napoleonic Wars: http://www.theeuropeanlibrary.org/exhibition/napoleonic_wars/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/napoleonic_wars/index.html" } ] }   };

		/* Treasures */

		var treasures = { "contextmenu" : "treasures", "featured": false, "img": "splash/img/tel_img4.jpg", "overlay": "splash/logos/logo-tel-black.png", "overlay_class":"overlay-tel", "name": "Treasures", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/treasures/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Treasures: http://www.theeuropeanlibrary.org/exhibition/treasures/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/treasures/index.html" } ] }   };

		/* Buildings */

		var buildings = { "contextmenu" : "buildings", "featured": false, "img": "splash/img/tel_img11.jpg", "overlay": "splash/logos/logo-tel-white.png", "overlay_class":"overlay-tel", "name": "Buildings", "partner": {"site":"http://www.theeuropeanlibrary.org/exhibition/buildings/index.html", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Buildings: http://www.theeuropeanlibrary.org/exhibition/buildings/index.html" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://www.theeuropeanlibrary.org/exhibition/buildings/index.html" } ] }   };

		/* Athena */

		var athena =  { "contextmenu" : "a-voyage-with-the-gods", "featured": false, "img": "splash/img/athena_img1.jpg", "overlay": "splash/logos/logo-athena.png", "name": "A Voyage With The Gods", "partner": {"site":"http://151.12.58.141/virtualexhibition/", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=A Voyage With The Gods: http://151.12.58.141/virtualexhibition/" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://151.12.58.141/virtualexhibition/" } ] }   };

		
		/* poisonous nature */

		var poisonousNature = {
				"contextmenu" : "poisonous-nature",
				"featured": false,
				"img": "splash/img/BHL_Poisonous-Nature.jpg",
				"overlay": "splash/logos/logo-bhl.png",
				"overlay_class":"overlay-tel",
				"name": "Poisonous Nature",
				"partner":{
							"site":"http://poisonousnature.biodiversityexhibition.com/en/card/giant-centipede",
							"label":"Open partner exhibition"
				},
				"menu":{
							"label" : "Share on...",
							"icon": "splash/img/share_icon.gif",
							"items":[
							         {
							        	 "label": "Twitter",
							        	 "icon": "splash/img/twitter_icon.gif",
							        	 "goto": "//twitter.com/intent/tweet?text=Poisonous Nature: http://poisonousnature.biodiversityexhibition.com/en/card/giant-centipede"
							        },
							        {
							        	"label": "Facebook",
							        	"icon": "splash/img/facebook_icon.gif",
							        	"goto": "//facebook.com/sharer/sharer.php?u=http://poisonousnature.biodiversityexhibition.com/en/card/giant-centipede"
							        }
							  ]
					}
		};

			
		
		/* spices */

		var spices = { "contextmenu" : "spices", "featured": false, "img": "splash/img/bhl_img2.jpg", "overlay": "splash/logos/logo-bhl.png", "overlay_class":"overlay-tel", "name": "Spices", "partner": {"site":"http://spices.biodiversityexhibition.com/", "label":"Open partner exhibition"}, "menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif", "items":[{"label": "Twitter", "icon": "splash/img/twitter_icon.gif", "goto": "//twitter.com/intent/tweet?text=Spices: http://spices.biodiversityexhibition.com/" }, {"label": "Facebook", "icon": "splash/img/facebook_icon.gif", "goto": "//facebook.com/sharer/sharer.php?u=http://spices.biodiversityexhibition.com/" } ] }   };
		
		
		
		
		/* being european */
		
		var beingEuropean = {	"contextmenu" : "being european", "featured": false,
								"img": "splash/img/imgBeingEuropean.jpg",
								
								"overlay":"splash/img/EUscreen-logo.png",
								"overlay_class":"eu-screen-overlay",
								
								"name": "Being European",
								"title" : "Being European",
								"partner": {"site":"http://euscreen.eu/exhibitions.html?id=beingeuropean", "label":"Open partner exhibition"},
								"menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif",
									"items":[
									        {	"label": "Twitter", "icon": "splash/img/twitter_icon.gif",
												"goto": "//twitter.com/intent/tweet?text=Being European: http://euscreen.eu/exhibitions.html?id=beingeuropean" },
											{	"label": "Facebook", "icon": "splash/img/facebook_icon.gif",
												"goto": "//facebook.com/sharer/sharer.php?u=http://euscreen.eu/exhibitions.html?id=beingeuropean" }
											]
										}
								};
		
		/* history of european tv */
		
		var historyOfTv = {	"contextmenu" : "history of european television", "featured": false,
				"img": "splash/img/imgHistoryOfEuropeanTv.jpg",
				
				"overlay":"splash/img/EUscreen-logo.png",
				"overlay_class":"eu-screen-overlay",

				"name": "History of European Television",
				"title" : "History of European Television",
				"partner": {"site":"http://euscreen.eu/exhibitions.html?id=history", "label":"Open partner exhibition"},
				"menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif",
					"items":[
					        {	"label": "Twitter", "icon": "splash/img/twitter_icon.gif",
								"goto": "//twitter.com/intent/tweet?text=History of European Television: http://euscreen.eu/exhibitions.html?id=history" },
							{	"label": "Facebook", "icon": "splash/img/facebook_icon.gif",
								"goto": "//facebook.com/sharer/sharer.php?u=http://euscreen.eu/exhibitions.html?id=history" }
							]
						}
				};
		
		
		
		/* ski-jumping and winter sports */
		
			
		var winterSports = {
				"contextmenu" : "ski-jumping and winter sports",
				"featured": false,
				"img" : "splash/img/waterSports.jpg",
				"overlay":"splash/img/EUscreen-logo.png",
				"overlay_class":"eu-screen-overlay",
				"name": "Ski Jumping and Winter Sports",
				"title": "Ski Jumping and Winter Sports",				
				"partner": {"site":"http://euscreen.eu/exhibitions.html?id=skijumping", "label":"Open partner exhibition"},

				"menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif",
					"items":[
					        {	"label": "Twitter", "icon": "splash/img/twitter_icon.gif",
								"goto": "//twitter.com/intent/tweet?text=Ski-Jumping and Winter Sports: http://euscreen.eu/exhibitions.html?id=skijumping" },
							{	"label": "Facebook", "icon": "splash/img/facebook_icon.gif",
								"goto": "//facebook.com/sharer/sharer.php?u=http://euscreen.eu/exhibitions.html?id=skijumping" }
							]
						}
				};

		
		/* hungarian music and dance */

		var hungarianMusicAndDance = {
			"contextmenu" : "Hungarian Music and Dance",
			"featured": false,
			"img" : "splash/img/hungarianMusicAndDance.jpg",
			"overlay":"splash/img/EUscreen-logo.png",
			"overlay_class":"eu-screen-overlay",
			"name": "Hungarian Music and Dance",
			"title": "Hungarian Music and Dance",				
			"partner": {"site":"http://euscreen.eu/exhibitions.html?id=hungarianmusicanddance", "label":"Open partner exhibition"},

			"menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif",
				"items":[
				        {	"label": "Twitter", "icon": "splash/img/twitter_icon.gif",
							"goto": "//twitter.com/intent/tweet?text=Hungarian Music and Dance: http://euscreen.eu/exhibitions.html?id=hungarianmusicanddance" },
						{	"label": "Facebook", "icon": "splash/img/facebook_icon.gif",
							"goto": "//facebook.com/sharer/sharer.php?u=http://euscreen.eu/exhibitions.html?id=hungarianmusicanddance" }
						]
					}
			};

		
		
		/* the Euro */
		

		var theEuro = {
				"contextmenu" : "The Euro",
				"featured": false,
				"img" : "splash/img/theEuro.jpg",
				"overlay":"splash/img/EUscreen-logo.png",
				"overlay_class":"eu-screen-overlay",
				"name": "The Euro",
				"title": "The Euro",				
				"partner": {"site":"http://euscreen.eu/exhibitions.html?id=theeuro", "label":"Open partner exhibition"},

				"menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif",
					"items":[
					        {	"label": "Twitter", "icon": "splash/img/twitter_icon.gif",
								"goto": "//twitter.com/intent/tweet?text=The Euro: http://euscreen.eu/exhibitions.html?id=theeuro" },
							{	"label": "Facebook", "icon": "splash/img/facebook_icon.gif",
								"goto": "//facebook.com/sharer/sharer.php?u=http://euscreen.eu/exhibitions.html?id=theeuro" }
							]
						}
				};


		
		/* EUscreen Exhibitions */
		
		var euscreenExhibitions = {
				"contextmenu" : "EUscreen Exhibitions",
				"featured": false,
				"img" : "splash/img/otherExhibitions.jpg",
				"overlay":"splash/img/EUscreen-logo.png",
				"overlay_class":"eu-screen-overlay",
				"name": "EUscreen Exhibitions",
				"title": "EUscreen Exhibitions",				
				"partner": {"site":"http://euscreen.eu/exhibitions.html", "label":"Open partner exhibition"},

				"menu":{ "label" : "Share on...", "icon": "splash/img/share_icon.gif",
					"items":[
					        {	"label": "Twitter", "icon": "splash/img/twitter_icon.gif",
								"goto": "//twitter.com/intent/tweet?text=EUscreen Exhibitions: http://euscreen.eu/exhibitions.html" },
							{	"label": "Facebook", "icon": "splash/img/facebook_icon.gif",
								"goto": "//facebook.com/sharer/sharer.php?u=http://euscreen.eu/exhibitions.html" }
							]
						}
				};

		
		
		
		
		
		//  http://euscreen.eu/exhibitions.html?id=skijumping#.UHa5Hm8bdI4
			
			
			
		return [
			toMyPeoples,
			darwin,
			romeInFesta,
    			pnayki,
			firstWorldWar,
		        glam,
				migration,
				royalbookcollections,
		        sports,
		        nineteenfourteen,
		        wikiLoves,
		        weddings,
		        dada,
		        mimo,
		        yiddish,
		        nouveau,
			
			picasso,
		        winterSports,
		        hungarianMusicAndDance,
		        theEuro,

		        beingEuropean,
		        historyOfTv,
		        euscreenExhibitions,
		        
		        flyingMachines,
		        travelling,
		        reading,
		        roma,
		        napoleon,
		        treasures,
		        buildings,

		        athena,
		        
		        poisonousNature,
		        spices,
		        expeditions
		        ];
}();
