<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php
$katha = new publicview();
if($check->is_login()){
	$user_id=$_SESSION['id'];
	$timestamp = $katha->get_data('last_password_change','userlogs','user_id',$_SESSION['id']);
}
else
	$timestamp=$user_id='';	
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
?>		
			<span class="text-center position-absolute w-100 message"id="message" style="z-index:978"></span>				
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col">
	            				<h2>Change Password <i class="fas fa5x fa-lock"></i></h2>
	            			</div>
	            			<div class="col text-right">
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
	            		<div class="col-md-3">&nbsp;</div>
	            		<div class="col-md-6">
	            			<form method="post" id="user_form" class="password" action="<?=SERVER_URL?>main_server.php">
	            				<div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">Current Password <span class="text-danger">*</span></label>
						            	<div class="col-md-8">
						            		<input type="password" name="old_password" id="old_password" class="form-control"   required data-parsley-minlength="0" data-parsley-maxlength="16" data-parsley-trigger="on blur" />
						            	</div>
						            </div>
					          	</div>
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">New Password <span class="text-danger">*</span></label>
						            	<div class="col-md-8">
						            		<input type="password" name="changed_password" id="changed_password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="on blur" />
						            	</div>
						            </div>
					          	</div>
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">Re-enter Password <span class="text-danger">*</span></label>
						            	<div class="col-md-8">
						            		<input type="password" name="confirm_password" id="confirm_password" class="form-control"  required data-parsley-equalto="#changed_password"data-parsley-trigger="on blur" />
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
					<div class="col-md-7	">Last password change: <time class="timeago" datetime="<?php echo $timestamp?>"><?php if (!$timestamp) echo'unknown';?></time>         </div>
				</div><!--card body end!-->				
			</div>			
		</div>		
	</div>

</body>
</html>
<script src="<?php echo JS_URL.'confirm_button.js'?>"></script>	