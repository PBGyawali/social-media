<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$katha = new publicview();
if(!$katha->is_login())
{   
    $_SESSION['error']="You must log in to view that page";
	header("location:".$katha->base_url);
}
else 
{ 
    require_once(ADMIN_SERVER.'settings_server.php');
    $row = WebsiteArray(); 
}
$select=new select();
include_once(USER_INCLUDES.'minimal_header.php');
include_once(USER_INCLUDES.'sidebar.php');
?>
<div class="col-sm-12  py-4">
<div class="d-flex flex-column " id="content-wrapper">
<div id="content">    
<div class="container-fluid ">   
 <div class="col-12 p-0">    
<div class="d-flex flex-column" >  
<div class="alert alert-success success_msg" role="alert" id="success_msg" ></div>			
<div class="alert alert-danger error_msg" role="alert" id="error_msg" ></div>
<span id="message"></span>

<!-- Tabs navs -->
<ul class="nav nav-tabs mb-3" id="ex1" role="tablist">
     <li class="nav-item" role="presentation">
    <a class="nav-link active tabbutton" data-id="ex1-tabs-0" data-mdb-toggle="tab" href="#ex1-tabs-0" role="tab" aria-controls="ex1-tabs-0" aria-selected="true">Profile Settings</a>
  </li>
  <?php  if($katha->is_owner()):?>
  <li class="nav-item" role="presentation">
    <a class="nav-link tabbutton" data-id="ex1-tabs-1" data-mdb-toggle="tab" href="#ex1-tabs-1" role="tab" aria-controls="ex1-tabs-1" aria-selected="false">Website Settings</a>
  </li>
  <li class="nav-item" role="presentation">
    <a class="nav-link tabbutton" data-id="ex1-tabs-2" data-mdb-toggle="tab" href="#ex1-tabs-2" role="tab" aria-controls="ex1-tabs-2" aria-selected="false">Owner Settings</a>
  </li> 
  <?php  endif?>
</ul>
<!-- Tabs navs -->

<!-- Tabs content -->
<div class="tab-content" id="ex1-content">
<div class="tab-pane show active" id="ex1-tabs-0" role="tabpanel" aria-labelledby="ex1-tab-0">
  <form method="post" class="profile setting_form" id="profile_setting_form" enctype="multipart/form-data" action="<?php echo ADMIN_SERVER_URL.'settings_server.php'; ?>">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Profile Settings</h6>
                </div>
                <div clas="col text-right" >
                    <button type="submit" name="profile_edit_button" id="profile_edit_button" class="btn btn-primary btn-sm edit_button"><i class="fas fa-edit"></i> Save</button>
                    &nbsp;&nbsp;
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- form left side -->
                <div class="col-md-4">
                    
                <h6 class="card-header"> Notifications </h6>

                <div class="list-group-item d-flex justify-content-between align-items-center"> Someone follows you
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif01" class="switcher-input" checked="">                            
                          </label>
                        </div>
                        
    
    
                        <div class="list-group-item d-flex justify-content-between align-items-center"> Someone mentions you
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif02" class="switcher-input" checked="">                            
                            </label>
                        </div>   
    
                        <div class="list-group-item d-flex justify-content-between align-items-center"> Someone sends you a message
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif03" class="switcher-input" checked="">
                          </label>
                        </div>

                
                </div><!-- column wrapper div -->
                <!-- form center part -->
                <div class="col-md-4">
                <h6 class="card-header"> Post Notifications </h6>               

                    <div class="list-group-item d-flex justify-content-between align-items-center"> Someone update a post
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif04" class="switcher-input" checked="">
                          </label>
                        </div>
                        
    
    
                        <div class="list-group-item d-flex justify-content-between align-items-center"> Someone adds new posts
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif05" class="switcher-input" checked="">
                          </label>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center"> Someone comments on your post
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif06" class="switcher-input" checked="">
                          </label>
                        </div>
                        <div class="list-group-item d-flex justify-content-between align-items-center"> Someone Likes your post
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif07" class="switcher-input" checked="">
                          </label>
                        </div>
                </div><!-- column wrapper div -->
                 <!-- form right side -->
                <div class="col-md-4">
                    
                    <h6 class="card-header"> Posts &amp; Trending</h6> 
                    <div class="list-group-item d-flex justify-content-between align-items-center"> Top posts this week
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif08" class="switcher-input" checked="">
                          </label>
                        </div>
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center"> Top topic this week
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif09" class="switcher-input" checked="">
                          </label>
                        </div>
                        
                        
                        <div class="list-group-item d-flex justify-content-between align-items-center"> Rating reminders
                          <label class="switcher-control switcher-control-success">
                            <input type="checkbox" name="notif10" class="switcher-input">
                          </label>
                        </div>
                </div>

            </div>
                            <input type="hidden" name="user_id" value="<?=$user_id;?>">
            <div class="row">
                <!-- form left side -->
                <div class="col-md-4">
                <h6 class="card-header"> Login to </h6>
                          <select name="login_menu" id="login_menu" class="form-control" required>   
                        <option value=""selected disabled hidden>Select login Menu</option>		
                        <option value="dashboard" <?php echo ('' == 'dashboard'? 'selected="selected"': '' );?>>Dashboard</option>
                        <option value="home"  <?php echo ('' == 'home' ? 'selected="selected"': '' );?>>Home</option>                       	
                        </select>                  
                </div>
            </div>







        </div>
    </div>
</form>
  </div><!-- end of 1st tab div content -->
  <?php  if($katha->is_owner()):?>
  <div class="tab-pane show" id="ex1-tabs-1" role="tabpanel" aria-labelledby="ex1-tab-1">
  <form method="post" class="website setting_form" id="website_setting_form" enctype="multipart/form-data" action="<?php echo ADMIN_SERVER_URL.'settings_server.php'; ?>">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Website Settings</h6>
                </div>
                <div clas="col text-right" >
                    <button type="submit" name="website_edit_button" id="website_edit_button" class="btn btn-primary btn-sm edit_button"><i class="fas fa-edit"></i> Save</button>
                    &nbsp;&nbsp;
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- form left side -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Website Name</label>
                        <input type="text" name="website_name" id="website_name"  value="<?php echo ($row['website_name']) ?>"class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Website Email</label>
                        <input type="email" name="website_email" id="website_email" value="<?php echo $row['website_email']; ?>"class="form-control" data-parsley-type="email" data-parsley-trigger="keyup"/>
                    </div>
                   
                    <div class="form-group">
                        <label>Website Address</label>
                        <input type="text" name="website_address" id="website_address" value="<?php echo $row['website_address']; ?>" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>User Target</label>
                        <input type="number" name="user_target" id="user_target" value="<?php echo $row['user_target']; ?>" required class="form-control" />
                    </div>
                </div>
                 <!-- form right side -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Website Tagline</label>
                        <input type="text" name="website_tagline" id="website_tagline"value="<?php echo $row['website_tagline']; ?>"  class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Theme</label>
                        <select name="website_theme" id="website_theme" class="form-control" required>   
                        <option value=""selected disabled hidden>Select Theme</option>		
                        <option value="white" <?php echo ($row['website_theme'] == 'white'? 'selected="selected"': '' );?>>White</option>
                        <option value="dark"  <?php echo ($row['website_theme'] == 'dark' ? 'selected="selected"': '' );?>>Dark</option>
                       	
                        </select>
                        
                    </div>
                    <div class="form-group">
                        <label>Timezone</label>
                        <?php echo $select->Timezone_list($row['website_timezone']);?>
                    </div>
                    <div class="form-group">
                    <label>Select Logo</label><br />
                    <input type="file" name="website_logo" id="website_logo"  class="image file_upload" data-allowed_file='[<?php echo '"' . implode('","', ALLOWED_IMAGES) . '"'?>]' data-upload_time="later" accept="<?php echo "image/" . implode(", image/", ALLOWED_IMAGES);?>"/>
                    <br />
                    <span class="text-muted">Only <?php  echo join(' and ', array_filter(array_merge(array(join(', ', array_slice(ALLOWED_IMAGES, 0, -1))), array_slice(ALLOWED_IMAGES, -1)), 'strlen'));?> extensions are supported</span><br />
                   </div>
                </div>
            </div>
        </div>
    </div>
</form>
  </div><!-- end of 2nd tab div content -->

  <div class="tab-pane show" id="ex1-tabs-2" role="tabpanel" aria-labelledby="ex1-tab-2">

  <form method="post" class="owner setting_form" id="owner_setting_form" enctype="multipart/form-data" action="<?php echo ADMIN_SERVER_URL.'settings_server.php'; ?>">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="row">
                <div class="col">
                    <h6 class="m-0 font-weight-bold text-primary">Owner Settings</h6>
                </div>
                <div clas="col text-right" >
                    <button type="submit" name="owner_edit_button" id="owner_edit_button" class="btn btn-primary btn-sm edit_button"><i class="fas fa-edit"></i> Save</button>
                    &nbsp;&nbsp;
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <!-- form left side -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Owner Name</label>
                        <input type="text" name="owner_name" id="owner_name"  value="<?php echo ($row['owner_name']) ?>"class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Owner Email</label>
                        <input type="email" name="owner_email" id="owner_email" value="<?php echo $row['owner_email']; ?>"class="form-control" data-parsley-type="email" data-parsley-trigger="keyup"/>
                    </div>
                    <div class="form-group">
                        <label>Owner Contact No.</label>
                        <input type="text" name="owner_contact_no" id="owner_contact_no" value="<?php echo $row['owner_contact_no']; ?>"class="form-control" />
                        <span class="text-muted">Enter numbers excluding country codes and '0' if it is the starting digit</span><br />
                    </div>
                    <div class="form-group">
                        <label>Owner Address, House no</label>
                        <input type="text" name="owner_address" id="owner_address" value="<?php echo $row['owner_address']; ?>" class="form-control" />
                    </div>
                </div>
                <!-- form right side -->
                <div class="col-md-6">
                    <div class="form-group">
                        <label>Owner postalcode, City</label>
                        <input type="text" name="owner_postal_code" id="owner_postal_code"value="<?php echo $row['owner_postal_code']; ?>"  class="form-control" />
                    </div>
                   
                    <div class="form-group">
                        <label>Owner Country</label>
                        <?php echo $select->Country_list($row['owner_country']);?>
                    </div>
                    <div class="form-group">
                    <label>Select Image</label><br />
                    <input type="file" name="owner_image" id="owner_image"  class="image file_upload" data-upload_time="later" accept="<?php echo "image/" . implode(", image/", ALLOWED_IMAGES);?>"/>
                    <br />
                    <span class="text-muted">Only <?php  echo join(' and ', array_filter(array_merge(array(join(', ', array_slice(ALLOWED_IMAGES, 0, -1))), array_slice(ALLOWED_IMAGES, -1)), 'strlen'));?> extensions are supported</span><br />
                   </div>
                    
                </div>
            </div>
        </div>
    </div>
</form>

  </div>
  <?php  endif?>
  </div>

<!-- last two div above belongs to Tabs content -->

                  </div></div></div></div></div></div>
<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<?php include_once ( USER_INCLUDES . 'footer.php') ?>
<script>


$(document).ready(function(){
	$('.setting_form').on('submit', function(event){  
        $form=$(this);         
        $button= $form.find("button[type=submit]");    //$(document.activeElement); 
        $form.parsley();
        event.preventDefault();
        url=$form.attr('action');
        buttonvalue=$button.html();             
		if($form.parsley().isValid())
        {	
			$.ajax({
				url:url,
				method:"POST",
				data:new FormData(this),
                dataType:'json',
                contentType:false,
                processData:false,
				beforeSend:function(){	
                    $button.html('Wait...').attr('disabled', 'disabled');                    
                },
                complete:function(){
                    $button.attr('disabled', false).html(buttonvalue);
                    setTimeout(function(){
				        $('#message').html('');
				    }, 5000); 
                },
                error:function(request){  
                     $form[0].reset();                                   
                     $('#message').html('<div class="alert alert-warning">There was some error updating the configuration at the moment</div>');
                },
				success:function(data){   
                    $('.file_upload').val(''); 
                    $('#message').html(data);
				}
			})
        }        
    });    
  
    $('.tabbutton').on('click', function(event){ 
        event.preventDefault(); 
        var tabpane=$(this).data('id');
        $('.tabbutton').removeClass('active');
        $(this).toggleClass('active');                   
        $('.tab-pane').hide();          
        $('#'+tabpane).show();  
    });
});
</script>     