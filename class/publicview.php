<?php
class publicview extends file
{
	public $base_url = BASE_URL;
	public $admin_url = ADMIN_URL;
	protected $db;
	public $query;
	protected $statement;

    function __construct(){
        $this->db = new mysqli(DB_SERVER , DB_USERNAME , DB_PASSWORD , DB_NAME);
        if ($this->db -> connect_errno){
        	echo "Failed to connect to MySQL server: " . $this->db -> connect_error;
        	exit();
        }                   
        else{
				if (session_status() === PHP_SESSION_NONE)session_start();
				$this->db->set_charset('utf8');
				set_time_limit(0);
				return $this->db;
			}		
	}
	function execute($data = null, $types = ""){ 
		$this->statement = $this->db->prepare($this->query);
        if($data){       
			$data=$this->check_array($data);
			$types = $types ?: str_repeat("s", count($data));
			$this->statement->bind_param($types, ...$data);			             			             
        }        
		return $this->statement->execute();		
	}

	function row_count(){
		return $this->statement->get_result()->num_rows;
	}
	function get_result(){
		return $this->statement->get_result();
	}

	function statement_result(){
		return $this->statement->get_result()->fetch_all(MYSQLI_ASSOC);
	}

	function get_array(){		
		return $this->statement->get_result()->fetch_assoc();
    }

    function close(){
        $this->statement->close();
    }
	function id(){
		return $this->db->insert_id;
	}
	function row(){
		return $this->db->affected_rows;
    }

	function clean_input($string,$html=null){
		  $string = trim($string);
		  $string = mysqli_real_escape_string($this->db, $string);
		  $string = stripslashes($string);
		  if($html){
			  if($html=='e')
				$string = htmlentities($string);			  
			  else
				$string = htmlspecialchars($string);			  		
		  }		  
		  return $string;
	}

	function UsersArray($value=null,$placeholder=null,$combine='AND'){
		if(isset($_SESSION['id'])||$value!=null){
			$placeholderset='users.id';			
			if ($placeholder)	$placeholderset=$this->check_array($placeholder); 
			if ($value)	$setvalue=$value;
			else		$setvalue=$_SESSION['id'];			
			$row_condition=$this->implode_array($placeholderset,'?',$combine);
			$this->query = "SELECT * FROM users LEFT JOIN userlogs ON users.id = userlogs.user_id WHERE $row_condition LIMIT 1";
			$this->execute($setvalue);	
			$results=$this->get_array();
			return $results;
		}
		return null;		
	}
	function ownerData(){		
		return $this->getArray('website_data');		
	}
	
	function WebsiteName(){	
		return $this->get_data('website_name','website_data');
	}
	function WebsiteLogo(){	
		return $this->get_data('website_logo','website_data');
	}
	function Get_profile_image($user_id=null)
	{
		if 	((isset($_SESSION['id']) &&!empty($_SESSION['id'])) || $user_id!=null){   
				(($user_id)?$id=$user_id:$id=$_SESSION['id']);							
					$row = $this->get_data(array('sex','profile_image','username'),'users','id',$id,'',1);					
					if(!empty($row['profile_image']))
						 return $this->image_check($row['profile_image'],USER_IMAGES_DIR);
					else { 
							if($row['sex']=='male')
								return "Admin.png";
							else if($row['sex']=='female')
								return "admin_female.png";
							else{							
								$image=$this-> make_avatar(strtoupper($row['username'][0]));						
								$saved=$this->UpdateDataColumn("users","profile_image",$image,"id",$id);
								if($saved)
									return $image;
								return null;							
							}		
						}
		}
		  return 'user_profile.png';
	}

	function activitylogs($user_id, $text,$type=null,$object=null,$parent_id=null,$parent_text=null,$child_text=null){
		$this->insert('activity_log',array('user_id', 'text','type','activity_object','parent_activity_id',
		'parent_activity_text','child_activity_text'),array($user_id, $text,$type,$object,$parent_id,$parent_text,$child_text));
	}

	function insert($table,$column,$value){			
		$column=$this->check_array($column);
		$column_condition=$this->implode_array($column,'',',');
		$value=$this->check_array($value);   		
		$marker= implode(', ', array_fill(0, sizeof($column), '?'));
		$this->query = "INSERT INTO $table ($column_condition) VALUES($marker)";		
		return $this->execute($value);
	}

	function UpdateDataColumn($table,$column,$value=null,$placeholder,$condition,$combine='AND'){	
		if($value===null)	$column_condition=$this->implode_array($column);
		else				$column_condition=$this->implode_array($column,'?',',');
		$value=$this->check_array($value);
		$condition=$this->check_array($condition);
		$placeholder_condition=$this->implode_array($placeholder,'?',$combine);
		$finalvalue=array_merge($value,$condition);
		$this->query = "UPDATE $table SET $column_condition WHERE $placeholder_condition ";	
		//return 	$this->query;
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
		if($row_condition)	$this->query .= " WHERE ".$row_condition;
		$this->execute($value);
		$row= $this->get_array();	
		return $row['total'];
	}

	function get_data($data=null,$table=null,$placeholder=null,$conditions=null,$combine='AND',$limit=null){    
		if (empty($table)) 
		return null;
		if(!$data)		$requireddata="*";
		else			$requireddata=$this->implode_array($data,'',',');
		if ($conditions!=null)	$row_condition=$this->implode_array($placeholder,'?',$combine);
		else					$row_condition=$this->implode_array($placeholder);
		$this->query ="SELECT $requireddata FROM $table";
		if($row_condition)	$this->query .= " WHERE ".$row_condition;			
		if($limit)			$this->query .= " LIMIT ".$limit; 
		$this->execute($conditions);
		$row= $this->get_array();	
		if ($row)
		{	if(!$data || is_array($data))			
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
		  if(!empty($row_condition)) $this->query .= " WHERE ".$row_condition;	
		  if(!empty($orderby))  	 $this->query .= " ORDER BY ". $orderby ." ".$order;
		  if(!empty($limit))	 	 $this->query .= " LIMIT ".$limit;			  
		  $this->execute($value);
		  return $this->statement_result();
	  }

	function Delete($table,$placeholder=NULL,$conditions=NULL,$combine='AND'){
		if ($conditions!=null)	$row_condition=$this->implode_array($placeholder,'?',$combine);
		else					$row_condition=$this->implode_array($placeholder);
		$row_condition=$this->implode_array($placeholder,'?',$combine); 
		$this->query ="DELETE FROM $table WHERE ". $row_condition;
		return $this->execute($conditions);	
	}

	function total($table,$column,$placeholder=null,$value=null,$combine='AND'){
		$value=$this->check_array($value);
		$row_condition=$this->implode_array($placeholder,'?',$combine);
		$this->query = "SELECT IFNULL(SUM($column), 0) AS total FROM $table ";
		if($row_condition) 	$this->query .= " WHERE ".$row_condition;				
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