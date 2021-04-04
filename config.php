<?php
    /* Database credentials.  */
    define('DB_SERVER', 'localhost');
    define('DB_USERNAME', 'root');
    define('DB_PASSWORD', 'root');
    define('DB_NAME', 'social_media');
 
    date_default_timezone_set("Europe/Berlin");

     // define global constants
    define("BASE_URL", "http://localhost/social_media/"); //defines the base url to start from in the server
    define("UPLOAD_URL", BASE_URL."uploads/");
    define("ADMIN_URL", BASE_URL."admin/");
    define("ADMIN_SERVER_URL", ADMIN_URL."server/");
    define("USER_SERVER_URL", BASE_URL."server/");    
    define("ASSETS_URL", BASE_URL."static/");
    define("CSS_URL", ASSETS_URL."css/");
    define("JS_URL", ASSETS_URL."jscripts/");
    define("IMAGES_URL", ASSETS_URL."images/");
    define("ICONS_URL", IMAGES_URL."icons/");
    define("USER_IMAGES_URL", IMAGES_URL."user_images/");
    define("BACKGROUNDS_URL", IMAGES_URL."backgrounds/");
    define("POST_IMAGES_URL", IMAGES_URL."post_images/");
    define("LOGO_URL", IMAGES_URL."logo/");
    define("FONTS_URL", ASSETS_URL."fonts/");
    define("PLUGINS_URL", ASSETS_URL."plugins/");

    define ("ROOT_PATH", realpath(dirname(__FILE__))); //starts the path from where the config.php file is located
    define ("BASE_PATH",ROOT_PATH."/");
    define("ERROR_LOG", BASE_PATH."errorcatching/error.log");  
    define("CLASS_DIR", BASE_PATH."class/");
    define("USER_CLASS", BASE_PATH."class/");
    define("ADMIN_CLASS", BASE_PATH."class/");
    define("ADMIN_DIR", BASE_PATH."admin/");
    define("ADMIN_INCLUDES", ADMIN_DIR."includes/");
    define("USER_INCLUDES", BASE_PATH."includes/");
    define("ADMIN_SERVER", ADMIN_DIR."server/");
    define("USER_SERVER", BASE_PATH."server/");
    define('UPLOAD_DIR', BASE_PATH."uploads");
    define("ASSETS_DIR", BASE_PATH."static/");
    define("CSS_DIR", ASSETS_DIR."css/");
    define("JS_DIR", ASSETS_DIR."jscripts/");
    define("IMAGES_DIR", ASSETS_DIR."images/");   
    define("PLUGINS_DIR", ASSETS_DIR."plugins/");
    define('USER_IMAGES_DIR', IMAGES_DIR."user_images/");
    define("POST_IMAGES_DIR", IMAGES_DIR."post_images/");
    define("LOGO_DIR", IMAGES_DIR."logo/");
    define("FONTS_DIR", ASSETS_DIR."fonts/");	

    define("ALLOWED_IMAGES", array("jpg", "jpeg", "png", "gif", "bmp"));
    define("ALLOWED_DOC", array("pdf", "doc", "docx", "ppt", "pptx","xls"));
    define("ALLOWED_FILES",array_merge(ALLOWED_IMAGES,ALLOWED_DOC)); 
    define("ATTEMPTS_NUMBER", "3");   //login attempts - 3 
    define("TIME_PERIOD", "10");//10 minutes    
    define("COOKIE_EXPIRE", 60*60*24*30); //30 days
    define("COOKIE_PATH", "/");  
    define("SITE_NAME", "hamro katha");
   

    $page=$page_name = pathinfo($_SERVER['PHP_SELF'], PATHINFO_FILENAME);

?>