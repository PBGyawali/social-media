<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$stats = new stats();
//if(!$stats->is_login())
//$stats->redirect(BASE_URL."#login",'danger','You must log in first to view the page');
//elseif(!$stats->is_admin())	
//$stats->redirect(BASE_URL."admin/");
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
$progresspoints=$stats->get_progress_points();
$target=$stats->get_user_target();
?>
<script type="text/javascript" src="<?= JS_URL?>hash.js"></script> 
<body id="page-top">
			<div class="container container-fluid dashboard ml-0 pl-0 ">
				<a href="profile.php"><h1 >Welcome <?= $username ?></strong></h1></a>
<h3 class="d-flex justify-content-between align-items-center">Here are some stats for <?= $website_name?>:</h3><br>
<div class="d-sm-flex justify-content-between align-items-center mb-4">
  <form action="" method="post">
<button class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" formaction="http://localhost/us_opt1/db_structure.php?server=1&db=registration" formtarget="_blank"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Administrate Database</button></form>
<button class="btn btn-primary btn-sm d-none d-sm-inline-block" role="button" href="#" formtarget="_blank"><i class="fas fa-download fa-sm text-white-50"></i>&nbsp;Generate Report</button>
</div>



                <div class="row ">
                    <div class="col-md-7 col-xl-8 mb-0"> 
                            <h3 >Stats for <strong style="color: green";><?= $username ?></strong>:</h3>
                    </div>
                </div>
               
                <div class="row "> 
                        <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-info py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Profile Complete Progress</span>
                                    </div>
                                        <div class="row no-gutters align-items-center">                                           
                                            <div class="col value-indicator">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" id ="progressbar_1" aria-valuenow="<?= $progresspoints;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $progresspoints;?>%;">
                                                    <span class="sr-only"><?= $progresspoints;?>%</span>
                                                </div>
                                                </div>
											</div>
											<div class="col-auto value-indicator-text">
                                                <div class="text-dark text-right font-weight-bold h5 mb-0 ml-3"><span class="progress-value"><?= $progresspoints;?>%</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div></div>          
				    <div class="col-md-6 col-xl-3 mb-4">  
                        <div class="card shadow border-left-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Total Published Post</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $stats->UserPublishedPosts(); ?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-blog fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-success py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Total post visitors</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $stats->gettotalpostviews(); ?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-user fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span id="followers">Total Followers</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span id="folowers_count"><?= $stats->count_follow_requests();?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-comments fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row ">
                    <div class="col-md-6 col-xl-8 mb-0"> 
                        <h3 >Stats for <?= $website_name?>:</h3>
                    </div>
                </div>

	            <div class="row ">
                <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-warning py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-success font-weight-bold text-xs mb-1"><span>Total Registered Users</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $stats->getAllUsers(); ?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-users fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
				<div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-primary py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-danger font-weight-bold text-xs mb-1"><span>Unverified Account (Email)</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $stats->getUnverifiedEmail();?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-question fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-success py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-warning font-weight-bold text-xs mb-1"><span>Unverified Account (profile)</span></div>
                                        <div class="text-dark font-weight-bold h5 mb-0"><span><?= $stats->getUnverifiedProfile();?></span></div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-calendar fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-xl-3 mb-4">
                        <div class="card shadow border-left-info py-2">
                            <div class="card-body">
                                <div class="row align-items-center no-gutters">
                                    <div class="col mr-2">
                                        <div class="text-uppercase text-info font-weight-bold text-xs mb-1"><span>Total User Target</span></div>
                                        <div class="row no-gutters align-items-center">                                           
                                            <div class="col value-indicator">
                                                <div class="progress progress-sm">
                                                    <div class="progress-bar bg-info progress-bar-striped progress-bar-animated" id ="progressbar_1" aria-valuenow="<?= $target;?>" aria-valuemin="0" aria-valuemax="100" style="width: <?= $target;?>%;"><span class="sr-only"><?= $target;?>%</span></div>
                                                </div>
											</div>
											<div class="col-auto value-indicator-text">
                                                <div class="text-dark text-right font-weight-bold h5 mb-0 ml-3"><span class="progress-value"><?= $target;?>%</span></div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-auto"><i class="fas fa-clipboard-list fa-2x text-gray-300"></i></div>
                                </div>
                            </div>
                        </div></div> 
                    

                </div>
						<div class="row">
	            	<div class="col-12 col-sm-6 col-md-3"><a href="posts.php">
	            		<div class="card text-white bg-info mb-3 stats">
						  	<div class="card-header text-center stats"><span><h4>Published Posts</h4></span></div>
						  	<div class="card-body stats">
						    	<h2 class="card-title text-center stats"><?= $stats->getAllPublishedPosts(); ?></h2>
						  	</div>
						</div></a>
	            	</div>
	            	<div class="col-12 col-sm-6 col-md-3"><a href="posts.php">
	            		<div class="card text-white bg-warning mb-3 stats">
						  	<div class="card-header text-center stats"><span id="published_post"><h4>Unpublished Post</h4></span></div>
						  	<div class="card-body stats">
						    	<h2 class=" text-center stats"><?= $stats->getAllUnPublishedPosts(); ?></h2>
						  	</div>
						</div></a>
	            	</div>
	            	<div class="col-12 col-sm-6 col-md-3"><a href="tickets.php">
	            		<div class="card text-white bg-danger mb-3 stats">
						  	<div class="card-header text-center"><span id="tickets"><h4>Unresolved Tickets</h4></span></a></div>
						  	<div class="card-body">
						    	<h2 class="card-title text-center"><?= $stats->getAllUnResolvedTickets(); ?></h2></a>
						  	</div>
						</div></a>
	            	</div>
	            	<div class="col-12 col-sm-6 col-md-3"><a href="#">
	            		<div class="card text-white bg-success mb-3 stats">
						  	<div class="card-header text-center"><span><h4>Website Visitors</h4></span></div>
						  	<div class="card-body">
						    	<h2 class="card-title text-center"><?= $stats->getAllVisitCount(); ?></h2>
							  </div>							
						</div></a>
						<!--from here starts the new div--> 						
					</div>					
				</div>				
			</div>
            <div class="row "> 
			<div class="col-lg-7 col-xl-8">
				<div class="card shadow mb-4">
					<div class="card-header d-flex justify-content-between align-items-center">
					<h6 ></h6><!--needs to be kept as an element unless new element is added for css reasons-->
						<h6 class="text-primary font-weight-bold m-0"><span class="label" id="label_0">Post</span> Overview (By <span id="type_0">number</span>)</h6>
						<div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v "></i></button>
							<div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"	role="menu">
								<p class="text-center dropdown-header">Action:</p>
								<a role="presentation" id="permonth_0"  class="dropdown-item permonth"     data-id="0" data-month='[<?= $month=$stats->getmonth();?>]' data-monthvalue='[<?= $monthvalue=$stats->getmonthvalue();?>]' style="display:none"> Get only past months value</a>
								<a role="presentation" id="fullmonths_0" class="dropdown-item fullmonths"  data-id="0" data-month='[<?= $stats->getfullmonth();?>]' data-monthvalue='[<?= $stats->getfullmonthvalue();?>]'> Get all month data</a>
								<a role="presentation" id="refresh_0" class="dropdown-item refresh"        data-id="0" data-url="<?= BASE_URL?>event_handler.php" > Refresh</a>
								<div class="dropdown-divider"></div>
								<a role="presentation" id="bargraph_0" class="dropdown-item bargraph" 	 data-id="0" data-type="permonth" > Show bar graphs</a></div>
						</div>
					</div>                                                                                                                                                                     
					<div class="card-body">
						<div class="chart-area" ><canvas id="graph_canvas_0" data-bs-chart="{&quot;type&quot;:&quot;line&quot;,&quot;data&quot;:{&quot;labels&quot;:[<?=$month?>],&quot;datasets&quot;:[{&quot;data&quot;:[<?= $monthvalue?>],&quot;label&quot;:&quot;Post&quot;,&quot;fill&quot;:true,&quot;backgroundColor&quot;:&quot;rgba(78, 78, 78, 0.3)&quot;,&quot;borderColor&quot;:&quot;rgba(78, 115, 223, 1)&quot;}]},&quot;options&quot;:{&quot;responsive&quot;:true,&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false},&quot;title&quot;:{},&quot;scales&quot;:{&quot;xAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;],&quot;drawOnChartArea&quot;:false},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;padding&quot;:20}}],&quot;yAxes&quot;:[{&quot;gridLines&quot;:{&quot;color&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;zeroLineColor&quot;:&quot;rgb(234, 236, 244)&quot;,&quot;drawBorder&quot;:false,&quot;drawTicks&quot;:false,&quot;borderDash&quot;:[&quot;2&quot;],&quot;zeroLineBorderDash&quot;:[&quot;2&quot;]},&quot;ticks&quot;:{&quot;fontColor&quot;:&quot;#858796&quot;,&quot;padding&quot;:20}}]}}}"></canvas></div>
					</div>
				</div>
			</div>					
			
                    <div class="col-lg-5 col-xl-4">
                        <div class="card shadow mb-4">
                            <div class="card-header d-flex justify-content-between align-items-center">
                                <h6 class="text-primary font-weight-bold m-0">Visitor Sources</h6>
                                <div class="dropdown no-arrow"><button class="btn btn-link btn-sm dropdown-toggle" data-toggle="dropdown" aria-expanded="false" type="button"><i class="fas fa-ellipsis-v text-gray-400"></i></button>
                                    <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in"
                                        role="menu">
                                        <p class="text-center dropdown-header">Action:</p><a class="dropdown-item" role="presentation" >&nbsp;Refresh</a><a class="dropdown-item" role="presentation" >&nbsp;I don't care</a>
                                        <div class="dropdown-divider"></div><a class="dropdown-item" role="presentation">&nbsp;Don't calculate again</a></div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="chart-area" id="piechart"><canvas data-bs-chart="{&quot;type&quot;:&quot;doughnut&quot;,&quot;data&quot;:{&quot;labels&quot;:[&quot;Chrome&quot;,&quot;Firefox&quot;,&quot;Safari&quot;],&quot;datasets&quot;:[{&quot;label&quot;:&quot;&quot;,&quot;backgroundColor&quot;:[&quot;#4e73df&quot;,&quot;#1cc88a&quot;,&quot;#36b9cc&quot;],&quot;borderColor&quot;:[&quot;#ffffff&quot;,&quot;#ffffff&quot;,&quot;#ffffff&quot;],&quot;data&quot;:[<?=$stats->get_visitor_sources()?>]}]},&quot;options&quot;:{&quot;maintainAspectRatio&quot;:false,&quot;legend&quot;:{&quot;display&quot;:false},&quot;title&quot;:{}}}"></canvas></div>
                                <div
                                    class="text-center small mt-4"><span class="mr-2"><i class="fas fa-circle text-primary"></i>&nbsp;Chrome</span><span class="mr-2"><i class="fas fa-circle text-success"></i>&nbsp;Firefox</span><span class="mr-2"><i class="fas fa-circle text-info"></i>&nbsp;Safari</span></div>
						</div>
					</div><!--card siv ends-->
				</div>
			</div>
			<?php include_once(USER_INCLUDES.'footer_top.php');?>
		</div>
	</div>	
</body>
</html>
<script src= "<?= JS_URL .'progressbar_bootstrap.js'?>"></script>
<script type="text/javascript" src="<?= JS_URL?>chart.min.js"></script>
<script type="text/javascript" src="<?= JS_URL?>jquery.easing.min.js"></script> 
<script type="text/javascript" src="<?= JS_URL?>graph.js"></script> 
