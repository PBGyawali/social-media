<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_CLASS.'publicview.php');
$katha=new publicview(); 
$user_id =(isset($_SESSION['id'])?$_SESSION['id']:'');

	if (isset($_GET['post-slug']) && !empty($_GET['post-slug'])) {
	$slug = $_GET['post-slug'];	
	// get postid from slug out of the database
	$posting = $katha->get_data('id','posts','slug',$slug,'',1);
	if(!empty($posting))// Get all comments from database
	$comments = getallcomments($posting);}
	
	

function getallcomments($id){
	global $katha;
	return $katha->getAllArray('comments','post_id',$id,'','','created_at'); 
}


// Receives a user id and returns the username
function getUsernameById($id){
	return getColumnById($id,'username');
}

// Receives a user id and returns the username
function getProfilePictureById($id){
	global $katha;
	return $katha->Get_profile_image($id);
}

function getColumnById($id,$column){
	global $katha;
	return $katha->get_data($column,'users','id',$id,'',1);
}
	// Receives a comment id and returns the username
	function getRepliesByCommentId($id){
		global $katha;
		return $katha->getAllArray('replies','comment_id',$id);
	}
	// Receives a post id and returns the total number of comments on that post
	function getCommentsCountByPostId($post_id){	
		global $katha;
		return $katha->CountTable('comments','post_id',$post_id) ;
	}

	//...
// If the user clicked submit on comment form...
if (isset($_POST['comment_posted'])) {
	// grab the comment that was submitted through Ajax call
	$comment_text = $katha->clean_input($_POST['comment_text']);
	$post_id = $katha->clean_input($_POST['post_id']);
	$receiver_id = $katha->clean_input($_POST['receiver_id']);
	// insert comment into database
	$katha->insert('comments',array('post_id', 'user_id', 'body'),array($post_id, $user_id , $comment_text));
	$inserted_id = $katha->id();		
	// if insert was successful, return that same comment 	
	if ($inserted_id) {
		$comment = "<div class='comment clearfix' id='comment_".$inserted_id."'>					
						<div class='comment-details' id='comment_details_".$inserted_id."'>
							<div id='profilepic_'".$inserted_id."'>
								<img src='".USER_IMAGES_URL.rawurlencode(getProfilePictureById($user_id))."' height='40px' width='40px' alt='profile picture' class='rounded-circle profile_pic'>
							<div >
							<div class='comment_info'>
								<a class='comment-name' href='profile?user='".$user_id."'>".getUsernameById($user_id)."</a>						
								<span class='comment-date'>" . date('F j, Y ', time()) . "</span>
								<p class='comment_value'>" . htmlspecialchars($comment_text). "</p>
								<a class='edit-btn btn btn-sm btn-primary py-0' data-id='" . $inserted_id . "'>Edit</a>
								<a class='delete-btn btn btn-sm  btn-danger btn-delete py-0' data-id='" . $inserted_id . "' data-object='comments'>Delete</a>						
							</div>
						</div>
					<!-- reply form -->
					<form action='single_post.php' class='reply_form clearfix' id='comment_reply_form_" . $inserted_id. "' data-id='" . $inserted_id . "'>
						<textarea class='form-control reply_text' name='reply_text' id='reply_text".$inserted_id."' cols='30' rows='2'></textarea>						
						<button class='btn btn-success btn-sm py-0 float-right' data-id='".$inserted_id."' data-receiver_id='".$user_id.">Submit reply</button>						
						<a class='cancel-btn btn btn-sm btn-primary py-0 float-left' data-id='".$inserted_id."'>Cancel Edit</a>						
						<a class='cancel-btn btn btn-sm btn-primary py-0 float-left' data-id='".$inserted_id."'>Cancel Reply</a>								
					<button type='button'class='btn btn-primary btn-sm py-0 update-reply float-right' id='update_btn' data-id='".$inserted_id."'style='display:none;'>Update</button>
					</form>					
					</div>";
					$comment_info = array('comment' => $comment,'comments_count' => getCommentsCountByPostId($post_id));
					echo json_encode($comment_info);
					$title=$katha->get_data('title','posts','id',$post_id);
						$katha->activitylogs($user_id, 'You commented on','comment','post',$post_id,$title,$comment_text);
						if(!$check->is_same_user($receiver_id))
						$katha->insert('alerts',array('user_id','alert','type'),array($receiver_id,getUsernameById($user_id).' commented on your post '.$title,'comment'));
				}
	else 
		echo "error";
	exit();
}


// If the user clicked submit on comment form...
if (isset($_POST['edit_comment'])) {	
	// grab the comment that was submitted through Ajax call
	$comment_text = $katha->clean_input($_POST['comment_text']);
	$comment_id =  $katha->clean_input($_POST['comment_id']);
	// insert comment into database
	$katha->UpdateDataColumn('comments','body',$comment_text,'id',$comment_id);
	$affected_row = $katha->row();	
	// if update was successful, get that same comment from the database and return it
	if ($affected_row) {
	$comment = '<div class="comment_info">
					<a class="comment-name" href="profile?user="'.$user_id.'">'.getUsernameById($user_id).'</a>						
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

// If the user clicked delete on comment form...
if (isset($_POST['comment_deleted'])) {
	// grab the comment id that needs to be deleted through Ajax call
	$comment_id = $katha->clean_input($_POST['comment_id']);
	$object=$katha->clean_input($_POST['object']);
	$post_id=$katha->clean_input($_POST['post_id']);
	$katha->Delete($object,'id',$comment_id);
	$result = $katha->row();
	// if delete was successful, 
	if ($result) 
		$status="success";
	 else 
		$status="error";
	$comment_info = array('status'=>$status,'comments_count'=>getCommentsCountByPostId($post_id));
	echo json_encode($comment_info);
	$katha->activitylogs($user_id, 'You deleted your '.$object.' on a' ,'delete','post',$post_id);
	exit();
}





// If the user clicked submit on reply form...
if (isset($_POST['reply_posted'])) {	
	// grab the reply that was submitted through Ajax call
	$reply_text = $katha->clean_input($_POST['reply_text']); 
	$comment_id =  $katha->clean_input($_POST['comment_id']);
	$receiver_id =  $katha->clean_input($_POST['receiver_id']);
	// insert reply into database
	$katha->insert('replies',array('user_id','comment_id','body'),array($user_id,$comment_id,$reply_text));
	$inserted_id = $katha->id();	
	// if insert was successful, get that same reply from the database and return it
	if ($inserted_id) {
		$reply = "<div class='comment reply clearfix'>
					<img src='".USER_IMAGES_URL.getProfilePictureById($user_id)."' alt='' height='40px' width='40px' class='profile_pic rounded-circle img-fluid'>
					<div class='comment-details'>
						<a class='comment-name' href='profile?user='".$user_id."'>".getUsernameById($user_id)."</a>
						<span class='comment-date'>" . date('F j, Y ', time()) . "</span>
						<p>" . htmlspecialchars($reply_text) . "</p>
						<a class='delete-btn btn btn-sm btn-danger py-0' data-id='".$inserted_id."' data-object='replies'>Delete</a>
						<a class='edit-btn btn btn-sm btn-primary py-0' data-id='".$inserted_id."'>Edit</a>												
					</div>
				</div>";
				echo json_encode($reply);
				$comments=$katha->get_data('body','comments','id',$comment_id);
				$katha->activitylogs($user_id, 'Your replied on','reply','comment',$comment_id,$comments,$katha->get_data('body','replies','id',$inserted_id));
				if(!$check->is_same_user($receiver_id))				
					$katha->insert('alerts',array('user_id','alert','type'),array($receiver_id,getUsernameById($user_id).' replied on your comment '.$comments,'reply'));
							
	} 
	else 
		echo "error";
	exit();
}

?>