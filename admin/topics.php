<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$katha = new katha();
if(!$check->is_login()){header("location:".$katha->base_url."");}
if(!$check->is_admin()){header("location:".$katha->base_url."home.php");}
 $topics = $katha->getAllArray('topics');
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
?>	
	        
			<div class="alert alert-success success_msg" role="alert" id="success_msg" ></div>			
			<div class="alert alert-danger error_msg" role="alert" id="error_msg" ></div>
	        	<span id="message"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col">
	            				<h2>Topics Management</h2>
	            			</div>
	            			<div class="col text-right">
	            				<button type="button" name="add_topic" id="add_topic" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button>
	            			</div>
	            		</div>
					</div>
					<?php if (empty($topics)): ?>
				<h1>No topics in the database.</h1>
			<?php else: ?>
	            	<div class="card-body" id="topic-list-box">
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="topic_table">
	            				<thead>
	            					<tr>
	            						<th>S.No</th>
										<th>Topic Name</th>							
										<th>Action</th>
										
	            					</tr>
								</thead>
								<tbody>
							<?php foreach ($topics as $key => $topic): ?>
							<tr  class="topic-box" id="topic_<?php echo $topic["id"];?>">
							<td class="index"><?php echo $key+1; ?></td>
							<td><div class="topic-content"><?php echo ucwords($topic['name']); ?></div></td>
							<td>

							<button type="button" name="edit" title="edit"class="fa fa-edit btn btn-success edit_button"  data-id="<?php echo $topic['id'] ?>"> EDIT</button>
															&nbsp;
							<button type="button" name="delete" title="delete" class="fa fa-trash btn btn-danger delete_button" data-id="<?php echo $topic['id'] ?>" > DELETE</button>
							</td>

							</tr>
							<?php endforeach ?>
							</tbody>
	            			</table>
	            		</div>
					</div>
					<?php endif?> 
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>

<div id="topicModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" id="topic_form" action="<?= ADMIN_SERVER_URL?>admin_functions.php">
      		<div class="modal-content">
        		<div class="modal-header">
          			<h4 class="modal-title" id="modal_title">Add Topic</h4>
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Topic Name</label>
			            	<div class="col-md-6">
			            		<input type="text" name="topic_name" id="topic_name" class="form-control"  data-parsley-pattern="/^[a-zA-Z\s]+$/" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
		          	</div>
		          	
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="create_topic" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<script src="<?php echo JS_URL?>topics.js"></script>