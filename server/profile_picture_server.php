<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php'); 
include_once(USER_CLASS.'publicview.php');
$katha=new publicview(); 
$id="";
$upload=1;
$errors=array();
$response='';

if(isset($_POST['delete_picture'])) 
{	$id= $katha->clean_input($_POST['profile_id']);
    $old_image= $katha->clean_input($_POST['profile_image']); 
    //set the image storage directory
    $dir=USER_IMAGES_DIR;    
    // define the full image file path
    $target= $dir.urldecode($old_image);
    //delete the name of the file from the database
    $katha->UpdateDataColumn('users','profile_image','','id',$id);
    // query if the data entry has been made into the database                               
    if($katha->row()>0)         
    { // if image is successfully deleted  
        $result=$file->imageDelete($target);      
        if($result){
            $response="Profile picture successfully deleted !!!";
            $katha->activitylogs($id, 'You deleted your ','delete','profile picture') ;
            $_SESSION['profile_image']=$katha->Get_profile_image();
        }
        else{
            $katha->UpdateDataColumn('users','profile_image',$old_image,'id',$id);
            array_push($errors, $result);
        }        
    }
    else
        //incase file is deleted but data could not be entered into the database
        array_push($errors, "Failed to delete image. The image was not found");
    $finalresponse = array('success'=> $response,'error'=> $errors,'url'=>USER_IMAGES_URL,'profile_image'=>rawurlencode($_SESSION['profile_image']));
        echo json_encode($finalresponse);
}


if(isset($_POST['upload'])) 
{	$id= $katha->clean_input($_POST['profile_id']);
    $old_image= $katha->clean_input($_POST['profile_image']); 
    $button='';
    //$new_random_name=$oldfile;
    $dir=USER_IMAGES_DIR;
    $result= $file->fileUpload($_FILES['featured_image'], $dir,$id);
    $errors=$result[1];
    // create post if there are no errors in the form
    if (count($errors) == 0)
    {   $new_random_name=$result[0];                                   
        //define the full path of previous image
        $oldfile_location=$dir.urldecode($old_image);   
        $target = $dir.$new_random_name;                                                                                        
        //enter the name of the file in the database
        $katha->UpdateDataColumn('users','profile_image',$new_random_name,'id',$id);
        // query if the data entry has been made into the database                               
        if($katha->row()>0)
        { // if image is successfully uploaded
            $_SESSION['profile_image']=$new_random_name;
            $button='<button class="btn btn-danger btn-sm fa fa-trash delete_btn" id="delete_picture" title="Click on the button to delete your profile picture"> Delete</button> ';
            $file->imageDelete($oldfile_location); 
            $response="Profile picture update successfull !!!";
            $katha->activitylogs($id, 'You updated your ','update','profile picture') ;
        }                                                
        else{
            $file->imageDelete($target);
            //incase file is uploaded but data could not be entered into the database
            array_push($errors, "Image data could not be written in the database");                                  
        }
    }       
    else
        array_push($errors, "The upload process could not be completed. ");
    $finalresponse =array('success'=>$response,'error'=> $errors,'url'=>USER_IMAGES_URL,'profile_image'=>rawurlencode($_SESSION['profile_image']),'button'=>$button);
    echo json_encode($finalresponse);
}
















    ?>