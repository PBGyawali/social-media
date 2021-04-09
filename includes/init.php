<?php  
error_reporting(E_ALL);
ini_set('display_errors', 1);
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/config.php'); 
spl_autoload_register(function($class_name){
    include_once(CLASS_DIR.$class_name.".php");     
});
$file=new file();
$method=new method();
$check=new check();
?>