<?php 
class file extends method{

	protected  $errors=array();

	function imageDelete($target){		
		if( !is_dir($target) && file_exists($target) )
		{        // Remove file
			return unlink($target);
		}
		
	}
	function Slug(String $string,$symbol='-')
	{
		$string = strtolower($string);
		$slug = preg_replace('/[^A-Za-z0-9-]+/', $symbol, $string);
		return $slug;
	}
	
	function fileUpload($file, $dir,$id='1',$type='image')
	{
		global $errors;	
		$file_name= '';
		if (empty($file['name'])) 
			array_push($errors, "Featured ". $type. " is empty "); 
		else
		{
				if($file['error'] == 0)
				{// file does not have any error
					// Check file size
					if (($file["size"]) > 500000000) 
						array_push($errors, '<div class="alert alert-danger">The uploaded '.$type.' is too large for our database to handle. </div><br>');
					else
					{		//extract file extension
							$fileType=strtolower(pathinfo($file['name'],PATHINFO_EXTENSION));
							// Allow only certain file formats			
							if(!in_array($fileType, ALLOWED_IMAGES))
								array_push($errors,  '<div class="alert alert-danger">Sorry, this '.$type.' extension is not supported. </div><br>');
							else
							{   
								if( $type=='image')
								{   // Check if image file is a actual image or fake image
                                    $imagetype=getimagesize($file["tmp_name"]);
                                    if($imagetype == false)                                    
	                                   array_push($errors, '<div class="alert alert-danger">The uploaded file is not a valid image. </div><br>');
							     }
								if(count($errors)==0)
								{
									$new_random_name=$this->processname($file['name'],$fileType,$id);
									// set new image full file storage path
									$target = $dir . $new_random_name;	
									
									//Check if the directory already exists.
									if(!is_dir($dir))
										//Directory does not exist, so lets create it with true variable allowing to create nested folders
										mkdir($dir, 0755, true);

									if ($type=='image' && !$this->compressImage($file['tmp_name'], $target))								
											array_push($errors, '<div class="alert alert-danger">Failed to transfer image. Image compression error</div><br>');
									elseif ($type!='image'&& !move_uploaded_file($file['tmp_name'], $target))								
											array_push($errors, '<div class="alert alert-danger">Failed to upload file. Please check file settings for your server </div><br>');
									else	
											$file_name= $new_random_name;
								} 
							}
					} 
				}
		} 
		$finalresponse =[$file_name,  $errors];			
		return $finalresponse;
	}
	function processname($file,$extension='jpg',$id='0')
	{  
				//extract file name without extension
				//extracts the whole text as an array with '.' as a delimiter
				$removeExtension = explode('.',basename($file));
				//returns everything except the last extension of the file in an array
				$sliced = array_slice($removeExtension, 0, -1);				
				//append the array into a new name with '_' as a delimiter
				$string = implode("_", $sliced); 
				//replace any spaces in name with '_'
				$string=$this->Slug($string,'_');
				//generates a random number
				$random=rand(100,10000);
				//set a new random name to the image
				$new_random_name=$string.'_'.$id.'_'.time().'_'.date("m_d_y").'_'.$random.'.'.$extension;
				return $new_random_name;
	}

	// Compress image
	function compressImage($source, $storepath=USER_IMAGES_DIR, $quality=75){  
		$info = getimagesize($source);
		if ($info['mime'] == 'image/jpeg') 
		$image = imagecreatefromjpeg($source);  
		elseif ($info['mime'] == 'image/gif') 
		$image = imagecreatefromgif($source);  
		elseif ($info['mime'] == 'image/png') 
		$image = imagecreatefrompng($source); 
		elseif ($info['mime'] == 'image/bmp') 
		$image = imagecreatefrombmp($source); 		
		$result=imagejpeg($image, $storepath, $quality); 
		imagedestroy($image);
		return $result;  
	}

	function make_avatar($character,$storepath=USER_IMAGES_DIR,$extension='png')
	{
		$image_name=time() . '.'.$extension;
		$path = $storepath. $image_name;
		$image = imagecreate(200, 200);
		$red = rand(0, 255);
		$green = rand(0, 255);
		$blue = rand(0, 255);
		imagecolorallocate($image, $red, $green, $blue);  
		$textcolor = imagecolorallocate($image, 255,255,255); 	
		imagettftext($image, 100, 0, 55, 150, $textcolor,FONTS_DIR.'arial.ttf', $character);
		imagepng($image, $path);
		imagedestroy($image);
		return $image_name;
	}


	function save_file($url,$dir){
		$image = file_get_contents($url);//download the image from the alien server
		file_put_contents($dir, $image); //save the image on your server
	}


	function image_check($image_name,$dir_name=null ){				
		if(!is_dir($dir_name.$image_name) && file_exists($dir_name.$image_name))
			return ($image_name);		
		else
		return 'avatar7.png';
	}




}
	
	
	
	
	

?>