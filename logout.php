<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$katha=new publicview();
if (session_status() === PHP_SESSION_NONE)
session_start();
if ($katha->is_user())
        $id= $_SESSION["id"];
// Unset all of the session variables
$_SESSION = array();

if ((isset($id)) &&!empty($id)){ 
        $katha-> UpdateDataColumn('userlogs','last_logout',$katha->get_datetime(),'user_id',$id);
        $katha-> activitylogs($id, 'You logged out from your','logout','profile');
        $katha->Delete('activity_log',array( ' activity_performed < (NOW() - INTERVAL 30 DAY) ',' user_id='.$id,));
}
// Destroy the session.
session_destroy();
// Redirect to login page
header("location:".BASE_URL."#login");
exit;
?>
