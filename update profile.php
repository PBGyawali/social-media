<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php include_once(USER_CLASS.'publicview.php');
 $katha=new publicview(); 
$row=$katha->UsersArray();

include_once(USER_SERVER.'main_server.php') ;
$sex=$facebook=$twitter=$googleplus=$verified=$firstname=$lastname= '';
if($row){
	$sex=$row['sex'];$facebook= $row['facebook'];$twitter=$row['twitter'];
	$googleplus=$row['googleplus'];$verified=$row['verified'];$firstname=$row['first_name'];$lastname= $row['last_name'];
}
include_once(USER_INCLUDES.'minimal_header.php') ;
$username=(isset($_SESSION['username']))? ucwords($_SESSION['username']):'';
$profileimage=(isset($_SESSION['profile_image']))? $_SESSION['profile_image']:'';
$email=(isset($_SESSION['email']))?$_SESSION['email']:'';
?>

<link rel="stylesheet" href="<?php echo CSS_URL.'profile.css'?>" >
<style>body {background-image: url('<?=BACKGROUNDS_URL?>contactusbg.jpg');}</style>
</head>
<body>

			<img src="<?php echo LOGO_URL.$katha->WebsiteLogo(); ?>"class="d-block mx-auto img-responsive " width="150" height= "150">
	        <div class="col-xs-12 col-sm-9 col-md-5 col-lg-4 px-0 m-auto">
			<div id="success_msg" class="alert alert-success success_msg m-auto text-center" role="alert"  ></div>	
			<div id="error_msg" class="alert alert-danger error_msg m-auto text-center" role="alert"  ></div>
	            <div class="card mt-0">
	            	<div class="card-header md-3 p-0 no-border">
	            		<div class="row mb-0">
	            			<div class="col-12 text-center">							
	            				<h2 class="text-center m-0">Profile</h2>
							</div>
							<div class="col-md-12">
							<div class="card mb-0 text-center">
							<div class="card-body text-center  offset-0 ml-0 m-auto p-0 pt-1">
							<?php if (empty($row['profile_image'])):	?>	
							<div class="mb-0 d-inline" id="delete_div">
							<button class="btn btn-danger btn-sm fa fa-trash delete_btn" id="delete_picture" title="Click on the button to delete your profile picture"> Delete</button> 
							</div>	
							<?php endif ?>
							<span id="user_uploaded_image" class="mt-0 ">												
							<a data-fancybox="" href="<?php echo USER_IMAGES_URL.rawurlencode($profileimage);?>"data-caption="Your full picture"><img class="rounded-circle my-0 mx-auto" src="<?php echo USER_IMAGES_URL.rawurlencode($profileimage);?>" width="150" height= "150" ></span></a>
							<div class="mb-2 d-inline"><label for="file_upload" tabindex="1" >	
							<?php if (!empty($row['profile_image'])):?>						
							<i class="fa fa-camera btn btn-primary btn-xs "><span id="upload_icon_text"> <?php echo (!empty($row['profile_image']))?"Change":"Upload New" ?></span> </i>
							</label>
							<?php endif ?>
							</div>
							
							<div class="mb-2 d-block mb-0 pb-0 "><i class="fa btn btn-sm px-3 <?php echo $verified?'btn-success fa-check-circle"> Verified': 'btn-danger fa-times-circle"> Not verified' ?></i></div>
							
								  						  
 							<form id="picture_upload" action="<?php echo USER_SERVER_URL?>profile_picture_server.php" method="post" enctype="multipart/form-data" style="display:none;">							
							<input type="hidden" name="profile_id" id="profile_id" value="<?php echo $row['id']; ?>">	
							<input type="hidden" name="profile_image" id="profile_image" value="<?php echo $row["profile_image"]; ?>" />							
							<input type="file" name="featured_image" id="file_upload" class="mb-2 d-block file_upload"   data-allowed_file='[<?php echo '"' . implode('","', ALLOWED_IMAGES) . '"';?>]' data-upload_time="now" accept="<?php echo "image/" . implode(", image/", ALLOWED_IMAGES);?>"  >
							<input type="submit" name="upload" value="upload">							
								</form>
                            </div></div></div></div>
							<div class="row mb-0 mt-0 pt-0">
							<div class="col-sm-12 p-0 ">
                                <div class="col ">
							<div class="card mb-0 p-0">
							<div class="card-body text-center p-0">
							<button class="btn  m-0 p-0 btn-sm fab fa-facebook fa-6x  d-inline" id="facebook" type="button"> </button>
							<button class="btn  p-0 pr-1 pl-1 btn-sm fab fa-twitter fa-5x d-inline" id="twitter"type="button"> </button>
							<button class="btn  p-0 pr-1 pl-1 btn-sm fab fa-google-plus fa-5x d-inline" id="google-plus" type="button"> </button>
							</div>
							</div></div></div></div>
							<div class="row mb-0">
	            			<div class="col">
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body p-0">
	            		&nbsp;
	            		<div class="col-md-12">
	            			<form method="post" id="user_form" enctype="multipart/form-data" action="<?php echo USER_SERVER_URL;?>main_server.php">
	            				<div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-3 text-right">User Name <span class="text-danger">*</span></label>
						            	<div class="col-xs-12 col-sm-9  ">
						            		<input type="text" name="username" id="username" class="form-control" required  readonly data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" value="<?= $username?>" />
						            	</div>
						            </div>
					          	</div>
					          	
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-3 text-right">User Email <span class="text-danger">*</span></label>
						            	<div class="col-xs-12 col-sm-9 ">
						            		<input type="text" name="email" id="email" class="form-control"  data-parsley-type="email" data-parsley-maxlength="150" data-parsley-trigger="keyup" value="<?=$email ?>" />
						            	</div>
						            </div>
					          	</div>
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-3 text-right">First name <span class="text-danger invisible" >*</span></label>
						            	<div class="col-xs-12 col-sm-9 ">
						            		<input type="text" name="first_name" id="first_name" class="form-control" value="<?=$firstname ?>" />
						            	</div>
						            </div>
								  </div>
								  <div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-3 text-right">Last name <span class="text-danger invisible">*</span></label>
						            	<div class="col-xs-12 col-sm-9 ">
						            		<input type="text" name="last_name" id="last_name" class="form-control"   value="<?=$lastname ?>" />
						            	</div>
						            </div>
								  </div>
								  <div class="form-group">
					          		<div class="row">
						            	<label class="col-xs-12 col-sm-2 text-right">Sex <span class="text-danger">*</span></label>
						            	<div class="col-xs-12 col-sm-10 d-inline pr-0 mr-0">										
										<input type="radio" class="d-inline"name="sex" id="sex" value="male" class="form-control" <?=($sex=='male')?'checked':'' ?> required/> Male
											<input type="radio"class="d-inline" name="sex" id="sex" value="female" class="form-control" <?=($sex=='female')?'checked':'' ?> required/> Female
											<input type="radio" class="d-inline"name="sex" id="sex" value="other" class="form-control" <?=($sex=='other')?'checked':'' ?> required/> Other
											<input type="radio" class=" d-inline"name="sex" id="sex" value="not mentioned" class="form-control" <?=($sex=='not mentioned')?'checked':'' ?> required/> Don't want to mention
										</div>
										</div>
					          	</div>
					          	
					         
					          	<div class="form-group text-center ">
								  <input type="hidden" name="facebook_data" class="social_media_data" data-id="facebook" id="facebook_data"value="<?=$facebook?>">
									<input type="hidden"  name="twitter_data" class="social_media_data" data-id="twitter" id="twitter_data"value="<?=$twitter?>">
									<input type="hidden" name="googleplus_data" class="social_media_data" data-id="google-plus" id="google-plus_data"value="<?=$googleplus?>">
									<input type="hidden" name="user_id" value="<?php echo $row['id']; ?>" />									         
									  <button type="submit" name="update_user" id="submit_button" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
									  <button  type="button" id="go_back" onclick="history.go(-1);" class="btn btn-primary"><i class="fas fa-reply"></i> Go back</button>
					          	</div>
					     
	            			</form>
	            		</div>
	            		
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
	<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
	<?php include_once ( USER_INCLUDES . 'footer.php') ?>
	<script src="<?php echo JS_URL?>jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="<?php echo CSS_URL?>jquery.fancybox.min.css" />
	<script src="<?php echo JS_URL.'confirmdefaults.js'?>"></script>
	<script src="<?php echo JS_URL.'confirm_button.js'?>"></script>
	<script src="<?php echo JS_URL.'confirm.js'?>"></script>
	<script >$('#user_form').parsley();</script>
</body>
</html>


