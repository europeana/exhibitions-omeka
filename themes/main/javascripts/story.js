

jQuery(document).ready(function() {

    switchMediaElement();


});

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

        // CLICK THE THUMBNAIL !!
        jQuery(this).click(function() {
            var mediaURI = jQuery(this).find('img:first').attr('accesskey');
            var zoomitURI = jQuery(this).next('input.zoomit').first().val();

            var regexAudio = /^audio/;
            var regexVideo = /^video/;
            var regexImage = /^image/;
            if (mimeType.match(regexImage)) {

                if (zoomitURI) {
                    jQuery('div#in-focus').html('');
                    jQuery('div#in-focus').css('height','400px');
                    log.info(zoomitURI);
                    log.info("http://api.zoom.it/v1/content/" + zoomitURI);
                    jQuery.ajax({
                        url: "http://api.zoom.it/v1/content/" + zoomitURI,
                        type: "GET",
                        dataType: "jsonp",
                        success: function(resp){
                            log.info(resp.content.id);
                            viewer = null;
                            viewer = new Seadragon.Viewer("in-focus");
                            viewer.openDzi(resp.content.dzi);
//                            Seadragon.Utils.cancelEvent(event);
                        },
                        error: function(error){
                            return false;
                        }
                    });
                } else {
                    jQuery('div#in-focus').html('<img src="' + newObjSrc + '" class="full"/>');
                }

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