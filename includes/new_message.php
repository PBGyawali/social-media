<?php if (session_status() === PHP_SESSION_NONE){session_start();}?>

<?php

function displaymessage(){
	global $errors;	
	$messages=array();
	if ($errors){
		if (count($errors) > 0) 
		echo "<div class='error'>";
		 foreach ($errors as $error) 
		 echo "<p class='alert alert-danger'>".  $error. "</p>";			
		 echo "</div>";
	}
	if(isset($_SESSION['success']) && !empty($_SESSION['success'])){
		$message="<p class=' alert alert-success'>".$_SESSION['success']."</p>";
		array_push($messages,$message);
		echo $message;
		unset($_SESSION['success']);
	}

	
	if(isset($_SESSION['error']) && !empty($_SESSION['error'])){
		$message="<p class='alert alert-danger'>".$_SESSION['error']."</p>";
		array_push($messages,$message);
		echo $message;
		unset($_SESSION['error']);
	}
	if(isset($_SESSION['info']) && !empty($_SESSION['info'])){
		$message="<p class='alert alert-info'>".$_SESSION['info']."</p>";
		array_push($messages,$message);
		echo $message;
		unset($_SESSION['info']);
	}
	if(isset($_SESSION['warning']) && !empty($_SESSION['warning'])){
		$message="<p class='alert alert-warning'>".$_SESSION['warning']."</p>";
		array_push($messages,$message);
		echo $message;
		unset($_SESSION['warning']);
	}
	if(isset($_SESSION['message']) && !empty($_SESSION['message'])){
		$message="<p class='alert alert-warning text-center'>".$_SESSION['message']."</p>";
		array_push($messages,$message);
		echo $message;
		unset($_SESSION['message']);
	} 
	return $messages; 
}

function repeatmessage(){
	global $errors;	
	global $messages;
	if ($errors){
		if (count($errors) > 0) 
		echo "<div class='error'>";
		 foreach ($errors as $error) 
		 echo" <p>".  $error. "</p>";			
		 echo"</div>";
	}
	if ($messages){
		if (count($messages) > 0) 		
		 foreach ($messages as $message) 
		 echo  $message;			
		 
	}

}
?>		