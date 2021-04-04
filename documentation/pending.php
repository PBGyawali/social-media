<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php include_once(USER_CLASS.'publicview.php');?>
<?php $katha=new publicview(); 
$email=isset($_GET['email'])&&!empty($_GET['email'])?$_GET['email']:'';
$username=(isset($_SESSION['username'])&&!empty($_SESSION['username']))?$_SESSION['username']:'';
include_once(USER_INCLUDES.'login_head_section.php');
?>
<title>Pending Confirmation</title>
</head>
<body>
<div class="bigtext">
"Welcome to <?php echo $katha->Websitename(); ?>"
</div>
<div class="image" >
<img src="<?php echo LOGO_URL.$katha->WebsiteLogo(); ?>"class="d-block mx-auto img-responsive " width="150" height= "150">
</div>
<div class="container container-fluid">
  <div class="header">
  <h2 class="text-center text-white mt-3">Confirmation</h2>
  </div>
  <form class="login-form text-center text-white" action="" >
		<h4>

		<p>	We sent an email to  your account <b><?php echo $email ?></b> to help you recover your account.</p>
		</h4>
			<h3> <strong><u>Next step:</u> </strong> </h3> 	
			<h4>
			<p>Please login into your email account and click on the link sent to your email to reset your password</p>

			</h4>	   

	
<p> Go to <a href="<?php echo BASE_URL.'#login'?>">Sign in</a> or return to  <a href="<?php echo BASE_URL?>">Homepage</a></p>
	</form>
	<div>
</body>
</html>