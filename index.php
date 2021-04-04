<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_CLASS.'publicview.php');
$katha=new publicview(); 
if($check->is_admin())$method->redirect(ADMIN_URL);
elseif ($check->is_user())$method->redirect(BASE_URL.'home');
else
{
  $company=$katha->get_data(array('website_logo','website_name'),'website_data');;
  $website_name=$company['website_name'];
  $website_logo=$company['website_logo'];
 include_once(USER_SERVER.'main_server.php');
 include_once(USER_INCLUDES.'login_head_section.php') ;}
?>
<title><?= $website_name; ?></title>
</head>	
<div class="bigtext">
Welcome to "<?= $website_name; ?>"
</div>
<div class="image" >
  <img src="<?php echo LOGO_URL.$website_logo; ?>"class="image">
</div>
<?php include_once(USER_INCLUDES.'new_message.php');?>
<div class="container" id="homepage_container">
  <div class="header">
  	<h2>Please Log in or sign up</h2>
  </div>
	<!-- notification message -->
  <?php $messages=displaymessage();?>
  
  
  <form method="post" action="">  
<div class=links>
<a href="login" class="login_link"><span></span><span></span><span></span><span></span>Log in</a>
 <a href="register"class="register_link"><span></span><span></span><span></span><span></span>Signup for free</a>
  </form>
  </div>
  </div>

  <div class="container"id="login_container">
    <div class="header">  	
      <h2>LOGIN</h2>
  </div>
  <?php repeatmessage();?>
  <form method="post" class="user_form" action="<?php echo htmlspecialchars(BASE_URL);?>#login" autocomplete="on">
  <div class="social">
        <h4>Connect with</h4>
        <ul>
          <li> 
          <a href="" class="facebook"><span class="fab fa-facebook"></span></a>
          </li>
          <li>
          <a href="" class="twitter"><span class="fab fa-twitter"></span></a>
          </li>
          <li>
            <a href="" class="google-plus"><span class="fab fa-google-plus"></span></a>
          </li>
        </ul>        
       </div>
    
    <div class="divider">   
         <span>or</span>  
      
       </div>
  	<div class="form-input-group">
  		<label>Username/Email</label>
      <i class="fa fa-user fa-md position-absolute loginicon"></i>
  		<input type="text" name="login_username" id="login_username"class="form-control" required placeholder="Your Username or Email" >
    </div>
    
  	<div class="form-input-group">
      <label>Password</label>
      <i class="fa fa-lock fa-md position-absolute loginicon"></i>
  		<input type="password" name="login_password" id="login_password" class="form-control" required placeholder="Your Password" >
      <i class="fa fa-fw fa-eye field-icon toggle-password" ></i>
      </div>  <br>   
      Forgot Your Password?<a class="reset_password_link" href="reset password.php"> RESET HERE. </a> Not a Member Yet?<a class="register_link"href="register.php"> SIGN UP HERE</a>
  	<div class="form-input-group">
          <input type="hidden" name="website_name" value="<?= $website_name; ?>" >
          <input type="hidden" name="website_logo" value="<?= $website_logo; ?>" >
          <button type="submit" class="btn btn-primary" name="login_user">Login</button>          
          <button type="submit" class="btn btn-secondary" name="login_guest" id="login_guest">Login as a guest</button>
          <button type="button" class="btn btn-success"  id="hint">Show login hint</button>
              </div>    
  </form>
  </div>
  
  
<div class="container" id="register_container">
  <div class="header">
  	<h2>Register</h2>
  </div>
  <?php repeatmessage();?>
    <div id="error_msg"></div> 
  <form name="myForm" class="user_form" id="register_form" method="post" action="<?php echo htmlspecialchars(BASE_URL);?>#register" >
     
  <div class="form-input-group"> 
    <label>Username</label><span class="text-right position-relative"> </span>
    		
  	  <input type="text" name="register_username" id="register_username" class="form-control datacheck" data-object="Username" value="" required data-parsley-minlength="5" data-parsley-trigger="on change">
  	</div>
  	<div class="form-input-group">
  	  <label>Email</label> <span></span>
  	  <input type="email" name="register_email" id="register_email" class="form-control datacheck" data-object="Email" value="" required data-parsley-type="email" data-parsley-trigger="on change">
	  </div>
	  <div class="form-input-group">
		<label>Confirm Email</label>
		<span></span>
  	  <input type="email" name="register_confirmemail"id="register_confirmemail" class="form-control" value=""required data-parsley-equalto="#register_email" data-parsley-trigger="on change">
  	</div>
  	<div class="form-input-group">
    <label>Password</label>
    <span id="strength_message"></span>	
  	  <input type="password" name="register_password_1" id="register_password_1" class="form-control" required data-parsley-minlength="5">
  	</div>
  	<div class="form-input-group">
		<label>Confirm password</label>
		<span></span>
  	  <input type="password" name="register_password_2"id="register_password_2" class="form-control"  required data-parsley-minlength="5" data-parsley-equalto="#register_password_1"data-parsley-trigger="on change">
      </div> 
      <div>
        <br><br>   
      <p>
      By clicking on Register you automatically agree to our <a class="conditions_link formlink"href="conditions.php">TERMS & CONDITIONS</a>
</p>
  	</div>
  	<div class="form-input-group">
    <input type="hidden" name="website_name" value="<?= $website_name; ?>" >
		<button type="submit" class="btn btn-primary" id= "reg_btn" name="reg_user">Register</button>
        <button type="reset" class="btn btn-info" >Reset</button>
      </div>
      <br>
  	<p>
      Already a member? <a class="login_link" href="login.php">Sign in</a> or return to  <a class="homepage_link"href="index.php">Homepage</a>
  	</p>
  </form>
  </div>

 


<div class="container" id="reset_password_container">
<?php repeatmessage();?>  
  <div class="header">
  	<h2>Reset password</h2>
  </div>
	<form action="<?php echo htmlspecialchars(BASE_URL);?>#resetpassword" class="user_form" method="post">
		<!-- form validation messages -->
                                                                                                                                                                                                                                         
		<div class="form-input-group">
  	  <label>Email</label>
  	  <input type="email" name="reset_email" class="form-control" value="">
  	</div><br>
		<div class="form-input-group">
    <input type="hidden" name="website_name" value="<?= $website_name; ?>" >
			<button type="submit" name="reset-password" class="btn btn-primary">Submit</button>		
		</div>
		<br>
      Go to <a class="login_link"href="login.php">Sign in</a> or return to  <a class="homepage_link"href="index">Homepage</a>
  	
	</form>
</div>



<div class="container" id="conditions_container">
  <div class="header">
  	<h2>Terms and conditions</h2>
  </div>
	
  <form class="user_form">  	
  	<div class="form-input-group">
  	<label>  1. No bad language</label>
  	   	</div>
  	<div class="form-input-group">
  	<label>  2. No fake information</label>
  	</div>
  	<div class="form-input-group">
  	  <label>3. You have to pay fine if you receive a punishment or else you will  be banned forever.</label>
  	</div>
  	<div class="form-input-group">
  	  <label>4. Show respect to others</label>
  	</div>
      	<p>
  		AGREE? Then <a class="register_link"href="register.php">Register</a> or return to  <a class="homepage_link"href="index">Homepage</a>
  	</p>
  </form>
</div>
</body>
</html>

<?php include_once(USER_INCLUDES.'login_footer.php') ?>
