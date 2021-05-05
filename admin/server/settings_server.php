<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php  
$katha=new publicview();
$errors = array(); 
$response="";
$message=array();	
function WebsiteArray(){
  global $katha;	
	return $katha->getArray('website_data');
}

  if(isset($_POST["website_name"]))
  {
	$placeholder = array('website_name'	,'website_tagline','website_address',
	'user_target','website_email','website_theme','website_timezone');
	$data = array(
			$katha->clean_input($_POST["website_name"]),
			$katha->clean_input($_POST["website_tagline"]),
			$katha->clean_input($_POST["website_address"]),
			$katha->clean_input($_POST["user_target"]),
			$katha->clean_input($_POST["website_email"]),
			$katha->clean_input($_POST["website_theme"]),
			$katha->clean_input($_POST["website_timezone"]),     
	  );
   
	if (isset($_FILES['website_logo']) && $_FILES['website_logo']['error'] === UPLOAD_ERR_OK  )
	{		
		$result=$file->fileUpload($_FILES['website_logo'], LOGO_DIR);
		$imagename=$result[0];
		$errors=$result[1];
		$placeholder[]='website_logo';
		$data[]=$imagename;
	}
	if(count($errors)==0)
	$katha->UpdateDataColumn('website_data ',$placeholder,$data);
	if($katha->row()>0)
		$response= '<div class="alert alert-success">Details Updated Successfully</div>';	
	else{
		array_push($errors,'<div class="alert alert-warning">No new change was made</div>');
		$response=$errors;
	}
    echo json_encode($response);
  }
  if(isset($_POST["owner_name"]))
  {
    $success = '';
  
	$placeholder = array(  'owner_name'	,'owner_contact_no','owner_address',
	'owner_email','owner_postal_code','owner_country');
	$data = array(
			$katha->clean_input($_POST["owner_name"]),
			$katha->clean_input($_POST["owner_contact_no"]),
			$katha->clean_input($_POST["owner_address"]),
			$katha->clean_input($_POST["owner_email"]),
			$katha->clean_input($_POST["owner_postal_code"]),
			$katha->clean_input($_POST["owner_country"]),     
	  );    
	if (isset($_FILES['owner_image']) && $_FILES['owner_image']['error'] === UPLOAD_ERR_OK  )
	{		
		$result=$file->fileUpload($_FILES['owner_image'], LOGO_DIR);
		$imagename=$result[0];
		$errors=$result[1];
		$placeholder[]='owner_image';
		$data[]=$imagename;
	}
	if(count($errors)==0)
	$katha->UpdateDataColumn('website_data ',$placeholder,$data);
    if($katha->row()>0)
		$response= '<div class="alert alert-success">Details Updated Successfully</div>';	
	else{
		array_push($errors,'<div class="alert alert-warning">No new change was made</div>');
		$response=$errors;
	}
    echo json_encode($response);
  }
  if(isset($_POST["login_menu"]))
  {    
	  $login_menu	=	$katha->clean_input($_POST["login_menu"]);
	  $id			=	$katha->clean_input($_POST["user_id"]);  
	$katha->UpdateDataColumn('userlogs ','login',$login_menu,'user_id',$id);
    if($katha->row()>0)
		$response= '<div class="alert alert-success">Details Updated Successfully</div>';	
	else{
		array_push($errors,'<div class="alert alert-warning">No new change was made</div>');
		$response=$errors;
	}
    echo json_encode($response);
  }

  

  ?>