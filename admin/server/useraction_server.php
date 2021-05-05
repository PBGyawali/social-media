<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$katha = new publicview();
// initializing variables
$username = "";
$email    = "";
$first_name="";
$last_name="";
$id = 0;
$remarks="";
$update = false;
$user_status = "Unauthenticated";
$status="";
$response="";
$user_type="user";
$row="";
$errors = array();
$user_id=(isset($_SESSION['id']))?$_SESSION['id']:'';


if (isset($_POST['reset'])) {
	$ID= $katha->clean_input($_POST['sel_record']);
	$row=$katha->getArray('users','id',$ID);
    $email=$row['email'];
    $username=$row['username'];
    $first_name=$row['first_name'];
    $last_name=$row['last_name'];
	$full_name=$first_name ." ". $last_name;
	$website_name=$katha->WebsiteName();
    if (empty($full_name)) 
        $receiver= $username;      
    else 
     $receiver=$full_name;
  	$token = bin2hex(random_bytes(50));    
    $katha->insert('verify_table',array('email','token'), array($email, $token));
    $to = $email;
    $subject = "Your password reset link for " . $website_name;
    $msg = "Hi"." ". $receiver.",". " click on this <a href=".BASE_URL."new_password.php?token=" . $token . "\">link</a> to reset your password on our site.Please note that this password reset link will expire in 30 minutes.";
    $msg = wordwrap($msg,70);    
    $headers = "From:". $website_name ." Admin";
    mail($to, $subject, $msg, $headers);   
	$response='<div class="alert alert-info">The password reset email has been sent to '.$email.'</div>';
	$katha->response($response);
  }
	
	
if (isset($_POST['update_user']))
 {
		$id=$katha->clean_input($_POST['id']); 
		$username = $katha->clean_input($_POST['username']);
		$email = $katha->clean_input($_POST['email']);
		$first_name = $katha->clean_input($_POST['first_name']);
		$last_name = $katha->clean_input($_POST['last_name']);
		$user_type = $katha->clean_input($_POST['user_type']);
		$row="";
		$result= $katha->UpdateDataColumn('users',array('username','email', 'first_name', 'last_name','user_type'),
		array($username,$email,$first_name,$last_name,$user_type),'id',$id);
		if ($result)
		{
				$status="success";
				$response='<div class="alert alert-success">The user Profile was successfully updated!</div>';
				$row='<tr id="userlist_'.$id.'">
				<td class="s_no">1</td>
				<td class="id">'.$id.'</td>
				<td class="profile_image"><img src="'.USER_IMAGES_URL.rawurlencode($katha->Get_profile_image($id)).'" class="img-fluid img-thumbnail" width="100" height="100" />'.'</td>
					<td class="username">'.$username.'</td>
					<td class="email">'.$email.'</td>
					<td class="full_name">'. ucwords(implode(' ',(array("<span class='first_name'>".$first_name."</span>","<span class='last_name'>".$last_name."</span>")))).'</td>
					<td class="user_type">'.$user_type.'</td>
					<td class="status">'. GetUserStatusById($id).'</td>					
					<td class="action">
					<div class="text-center">
					<button type="button"  class="btn btn-primary btn-sm view_button" data-id="'.$id.'"><i class="fas fa-eye"></i></button>
					&nbsp;
					<button type="button"  class="btn btn-danger btn-sm delete_button" data-id="'.$id.'"><i class="fas fa-times"></i></button>
					&nbsp;					
					<button type="button" class="btn btn-secondary btn-sm edit_button" data-id="'.$id.'"><i class="fas fa-edit"></i></button>					
					&nbsp;
					<button type="button"  class="btn btn-success btn-sm reset_button" data-id="'.$id.'"><i class="fas fa-sync"></i></button>
					&nbsp;
					<button type="button"m class="btn btn-warning btn-sm fas fa-ban disable_button" data-id="'.$id.'"></button>
					</div>		
				</td>';
		}
	else{
			$status="error";
			$response='<div class="alert alert-danger">The user profile could not be updated due to some error</div>';
		}
		$katha->response($response,$status,$row);
}

if (isset($_POST['fetch_detail'])) {
	$katha->response($katha->UsersArray($katha->clean_input($_POST['id'])),'',USER_IMAGES_URL);
}

function arraypush($message){
	global $errors;
   return array_push($errors, $message);
}


if (isset($_POST['update_status'])) 
{   $value=$column=array();
	$id=$katha->clean_input($_POST['id']); 
	if(isset($_POST['user_status']) && !empty($_POST['user_status']))
	{
		$user_status=$katha->clean_input($_POST['user_status']); 
		$column[]='user_status';
		$value[]=$user_status;
	}	
	if (isset($_POST['user_status']) && !empty($_POST['user_status'])&& isset($_POST['remarks']) && !empty($_POST['remarks']))
	{
		$remarks=$katha->clean_input($_POST['remarks'],'e'); 
		$column[]='remarks';
		$value[]=$remarks;
	}
	elseif ((!isset($_POST['user_status'])&& isset($_POST['remarks'])) || (isset($_POST['user_status']) && empty($_POST['user_status'])&& isset($_POST['remarks'])))
	{
		$remarks=$katha->clean_input($_POST['remarks'],'e'); 
		$column[]='remarks';
		$value[]=$remarks;
	}
	$result = $katha->UpdateDataColumn('userlogs',$column,$value,'user_id',$id);
	if ($result){
		$status="success";
		$response='<div class="alert alert-success">The profile status was successfully '.$user_status.'d</div>';
	}
	else{
		$status="error";
		$response='<div class="alert alert-danger">The profile status could not be changed </div>';
	}
	$katha->response($response,$status);	
}


if (isset($_POST['verify'])) 
{   
	$id=$katha->clean_input($_POST['id']); 
	$value=$katha->clean_input($_POST['verify_type']);
	$result = $katha->UpdateDataColumn('userlogs','verified',$value,'user_id',$id);
	if ($result)
		$response='<div class="alert alert-success">The profile verification status has been updated</div>';
	else
		$response='<div class="alert alert-warning">The profile verification status has not been changed</div>';
	$katha->response($response);	
}

Function GetUserLogById($id){
	global $katha;
	return $katha->getArray('userlogs','user_id',$id);
}

Function GetUserDetailById($id){
	global $katha;
	return $katha->getArray('users','id',$id);    
}



if (isset($_POST['delete'])) {
	$id=$katha->clean_input($_POST['id']);
	$user_type=$katha->clean_input($_POST['user_type']);
	$username=$katha->clean_input($_POST['username']);
	$profile_image=$katha->clean_input($_POST['profile_image']);
	$status="danger";
	if (empty($user_id))
		$message= "You must log in to perform this action";
	else if($user_id==$id) 
		$message="You cannot delete yourself";
	else if($user_type=='owner') 	
		$message="You cannot delete ".$user_type. " of this website";
	else if(in_array($username,array('Puskar','Prakhar')))
		$message="Do not try to be mischievous or you will be logged out.";
	else if(in_array($id,array('1','2'))) 
		$message="This user account is not allowed to be deleted.";
	else{
		$result = $katha->Delete('users','id',$id);	
		if ($result){
			$katha->imageDelete(USER_IMAGES_DIR.$profile_image);
			$status="success";
			$message="The user account was successfully deleted";
		}
		else
			$message="The user account could not be deleted";
	}
	$response='<div class="alert alert-'.$status.'">'.$message.'</div>';
	$katha->response($response,$status);	
}


function GetUserStatusById($id){
	global $katha;
	return $katha->get_data('user_status','userlogs','user_id',$id);    	
}

// REGISTER USER
if (isset($_POST['reg_admin'])) 
{
	// receive all input values from the form
	$username = $katha->clean_input( $_POST['username']);
	$email = $katha->clean_input( $_POST['email']);
	$password = $katha->clean_input( $_POST['password']);
	$first_name = $katha->clean_input($_POST['first_name']);
	$last_name = $katha->clean_input($_POST['last_name']);	
	if (empty($user_id)) { array_push($errors, "You must log in to perform this action");  }
    else
    {
		if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {array_push($errors, "Invalid email address");  }
		if (isset($_POST['user_type']))	{$user_type=$katha->clean_input( $_POST['user_type']);} 
		// form validation: ensure that the form is correctly filled ...
		// by adding (array_push()) corresponding error unto $errors array
		if ($check->is_empty(array("Username"=>$username,"Email"=>$email,"Password"=>$password))) {
			$status="error";
			$response=$errors;}		
	}
	if (count($errors) == 0)
	{
			// first check for duplicate username and/or email
			$user=$katha->get_data(array('username','email'),'users',array('username','email'),array($username,$email),'OR');			
					if ($user) 
					{ // if user exists
							if ($user['username'] === $username) {
								arraypush("The selected Username already exists. Please try another");
								$status="error";
								$response=$errors;
							}						
							if ($user['email'] === $email) {
								arraypush("The requested Email address already exists");
								$status="error";
								$response=$errors;
							}
					}
					else
					{
							$password=password_hash($password, PASSWORD_DEFAULT);//hash the password before saving in the database	
							$profile_image= $katha->make_avatar(strtoupper($username[0]));//make avatar image as default image
							$result= $katha->insert('users',array('username', 'email','user_type', 'password','profile_image'),
                                array($username, $email,$user_type, $password,$profile_image));	
								if ($result)
								{
									$inserted_id=$katha->id();
									if ($inserted_id) 
                                            {
												$newresult= $katha->insert('userlogs','user_id',$inserted_id);
														if ($newresult)
														{
															$token = bin2hex(random_bytes(50));          
															// store token in the password-reset database table against the user's email
															$katha->insert('verify_table',array('user_id','email','token','token_type'),
															array($inserted_id,$email,$token,'account_verify'));																				
															$katha->activitylogs($inserted_id, 'An admin registered your ','register','profile');
															$to = $email;
															$subject = "Verify your account on ".SITE_NAME;																		
															$msg = 'Hi '.$username.' please click on this <a href="'.BASE_URL.'verify_account.php?email='.$email.'&verify=' . $token . '"> link</a> to verify your account on our site.';
															$msg = wordwrap($msg,70);
															$headers = "From:info\@\"".str_replace(' ', '', SITE_NAME).".com";                      
															mail($to, $subject, $msg, $headers);
															$response = "New user with " .$user_type. " privilege was successfully created!!";
															$status="success";																
															$row='<tr id="userlist_'.$inserted_id.'">
															<td class="s_no">1</td>
															<td class="id">'.$inserted_id.'</td>
															<td class="profile_image"><img src="'.USER_IMAGES_URL.rawurlencode($profile_image).'" class="img-fluid img-thumbnail" width="100" height="100" />'.'</td>
																<td class="username">'.$username.'</td>
																<td class="email">'.$email.'</td>
																<td class="full_name">'. ucwords(implode(' ',(array("<span class='first_name'>".$first_name."</span>","<span class='last_name'>".$last_name."</span>")))).'</td>
																<td class="user_type">'.$user_type.'</td>
																<td class="status">'. $user_status.'</td>																
																<td class="action">
																<div align="center">
																<button type="button" name="view_button" class="btn btn-primary btn-sm view_button" data-id="'.$inserted_id.'"><i class="fas fa-eye"></i></button>
																&nbsp;
																<button type="button" name="delete_button" class="btn btn-danger btn-sm delete_button" data-id="'.$inserted_id.'"><i class="fas fa-times"></i></button>
																&nbsp;																
																<button type="button" name="edit_button" class="btn btn-secondary btn-sm edit_button" data-id="'.$inserted_id.'"><i class="fas fa-edit"></i></button>																
																&nbsp;
																<button type="button" name="reset_button" class="btn btn-success btn-sm reset_button" data-id="'.$inserted_id.'"><i class="fas fa-sync"></i></button>
																&nbsp;
																<button type="button" name="disable_button" class="btn btn-warning btn-sm fas fa-ban disable_button" data-id="'.$inserted_id.'"></button>
																</div>		
															</td>';																	
														}
														else
														{
															$response = arraypush( "New user creation could not be completed");				
															$status="error";	
														}
											}
											else
											{	$status="error";
												arraypush( "Our database is facing some error. Please try again later.");		
											}
								}
								else
								{
									$response =	arraypush("The New user registration could not be started");		
									$status="error";	
								}
					}			
	 }	
	$katha->response($response,$status,$row);	
}
?>