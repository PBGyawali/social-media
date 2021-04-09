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