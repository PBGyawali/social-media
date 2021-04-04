<?php  
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$stats = new stats();
$records = new records();
if (isset ($_POST['postviews'])){    
    $post_id=$stats->clean_input($_POST['post_id']);
    $userid=$stats->clean_input($_POST['user_id']);
    $browser=$stats->clean_input($_POST['browser']);
    $views=updatePostviews($post_id,$userid,$browser);
    if($views)
   echo json_encode($views);
}
if (isset($_POST['get_full_data'])) {
    $stats->show_full_month_chart();	
}
if (isset($_POST['message'])) {
    $records->message($_POST);	
}
if (isset($_POST['user_message'])) {
    $records->user_message($_POST);	
}
if (isset($_POST['request'])) {
    $records->request($_POST);	
}
if (isset($_POST['delete-message'])) {
    $records->delete_message($_POST);	
}
function updatePostviews($post_id,$userid,$browser)
{		global $stats;				
   // is post visitor unique for this session? If not, increase counter value by one
       if(!isset($_SESSION['page='.$post_id]))
           {
               $counter_value =$stats-> get_data('views','posts','id='.$post_id);
               $_SESSION['page='.$post_id]="yes";
               $counter_value++;
               $stats->query = "UPDATE posts set views=? WHERE id = ?";
               $stats->execute(array($counter_value ,$post_id));
               updatePostview($post_id,$userid,$browser);	
               return $counter_value;	  
           } 
           return false;
}
function updatePostview($post_id,$user_id,$browser)
{		global $stats;				
    // is post visitor unique for this session? If not, increase counter value by one
        if(isset($_SESSION['page='.$post_id]))
            {
                $stats->query = "INSERT INTO visitor_log ($browser, post_id, owner_id) 
                VALUES ('1', ?, ?) ON DUPLICATE KEY UPDATE $browser=$browser+1  ";
                $stats->execute(array($post_id,$user_id));
            }	
}


?>