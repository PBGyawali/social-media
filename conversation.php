<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$chat_object = new records;
$messageid='';
if(isset($_GET['message_id']))
$messageid=$_GET['message_id'];
$chat_data = $chat_object->get_all_chat_data($messageid);
$user_data = $chat_object->get_user_all_data();

$login_user_id = '';
include_once(USER_INCLUDES.'minimal_header.php');
include_once(USER_INCLUDES.'sidebar.php');
?>
	<style type="text/css">
		html,body { height: 100%; width: 100%;margin: 0;}
		#user_list{	height:450px;overflow-y: auto;}
		#messages_area{height: 650px;overflow-y: auto;background-color:#e6e6e6;}
	</style>
</head>
<body >
	<div class="container">		
		<div class="row">       
			<div class="col-lg-8">                
				<div class="card">
					<div class="card-header text-center"><div class="dropdown-list-image mr-3 d-inline align-items-center">
                    <img src="<?= USER_IMAGES_URL.$chat_object->image_check($chat_data[0]["profile_image"],USER_IMAGES_DIR);?>" width="40" class="img-fluid rounded-circle img-thumbnail m-0 p-0 align-items-center " />                                             
                    <h3 class="d-inline"><?= $chat_data[0]['username']; ?></h3>   </div></div>
					<div class="card-body" id="messages_area">                
                <?php foreach ($chat_data as $key => $chat): ?>  
                    <?php 
                            $float=$row_class='';                                                         
                            $background_class =' alert-success ';
                            if($_SESSION['id']!=$chat['sender_id']){ 
                                    $row_class = ' flex-row-reverse ';
                                    $background_class = '';
                                    $float=' float-right ';                                  
                            }                              ?>
                    <div class="row "><div class="col"><div class="card shadow mb-3 alert <?= $background_class?> " >
                                <div class=" d-flex  <?=$row_class?>  justify-content-between align-items-center float-right" >
                                <div class="dropdown-list-image mr-3 ">
                                    <img class="rounded-circle" src="<?= USER_IMAGES_URL.$chat_object->image_check($chat["profile_image"],USER_IMAGES_DIR); ?>" height="35" width="35">                                                
                                </div>
                                        <a class="d-flex <?=$row_class?> align-items-center dropdown-item  mt-3" style="white-space: normal;" >                                       
                                             <div class="text-left "> <div class="">
                                             <span> <p class="">
                                             <?= htmlspecialchars($chat['message']);?>
                                             </p></span>
                                                </div><span class="<?=$float?>">
                                                <span class="small mb-0  font-weight-bold"><?= ($_SESSION['id']==$chat['sender_id'])?'You':$chat['username'];?></span>
                                                <p class="small mb-0 d-inline">-<time class="timeago" datetime="<?= $chat['sent_on']; ?>"></time></p>
                                                 </span>
                                            </div> </a> 
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-link btn-sm" data-toggle="dropdown"  type="button"><i class="fas fa-ellipsis-v text-blue-400"></i></button>
                                        <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
                                            <a class="dropdown-item pt-0 ">Delete this message</a>           
                                        </div>
                                     </div>
                                     </div>
                                    </div>
                                     </div>  
                                    </div> 
                                        <?php endforeach ?> 
                                        
					</div>
				</div>
				<form method="post" id="chat_form" data-parsley-errors-container="#validation_error">
					<div class="input-group mb-3">
						<textarea class="form-control" id="chat_message" name="chat_message" placeholder="Type Message Here" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
						<div class="input-group-append">
							<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
						</div>
					</div>
					<div id="validation_error"></div>
				</form>
			</div>
			<div class="col-lg-4">
				<?php $login_user_id=$_SESSION['id'];?>
				<input type="hidden" name="login_user_id" id="login_user_id" value="<?= $login_user_id;?>" />
				<div class="mt-3 mb-3 text-center">
					<img src="<?= USER_IMAGES_URL.$chat_object->image_check($chat_data[0]["profile_image"],USER_IMAGES_DIR);?>" width="100" class="img-fluid rounded-circle img-thumbnail" /><br>
                    <h3 class="d-inline"><?= $chat_data[0]['username']; ?></h3>
                    <div class="dropdown d-inline">
                                        <button class="btn btn-link btn-sm mt-0 pt-0" data-toggle="dropdown"  type="button"><i class="fas fa-ellipsis-v "></i></button>
                                        <div class="dropdown-menu shadow dropdown-menu-right animated--fade-in" role="menu">
                                            <a class="dropdown-item pt-0 "href="profile.php?user=<?= $chat_data[0]['sender_id']; ?>" >Profile</a>           
                                        </div>
                                     </div>
				</div>
				<div class="card mt-3">
					<div class="card-header text-center">User List</div>
					<div class="card-body" id="user_list">
						<div class="list-group list-group-flush">
						<?php
						if(count($user_data) > 0){
							foreach($user_data as $key => $user){
								$icon = '<i class="fa fa-circle text-danger"></i>';
								if($user['login'] == 'home')
									$icon = '<i class="fa fa-circle text-success"></i>';
								if($user['id'] != $login_user_id){
									echo '<a class="list-group-item list-group-item-action" href="conversation.php?message_id='. $user['id'].'">
										<img src="' .USER_IMAGES_URL.$chat_object->image_check($user["profile_image"],USER_IMAGES_DIR).'" class="img-fluid rounded-circle img-thumbnail" width="50" />
										<span class="ml-1"><strong>'.$user["username"].'</strong></span>
										<span class="mt-2 float-right">'.$icon.'</span></a>';
								}
							}
						}
						?>
						</div>
					</div>
				</div>

			</div>
		</div>
	</div>
</body>
<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<script type="text/javascript">
	
	$(document).ready(function(){
		var conn = new WebSocket(' ws://127.0.0.1');
		conn.onopen = function(e) {
		    console.log("Connection established!");
		};

		conn.onmessage = function(e) {
		    console.log(e.data);
		    var data = JSON.parse(e.data);
		    var row_class = '';
		    var background_class = '';
		    if(data.from == 'Me')
		    {
		    	row_class = 'row justify-content-start';
		    	background_class = 'text-dark alert-light';
		    }
		    else
		    {
		    	row_class = 'row justify-content-end';
		    	background_class = 'alert-success';
		    }

		    var html_data = "<div class='"+row_class+"'><div class='col-sm-10'><div class='shadow-sm alert "+background_class+"'><b>"+data.from+" - </b>"+data.msg+"<br /><div class='text-right'><small><i>"+data.dt+"</i></small></div></div></div></div>";

		    $('#messages_area').append(html_data);
		    $("#chat_message").val("");
		};

		$('#chat_form').parsley();
		$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);

		$('#chat_form').on('submit', function(event){
			event.preventDefault();
			if($('#chat_form').parsley().isValid())
			{
				var user_id = $('#login_user_id').val();
				var message = $('#chat_message').val();
				var data = {
					userId : user_id,
					msg : message
				};
				conn.send(JSON.stringify(data));
				$('#messages_area').scrollTop($('#messages_area')[0].scrollHeight);
			}

		});
		
	
	});
	
</script>
</html>
