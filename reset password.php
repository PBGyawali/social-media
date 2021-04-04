<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php include_once(USER_CLASS.'publicview.php');?>
<?php $katha=new publicview(); ?>
<?php include_once(USER_SERVER.'main_server.php');

 ?>
 <?php include_once(USER_INCLUDES.'new_message.php');?>
<?php include_once(USER_INCLUDES.'minimal_header.php') ?> 
	<link rel="stylesheet" href="<?CSS_URL?>outside_login.css">
</head>
<body>
<div class="bigtext">
Welcome to "<?php echo $katha->get_data('website_name','website_data'); ?>"
</div>
<div class="image" >
</div><div class="container">
  <div class="header">
  	<h2>Reset password</h2>
  </div>
	<form action="reset password.php" method="post">
		<!-- form validation messages -->
		<?php displaymessage();?>
		<div class="input-group">
  	  <label>Email</label>
  	  <input type="email" name="email" value="">
  	</div><br>
		<div class="input-group">
			<button type="submit" name="reset-password" class="btn">Submit</button>
			<button type="reset" name="reset-" class="btn">Reset</button>
		</div>
		<br>
      Go to <a href="login.php">Sign in</a> or return to  <a href="index.php">Homepage</a>
  	
	</form>
	<div>
</body>
</html>