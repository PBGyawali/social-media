<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_SERVER.'main_server.php');
$company=$katha->get_data(array('website_logo','website_name'),'website_data');
$website_name=$company['website_name'];
$website_logo=$company['website_logo']; 
include_once(USER_INCLUDES.'new_message.php');
include_once(USER_INCLUDES.'minimal_header.php');
?>	
<link rel="stylesheet" href="<?=CSS_URL?>outside_login.css">
<title><?= $website_name; ?></title>
</head>
<body>
<?php include_once(INCLUDES.'main_menu_top.php')?>
  <div class="container">
    <div class="header">  	
      <h2>Verify account</h2>
  </div>
	<form class="verify-form" action="verify_account.php" method="post">
	<?php displaymessage();?>		
	</form>
	</div>
</body>
</html>