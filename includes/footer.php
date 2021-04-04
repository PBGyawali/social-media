


<div id="messageModal" class="modal fade text-dark" data-backdrop="static">
  	<div class="modal-dialog modal-md">
    	<form method="post" id="message_form" enctype="multipart/form-data" >
      		<div class="modal-content">
        		<div class="modal-header bg-primary p-0">
          			<h4 class="modal-title text-white " id="modal_title">Send us offline Message</h4>
          			<button type="button" class="close" data-dismiss="modal"><span class=" text-danger">&times;</span></button>
        		</div>
        		<div class="modal-body text-left">                      
					  <div class="form-group m-0">
		          		<div class="row">
						  <label class="col-md-12 text-center m-0">Full name</label>
			            	<div class="col-md-12">
			            		<input type="text" name="full_name" id="full_name" value="<?= $check->session('username');?> " class="form-control border-dark" required data-parsley-pattern="/^[a-zA-Z\s]+$/"  data-parsley-maxlength="150" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>	         
					  <div class="form-group m-0">
		          		<div class="row">
						  <label class="col-md-12 text-center m-0">Email</label>
			            	<div class="col-md-12">
			            		<input type="email" name="email" id="email" value="<?= $check->session('email');?>" class="form-control border-dark" required data-parsley-pattern="email"  data-parsley-maxlength="150" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>	
		          	<div class="form-group m-0">
		          		<div class="row">
						  <label class="col-md-12 text-center m-0">Subject</label>
			            	<div class="col-md-12">
			            		<input type="text" name="subject" id="subject" class="form-control border-dark" required data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-maxlength="150" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>		          	
		          	<div class="form-group m-0 p-0">
		          		<div class="row">
						  <label class="col-md-12 text-center m-0">Your message</label>			            	
			            	<div class="col-md-12 text-left">
							<textarea name="body" id="body" rows="5" class="form-control border-dark"></textarea>
			            	</div>
			            </div>
		          	</div>		          
		          
		          	</div>		          	
		          	
        		<div class="modal-footer">				
					  <input type="hidden" name="user_id" id="user_id"value="" />					  
          			<input type="hidden" name="action" id="action" value="1" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Send" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<?php if($check->is_user()):?> 

<div class="text-center bg-dark fixed-bottom text-warning"><em><strong style= "color:yellow;">
In this session you have navigated our website
<?php include_once(USER_INCLUDES."sessioncount.php");?>  times.</em></strong></style></div>
<?php endif?> 
<script>
        setTimeout(function(){
            $('.alert').slideUp();
        }, 3000);        
    </script>