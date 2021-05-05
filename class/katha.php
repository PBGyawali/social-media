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
	function error(){
		return $this->db->errorInfo();
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

	function parms($string,$data) {
		$indexed=$data==array_values($data);
		foreach($data as $k=>$v) {
			if(is_string($v)) $v="'$v'";
			if($indexed) $string=preg_replace('/\?/',$v,$string,1);
			else $string=str_replace(":$k",$v,$string);
		}
		return $string;
	}
	function UsersArray($value=null,$placeholder=null,$combine='AND'){
		if(isset($_SESSION['id'])||$value!=null){
			$placeholderset='users.id';			
			if ($placeholder)	$placeholderset=$this->check_array($placeholder);			
			if ($value)	$setvalue=$value;
			else $setvalue=$_SESSION['id']; 			
			$join=array('LEFT JOIN'=>array('userlogs'=>"users.id = userlogs.user_id"));
			return $this->getArray('users',$placeholderset,$setvalue,$combine,$join);			
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
	
	function insert($table,$column,$value,$attr=array()){			
		$column=$this->check_array($column);
		$column_condition=$this->implode_array($column,'',',');
		$marker= implode(', ', array_fill(0, sizeof($column), '?'));
		if(isset($attr['replace']))
			$this->query = " REPLACE " ;
		else
		$this->query = " INSERT " ;
		if(isset($attr['ignore']))
			$this->query .= " IGNORE " ;
		$this->query .=" INTO $table ($column_condition) VALUES ($marker) ";
		if(isset($attr['duplicate']))
			$this->query .=" ON DUPLICATE KEY UPDATE ". $attr['duplicate'];
		if(isset($attr['debug'])){
			return $this->query;	
			}
		return $this->execute($value);
	}	
	function UpdateDataColumn($table,$column,$value=null,$placeholder=null,$condition=null,$combine='AND',$attr=array()){	
		$compare=isset($attr['compare'])?$attr['compare']:'=';
		if($value===null)	$column_condition=$this->implode_array($column);
		else				$column_condition=$this->implode_array($column,'?',',',$compare);
		$value=$this->check_array($value);
		$condition=$this->check_array($condition);
		$placeholder_condition=$this->implode_array($placeholder,'?',$combine);
		$finalvalue=array_merge($value,$condition);
		$this->query = "UPDATE $table SET $column_condition  ";
		if($placeholder_condition)
			$this->query .= " WHERE $placeholder_condition ";
		if(isset($attr['debug'])){
			return $this->query;	
			}			
		return $this->execute($finalvalue);
	}
	function CountTable($table,$condition=null,$value=null,$combine='AND',$compare='=',$attr=array()){   
		if ($value!=null){		  
			$marker=$this->create_placeholder($condition);	  
			if(!is_array($condition)&&is_array($value))			
			  	$marker=$this->create_placeholder($value);
		   $row_condition=$this->implode_array($condition,$marker,$combine,$compare);
		}	 
	  	else	  
			$row_condition=$this->implode_array($condition);	  			  
	 	$this->query = "SELECT Count(*) AS total FROM $table ";	
		if($row_condition)	$this->query .= " WHERE ".$row_condition;
		if(isset($attr['debug'])){
			return $this->query;	
		  }
		$this->execute($value);
		$row= $this->get_array(isset($attr['fetch'])?$attr['fetch']:'assoc');	
		return $row['total'];
	}

	  function get_data($data=null,$table,$placeholder=null,$conditions=null,$combine='AND',$join=array(),$attr=array()){    
		if (empty($table)) 
			return null;
		if(!$data)		$requireddata="*";
		else			$requireddata=$this->implode_array($data,'',',');
		if ($conditions!=null)	$row_condition=$this->implode_array($placeholder,'?',$combine);
		else					$row_condition=$this->implode_array($placeholder);
		$this->query ="SELECT $requireddata FROM $table ";
		if($join){
			$joincondition=$this->implode_join($join);
			$this->query .=$joincondition;
		}	
		if($row_condition)	$this->query .= " WHERE ".$row_condition;			
		$this->query .= " LIMIT 1";
		if(isset($attr['debug'])){
			return $this->query;	
		  }	
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

	  function getArray($table,$placeholder=null,$conditions=null,$combine='AND',$join=array(),$attr=array()){//gives one array		
		return $this->get_data('',$table,$placeholder,$conditions,$combine,$join,$attr);
	}

	function getAllArray($table,$column=null,$value=null,$combine='AND',$limit=null,$orderby=null,$order='DESC',$join=array(),$attr=array()){	//gives all array
		$compare=isset($attr['compare'])?$attr['compare']:'=';
		if ($value!=null)
		  	$row_condition=$this->implode_array($column,'?',$combine,$compare);
		  else
			  $row_condition=$this->implode_array($column);
			if(isset($attr['fields']))
			$requireddata=$this->implode_array($attr['fields'],'',',');
			else
			$requireddata='*';
		  $this->query =" SELECT " ;
		  $this->query .= $requireddata  ;	  
		  $this->query .= " FROM $table "  ;		 
		  if($join){
			$joincondition=$this->implode_join($join);
			$this->query .=$joincondition;
			}
			if(isset($attr['whereparameter'])){
				$this->query .= " WHERE ".$this->implode_join($attr['whereparameter'],'(');	
			}
		  elseif(!empty($row_condition)) $this->query .= " WHERE ".$row_condition;
		  if(isset($attr['groupby'])){
			$this->query .= " GROUP BY ". $attr['groupby'];	
		  }
		  if(isset($attr['having']))
			$this->query .= " HAVING ".$attr['having'];
		  if(!empty($orderby))  	 $this->query .= " ORDER BY ". $this->implode_array($orderby,$order,",",""," ","");
		  if(!empty($limit))	 	 $this->query .= " LIMIT ".$limit;
		  if(isset($attr['debug'])){
			return $this->query;	
		  }			  
		  $this->execute($value);
		  if(isset($attr['array'])){
			return $this->get_array(isset($attr['fetch'])?$attr['fetch']:'assoc');	
		  }	
		  return $this->statement_result(isset($attr['fetch'])?$attr['fetch']:MYSQLI_ASSOC);
	  }


	  function Delete($table,$placeholder=NULL,$conditions=NULL,$combine='AND'){
		if ($conditions!=null)	$row_condition=$this->implode_array($placeholder,'?',$combine);
		else					$row_condition=$this->implode_array($placeholder);
		$row_condition=$this->implode_array($placeholder,'?',$combine); 
		$this->query ="DELETE FROM $table WHERE ". $row_condition;
		return $this->execute($conditions);	
	}
function total($table=null,$column=null,$placeholder=null,$value=null,$combine='AND',$join=array(),$attr=array())
	{
		$implode=isset($attr['implode'])?$attr['implode']:',';
		$firstclose=isset($attr['firstclose'])?$attr['firstclose']:' ) AS ';
		$start=	isset($attr['start'])?$attr['start']:'IFNULL (SUM(';	
		$value=$this->check_array($value);
		$finalclose=isset($attr['finalclose'])?$attr['finalclose']:'), 0) AS total';
		if(isset($attr['implodehere']))
			$columnvalue=$start.$this->implode_array($column,'',') + SUM(').$finalclose;
		else
			$columnvalue=$this->implode_join($column,$firstclose,$start,$implode,$finalclose);
		$row_condition=$this->implode_array($placeholder,'?',$combine);						
		$this->query = "SELECT ".$columnvalue." FROM $table ";
		if($join){
			$joincondition=$this->implode_join($join);
			$this->query .=$joincondition;
		}	
		if(!empty($row_condition)) 
			$this->query .= " WHERE ".$row_condition;
		if(isset($attr['groupby']))
			$this->query .= " GROUP BY ".$attr['groupby'];		
		$this->execute($value);
		if(isset($attr['groupby']))
			return $this->statement_result(isset($attr['fetch'])?$attr['fetch']:MYSQLI_ASSOC);
		$row=$this->get_array(isset($attr['fetch'])?$attr['fetch']:'assoc');			
		if ($row)
				return $row['total'];				
		return 0;
	}

function implode_join($join,$how=' ON  ',$default='SUM(',$implode=" ",$close=')'){		
	if(is_string($join))
		return $default.$join.$close;
	$temp=array();			
	foreach($join as $column_name => $firstvalue)								
		if (is_array($firstvalue)){			
			foreach($firstvalue as $extracolumn_name => $extravalue)					
				if(is_array($extravalue))
					$temp[]=$this->implode_array($column_name,$how,""," ",$extracolumn_name,implode(' AND ',$extravalue));
				else
					$temp[] =$this->implode_array($column_name,$how,""," ",$extracolumn_name,$extravalue);
		}			
		else
			$temp[]=$column_name.' '.$firstvalue;	
	return  implode($implode,$temp);		
}
function implode_array($placeholder=null,$conditions=null,$combine="AND",$compare="=",$frontquotes="'",$backquotes="'",$attr=array()){
	$finalarray=array();
	if ($placeholder==null)
			return null;
	elseif (!is_array($placeholder)&&!empty($placeholder) && empty($conditions))						
			return " ".$placeholder." "; 
	elseif (!is_array($placeholder) && !empty($conditions) && !is_array($conditions))		
			if	($conditions=='?')
				return " ".$placeholder.$compare."?"." ";
			else
				return " ".$placeholder.$compare.$frontquotes.$conditions.$backquotes." "; 		
	elseif (is_array($placeholder)&& empty($conditions))				
			$finalarray=$placeholder;
	elseif (is_array($placeholder)&& is_array($conditions) && !empty($conditions))							
			if ( in_array('?',$conditions))
				foreach($conditions as $key=> $condition)
					if(is_array($compare))
						array_push($finalarray," ".$placeholder[$key].$compare[$key].$condition);
					else						 
						array_push($finalarray," ".$placeholder[$key].$compare.$condition);
			else
				foreach($conditions as $key=> $condition)
					if(is_array($compare))							
					array_push($finalarray," ".$placeholder[$key].$compare[$key].$frontquotes.$condition.$backquotes);
					else
					array_push($finalarray," ".$placeholder[$key].$compare.$frontquotes.$condition.$backquotes);	
	elseif (is_array($placeholder)&& !is_array($conditions) && !empty($conditions))					
			if ($conditions=='?')
				foreach($placeholder as $key=> $place)
				if(is_array($compare))							
					array_push($finalarray," ".$place.$compare[$key].$conditions);
				else
					array_push($finalarray," ".$place.$compare.$conditions);	
					
			else
				foreach($placeholder as $key=> $place){
					if(!empty($place))
					array_push($finalarray," ".$place.$compare.$frontquotes.$conditions.$backquotes);	
				}
	else	
			if(!$combine)
				return $placeholder[0].$compare.$conditions[0];		
			elseif ( in_array('?',$conditions))						
				foreach($conditions as $key=> $condition)							
					array_push($finalarray," ".$placeholder.$compare.$condition); 
			else						
				foreach($conditions as $key=> $condition)
					if(!empty($condition))
						array_push($finalarray," ".$placeholder.$compare.$frontquotes.$condition.$backquotes); 									
	if ($combine)
		if(is_array($combine)){
			$temp=array();
			$count=0;
			foreach($finalarray as $key=>$returnarray){
				if($combine[$count])
					$temp[]=$returnarray.$combine[$count];
				$count++;
			}
			return implode('  ',$temp);
		}
		else
			return implode(' '.$combine.' ',$finalarray); 
	return  $finalarray;    
}




}


?>