var story = function() {

	var viewer;
	var zoomitAjaxUrl = "";
	var zoomitAjaxUrlPrefix = "http://api.zoom.it/v1/content/?url=";
	var tmpImg;
	var zoomitWindow = jQuery("#zoomit_window");
	
	// public 
	return{
		initZoomit: function (initialUrl){
			
			tmpImg = jQuery('#media_wrapper img.tmp-img');
			switchMediaElement();
			var firstThumbnail = jQuery('div#exhibit-item-thumbnails div.exhibit-item a.thumb');
			if(firstThumbnail.length > 0){
				firstThumbnail[0].click();
			}
			else{
				zoomitAjaxUrl = initialUrl;
				zoomitAjaxUrl = zoomitAjaxUrl.replace("http://127.0.0.1/ombad/webtree/", "http://test.exhibit.eanadev.org/"); // TODO remove this before going live - allows zoomit to work on localhost
				zoomitAjaxUrl = zoomitAjaxUrl.replace("http://localhost/webtree/", "http://test.exhibit.eanadev.org/"); // TODO remove this before going live - allows zoomit to work on localhost
		       	zoomitAjaxUrl = zoomitAjaxUrlPrefix + encodeURIComponent(zoomitAjaxUrl);
				poll();
			}
		}
	};

	function poll(){
		jQuery.ajax({
			url: zoomitAjaxUrl,
			dataType: "jsonp",
			success: onZoomitResponse
		});			
	}

	function log(msg){
		if(console){
			console.log(msg);
		}
	}
	
	function showTmpImg(){
		if(viewer){
			zoomitWindow.css("display", "none");
		}
		tmpImg.css("display", "block");
		tmpImg.css("visibility", "visible");
	};

	function hideTmpImg(remove){
		if(remove){
			tmpImg.css("display", "none");		// we don't really "remove" it, just put it out of sight
		}
		tmpImg.css("visibility", "hidden");
		if(viewer){
			zoomitWindow.css("display", "block");
		}
	};

	
	function onZoomitResponse(resp) {
		
		if(resp.error){
			showTmpImg(true);
			return;
		}
		
		var content = resp.content;
	
		if(content.ready){
			log("content.ready");
	
			var width	= 0;
			var height	= 0;
			
			if(tmpImg.width()>0 && tmpImg.height() > 0){
				
				log("get dimension from tmp-img ");
				
				showTmpImg(); // needed for valid calculation
				height	= tmpImg.height();
				width	= tmpImg.width();
			}
			else{ // scale viewport according to calculation
				
				log("get dimension from calculation");
	
				var maxHeight = jQuery("#items").height();
				height = content.dzi.height < maxHeight ? content.dzi.height : maxHeight;
				width = content.dzi.width / (content.dzi.height / height);
			}
			
			zoomitWindow.height(height);				
			zoomitWindow.width(width);
	
			if(!viewer){
				viewer = new Seadragon.Viewer(zoomitWindow[0]);
			}
			
			Seadragon.Config.autoHideControls = false;
			viewer.addEventListener("open",
				function(){
					viewer.viewport.goHome();	
				}
			);
			viewer.openDzi(content.dzi);
			hideTmpImg(true);
		}
		else if(content.failed){
			showTmpImg();
		}
		else{
			showTmpImg();
			log(Math.round(100 * content.progress) + "% done.");
			setTimeout(poll, 1500);
		}
	}




	function switchMediaElement() {
	    jQuery('div#exhibit-item-thumbnails div.exhibit-item a.thumb').each(function(index) {
	    	
	        //VALUES
	        var mimeType = jQuery(this).find('img:first').attr('rel');
	        var newObjHref = jQuery(this).attr('href');
	        var newObjSrc = jQuery(this).find('img:first').attr('src').replace('square_thumbnails', 'fullsize');
	        var newObjTitle = jQuery(this).find('img:first').attr('alt');
	        var newZoomURI = jQuery(this).next('input.zoomit').first().val();
	
	        // PLACEHOLDERS
	        var targetObjHref = jQuery('a#info-link');
	        var targetObjTitle = jQuery('div#exhibit-item-title h4');
	        var targetZoomitHref = jQuery('div#in-focus');
	
	        
	        
	        // CLICK THE THUMBNAIL
	        jQuery(this).click(function() {
	        	
	            var mediaURI = jQuery(this).find('img:first').attr('accesskey');
	            
	            var regexAudio = /^audio/;
	            var regexVideo = /^video/;
	            var regexImage = /^image/;
	            if (mimeType.match(regexImage)) { // all images a zoomit-able
	
	               	newObjSrc = newObjSrc.replace("http://127.0.0.1/ombad/webtree/", "http://test.exhibit.eanadev.org/"); // TODO remove this before going live - allows zoomit to work on localhost
	               	newObjSrc = newObjSrc.replace("http://localhost/webtree/", "http://test.exhibit.eanadev.org/"); // TODO remove this before going live - allows zoomit to work on localhost
	
	           		jQuery('#exhibit-item-title-only h4').html(newObjTitle);
		
	               	zoomitAjaxUrl = zoomitAjaxUrlPrefix + encodeURIComponent(newObjSrc);

	        		tmpImg.attr("src", newObjSrc).load(function() {
	        			poll();
	               	});  
	
	            }
	            if (mimeType.match(regexAudio)) {
	                jQuery('div#in-focus').html('<audio  controls="controls"  type="audio/mp3" src="' + mediaURI + '"></audio>');
	                jQuery('div#in-focus audio').mediaelementplayer({
	                    enableAutosize: true,
	                    // if the <video width> is not specified, this is the default
	                    defaultVideoWidth: 460,
	                    // if the <video height> is not specified, this is the default
	                    defaultVideoHeight: 270,
	                    // if set, overrides <video width>
	                    videoWidth: -1,
	                    // if set, overrides <video height>
	                    videoHeight: -1,
	                    // width of audio player
	                    audioWidth: 460,
	                    // height of audio player
	                    audioHeight: 84,
	                    plugins: ['flash','silverlight'],
	                    // the order of controls you want on the control bar (and other plugins below)
	                    features: ['playpause','progress','current','duration','volume','fullscreen']
	                });
	            }
	            if (mimeType.match(regexVideo)) {
	                jQuery('div#in-focus').html('<video controls="controls" src="' + mediaURI + '"></video>');
	                jQuery('div#in-focus video').mediaelementplayer({
	                    enableAutosize: true,
	                    // if the <video width> is not specified, this is the default
	                    defaultVideoWidth: 460,
	                    // if the <video height> is not specified, this is the default
	                    defaultVideoHeight: 270,
	                    // if set, overrides <video width>
	                    videoWidth: -1,
	                    // if set, overrides <video height>
	                    videoHeight: -1,
	                    // width of audio player
	                    audioWidth: 460,
	                    // height of audio player
	                    audioHeight: 84,
	                    plugins: ['flash','silverlight'],
	                    // the order of controls you want on the control bar (and other plugins below)
	                    features: ['playpause','progress','current','duration','volume','fullscreen']
	                });
	            }
	            // Replace the url for the link to the item page
	            targetObjHref.attr('href', newObjHref);
	            // Replace the title
	            targetObjTitle.html(newObjTitle);
	            // Don't follow the hyperlink, just execute the above code
	            
	            return false;
	        });
	    });
	}

}();
