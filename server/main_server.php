<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_CLASS.'publicview.php');
 $katha=new publicview(); 
// initializing variables
$username = "";
$email    = ""; 
$sex="not mentioned";
$user_type='user';
$old_password="";
$new_password="";
$confirm_password="";
$errors = array(); 
$_SESSION['message']='';
$profile_image="";
$message='';
$user_id=(isset($_SESSION['id']))?$_SESSION['id']:'';
$response='';

// UPDATE USER PASSWORD
if (isset($_POST['update_password'])) 
{  
  $old_password = $katha->clean_input($_POST['old_password']);
  $new_password = $katha->clean_input($_POST['changed_password']);
  $confirm_password = $katha->clean_input($_POST['confirm_password']); 
  $changer_id = $katha->clean_input($_POST['changer_id']); 
  // form validation: ensure that the form is correctly filled ... 
        if (empty($user_id))  arraypush("You must log in to perform this action");  
        elseif($user_id!=$changer_id)arraypush("This profile does not belong to logged in user");
        else
        { $empty=$check->is_empty(array('Current password'=>$old_password,'New password'=>$new_password,'Confirm password'=>$confirm_password));
          if ($empty)$errors[]=$empty;         
          else if (isset($new_password) && $new_password != $confirm_password) arraypush("The two new passwords do not match");
          else if (isset($old_password) && !empty($old_password) AND $old_password == $confirm_password) arraypush("You cannot keep your new password same as your old password ");
          else $check->validate_password($confirm_password);
        }  
  // Finally, register user if there are no errors in the form
  if (count($errors) == 0) 
  {   
      $saved_password= $katha-> get_data('password','users','id',$user_id,'',1);           
      if ($saved_password)
      {
              $password=md5($old_password);
              if ($check->verifypassword($password,$old_password,$saved_password))
              {
                  $confirmedpassword=password_hash($new_password, PASSWORD_DEFAULT); 
                  $result=updatePassword($confirmedpassword,'id',$user_id);                      
                    if ($result)  
                    {        
                        $katha->UpdateDataColumn('userlogs','last_password_change',$katha->get_datetime(),'user_id',$user_id); 
                        //$_SESSION["loggedin"] = false;
                        $response="Your password has been successfully updated. Please re-login. ";
                        //session_destroy();                              
                    }
                    else                          
                    arraypush("There was some error in updating your password");
            }
            else                                   
            arraypush("The current password does not match the server data");
      }
  } 
  $finalresponse = array('success' => $response, 'error' => $errors, );
  echo json_encode($finalresponse);
}

    if (isset($_POST['check'])) {  
    echo json_encode(checkdata($_POST['data'],$_POST['column'])); 
    exit();  
      }

Function checkdata($data,$placeholder){
  global $katha;
  $num_rows = $katha->CountTable('users',$placeholder,$data);  
  if($num_rows > 0)    
      return 'exists';	    
    else    
      return 'available';    
}

// REGISTER USER
if (isset($_POST['reg_user'])) 
{
  $username = $katha->clean_input($_POST['register_username']);
  $email = $katha->clean_input($_POST['register_email']);
  $confirmemail = $katha->clean_input($_POST['register_confirmemail']);
  $password_1 = $katha->clean_input($_POST['register_password_1']);
  $password_2 = $katha->clean_input($_POST['register_password_2']);
  $website_name = $katha->clean_input($_POST['website_name']);
  

  $empty=$check->is_empty(array('Username'=>$username,'Email'=>$email,'Password'=>$password_1));
  if ($empty)$errors=$empty;
  if (isset($email) && $email != $confirmemail) 	arraypush("The two emails do not match");
  if (isset($password_1) && $password_1 != $password_2) 	arraypush("The two passwords do not match");
  if (!filter_var($email, FILTER_VALIDATE_EMAIL))  arraypush("Invalid email address"); 
  if (count($errors) == 0) 
    {   // first check the database to make sure   a user does not already exist with the same username and/or email
        $user=$katha->get_data(array('username','email') ,'users',array('username','email'),array($username,$email),'OR',1) ;
        if ($user){	           
                  if ($user['username'] === $username)                   
                  arraypush("The selected Username already exists. Please try another");                  
                  if ($user['email'] === $email)                   
                  arraypush("The requested Email address already exists");                                    
              }
              else
              {   // Finally, register user if there are no errors in the form                        		
                             $password=password_hash($password_1, PASSWORD_DEFAULT);//encrypt the password before saving in the database
                              $profile_image= $katha->make_avatar(strtoupper($username[0]));
                                $result= $katha->insert('users',array('username', 'email', 'password','profile_image'),
                                array($username, $email, $password,$profile_image));
                                if ($result){
                                              $inserted_id= $katha->id();
                                              if ($inserted_id) 
                                                {  $newresult= $katha->insert('userlogs','user_id',$inserted_id);
                                                        if ($newresult){
                                                                      $token = bin2hex(random_bytes(50));          
                                                                      // store token in the password-reset database table against the user's email
                                                                      $katha->insert('verify_table',array('user_id','email','token','token_type'),array($inserted_id,$email,$token,'account_verify'));                                                                            
                                                                      $katha->activitylogs($inserted_id, 'You registered your ','register','profile');
                                                                      $to = $email;
                                                                      $subject = "Verify your account on ".$website_name;                                                                                  
                                                                      $msg = 'Hi there, please click on this <a href="'.BASE_URL.'verify_account.php?email='.$email.'&verify=' . $token . '"> link</a> to verify your account on our site.';
                                                                      $msg = wordwrap($msg,70);
                                                                      $headers = "From:info\@\"".str_replace(' ', '', $website_name).".com";                      
                                                                      mail($to, $subject, $msg, $headers);
                                                                      $_SESSION['username'] = $username;     
                                                                      $_SESSION['email'] = $email;
                                                                      $_SESSION['message']  = "The new user registration was successfull !!";
                                                                      header("location:confirmation/account registration confirmation.php"); 
                                                                    }                                     
                                                        else{
                                                                arraypush("New user creation process could not be completed");
                                                                $katha->imageDelete(USER_IMAGES_DIR.$profile_image);	
                                                            }
                                                }
                                                else{
                                                    arraypush("Our database is facing some error. Please try again later.");
                                                    $katha->imageDelete(USER_IMAGES_DIR.$profile_image);			
                                                }                          
                                          }
                                  else{
                                        arraypush("The New user registration could not be started");	
                                        $katha->imageDelete(USER_IMAGES_DIR.$profile_image);	
                                      }                          
      }      }
}


	
// Update user profile
if (isset($_POST['update_user'])) 
{  
  $username = $katha->clean_input($_POST['username']);
  $email = $katha->clean_input($_POST['email']);
  $first_name = $katha->clean_input($_POST['first_name']);
  $last_name = $katha->clean_input($_POST['last_name']);
  $sex = $katha->clean_input($_POST['sex']);  
  $facebook_data = $katha->clean_input($_POST['facebook_data'],'e');
  $twitter_data = $katha->clean_input($_POST['twitter_data'],'e');
  $googleplus_data = $katha->clean_input($_POST['googleplus_data'],'e'); 
  $id = $katha->clean_input($_POST['user_id']); 
  if (empty($user_id))    arraypush("You must log in to perform this action");
  elseif($user_id!=$id)   arraypush("The profile does not belong to the logged in user");
  else{
    $empty=$check->is_empty(array('Username'=>$username,'Email'=>$email));
    if ($empty)$errors=$empty;
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {arraypush("Invalid email address"); }
  }
  if (count($errors) == 0) 
    {  
          // first check the database to make sure  a user does not already exist with the same username and/or email
          //$katha->query="SELECT username,email FROM users WHERE (username=? OR email=?) AND id!= ? LIMIT 1" ;
          $row = $katha->get_data(
                                  array('username','email'),'users',
                                  array('(username','email', 'id!'),
                                  array($username,$email,$id),
                                  array(' OR ',') AND',''),'1');
          //$katha->execute(array($username,$email,$id));
          //$row = $katha->get_array();
          //$katha->close();
          if ($row){ // if email exists
                if ($email == $row['email']) 
                arraypush("The requested Email address already exists");

                if ($username == $row['username']) 
                arraypush("The selected Username already exists. Please try another.");                
          }
          else{
                  $update= $katha->UpdateDataColumn('users',array('email', 'first_name', 'last_name' , 'sex' ,
                  'facebook', 'twitter', 'googleplus' ),array($email,$first_name,$last_name,$sex,
                  $facebook_data,$twitter_data, $googleplus_data),'id',$user_id);
                  if ($update)
                  {                      
                      if($katha->row()>0){  
                        $response = "Your Profile has been updated!";
                        $katha->setSession(array("email",'username'),array($email,$username) );
                        $katha->activitylogs($id, 'You updated your ','update','profile');
                      }
                      else
                      $response = "No new changes were made";
                  }
              }
    }
    $finalresponse = array('success'=> $response,'error' => $errors);
    echo json_encode($finalresponse); 
}

// LOGIN USER AS A GUEST
if (isset($_POST['login_guest'])) {
   session_start();
   $website_logo = $katha->clean_input($_POST['website_logo']);
  $website_name = $katha->clean_input($_POST['website_name']);
   $katha->setSession(array('website_name','website_logo'),array($website_name,$website_logo));
   // Store data in session variable
   $katha->setSession(array("loggedin",'user_type'),array("true",'guest') );
    location();
}


  // LOGIN USER
  if (isset($_POST['login_user'])) 
  {
      $username = $katha->clean_input($_POST['login_username']);
      $password = $katha->clean_input($_POST['login_password']);
      $website_logo = $katha->clean_input($_POST['website_logo']);
      $website_name = $katha->clean_input($_POST['website_name']);
      $empty=$check->is_empty(array('Username'=>$username,'Password'=>$password)); 
      if ($empty)$errors=$empty;        
      if (count($errors) == 0) 
      {                                  
          $row = $katha->UsersArray(array($username,$username),array('username','email'),'OR');
          if($row)              
          {                         
              $oldpassword = md5($password); 
              if ($check->verifypassword($oldpassword,$password,$row['password']))
              { 
                  $error=checkstatus($row['user_status']);
                  $difference=$row['login_status']- ATTEMPTS_NUMBER;
                  if(!empty($error))
                      arraypush($error);
                  elseif ($difference>0){   
                          $timedifference=(time()- strtotime(($row['last_login_attempt'])))/60;
                          $attempts=array('2','5','10','15');                                               
                          $difference_array=array('3','5','10','15');
                          if ($difference<=end($attempts)){
                              foreach($attempts as $key=> $attempt){  
                                  if($difference<=$attempts[$key]){ 
                                      if($timedifference<=$difference_array[$key]){                                                                                                                    
                                        arraypush("Please login after " .$difference_array[$key]." minutes");	
                                        break;
                                      }                                                                                                                                                         
                                      else
                                        login($row);
                                        break;									
                                  }  
                              }
                          }
                          else                                            
                            arraypush("You have reached your maximum login attempt.Please login later or contact admin");                                              
                      } 
                    else{     
                            if ($row['hash_method']==1){   
                                  $securedpassword=password_hash($password, PASSWORD_DEFAULT);                                  
                                  $updatedhashedpassword=updatePassword($securedpassword,'id',$row['id'],false);
                                  if ($updatedhashedpassword)
                                      updateStatus($row['id'],'hash_method','hash_method+1');                                                                                                                                     
                              }
                              login($row);                      
                        }
                }
              else{
                $user_id=$row['id'];
                if (!empty($user_id)){ 
                  arraypush("Wrong password Entered");
                  $attr['compare']=array('+','=');
                  updateStatus($user_id,array('login_status=login_status','last_login_attempt'),array('1',$katha->get_datetime())); 
                }                                  
              }
          }
          else  
              arraypush("The given username or email does not exist in our system");  
      }
 }

 function checkstatus($user_status){
  $message="";
  if  ($user_status== 'Unauthenticated')  
    $message= "Your account is not verified yet.Please verify through the email link sent to you";  
  elseif  ($user_status== 'Disable')  
    $message= "Sorry your account has been disabled. Please contact Admin or support";
  return $message;
 }

 function arraypush($message){
   global $errors;
  array_push($errors, $message);
 }

 function updatePassword($password,$condition,$value,$log=true){
  global $katha;
  $result=$katha->UpdateDataColumn('users','password',$password,$condition,$value);
  if ($result){
    if($log==true)
    $katha->activitylogs($value, 'You updated your ','update','password',$value);
    return $result;
  }
    return null;
}
function updateStatus($id,$condition,$value,$attr=array()){
  global $katha;  
  return $katha-> UpdateDataColumn('userlogs',$condition,$value,'user_id',$id,'AND',$attr); 
}

function loginstatus($row){
  global $katha;
  $id=$row['id']; 
  return updateStatus($id,array('login_status','last_login_attempt'),array(0,$katha->get_datetime()));
}

function login($row){
   global $katha,$katha,$katha, $website_logo,$website_name;
  $id=$row['id'];
  $user_type=$row['user_type'];
  $email= $row['email'];
  // Store data in session variables
  if (!empty($row['username'])) 
  $username= $row['username']; 
  else  
  $username = $email; 
  $profile_image=$katha->image_check($row['profile_image'],USER_IMAGES_DIR);
  $katha->setSession( array("loggedin","email","id",'user_type','username'),array("true",$email,$id,$user_type,$username) );
  $katha->setSession(array('profile_image','website_name','website_logo'),array($profile_image,$website_name,$website_logo));
  $katha->activitylogs($id, 'You logged into your ','login','profile');
  location($row['user_type'],$row['login']);
  updateStatus($id,array('login_status','last_login_attempt','user_status'),array(0,$katha->get_datetime(),'Enabled'));
}



function getuserid($username){
  global $katha;
  return $katha->get_data('id','users',array('username','email'),array($username,$username),'OR',1);
}

function location($user_type=null,$login=null)
{  
        switch ($login) 
        {
              case 'home': 
              header('location: home.php'); 
              break;  
              case 'dashboard':
                    switch ($user_type) 
                    {
                          case 'user': 
                              header('location:dashboard.php');
                            break;  
                            case 'admin':
                            case 'editor':
                            case 'owner':                                    
                            header('location: admin/');                          
                            break;
                      }      
                break;
                default:
              header('location: welcome.php');
              break;            
       }
}

  /*
  Accept email of user whose password is to be reset
  Send email to user to reset their password
*/
if (isset($_POST['reset-password'])){
  $email = $katha->clean_input($_POST['reset_email']);
  $website_name = $katha->clean_input($_POST['website_name']);
  // ensure that the user exists on our system
  $empty=$check->is_empty(array('email'=>$email));
    if ($empty)$errors=$empty; 
    if (count($errors) == 0) 
    {         
          $result =$katha->get_data('id','users','email',$email,'',1);
            if(!$result)
                arraypush("Sorry, no user exists on our system with that email");
            else{
                $id=$result['id'];                
                $result = $katha->get_data('user_status','userlogs','user_id',$id,'',1);
                $status=$result['user_status'];
                if(in_array($status,array('Disabled','Locked','Unauthenticated')))                
                  arraypush("Sorry, your account is still " .$status. ".  The password cannot be reset. ");                
                else  
                    {
                        // generate a unique random token of length 100
                        $token = bin2hex(random_bytes(50));          
                        // store token in the password-reset database table against the user's email
                        $katha->insert('verify_table',array('user_id','email','token'),array($id,$email,$token)); 
                        // Send email to user with the token in a link they can click on
                        $to = $email;
                        $subject = "Reset your password on ".$website_name;                                    
                        $msg = 'Hi there, please click on this <a href="'.BASE_URL.'new_password.php?token='. $token . '"> link</a> to reset your password on our site. Please note that this password reset link will expire in 30 minutes.';
                        $msg = wordwrap($msg,70);
                        $headers = "From:info\@\"".str_replace(' ', '', $website_name).".com";                      
                        mail($to, $subject, $msg, $headers); 
                        header('location:' .BASE_URL.'confirmation/pending.php?email=' . $email);
                    }
            }
    }     
}

// ENTER A NEW PASSWORD
if (isset($_POST['new_password'])) {
  $new_pass = $katha->clean_input($_POST['new_pass']);
  $new_pass_c = $katha->clean_input($_POST['new_pass_c']); 
  $check->is_empty(array("Password"=>$new_pass,"Confirm Password"=>$new_pass_c)); 
  if (isset($new_pass) && $new_pass != $new_pass_c) arraypush("Password do not match");
  if (count($errors) == 0) 
  {
        // Grab to token that came from the email link        
        $token= (isset($_SESSION['token']))?$_SESSION['token']:'';        
        // select email address of user from the password_reset table
        $row =$katha->getArray('verify_table',array('token','token_type'),array($token,'password_reset'),'AND',1);
        $katha->close();
        if ($row){     
              $email=$row['email'];             
              if($email)
              {   
                $token_created=strtotime($row['token_created']);
                $user_id=$row['user_id'];
                $time = time(); 
                $time_difference=$time-$token_created;
                if  ($time_difference>=1800){
                  arraypush("The password reset link has expired. Please make your request again");                    
                  $katha->Delete('verify_table',array('email','token_type'),array($email,'password_reset')); 
                }
                else
                {
                  $new_pass = password_hash($new_pass, PASSWORD_DEFAULT);
                  $result=updatePassword($new_pass,'email',$email);
                      if($result>0){ 
                        $_SESSION['success']="Your password has been reset to your given Password";
                        $katha->Delete('verify_table',array('email','token_type'),array($email,'password_reset'));
                        $katha->activitylogs($user_id, 'You performed reset of your ','reset','password'); 
                        $katha->insert('alerts',array('user_id','alert','type'),array($user_id,'Your password was successfully updated.','update'));      
                      }
                      else                                         
                          arraypush("There was some error updating the password");                          
                } 
              } 
              else                             
                arraypush("Your email does not exist in our system");              
        }
        else        
          arraypush( "The reset link is invalid or has expired ");        
  }
}




if (isset($_GET['verify'])){
      if(isset($_GET['email']) && !empty($_GET['email']) AND isset($_GET['verify']) && !empty($_GET['verify'])){
        // Verify data
        $sender_email = $katha->clean_input($_GET['email']); // Set email variable
        $token = $katha->clean_input($_GET['verify']); // Set hash variable
            // Grab to token that came from the email link         
            // select email address of user from the verify_table table 
            $row =$katha->getArray('verify_table',array('token','token_type'),array($token,'account_verify'),'AND',1);
            $katha->close();
            if ($row){     
                  $email = $row['email'];
                  $id=getuserid($email);             
                  if($email==$sender_email)
                  {                                      
                    $result=updateStatus($id,'user_status','Enabled');
                      if  ($result){
                            $result=$katha->row();                             
                                  if($result){ 
                                    $_SESSION['message']="Your email has been verified";
                                    $katha->activitylogs($id, 'You verified your  ','verify','profile');
                                    $katha->insert('alerts',array('user_id','alert','type'),array($id,'Your profile was successfully verified.','verify'));
                                    $katha->Delete('password_reset',array('email','token_type'),array($email,'account_verify'));
                                  }
                                  else                
                                      arraypush("Your email has already been verified");                                  
                      } 
                      else                
                            arraypush("There was an error in email verification");                          
                  } 
                  else                                 
                    arraypush("We could not find your account. Please check if the link is correct.");                  
            }
            else            
              arraypush("Your account ".$sender_email." does not exist in our system");            
        }
        else         
          arraypush("The verification link is invalid or incomplete."); 
}
  ?>