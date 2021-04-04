<?php  
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(ADMIN_CLASS.'katha.php');
$katha = new katha();
$row = $katha->UsersArray();
$email=(isset($_SESSION['email']))?$_SESSION['email']:'';
$sex=$facebook=$twitter=$googleplus=$verified=$firstname=$lastname= '';
if($row){
	$sex=$row['sex'];$facebook= $row['facebook'];$twitter=$row['twitter'];
	$googleplus=$row['googleplus'];$verified=$row['verified'];$firstname=$row['first_name'];$lastname= $row['last_name'];
}
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
?>	        
			<div class="alert alert-success success_msg" role="alert" id="success_msg" ></div>			
			<div class="alert alert-danger error_msg" role="alert" id="error_msg" ></div>
	            <div class="card">
	            	<div class="card-header md-3 p-0 no-border">
	            		<div class="row mb-0">
	            			<div class="col">
	            				<h2>Profile</h2>
							</div><div class="col-md-12">
							<div class="card mb-0 text-center">
							<div class="card-body text-center  offset-0 ml-0 ">
							<span id="user_uploaded_image" class="mt-0 ">							
							<a data-fancybox="" href="<?php echo USER_IMAGES_URL.rawurlencode($profileimage);?>"data-caption="Your full picture"><img class="rounded-circle mb-0 mt-0" src="<?php echo USER_IMAGES_URL.rawurlencode($profileimage);?>" width="200" height= "200" ></span></a>
							<?php if (!empty($row)):?>
							<div class="mb-2 d-inline"> 
							<?php 	
							echo '<i class="fa btn btn-sm '.($verified?'btn-success fa-check-circle"> Verified':'btn-danger fa-times-circle"> 
							Not verified').'</i>';	
							 ?>
							</div>							
							<div class="mb-2 d-inline"><label for="file_upload" tabindex="1"><i class="fa fa-camera upload-button btn btn-primary btn-sm fa fa-camera upload_picture"><span id="upload_icon_text"> <?php if (!empty($profileimage)) echo"Change"; else echo "Upload New"; ?>   </span> </i></label></div>
							<?php endif?>
							<div class="mb-0 d-inline" id="delete_div">	
							<?php if (!empty($profileimage)):?>			
								<button class="btn btn-danger btn-sm fa fa-trash delete_btn" id="delete_picture" title="Click on the button to delete your profile picture"> Delete</button>								  
								  <?php endif ?>
								</div>					  
 							<form id="picture_upload" action="<?php echo USER_SERVER_URL?>profile_picture_server.php" method="post" enctype="multipart/form-data" style="display:none;">							
								<input type="hidden" name="profile_id" id="profile_id" value="<?php  echo $row['id']; ?>">	
								<input type="hidden" name="profile_image" class="profile_image" id="profile_image" value="<?php  echo $row["profile_image"] ?>" />							
								<input type="file" name="featured_image" id="file_upload" class="mb-2 d-block file_upload" data-allowed_file='[<?php echo '"'.implode('","', ALLOWED_IMAGES) .'"';?>]' data-upload_time="now" accept="<?php echo "image/".implode(", image/", ALLOWED_IMAGES);?>"  >
								<input type="submit" name="upload" value="upload">							
							</form>
                            </div></div></div></div>
							<div class="row mb-0">
							<div class="col-sm-12 p-0 ">
                                <div class="col ">
							<div class="card mb-0 ">
							<div class="card-body text-center ">
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
	            	<div class="card-body">
	            		<div class="col-md-4">&nbsp;</div>
	            		<div class="col-md-9">
	            			<form method="post" id="user_form" enctype="multipart/form-data" action="<?php echo USER_SERVER_URL;?>main_server.php">
	            				<div class="alert alert-success success_msg" role="alert"  ></div>			
								<div  class="alert alert-danger error_msg" role="alert" ></div>
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
											<input type="radio" class=" d-inline"name="sex" id="sex" value="not mentioned" class="form-control" <?php echo ($sex=='not mentioned')?'checked':''; ?> required/> Don't want to mention
										</div>
										</div>
					          	</div>	
					          	<div class="form-group text-center">
								  <input type="hidden" name="facebook_data" class="social_media_data" data-id="facebook" id="facebook_data"value="<?php echo $facebook?>">
									<input type="hidden"  name="twitter_data" class="social_media_data" data-id="twitter" id="twitter_data"value="<?php echo $twitter?>">
									<input type="hidden" name="googleplus_data" class="social_media_data" data-id="google-plus" id="google-plus_data"value="<?php echo $googleplus?>">
					          		<input type="hidden" name="user_id" value="<?php echo $row['id']; ?>" />
									  <input type="hidden" name="action" value="profile" />         
									  <button type="submit" name="update_user" id="submit_button" class="btn btn-success"><i class="fas fa-save"></i> Save</button>
					          	</div>					     
	            			</form>
	            		</div>
	            		<div class="col-md-3">&nbsp;</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>
	<script src="<?php echo JS_URL?>jquery.fancybox.min.js"></script>
	<link rel="stylesheet" href="<?php echo CSS_URL?>jquery.fancybox.min.css" />
	<script src="<?php echo JS_URL.'confirm_button.js'?>"></script>
</body>
</html>


