<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php  $article=new article;
$past =$article->  getPublishedPosts();
 include_once(USER_SERVER.'comment_server.php'); ?>
<?php include_once(USER_SERVER.'user_action_server.php'); ?>
<?php include_once(USER_INCLUDES.'minimal_header.php'); ?>
<title> </title>
<!DOCTYPE html>
<html>
<head>
<script type="text/javascript" src="<?php echo JS_URL?>hash.js"></script> 
<title>User Wall</title>
  <link rel="stylesheet" type="text/css" href="<?php echo CSS_URL?>wall.css">
<style type="text/css">
body {
    font-family: Arial;
    background: #e9ebee;
    font-size: 0.9em;
}
.postwall {		
	border: 1px  solid #74543e34;
	border-radius: 5px;			
}
.post-title {
    color: #4faae6;
}
.post-link {
    color: #4faae6;
}
.finished {
    display: none;
    text-align: center;
}
.ajax-loader {
    display: none;
    text-align: center;
}
</style>
</head>
<body>
<?php include_once(USER_INCLUDES.'sidebar.php');?>
    <div class="post-wall ">   
	<input type="hidden" name="total_count" id="total_count" value="<?php echo $katha-> CountTable('posts'); ?>" />
	<input type="hidden" name="action_server" id="action_server" value="<?php echo USER_SERVER_URL.'user_action_server.php'; ?>" />
    </div>
<div class="container-fluid mt-5">
	<div class="row mx-0">
		<div class="col-xs-0 col-md-2 mx-0 px-0">			
		</div>
		<div class="col-xs-12 col-md-6 offset-md-1 postwall">
			<?php foreach($past as $post):?>
			<div class="content d-flex" >	
				<div class="post-wrapper w-100" id="<?php echo $post['id']; ?>">
					<div class="full-post-div pl-1 ">
						<?php if ( $post['published'] != false): ?>							
								<input type="hidden" id="action_server" value="<?php echo USER_SERVER_URL.'user_action_server.php'; ?>" />							
							<h3 class="post-title d-inline text-dark"> 
							<?php if ($post['anonymity'] == 'yes'): ?>
								<img src="<?php echo USER_IMAGES_URL.'user_profile.png'; ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
								<?php echo 'Anonymous'; ?>
							<?php else: ?>
								<img src="<?php echo USER_IMAGES_URL.urlencode($katha->Get_profile_image($post['user_id'])); ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">                
									<?php 
										if (!empty($post['first_name'])|| !empty($post['last_name'])){
											$str=array($post['first_name'],$post['last_name']);    
											$author=implode(' ',$str);
										}
									else if (!empty($post['username']))  
										$author=$post['username'];			  
									else 
										$author="anonymous";
										echo '<a class="post-title" href="profile.php?user='.$post['user_id'].'">'.ucwords($author).'</a>';	
									?>			
								<?php endif ?>	
							</h4>
							<?php if ($check->is_user()):?>			
								<?php if ($post['anonymity']!="yes"): ?>
									<?php if (userfollowed($post['user_id'])): ?>
										<?php echo '<button type="button" class="action_button btn btn-sm btn-success " data-user_id="'.$user_id.' " data-action="follow" data-receiver_id="'.$post['user_id'].'">UnFollow</button>';?>
									<?php else: ?>		
										<?php echo '<button type="button" class="action_button btn btn-sm btn-primary " data-user_id="'.$user_id.'" data-action="unfollow" data-receiver_id="'.$post['user_id'].'"><i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow</button>';?>
									<?php endif ?>			      
								<?php endif ?>
							<?php endif ?>				
						
							<h4 class="post-title"><?php echo ucfirst($post['title']); ?></h4>
							<div class="post-body-div p-0 d-inline-block" style="max-width:90%">                
								 <?php echo substr($post['body'], 0, 200); ?> ... <p class="post-link"><a class="post-title" target="_blank" href="single_post.php?post-slug=<?php echo $post['slug']; ?>">Read more...</a></p>
							</div>	
							<div class="post-info p-3">
								<i 
									<?php if (userLiked($post['id'])):?>
										class="rating-btn fa fa-thumbs-up text-primary like-btn"		
									<?php else: ?>
										class="rating-btn fa fa-thumbs-up fa-thumbs-o-up like-btn"
									<?php endif ?>
									data-id="<?php echo $post['id'] ?>" data-receiver_id=" <?php echo $post['user_id']; ?>" data-user_id="<?php echo $user_id  ?>">
								</i>
								<span class="likes"><?php echo getLikes($post['id']);?></span>
								<i 
								<?php if (userDisliked($post['id'])): ?>
									class="rating-btn fa fa-thumbs-down text-primary dislike-btn"
								<?php else: ?>
									class="rating-btn fa fa-thumbs-down fa-thumbs-o-down dislike-btn"
								<?php endif ?>
								data-id="<?php echo $post['id'] ?>" data-receiver_id="<?php echo $post['user_id']; ?>" data-user_id="<?php echo $user_id ?>"></i>
								<span class="dislikes"><?php echo getDislikes($post['id']);?></span><span><?php if (!$check->is_user()) echo "<h3>Please Login to Rate the Post</h3>"?></span>	 
							</div>	<!-- div for like dislike ends here  -->		
							<div class="row mx-0 pb-5">
								<div class="col-md-12 comments-section">
									<!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
									<?php if ($check->is_user()): ?>
									<form class="comment_form clearfix" action="single_post.php" method="post" id="comment_form " style="display:none">
										<textarea name="comment_text" placeholder="Start the discussion" id="comment_text_<?php echo $post['id']?>" class="form-control comment_text" cols="30" rows="3"></textarea>
										<input type="hidden" name="post_id" class="post_id" id="post_id" value="<?php echo $post['id'] ?>">
										<button class="btn btn-success btn-sm float-right submit_comment" type="submit" name ="comment_posted" data-user_id="<?php echo $post['user_id'] ?>" data-id="<?php echo $post['id'] ?>" id="submit_comment">Submit comment</button>
									</form>
									<?php else: ?>
									<div class="sign-up mt-5" >
										<h3 class="text-center"><a href="<?php echo BASE_URL.'index.php#login'; ?>">Sign in</a> to post a comment</h3>
									</div>
									<?php endif ?>
									<?php $comments=getallcomments($post['id']); ?>
									<!-- Display total number of comments on this post  -->
									
									<h3 ><span class="comments_count" id="comments_count_<?php echo $post['id'] ?>"><?php $count=count($comments);echo ($count>0?'Show '.$count:$count); ?> Comment<?php echo ($count>1?'s':''); ?></span></h3>
									
									
										<!-- comments wrapper -->
									<div id="comments-wrapper_<?php echo $post['id'] ?>" class="comments-wrapper">
										<?php if (isset($comments) && $comments!=null): ?>
											<?php foreach ($comments as $comment): ?>											
												<div class="comment clearfix" id="comment_<?php echo $comment['id']?>" style="display:none">
													<div class="comment-details" id="comment__details_<?php echo $comment['id']?>">
														<div id="profilepic_<?php echo $comment['id']?>">
															<img src="<?php echo USER_IMAGES_URL.urlencode(getProfilePictureById($comment['user_id'])) ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
														</div>
														<div class="comment_info">
															<a class="comment-name" href="profile.php?user=<?php echo $comment['user_id']?>"><?php echo getUsernameById($comment['user_id']) ?></a>
															<span class="comment-date"><?php echo date("F j, Y ", strtotime($comment["created_at"])); ?></span>
															<p class="comment_value"><?php echo htmlspecialchars($comment['body']); ?></p>
															<?php if ($check->is_user() && $check->is_same_user($comment['user_id'])):?>
																<button class="edit-btn badge btn-primary py-0" data-id="<?php echo $comment['id']; ?>">Edit</button>					
															<?php else:?>	
																<?php if ($check->is_user()):?>											
																	<button class="reply-btn badge btn-primary py-0" data-id="<?php echo $comment['id']; ?>" data-receiver_id="<?php echo $comment['user_id']; ?>">Reply</button>
																<?php endif?>
															<?php endif?>
															<?php if ($check->is_user() && $check->is_same_user($comment['user_id']) || $check->is_admin()):?>
																<button class="delete-btn badge btn-danger py-0" data-id="<?php echo $comment['id']; ?>"  data-object="comments" >Delete</button>
															<?php endif?>
														</div>
													</div><!-- // comment-details -->
															<!-- reply form -->					
													<form action="single_post.php" class="reply_form clearfix" id="comment_reply_form_<?php echo $comment['id'] ?>" data-id="<?php echo $comment['id']; ?>">
														<textarea class="form-control reply_text" name="reply_text" id="reply_text_<?php echo $comment['id'] ?>"class="form-control" cols="30" rows="3"></textarea>
														<button class="btn btn-success btn-sm py-0 pull-right submit-reply float-right" data-id="<?php echo $comment['id']; ?>"data-receiver_id="<?php echo $comment['user_id']; ?>">Submit reply</button>
														<?php if ($check->is_user() && $check->is_same_user($comment['user_id'])):?>						
															<button class="cancel-btn btn btn-sm btn-primary py-0" data-id="<?php echo $comment['id']; ?>">Cancel Edit</button>
														<?php else:?>						
															<button class="cancel-btn btn btn-sm btn-primary py-0" data-id="<?php echo $comment['id']; ?>">Cancel Reply</button>
														<?php endif?>
															<button type='button'class="btn btn-primary btn-sm pull-right update-reply py-0 text-right float-right" id='update_btn' data-id="<?php echo $comment['id']; ?>"style='display: none;'>Update</button>
													</form>
														<!-- GET ALL REPLIES -->
														<?php $replies = getRepliesByCommentId($comment['id']) ?>
														<?php if (isset($replies) && $replies!=null): ?>
															<?php foreach ($replies as $reply): ?>
																<div class="replies_wrapper_<?php echo $comment['id']; ?>">
																	<div class="comment reply clearfix"><!-- reply -->
																		<img src="<?php echo USER_IMAGES_URL.urlencode(getProfilePictureById($reply['user_id'])) ?>" alt="" height="40px" width="40px" class="profile_pic rounded-circle">
																		<div class="comment-details">
																			<a class="comment-name" href="profile.php?user=<?php echo $reply['user_id']?>"><?php echo getUsernameById($reply['user_id']) ?></a>
																			<span class="comment-date"><?php echo date("F j, Y ", strtotime($reply["created_at"])); ?></span>
																			<p><?php echo htmlspecialchars($reply['body']); ?></p>
																			<?php if ($check->is_user() && ($check->is_same_user($reply['user_id']) || $check->is_admin() )):?>										
																			<button class="delete-btn btn btn-sm btn-danger py-0" data-id="<?php echo $reply['id']; ?>" data-object="replies">Delete</button>
																			<?php endif?>
																			<?php if ($check->is_user() && $check->is_same_user($reply['user_id'])):?>										
																			<button class="edit-btn btn btn-sm btn-primary py-0" data-id="<?php echo $reply['id']; ?>">Edit</button>
																			<?php endif?>
																			<?php if ($check->is_user() && !$check->is_same_user($reply['user_id'])):?>										
																				<button class="reply-btn btn btn-sm btn-success py-0"  data-id="<?php echo $comment['id']; ?>">Reply</button>
																			<?php endif ?>
																		</div>
																	</div>															
																</div>
															<?php endforeach ?>
														<?php endif ?>
												</div><!-- // comment -->	
											<?php endforeach ?>										
											<?php else: ?>
										<h4 class='comment_call' id="comment_call_<?php echo $post['id']?>">Be the first to comment on this post</h4>
										<?php endif ?>
									</div><!-- comments wrapper -->
								</div>
							</div>
							<?php endif ?><!-- dont show anything if post is not released except the message -->
					</div><!-- full post-div -->
				</div>	<!-- post-wrapper -->
			</div> <!--content -->
			<?php endforeach?>
		</div> 
		<?php include_once(USER_INCLUDES.'minimal_footer.php'); ?>
			<div class=" col-md-2 mx-0 px-0 d-none d-sm-block">						
						<?php if ($check->is_user()):?>
							<?php include_once(USER_INCLUDES.'/chatbox.php');?>
						<?php endif ?>
			</div>
	</div>
</div><!-- container div end -->

<div class="ajax-loader text-center">
			<i class="fa fa-spinner fa-pulse fa-3x text-secondary"></i> <h4 class="d-inline"> Loading more posts...</h4>
            </div>
            <div class="finished text-center">
                <h4>No more posts available...</h4>
			</div>
			<?php include_once(USER_INCLUDES.'minimal_footer.php'); ?>
            <script type="text/javascript">
$(document).ready(function(){
        windowOnScroll();
});
function windowOnScroll() {
       $(window).on("scroll", function(e){
        if ($(window).scrollTop() == $(document).height() - $(window).height()){
            if($(".post-wrapper").length < $("#total_count").val()) {
                var lastId = $(".post-wrapper:last").attr("id");
                getMoreData(lastId);
			}
			else
			$('.finished').show();			
        }
    });
}

function getMoreData(lastId) {
	   $(window).off("scroll");	   
    $.ajax({
        url: 'getMoreData.php?lastId=' + lastId,
        method: "get",	
        beforeSend: function ()
        {
			$('.ajax-loader').show();
			$('.no-post').remove();
        },
        error:function()
        { 
            $('.finished').show();            
        } ,
        complete: function () {
            $('.ajax-loader').hide();
        },
        success: function (data) {            
            $(".postwall").append(data);
        	setTimeout(function() {                      
            windowOnScroll();
        	   }, 1000);
        }
   });
}
</script>
<script type="text/javascript" src="<?php echo JS_URL?>comment_system.js" ></script>
<script type="text/javascript" src="<?php echo JS_URL?>user_action.js" ></script>
<?php include_once ( USER_INCLUDES . 'footer.php') ?>

</body>
</html>

