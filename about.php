<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php include_once ( USER_INCLUDES . 'minimal_header.php')?>
<?php include_once(USER_CLASS.'publicview.php');?>
<?php $katha=new publicview;
$data=$katha->ownerData(); ?>
<?php include_once(USER_INCLUDES.'sidebar.php');?>
<link rel="stylesheet" href="<?php echo CSS_URL?>aboutus.css" type="text/css" media="screen" charset="utf-8" />
<link rel="stylesheet" href="<?php echo CSS_URL?>animate.css">
</head>
<body>

<div class="container-fluid">

<!-- Main Navigation -->
<nav class="main-nav text-center ">
	<ul>
	<li><a href="#main" class="active link">Our Vision</a></li>
	<li><a href="#about" class="link">About us</a></li>
	<li><a href="#contact" class="link">Get in touch</a></li>
	</ul>
</nav>
<!-- Slider Controls -->
<a href="" id="arrow_left"><img src="<?php echo ICONS_URL?>arrow-left.png" alt="Slide Left" /></a>
<a href="" id="arrow_right"><img src="<?php echo ICONS_URL?>arrow-right.png" alt="Slide Right" /></a>



<!-- Home Page -->
<section class="content animated zoomIn" id="main_container">
<h1>Welcome</h1>
<h5>Our new site is coming soon!</h5>
<p >Please keep on reading and keep on posting to support our website.
 The post can be both video or text.</p>
<a class="link" href="">More info </a>
</section>

<!-- About Page -->
<section class="content animated zoomIn" id="about_container" style="display:none">
<h1>About</h1>
<h5>Here's a little about what we're up to.</h5>
<p>We are striving to be the most visited blog/website for stories, confessions and experience sharing. 
We are working on some project that will make us achieve this goal.</p>
<p><a href="" class="link">Follow our updates on Twitter</a></p>
</section>



<!-- Contact Page -->
<section class="content animated zoomIn" id="contact_container" style="display:none">
<div class="">
	<h1>Get in touch</h1>
	<h5>You can get connected to us in the following ways</h5>
	<p>Email: <a class="link" href="mailto:<?php echo $data['owner_email'];?>"><?php echo $data['owner_email'];?></a></p>
	Phone: 0<?php echo $data['owner_contact_no'];?></p>
	Postal address: &nbsp <?php echo $data['owner_address'];?>
	<p style="margin:0 0 0 110px;"><?php echo $data['owner_postal_code'];?><br />
	<?php echo $data['owner_country'];?></p>
</div>

<!-- Social Links -->
<nav class="social-nav text-center"  >
	<ul>
	<li><a href="https://www.fb.com/prkhr.pskr"><img src="<?php echo ICONS_URL?>facebook.png" /></a></li>
	<li><a href=""><img src="<?php echo ICONS_URL?>twitter.png" /></a></li>
	<li><a href=""><img src="<?php echo ICONS_URL?>google.png" /></a></li>
	<li><a href=""><img src="<?php echo ICONS_URL?>dribbble.png" /></a></li>
	<li><a href="https://www.linkedin.com/in/prakhar-gyawali-60a687137/"><img src="<?php echo ICONS_URL?>linkedin.png" /></a></li>
	<li><a href=""><img src="<?php echo ICONS_URL?>pinterest.png" /></a></li>
	</ul>
</nav>
</section>



</div>

<!-- Background Slides -->
<div id="maximage">
<div>
<img class="img-fluid"src="<?php echo BACKGROUNDS_URL?>bg-img-1.jpg" alt="" />
<img class="gradient img-fluid" src="<?php echo BACKGROUNDS_URL?>gradient.png" alt="" />
</div>
<div>
<img class="img-fluid"src="<?php echo BACKGROUNDS_URL?>bg-img-2.jpg" alt="" />
<img class="gradient img-fluid" src="<?php echo BACKGROUNDS_URL?>gradient.png" alt="" />
</div>
<div>
<img class="img-fluid" src="<?php echo BACKGROUNDS_URL?>bg-img-3.jpg" alt="" />
<img class="gradient img-fluid" src="<?php echo BACKGROUNDS_URL?>gradient.png" alt="" />
</div>
<div>
<img class="img-fluid" src="<?php echo BACKGROUNDS_URL?>bg-img-4.jpg" alt="" />
<img class="gradient img-fluid" src="<?php echo BACKGROUNDS_URL?>gradient.png" alt="" />
</div>
<div>
<img class="img-fluid"src="<?php echo BACKGROUNDS_URL?>bg-img-5.jpg" alt="" />
<img class="gradient  img-fluid" src="<?php echo BACKGROUNDS_URL?>gradient.png" alt="" />
</div>		
</div>
<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<script src='http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.js'></script>
<script src="<?php echo JS_URL?>jquery.cycle.all.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo JS_URL?>jquery.maximage.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo JS_URL?>container.js" type="text/javascript" charset="utf-8"></script>
<script type="text/javascript" charset="utf-8">
$(function(){
	$('#maximage').maximage({
		cycleOptions: {
		fx: 'fade',
		speed: 1000, // Has to match the speed for CSS transitions in about.css (lines 48 - 71)
		timeout: 5000,
		prev: '#arrow_left',
		next: '#arrow_right',
		pause: 0,
		before: function(last,current){
			if(!$.browser.msie){
				// Start HTML5 video when you arrive
				if($(current).find('video').length > 0) $(current).find('video')[0].play();
			}
		},
			after: function(last,current){
				if(!$.browser.msie){
					// Pauses HTML5 video when you leave it
					if($(last).find('video').length > 0) $(last).find('video')[0].pause();
				}
			}
		},
		onFirstImageLoaded: function(){			
			$('#maximage').fadeIn('fast');
			}
	});
	// Helper function to Fill and Center the HTML5 Video
	$('video,object').maximage('maxcover');
});
</script>
</body>
</html>
<?php include_once ( USER_INCLUDES . 'footer.php') ?>
