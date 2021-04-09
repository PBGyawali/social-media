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
      <div class="form-input-group" >
      Forgot Your Password?<a class="reset_password_link" href="reset password.php"> RESET HERE. </a> Not a Member Yet?<a class="register_link"href="register.php"> SIGN UP HERE</a>
      </div>  
     
  	<div class="form-input-group">
          <input type="hidden" name="website_name" value="<?= $website_name; ?>" >
          <input type="hidden" name="website_logo" value="<?= $website_logo; ?>" >
          <button type="submit" class="btn btn-primary" name="login_user">Login</button>          
          <button type="submit" class="btn btn-secondary" name="login_guest" id="login_guest">Login as a guest</button>
          <button type="button" class="btn btn-success"  id="hint">Show login hint</button>
              </div>    
  </form>
  </div>