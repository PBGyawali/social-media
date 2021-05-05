<div class="container" id="register_container">
  <div class="header">
	  <h2>Register</h2>
	 
  </div>
  <?php //repeatmessage();?>

  <span class="text-center position-absolute w-100 message"id="error_msg" style="z-index:978"></span>
  <form name="myForm" class="user_form" id="register_form" method="post" action="<?php echo htmlspecialchars(BASE_URL);?>#register" >
     
  <div class="form-input-group"> 
    <label class="d-inline-block">Username</label><span class="d-inline-block position-relative " style="z-index:978"> </span>    		
  	  <input type="text" name="register_username" id="register_username" class="form-control datacheck" data-object="Username"  required data-parsley-minlength="5" data-parsley-trigger="on change">
  	</div>
  	<div class="form-input-group">
  	  <label class="d-inline-block">Email</label> <span class="d-inline-block position-relative "></span>
  	  <input type="email" name="register_email" id="register_email" class="form-control datacheck" data-object="Email"  required data-parsley-type="email" data-parsley-trigger="on change">
	  </div>
	  <div class="form-input-group">
		<label>Confirm Email</label>
		<span></span>
  	  <input type="email" name="register_confirmemail"id="register_confirmemail" class="form-control"required data-parsley-equalto="#register_email" data-parsley-trigger="on change">
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