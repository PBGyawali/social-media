<?php 
include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');  
include_once(ADMIN_CLASS.'katha.php');
$katha = new katha();
include_once(ADMIN_INCLUDES.'header.php');
include_once(ADMIN_INCLUDES.'sidebar.php');
$alerts =$records-> allalerts();
?>

<input type="hidden" name="" id="ajaxurl" class="alerts" value="<?= BASE_URL?>event_handler.php">


<div class="d-flex flex-column " id="content-wrapper">
<div id="content">
    <div class="container-fluid ">
    <div class="col-12 p-0">
    <div class="d-flex flex-column" >
<h1 class="alert-primary text-center ">Alerts center</h1>
</div>
</div> 
<?php if (isset($alerts) &&!empty($alerts)): ?>
<?php foreach ($alerts  as $key => $alert): ?>
<div class="row <?php echo $alert['type']; ?>" id="alert_header_<?php echo $alert['id']; ?>">
<div class="col-lg-12 col-xl-12 col-sm-12">
<div class="card shadow mb-1" id="alert_<?php echo $alert['id']; ?>">
<div class="card-header d-flex text-center justify-content-between align-items-center">
<h6 class="text-primary font-weight-bold m-0 ">
<a class="d-flex align-items-center dropdown-item " style="cursor:pointer">
    <div class="mr-3">
    <?php 
        $iconclass=' text-primary ';
        $alerttypes=array("comment","reply","money","update","delete","warning",
        "unfollow","follow","dislike","like","reset",'other');
        $icontype=array("comment","comments","donate","sync","trash","exclamation-triangle","user-minus",
        "user-plus","thumbs-down","thumbs-up","reply",'file-alt' );                                        
        if     (in_array($alert['type'],(array_slice($alerttypes,0,2)))) $iconclass=' text-info ';
        elseif (in_array($alert['type'],(array_slice($alerttypes,2,2)))) $iconclass=' text-success ';
        elseif (in_array($alert['type'],(array_slice($alerttypes,4,2)))) $iconclass=' text-danger ';
        elseif (in_array($alert['type'],(array_slice($alerttypes,6,1)))) $iconclass=' text-secondary ';
        foreach($alerttypes as $key=> $alerttype)  
            if($alert['type']== $alerttype) 
                break;												                    
    ?>										
    <div class="icon-circle "><i class="fa fa-<?=$icontype[$key].$iconclass?>"></i></div>            
    </div>
    <div><span class="small text-gray-500"><?php echo $alert['alert_date']; ?></span>
        <p><?php echo $alert['alert']; ?></p>
    </div>
</a> </h6>
    <div class="dropdown no-arrow">
    <button class="btn btn-link btn-sm" data-toggle="dropdown" aria-expanded="false" type="button">
    <i class="fas fa-ellipsis-v text-blue-400"></i></button>
        <div class="dropdown-menu text-blue shadow dropdown-menu-right animated--fade-in" role="menu">
        <p class="text-center dropdown-header m-0 p-0">Action:</p>
        <a class="dropdown-item pt-0 alertaction" role="presentation" data-action="delete" data-type="<?php echo $alert['type']; ?>" data-id="<?php echo $alert['id']; ?>" style="cursor:pointer">Delete this alert</a>
        <a class="dropdown-item pt-0 alertaction" role="presentation" data-action="read" data-type="<?php echo $alert['type']; ?>" data-id="<?php echo $alert['id']; ?>" style="cursor:pointer">Mark as Read</a>
        <a class="dropdown-item pt-0 alertaction" role="presentation" data-action="delete_similar" data-type="<?php echo $alert['type']; ?>"data-id="<?php echo $alert['id']; ?>" style="cursor:pointer">Delete similar notifications</a>
        </div>
    </div>
</div>
</div>
</div>
</div>
<?php endforeach ?>
<?php else: ?>
    <div class="row ">
<div class="col-lg-12 col-xl-12 col-sm-12">
<div class="card shadow mb-1">
<div class="card-header d-flex text-center justify-content-between align-items-center">
<h6 class="text-primary font-weight-bold m-0 ">
<a class="d-flex align-items-center dropdown-item " >
    <div class="mr-4"> 
        <div class=" "><i class="far fa-folder-open text-danger fa-2x"></i></div>   
    </div>
    <div>
        <h2 class="text-center ml-3">You do not have any Alert. Please comeback Later.</h2>
    </div>
</a> </h6>

</div>
</div>
</div>
</div>
<?php endif ?>
</div>
<script type="text/javascript">


$(document).ready(function()
{
    $('.alertaction').on('click', function()
    {      
      var action= $(this).data('action');
      var type= $(this).data('type');
      var id= $(this).data('id');
      var url=$('#ajaxurl').val();      
      $clickedbutton=$(this);
      $div=$clickedbutton.closest('div.row');
      if(action=='delete'){
        $div.fadeOut('slow');  
      }
      if(action=='delete_similar'){
        $('.'+type).fadeOut('slow');         
      }
          
      $.ajax
      ({
            url: url,
            method: 'post',
            data: 
            {
                request:action,
                type:type,
                id:id
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
                    {
                        $('#alertcount').text('');
                    }
                    else if(data>3)
                    {
                        $('#alertcount').text(data+'+');
                    }
                    else
                    {
                        $('#alertcount').text(data);
                    }
                }
            }
        });
  


    });



  
  
});






</script>