<?php  
 include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
 $article=new article;
 $anonymous='no';
 $published = '0';
 $isEditingPost = false;
 $title = '';
 $body = '';	
 $created_at='';
 $user_id='';
 $featured_image='';
 $selected = "";

// $errors=array();
// if user clicks the create post button
if (isset($_POST['create_post'])) { 
	$result=$article->createPost($_POST);
	if($result){	
				$errors=$result[3];	
	} 
}

// if user clicks the create post button through ajax
if (isset($_POST['create-post'])) { 
	$result=$article->createPost($_POST);
	if($result)
	$response='<div class="alert alert-'.$result[1].'">'.$result[0].'</div>';
	   $article->response($response,$result[1],$result[2]);
}

// if user clicks the Edit post button
if (isset($_POST['edit-post'])) {
	$isEditingPost = true;
	$post_id =$article->clean_input($_POST['id']);
	$postdata=$article->editPost($post_id);
	$title = $postdata['response']['title'];
	$body = htmlspecialchars($postdata['response']['body']);		
	$published =$postdata['response']['published'];
	$published =$postdata['response']['published'];
	$created_at=$postdata['response']['created_at'];
	$user_id=$postdata['response']['user_id'];
	$topic_id=$postdata['status'];
	$featured_image=$postdata['response']['image'];
}

// if user clicks the Edit post button through ajax
if (isset($_POST['edit_post'])) {	
	$post_id =$article->clean_input($_POST['id']);
	$postdata=$article->editPost($post_id);
	if($postdata)
		echo json_encode($postdata);
}

// if user clicks the update post button
if (isset($_POST['update_post'])) {
	$result=$article->updatePost($_POST);
	$_SESSION['message'] = $result[0];	
}
// if user clicks the update post button through ajax
if (isset($_POST['update-post'])) {
	$result=$article->updatePost($_POST);
	if($result)
	$response='<div class="alert alert-'.$result[1].'">'.$result[0].'</div>';
	   $article->response($response,$result[1],$result[2]);
}
	
	if(isset($_POST["id"]))
		$id=$article->clean_input($_POST['id']);	
	if(isset($_POST["action"]))
		$action = $_POST["action"];		
			if(!empty($action)) {	
				switch($action) {
					case "publish":
						$message = "Post published successfully";			
						$value= "1";
						$result = $article->togglePublishPost($id,$value);
						if($result){
								$status="success";
								$response=$message;
							}
							else{
								$status="danger";
								$response="The post status could not be changed due to some error";
							}					
							break;
					case "unpublish":
						$message = "Post successfully unpublished";			
						$value= "0";
						$result = $article->togglePublishPost($id,$value);
							if($result){
									$status="success";
									$response=$message;
								}
							else{
									$status="danger";
									$response="The post status could not be changed due to some error";
							}					
							break;
					case "delete": 
						$result =$article->deletePost($id);
						if($result){
								$status="success";
								$response="The post was successfully deleted ";
							}
						else{
								$status="danger";
								$response="The post could not be deleted due to some error";
						}					
						break;
				}
				$response='<div class="alert alert-'.$status.'">'.$response.'</div>';
				$article->response($response,$status);
			}
	
?>