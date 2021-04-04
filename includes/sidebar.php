<?php  
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$records=new records;
if($records->is_user()){
	$messages = $records->allOfflineMessages();
	$alerts = $records->allalerts();
}
if(!isset($_SESSION['website_name'])||empty($_SESSION['website_name'])||!isset($_SESSION['website_logo'])||empty($_SESSION['website_logo'])){
	$website_data=$records->getArray('website_data');
	$_SESSION['website_name']=$website_data['website_name'];
	$_SESSION['website_logo']=$website_data['website_logo'];
	$_SESSION['website_icon']=$website_data['website_logo'];
}
$topics = $records->getAllArray('topics');
$welcome_active=$dashboard_active=$about_active=$manage_article=$home_active=$topics_active='inactive_page';					
${$page."_active"} = 'active_page';
if($page == 'posts'|| $page =='post')$manage_article='active_page';
if($page == 'filtered_posts')$topics_active='active_page';
$website_name=$_SESSION['website_name'];
$user_type= (isset($_SESSION['user_type']))?$_SESSION['user_type']:'';
$username=(isset($_SESSION['username']))?ucwords($_SESSION['username']):'';
$website_logo=$_SESSION['website_logo'];
$profileimage=(isset($_SESSION['profile_image']))? $_SESSION['profile_image']:'';
$user_id=$check->is_user()?$_SESSION['id']:"";
?>
</head>
<body class="p-0">
<div class="container-fluid bg-dark d-inline p-0 " style="z-index:1049;">
<?php if(in_array($page,array('dashboard','home','welcome'))):  ?>
<div class="row ">
	<img src="<?php echo LOGO_URL.'new_banner.jpg'?>" alt="Banner" class="img-fluid">
</div >
<?php  endif ?>
	    <div class="row sticky-top py-0">
		<div class="col-4 bg-dark pr-0 ">  
			<div class="row">
				<div class="col-2 text-right pr-1 mr-0"> 
					<img src="<?php echo LOGO_URL.'logo2_4_02_01_21_7052.png'; ?>"class="img-fluid mt-0 pt-0" width="45" height= "45">	
				</div>
				<div class="col-10 text-left pl-0 ml-0 my-auto">  
					<h3 class="mb-0 pb-0 text-white "><?php echo $website_name?></h3>
				</div>
			</div>		
		</div>
		<div class="col-8 text-center pl-0">
			<div class="d-flex flex-column" >
                <nav class="navbar navbar-light bg-dark navbar-expand topbar static-top">
				<ul class="nav navbar-nav flex-nowrap ml-auto">
				<?php if($check->is_login()):  ?> 
					<?php if($check->is_user()):  ?>		
					<li ><a href="dashboard.php"><span class="btn btn-primary btn-sm mr-2 <?php echo $dashboard_active ?> "> <i class="fas fa-tachometer-alt"></i> Dashboard</span></a></li>
					<li ><a  href="home.php"><span class="btn btn-primary btn-sm mr-2 <?php echo $home_active ?> "><i class="fas fa-home"></i> Home</span></a></li>	
					<?php else:  ?>
					<li ><a  href="welcome.php"><span class="btn btn-primary btn-sm mr-2 <?php echo $welcome_active ?> "><i class="fas fa-home"></i> Home</span></a></li>	
					<?php endif  ?>
				<?php endif  ?>
				
		<li ><a  href="about.php"><span class="btn btn-primary btn-sm mr-2 <?php echo $about_active ?>"><i class="far fa-smile-beam"></i> About</span></a></li>		
        <li ><a class="contactus"  data-toggle="modal" data-receiver_type="user" data-id="<?php echo  '1';?>" data-target="#messageModal"> <span class="btn btn-primary btn-sm mr-1"><i class="fas fa-envelope"></i> Contact</span></a></li>  
        <?php if ($check->is_login()): ?>      
			<?php if($check->is_user()):  ?> 
				<ul class="nav navbar-nav flex-nowrap ml-auto">
				<li class="dropdown mx-1" role="presentation">
						<div class="dropdown"><a class="dropdown" data-toggle="dropdown" aria-expanded="false" ><span class="btn btn-primary btn-sm <?php echo $manage_article ?>"> <i class="fa fa-caret-down"></i> Article</span></a>
							<div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
								role="menu">                                        
								<a class="d-flex align-items-center dropdown-item" href="post.php">
									<div class="mr-3">                                            
										<div class="text-dark ">Create Article</div>        
									</div>							
								</a>  
								<a class="d-flex align-items-center dropdown-item" href="posts.php">
									<div class="mr-3">                                            
										<div class="text-dark ">Manage Article</div>        
									</div>							
								</a>  	
							</div>
					</li>
					<?php endif ?>  
				<?php endif ?>

				<li class="dropdown mx-1" role="presentation">
					<div class="dropdown"><a class="dropdown" data-toggle="dropdown" aria-expanded="false" ><span class="btn btn-primary btn-sm <?php echo $topics_active ?>"><i class="fa fa-caret-down"></i> Topics</span></a>
						<div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
							role="menu">
							<?php foreach ($topics as $topic): ?>
								<a class="d-flex align-items-center dropdown-item" href="<?php echo BASE_URL . 'filtered_posts.php?topic='.$topic['id'] ?>">
								<div class="mr-3">                                            
									<div class="text-dark "><?php echo ucwords($topic['name']); ?></div>        
								</div>
								<div>
								</div>
								</a>  
							<?php endforeach ?>
					</div>
				</li>
				<?php if ($check->is_login()): ?>
					<?php if ($check->is_admin()) :?>         
					<li > <a href="admin/"><span class="btn btn-primary btn-sm mr-3">Admin Panel</a></li>
					<?php endif?>
						
					<?php if ($check->is_user()) :?> 
					<li class="dropdown mx-1" role="presentation">
							<div class="dropdown"><a class="dropdown positon-relative ml-2" data-toggle="dropdown" aria-expanded="false" >
								<span id="alertcount" class="badge badge-danger badge-counter position-absolute py-0 pr-1 mr-2" style="top:0;right:0;">
								<?php  $alertcount=$records->AlertCount();echo (($alertcount>0)?$alertcount:"").(($alertcount>=3)?"+":"")?></span>
								<i class="fas fa-bell fa-fw "></i></a>
								<div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
									role="menu">
									<h6 class="dropdown-header alert-primary text-center">alerts center</h6>
									<?php if (isset($alerts) &&!empty($alerts)): ?>
									<?php foreach (array_slice($alerts, 0, 5)  as $key => $alert): ?>
										<a class="d-flex align-items-center dropdown-item" style="cursor:pointer">
										<div class="mr-3">
											<?php 
												$iconclass=' text-primary ';
												$iconsymbol=' fas fa-file-alt ';  
												$alerttypes=array("comment","reply","money","update","delete",
												"warning","unfollow","follow","dislike","like","reset");
												$icontype=array("comment","comments","donate","sync","trash","exclamation-triangle",
												"user-minus","user-plus","thumbs-down","thumbs-up","reply");                                        
												if     (in_array($alert['type'],(array_slice($alerttypes,0,2)))) $iconclass=' text-info ';
												elseif (in_array($alert['type'],(array_slice($alerttypes,2,2)))) $iconclass=' text-success ';
												elseif (in_array($alert['type'],(array_slice($alerttypes,4,2)))) $iconclass=' text-danger ';
												elseif (in_array($alert['type'],(array_slice($alerttypes,6,1)))) $iconclass=' text-secondary ';
												foreach($alerttypes as $key=> $alerttype)  
													if($alert['type']== $alerttype) 
														break;												                    
											?>										
											<div class="icon-circle "><i class="fa fa-<?=$icontype[$key].$iconclass?>"></i></div>                                                 
										</div>
										<div><span class="small text-gray-500"><?php echo $alert['alert_date']; ?></span>
											<p class="d-block text-truncate pb-0 mb-0" style="max-width: 450px;"><?php echo $alert['alert']; ?></p>
										</div>
									</a>  
								<?php endforeach ?>
									<a class="text-center dropdown-item small text-gray-500" href="allalerts.php">Show All Alerts</a></div>
								<?php else: ?>
									<div class="row ">
									<div class="col-lg-12 col-xl-12 col-sm-6">
										<div class="card shadow mb-1">
											<div class="card-header d-flex text-center justify-content-between align-items-center">
												<h6 class="text-primary font-weight-bold m-0 ">
													<a class="d-flex align-items-center dropdown-item " >										
														<div>									
															<p class="text-center"> <i class="far fa-folder-open text-danger"></i> No Alerts to show.</p>
														</div>
													</a> 
												</h6>
											</div>
										</div>
									</div>
								</div>
								<?php endif ?>									
						<!--one div was deleted for css reasons-->
						</div>
					</li>
					<!--alert div ends here-->
					<li class="dropdown mx-1" role="presentation">
					<div class=" dropdown "><a class="dropdown position-relative mr-2" data-toggle="dropdown" aria-expanded="false" style="cursor:pointer">
					<i class="fas fa-envelope fa-fw"></i>
					<span class="badge badge-danger badge-counter position-absolute py-0 pr-0 ml-0 mr-2" style="top:0;left:2;" id="messagecount">
					<?php  $messagecount=$records->MessageCount();echo (($messagecount>0)?$messagecount:"").(($messagecount>=3)?"+":"")?></span></a>																													
					<div class="dropdown-menu dropdown-menu-right "	role="menu">
						<h6 class="dropdown-header alert-primary text-center">Your Messages</h6>
					<?php if (isset($messages) &&!empty($messages)): ?>
							<?php foreach (array_slice($messages, 0, 5) as $key => $message): ?>
					<div class="dropdown">
						<div class="dropdown-list  ">
							<a class="d-flex align-items-center dropdown-item" style="cursor:pointer">
								<div class="dropdown-list-image mr-3"><img class="rounded-circle" src="<?php echo USER_IMAGES_URL.rawurlencode($message['profile_image']); ?>"height="60" width="60">
								<div class="badge status-indicator bg-transparent spinner-grow spinner-grow-sm spinner-border-sm d-inline mt-5 text-left position-absolute" role="status" style="z-index:5;margin-left:-17px;"> 
									<i class="fa fa-circle text-success" aria-hidden="true"></i></div>
								</div>
								<div class="font-weight-bold">
									<div class="d-inline-block text-truncate" style="max-width: 350px;"><span><?php echo htmlspecialchars($message['message']); ?></span></div>
									<p class="small text-gray-500 mb-0"><?php echo $message['username']; ?> -<time class="timeago" datetime="<?php echo $message['sent_on']; ?>"></time></p>
								</div>
							</a>
						</div>
					</div>
						<?php endforeach ?>
						<a class="text-center dropdown-item small text-gray-500" href="allmessages.php">Show All Messages</a>
						<?php else: ?>
							<div class="row ">
						<div class="col-lg-12 col-xl-12 col-sm-6">
						<div class="card shadow mb-1">
						<div class="card-header d-flex text-center justify-content-between align-items-center">
						<h6 class="text-primary font-weight-bold m-0 ">
						<a class="d-flex align-items-center dropdown-item " >					
							<div>
								<p class="text-center"><i class="fas fa-frown text-dark"></i> No Messages to show.</p>
							</div>
						</a> </h6>
						</div>
						</div>
						</div>
						</div>
						<?php endif ?></div>
										</div>
								<!--message div ends here-->								
						<div class="shadow dropdown-list dropdown-menu  dropdown-menu-right animated zoomIn" aria-labelledby="alertsDropdown"></div>
								</li>                    
								<li class="dropdown " role="presentation">
							
							<a data-toggle="dropdown" class="position-relative" aria-expanded="false" href="#"><span id="user_uploaded_image_small" class="mt-0 text-white ml-1 pl-2"><?php echo $username?> <img src="<?php echo USER_IMAGES_URL.rawurlencode($profileimage); ?>" class="img-fluid rounded-circle" width="30" height="30"/></a></span>
									<div class="dropdown-menu shadow dropdown-menu-right animated--grow-in" role="menu">
										<a class="dropdown-item" role="presentation" href="<?php echo BASE_URL.'update profile.php'?>"><i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
										<a class="dropdown-item" role="presentation" href="<?php echo BASE_URL?>settings.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
										<a class="dropdown-item" role="presentation" href="<?php echo BASE_URL.'update password.php'?>"><i class="fas fa-key fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Change Password</a>
										<a class="dropdown-item" role="presentation" href="<?php echo BASE_URL.'activitylog.php'?>"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity Log</a>
										<div class="dropdown-divider"></div><form action="<?php echo BASE_URL.'logout.php'?>" method="post" class="logout_form"><button class="dropdown-item logout" role="presentation" type="submit" title="Clicking this button will log you out."><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</button></form></div>
									</div>
							</li>				
			<?php else:?> 
					<li>
						<form action="<?php echo BASE_URL.'logout.php'?>" method="post" class="logout_form">
							<button class="logout btn btn-primary btn-sm" type="submit" >&nbsp;Logout as Guest</button>
						</form>
					</li>
					<li > <a href="index.php#register"><span class="btn btn-primary btn-sm ">Register</a></li>  
			<?php endif?>
    	<?php else:?> 
      		  <li > <a href="index.php#login"><span class="btn btn-primary btn-sm mr-2">Log in as User</a></li>
              <li > <a href="index.php#register"><span class="btn btn-primary btn-sm">Register</a></li>
		<?php endif?>
	        </div> 
	    </div>
	</div></div>
    <script src="<?php echo JS_URL.'confirmdefaults.js'?>"></script>
    <script src="<?php echo JS_URL.'confirm.js'?>"></script>
   
	