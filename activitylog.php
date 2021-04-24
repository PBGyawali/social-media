<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_INCLUDES.'minimal_header.php');
include_once(USER_INCLUDES.'sidebar.php');
$logs=$records->useractivitylogs();
?>
<input type="hidden" name="" id="ajaxurl" class="activity_log" value="<?= BASE_URL?>event_handler.php">
<div class="col py-4">

<div class="d-flex flex-column " id="content-wrapper">
<div id="content">
    <div class="container-fluid ">
    <div class="col-12 p-0">
    <div class="d-flex flex-column" >
<h1 class="alert-primary text-center ">Activity log </h1>
</div>
</div> 
 <?php if (isset($logs)&&!empty($logs)): ?> 

        <?php foreach ($logs  as $key => $log): ?>
        <div class="row">
        <div class="col-lg-12 col-xl-12 col-sm-12">
        <div class="card shadow mb-1">
        <div class="card-header d-flex text-center justify-content-between align-items-center">
        <h6 class="text-primary font-weight-bold m-0 ">
        <a class="d-flex align-items-center dropdown-item " >
            <div class="mr-3">
            <?php 
                $iconclass=' text-primary ';               
                $activitytypes=array("comment","reply","money","update","delete","warning","logout","unfollow",
                "undislike","unlike","follow","dislike","like","reset","login","register","other");
                $icontype=array("comment","comments","donate","sync","trash","exclamation-triangle","sign-out-alt","user-minus",
                "thumbs-down","thumbs-up","user-plus","thumbs-down","thumbs-up","reply","sign-in-alt","user-graduate","file-alt");                                        
                if     (in_array($log['type'],(array_slice($activitytypes,0,2)))) $iconclass=' text-info ';
                elseif (in_array($log['type'],(array_slice($activitytypes,2,2)))) $iconclass=' text-success ';
                elseif (in_array($log['type'],(array_slice($activitytypes,4,2)))) $iconclass=' text-danger ';
                elseif (in_array($log['type'],(array_slice($activitytypes,6,4)))) $iconclass=' text-secondary ';
                foreach($activitytypes as $key=> $activitytype)  
                    if($log['type']== $activitytype) 
                        break;												                    
            ?>										
            <div class="icon-circle "><i class="fa fa-<?=$icontype[$key].$iconclass?>"></i></div>                
            </div><?php $parent=$log['parent_activity_text'];?>
            <div><span class="small text-gray-500"><?php echo $log['activity_performed']; ?></span>
                <p><?php echo $log['text'].' '.$log['activity_object'].(($parent)?' "'.$parent.'"':"").'.'; ?></p>
            </div>
        </a> </h6>
        <div class="dropdown no-arrow">
        <button class="btn btn-link btn-sm" data-toggle="dropdown" aria-expanded="false" type="button">
        <i class="fas fa-ellipsis-v text-blue-400"></i></button>
        <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
        <p class="text-center dropdown-header m-0 p-0">Action:</p>
        <a class="dropdown-item pt-0 logaction" role="presentation" data-action="delete" data-type="<?=$log['type'];?>" data-id="<?php echo $log['id']; ?>" >Delete this</a>  
        <a class="dropdown-item pt-0 logaction" role="presentation" data-action="delete" data-type="<?=$log['type'];?>" data-id="<?php echo $log['type']; ?>" >Clean related logs</a>        
        </div>
        </div>
        </div>
        </div>
        </div>
        </div>
        <?php endforeach ?>
<?php else: ?>
    <div class="row">
        <div class="col-lg-12 col-xl-12 col-sm-12">
        <div class="card shadow mb-1">
        <div class="card-header d-flex text-left ">      
        <a class="text-dark font-weight-bold m-0">            
        <h3>Sorry you do not have any activity logs at the moment. Perform some activities for your activity logs to be recorded.</h3>
        </a>
        </div>
        </div>
        </div>    
<?php endif ?>

</div>
<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<?php include_once ( USER_INCLUDES . 'footer.php') ?>
<script type="text/javascript">
$(document).ready(function()
{
    $('.alertaction,.logaction').on('click', function()
    {      
      var action= $(this).data('action');
      var type= $(this).data('type');
      var id= $(this).data('id');
      var url=$('#ajaxurl').val();
      var table=$('#ajaxurl').attr('class');
      $clickedbutton=$(this);
      $div=$clickedbutton.closest('div.row');
      if(action=='delete')
        $div.fadeOut('slow');
      else if(action=='delete_similar')
        $('.'+type).fadeOut('slow');
      $.ajax
      ({
            url: url,
            method: 'post',
            data: 
            {
                request:action,
                type:type,
                id:id,
                table:table
            },
            dataType:"JSON",
            error:function(request)
            {   
                $div.show();       
            },	  
            success: function(data)
            {
                if (data!=""){
                    if(data==0)                    
                        $('#alertcount').text('');                    
                    else if(data>3)                    
                        $('#alertcount').text(data+'+');                    
                    else                    
                        $('#alertcount').text(data);                    
                }
            }
        });
    });
});</script>