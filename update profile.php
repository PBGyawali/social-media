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

<style>body {background-image: url('<?=BACKGROUNDS_URL?>contactusbg.jpg');padding:0}</style>
</head>
<body>
			<img src="<?php echo LOGO_URL.$katha->WebsiteLogo(); ?>"class="d-block mx-auto img-responsive " width="120" height= "120">
	        <div class="col-xs-12 col-sm-9 col-md-5 col-lg-4 px-0 m-auto">
			<span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>				
			    <div class="card mt-0">
	            	<div class="card-header md-3 p-0 no-border">
	            		<div class="row mb-0">
	            			<div class="col-12 text-center">							
	            				<h2 class="text-center m-0">Profile</h2>
							</div>
							<div class="col-md-12">
							<div class="card mb-0 text-center">
							<div class="card-body text-center  offset-0 ml-0 m-auto p-0 pt-1">
							
							<span id="user_uploaded_image" class="mt-0 ">							
							<a data-fancybox="" href="<?php echo USER_IMAGES_URL.rawurlencode($profileimage);?>"data-caption="Your full picture"><img class="rounded-circle mb-0 mt-0 img-fluid" src="<?php echo USER_IMAGES_URL.rawurlencode($profileimage);?>" width="150"  ></span></a>
							
							<?php if (!empty($row)):?>
							<div class="mb-2 d-inline"> 
							<?php 	
							echo '<i class="fa btn btn-sm '.($verified?'btn-success fa-check-circle"> <span class="d-none d-md-inline-block"> Verified</span>':'btn-danger fa-times-circle"> 
							<span class="d-none d-md-inline-block">Not verified</span>').'</i>';	
							 ?>
							</div>
							<div class="col-md-12 text-center">						
							<div class="mb-2 d-inline"><label for="file_upload" tabindex="1"><i class="fa fa-camera upload-button btn btn-primary btn-sm fa fa-camera upload_picture"><span id="upload_icon_text" class="d-none d-md-inline-block"> <?php if (!empty($profileimage)) echo"Change"; else echo "Upload New"; ?>   </span> </i></label></div>
							<?php endif?>
							<div class="mb-0 d-inline" id="delete_div">	
							<?php if (!empty($profileimage)):?>			
								<button class="btn btn-danger btn-sm fa fa-trash delete_btn" id="delete_picture" title="Click on the button to delete your profile picture"> <span class="d-none d-md-inline-block">Delete</span></button>								  
								  <?php endif ?>
								</div>					  
 							<form id="picture_upload" action="<?php echo USER_SERVER_URL?>profile_picture_server.php" method="post" enctype="multipart/form-data" style="display:none;">							
								<input type="hidden" name="profile_id" id="profile_id" value="<?php  echo $row['id']; ?>">	
								<input type="hidden" name="profile_image" class="profile_image" id="profile_image" value="<?php  echo $row["profile_image"] ?>" />							
								<input type="file" name="featured_image" id="file_upload" class="mb-2 d-block file_upload" data-allowed_file='[<?php echo '"'.implode('","', ALLOWED_IMAGES) .'"';?>]' data-upload_time="now" accept="<?php echo "image/".implode(", image/", ALLOWED_IMAGES);?>"  >
								<input type="submit" name="upload" value="upload">							
							</form>
                            </div></div></div></div></div>
							<div class="row mb-0">
							<div class="col-sm-12 p-0 ">
                                <div class="col ">
							<div class="card mb-0 ">
							<div class="card-body text-center p-0">
							<button class="btn  m-0 px-1 btn-sm fab fa-facebook fa-4x  d-inline" id="facebook" type="button"> </button>
							<button class="btn  px-1  btn-sm fab fa-twitter fa-3x d-inline" id="twitter"type="button"> </button>
							<button class="btn  px-1  btn-sm fab fa-google-plus fa-3x d-inline" id="google-plus" type="button"> </button>								
							</div>
							</div></div></div></div>
							<div class="row mb-0">
	            			<div class="col">
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body p-0">	            		
	            		<div class="col-md-12">
	            			<form method="post" id="user_form" class="profile" enctype="multipart/form-data" action="<?php echo USER_SERVER_URL;?>main_server.php">	           				
								<div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">User Name <span class="text-danger">*</span></label>
						            	<div class="col-md-8">
						            		<input type="text" name="username" id="username" class="form-control"   data-parsley-pattern="/^[a-zA-Z\s]+$/"  data-parsley-trigger="keyup" value="<?php echo $username; ?>" />
						            	</div>
						            </div>
					          	</div>					          	
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">User Email <span class="text-danger">*</span></label>
						            	<div class="col-md-8">
						            		<input type="email" name="email" id="email" class="form-control"  data-parsley-type="email"  data-parsley-trigger="keyup" value="<?php echo $email; ?>" />
						            	</div>
						            </div>
					          	</div>
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">First name <span class="text-danger"></span></label>
						            	<div class="col-md-8">
						            		<input type="text" name="first_name" id="first_name" class="form-control" value="<?php echo $firstname ?>" />
						            	</div>
						            </div>
								  </div>
								  <div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">Last name <span class="text-danger"></span></label>
						            	<div class="col-md-8">
						            		<input type="text" name="last_name" id="last_name" class="form-control"   value="<?php echo $lastname ?>" />
						            	</div>
						            </div>
								  </div>
								  <div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">Sex <span class="text-danger"></span></label>
						            	<div class="col-md-8 d-inline">										
											<input type="radio" class="d-inline"name="sex" id="sex" value="male" class="form-control" <?php echo  ($sex=='male')?'checked':''; ?> required/> Male
											<input type="radio"class="d-inline" name="sex" id="sex" value="female" class="form-control" <?php echo ($sex=='female')?'checked':''; ?> required/> Female
											<input type="radio" class="d-inline"name="sex" id="sex" value="other" class="form-control" <?php echo ($sex=='other')?'checked':''; ?> required/> Other
											<input type="radio" class=" d-inline"name="sex" id="sex" value="not mentioned" class="form-control" <?php echo ($sex=='not mentioned')?'checked':''; ?> required/> Secret
										</div>
										</div>
								  </div>	
								  
								  <div class="form-group text-center mb-3">
								  <input type="hidden" name="facebook_data" class="social_media_data" data-id="facebook" id="facebook_data"value="<?=$facebook?>">
									<input type="hidden"  name="twitter_data" class="social_media_data" data-id="twitter" id="twitter_data"value="<?=$twitter?>">
									<input type="hidden" name="googleplus_data" class="social_media_data" data-id="google-plus" id="google-plus_data"value="<?=$googleplus?>">
									<input type="hidden" name="user_id" value="<?php echo $row['id']; ?>" />
									<input type="hidden" name="update_user" value="update_user" />									         
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
	<script src="<?php echo JS_URL.'confirm_button.js'?>"></script>	
	
</body>
</html>
