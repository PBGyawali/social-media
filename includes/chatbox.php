 <?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$username=(isset($_SESSION['username']))?ucwords($_SESSION['username']):'';
$chat_object = new records;
$user_data = $chat_object->get_user_all_data();
?>
	<style type="text/css">
		html,body { height: 100%; width: 100%;margin: 0;}
		#user_list{	height:150px;overflow-y: auto;}
    #chatbox{	height:300px;}    
		#messages_area{height: 650px;overflow-y: auto;background-color:#e6e6e6;}
/* Button used to open the chat form - fixed at the bottom of the page */
.open-button { position: fixed;   cursor: pointer;  opacity: 0.8;    bottom: 23px;
  right: 28px;  width: 100px;  font-size: 4rem;  border-radius: 50%;  z-index: 8;}  

  /* The popup chat - hidden by default */ 
.chat-popup { position: fixed;  bottom: 90px;  right: 0;
  border: none;  z-index: 9;  margin-bottom: 10px;}

/* Add styles to the form container */
.form-container { width:300px; max-width: 400px; padding: 0px; background-color: none;}

/* Full-width textarea */
.form-container input.msg { padding: 0px; margin: 5px 0 22px 0; 
border: none; background: #050505; min-height: 50px;
}

/* When the textarea gets focus, do something */
.form-container input.msg:focus { background-color: rgb(255, 255, 255);  outline: 1px solid black;  height:100px;}

/* Set a style for the submit/send button */
.form-container .btn {  font-size: 1rem;   opacity: 0.8;  transition-duration: 0.4s; }

.form-container .btn:hover, .open-button:hover {  opacity: 1;  color: white;  }

#all_messages{max-width: 300px;max-height: 450px;}
</style>
</head>

<div class="container">
    <div class="row">
        <div class=" col xs-0 col sm-0 col-md-12">
            <button class="open-button bg-white position-fixed p-0 border-0 mb-5" role="button" 
                data-sender_id="" data-id="">
                <i class="chatboxicon text-dark fa fa-comments fa-1x  p-0"></i>
            </button>
            <div class="chat-popup d-none" id="chatbox">
            <ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
     <li class="nav-item" role="presentation">
    <a class="nav-link active tabbutton" data-id="ex1-tabs-0" data-mdb-toggle="tab" href="#ex1-tabs-0" role="tab" aria-controls="ex1-tabs-0" aria-selected="true">Message</a>
  </li>  
  <li class="nav-item" role="presentation">
    <a class="nav-link tabbutton" data-id="ex1-tabs-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="false">Support</a>
  </li>
</ul> 
<!-- Tabs content -->
<div class="tab-content" id="ex1-content">
<div class="tab-pane show active" id="ex1-tabs-0" role="tabpanel" aria-labelledby="ex1-tab-0">
    <div class="card shadow mb-4">
        <div class="card-header">
            <div class="row">
                <div class="col">
                <div class="card">
					<div class="card-body" id="user_list">
						<div class="list-group list-group-flush">
						<?php
						if(count($user_data) > 0){
							foreach($user_data as $key => $user){
								$icon = '<i class="fa fa-circle text-danger"></i>';
								if($user['login'] == 'home')
									$icon = '<i class="fa fa-circle text-success"></i>';
								if($user['id'] != $_SESSION['id']){
									echo '<a class="list-group-item-action">
										<img src="' .USER_IMAGES_URL.$chat_object->image_check($user["profile_image"],USER_IMAGES_DIR).'" class="img-fluid rounded-circle img-thumbnail" width="50" />
										<span class="ml-1"><strong>'.$user["username"].'</strong></span>
										<span class=" ml-1 mt-2 float-right">'.$icon.'</span></a>';
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
    </div>
  </div><!-- end of 1st tab div content --> 
  <div class="tab-pane show" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
  <div class="card shadow ">
        <div class="card-header">
            <div class="row">
                <div class="col">
                <div class="card">
                <div ><i class="fas fa-comment chatboxicon p-0"></i> Support: </div>                            
                <span class="usermessage">Hello <?php echo $username?>. What can we do for you?</span>
                <p><span class="usermessagedate" id="usermessagedate"></span></p>
                <span id="typing_on"></span>         
						</div>
					</div>
        </div>   
      </div>                
    </div>
            
				<form method="post" id="chat"class="form-container p-0" data-parsley-errors-container="#validation_error">
        <div class="input-group mb-3">
						<textarea  id="sender_msg" name="chat_message" placeholder="Type Message Here" class="msg form-control bg-secondary text-white" value="" autocomplete="off"  data-parsley-minlength="1" data-parsley-trigger="keyup" data-parsley-maxlength="1000" data-parsley-pattern="/^[a-zA-Z0-9\s]+$/" required></textarea>
						<div class="input-group-append">
							<button type="submit" name="send" id="send" class="btn btn-primary"><i class="fa fa-paper-plane"></i></button>
						</div> 
          </div>
          <input type="hidden"id="chat_username" value ="<?php echo $username?>">
                      <input type="hidden"id="imagesource" value ="<?php echo USER_IMAGES_URL.$profileimage; ?>">
                      <input type="hidden"id="receiver_type" value ="support">
                      <input type="hidden"id="sender_id" value ="">
                      <input type="hidden"id="receiver_id" value ="">
					<div id="validation_error"></div>
				</form>
			</div>
            
      
 
  </div><!-- end of 2nd tab div content -->





                   
              </div>
          </div>
      </div>
  </div>
</head>
<body >

	</div>
</body>
</html>
<script>

$(document).ready(function() 
{ 

  var msg = $('#sender_msg');
      var username = $("#chat_username").val();      
      var src=$("#imagesource").val(); 
      var typingStatus = $('#typing_on');
      var lastTypedTime = new Date(0);
      var time=getDate();
      var delay = 8000; //typing delay time in milliseconds


  $('.tabbutton').on('click', function(event){ 
        event.preventDefault(); 
        var tabpane=$(this).data('id');
        $('.tabbutton').removeClass('active');
        $(this).toggleClass('active');                   
        $('.tab-pane').hide();          
        $('#'+tabpane).show();
        $("#usermessagedate").text(getDate(true));  
    });

  $('.open-button').on('click', function(event){   
      $('#chatbox').toggleClass('d-none');    
        var sender_id=$(this).data('sender_id');    
        var receiver_id= $(this).data('id');
        var receiver_type=$('#receiver_type').val();        
  });  
  function refreshTypingStatus(){
      if (!msg.is(':focus') || msg.val() == '' || new Date().getTime() - lastTypedTime.getTime() > delay)          
          typingStatus.html('');
        else           
          typingStatus.html(username+' is typing...');          
  }
      function updateLastTypedTime(){
          lastTypedTime = new Date();
      }

      setInterval(refreshTypingStatus, 500);
      msg.keypress(updateLastTypedTime);
      msg.blur(refreshTypingStatus);
        
      function getDate(time=null) {
          var date;
          date = new Date();
          if(time)
          return date.toLocaleString([], { hour: 'numeric', minute: 'numeric' });
          return  date.toLocaleString();          
      } 
      function chatmsg(id=1,src,username,txt,iconclass,time=null){
          new_id=id*1+1;
          $('#newusermessage_'+id).remove();
          var chat_msg=	'<div id="newusermessage_'+new_id+'">'+
                      '<div>'+
              '<img src="'+src+'" class="rounded-circle mb-0 mt-0" height="30" width="30"> '+ username+":"+
                '</div>'+ '<div>'+                           
              '<span class="usermessage_1">'+txt+' <i class="fas fa-'+iconclass+'"</i></span>'+'</div>'+				
              '<p><span class="ticketcommentdate">'+'<time class="chattimeago" datetime="'+time+'">'+time+'</time></span></p>';               
              $('#all_messages').append(chat_msg); 
        }
        $('#chat').on('submit', function(event)
        {     var url=$('#user_message_server').val();                
              var g=new Date();
              event.preventDefault();
              var sender_id=$('#sender_id').val();
              var receiver_id=$('#receiver_id').val();
              var time=getDate();          
              var txt = $("#sender_msg").val();
              if (txt==""){
                alert('the text is empty');
                return false;
              }
              var username = $("#chat_username").val();
              chatmsg(1,src,username,txt,'pause-circle  text-primary',time);
              $.ajax
              ({
                  url:url,
                  method:"POST",
                  data:{image:src, username:username,text:txt,sender_id:sender_id,receiver_id:receiver_id,user_message:1},
                  dataType:"JSON",
                  beforeSend:function(){
                    chatmsg(1,src,username,txt,'clock text-warning',time);                   			
                  },
                  error:function(){   
                    chatmsg(2,src,username,txt,'times text-danger unsent',time);
                  },                  		
                    success:function(data)  {   		
                    $('#newusermessage_1,#newusermessage_2,#newusermessage_3').remove();
                    $('#all_messages').append(data);					
                  },
                  complete:function() {				
                    $("#sender_msg").val(''); 
                    $('.chattimeago').timeago('update', new Date());                                     		
                  },                  
                })             
        });

       
				
});     
</script>
