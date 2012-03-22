<?php //head(array('title' => item('Dublin Core', 'Title'),'bodyid'=>'items','bodyclass' => 'show item')); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<style type="text/css">
html, body {
    margin: 0;
    padding: 0;
     background: #4b4b4d;
    font: 13px/1.5 Helvetica, Arial, 'Liberation Sans', FreeSans, sans-serif;
}
#pop-main {
    width: 600px;
    margin: 0 auto;
    text-align: center;
}
#image-full img {
    max-height: 500px;
}
#data {
    text-align: left;
    font-size: small;
    color: #e3d6b6;
}

#data h2 {font-size: 1em; display: none;}
#data h3 {margin: .5em 0 0 0; color: #fff; font-size: 1em;}
#data .element {margin: 0 0 .25em .25em; }
#data .element a:link,
#data .element a:visited{
    color:#aaa391;
}
#data em {float: left;}
</style>
</head>
<body>

<div id="pop-main">

    <div id="image-full">
        <?php if (item_fullsize()){echo item_fullsize();} ?>
    </div>

    <div id="data">
        <?php echo show_item_metadata(); ?>
    </div>

</div>
<?php //echo js('jquery');?>
<!--<script type="text/javascript">-->
<!--    $(document).ready(function(i) {-->
<!--        $("div#data h3").each(function(){-->
<!--            $(this).replaceWith("<em>"+$(this).html()+"</em>");-->
<!--        })-->
<!--    });-->
<!--</script>-->
</body>
</html>




