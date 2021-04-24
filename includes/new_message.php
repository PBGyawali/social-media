<?php if (session_status() === PHP_SESSION_NONE){session_start();}
function displaymessage($display=true){
	global $errors;	
	$messages=array();
	if ($errors){
		if (count($errors) > 0) {
			foreach ($errors as $error){
				echo'<div class="text-center bg-danger alert alert-danger text-white border-0"><p >';
				print_r(  $error); 
				echo '</p></div> ';
			}
		}
		else{
			echo'<div class="text-center bg-danger alert alert-danger text-white border-0"><p >';
				print_r(  $errors); 
				echo '</p></div> ';
		}		
	}
	$types=array('success','info','warning','error','message','danger');
	$showtypes=array('success','info','warning','danger','warning','danger');
	foreach($types as $key=>$type){
		if(isset($_SESSION[$type]) && !empty($_SESSION[$type])){	
			$message='<div class="text-center alert alert-'.$showtypes[$key].'">'.$_SESSION[$type].'</div>';	
			array_push($messages,$message);
			if($display==true){
				echo $message;
			}	
			unset($_SESSION[$type]);
		}
	}
	return $messages; 
}

function repeatmessage(){
	global $errors;	
	global $messages;
	if ($errors){
		if (count($errors) > 0) 	
		echo'<div class="text-center bg-danger alert alert-warning text-white border-0">';
		 foreach ($errors as $error)
		 echo' <p >'.  $error. '</p>';
		 echo '</div> ';
	}
	if ($messages){
		if (count($messages) > 0) 		
		 foreach ($messages as $message) 
		 echo  $message;			
		 
	}

}
?>		