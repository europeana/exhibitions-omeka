<?php head(); ?>

<div id="primary" class="grid_16">

<h1><?php echo ve_translate('contact-us-title', 'Contact Us') ?></h1>

<div id="simple-contact">
	<div id="form-instructions">
		<?php echo ve_translate('contact-us-instructions', 'Please send us your comments and suggestions.') ?>
	</div>
	<?php echo flash(); ?>
	<form name="contact_form" id="contact-form"  method="post" enctype="multipart/form-data" accept-charset="utf-8">
        
        <fieldset>
            
        <div class="field">
		<?php 
		    echo $this->formLabel('name', ve_translate('contact-us-label-name', 'Your Name') . ': ');
		    echo $this->formText('name', $name, array('class'=>'textinput')); ?>
		</div>
		
        <div class="field">
            <?php 
            echo $this->formLabel('email', ve_translate('contact-us-label-email', 'Your Email') . ': ');
		    echo $this->formText('email', $email, array('class'=>'textinput'));  ?>
        </div>
        
		<div class="field">
		  <?php 
		    echo $this->formLabel('message', ve_translate('contact-us-label-message', 'Your Message') . ': ');
		    echo $this->formTextarea('message', $message, array('class'=>'textinput')); ?>
		</div>    
		
		</fieldset>
		
		<fieldset>
		    
		<div class="field">
		  <?php echo $captcha; ?>
		</div>		
		
		<div class="field">
		  <?php echo $this->formSubmit('send', ve_translate('contact-us-button-send', 'Send Message')); ?>
		</div>
	    
	    </fieldset>
	</form>
</div>

</div>
<?php foot(); ?>