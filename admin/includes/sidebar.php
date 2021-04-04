<?php  
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php'); 
$records=new records;
$messages =$records-> allunseenOfflineMessages();
$alerts =$records-> allunreadalerts();
$website_name=$_SESSION['website_name'];
$user_type= (isset($_SESSION['user_type']))?$_SESSION['user_type']:'';
$username=(isset($_SESSION['username']))? ucwords($_SESSION['username']):'';
$user_id=(isset($_SESSION['id']))? ucwords($_SESSION['id']):'';
$profileimage=(isset($_SESSION['profile_image']))? $_SESSION['profile_image']:'';
$index_active=$userlist_active=$tickets_active=$posts_active =$topics_active=
$non_visitable_places=$manage_article='inactive_class';					
${$page_name."_active"} = 'active_class';
if($page_name == 'posts'|| $page_name =='topics')$manage_article='active_class' ;
?>
<div class="container-fluid fixed-top bg-dark py-3" style="z-index:1049;">
	    <div class="row">	       
	        <div class="col-7">
	            <!-- toggler -->
	            <a data-toggle="collapse" href="" data-target=".collapse" role="button">
					<h3 class="mt-2 mb-2 text-white text-center"><?php echo $website_name?> <?php echo ucwords($user_type);?> Panel</h3>
	            </a>
			</div><div class="col-5  text-center">
			<div class="d-flex flex-column" >
                <nav class="navbar navbar-light navbar-expand topbar static-top">                             
                        <ul class="nav navbar-nav flex-nowrap ml-auto">
                            <li class="dropdown mx-1" role="presentation">
								<div class=" dropdown "><a class="dropdown" data-toggle="dropdown" aria-expanded="false" style="cursor:pointer">
								<span class="badge badge-danger badge-counter" id="alertcount">
									<?php $alertcount=$records->AlertCount();echo (($alertcount>0)?$alertcount:"").(($alertcount>=4)?"+":"") ;?></span>
									<i class="fas fa-bell fa-fw"></i></a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-list dropdown-menu-right animated--grow-in"
                                        role="menu">
										<h6 class="dropdown-header alert-primary text-center">alerts center</h6>
										<?php if (isset($alerts) &&!empty($alerts)): ?>
											<?php foreach ($alerts as $key => $alert): ?>
												<a class="d-flex align-items-center dropdown-item" style="cursor:pointer">
												<div class="mr-3">
												<?php 
												$iconclass=' text-primary ';
												$iconsymbol=' fas fa-file-alt ';  
												$alerttypes=array("comment","reply","money","update","delete","warning",
												"unfollow","follow","dislike","like","reset");
												$icontype=array("comment","comments","donate","sync","trash","exclamation-triangle","user-minus",
												"user-plus","thumbs-down","thumbs-up","reply");                                        
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
											<a class="text-center dropdown-item small text-gray-500" href="allalerts.php">Show All Alerts</a>
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
								</div>
							</div>
						</li>
			
				<!--alert div ends here-->
				<li class="dropdown mx-1" role="presentation">
					<div class=" dropdown "><a class="dropdown position-relative mr-2" data-toggle="dropdown" aria-expanded="false" style="cursor:pointer">
					<i class="fas fa-envelope fa-fw"></i>
					<span class="badge badge-danger badge-counter position-absolute py-0  ml-0 mr-2" style="top:0;left:2;" id="messagecount">
					<?php  $messagecount=$records->MessageCount();echo (($messagecount>0)?$messagecount:"").(($messagecount>=3)?"+":"")?></span></a>																													
					<div class="dropdown-menu dropdown-menu-right "	role="menu">
						<h6 class="dropdown-header alert-primary text-center">Your Messages</h6>
			<?php if (isset($messages) &&!empty($messages)): ?>
					<?php foreach ($messages as $key => $message): ?>
			<div class="dropdown">
				<div class="dropdown-list  ">
					<a class="d-flex align-items-center dropdown-item" style="cursor:pointer">
						<div class="dropdown-list-image mr-3"><img class="rounded-circle" src="<?php echo USER_IMAGES_URL.rawurlencode($message['profile_image']); ?>"height="60" width="60">
						<div class="badge status-indicator bg-transparent spinner-grow spinner-grow-sm spinner-border-sm d-inline mt-5 text-left position-absolute" role="status" style="z-index:5;margin-left:-17px;"> 
        					<i class="fa fa-circle text-success" aria-hidden="true"></i></div>
						</div>
						<div class="font-weight-bold">
							<div class="d-inline-block text-truncate" style="max-width: 350px;"><span><?php echo $message['message']; ?></span></div>
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
								<div class="shadow dropdown-list dropdown-menu  dropdown-menu-right " aria-labelledby="alertsDropdown"></div>
                            </li>                    
                            <li class="dropdown" role="presentation">							
							<a data-toggle="dropdown" aria-expanded="false"  style="cursor:pointer" class="no-border p-0 m-0 bg-transparent"><span id="current_user" class="text-white"><?php echo $username?></span> <span id="user_uploaded_image_small" class="mt-0"><img src="<?php echo USER_IMAGES_URL.rawurlencode($profileimage); ?>" class="img-fluid rounded-circle" width="30" height="30"/></a></span>
									<div class="dropdown-menu shadow dropdown-menu-right animated zoomIn" role="menu">
										<a class="dropdown-item" role="presentation" href="<?php echo ADMIN_URL.'profile.php'?>"><i class="fas fa-id-badge fa-fw mr-2 text-gray-400"></i>&nbsp;Profile</a>
										<a class="dropdown-item" role="presentation" href="<?php echo ADMIN_URL.'change_password.php'?>"><i class="fas fa-key fa-fw mr-2 text-gray-400"></i>&nbsp;Password</a>
										<a class="dropdown-item" role="presentation" href="<?php echo ADMIN_URL?>settings.php"><i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Settings</a>
										<a class="dropdown-item" role="presentation" href="<?php echo ADMIN_URL?>activitylog.php"><i class="fas fa-list fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Activity log</a>
										<div class="dropdown-divider"></div><form action="<?php echo BASE_URL.'logout.php'?>" method="post" class="logout_form"><button class="dropdown-item logout" role="presentation" type="submit" title="Clicking this button will log you out."><i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>&nbsp;Logout</button></form></div>
                    				</div>
							</li>
					
	        </div> 
	    </div>
	</div></div>
	<div class="container-fluid mt-1 pt-6">
	    <div class="row vh-100 flex-nowrap">
	        <div class="col-2 collapse show sidebar vh-100 bg-dark position-fixed">
	            <ul class="nav flex-column flex flex-fill sidebar vh-100" id="sidebar" >	            	
					<li class="nav-item text-center">
                    <span id="user_uploaded_image_medium">
					<img src="<?php echo USER_IMAGES_URL.rawurlencode($profileimage); ?>" class="rounded-circle mb-0 " width="100" height="100"/></li></span>
	            	<li class="nav-item">
	                    <a class="nav-link <?php echo $index_active; ?>" href="<?php echo ADMIN_URL?>"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-tachometer-alt"></i> Dashboard</span></a>
	                </li>
	            	<?php
	            	if($check->is_master_admin()):?>
	            	<li class="nav-item">
	                    <a class="nav-link <?php echo $userlist_active; ?>" href="<?php echo ADMIN_URL.'userlist.php'?>"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-users"></i> Manage Users</span></a>
					</li>
                    <?php endif 	?>
					<li class="nav-item">									
					<a class="nav-link dropdown-btn <?php echo $manage_article; ?>"><span title="Click to view and manage your post" class="ml-2 d-none d-sm-inline dropdown-toggle">&nbsp; Manage Article </span> </a>
						<div class="dropdown-container animated zoomIn">					
						<a class="nav-link <?php echo $posts_active; ?>" href="<?php echo ADMIN_URL.'posts.php'?>"><span class="ml-2 d-none d-sm-inline"><i class="far fa-newspaper"></i> &nbsp;&nbsp; Manage posts</span></a>
						<a class="nav-link <?php echo $topics_active; ?>" href="<?php echo ADMIN_URL.'topics.php'?>"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-key"></i>&nbsp;&nbsp;Manage Topics</span></a>
  						</div>
	                </li>
	                <li class="nav-item">
	                    <a class="nav-link <?php echo $tickets_active; ?>" href="<?php echo ADMIN_URL.'tickets.php'?>"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-ticket-alt"></i>&nbsp;&nbsp;Tickets</span></a>
	                </li>  
					<li class="nav-item">
	                    <a class="nav-link inactive_class" href="<?php echo BASE_URL.'home.php'?>" title="View the website as a normal user"><span class="ml-2 d-none d-sm-inline"><i class="fas fa-user"></i>&nbsp;&nbsp;User Panel</span></a>
					</li>	
	            </ul>
			</div>
			<div class="col offset-2 py-4">
    <script src="<?php echo JS_URL.'confirmdefaults.js'?>"></script>
    <script src="<?php echo JS_URL.'confirm.js'?>"></script>
    <script src="<?php echo JS_URL.'dropdown_button.js'?>"></script>
            