<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php

$katha = new publicview();
if($check->is_login()){
	$user_id=$_SESSION['id'];
	$timestamp = $katha->get_data('last_password_change','userlogs','user_id',$_SESSION['id']);
}
else{
	$timestamp=$user_id='';	
}

include_once(ADMIN_INCLUDES.'header.php');

include_once(ADMIN_INCLUDES.'sidebar.php');
?>
	

	        
					
			<div id="error_msg" class="alert alert-danger error_msg ml-0 text-left" role="alert" ></div>
			<div id="success_msg" class="alert alert-success success_msg ml-0 text-left" role="alert" ></div>	
	        	
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
	            			<form method="post" id="user_form" action="server/admin_profile_server.php">
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
						            		<input type="password" name="new_password" id="new_password" class="form-control" required data-parsley-minlength="6" data-parsley-maxlength="16" data-parsley-trigger="on blur" />
						            	</div>
						            </div>
					          	</div>
					          	<div class="form-group">
					          		<div class="row">
						            	<label class="col-md-4 text-right">Re-enter Password <span class="text-danger">*</span></label>
						            	<div class="col-md-8">
						            		<input type="password" name="confirm_password" id="confirm_password" class="form-control"  required data-parsley-equalto="#new_password"data-parsley-trigger="on blur" />
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

<script>

$(document).ready(function(){
	
	var url = $('#user_form').attr('action');	
	$('#user_form').parsley();

	$('#user_form').on('submit', function(event){
		event.preventDefault();
		if($('#user_form').parsley().isValid())
		{
		var data = new FormData(this);
		// If you want to add an extra field for the FormData
        data.append("update_password", 1);
				$.ajax({
				url:url,
				method:"POST",
				data:data,
				processData: false,
            	contentType: false,
            	cache: false,
            	timeout: 800000,			
				dataType:"JSON",			
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').html('wait...');
				},
				complete:function(){
					$('#submit_button').attr('disabled', false);
					$('#submit_button').html('<i class="fas fa-lock"></i> Change');
					$('#user_form')[0].reset();	
				},
				success:function(data)
				{					
					if(data.error != '')
					{ 
					$('#error_msg').html(data.error);
					$(".error_msg").fadeTo(3500, 500).slideUp(500);
					}
					else{ 
						$('#success_msg').html(data.success);
						$(".success_msg").fadeTo(2500, 500).slideUp(500); 						
						$('.timeago').timeago('update', new Date());		
					
					}
					
						
				}
			})
		}
	});

});

</script>