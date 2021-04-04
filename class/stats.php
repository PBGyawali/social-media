<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
include_once(USER_CLASS.'publicview.php');	
class stats extends publicview{	
	function getAllUsers(){		
		return $this->CountTable('users'); 		
	}	
	function getAllPublishedPosts(){		
		return $this->CountTable('posts','published',1);	
	}	
	function getAllUnPublishedPosts(){				
		return $this->CountTable('posts','published=0');	
	}
	function getUnverifiedEmail(){			
		return $this->CountTable('userlogs','user_status','Unauthenticated');
	}	
	function getUnverifiedProfile(){			
		return $this->CountTable('userlogs','verified','no');
	}
	function getAllUnResolvedTickets(){   
		return $this->CountTable('tickets','status',array('open', 'pending','on-hold'),'OR');
	}	
	function count_follow_requests(){
		if 	(isset($_SESSION['id']))          
			return $this->CountTable('followers','receiver_id',$_SESSION["id"]);		
		return 0;	
	}		
	function UserPublishedPosts(){
		return $this->countPosts(1);
	}
	function UserUnPublishedPosts(){		
		return $this->countPosts(0);	
	}
	function countPosts($value){
		if 	(isset($_SESSION['id']))	
			return $this->CountTable('posts',array('published','user_id'),array($value,$_SESSION["id"]),'AND');			
		return 0;	
	}	
	function getmonth()	{	
		return $this->loopmonth('&quot;');			
	}
	function getmonthhtml()	{		
		return $this->loopmonth();
	}
	function getfullmonth(){
		return $this->loopmonth("&quot;","-9");
	}
	function getfullmonthhtml(){
		return $this->loopmonth("","-9");
	}		
	function loopmonth($quote=null,$start=1){
		$months=array();
		for($i=$start;$i<=date('n');$i++)
			array_push($months,$quote.substr(date('F', mktime(0, 0, 0, ($i), 2, date('Y'))),0,3).$quote);
		if ($quote)
			return  implode(',',$months);
		return  $months;
	}
	function getmonthvalue(){
		return  $this->loopmonthvalue('&quot;');
	}
	function getmonthvaluehtml(){
		return  $this->loopmonthvalue();
	}
	function loopmonthvalue($quote=null){
		$value=$this->loopvalue(date('n'),$quote);	
		if ($quote)
			return  implode(',',$value);
		return  $value;
	}
	function getfullmonthvalue(){
		return $this->loopfullmonthvalue("&quot;");		
	}
	function getfullmonthvaluehtml(){		
		return $this->loopfullmonthvalue();
	}
	function loopfullmonthvalue($quote=null){
		$value=$this->loopvalue(12,$quote);		
		$startpos = date('n');		
		$output = array_merge(array_slice($value,$startpos), array_slice($value, 0, $startpos)); 		
		if ($quote)
			return implode(',',$output);
		return $output;
	}
	function loopvalue($maxvalue,$quote=null){
		$value=array();		
		for($i=1;$i<=$maxvalue;$i++)
			array_push($value,$quote .$this->countPostsPerMonth($i).$quote);		 
		return  $value;
	}
	function countPostsPerMonth($value){
		if 	(isset($_SESSION['id']))					
			return $this->CountTable('posts','MONTH(created_at)',$value);		
		return 0;	
	}
	function getAllVisitCount($filename="counter.txt"){
		$counter_file_path = ADMIN_INCLUDES.$filename;			
		if(!is_dir($counter_file_path) && !file_exists($counter_file_path)) {
		  $file = fopen($counter_file_path, "w");
		  fwrite($file,"0");
		  fclose($file);
		}
		$file = fopen($counter_file_path,"r");
		$counterValue = fread($file, filesize($counter_file_path));
		fclose($file);
		if(!isset($_SESSION['hasVisited'])){
		  $_SESSION['hasVisited']="yes";
		  $counterValue++;
		  $file = fopen($counter_file_path, "w");
		  fwrite($file, $counterValue);
		  fclose($file); 
		}		
		return $counterValue;
	}
		function gettotalpostviews(){
			if 	(isset($_SESSION['id']))
				return $this->total('posts','views','user_id',$_SESSION["id"]);			
			return 0;
		}	
		function get_progress_points(){
			if 	(isset($_SESSION['id'])){					
					$row=$this->UsersArray();
					$points=25;
					if(!empty($row['profile_image'])){$points=$points+20;} 
					if(!empty($row['first_name'])){$points=$points+5;} 				
					if(!empty($row['last_name'])){$points=$points+5;}
					if((!empty($row['sex'])) && $row['sex']!="not mentioned"){$points=$points+2;}
					if(!empty($row['facebook'])){$points=$points+10;} 
					if(!empty($row['twitter']))	{$points=$points+10;} 
					if(!empty($row['googleplus'])){$points=$points+10;} 
					if(($row['verified']=='yes')){$points=$points+5;} 
					if(($row['hash_method']=='2')){$points=$points+5;} 
					return $points;
				}
			return 0;
		}
		function target(){			
			$target=$this->get_data('user_target','website_data');
			return $target;
		}
		function get_user_target(){		
				$users=$this->getAllUsers();
				$target=$this->target();
				if($target==0)return 0;
				$user_target=($users/$target)*100;
				return $user_target;	
		}
		function get_visitor_sources($quote="&quot;"){			
			$sources=array('chrome','firefox','safari');
			$value=array();	
			foreach ($sources as $source)
				array_push($value,$quote .$this->total("visitor_log",$source).$quote);
			return  implode(',',$value);
		}

		function show_full_month_chart(){
			$finalresponse=array(
			'labels'=>$this->getfullmonthhtml(),
			'data'=>$this->getfullmonthvaluehtml()
		);
		echo json_encode($finalresponse);
		}
}
		
?>