<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php'); 
$post_id='';
$sender_id='';
$error="";
$rating = array();
$katha=new publicview(); 
if (isset($_SESSION['id']))
{$sender_id = $_SESSION['id'];
}
// if user clicks like or dislike button
if (isset($_POST['actions'])) {
  $post_id = $_POST['post_id'];
  $action = $_POST['actions'];
  $receiver_id = $_POST['receiver_id'];
  
  switch ($action) {
    case 'like':
    case 'dislike':     
      $attr=array('duplicate'=>"rating_action=?"   );
      $katha->insert('rating_info',array('user_id', 'post_id', 'rating_action'),array($sender_id,$post_id,$action,$action),$attr);
         break;  
  	case 'unlike':      
    case 'undislike':
      $katha->Delete('rating_info',array('user_id', 'post_id'),array($sender_id,$post_id));      
      break;  	
  }  
  // execute query to effect changes in the database ... 
  $title=$katha->get_data('title','posts','id',$post_id);
  $katha->activitylogs($sender_id, 'You '.$action.'d ',$action,'post',$title);
  $katha->insert('alerts',array('user_id','alert','type'),array($receiver_id,$katha->get_data('username','users','id',$sender_id).' '.$action.'d your post '.$title,$action));
  exit(0);
} 

// if user clicks follow or unfollow button
if (isset($_POST['result'])) {
  $receiver_id = $_POST['receiver_id'];
  $action = $_POST['result'];  
  if ($receiver_id==$sender_id){
    $error="Sorry, You cannot follow yourself"; 
  }
  else{
        switch ($action)
         {
              case 'follow':
                  $katha->insert('followers',array('sender_id', 'receiver_id'),array($sender_id,$receiver_id));                        
                  break;
              case 'unfollow':
                  $katha->Delete('followers',array('sender_id', 'receiver_id'),array($sender_id,$receiver_id));
                  break;
         }          
  }
 echo json_encode($error);
 if($katha->row>0){
  $katha->activitylogs($sender_id, 'You '.$action.'ed',$action,'user',$receiver_id,$katha->get_data('username','users','id',$receiver_id));
  $katha->insert('alerts',array('user_id','alert','type'),array($receiver_id,$katha->get_data('username','users','id',$sender_id).' '.$action.'ed you ',$action));
 }
  exit(0); 
} 




// Get total number of likes and dislikes for a particular post
function getRating($post_id)
{ $rating = [
  	'likes' => getRatingcount($post_id,'like'),
  	'dislikes' => getRatingcount($post_id,'dislike')
  ];
  return json_encode($rating);
}


function getLikes($post_id){  return getRatingcount($post_id,'like'); }

function getDislikes($post_id){  return getRatingcount($post_id,'dislike'); }
// Check if user already likes post or not
function userLiked($post_id){  return hasUserRated($post_id,'like'); }
// Check if user already dislikes post or not
function userDisliked($post_id){  return hasUserRated($post_id,'dislike');}  

function getRatingcount($post_id,$value)
{
  global $katha;  
  return  $katha->CountTable('rating_info',array('post_id','rating_action'),array($post_id,$value));  
}


// Get total number of follows and unfollows for a particular post
function getFollowers($id){
  global $katha;  
  return $katha->CountTable('followers','receiver_id',$id);
}

function hasUserRated($post_id,$value){  
  global $sender_id,$katha;  
  $result = $katha->CountTable('rating_info',array('user_id','post_id','rating_action'),array($sender_id ,$post_id,$value)); 
  if ($result > 0) 
  	return true; 
  return false;
}

// Check if user already follows author or not
function userfollowed($receiver_id){
  global $sender_id,$katha;  
  $result = $katha->CountTable('followers',array('sender_id','receiver_id'),array($sender_id,$receiver_id)); 
  if ($result > 0)
  	return true;
  return false;  
} 

?>