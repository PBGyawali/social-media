<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');

include_once(USER_INCLUDES.'minimal_header.php');
include_once(USER_INCLUDES.'sidebar.php');
$messages =$records-> allOfflineMessages();
$user_id=(isset($_SESSION['id']))?$_SESSION['id']:'';
include_once(USER_INCLUDES.'/chatbox.php');?>
<div class="col-lg-12 col-xl-12 col-sm-12 col-xs-8 offset-xs-3 mr-5">
<div class="d-flex flex-column " id="content-wrapper">
<div id="content">    
<div class="container-fluid ">   
 <div class="col-lg-12 col-xl-12 col-sm-6 p-0">    
<div class="d-flex flex-column" >    
<h1 class="alert-primary text-center ">Your All Messages</h1></div></div> 
<?php if (isset($messages) &&!empty($messages)): ?>
                <?php foreach ($messages as $key => $chat): ?>  
                    <?php 
                            $float=$row_class='';                                                         
                            $background_class =' ';                 
                                                        ?>
                    <div class="row "><div class="col"><div class="card shadow mb-3 alert " >
                                <div class=" d-flex    justify-content-between align-items-center float-right" >
                                <div class="dropdown-list-image mr-3 ">
                                    <img class="rounded-circle" src="<?= USER_IMAGES_URL.$records->image_check($chat['profile_image'],USER_IMAGES_DIR); ?>" height="60" width="60">                                    
                                    <div class="badge status-indicator bg-transparent spinner-grow spinner-grow-sm spinner-border-sm d-inline mt-5 text-left position-absolute" role="status" style="z-index:5;margin-left:-17px;"> 
                                        <i class="fa fa-circle text-success" aria-hidden="true"></i>
                                    </div>                                
                                </div>
                                <a class="d-flex align-items-center dropdown-item mt-3" href="conversation.php?message_id=<?= $chat['sender_id']; ?>" style="white-space: normal;cursor:pointer;">
                                                                              
                                             <div class="text-left "> <div class="">
                                             <span> <p class="">
                                             <?= htmlspecialchars($chat['message']);?>
                                             </p></span>
                                                </div><span class="">
                                                <span class="small mb-0  font-weight-bold"><?= ($_SESSION['id']==$chat['sender_id'])?'You':$chat['username'];?></span>
                                                <p class="small mb-0 d-inline">-<time class="timeago" datetime="<?= $chat['sent_on']; ?>"></time></p>
                                                 </span>
                                            </div> </a> 
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-link btn-sm" data-toggle="dropdown"  type="button"><i class="fas fa-ellipsis-v text-blue-400"></i></button>                                        
                                            <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $message['sender_id']; ?>" data-id="<?= $message['id']; ?>" style="cursor:pointer" data-action="delete"       >Delete this conversation</a>
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $message['sender_id']; ?>" data-id="<?= $message['id']; ?>" style="cursor:pointer" data-action="notification" >Turn off notification</a>
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $message['sender_id']; ?>" data-id="<?= $message['id']; ?>" style="cursor:pointer" data-action="read"         >Mark as Read</a>
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?= $user_id ?>" data-sender_id="<?= $message['sender_id']; ?>" data-id="<?= $message['id']; ?>" style="cursor:pointer" data-action="archive"      >Archive</a>
                                            
                                        </div>                                    
                                     </div>
                                     </div>
                                    </div>
                                     </div>  
                                    </div> 
                                        <?php endforeach ?> 
<?php else: ?>
    <div class="row ">
<div class="col-lg-12 col-xl-12 col-sm-6">
<div class="card shadow mb-1 col-lg-12 col-xl-12 col-sm-6">
<div class="card-header d-flex text-center justify-content-between align-items-center">
<h6 class="text-primary font-weight-bold m-0 ">
<a class="d-flex align-items-center dropdown-item " >
    <div class="mr-4"> 
        <div class="icon-circle"><i class="fas fa-frown text-secondary fa-3x"></i></div>   
    </div>
    <div>
        <h2 class="text-center ml-3">You do not have any Messages. Please comeback Later.</h2>
    </div>
</a> </h6>

</div>
</div>
</div>
</div>
<?php endif ?>



</div>

<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<script type="text/javascript">


$(document).ready(function()
{
    $('#usermessage_0').hide();
    $('#chatbox_heading').text('Message');
    $('#receiver_type').val("user");   
    $('.messageaction').on('click', function()
    {      
      var action= $(this).data('action');      
      var id= $(this).data('id');
      var sender_id=$(this).data('sender_id');
      var url=$('#ajaxurl').val();      
      $clickedbutton=$(this);
      $div=$clickedbutton.closest('div.row');
      if(action=='delete'){
        $div.fadeOut('slow');  
      }
      if(action=='read'){
        $div.attr('css','slow');         
      }
          
      $.ajax
      ({
            url: url,
            method: 'post',
            data: 
            {
                message:action,                
                id:id,
                sender_id:sender_id
            },
            dataType:"JSON",
            error:function(request)
            {          
                alert(request.responseText); 
                $div.show();       
            },	  
            success: function(data)
            {
                if (data!="")
                {
                    if(data==0)
                        $('#messagecount').text('');
                    else if(data>3)
                        $('#messagecount').text(data+'+');
                    else
                        $('#messagecount').text(data);
                }
            }
        });
  


    });
    /*$('.reply_on_click').on('click', function()
    {      
        $('#chatbox').toggleClass('d-none'); 
      var sender_text= $(this).children().find('span.sender_message').text();
      var sender_image= $(this).children().find('img').attr('src');      
      var sender_username=$(this).children().find('.sender_username').text();
      var sender_id=$(this).children().find('a.messageaction').data('sender_id');//sender of the message
      $('#new_sender_usermessage_'+sender_id).hide();
      var receiver_id=$(this).children().find('a.messageaction').data('receiver_id');
      var time=$(this).children().find('.timeago').text();      
      var url=$('#ajaxurl').val();
      //incase of reply sender becomes the receiver and receiver becomes the sender
      $('#sender_id').val(receiver_id);
      $('#receiver_id').val(sender_id);
      var chat_msg=	'<div id="new_sender_usermessage_'+sender_id+'">'+
                      '<div class="text-dark">'+
              '<img src="'+sender_image+'" class="rounded-circle mb-0 mt-0" height="30" width="30"> '+ sender_username+
                '</div>'+ '<div>'+                           
              '<span class="usermessage_1">'+sender_text+'</span>'+'</div>'+				
              '<p><span class="ticketcommentdate">'+'<time class="timeago" datetime="'+time+'">'+time+'</time></span></p>';
      $('#all_messages').empty();  
      $('#all_messages').append(chat_msg);
      $("#sender_msg").val(''); 
      return ; 
    });*/


  
  
});






</script>
<input type="hidden" name="" id="ajaxurl" value="<?= BASE_URL?>event_handler.php">
<input type="hidden"id="user_message_server" value="<?= BASE_URL?>event_handler.php">