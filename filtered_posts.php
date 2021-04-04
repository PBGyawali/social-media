<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');

$article=new article;

	// Get posts under a particular topic
	if (isset($_GET['topic'])) {
		$topic_id = $_GET['topic'];
		$posts =$article->getPublishedPostsByTopic($topic_id);
		$pasts =$article->getTrendingPublishedPostsByTopic($topic_id);
		$topic_name=$article->getTopicNameById($topic_id);
	}
 include_once(USER_INCLUDES.'minimal_header.php'); 
  include_once(USER_INCLUDES.'sidebar.php');?>
	<title><?php echo $website_name; ?> </title>
</head>
<body>

<div class="container container-fluid my-0 mb-8">
	<!-- content -->
	<div class="content ">
		<h2 class="content-title text-primary mt-2 my-0">
		Recent Articles on <u><?php echo $topic_name; ?></u>
		</h2>	
<div class="row mt-3">
<?php foreach ($posts as $post): ?>
  <div class="col-xs-12 col-sm-6 col-md-4">
  <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
    <div class="card mb-5">	
      <img src="<?php echo POST_IMAGES_URL.(!empty ($post['image'])?$post['image']:'no thumbnail.png'); ?>" class=" "  height="200" width="100%" alt="..."    />
      <div class="card-body">
        <h5 class="card-title"><?php echo ucfirst($post['title']) ?></h5>
        <p class="card-text">
		<span class="text-secondary">Author: 
							<?php if ($post['anonymity'] == 'yes'): ?>
								Anonymous
							<?php else: ?>
								<?php  
								if (!empty($post['first_name'])|| !empty($post['last_name']))									
									$author=implode(' ',array($post['first_name'],$post['last_name']));	
								else if (!empty($post['username'])) 								
									$author=$post['username'];								
								else								
									$author="anonymous"; 								
								echo ucwords($author); 
								?>			
							<?php endif ?>
							</span>	</p>	<p>			
							<span class="text-secondary"><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span></p>
							<p class="text-primary"><span class=" float-right mr-1">Read more...</span>
        </p>
      </div>
      <div class="card-footer">
        <small class="text-secondary">Last updated: <time class="timeago" datetime="<?php echo $post['updated_at']?>"><?php if (!$post['updated_at']) echo'unknown';?></time></small>
	  </div>	  
	  </a>
    </div>
  </div>
  <?php endforeach ?>
</div>




</div>
<div class="content ">
		<h2 class="content-title text-primary mt-2 my-0">
			Trending Articles on <u><?php echo $topic_name; ?></u>
		</h2>	
<div class="row mt-3">
<?php foreach ($pasts as $post): ?>
  <div class="col-xs-12 col-sm-6 col-md-4">
  <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
    <div class="card mb-5">	
      <img src="<?php echo POST_IMAGES_URL.(!empty ($post['image'])?$post['image']:'no thumbnail.png'); ?>" class=" "  height="200" width="100%" alt="..."    />
      <div class="card-body">
        <h5 class="card-title"><?php echo ucfirst(htmlspecialchars($post['title'])) ?></h5>
        <p class="card-text">
		<span class="text-secondary">Author: 
							<?php if ($post['anonymity'] == 'yes'): ?>
								Anonymous
							<?php else: ?>
								<?php  
								if (!empty($post['first_name'])|| !empty($post['last_name']))									
									$author=implode(' ',array($post['first_name'],$post['last_name']));	
								else if (!empty($post['username'])) 								
									$author=$post['username'];								
								else								
									$author="anonymous"; 								
								echo ucwords($author); 
								?>			
							<?php endif ?>
							</span>	</p>	<p>			
							<span ><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span></p>
							<p class="text-primary"><span class=" float-right mr-1">Read more...</span>
        </p>
      </div>
      <div class="card-footer">
        <small class="text-secondary">Last updated: <time class="timeago" datetime="<?php echo $post['updated_at']?>"><?php if (!$post['updated_at']) echo'unknown';?></time></small>
	  </div>	  
	  </a>
    </div>
  </div>
  <?php endforeach ?>
</div>




</div>
</div>
<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<?php include_once(USER_INCLUDES.'footer.php'); ?>