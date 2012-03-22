var itemIndex = 0;
function switchStoryImage() {
    var srcItemHref = $('div.exhibit-item a#img-large');
    var srcItemImg = $('div.exhibit-item img.full');
    var srcItemTitle =  $('div.exhibit-item div.title p');
    $('div.exhibit-item a').each(function(i) {
        // skip the first one, as this is the large image we want to manipulate
        if (i > 0) {
            $(this).attr('name','exhibit-item-metadata-'+(i));

            $(this).click(function() {
                    $('img#hidedata').die("click");
                // change the itemIndex for the overlay;
                itemIndex = i-1;
                // hide the slide out information if present
                $('div.exhibit-item-metadata').hide();
                // set attributes for new 'in-focus' image
                var newItemImg = $(this).find('img:first').attr('src').replace('square_thumbnail', 'fullsize');
                var newItemHref = $(this).attr('href');
                var newItemName = $(this).attr('name');
                var newItemTitle = $(this).find('img:first').attr('alt');

                srcItemImg.attr('src', newItemImg);
                srcItemHref.attr('href', newItemHref);
                srcItemHref.attr('name', newItemName);
                srcItemMetadataLink.attr('href', newItemHref);
                srcItemMetadataLink.attr('name',newItemName);
                srcItemTitle.html(newItemTitle);
                return false;
            })
        }
    });
    // tell the info link which info block to show
    var srcItemMetadataLink = $('div#exhibit-item-link a');
    srcItemMetadataLink.click(function() {
       dataToShow = $(this).attr('name');
       $('div#'+dataToShow).show('slow');
       $('div#'+dataToShow).css('display','block');
       return false;
    });
    // add hide functionality to the info block's info button

    $('img.hidedata').click(function(){

        $('div#'+dataToShow).hide('slow');
//        $('div#'+dataToShow).css('display','none');
    });
}


function setLanguage(lang){
    $.cookie('ve_lang', lang, 7);
    document.location.href=document.location.href;
}
