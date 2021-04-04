<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$selected_topic='';
include_once(USER_SERVER. 'post_functions.php'); 
 include_once(USER_INCLUDES. 'minimal_header.php'); 
 include_once(USER_INCLUDES.'sidebar.php');
 include_once(USER_INCLUDES.'new_message.php');
 if(!$check->is_login())  
$method->redirect(BASE_URL."#login",'error','You must log in first to view the page');?>
	        <div class="col-sm-12 py-4">
			<?php displaymessage();?>
			<div class="alert alert-success success_msg" role="alert" id="success_msg" ></div>			
			<div class="alert alert-danger error_msg" role="alert" id="error_msg" ></div>
	        	<span id="message"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-4">
							<?php if ($isEditingPost === true): ?> 
								<h2>Edit Post</h2>
							<?php else: ?> 
								<h2>Create Post</h2>
								<?php endif ?> 
	            			</div>     			
		            		<div class="col-sm-4">
							
	            			</div>
	            			<div class="col-md-4 text-right">	            				
	            				<a type="button" name="add_post" id="add_post" href="posts.php" class="btn btn-success btn-sm" ><i class="fas fa-reply"></i> Return to Post Management</a>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body text-left">									
	 
				<form method="post" id="post_form" enctype="multipart/form-data" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
					<div class="content">       
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Title</label>
			            	<div class="col-md-11">
			            		<input type="text" name="title" id="title" value="<?php echo $title;?>"class="form-control" required data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Featured Image</label>
			            	<div class="col-md-11">
							<input type="file" name="featured_image" id="featured_image" class="form-control" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">			            	
			            	<div class="col-md-12 text-left">
							<textarea name="body" class="formcontrol "id="body" cols="100%" rows="100%" ><?php echo html_entity_decode(html_entity_decode(html_entity_decode($body))); ?></textarea>							
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
							
				<?php if ($check->is_admin()): ?>
					<!-- display checkbox according to whether post has been published or not -->
					<?php if ($published == true): ?>
						<label class="col-md-1 text-left">Published</label>
							<div class="col-md-1 text-left">
							<input type="checkbox" name="publish" id="publish" value="1" checked="checked" class="form-control" >
							</div>                   						
					<?php else: ?>					
						<label class="col-md-1 text-left">Publish</label>
							<div class="col-md-1 text-left">
							<input type="checkbox" name="publish" id="publish" value="1" class="form-control" >
							</div>
					<?php endif ?>
				<?php endif ?>
				
				<?php if ($isEditingPost === true && $anonymous== 'yes'): ?> 
					<label class="col-md-2.5 text-left">Keep the post as Anonymous</label>
					<div class="col-md-1 text-left">
					<input type="checkbox" name="anonymous" value="yes" id="anonymity" checked="checked" class="form-control" >
					</div>						
					<?php else: ?>
					<label class="col-md-2.5 text-left">Post as Anonymous</label>
					<div class="col-md-1 text-left">
					<input type="checkbox" name="anonymous" value="yes" id="anonymity" class="form-control" >
					</div>
					<?php endif ?>       							
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Topic</label>
			            	<div class="col-md-11">
			            		<select name="topic_id" id="topic_id" class="form-control" required>								
								<option value="" selected disabled>Choose topic</option>
									<?php foreach ($topics as $key => $topic): ?>
									<?php	if (isset ($topic_id)&&!empty($topic_id)){
												$selected_topic = $topic_id;// topic value from database
												$selected = ($selected_topic == $topic['id']) ? "selected" : "";}?>						
									<option value="<?php echo $topic['id']; ?>"<?php echo $selected; ?> ><?php echo $topic['name']; ?>
									</option>
									</div>
								<?php endforeach ?>
			            		</select>
			            	</div>
			            </div>
		          	</div>
        		<div class="footer text-right">
				<?php if ($isEditingPost === true): ?> 
					<input type="hidden" name="old_featured_image" value="<?php echo $featured_image; ?>">
					<input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
					<input type="hidden" name="publish_status"  value="<?php echo $published; ?>" >
					<input type="hidden" name="user_id"  value="<?php echo $user_id; ?>" >
					<input type="hidden" name="created_at" id="created_at"value="<?php echo $created_at; ?>" />
					<button type="submit"  name="update_post" class="btn btn-primary" >UPDATE</button>
				<?php else: ?>
					<input type="hidden" name="user_id"  value="<?php echo $user_id; ?>" >
					<button type="submit"  class="btn btn-success" name="create_post">Save Post</button>
				<?php endif ?>	
        		</div>
      		
    	</form>	
				</div>
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>
<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<script type="text/javascript" src="<?php echo JS_URL.'parsley.min.js'?>"></script>	
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<link rel="stylesheet" href="<?php echo CSS_URL.'parsley.css'?>" >	
<script>
 setTimeout(function(){
            $('.alert').slideUp();
        }, 3000);
	$('#post_form').parsley();	
	CKEDITOR.replace('body');
</script>