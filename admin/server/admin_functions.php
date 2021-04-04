<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(ADMIN_CLASS.'katha.php');
$katha=new katha();
$topic_id = 0;
$topic_name = "";

if(isset($_POST["action"]))	 	$action = $katha->clean_input($_POST["action"]);	
if(isset($_POST["topic_id"]))	$topic_id=$katha->clean_input($_POST['topic_id']);
if(isset($_POST["topic"]))	 	{$topic=$katha->clean_input($_POST["topic"],'h');$slug= $method->Slug($topic);}

if(!empty($action))
 {
	switch($action) 
	{
		case "add":
		case "edit":
			if (empty($topic)){ 
				$response= "Topic name required"; 
				$status="error";
			}
			else 
			{	
				switch($action) 
				{
					case "add":
						// Ensure that no topic is saved twice. 
					$topic_check_query =$katha->CountTable('topics','slug',$slug);			
					if ($topic_check_query>0){ 
						$response= "Topic already exists";
						$status="error";
					} 
					else
					{					
						$result = $katha->insert('topics',array('name','slug'),array($topic,$slug));
						if($result)
						{
							$insert_id = $katha->id();
							if ($insert_id ){
								$status="The topic was successfully added";
								$response= '
								<tr  class="topic-box" id="topic_'. $insert_id.'">
										<td class="index">1</td>
										<td><div class="topic-content">'.ucwords($topic).'</div></td>
										<td>
										<button type="button" name="edit" title="edit"class="fa fa-edit btn btn-success edit_button"  data-id="'.$insert_id.'"> EDIT</button> &nbsp;															
										<button type="button" name="delete" title="delete" class="fa fa-trash btn btn-danger delete_button" data-id="'.$insert_id.'" > DELETE</button>
										</td>
										</tr>';
							}
							else{								
									$response= "Topic is not unique";
									$status="error";
							}							
						}
					}
					break;

						case "edit":							
								$topic_check_query=$katha->CountTable('topics',array('slug','id!'),array($slug,$topic_id));						
								if ($topic_check_query[0]>0) { 
									$response= "Topic already exists";
									$status="error";
								} 
								else{
									$result =$katha->UpdateDataColumn('topics',array('name','slug'),array($topic,$slug),"id",$topic_id);
									if($result){ 
										if ($katha->row()){
											$status="The topic was successfully updated";
											$response=$topic;
										}
										else{
											$status="There was no update made";
											$response=$topic;
										}										
									}
									else{
										$status="error";
										$response="There was no update made";
									}
								}																						
						break;
				}			
			break;	}	
		

		case "delete": 
			$result=$katha->Delete('topics','id',$topic_id);
			if($result){
				$status="success";
				$response="The topic was successfully deleted";
			}
			else{
				$status="error";
				$response="The topic could not be deleted due to some error";
			}			
			break;
	}
	$method->response($response, $status);	
 }
?>