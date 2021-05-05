<?php  
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_CLASS.'publicview.php');
$katha = new publicview();
if($check->is_login()){
	$user_id=$_SESSION['id'];
	$timestamp = $katha->get_data('last_password_change','userlogs','user_id',$_SESSION['id']);
}
else{
	$timestamp=$user_id='';	
}

include_once(USER_INCLUDES.'minimal_header.php');

include_once(USER_INCLUDES.'sidebar.php');
?>
<title><?php echo $page ?></title>
<link rel="stylesheet" type="text/css" href="<?php echo  CSS_URL.'profile.css' ?>">
<style>body {background-image: url('<?=BACKGROUNDS_URL?>contactusbg.jpg');}</style>	
</head>
<body >	
<img src="<?php echo LOGO_URL.$katha->WebsiteLogo(); ?>"class="d-block mx-auto img-responsive " width="120" height= "120">
	        <div class="col-xs-12 col-sm-9 col-md-8 col-lg-6 pt-3 m-auto">
			<div class="row row-fluid">	
			<span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>				
				</div>	
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col">
	            				<h2>Change Password <i class="fas fa5x fa-lock"></i></h2>
	            			</div>
	            			
	            		</div>
	            	</div>
	            	<div class="card-body pr-0">
	            		
	            		<div class="col-md-12">
	            			<form method="post" id="user_form" class="password"action="<?=SERVER_URL?>main_server.php">
	            				<div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-3 text-left pl-0 pr-1 ">Current Password <span class="text-danger">*</span></label>
						            	<div class="col-xs-12 col-sm-9 pl-0">
						            		<input type="password" name="old_password" id="old_password" class="form-control"    data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="on blur" />
						            	</div>
						            </div>
					          	</div>
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-3 text-left pl-0 pr-1 ">New Password <span class="text-danger">*</span></label>
						            	<div class="col-xs-12 col-sm-9 pl-0">
						            		<input type="password" name="changed_password" id="new_password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="on blur" />
						            	</div>
						            </div>
					          	</div>
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-3 text-left pl-0 pr-1 ">Confirm Password <span class="text-danger">*</span></label>
						            	<div class="col-xs-12 col-sm-9 pl-0 ">
						            		<input type="password" name="confirm_password" id="confirm_password" class="form-control"  required data-parsley-equalto="#new_password" data-parsley-trigger="on change" />
						            	</div>
						            </div>
					          	</div>
					          	<br />
					          	<div class="form-group text-center">
										<input type="hidden" name="changer_id" value="<?php echo $user_id ?>" />
									  <input type="hidden" name="action" value="change_password" />
									  <input type="hidden" name="update_password" value="change_password" />
					          		<button type="submit" name="update_password" id="submit_button" class="btn btn-success"><i class="fas fa-lock"></i> Change</button>
					          	</div>
	            			</form>
	            		</div>
	            		
					</div>
					<div class="col-md-7">Last password change: <time class="timeago" datetime="<?php echo $timestamp?>"><?php if (!$timestamp) echo'unknown';?></time>         </div>
				</div><!--card body end!-->
				
			</div>
			
		</div>
		
	</div>

</body>
</html>
<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<script src="<?php echo JS_URL.'confirm_button.js'?>"></script>	