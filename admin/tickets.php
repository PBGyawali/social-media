<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(ADMIN_SERVER.'ticketing_server.php'); 
$katha = new publicview();
//if(!$katha->is_login())
//$katha->redirect(BASE_URL);

//if(!$katha->is_admin())
//$katha->redirect(BASE_URL);
$tickets=GetAllTickets();
 include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
?>
	        
			<span class="text-center position-absolute w-100"id="message" style="z-index:50"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col">
								<h2>Ticket Management</h2>														
							</div>							
	            			<div class="col text-right">
	            				<button type="button" name="add_ticket" id="add_ticket" class="btn btn-success btn-sm"><i class="fas fa-plus"></i></button>
	            			</div>
						</div>
						<div class="row">
	            			<div class="col text-center font-weight-bold">
							Hide Chosen Row														
							</div>
							<div class="col text-center font-weight-bold">
							Show only the chosen row
	            			</div>
						</div>
						<div class="row">
	            			<div class="col text-left-justified border border-dark">
								
								<button class="hiderow btn-sm btn-secondary" id="open"> Open</button>
								<button class="hiderow  btn-sm btn-secondary" id="pending"> Pending</button>
								<button class="hiderow  btn-sm btn-secondary" id="on-hold"> On-hold</button>
								<button class="hiderow  btn-sm btn-secondary" id="resolved"> Resolved</button>
								<button class="hiderow  btn-sm btn-secondary" id="closed"> Closed</button>
							</div>
							
	            			<div class="col text-right-justified border border-dark">
								<button class="showonly btn-sm btn-secondary" data-id="open" id="openonly"> Open</button>
								<button class="showonly btn-sm btn-secondary" data-id="pending" id="pendingonly"> Pending</button>
								<button class="showonly btn-sm btn-secondary" data-id="on-hold" id="on-holdonly"> On-hold</button>
								<button class="showonly btn-sm btn-secondary" data-id="resolved" id="resolvedonly"> Resolved</button>
								<button class="showonly btn-sm btn-secondary" data-id="closed" id="closedonly"> Closed</button>	
								<button class="reset btn-sm btn-primary float-right" data-id="" id=""> Reset</button>							
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
	            		<div class="table-responsive ">
	            			<table class="table table-striped table-bordered " id="list">
	            				<thead>
	            					<tr>
	            						<th>Status</th>
										<th>Name</th>
										<th>Email</th>
										<th>Date created</th>						
										<th>Action</th>
	            					</tr>
								</thead>
								<tbody>
								<?php foreach ($tickets as $ticket): ?>
								<tr id="ticket_<?php echo $ticket["id"];?>">
								<td class="ticketstatus">
					<?php 	$statustypes=array("open","pending","on-hold","resolved","closed");
							$icontype=array("envelope","clock","pause-circle","check","times"); 
							$class= array('primary ','danger ','warning ','success ','secondary ');
							foreach($statustypes as $key=> $statustype) 
								if($ticket['status']== $statustype)
										break;											                    
					?>			
				<i class="fa-2x fas fa-<?= $icontype[$key].' '.$statustype.' text-'.$class[$key].'" title="'.$statustype?>">
				<span style="display: none;"><?= $key ?></span></i>
				</td>
				<td class="messagebox"><div class="mb-1">
				<span class="title"><?=htmlspecialchars($ticket['title'], ENT_QUOTES)?></span></div>
				<div><span class="msg bg-secondary text-white"><?=htmlspecialchars($ticket['msg'], ENT_QUOTES)?></span></div></td>
				<td class="ticketemail">
				<?=$ticket['email']?>		
				</td>
				<td class="ticketdate">
			<span><?=date('Y-m-d, G:ia', strtotime($ticket['created']))?></span></td>
			<td>						
			<button type="button" name="view_button" class="btn btn-primary btn-sm view_button" data-id="<?=$ticket['id']?>">
			<i class="fas fa-eye"></i></button>
				</td>
			</tr>
								<?php endforeach ?>
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

<div id="ticketModal" class="modal fade">
  	<div class="modal-dialog">
    	<form method="post" class="form" id="ticket_form" action="<?= ADMIN_SERVER_URL?>ticketing_server.php">
      		<div class="modal-content">
        		<div class="modal-header">
					  <h4 class="modal-title" id="modal_title">Create Ticket</h4>
					 
          			<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Ticket name</label>
			            	<div class="col-md-6">
			            		<input type="text" name="title" placeholder="Title" id="title" class="form-control" required data-parsley-pattern="/^[a-zA-Z\s0-9]+$/" data-parsley-trigger="keyup" />
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Email</label>
			            	<div class="col-md-6">
			            		<input type="text" name="email" placeholder="johndoe@example.com" id="email" class="form-control" required data-parsley-type="email" data-parsley-trigger="on change" />
			            	</div>
			            </div>
					  </div>
					  
	          	<div class="form-group">
		          		<div class="row">
			            	<label class="col-md-4 text-right">Comments</label>
			            	<div class="col-md-6">
							<textarea name="msg" placeholder="Enter your message here..." id="msg" class="form-control"  required  data-parsley-trigger="on change"></textarea>
			            	</div>
			            	<div class="col-md-2">
			            		<button type="button" name="add_comment" id="add_comment" class="btn btn-success btn-sm">+</button>
			            	</div>
			            </div>
					
		            	<div id="append_comment"></div>
		          	</div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="hidden_id" id="hidden_id" />
          			<input type="hidden" name="action" id="action" value="Add" />
          			<input type="submit" name="submit" id="submit_button" class="btn btn-success" value="Add" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>

<div id="viewticketModal" class="modal fade">
  	<div class="modal-dialog"> 
	  <form method="post" class="form" id="comment_form" >	   	
      		<div class="modal-content">
        		<div class="modal-header ">
					  <h4 class="modal-title text-center " id="viewmodal_title"><span id="titleview"></span> <span id="statusview"class=" text-danger ">()</span></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
        		</div>
        		<div class="modal-body">
        			<span id="form_message"></span>
		          	<div class="form-group">
					  <div class="row">	
					  <label class="col-md-12 text-center">Ticket data</label> </div>
					  <div class="row">	 
					  <div class="col-md-12">
						<p> Created on: <span id="dateview"></span></p>
						<p id="messageview"></p>
						</div>
			            </div>
					  </div>
					  <div class="form-group">
		          		<div class="row">
			            	<label class="col-md-1 text-left">Email: </label>
			            	<div class="col-md-6 text-left">
							<span id="emailview"></span>						            		
			            	</div>
			            </div>
					  </div>
					  <div class="form-group">
					  <div class="row">	
					  <label class="col-md-12 text-center">Change status</label> </div>
					  <div class="row">						  
					  <div class="col-md-12">
					  <?php if($check->is_master_admin()):?>					
						<button type="button" name="closed_button" class="btn btn-secondary status_button" data-status="closed" data-id="">Closed</button>
						<?php endif?>
						<button type="button" name="resolved_button" class="btn btn-success status_button" data-status="resolved" data-id="">Resolved</button>
						<button type="button" name="pending_button" class="btn btn-danger status_button" data-status="pending" data-id="">Pending</button>
						<button type="button" name="on-hold_button" class="btn btn-warning status_button" data-status="on-hold" data-id="">On hold</button>
						</div>
			            </div>
					  </div>
					 
					  <div class="form-group">
		          		<div class="row">
							<label class="col-md-12 text-center">Comments</label>
							<div class="col-md-12 comments_view text-center" style="display:none"><h5><i class="fa fa-spinner fa-pulse "></i> Loading comments...</h5></div>					  
			            	<div class="col-md-12 allcomments" id="allcomments">        
			            	</div>
			            </div>
					  </div>
					  
	          	<div class="form-group">
		          		<div class="row">			            	
			            	<div class="col-md-12">														
							<textarea name="usermsg" placeholder="Enter comments here..." id="ticketcomments" value=""class="form-control"  required  data-parsley-trigger="on change"></textarea>
							 </div>			            	
			            </div>		            	
					  </div>
        		</div>
        		<div class="modal-footer">
          			<input type="hidden" name="id" id="ticketcommentid" value="">
          			<input type="submit" name="submit" id="comment_submit_button" class="btn btn-success" value="Post comment" />
          			<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        		</div>
      		</div>
    	</form>
  	</div>
</div>
<?php include_once(INCLUDES.'admin_footer.php')?>
<script src="<?= JS_URL?>tickets.js"></script>