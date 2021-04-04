<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php 
include_once(USER_CLASS.'publicview.php');
$katha=new publicview(); 
include_once(USER_INCLUDES.'login_head_section.php');
$email=isset($_GET['email'])&&!empty($_GET['email'])?$_GET['email']:'';
$username=(isset($_SESSION['username'])&&!empty($_SESSION['username']))?$_SESSION['username']:'';
?>
<title>Update Profile</title>
</head>
<body>
<div class="image" >
<img src="<?php echo LOGO_URL.$katha->WebsiteLogo(); ?>"class="d-block mx-auto img-responsive " width="150" height= "150">
</div>
<h2 class="text-center text-white mt-3">Confirmation</h2>
<form class="login-form text-center text-white" action="" >
<h4><p>Success!!! <br>
Thank you <?php echo $username;?>. Your Profile has been successfully updated.</p>
<p>	We have sent an email to  your account <b><?php echo $email ?></b> to help you confirm this change. 
<p>You have to do nothing. <p>Please ignore the  email if you are sure that you are the real owner of this account.</p>	
</h4>
</form>	
</body>
</html>