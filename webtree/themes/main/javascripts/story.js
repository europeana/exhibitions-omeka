
var viewer;
var ajaxUrl;

function onZoomitResponse(resp) {
	if(resp.error){
		return;
	}
	
	var content = resp.content;
	if(content.ready){
		


		var tmpImg = jQuery('#zoomit_dimensioned_wrapper img.tmp-img'); // scale viewport to placeholder image
		if(tmpImg.width()>0 && tmpImg.height() > 0){
			jQuery("#zoomit_window").height(tmpImg.height());				
			jQuery("#zoomit_window").width(tmpImg.width());			
		}
		else{ // scale viewport according to calculation
			var maxHeight = jQuery("#items").height();
			var height = content.dzi.height < maxHeight ? content.dzi.height : maxHeight;
			var width = content.dzi.width / (content.dzi.height / height);

			jQuery("#zoomit_window").height(height);				
			jQuery("#zoomit_window").width(width);			
		}
		if(!viewer){
			
			viewer = new Seadragon.Viewer("zoomit_window");
			viewer.setVisible(false);
			 
		}
		
		Seadragon.Config.animationTime = 0;
		Seadragon.Config.blendTime = 0;

		viewer.openDzi(content.dzi);
		
		
			tmpImg.remove();	// hide temp image
			viewer.setVisible(true);
			jQuery('#zoomit_window').show();

		var restoreAnimation = function(){
			Seadragon.Config.animationTime = 1.5;
			Seadragon.Config.blendTime = 0.5;
		}
		setTimeout(restoreAnimation, 500);
		
	}
	else if(content.failed){
		//alert(content.url + " failed to convert.");
	}
	else{
		var poll = function(){
			jQuery.ajax({
				url: ajaxUrl,
				dataType: "jsonp",
				success: onZoomitResponse
			});
		}
		setTimeout(poll, 1000);
		
	}
}



function initZoomit(){
	imgUrl = imgUrl.replace("http://127.0.0.1/ombad/webtree/", "http://test.exhibit.eanadev.org/");	// TODO remove this before going live - allows zoomit to work on localhost
	imgUrl = imgUrl.replace("http://localhost/webtree/", "http://test.exhibit.eanadev.org/");	// TODO remove this before going live - allows zoomit to work on localhost
    
	jQuery.ajax({
		url: "http://api.zoom.it/v1/content/?url=" + encodeURIComponent(imgUrl),
		dataType: "jsonp",
		success: function(resp){
			onZoomitResponse(resp);
		}
	});
    switchMediaElement();
};

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

        		jQuery('#zoomit_dimensioned_wrapper img.tmp-img').remove();	// hide temp image
           		jQuery('#zoomit_dimensioned_wrapper').append('<img src="' + newObjSrc + '" class="tmp-img"/>');
           		jQuery('#exhibit-item-title-only h4').html(newObjTitle);
           		jQuery('#zoomit_window').hide();
            	
           		if(viewer){
           			viewer.setVisible(false);
        			Seadragon.Config.animationTime = 0;
        			Seadragon.Config.blendTime = 0;
           		}
           		
               	newObjSrc = newObjSrc.replace("http://127.0.0.1/ombad/webtree/", "http://test.exhibit.eanadev.org/"); // TODO remove this before going live - allows zoomit to work on localhost
               	newObjSrc = newObjSrc.replace("http://localhost/webtree/", "http://test.exhibit.eanadev.org/"); // TODO remove this before going live - allows zoomit to work on localhost
               	http://localhost/webtree/
               	ajaxUrl = "http://api.zoom.it/v1/content/?url=" + encodeURIComponent(newObjSrc);

               	jQuery.ajax({
               		url: ajaxUrl,
               		dataType: "jsonp",
               		success: onZoomitResponse
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