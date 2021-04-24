<?php
class user extends publicview{
  public $post_id='';
  public $error="";
  public $rating = array();
  public $sender_id;
  
  public function __construct(){
    parent::__construct();    
    $this->sender_id =(isset($_SESSION['id'])?$_SESSION['id']:''); 
  }  
  
  function getLikes($post_id){return $this->getRatingcount($post_id,'like');}
  
  function getDislikes($post_id){return $this->getRatingcount($post_id,'dislike');}
  
  function userLiked($post_id){return $this->hasUserRated($post_id,'like');}
  
  function userDisliked($post_id){return $this->hasUserRated($post_id,'dislike');}  
  
  function getRatingcount($post_id,$value){return $this->CountTable('rating_info',array('post_id','rating_action'),array($post_id,$value));}
  
  function getFollowers($id){  return $this->CountTable('followers','receiver_id',$id);}

  function getallcomments($id){return $this->getAllArray('comments','post_id',$id,'','','created_at');}
  
  function getUsernameById($id){return $this->getColumnById($id,'username');}
  
  function getProfilePictureById($id){ return $this->Get_profile_image($id);}
  
  function getColumnById($id,$column){ return $this->get_data($column,'users','id',$id,'',1);}
  
  function getRepliesByCommentId($id){return $this->getAllArray('replies','comment_id',$id);}
  
  function getCommentsCountByPostId($post_id){return $this->CountTable('comments','post_id',$post_id);}
  
  function getRating($post_id){ 
    $rating = ['likes' =>$this->getRatingcount($post_id,'like'),'dislikes' =>$this->getRatingcount($post_id,'dislike') ];
    return json_encode($rating);
  }
  function hasUserRated($post_id,$value){      
    $result = $this->CountTable('rating_info',array('user_id','post_id','rating_action'),array($this->sender_id ,$post_id,$value)); 
    if ($result > 0)
      return true;
    else
      return false;
  }
  
  function userfollowed($receiver_id){
    $result = $this->CountTable('followers',array('sender_id','receiver_id'),array($this->sender_id,$receiver_id)); 
    if ($result > 0)
      return true;
    else
      return false;
  }	

  function rating($actions) {
  $post_id = $actions['post_id'];
  $action = $actions['actions'];
  $receiver_id = $actions['receiver_id'];  
  switch ($action) {
    case 'like':
    case 'dislike':
      $this->query="INSERT INTO rating_info (user_id, post_id, rating_action) 
                    VALUES (?, ?,'$action') ON DUPLICATE KEY UPDATE rating_action='$action'";  
         break;  
  	case 'unlike':      
  	case 'undislike':
      $this->query="DELETE FROM rating_info WHERE user_id= ? AND post_id= ? ";
      break;  	
  }
  $this->execute(array($this->sender_id,$post_id));
  echo getRating($post_id);
  $title=$this->get_data('title','posts','id',$post_id);
  $this->activitylogs($this->sender_id, 'You '.$action.'d ',$action,'post',$title);
  $this->insert('alerts',array('user_id','alert','type'),array($receiver_id,$this->get_data('username','users','id',$this->sender_id).' '.$action.'d your post '.$title,$action));
  exit(0);
}

function follow($result) {
  $receiver_id = $result['receiver_id'];
  $action = $result['result'];  
  if ($receiver_id==$this->sender_id){
    $error="Sorry, You cannot follow yourself"; 
  }
  else{
        switch ($action){
              case 'follow':
                  $this->insert('followers',array('sender_id', 'receiver_id'),array($this->sender_id,$receiver_id));                        
                  break;
              case 'unfollow':
                  $this->Delete('followers',array('sender_id', 'receiver_id'),array($this->sender_id,$receiver_id));
                  break;
         }          
  }
 echo json_encode($error);
 if($this->row>0){
  $this->activitylogs($this->sender_id, 'You '.$action.'ed',$action,'user',$receiver_id,$this->get_data('username','users','id',$receiver_id));
  $this->insert('alerts',array('user_id','alert','type'),array($receiver_id,$this->get_data('username','users','id',$this->sender_id).' '.$action.'ed you ',$action));
 }
  exit(0); 
} 


function post_comment($posted){	
	$comment_text = $this->clean_input($posted['comment_text']);
	$post_id = $this->clean_input($posted['post_id']);
	$receiver_id = $this->clean_input($posted['receiver_id']);
	$this->insert('comments',array('post_id', 'user_id', 'body'),array($post_id, $this->sender_id , $comment_text));
	$inserted_id = $this->id();
	if ($inserted_id) {
		$comment = "<div class='comment clearfix' id='comment_".$inserted_id."'>					
						<div class='comment-details' id='comment_details_".$inserted_id."'>
							<div id='profilepic_'".$inserted_id."'>
								<img src='".USER_IMAGES_URL.urlencode($this->getProfilePictureById($this->sender_id))."' height='40px' width='40px' alt='profile picture' class='rounded-circle profile_pic'>
							<div >
							<div class='comment_info'>
								<a class='comment-name' href='profile?user='".$this->sender_id."'>".$this->getUsernameById($this->sender_id)."</a>						
								<span class='comment-date'>" . date('F j, Y ', time()) . "</span>
								<p class='comment_value'>" . htmlspecialchars($comment_text). "</p>
								<a class='edit-btn btn btn-sm btn-primary py-0' data-id='" . $inserted_id . "'>Edit</a>
								<a class='delete-btn btn btn-sm  btn-danger btn-delete py-0' data-id='" . $inserted_id . "' data-object='comments'>Delete</a>						
							</div>
						</div>
					<!-- reply form -->
					<form action='single_post.php' class='reply_form clearfix' id='comment_reply_form_" . $inserted_id. "' data-id='" . $inserted_id . "'>
						<textarea class='form-control reply_text' name='reply_text' id='reply_text".$inserted_id."' cols='30' rows='2'></textarea>						
						<button class='btn btn-success btn-sm py-0 float-right' data-id='".$inserted_id."' data-receiver_id='".$this->sender_id.">Submit reply</button>						
						<a class='cancel-btn btn btn-sm btn-primary py-0 float-left' data-id='".$inserted_id."'>Cancel Edit</a>						
						<a class='cancel-btn btn btn-sm btn-primary py-0 float-left' data-id='".$inserted_id."'>Cancel Reply</a>								
					<button type='button'class='btn btn-primary btn-sm py-0 update-reply float-right' id='update_btn' data-id='".$inserted_id."'style='display:none;'>Update</button>
					</form>					
					</div>";
					$comment_info = array('comment' => $comment,'comments_count' =>$this->getCommentsCountByPostId($post_id));
					echo json_encode($comment_info);
					$title=$this->get_data('title','posts','id',$post_id);
						$this->activitylogs($this->sender_id, 'You commented on','comment','post',$post_id,$title,$comment_text);
						if(!$this->is_same_user($receiver_id))
						$this->insert('alerts',array('user_id','alert','type'),array($receiver_id,$this->getUsernameById($this->sender_id).' commented on your post '.$title,'comment'));
				}
	else 
		echo "error";
	exit();
}


function edit_comment($edit) {
	$comment_text = $this->clean_input($edit['comment_text']);
	$comment_id =  $this->clean_input($edit['comment_id']);
	$this->UpdateDataColumn('comments','body',$comment_text,'id',$comment_id);
	$affected_row = $this->row();	
	if ($affected_row) {
	$comment = '<div class="comment_info">
					<a class="comment-name" href="profile?user="'.$this->sender_id.'">'.$this->getUsernameById($this->sender_id).'</a>						
					<span class="comment-date">'.date('F j, Y ', time()).'</span>
					<p>' . htmlspecialchars($comment_text) . '</p>
					<a class="edit-btn btn btn-sm btn-primary py-0" data-id="'.$comment_id.'">Edit</a>
					<a class="delete-btn btn btn-sm btn-danger py-0" data-id="'.$comment_id.'">Delete</a>						
				</div>';	
		echo json_encode($comment);		
	} else
		echo "error";
	exit();
}

function delete_comment($delete){
	$comment_id = $this->clean_input($delete['comment_id']);
	$object=$this->clean_input($delete['object']);
	$post_id=$this->clean_input($delete['post_id']);
	$this->Delete($object,'id',$comment_id);
	$result = $this->row();	
	if ($result) 
		$status="success";
	 else 
		$status="error";
	$comment_info = array('status'=>$status,'comments_count'=>$this->getCommentsCountByPostId($post_id));
	echo json_encode($comment_info);
	$this->activitylogs($this->sender_id, 'You deleted your '.$object.' on a' ,'delete','post',$post_id);
	exit();
}


function reply($reply) {	
	$reply_text = $this->clean_input($reply['reply_text']); 
	$comment_id =  $this->clean_input($reply['comment_id']);
	$receiver_id =  $this->clean_input($reply['receiver_id']);	
	$this->insert('replies',array('user_id','comment_id','body'),array($this->sender_id,$comment_id,$reply_text));
	$inserted_id = $this->id();	
	if ($inserted_id) {
		$reply = "<div class='comment reply clearfix'>
					<img src='".USER_IMAGES_URL.$this->getProfilePictureById($this->sender_id)."' alt='' height='40px' width='40px' class='profile_pic rounded-circle img-fluid'>
					<div class='comment-details'>
						<a class='comment-name' href='profile?user='".$this->sender_id."'>".$this->getUsernameById($this->sender_id)."</a>
						<span class='comment-date'>" . date('F j, Y ', time()) . "</span>
						<p>" . htmlspecialchars($reply_text) . "</p>
						<a class='delete-btn btn btn-sm btn-danger py-0' data-id='".$inserted_id."' data-object='replies'>Delete</a>
						<a class='edit-btn btn btn-sm btn-primary py-0' data-id='".$inserted_id."'>Edit</a>												
					</div>
				</div>";
				echo json_encode($reply);
				$comments=$this->get_data('body','comments','id',$comment_id);
				$this->activitylogs($this->sender_id, 'Your replied on','reply','comment',$comment_id,$comments,$this->get_data('body','replies','id',$inserted_id));
				if(!$this->is_same_user($receiver_id))				
					$this->insert('alerts',array('user_id','alert','type'),array($receiver_id,$this->getUsernameById($this->sender_id).' replied on your comment '.$comments,'reply'));
		} 
	else 
		echo "error";
	exit();
}
}

if (isset($_GET['post-slug']) && !empty($_GET['post-slug'])) {
	$slug = $_GET['post-slug'];	
	$posting = $this->get_data('id','posts','slug',$slug,'',1);
	if(!empty($posting))
  $comments = $this->getallcomments($posting['id']);
}
?>