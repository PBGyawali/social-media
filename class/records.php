<?php  
class records extends publicview{
	public $user_id;		
	private $message;
    public function __construct(){
		parent::__construct();		
		$this->user_id = (isset($_SESSION['id'])?$_SESSION['id']:'');  
	}

	function setUserId($user_id){
		$this->user_id = $user_id;
	}	

	function setMessage($message){
		$this->message = $message;
	}	
	
	function get_user_data_by_id(){
		return $this->getArray('users','user_id',array($this->user_id));
	}

	function get_user_all_data(){
		$join=array('LEFT JOIN'=>array('userlogs'=>"users.id = userlogs.user_id"));
		return  $this->getAllArray('users','','','','','users.id','DESC',$join,'');		
	}

	function save_chat($user_id=1){
		$this->insert('offline_messages',array('user_id','sender_id','message'),
		array($user_id,$this->user_id,$this->message));			
	}

function allConversation(){	
	return $this->get_conversation();
}
function allOfflineMessages(){	
		return $this->get_messages();
}
function allunseenOfflineMessages(){
	$data['debug']=true;
	//return $this->get_messages('3','','DESC',$data);
		return $this->get_messages(3);
}

function get_all_chat_data($user_id=self::user_id){
	$userid=$this->user_id;
	if($user_id)
	$userid=$user_id;
	$join=array('LEFT JOIN'=>array('users'=>'users.id = offline_messages.user_id') );
	 $messages=$this->getAllArray(
		'offline_messages',  
		array('(offline_messages.user_id','offline_messages.sender_id','offline_messages.user_id','offline_messages.sender_id'),
	   array($this->user_id,$userid,$userid,$this->user_id),
	   array(' AND ',' ) OR (',' AND ',' )'),'','offline_messages.sent_on','ASC',$join);			
	return $this->getextradata($messages);
}

function get_conversation($order='ASC',$limit=null){
	if 	($this->is_user()){						
		$messages =$this->getAllArray('offline_messages',array('user_id','sender_id'),
		array($this->user_id,$this->user_id),'OR',$limit,'sent_on',$order);
		return $this->getextradata($messages);
	}		
   return null;
}
function get_messages($limit=null,$archive=NULL,$order='DESC',$data=array()){
	if 	($this->is_user()){
		$where=$condition=array();
		if($archive){
			$where="  archive ";
			$condition[]=$archive;
		};
		$condition[]=$this->user_id;
		$condition[]=$this->user_id;
		$attr=array('debug'=>true,
            'groupby'=>'user_id,sender_id',
            'fields'=>'user_id,sender_id,MAX(sent_on) AS recent_date'
			);
		$join=array('JOIN('=>$this->getAllArray('offline_messages',	
						array('offline_messages.user_id','offline_messages.sender_id'), 
						array($this->user_id,$this->user_id), 'OR','','','','',$attr) 
  			  		,' ) AS'=>array(' Latest '=>
                      array('offline_messages.sent_on = Latest.recent_date ',' offline_messages.user_id=Latest.user_id','
                      offline_messages.sender_id=Latest.sender_id')),            
    			  'LEFT JOIN'=>array('message_log '=>
                      array('offline_messages.user_id=message_log.user_id ','offline_messages.sender_id=message_log.sender_id')),
			);
		$messages=$this->getAllArray('offline_messages',$where , $condition, '',$limit,'offline_messages.sent_on',$order,$join,$data);
		if(isset($data['debug']))
		return $messages;
		return $this->getextradata($messages);
	}		
   return null;
}

function getextradata($messages){
	$final_messages = array();
		foreach ($messages as $message) {
			$sender_id=$message['sender_id'];
			if($message['sender_id']==$this->user_id)
			$sender_id=$message['user_id'];			
			$message['username'] = $this->UserNameById($message['sender_id']);
			$message['profile_image'] =$this-> ProImageById($sender_id);
			array_push($final_messages, $message);
		}
		return $final_messages;
}

    function MessageCount(){	
		if 	($this->is_user())
			return $this->CountNumbers('offline_messages',$this->user_id);
		return null;        
	}   
	function allunreadalerts(){
		return $this->get_alerts('no',5);           
    }
    function allalerts(){
		return $this->get_alerts();           
	}
	
	function get_alerts($read=NULL,$limit=null){
		$value=array($this->user_id);		
		$column=array('user_id');
		if($read){			
			array_push($column,'read_by_user');
			array_push($value,$read);	
		}	
		if 	($this->is_user())
			return $this->getAllArray('alerts',$column,$value,'AND',$limit,'alert_date');
		return null;           
    }

	function AlertCount(){
		if 	($this->is_user())		
			return $this->CountNumbers('alerts',$this->user_id);		
		return null;		
	}
    
	function useractivitylogs(){
		if 	($this->is_user())		
			return  $this->getAllArray('activity_log','user_id', $this->user_id,'','','id');
		return null;
	}

	function CountNumbers($table,$user_id){
		return $this->CountTable($table,array('user_id','read_by_user'),array($user_id,'no'));	
	}
	
	function UserNameById($user_id){
		return $this->get_data('username','users','id='.$user_id);	
	}
	
	function ProImageById($user_id){
		return $this->Get_profile_image($user_id);	   
	}


	function update_read_status($id,$table){
		if 	($this->is_user()){
			$result=$this->UpdateDataColumn($table,'read_by_user','yes',array('user_id','id'),array($this->user_id,$id));	
			$row=$this->CountNumbers($table,$this->user_id);
			if ($result)
				return $row;
			else 
				return null;
		}
		return null;	
	}

	// delete message
function deleterecord($message_id,$table='offline_messages'){
	return $this->Delete($table,'id',$message_id);
}

// if user clicks the Delete message button
function delete_message($posted){
	$message_id = $this->clean_input($posted['id']);
	$this->deleterecord($message_id);
}

function request($posted){
	$table=' alerts ';
	if(isset($posted['table']) && !empty($posted['table']))
	$table=' '.$posted['table'].' ';	
	$request=$posted['request'];
	$id=$posted['id'];
	$type=$posted['type'];
	if 	(!$this->is_user())
		return;
switch($request){
	case 'delete':		
		$this->deleterecord($id,$table);
    break; 
	case 'read':
		$this->UpdateDataColumn($table,'read_by_user','yes',array('id','type'),array($id,$type));
	break;
	case 'delete_similar':
		$this->Delete($table,array('user_id','type'),array($this->user_id,$type));
	break;
}	
if($table==' alerts ')
	echo json_encode($this->AlertCount());
	else echo json_encode('');	
}	
	function message($posted){
		$request=$posted['message'];
		$id=$posted['id'];
		$sender_id=$posted['sender_id'];
		if 	(!$this->is_user())
		return;
	switch($request){
		case 'delete':		
			$this->deleterecord($id);
		break;
		 case'deleteall':
			$this->Delete('offline_messages',array('user_id','sender_id'),array($this->user_id,$sender_id));
			$this->Delete('message_log',array('user_id','sender_id'),array($this->user_id,$sender_id));
		break;

		case 'read':
		$this->UpdateDataColumn('offline_messages','read_by_user','yes','id',$id);
		break;
		case 'notification':
			$this->UpdateDataColumn('message_log','notification','off',array('user_id','sender_id'),array($this->user_id,$sender_id));			
		break;
		case 'archive':
			$this->UpdateDataColumn('message_log','archive','yes',array('user_id','sender_id'),array($this->user_id,$sender_id));		
		break;
	}
	echo json_encode($this->MessageCount());
	}

	function user_message($posted){
		$message=$posted['text'];
		$receiver_id=$posted['receiver_id'];
		$sender_id=$posted['sender_id'];
		$image=$posted['image'];
		$username=$posted['username'];
			$this->insert('offline_messages',array('user_id','sender_id','message'),array($receiver_id,$sender_id,$message));
			$inserted_id=$this->id();
			$datetime=$this->get_datetime();
			$chat_msg='<div id="sentusermessage_'.$inserted_id.'">
			<div>
			<img src="'.$image.'" class="rounded-circle mb-0 mt-0" height="30" width="30"> '. $username.':
			</div>					
			<span class="usermessage">'.$message.'&nbsp;&nbsp;'.'<i class="fas fa-check text-success resolved"></i></span>
			<p><span class="ticketcommentdate"><time class="chattimeago"" datetime="'.$datetime.'">'.$datetime.'</time></span></p>';
			
			echo json_encode($chat_msg);
			$attr=array('ignore'=>true);
			$this->insert('message_log',array('user_id','sender_id'),array($receiver_id,$sender_id),$attr);		
	}

}

                                                                
?>