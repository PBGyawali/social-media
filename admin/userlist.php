<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(ADMIN_SERVER.'useraction_server.php'); 
include_once(ADMIN_CLASS.'katha.php');
$katha = new katha();

include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
 $results =$katha->getAllArray('users','','','','','user_type'); ?>
<script>
$(document).ready(function(){
    var date = new Date();
        
    $('.input-daterange').datepicker({
        todayBtn: "linked",
        format: "yyyy-mm-dd",
        autoclose: true
    });
        
});
</script>
			<div class="alert alert-success success_msg" role="alert" id="success_msg" ></div>			
			<div class="alert alert-danger error_msg" role="alert" id="error_msg" ></div>
	        
	        	<span id="message"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-4">
	            				<h2>User Area</h2>
	            			</div>
	            			<div class="col-sm-4">
	            				<div class="row input-daterange">
	            					<div class="col-md-6">
		            					<input type="text" name="from_date" id="from_date" class="form-control form-control-sm" placeholder="From Date" readonly />
		            				</div>
		            				<div class="col-md-6">
		            					<input type="text" name="to_date" id="to_date" class="form-control form-control-sm" placeholder="To Date" readonly />
		            				</div>
		            			</div>
		            		</div>
		            		<div class="col-md-2">
	            				<button type="button" name="filter" id="filter" class="btn btn-info btn-sm"><i class="fas fa-filter"></i></button>
	            				&nbsp;
	            				<button type="button" name="refresh" id="refresh" class="btn btn-secondary btn-sm"><i class="fas fa-sync-alt"></i></button>
	            			</div>
	            			<div class="col-md-2 text-right" >
	            				<button data-url="<?php echo ADMIN_URL?>"name="export" id="export" class="text-success"><i class="fas fa-file-csv fa-2x"></i></button>  
	            				&nbsp;
	            				<button type="button" name="add_user" id="add_user" class="btn btn-success btn-sm" style="margin-top: -15px;"><i class="fas fa-user-plus"></i></button>
	            			</div>
						</div>
						<div class="row">
	            			<div class="col text-center font-weight-bold">
							Hide Chosen Row														
							</div>
						</div>
						<div class="row">
	            			<div class="col text-left-justified border border-dark">
							    <input type="checkbox" class=toggle data-column="0" > S.no
							    <input type="checkbox" class=toggle data-column="1"> Id
								<input type="checkbox" class=toggle data-column="2"> Profile Image
								<input type="checkbox" class=toggle data-column="3"> Username								
								<input type="checkbox" class=toggle data-column="4"> Email
								<input type="checkbox" class=toggle data-column="5"> Full name
								<input type="checkbox" class=toggle data-column="6"> User Type
								<input type="checkbox" class=toggle data-column="7"> Status
								<input type="checkbox" class=toggle data-column="8"> Action							
								</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="list">
	            				<thead>
	            					<tr>
									<th >S.no</th> 
									<th >ID </th>
										<th>Profile Image</th>
	            						<th>User Name</th>
										<th>Email</th>
										<th>Full name</th>
										<th>User Type</th>
										<th>Status</th>															
										<th>Action</th>
										</tr>
								</thead>
									<tbody>
	<?php
	$count = 1; 
	foreach ($results as $row):?>
		<tr id="userlist_<?php echo $row['id']; ?>">
		<td class="s_no"><?php echo $count; ?></td>
		<td class="id"><?php echo $row['id']; ?></td>

		<td class="profile_image"><?php $image=$katha->Get_profile_image($row['id']); echo '<img data-src="'.$image.'" src="'.USER_IMAGES_URL.rawurlencode($image).'" class="img-fluid img-thumbnail" width="100" height="100" />'; ?></td>
			<td class="username"><?php echo $row['username']; ?></td>
            <td class="email"><?php echo $row['email']; ?></td>
			<td class="full_name"><?php echo ucwords(implode(' ',(array("<span class='first_name'>".$row['first_name']."</span>","<span class='last_name'>".$row['last_name']."</span>")))); ?></td>
			<td class="user_type"><?php echo $row['user_type']; ?></td>
			<td class="status"><?php $status= GetUserStatusById($row['id']);echo $status;?></td>
			
			<td class="action"><?php echo'
			<div align="center">
			<button type="button" name="view_button" class="btn btn-info btn-sm view_button" data-id="'.$row["id"].'"><i class="fas fa-eye"></i></button>
			&nbsp;
			<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$row["id"].'"><i class="fas fa-times"></i></button>
			&nbsp;
			
			<button type="button" name="edit_button" class="btn btn-secondary btn-sm edit_button" data-id="'.$row["id"].'"><i class="fas fa-edit"></i></button>
			
			&nbsp;
			<button type="button" name="reset_button" class="btn btn-primary btn-sm reset_button" data-id="'.$row["id"].'"><i class="fas fa-sync"></i></button>
			&nbsp;
			<button type="button" name="disable_button" class="btn btn-sm disable_button '. (($status=='Disabled')?'btn-success fas fa-unlock-alt':'btn-warning fas fa-ban') .'" data-id="'.$row["id"].'"></button>
			</div>'   
			;	?>		
</td>
				                           
		</tr>
		<?php	$count++;endforeach?>
	
	</tbody>
			
            			</table>
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>

<div id="userModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="user_form" action="<?php echo ADMIN_SERVER_URL.'useraction_server.php';?>" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add User</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">User Name</label>
			            	<div class="col-md-8">
			            		<input type="text" name="username" id="username" value="" class="form-control" required data-parsley-pattern="/^[a-zA-Z0-9\s_.]+$/" data-parsley-maxlength="150" data-parsley-trigger="on change" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"> Email</label>
			            	<div class="col-md-8">
			            		<input type="email" name="email" id="email" class="form-control" required  data-parsley-type="email" data-parsley-maxlength="150" data-parsley-trigger="on blur" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group" id="password_section">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Password</label>
			            	<div class="col-md-8">
			            		<input type="text" name="password" id="password" class="form-control"  data-parsley-minlength="6"  data-parsley-trigger="on change" />
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">First name</label>
			            	<div class="col-md-8">
			            		<input type="text"  name="first_name" id="first_name" class="form-control"  data-parsley-maxlength="100" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Last name</label>
			            	<div class="col-md-8">
			            		<input type="text"  name="last_name" id="last_name" class="form-control" data-parsley-maxlength="100" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">User_type</label>
			            	<div class="col-md-8">
			            		<select name="user_type" id="user_type" class="form-control" >
			            			<option value="" disabled  selected hidden>Select User type</option>
									<option value="admin" >Admin</option>
									<option value="editor" >Editor</option>
									<option value="user" >User</option>
			            		</select>
			            	</div>
			            </div>
		          	</div>
		          	
				  
					  
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="detailModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="details_form" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="detail_modal_title"> User Details</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
				<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"></label>
			            	<div class="col-md-8" >
			            		<img id="profile_image" src="<?php echo USER_IMAGES_URL.rawurlencode($katha->Get_profile_image());?>" class="rounded-circle mb-0 mt-0" width="200" height="200" alt="thumbnail">
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>User Name:</b></label>
			            	<div class="col-md-8">
			            		<span id="username_detail"></span>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b> Email:</b></label>
			            	<div class="col-md-8">
			            		<span id="email_detail"></span>
			            	</div>
			            </div>
		          	</div>
		          	
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Full name:</b></label>
			            	<div class="col-md-8">
			            		<span id="name_detail"></span>
			            	</div>
			            </div>
		          	</div>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>User type:</b></label>
			            	<div class="col-md-8">
			            		<span id="user_type_detail"></span>
			            	</div>
			            </div>
		          	</div>
		          	
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Status:</b></label>
			            	<div class="col-md-8">
			            		<span id="user_status_detail"></span>
			            	</div>
			            </div>
					  </div>
					  <div class="form-group" id="remarks_div">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Remarks:</b></label>
			            	<div class="col-md-8">
			            		<textarea name="remarks" id="remarks" class="form-control" data-parsley-maxlength="400" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Facebook:</b></label>
			            	<div class="col-md-8">
			            		<span id="facebook"></span>
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Twitter:</b></label>
			            	<div class="col-md-8">
			            		<span id="twitter"></span>
			            	</div>
			            </div>
		          	</div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Google plus:</b></label>
			            	<div class="col-md-8">
							<span id="googleplus"></span>
			            	</div>
			            </div>
					  </div>
					  
		          
					 
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="id" id="detail_hidden_id" />
          			<input type="hidden" name="action" id="detail_action" value="update_detail" />
          			<input type="submit" name="submit" id="detail_submit_button" class="btn btn-success" value="Save" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<div id="actionModal" class="modal fade">
  	<div class="modal-dialog modal-lg">
    	<form method="post" id="action_form" enctype="multipart/form-data">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="action_modal_title"> Disable User</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">		
		          	
		          	
					  <div class="form-group" id="remarks_div">
		          		<div class="row">
			            	<label class="col-md-4 text-right"><b>Remarks:</b></label>
			            	<div class="col-md-8">
			            		<textarea name="remarks" id="action_remarks" class="form-control" data-parsley-maxlength="400" data-parsley-trigger="keyup"></textarea>
			            	</div>
			            </div>
					  </div>       
					 
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="id" id="action_hidden_id" />
					  <input type="hidden" name="action" id="action_update_detail" value="update_detail" />
					  <input type="hidden" id="actionModalurl" value="<?php echo ADMIN_SERVER_URL.'useraction_server.php';?>" />
          			<input type="submit" name="submit" id="action_submit_button" class="btn btn-success" value="Disable" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<script src="userlist.js"></script>


		