<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');  

$katha = new publicview();
$user_id=isset($_SESSION['id']) ? $_SESSION['id']:"";
$user_name=isset($_SESSION['user_name']) ? $_SESSION['user_name']:"";
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
$chats = allConversation();
?>

    <div class="d-flex flex-column " id="content-wrapper">
        <div id="content">    
            <div class="container-fluid ">   
                <div class="col p-0">    
                    <div class="d-flex flex-column" >    
                        <h1 class="alert-primary text-center ">
                            Full Conversation
                        </h1>
                    </div>
                </div> 
                <?php if (isset($chats) &&!empty($chats)): ?>
                <?php foreach ($chats as $key => $chat): ?>
                    <div class="dropdown ">
                <div class="dropdown-list  ">
                    <div class="row reply_on_click">
                        <div class="col">
                            <div class="card shadow  message_head" id="message_head_big_<?php echo $chat['id'];?>">
                                <div class=" d-flex  justify-content-between align-items-center float-right">                                    
                                    <h6 class="text-primary font-weight-bold m-0 ">
                                        <a class="d-flex align-items-center dropdown-item " style="cursor:pointer">
                                        <?php if ( $check->is_same_user($chat['sender_id'])):?>
                                            <div class="dropdown-list-image mr-3 ">
                                                <img class="rounded-circle" src="<?php echo USER_IMAGES_URL.$chat['profile_image']; ?>" height="30" width="30">
                                                <div class="badge status-indicator bg-transparent spinner-grow spinner-grow-sm spinner-border-sm d-inline mt-4 text-left position-absolute" role="status" style="z-index:5;margin-left:-17px;"> 
                                                    <i class="fa fa-circle text-success" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                        <?php endif?>     
                                            <div class="text-left font-weight-bold">
                                                <div class="text-truncate overflow-hidden">
                                                    <span class="sender_message" id="sender_message_<?php echo $chat['id']; ?>">
                                                        <?php echo htmlspecialchars($chat['message']); ?>
                                                    </span>
                                                </div>
                                                <span class="small text-gray-500 mb-0 sender_username">
                                                    <?php echo ($chat['username']==$username)?'You':ucwords($chat['username']); ?>
                                                </span>
                                                <p class="small text-gray-500 mb-0 d-inline">
                                                    -<time class="timeago" datetime="<?php echo $chat['sent_on']; ?>"></time>
                                                </p>
                                            </div>
                                            <?php if ( !$check->is_same_user($chat['user_id'])):?>
                                            <div class="dropdown-list-image ml-3">
                                                <img class="rounded-circle" src="<?php echo USER_IMAGES_URL.$chat['profile_image']; ?>" height="30" width="30">
                                                <div class="badge status-indicator bg-transparent spinner-grow spinner-grow-sm spinner-border-sm d-inline mt-4 text-left position-absolute" role="status" style="z-index:5;margin-left:-17px;"> 
                                                    <i class="fa fa-circle text-success" aria-hidden="true"></i>
                                                </div>
                                            </div>
                                            <?php endif?> 
                                         </a> 
                                    </h6>    
                                    <div class="dropdown no-arrow">
                                        <button class="btn btn-link btn-sm" data-toggle="dropdown" aria-expanded="false" type="button">
                                            <i class="fas fa-ellipsis-v text-blue-400"></i>
                                        </button>
                                        <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
                                            <a class="dropdown-item pt-0 messageaction" role="presentation" data-receiver_id="<?php echo $user_id ?>"
                                            data-sender_id="<?php echo $chat['sender_id']; ?>" data-action="delete" data-id="<?php echo $chat['id']; ?>"
                                            style="cursor:pointer">
                                            Delete this message
                                            </a>           
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
                                                <div class="icon-circle">
                                                    <i class="fas fa-frown text-secondary fa-3x"></i>
                                                </div>   
                                            </div>
                                            <div>
                                                <h2 class="text-center ml-3">You do not have any Messages. Please comeback Later.</h2>
                                            </div>
                                        </a> 
                                    </h6>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
$(document).ready(function()
{    
    $('.messageaction').on('click', function()
    {      
      var action= $(this).data('action');      
      var id= $(this).data('id');
      var sender_id=$(this).data('sender_id');
      var url=$('#ajaxurl').val();      
      $clickedbutton=$(this);
      $div=$clickedbutton.closest('div.row');
      if(action=='delete')
        $div.fadeOut('slow');
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
});
</script>
<input type="hidden" name="" id="ajaxurl" value="<?php echo ADMIN_SERVER_URL.'message_server.php'?>">
<input type="hidden"id="user_message_server" value ="<?php echo USER_SERVER_URL.'message_server.php' ?>">