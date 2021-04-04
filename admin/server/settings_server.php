<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');?>
<?php  include_once(ADMIN_CLASS.'katha.php');
$katha=new katha();

$errors = array(); 
$response="";
$message=array();
	
function WebsiteArray(){
  global $katha;	
	return $katha->getArray('website_data');
}

  if(isset($_POST["website_name"]))
  {
    $data = array(
      ':website_name'		=>	$katha->clean_input($_POST["website_name"]),
      ':website_tagline'	=>	$katha->clean_input($_POST["website_tagline"]),
	  ':website_address'	=>	$katha->clean_input($_POST["website_address"]),
	  ':user_target'		=>	$katha->clean_input($_POST["user_target"]),
      ':website_email'		=>	$katha->clean_input($_POST["website_email"]),
      ':website_theme'		=>	$katha->clean_input($_POST["website_theme"]),
      ':website_timezone'	=>	$katha->clean_input($_POST["website_timezone"]),     
	);

    $katha->query = "UPDATE website_data  SET website_name = :website_name, website_tagline = :website_tagline,
      website_address = :website_address,user_target = :user_target, website_email = :website_email, website_theme = :website_theme, website_timezone = :website_timezone ";
	if (isset($_FILES['website_logo']) && $_FILES['website_logo']['error'] === UPLOAD_ERR_OK  )
	{		
		$result=$file->fileUpload($_FILES['website_logo'], LOGO_DIR);
		$imagename=$result[0];
		$errors=$result[1];
		$katha->query .= ", website_logo = :website_logo ";
		$newdata=array(':website_logo'	=>$imagename);
		$data = array_merge($data, $newdata);
	}
	if(count($errors)==0)
    $katha->execute($data);
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
  
    $data = array(
      ':owner_name'			=>	$katha->clean_input($_POST["owner_name"]),
      ':owner_contact_no'	=>	$katha->clean_input($_POST["owner_contact_no"]),
      ':owner_address'		=>	$katha->clean_input($_POST["owner_address"]),
      ':owner_email'		=>	$katha->clean_input($_POST["owner_email"]),
      ':owner_postal_code'	=>	$katha->clean_input($_POST["owner_postal_code"]),
      ':owner_country'		=>	$katha->clean_input($_POST["owner_country"]),     
    );

    $katha->query = "UPDATE website_data  SET owner_name = :owner_name, owner_email = :owner_email,  owner_address = :owner_address, 
	owner_contact_no = :owner_contact_no, owner_postal_code = :owner_postal_code, owner_country = :owner_country  ";
	if (isset($_FILES['owner_image']) && $_FILES['owner_image']['error'] === UPLOAD_ERR_OK  )
	{		
		$result=$file->fileUpload($_FILES['owner_image'], LOGO_DIR);
		$imagename=$result[0];
		$errors=$result[1];
		$katha->query .= ", owner_image = :owner_image ";
		$newdata=array(':owner_image'	=>$imagename);
		$data = array_merge($data, $newdata);
	}
	if(count($errors)==0)
    $katha->execute($data);
    $data = array();
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
    $data = array(
	  ':login_menu'	=>	$katha->clean_input($_POST["login_menu"]),
	  ':id'			=>	$katha->clean_input($_POST["user_id"]),             
    );

    $katha->query = "UPDATE users  SET login = :login_menu  WHERE id=:id";
	
	if(count($errors)==0)
    $katha->execute($data);
    $data = array();
    if($katha->row()>0)
		$response= '<div class="alert alert-success">Details Updated Successfully</div>';	
	else{
		array_push($errors,'<div class="alert alert-warning">No new change was made</div>');
		$response=$errors;
	}
    echo json_encode($response);
  }

  

  ?>