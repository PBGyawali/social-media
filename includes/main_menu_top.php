<div class="bigtext">
Welcome to "<?= $website_name; ?>"

</div>
<div class="image" >
  <img src="<?php echo LOGO_URL.$website_logo; ?>"class="image js-tilt">
  
</div>
<span class="position-absolute text-center w-100"id="message" style="z-index:10;"><?php repeatmessage();?></span>