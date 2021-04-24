<?php  
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_SERVER.'main_server.php');
//if($katha->is_admin())$katha->redirect(ADMIN_URL);
//elseif ($katha->is_user())$katha->redirect(BASE_URL.'home.php');
//else{
  $company=$katha->get_data(array('website_logo','website_name'),'website_data');
  $website_name=$company['website_name'];
  $website_logo=$company['website_logo'];
 include_once(INCLUDES.'login_head_section.php');
 include_once(INCLUDES.'new_message.php');
//}
?>
<title><?= $website_name; ?></title>
<style>#login_container,#register_container,#reset_password_container,#conditions_container{display:none;}</style>
</head>	
<?php include_once(INCLUDES.'main_menu_top.php')?>
<?php include_once(INCLUDES.'homepage_container.php')?>
<?php include_once(INCLUDES.'login_container.php')?>
<?php include_once(INCLUDES.'register_container.php')?>
<?php include_once(INCLUDES.'reset_container.php')?>
<?php include_once(INCLUDES.'conditions_container.php')?>
<?php include_once(INCLUDES.'login_footer.php') ?>