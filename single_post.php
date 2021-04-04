<?php 
	include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
	//include_once(ADMIN_CLASS.'katha.php');
	$article=new article;
	include_once(USER_SERVER.'comment_server.php');
	include_once(USER_SERVER.'user_action_server.php'); 
	include_once(USER_INCLUDES.'minimal_header.php');  
	if (isset($_GET['post-slug']) && !empty($_GET['post-slug'])) 
	$posts =$article-> getPost($_GET['post-slug']);
	if(!empty($posts))
	{foreach($posts as $post)
	{(!empty($post))?$views=$post['views']:$views='';
	(!empty($post))?$title=$post['title']: $title='';}}
	//$katha=new katha();	
 ?>
<title> <?= $title ?></title>  
  <link rel="stylesheet" type="text/css" href="<?php  echo CSS_URL?>post_style.css">
  <?php include_once( USER_INCLUDES.'sidebar.php'); ?>
</head>
<body>
<div class="container-fluid mt-3">
	<div class="row mx-0">
		<div class="col-md-1 mx-0 px-0">
			<!--<script type="text/javascript" src="https://platform-api.sharethis.com/js/sharethis.js#property=5facd05263b0cd00123cbb3f&product=sticky-share-buttons" async="async"></script>-->			
		</div>
		<div class="col-md-9  ">
		
			<div class="content d-flex" >	
				<div class="post-wrapper w-100">
					<div class="full-post-div pl-1 ">
						<?php if (!(isset($_GET['post-slug']))||empty($_GET['post-slug'])): ?>
							<h2 class="post-title m-auto">Sorry... The link you tried to access is invalid. </h2>						
							<?php elseif (empty($posts)): ?>
							<h2 class="post-title m-auto">Sorry... The post that you are trying to find does not exist in our system. </h2>	
							<?php else: ?>
						<?php foreach($posts as $post):?>					
						<?php if ( $post['published'] == false): ?>
							<h2 class="post-title m-auto">Sorry... This post is not available. Either the author made it private or it has been hidden/removed due to violation of our community guidlines.</h2>						
						<?php else: ?>
							
							<form id="postviews" action="<?= BASE_URL.'event_handler.php'?>" method="post">
								<input type="hidden" id="views" value="<?= $post['id']; ?>">
								<input type="hidden" id="loginid" value="<?= $user_id ?>">
								<input type="hidden" id="receiverid" value="<?php if ($check->is_user()) echo $post['user_id'] ?>">
								<input type="hidden" id="action_server" value="<?= USER_SERVER_URL.'user_action_server.php'; ?>" />
							</form>
							<h2 class="post-title text-center"><?= ucfirst($post['title']); ?></h2>
							<h4 class="post-title d-inline">Author: 
								<?php if ($post['anonymity'] == 'yes'): ?>
									Anonymous
								<?php else: ?>
									<?php 
										if (!empty($post['first_name'])|| !empty($post['last_name'])){
											$str=array($post['first_name'],$post['last_name']);    
											$author=implode(' ',$str);
										}
									else if (!empty($post['username']))  
										$author=$post['username'];			  
									else 
										$author="anonymous";					
										echo ucwords($author);				
									?>			
								<?php endif ?>	
							</h4>
							<?php if ($check->is_user()):?>			
								<?php if ($post['anonymity']!="yes"): ?>
									<?php if (userfollowed($post['user_id']))
											echo '<button type="button" class="action_button btn btn-sm btn-success " data-user_id="'.$user_id.' " data-action="follow" data-receiver_id="'.$post['user_id'].'">UnFollow</button>';
										else	
											echo '<button type="button" class="action_button btn btn-sm btn-primary " data-user_id="'.$user_id.'" data-action="unfollow" data-receiver_id="'.$post['user_id'].'"><i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow</button>';
									 ?>			      
								<?php endif ?>
							<?php endif ?>				
						
							<h5 class="post-created">Created on: <?= date("F j, Y ", strtotime($post["created_at"])); ?></h5>
							<?php if ($post['updated_at']):?>
							<h5 class="post-updated">Last updated: <time class="timeago" datetime="<?= $post['updated_at']?>"></time></h5>
							<?php endif ?>
							<h5 class="post-view">Total views: <?= $views; ?></h5>
							<div class="post-body-div m-auto mt-3 pr-3  text-justify" style="word-wrap: break-word;">
							<p class="comment_value"><?= $post['body'] ?></p>
							</div>	
							<div class="post-info p-3">
								<i 
									<?php if (userLiked($post['id'])):?>
										class="rating-btn fa fa-thumbs-up text-primary like-btn"		
									<?php else: ?>
										class="rating-btn fa fa-thumbs-up fa-thumbs-o-up like-btn"
									<?php endif ?>
									data-id="<?= $post['id'] ?>" data-receiver_id=" <?= $post['user_id']; ?>" data-user_id="<?= $user_id  ?>">
								</i>
								<span class="likes"><?= getLikes($post['id']);?></span>
								<i 
								<?php if (userDisliked($post['id'])): ?>
									class="rating-btn fa fa-thumbs-down text-primary dislike-btn"
								<?php else: ?>
									class="rating-btn fa fa-thumbs-down fa-thumbs-o-down dislike-btn"
								<?php endif ?>
								data-id="<?= $post['id'] ?>" data-receiver_id="<?= $post['user_id']; ?>" data-user_id="<?= $user_id ?>"></i>
								<span class="dislikes"><?= getDislikes($post['id']);?></span><span><?php if (!$check->is_user()) echo"<h3>Please Login to Rate the Post</h3>";?></span>	 
							</div>	<!-- div for like dislike ends here  -->		
							<div class="row mx-0 pb-5">
								<div class="col-md-12 comments-section">
									<!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
									<?php if ($check->is_user()): ?>
									<form class="comment_form clearfix" action="single_post.php" method="post" id="comment_form">
										<textarea name="comment_text" placeholder="Start the discussion" id="comment_text_<?= $post['id'] ?>" class="form-control comment_text" cols="30" rows="3"></textarea>
										<input type="hidden" name="post_id" class="post_id" id="post_id" value="<?= $post['id'] ?>">
										<button class="submit_comment btn btn-success btn-sm float-right" type="submit" data-user_id="<?= $post['user_id'] ?>" data-id="<?= $post['id'] ?>" name ="comment_posted" id="submit_comment">Submit comment</button>
									</form>
									<?php else: ?>
									<div class="sign-up mt-5" >
										<h3 class="text-center"><a href="<?= BASE_URL.'index.php#login'; ?>">Sign in</a> to post a comment</h3>
									</div>
									<?php endif ?>
									<!-- Display total number of comments on this post  -->
									<h3 ><span class="comments_count" id="comments_count_<?= $post['id'] ?>"><?php $count=count($comments);echo ($count>0?'<span class="comments_count_show" id="comments_count_show'.$post['id'].'">Show </span>'.$count:$count); ?> Comment<?= ($count>1?'s':''); ?></span></h3>
										<!-- comments wrapper -->
									<div id="comments-wrapper_<?= $post['id']?>" class="comments-wrapper">
										<?php if (isset($comments) && $comments!=null): ?>
											<?php foreach ($comments as $comment): ?>											
												<div class="comment clearfix" id="comment_<?= $comment['id']?>">
													<div class="comment-details" id="comment__details_<?= $comment['id']?>">
														<div id="profilepic_<?= $comment['id']?>">
															<img src="<?= USER_IMAGES_URL.rawurlencode(getProfilePictureById($comment['user_id'])) ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
														</div>
														<div class="comment_info">
															<a class="comment-name" href="profile.php?user=<?= $comment['user_id']?>"><?= getUsernameById($comment['user_id']) ?></a>
															<span class="comment-date"><?= date("F j, Y ", strtotime($comment["created_at"])); ?></span>
															<p class="comment_value"><?= htmlspecialchars($comment['body']); ?></p>
															<?php if ($check->is_user() && $check->is_same_user($comment['user_id'])):?>
																<button class="edit-btn btn btn-sm btn-primary py-0" data-id="<?= $comment['id']; ?>">Edit</button>					
															<?php else:?>	
																<?php if ($check->is_user()):?>											
																	<button class="reply-btn btn btn-sm btn-primary py-0" data-id="<?= $comment['id']; ?>" data-receiver_id="<?= $comment['user_id']; ?>">Reply</button>
																<?php endif?>
															<?php endif?>
															<?php if ($check->is_user() && $check->is_same_user($comment['user_id']) || $check->is_admin()):?>
																<button class="delete-btn btn btn-sm btn-danger py-0" data-id="<?= $comment['id']; ?>"  data-object="comments" >Delete</button>
															<?php endif?>
														</div>
													</div><!-- // comment-details -->
															<!-- reply form -->					
													<form action="single_post.php" class="reply_form clearfix" id="comment_reply_form_<?= $comment['id'] ?>" data-id="<?= $comment['id']; ?>">
														<textarea class="form-control reply_text" name="reply_text" id="reply_text_<?= $comment['id'] ?>"class="form-control" cols="30" rows="3"></textarea>
														<button class="btn btn-success btn-sm py-0 pull-right submit-reply float-right" data-id="<?= $comment['id']; ?>"data-receiver_id="<?= $comment['user_id']; ?>">Submit reply</button>
														<?php if ($check->is_user() && $check->is_same_user($comment['user_id'])):?>						
															<button class="cancel-btn btn btn-sm btn-primary py-0" data-id="<?= $comment['id']; ?>">Cancel Edit</button>
														<?php else:?>						
															<button class="cancel-btn btn btn-sm btn-primary py-0" data-id="<?= $comment['id']; ?>">Cancel Reply</button>
														<?php endif?>
															<button type='button'class="btn btn-primary btn-sm pull-right update-reply py-0 text-right float-right" id='update_btn' data-id="<?= $comment['id']; ?>"style='display: none;'>Update</button>
													</form>
														<!-- GET ALL REPLIES -->
														<?php $replies = getRepliesByCommentId($comment['id']) ?>
														<?php if (isset($replies) && $replies!=null): ?>
															<?php foreach ($replies as $reply): ?>
																<div class="replies_wrapper_<?= $comment['id']; ?>">
																	<div class="comment reply clearfix"><!-- reply -->
																		<img src="<?= USER_IMAGES_URL.rawurlencode(getProfilePictureById($reply['user_id'])) ?>" alt="" height="40px" width="40px" class="profile_pic rounded-circle">
																		<div class="comment-details">
																			<a class="comment-name" href="profile.php?user=<?= $reply['user_id']?>"><?= getUsernameById($reply['user_id']) ?></a>
																			<span class="comment-date"><?= date("F j, Y ", strtotime($reply["created_at"])); ?></span>
																			<p><?= htmlspecialchars($reply['body']); ?></p>
																			<?php if ($check->is_user() && ($check->is_same_user($reply['user_id']) || $check->is_admin() )):?>										
																			<button class="delete-btn btn btn-sm btn-danger py-0" data-id="<?= $reply['id']; ?>" data-object="replies">Delete</button>
																			<?php endif?>
																			<?php if ($check->is_user() && $check->is_same_user($reply['user_id'])):?>										
																			<button class="edit-btn btn btn-sm btn-primary py-0" data-id="<?= $reply['id']; ?>">Edit</button>
																			<?php endif?>
																			<?php if ($check->is_user() && !$check->is_same_user($reply['user_id'])):?>										
																				<button class="reply-btn btn btn-sm btn-success py-0"  data-id="<?= $comment['id']; ?>">Reply</button>
																			<?php endif ?>
																		</div>
																	</div>															
																</div>
															<?php endforeach ?>
														<?php endif ?>
												</div><!-- // comment -->	
											<?php endforeach ?>										
											<?php else: ?>
										<h2 class="comment_call" id="comment_call_<?= $post['id']?>">Be the first to comment on this post</h2>
										<?php endif ?>
									</div><!-- comments wrapper -->
								</div>
							</div>
							<?php endif ?>
							<?php endforeach?>							
							<?php endif ?><!-- dont show anything if post is not released except the message -->
					</div><!-- full post-div -->
				</div>	<!-- post-wrapper -->
			</div> <!--content -->
			
		</div>   
			<div class="col-md-2 mx-0 px-0">
						<div class="post-sidebar">
							<div class="card w-100">
								<div class="card-header text-center text-white p-0">
									<h2 class="bg-primary my-0">Topics</h2>	
								</div>
								<div class="card-content">
									<?php foreach ($topics as $topic): ?>
										<a href="<?= BASE_URL.'filtered_posts.php?topic='.$topic['id']?>"><?= ucwords($topic['name'])?></a> 
									<?php endforeach ?>
								</div>
							</div>
						</div>
						<?php if ($check->is_user()):?>
						<?php include_once(USER_INCLUDES.'/chatbox.php');?>
						<?php endif ?>
			</div>
	</div>
</div><!-- container div end -->
</body>
</html>
<?php include_once( USER_INCLUDES . 'footer.php') ?>
<script type="text/javascript" src="<?= JS_URL?>comment_system.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>user_action.js" ></script>
<script type="text/javascript" src="<?= JS_URL?>visitor_detail.js"></script>
