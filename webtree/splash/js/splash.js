var eu_europeana_mortar = {

	container: null,
	
	globalElementWidth: 0,
	
	globalElementWidthLarge:0,

	calculateElementWidth: function(){

   		var noCols = 0;
    	var containerWidth = eu_europeana_mortar.container.width();

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
		this.isotopeInit();
	},



	//	Isotope script - isotope.metafizzy.co - for more information
	isotopeInit: function(){

		var $container = eu_europeana_mortar.container;

		try{
	        //$container.isotope('destroy');
		}
		catch(e){}
        
		/* Andy: the "1" setting seems to force isotope to calculate not on the 1st col (or row) width (or height), but to fit all spaces  */

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
		
		jQuery(window).bind('orientationchange',function(event){
			/* since ipad fires this event after the new window size has been calculated and galaxy does it before, a full refresh is needed. */
			//calculateElementWidth();
			window.location.reload();
		});
		
		
	},

	
	buildSection:function(definition){
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
		html +=			'<h2 class="name dark" ' + (definition.title ? 'title="' + definition.title + '"' : '') + '>' + definition.name + '</h2>';				
		html += 	'</td></tr></table>';
		html +=	'</div>';


		html += '<div class="languages">';
		html +=		'<table class="language-table"><tr><td>';

		if(definition.languages){	
			for(var i=0; i<definition.languages.length; i++){
				var language = definition.languages[i];
				html += '<h4 style="display:inline; font-weight:normal;"><a class="' + language.langClass + '" href="' + language.link + '">' + language.label + '</a></h4>';
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

		if(definition.menu){
			html += 		'<menu type="context" id="' + definition.contextmenu + '">';
			html += 			'<menu label="' + definition.menu.label + '" icon="' + definition.menu.icon + '">';
	
			for(var i=0; i<definition.menu.items.length; i++){
				var item = definition.menu.items[i];
				html +=				'<menuitem label="' + item.label + '" icon="' + item.icon + '" onclick="goTo(\'' + item.goto + '\')">';
				html +=				'</menuitem>';
			}
	
			html += 			'</menu>';
			html += 		'</menu>';
		}
	
		html += 	'</div>';
		html += '</div>';
		jQuery(eu_europeana_mortar.container).append(html);
	},
	
	goTo:function(url) { window.open(url, "shareWindow"); },

	
	init:function(data, containerSelector){
		
		eu_europeana_mortar.container = jQuery(containerSelector);
		
		eu_europeana_mortar.container.delegate( '.element', 'click', function(){			
			jQuery(this).toggleClass('large');
			
			if(jQuery(this).hasClass('large')){
				jQuery(this).css("width", globalElementWidthLarge + "px");
				jQuery(this).css("height", globalElementWidthLarge + "px");
			}
			else{
				jQuery(this).css("width", globalElementWidth + "px");
				jQuery(this).css("height", globalElementWidth + "px");
			}
			eu_europeana_mortar.container.isotope('reLayout');
		});
		
		eu_europeana_mortar.container.html(""); // clear non-js seo stuff
		
		for(var i=0; i<data.length; i++){
			this.buildSection(data[i]);
		}
		
		this.calculateElementWidth();
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
	},

};



