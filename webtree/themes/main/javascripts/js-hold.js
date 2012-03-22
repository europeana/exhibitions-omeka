    jQuery(document).ready(function() {

        jQuery('div#exhibit-item-thumbnails div.exhibit-item a.thumb').each(function(index) {

            var mimeType = jQuery(this).find('img:first').attr('rel');
            // Get new element values to replace the target object values
            var newObjHref = jQuery(this).attr('href');
            var newObjSrc = jQuery(this).find('img:first').attr('src').replace('square_thumbnails', 'fullsize');
            var newObjTitle = jQuery(this).find('img:first').attr('alt');
            // Get placeholders for hyperlink and title
            var targetObjHref = jQuery('div.exhibit-item a#img-large');
            var targetObjTitle = jQuery('div.exhibit-item div.title p');
            jQuery(this).click(function() {
                if (mimeType == 'image') {
                    // Is there an existing image element to replace?
                    // Yes there is!  Lets replace its attribute values
                    if (jQuery('div#in-focus.image').length > 0) {
                        // switch image attributes
                        // Get targetObject element values
                        var targetObj = jQuery('div.exhibit-item img.full');
                        // Replace target object values with new values
                        targetObj.attr('src', newObjSrc);
                    }
                    // No there is not. Lets create one!
                    else {
                        // create image object
                        jQuery('div#in-focus').removeClass('player').addClass('image').html('<img src="' + newObjSrc + '" class="full"/>');
                    }
                    return false;
                }
                else {

                    if (jQuery('div#in-focus.player').length > 0) {
                        // switch player attributes
                        alert("player exists");
                        var mediaURI = jQuery(this).find('img:first').attr('accesskey');
                         createPlayer(mediaURI, mimeType);
                        return false;
                    }
                    else {
                        // create player object
                        alert("create player");
                        jQuery('div#in-focus').removeClass('image').addClass('player');
                        var mediaURI = jQuery(this).find('img:first').attr('accesskey');
                        createPlayer(mediaURI, mimeType);
                        return false;
                    }
                    return false;
                }
                // Replace the url for the link to the item page
                targetObjHref.attr('href', newObjHref);
                // Replace the title
                targetObjTitle.html(newObjTitle);
                return false;
            })
        });
        return false;
    });


function createPlayer(dataSrc, mimeType) {
    var objectString = '\
    <object classid="clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B" codebase="http://www.apple.com/qtactivex/qtplugin.cab" width="200" height="20"> \
        <param name="src" value="' + dataSrc + '" /> \
        <param name="controller" value="true" /> \
        <param name="autoplay" value="false" /> \
        <param name="loop" value="false" /> \
        <object type="' + mimeType + '" data="' + dataSrc + '" width="200" height="20" autoplay="false"> \
        <param name="src" value="'+dataSrc+'" /> \
        <param name="controller" value="true" /> \
        <param name="autoplay" value="false" /> \
        <param name="autostart" value="0" /> \
        <param name="loop" value="false" /> \
        </object> \
        </object>';
    jQuery('div#in-focus').html(objectString);
    return false;
}