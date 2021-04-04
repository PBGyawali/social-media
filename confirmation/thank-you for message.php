<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php
include_once(USER_CLASS.'publicview.php');
$katha=new publicview(); 
include_once(USER_INCLUDES.'login_head_section.php');
include_once(USER_INCLUDES.'sidebar.php'); ?>
<?php
$username=$_POST['username'];
$email=$_POST['email'];
$to='prakhar2015@kcm.edu.np';
$subject='new message';
mail($to,$subject,"From:".$username);
?>
<title>Thank you!</title>     
</head>
<body>
<h2 class="text-center text-white"><p>Thank you sir/madam for your 
time to send us the message.</p>We will reply you back as soon as possible :)</h2>

</body>
</html>
