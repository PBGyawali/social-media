<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$article=new article;
$topics =$article->getAllArray('topics');
$posts = $article->getAllPosts();
//if(!$article->is_login())  
//$article->redirect(BASE_URL."#login",'danger','You must log in first to view the page');
//if(!$article->is_admin())$article->redirect(ADMIN_URL);
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
?>					
				<span class="text-center position-absolute w-100"id="message" style="z-index:50"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-4">
	            				<h2>Post Management</h2>
	            			</div>
	            			<div class="col-sm-4">
	            				<div class="row input-daterange">
	            					<div class="col-md-6">
		            					<input type="date" name="from_date" id="from_date" class="form-control form-control-sm" placeholder="From Date" />
		            				</div>
		            				<div class="col-md-6">
		            					<input type="date" name="to_date" id="to_date" class="form-control form-control-sm" placeholder="To Date"  />
		            				</div>
		            			</div>
		            		</div>
		            		<div class="col-md-2">
	            				<button type="button" name="filter" id="filter" class="btn btn-info btn-sm"><i class="fas fa-filter"></i></button>
	            				&nbsp;
	            				<button type="button" name="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>
	            			</div>
	            			<div class="col-md-2 text-right" >
	            				<a href="#" name="export" id="export" class="text-success"><i class="fas fa-file-csv fa-2x"></i></a>
	            				&nbsp;
	            				<button type="button" name="add_post" id="add_post" class="btn btn-success btn-sm mr-2" style="margin-top: -15px;"><i class="fas fa-plus"></i>  <span class="d-none d-sm-inline-block">Add new</span></button>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
					<?php if (empty($posts)): ?>
				<h1 class="text-center mt-20">There are no posts in the database.</h1>
			<?php else: ?>
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="list">
	            				<thead>
	            					<tr>
										<th>POST ID</th>
	            						<th>Title</th>
										<th>Author</th>										
										<th>Created on</th>
										<th>Updated on</th>
										<th>Published</th>
										<?php if ($check->is_admin()): ?>																				
										<?php	echo 	'<th>Anonymous</th>';?>
										<?php endif?>
										<th>Action</th>
	            					</tr>
	            				</thead>
								<tbody>
					<?php foreach ($posts as $key => $post): ?>
						<tr id="post_<?php echo $post["id"];?>">
						<td class="post_id"><?php echo $post['id']; ?></td>
						<td class="postname">
								<a 	target="_blank"
								href="<?php echo BASE_URL.'single_post.php?post-slug='.$post['slug'];?>">
									<?php echo $post['title'];?>	
								</a>
							</td>
							<td><?php echo $post['username']; ?></td>					
							
							<td><?php echo $post['created_at']; ?></td>
							<td class="updated"><?php echo $post['updated_at']; ?></td>
							
							<!-- Only Admin can publish/unpublish post -->
								<td class="publish_status">
								<?php if ($post['published'] == true): ?>
									<i class="fa fa-check btn btn-success"></i><span style="display:none;">b</span>
								<?php else: ?>
									<i class="fa fa-times btn btn-danger"></i><span style="display:none;">a</span>		
								</td>
							<?php endif ?>
							<?php if ($check->is_admin()): ?>
							<td class="anonymity">
							<?php echo $post['anonymity'];?></td>
							<?php endif ?>							
								<td class="buttons">
							
								<button type="button" name="edit_button" title="edit"class="fa fa-edit btn btn-primary btn-sm edit_button" data-action="fetch_single" data-id="<?php echo $post['id'] ?>"></button>
								&nbsp;
								<button type="button" name="delete_button" title="delete" class="fa fa-trash btn btn-danger btn-sm delete_button" data-action="delete" data-id="<?php echo $post['id'] ?>"></button>
								<?php if ($post['published'] == true): ?>
										&nbsp;
									<button type="button"  title="unpublish" class="fa fa-times btn btn-warning btn-sm toggle action_button" data-action="unpublish" data-id="<?php echo $post['id'] ?>"></button>
								<?php else: ?>
									&nbsp;
									<button type="button" title="publish" class="fa fa-eye btn btn-success btn-sm toggle action_button" data-action="publish" data-id="<?php echo $post['id'] ?>"></button>
								<?php endif ?>
							</td>
						</tr>
						
					<?php endforeach ?>
					</tbody>
				</table>
				<?php endif ?>
			
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>

<div id="postModal" class="modal fade" data-backdrop="static">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="post_form" class="form" enctype="multipart/form-data" action="<?php echo USER_SERVER_URL.'post_functions.php'?>">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Create Post</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body text-left">
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Title</label>
			            	<div class="col-md-11">
			            		<input type="text" name="title" id="title" class="form-control"  data-parsley-pattern="/^[a-zA-Z\s0-9]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
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
							<textarea name="body" id="body" cols="100%" rows="100%"></textarea>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
							<label class="col-md-1 text-left">Publish</label>
								<div class="col-md-1 text-left">
									<input type="checkbox" name="publish" id="publish" value="1" class="form-control" >
								</div>
								<?php if($check->is_master_admin()):?>	
								<label class="col-md-2.5 text-left">Post as Anonymous</label>
								<div class="col-md-1 text-left">
									<input type="checkbox" name="anonymous" value="yes" id="anonymity" class="form-control" >
								</div>	
								<?php endif?>						
							</div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Topic</label>
			            	<div class="col-md-11">
			            		<select name="topic_id" id="topic_id" class="form-control" required>								
								<option value="" selected disabled>Choose topic</option>
								<?php foreach ($topics as $key => $topic): ?>						
								<option value="<?php echo $topic['id']; ?>" ><?php echo $topic['name']; ?>
								</option>
								</div>
								<?php endforeach ?>
			            		</select>
			            	</div>
			            </div>
		          	</div>
		          	
		          	
        		<div class="modal-footer">
				<input type="hidden" name="old_featured_image" id="old_featured_image"value="">
					  <input type="hidden" name="post_id" id="post_id" value=""/>
					  <input type="hidden" name="user_id" id="user_id" value="" />
					  <input type="hidden" name="publish_status" id="publish_status" value="" >
					  <input type="hidden" name="created_at" id="created_at"value="" />

					  
          			<input type="hidden" name="action" id="action" value="1" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<?php include_once(INCLUDES.'admin_footer.php')?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.8.0/ckeditor.js"></script>
<script src="posts.js"></script>
<script>CKEDITOR.replace('body');</script>