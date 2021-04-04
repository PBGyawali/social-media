<?php
class katha extends file
{
	public $base_url = BASE_URL;
	public $admin_url = ADMIN_URL;
	public $connect;
	public $query;
	public $statement;

	function __construct(){
		try {
			$this->connect = new PDO("mysql:host=".DB_SERVER.";dbname=".DB_NAME.";", DB_USERNAME, DB_PASSWORD);
			$this->connect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			$this->query = "SET NAMES utf8";			
			if (session_status() === PHP_SESSION_NONE){session_start();}
			if($this->Set_timezone() != '')
			{
				date_default_timezone_set($this->Set_timezone());
			}
		}		
		catch(PDOException $e){
			$msg = date("Y-m-d h:i:s A")." Connection, PDO: ".$e->getMessage()."\r\n";
			error_log($msg, 3, ERROR_LOG);
		} catch(Exception $e){
			$msg = date("Y-m-d h:i:s A")." Connection, General: ".$e->getMessage()."\r\n";
			error_log($msg, 3, ERROR_LOG);
		}
        return $this->connect;
		
	}
	function execute($data = null){
		$this->statement = $this->connect->prepare($this->query);
		if($data){
			$data=$this->check_array($data);			
			return $this->statement->execute($data);
		}
		else		
			return $this->statement->execute();		
	}

	function row_count(){
		return $this->statement->fetchColumn();
	}

	function statement_result(){
		return $this->statement->fetchAll();
	}
	function get_array(){		
		return $this->statement->fetch();
    }
	function get_result(){
		return $this->connect->query($this->query, PDO::FETCH_ASSOC);
	}

	function close() {
        $this->statement=NULL;
    }
	function id() {
		return $this->connect->lastInsertId();
	}
	function row() {
		return $this->statement->rowCount();
    }

	function clean_input($string,$html=null){
		  $string = trim($string);		 
		  $string = stripslashes($string);
		  if($html){
			  if($html=='e')			  
				$string = htmlentities($string);
			  else			  
				$string = htmlspecialchars($string);
		  }		  
		  return $string;
	}

	function Set_timezone(){    
		return $this->get_data('website_timezone','website_data');		
	}


function UsersArray($placeholder=null,$value=null,$combine='AND'){
	if(isset($_SESSION['id'])||($placeholder!=null&&$value!=null))
	{
		(($placeholder)?$placeholderset=$placeholder:$placeholderset='users.id');
		(($value)?$setvalue=$value:$setvalue=$_SESSION['id']);			
		$row_condition=$this->implode_array($placeholderset,'?',$combine);
		$this->query = "SELECT * FROM users LEFT JOIN userlogs ON users.id = userlogs.user_id WHERE $row_condition LIMIT 1"; 
		$this->execute($setvalue);	
		return $this->get_array();		
	}
		return null;		
}


	function activitylogs($user_id, $text,$type=null,$object=null,$parent_id=null,$parent_text=null,$child_text=null){
		$this->insert('activity_log',array('user_id', 'text','type','activity_object','parent_activity_id',
		'parent_activity_text','child_activity_text'),array($user_id, $text,$type,$object,$parent_id,$parent_text,$child_text));
	}

	function WebsiteName(){	
		return $this->get_data('website_name','website_data');
	}
	function Get_profile_image($user_id=null){
		if 	((isset($_SESSION['id']) && !empty($_SESSION['id'])) || $user_id!=null){  
			(($user_id)?$id=$user_id:$id=$_SESSION['id']);
			$this->query = " SELECT sex,profile_image,username FROM users WHERE id = ? ";
			$this->execute($id);
			$row = $this->get_array();					
			if(!empty($row['profile_image']))					
				return $this->image_check($row['profile_image'],USER_IMAGES_DIR);							
			else { 
					if($row['sex']=='male')							
						return "Admin.png";							
					else if($row['sex']=='female')							
						return "admin_female.png";							
					else
					{							
						$image=$this->make_avatar(strtoupper($row['username'][0]));						
						$saved=$this->UpdateDataColumn("users","profile_image",$image,"id",$id);
						if($saved)								
							return $image;								
						return null;							
					}		
				}
		}
		return 'user_profile.png';
	}
	
	function insert($table,$column,$value){	
		$column=$this->check_array($column);
		$column_condition=$this->implode_array($column,'',',');
		$value=$this->check_array($value);   		
		$marker= implode(', ', array_fill(0, sizeof($column), '?'));
		$this->query = "INSERT INTO $table ($column_condition) VALUES($marker)";		
		return $this->execute($value);
	}
	function UpdateDataColumn($table,$column,$value,$placeholder,$condition,$combine='AND'){	
		$column_condition=$this->implode_array($column,'?',',');
		$value=$this->check_array($value);
		$condition=$this->check_array($condition);
		$placeholder_condition=$this->implode_array($placeholder,'?',$combine);
		$finalvalue=array_merge($value,$condition);
		$this->query = "UPDATE $table SET $column_condition WHERE $placeholder_condition ";		
		return $this->execute($finalvalue);
	}
	
	function CountTable($table,$condition=null,$value=null,$combine='AND'){    
	  if ($value!=null){		  
		  $marker=$this->create_placeholder($condition);	  
		  if(!is_array($condition)&&is_array($value))		  
				$marker=$this->create_placeholder($value);
		 $row_condition=$this->implode_array($condition,$marker,$combine);
	  }
	  else	
			$row_condition=$this->implode_array($condition);		  
	 	$this->query = "SELECT Count(*) AS total FROM $table ";	
		if(!empty($row_condition)&& is_string($row_condition))		
			$this->query .= " WHERE ".$row_condition;	
		$this->execute($value);
		$row= $this->get_array();	
		return $row['total'];
	  }	

	  function get_data($data=null,$table=null,$placeholder=null,$conditions=null,$combine='AND',$limit=null){   
		  if (empty($table)) 
			  return null;
		  if(!$data)
			  $requireddata="*";
		  else	
			  $requireddata=$this->implode_array($data,'',',');
		  if ($conditions!=null)
			  $row_condition=$this->implode_array($placeholder,'?',$combine);
		  else
			  $row_condition=$this->implode_array($placeholder);
		  $this->query ="SELECT $requireddata FROM $table";
		  if(!empty($row_condition)&& is_string($row_condition))
				  $this->query .= " WHERE ".$row_condition;			
		  if($limit)
			  $this->query .= " LIMIT ".$limit; 
		  $this->execute($conditions);
		  $row= $this->get_array();	
		  if ($row){
			  if(!$data || is_array($data))			
				  return $row;	
			  else
				  return $row[$data];	
		  }						
		  return null;	
	  }

 function getArray($table,$placeholder=null,$conditions=null,$combine='AND',$limit=null){//gives one array
	return $this->get_data('',$table,$placeholder,$conditions,$combine,$limit);
}

function getAllArray($table,$column=null,$value=null,$combine='AND',$limit=null,$orderby=null,$order='DESC'){	//gives all array	
		if ($value!=null)		
			$row_condition=$this->implode_array($column,'?',$combine);		
		else		
			$row_condition=$this->implode_array($column);
		$this->query ="SELECT * FROM $table";
		if(!empty($row_condition)) 
			$this->query .= " WHERE ".$row_condition;	
		if(!empty($orderby)) 
			$this->query .= " ORDER BY ". $orderby ." ".$order;
		if(!empty($limit)) 
			$this->query .= " LIMIT ".$limit;
		$this->execute($value);
		return $this->statement_result();	
	}


function Delete($table,$placeholder=NULL,$conditions=NULL,$combine='AND'){
	$row_condition=$this->implode_array($placeholder,'?',$combine); 
	$this->query ="DELETE FROM $table WHERE ". $row_condition;
	return $this->execute($conditions);	
}

function total($table,$column,$placeholder=null,$value=null,$combine='AND')
{
	$value=$this->check_array($value);
	$row_condition=$this->implode_array($placeholder,'?',$combine);
	$this->query = "SELECT IFNULL(SUM($column), 0) AS total FROM $table ";
	if(!empty($row_condition)) 
		$this->query .= " WHERE ".$row_condition;				
	$this->execute($value);
	$row=$this->get_array();
	if ($row)
			return $row['total'];				
	return 0;
}

function implode_array($placeholder=null,$conditions=null,$combine='AND'){
	$finalarray=array();
	if ($placeholder==null)
		return null;
	elseif (!is_array($placeholder)&&!empty($placeholder) && empty($conditions))						
		return " ".$placeholder." "; 
	elseif (!is_array($placeholder) && !empty($conditions) && !is_array($conditions))		
			if	($conditions=='?')
				return " ".$placeholder."="."?"." ";
			else
				return " ".$placeholder."="."'".$conditions."'"." "; 		
	elseif (is_array($placeholder)&& empty($conditions))				
		return implode(' '.$combine.' ', $placeholder);
	elseif (is_array($placeholder)&& is_array($conditions) && !empty($conditions))							
			if ( in_array('?',$conditions))
				foreach($conditions as $key=> $condition)						 
					array_push($finalarray," ".$placeholder[$key]."=".$condition." ");
			else
				foreach($conditions as $key=> $condition)							
					array_push($finalarray," ".$placeholder[$key]."="."'".$condition."'"." ");		
	elseif (is_array($placeholder)&& !is_array($conditions) && !empty($conditions))					
			if ($conditions=='?')
				foreach($placeholder as $key=> $place)
					array_push($finalarray," ".$place."=".$conditions." ");
			else
				foreach($placeholder as $key=> $place)
					array_push($finalarray," ".$place."="."'".$conditions."'"." ");		
	else					
			if ( in_array('?',$conditions))						
				foreach($conditions as $key=> $condition)							
					array_push($finalarray," ".$placeholder."=".$condition." "); 
			else						
				foreach($conditions as $key=> $condition)
					array_push($finalarray," ".$placeholder."="."'".$condition."'"." "); 
	if ($combine)
		return implode($combine,$finalarray); 
	return  $finalarray;    
}




}


?>