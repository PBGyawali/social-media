<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
  $article=new article; 
  if(!$article->is_login())
  $article->redirect(BASE_URL."#login",'error','You must log in first to view the page');
  else
  $posts=$article-> getPublishedPosts();
	include_once ( USER_INCLUDES .'minimal_header.php'); 
	include_once(USER_INCLUDES.'sidebar.php');?>
<link rel="stylesheet" href="<?php echo CSS_URL?>userhome.css">
<title>Home</title>
<script type="text/javascript" src="<?php echo JS_URL?>hash.js"></script> 
</head>
<html>
<body > 
	<div class="container container-fluid mt-3">
		<div class="row">
			<div class="col-md-12 pl-0">
				<div class=user_info>
					<h2><b>Hi </b><strong style="color: green";><?php echo $username; ?></strong>,
				</div>
				<div class="welcome">
				<h2>Welcome to <?php echo $website_name; ?></b></h2>
				</div>
				<div class="info">
					<Section>
						<p class="mt-7">
							This is a website meant to bring interested readers and creative writers into one platform.
							If you have some creative stories then dont forget to post it to us
							by clicking on the contact us button.To know more about us click on Submit Post button located on the
							left side of this page. 
						</p>
					</Section>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12"> 				
					<Section class=topic>
						<h3 class="content-title"><b>Here you can read following type of stories</b>:</h3>
						<div class="table-div">
								<?php if (empty($topics)): ?>
									<h1>Till now we do not have any topics in the database.</h1>
								<?php else: ?>
									<div class="col-md-5">
										<table class="table text-warning table-responsive text-left">
											<thead >
												<th>S.N.</th>
												<th>Topic Name</th>
											</thead>
											<tbody> 
												<?php foreach ($topics as $key => $topic): ?>
												<tr>
													<td><?php echo $key + 1; ?></td>
													<td> 						
														<a href="<?php echo BASE_URL.'filtered_posts.php?topic='.$topic['id']?> " target="_blank">
														<?php echo $topic['name']; ?></a>
													</td>
												</tr>
												<?php endforeach ?>
											</tbody>
										</table>
									</div>
								<?php endif ?>							
						</div>
					</section>
					<div class="col-md-7">
					</div >
				</div>
			</div>
		</div>

		<div class="row">
			<div class="col-md-12 pl-0">
				<p style="font-size:8;">We prefer inspiring stories as a video. You will be rewarded as a top user is your video reaches a huge view.</p>
				<p>Here is a demo video for you...</p></style>
				<div class="imlk" >	
					<a data-fancybox href="https://www.youtube.com/watch?v=YRgSvRp676I" data-width="1600" data-height="900" >
					<img class="card-img-top img-fluid" src="https://i.ytimg.com/vi/YRgSvRp676I/maxresdefault.jpg" /></a>
				</div>
			</div>
		</div>
		<div class="row mt-5 px-0">
			<div class="col-12">

			<h2>These are some of the recent articles</h2>
			</div>
		</div>
		<div class="row mt-3">
<?php foreach ($posts as $post): ?>
  <div class="col-xs-12 col-sm-6 col-md-4">
  <a href="single_post.php?post-slug=<?php echo $post['slug']; ?>">
    <div class="card mb-5">	
	  <img src="<?php echo POST_IMAGES_URL.(!empty ($post['image'])?$post['image']:'no thumbnail.png'); ?>" class=" "  height="200" width="100%" alt="..."    />
	  <?php if (isset($post['topic']['name'])): ?>
		<a 
			href="<?php echo BASE_URL . 'filtered_posts.php?topic=' . $post['topic']['id'] ?>"target='_blank' class="btn category">
			<?php echo $post['topic']['name'] ?>
		</a>
	<?php endif ?>
      <div class="card-body">
        <h5 class="card-title text-warning"><?php echo ucfirst($post['title']) ?></h5>
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
							<span class="text-warning"><?php echo date("F j, Y ", strtotime($post["created_at"])); ?></span></p>
							<p class="text-primary post_info mb-0 pb-0"><span class=" float-right mr-1 read_more">Read more...</span>
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


		<div class="row">
			<div class="col-md-9 w-100">
			<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
			<?php include_once ( USER_INCLUDES . 'footer.php') ?>
			</div>
		</div>
	</div>
</body>
</html>

<script src="<?php echo JS_URL?>jquery.fancybox.min.js"></script>
<link rel="stylesheet" href="<?php echo CSS_URL?>jquery.fancybox.min.css" />