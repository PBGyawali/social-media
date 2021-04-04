<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php include_once(USER_CLASS.'publicview.php');?>
<?php $katha=new publicview(); ?>
<?php include_once ( USER_SERVER . 'main_server.php'); ?>
<?php include_once ( USER_INCLUDES . 'minimal_header.php') ?>
	<title>Accounnt verify</title>
	<link rel="stylesheet" href="<?=CSS_URL?>outside_login.css">
</head>
<body><div class="bigtext">Welcome to "<?php echo $katha->WebsiteName(); ?>"</div>
  <div class="image" ></div>
  <div class="container">
    <div class="header">  	
      <h2>Verify account</h2>
  </div>
	<form class="verify-form" action="verify_account.php" method="post">
	<?php include_once(USER_INCLUDES.'new_message.php');?>		
	</form>
	</div>
</body>
</html>