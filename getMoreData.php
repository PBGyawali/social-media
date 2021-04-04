<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
 include_once(USER_CLASS.'publicview.php'); 
  include_once(USER_SERVER.'comment_server.php'); 
 include_once(USER_SERVER.'user_action_server.php');
 $article=new article; 
 $past =$article-> getPublishedPosts();
  ?>
<?php if (isset($_GET['lastId'])  && !empty($_GET['lastId'])): ?>
    <?php     
        $lastId = $_GET['lastId'];
        $article->query = "SELECT * FROM posts WHERE id < '" .$lastId . "' ORDER BY id DESC LIMIT 3";
        $article->execute(); 
        $posts= $article->statement_result();?>

        <?php if ($posts):?>
            <?php foreach($posts as $post):?>
                <div class="content d-flex" >	
                    <div class="post-wrapper w-100" id="<?= $post['id']; ?>">
                        <div class="full-post-div pl-1 ">
                            <?php if ( $post['published'] != false): ?>							
                                    <input type="hidden" id="action_server" value="<?= USER_SERVER_URL.'user_action_server.php'; ?>" />							
                                <h3 class="post-title d-inline text-dark"> 
                                <?php if ($post['anonymity'] == 'yes'): ?>
                                    <img src="<?= USER_IMAGES_URL.'user_profile.png'; ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
                                    <?= 'Anonymous'; ?>
                                <?php else: ?>
                                    <img src="<?= USER_IMAGES_URL.urlencode($article->Get_profile_image($post['user_id'])); ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">                
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
                                            <?= '<button type="button" class="action_button btn btn-sm btn-primary " data-user_id="'.$user_id.' " data-action="follow" data-receiver_id="'.$post['user_id'].'">UnFollow</button>';?>
                                        <?php else: ?>		
                                            <?= '<button type="button" class="action_button btn btn-sm btn-success " data-user_id="'.$user_id.'" data-action="unfollow" data-receiver_id="'.$post['user_id'].'"><i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow</button>';?>
                                        <?php endif ?>			      
                                    <?php endif ?>
                                <?php endif ?>				
                            
                                <h4 class="post-title"><?= ucfirst($post['title']); ?></h4>
                                <div class="post-body-div p-0 d-inline-block" style="max-width:90%">                
                                    <?= html_entity_decode(html_entity_decode(html_entity_decode(substr($post['body'], 0, 200)))); ?> ... <p class="post-link"><a class="post-title" target="_blank" href="single_post.php?post-slug=<?= $post['slug']; ?>">Read more...</a></p>
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
                                    <span class="likes"><?= getLikes($post['id']); ?></span>
                                    <i 
                                    <?php if (userDisliked($post['id'])): ?>
                                        class="rating-btn fa fa-thumbs-down text-primary dislike-btn"
                                    <?php else: ?>
                                        class="rating-btn fa fa-thumbs-down fa-thumbs-o-down dislike-btn"
                                    <?php endif ?>
                                    data-id="<?= $post['id'] ?>" data-receiver_id="<?= $post['user_id']; ?>" data-user_id="<?= $user_id ?>"></i>
                                    <span class="dislikes">	<?= getDislikes($post['id']); ?>
                                        <?php if (!$check->is_user()) echo "<h3>Please Login to Rate the Post</h3>"?>
                                    </span>	 
                                </div>	<!-- div for like dislike ends here  -->		
                                <div class="row mx-0 pb-5">
                                    <div class="col-md-12 comments-section">
                                        <!-- if user is not signed in, tell them to sign in. If signed in, present them with comment form -->
                                        <?php if ($check->is_user()): ?>
                                        <form class="clearfix" action="single_post.php" method="post" id="comment_form" style="display:none">
                                            <textarea name="comment_text" placeholder="Start the discussion" id="comment_text" class="form-control" cols="30" rows="3"></textarea>
                                            <input type="hidden" name="post_id" id="post_id" value="<?= $post['id'] ?>">
                                            <button class="btn btn-success btn-sm float-right" type="submit" name ="comment_posted" id="submit_comment">Submit comment</button>
                                        </form>
                                        <?php else: ?>
                                        <div class="sign-up mt-5" >
                                            <h3 class="text-center"><a href="<?= BASE_URL.'index.php#login'; ?>">Sign in</a> to post a comment</h3>
                                        </div>
                                        <?php endif ?>
                                        <?php $comments=getallcomments($post['id']); ?>
                                        <!-- Display total number of comments on this post  -->
                                        <h2><span id="comments_count"><?= count($comments) ?></span> Comment(s)</h2>
                                            <!-- comments wrapper -->
                                        <div id="comments-wrapper" style="display:none">
                                            <?php if (isset($comments) && $comments!=null): ?>
                                                <?php foreach ($comments as $comment): ?>											
                                                    <div class="comment clearfix" id="comment_<?= $comment['id']?>">
                                                        <div class="comment-details" id="comment__details_<?= $comment['id']?>">
                                                            <div id="profilepic_<?= $comment['id']?>">
                                                                <img src="<?= USER_IMAGES_URL.urlencode(getProfilePictureById($comment['user_id'])) ?>" height="40px" width="40px" alt="profile picture" class="profile_pic rounded-circle">
                                                            </div>
                                                            <div class="comment_info">
                                                                <a class="comment-name" href="profile.php?user=<?= $comment['user_id']?>"><?= getUsernameById($comment['user_id']) ?></a>
                                                                <span class="comment-date"><?= date("F j, Y ", strtotime($comment["created_at"])); ?></span>
                                                                <p class="comment_value"><?= $comment['body']; ?></p>
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
                                                                            <img src="<?= USER_IMAGES_URL.urlencode(getProfilePictureById($reply['user_id'])) ?>" alt="" height="40px" width="40px" class="profile_pic rounded-circle">
                                                                            <div class="comment-details">
                                                                                <a class="comment-name" href="profile.php?user=<?= $reply['user_id']?>"><?= getUsernameById($reply['user_id']) ?></a>
                                                                                <span class="comment-date"><?= date("F j, Y ", strtotime($reply["created_at"])); ?></span>
                                                                                <p><?= ($reply['body']); ?></p>
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
                                            <h2 id="comment_call">Be the first to comment on this post</h2>
                                            <?php endif ?>
                                        </div><!-- comments wrapper -->
                                    </div>
                                </div>
                                <?php endif ?><!-- dont show anything if post is not released except the message -->
                        </div><!-- full post-div -->
                    </div>	<!-- post-wrapper -->
                </div> <!--content -->
                <?php endforeach?>
        <?php else:?>  
            <?= '<h4 class="text-center no-post" >No more post to load</h4>';?>
        <?php endif?>  

<?php else: ?>
    <?=' <h4 class="text-center no-post">No post found</h4>';?>  
<?php endif?>