
<?php
setcookie("ve_lang", "en", time()+3600, "/");
$endpoint = uri('exhibits/browse');
?>
<h1 class="grid_16">Virtual Exhibitions</h1>
<div id="exhibit-providers">
<div class="grid_4">
<a href="<?php echo $endpoint; ?>?tags=europeana-en" >
<?php echo ve_get_provider_logo('logo-europeana.png'); ?>
</a>
<h2>
<a href="<?php echo $endpoint; ?>?tags=europeana-en" 
class="widget">Europeana</a>
</h2>
<p>Exhibitions curated by Europeana.</p>
</div>

<div class="grid_4">
<a href="<?php echo $endpoint; ?>?tags=judaica-en" >
<?php echo ve_get_provider_logo('logo-europeana-judaica.png'); ?>
</a>
<h2><a href="<?php echo $endpoint; ?>?tags=judaica-en" class="widget">Judaica Europeana</a></h2>
<p>Exhibitions from the <a href="http://www.judaica-europeana.eu/" target="_blank" title="Click here to visit the Judaica Europeana website">Judaica Europeana<a> partners' collections.</p>
</div>

<div class="grid_4">
<a href="<?php echo $endpoint; ?>?tags=mimo-en" >
<?php echo ve_get_provider_logo('logo-mimo.png'); ?>
</a>
<h2><a href="<?php echo $endpoint; ?>?tags=mimo-en" class="widget">MIMO</a></h2>
<p>An exhibition from the MIMO project, drawn from the collections from nine of Europe's major musical instrument museums.</p>
</div>

<div class="grid_4">
<a href="<?php echo $endpoint; ?>?tags=weddings-eastern-en" >
<?php echo ve_get_provider_logo('logo-connect.png'); ?>
</a>
<h2><a href="<?php echo $endpoint; ?>?tags=weddings-eastern-en" class="widget">Europeana Connect</a></h2>
<p>Cultural treasures preserved in the sound archives of Hungary, Lithuania, Poland and Slovenia provide a fascinating look view at vanishing wedding traditions and rituals in Eastern Europe.</p>
</div>

</div>

<div class="clear"></div>
<?php foot(); ?>