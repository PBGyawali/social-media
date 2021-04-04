<?php 
class article extends publicview{
public $errors=array();
public $user_id ;
public $response='';
public $status='';
public $anonymous='no';
public $published = '0';
public $featured_image = "";
public $row = "";
public function __construct(){
	parent::__construct();
	$this->user_id = (isset($_SESSION['id'])?$_SESSION['id']:'');  
}

function editPost($post_id){	
	$post = $this->getArray('posts','id',$post_id,'',1);		
	$topic_id = $this->get_data('topic_id','post_topic','post_id',$post_id,'',1);
	$post['newbody'] = html_entity_decode($post['body']);
	array_push($post,$post['newbody'])	;
	$finalresponse = array('response' => $post,'status' => $topic_id);
	return $finalresponse;
}
function getPublishedPosts() {
	$posts =$this->getAllArray('posts','published',1,'',10,'created_at');
	if($posts){
		$posts= $this->getextradata($posts);
		return $posts;
	}				
	return null;
}
function getPostusername($id){	
	return $this->getPostData($id,'username');
}
function getPostData($id,$column){		
	return $this->get_data($column,'users','id',$id);
}
function getPostFirstname($id){
	return $this->getPostData($id,'first_name');
}

function getPostLastname($id){	
	return $this->getPostData($id,'last_name');
}

function getPublishedPostsByTopic($topic_id) {// Returns all posts under a topic
	return $this->getPostsByTopic($topic_id);
}

function getTrendingPublishedPostsByTopic($topic_id) {
	return $this->getPostsByTopic($topic_id,'views');
}
 
 function getTopicNameById($id){//Returns topic name by topic id	
	return $this->get_data('name','topics','id',$id);	
}
function getPostsByTopic($topic_id,$orderby=null,$order='DESC') {
	$this->query= "SELECT * FROM posts ps 	WHERE ps.id IN	(SELECT pt.post_id FROM post_topic pt 
	WHERE pt.topic_id=? GROUP BY pt.post_id HAVING COUNT(1) = 1) AND published='1' ORDER BY ";
	if ($orderby)
	$this->query.=$orderby." ".$order.",";
	$this->query.=" created_at ".$order;
	$this->execute($topic_id);	
	$posts =  $this->statement_result();
	if($posts){
		$posts= $this->getextradata($posts);
		return $posts;
	}				
	return null;
}

function getPostTopic($post_id){// Receives a post id and * Returns topic of the post
	$this->query = "SELECT * FROM topics WHERE id=	(SELECT topic_id FROM post_topic WHERE post_id= ? ) LIMIT 1";
	$this->execute($post_id);
	return $this->get_array();	
}

function getPost($post_slug){// Returns a single post
	$posts = $this->getAllArray('posts','slug',$post_slug,'',1);
	if($posts){
		$posts= $this->getextradata($posts);
		return $posts;
	}				
	return null;
}
function getAllPosts(){
	if($this->is_user()){
		$this->query ="SELECT * FROM posts ";
		if(!$this->is_admin()) 
		$this->query .=" WHERE user_id='$this->user_id' ";
		$this->query .=" ORDER BY published ";	
		$this->execute(); 	
		$posts = $this->statement_result();
		if($posts)
				return $this->getextradata($posts,false);
		return null;	
	}		
	return null;
}

function getextradata($posts,$extra=true){
	$final_posts = array();
	foreach ($posts as $key=>$post) {
		$post['username'] =$this-> getPostUsername($post['user_id']);
		if($extra){
			$post['topic'] = $this->getPostTopic($post['id']); 
			$post['first_name'] = $this->getPostFirstname($post['user_id']);
			$post['last_name'] = $this->getPostLastname($post['user_id']);
		}		
		array_push($final_posts, $post);
	}
	return $final_posts;
}

function deletePost($post_id){// delete blog post
	$postname=$this->get_data('title','posts','id',$post_id);
	$result= $this->Delete('posts','id',$post_id);
	if ($result){
		$this->activitylogs($this->user_id, 'You deleted a','delete','post',$post_id,$postname);
		return $result;
	}
	return null;	
}

function togglePublishPost($post_id,$value){// toggle visibility of blog post
	return $this->UpdateDataColumn('posts','published',$value,'id',$post_id);		
}

function createPost($values){		
		$title = $this->clean_input($values['title']);
		$body = $values['body'];		
		$user_id = $this->user_id;
		$errors=$this->is_empty(array('Post title'=>$title,'Post body'=>$body));
		if (empty($this->user_id))  {
			array_push($this->errors, "You must log in to perform this action");
			$this->response=$this->errors;
			$this->status="error";
		}
		else if ($errors){
			$this->response=$errors;
			$this->status="error";
			$this->errors=$errors; 
		}
		if (isset($values['topic_id'])) 
			$topic_id = $this->clean_input($values['topic_id']);	
		
		if (isset($values['publish'])) 
		$this->published = $this->clean_input($values['publish']);	
		
		if (isset($values['anonymous'])) 
		$this->anonymous = $this->clean_input($values['anonymous']);	
			
		if (count($this->errors) == 0) 
		{		// create slug: if title is "The Storm Is Over", return "the-storm-is-over" as slug
			$post_slug = $this->Slug($title);
			// Ensure that no post is saved twice. 	
			$result=$this->CountTable('posts','slug',$post_slug);
			if ($result> 0)  // if post exists
				array_push($this->errors, "A post already exists with that title.");
			else
			{				
				//set the image storage directory
				$dir=POST_IMAGES_DIR;	
				if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK  )
				{		
					$result=$this->fileUpload($_FILES['featured_image'], $dir,$user_id);
					$this->featured_image=$result[0];
					$errors=$result[1];
					if ($errors){
						$this->response=$errors;
						$this->status="error";
						$this->errors=$errors; 
					}					
				}			
				// create post if there are no errors in the form
				if (count($this->errors) == 0) {					
					$query=$this->insert('posts',array('user_id', 'title', 'slug', 'body','image','anonymity', 'published' ),
					array($user_id, $title, $post_slug, $body,$this->featured_image,$this->anonymous,$this->published));
					if($query)
					{ // if post created successfully
						$inserted_post_id = $this->id();						
						if (isset($topic_id))// create relationship between post and topic
							$this->insert('post_topic',array('post_id','topic_id'),array($inserted_post_id, $topic_id));				
						if($inserted_post_id){					
							$this->row='<tr id="post_'.$inserted_post_id.'">
							<td class="post_id">' .$inserted_post_id. '</td>
								<td><a target="_blank" href="'.BASE_URL.'single_post?post-slug='.$post_slug.'">
								'.$title.'	
								</a>'.'
							</td>
							<td>'.$this->getPostusername($user_id).'</td>					
							<td>'. date('F j, Y ', time()).'</td>
							<td class="updated">'.NULL.'</td>
							<td class="publish_status">'.
							(($this->published == true)? '<i class="fa fa-check btn btn-success"></i><span style="display:none;">b</span>':'<i class="fa fa-times btn btn-danger"></i><span style="display:none;">a</span>').'
								</td>'.							
								(($this->is_admin())?'
								<td >'.
								$this->anonymous.'</td>':"").'							
								<td class="buttons">							
								<button type="button" name="edit_button" title="edit"class="fa fa-edit btn btn-primary btn-sm edit_button" data-action="fetch_single" data-id="'.$inserted_post_id.'"></button>
								&nbsp;
								<button type="button" name="delete_button" title="delete" class="fa fa-trash btn btn-danger btn-sm delete_button" data-action="delete" data-id="'.$inserted_post_id.'"></button>'.
									(($this->published == true)?'<button type="button"  title="unpublish" class="fa fa-times btn btn-warning btn-sm toggle action_button" data-action="unpublish" data-id="'.$inserted_post_id.'"></button>':'<button type="button" title="publish" class="fa fa-eye btn btn-success btn-sm toggle action_button" data-action="publish" data-id="'.$inserted_post_id.'"></button>').'
											</td>
									</tr>';	
							$this->response=" A new Post was created successfully";
							$this->status='success';
							$this->activitylogs($user_id, 'You created a ','create','post',$inserted_post_id,' '.$title);
							} 
							else{//delete already uploaded image in case of error
								$this->imageDelete($dir.$featured_image);
								$this->status="error";
								$this->response=$this->errors;
							}		
								}
							}
				}
		}  
		$this->setSession('message',$this->response );
		$finalresponse = [$this->response,$this->status,$this->row];
			return $finalresponse;
	}

	function updatePost($values)
	{
		$row='';		
		$title = $this->clean_input($values['title']);		
		$body = $this->clean_input($values['body']);				
		$post_id = $this->clean_input($values['post_id']);
		$featured_image = $this->clean_input($values['old_featured_image']);
		$created_at=$this->clean_input($values['created_at']);
		$errors=$this->is_empty(array('Post title'=>$title,'Post body'=>$body));
		if (empty($this->user_id)) {
			array_push($this->errors, "You must log in to perform this action");
			$this->response=$this->errors;
			$this->status="error";} 
		else if ($errors){
			$this->response=$errors;
			$this->status="error";
			$this->errors=$errors;
		}
		$user_id=$this->clean_input($values['user_id']);	
		
		if (isset($values['publish'])) 
		$this->published= $this->clean_input($values['publish']);
		
		if (isset($values['anonymous']))
		$this->anonymous = $this->clean_input($values['anonymous']);	
		
		if (isset($values['topic_id']))
			$topic_id = $this->clean_input($values['topic_id']);			
		
		if (count($this->errors) == 0){
				$post_slug = $this->Slug($title);
				$result=$this->CountTable('posts',array('slug','id!'),array($post_slug,$post_id));
				if ($result > 0) 
				{ // if post exists
					array_push($this->errors, "A post already exists with that title.");
					$this->response=$this->errors;
					$this->status="error";			
				}
				else
				{			if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK){		
								$result=$this->fileUpload($_FILES['featured_image'], POST_IMAGES_DIR);
								$featured_image=$result[0];
								$this->errors=$result[1];			
							}
							// register topic if there are no errors in the form
							if (count($this->errors) == 0) 
							{	
								$query=$this->UpdateDataColumn('posts',array('title','slug','image','body','published','anonymity','updated_at'),
								array($title,$post_slug,$featured_image,$body,$this->published,$this->anonymous,$this->get_datetime()),'id',$post_id);
								// attach topic to post on post_topic table
								if($query)
								{ $update=$this->row();
									// if post created successfully
									if (isset($topic_id)){	// create relationship between post and topic
										$this->UpdateDataColumn('post_topic','topic_id',$topic_id,'post_id',$post_id);
									}
									if ($update>0){
										$row='<tr id="post_'.$post_id.'">
										<td class="post_id">'.$post_id.'</td>
										<td><a target="_blank" href="'.BASE_URL.'single_post.php?post-slug='.$post_slug.'">'.$title.'</a>
										</td>
										<td>'.$this->getPostusername($user_id).'</td>					
										<td>'. $created_at.'</td>
										<td class="updated">'.date("Y-m-d H:i:s",  STRTOTIME(date('h:i:sa'))).'</td>
										<td class="publish_status">'.
										(($this->published == true)? '<i class="fa fa-check btn btn-success"></i><span style="display:none;">b</span>':'<i class="fa fa-times btn btn-danger"></i><span style="display:none;">a</span>').'
										</td>'.							
										($this->is_admin()?'<td >'.$this->anonymous.'</td>':"").'							
										<td class="buttons">							
										<button type="button" name="edit_button" title="edit"class="fa fa-edit btn btn-primary btn-sm edit_button" data-action="fetch_single" data-id="'.$post_id.'"></button>
										&nbsp;
										<button type="button" name="delete_button" title="delete" class="fa fa-trash btn btn-danger btn-sm delete_button" data-action="delete" data-id="'.$post_id.'"></button>'.
										(($this->published == true)?'<button type="button"  title="unpublish" class="fa fa-times btn btn-warning btn-sm toggle action_button" data-action="unpublish" data-id="'.$post_id.'"></button>':'<button type="button" title="publish" class="fa fa-eye btn btn-success btn-sm toggle action_button" data-action="publish" data-id="'.$post_id.'"></button>').'
												</td>
										</tr>';									
										$this->response="Post updated successfully";
										$this->status="success";
										$this->activitylogs($this->user_id, 'You updated ','update','post',$post_id,$title);
										$this->insert('alerts',array('user_id','alert','type'),array($user_id,'Your post '.$title.' was successfully updated ','update'));
									}
									else {
										array_push($this->errors,"No change in update was made");
										$this->response=$this->errors;
										$this->status="error";
									}								
								}
								else {
									array_push($this->errors,"Database entry was not successful");
									$this->response=$this->errors;
									$this->status="error";
								}
							}
				}
		}				
				$finalresponse =[$this->response,  $this->status, $row];				
				return $finalresponse;
	}
	}
?>