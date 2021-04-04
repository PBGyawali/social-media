<?php 
if (session_status() === PHP_SESSION_NONE)
{session_start();}?> 
<?php if ($check->is_admin()) :?> 
   <?php echo BASE_URL.'admin/'?>
<?php   elseif ($check->is_user()):?>
  <?php echo BASE_URL.'home'?>
<?php   elseif ($check->is_login()):?>
  <?php echo BASE_URL.'welcome'?>
<?php  else:?>
      <?php echo BASE_URL?>
 <?php  endif?>
 