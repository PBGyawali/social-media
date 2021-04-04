<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php 
include_once(USER_CLASS.'publicview.php');
$katha=new publicview(); 
include_once(USER_INCLUDES.'login_head_section.php');
?>
<meta http-equiv="refresh" content="15; url='<?php echo BASE_URL.'#login'?>" />
	<title>Confirmation</title>
</head>
<body>
<div class="bigtext">
"Welcome to <?php echo $katha->Websitename(); ?>"
</div>
<div class="image" >
<img src="<?php echo LOGO_URL.$katha->WebsiteLogo(); ?>"class="d-block mx-auto img-responsive " width="150" height= "150">
</div>
  <div class="header">
  <h2 class="text-center text-white mt-3">Confirmation</h2>
  </div>
  <form class="login-form text-center text-white" action="" >
		<p><h1>Success!!!</h1> <br>
			Thank you <?php echo $_SESSION['username'];?>. Your Account has been successfully registered.</p>
		<p>	We have sent an email to your account <b><?php echo $_SESSION['email'];?></b> to help you confirm this registration. 
		</p>
		<p>Please follow the link in your confirmation email to confirm this registration and you are good to go.</p>
		<br>
		<p>	Return to  <a href="<?php echo BASE_URL.'#login'?>">Login</a></p>
	</form>
	<?php session_destroy();?>
	
</body>
</html>