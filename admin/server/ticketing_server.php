
<?php  include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
  include_once(ADMIN_CLASS.'katha.php');
$katha=new katha();


$error="";
if (isset($_POST['fetch_detail'])) {
    $id=$katha->clean_input($_POST['id']);    
    $detail=GetTicketById($id);      
     echo json_encode($detail);
}

if (isset($_POST['fetch_comments'])) {
    $id=$katha->clean_input($_POST['id']);    
    echo json_encode($katha->getAllArray('tickets_comments','ticket_id',$id,'','','created','ASC'));    
}

if (isset($_POST['fetch_ticket_detail'])) {
    $id=$katha->clean_input($_POST['id']);    
    $detail=GetTicketById($id);
    $comments= $katha->getAllArray('tickets_comments','ticket_id',$id,'','','created','ASC');
    $finalresponse=array(
        'detail'=>$detail,
        'comments'=>$comments
    );     
     echo json_encode($finalresponse);
}



Function GetTicketById($id){
    global $katha;
    return $katha->getArray('tickets','id',$id);   
}

Function GetAllTickets(){
    global $katha;  
    return $katha->getAllArray('tickets','','','','','created');
}



// Update status
if (isset($_POST['status']) && in_array($_POST['status'], array('open', 'closed', 'resolved','pending', 'on-hold'))) {
    $id=$katha->clean_input($_POST['id']); 
    $status=$katha->clean_input($_POST['status']); 
    $katha->UpdateDataColumn('tickets','status',$status,'id',$id);     
    echo json_encode($status);
}

  
// Output message variable
$errors = '';
// Check if POST data exists (user submitted the form)
if (isset($_POST['title'], $_POST['email'], $_POST['msg'])) {
    // Validation checks... make sure the POST data is not empty
    if (empty($_POST['title']) || empty($_POST['email']) || empty($_POST['msg'])) {
        $errors = 'Please complete the form!';
    } else if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
        $errors = 'Please provide a valid email address!';
    } else {
        $email=$katha->clean_input($_POST['email']);
        $title=$katha->clean_input($_POST['title'],'h');
        $message=$katha->clean_input($_POST['msg'],'h');
        // Insert new record into the tickets table
        $katha->insert('tickets',array('title', 'email', 'msg'),array($title, $email, $message));            
        $newid=$katha->id();
        if($newid){

            $_SESSION['message']="A new ticket has been successfully created";      
            $ticket=" <tr id='ticket_".$newid."'>".            
            "<td class='ticketstatus'>            
            <i class='far fa-envelope fa-2x text-primary open' title='OPEN'><span style='display: none;'>Abcde</span></i>
            </td>"
            ."<td class='messagebox'>
            <div class='mb-1'>"."<span class='title'>".$title."</span></div>
            <div><span class='msg bg-secondary text-white'>".$message."</span></div>
            </td>
            <td class='ticketemail'>
            ".$email."
            </td>
            <td class='ticketdate'>
        <span>".date('F dS, G:ia', time())."</span></td>
        <td>
        <button type='button' name='view_button' class='btn btn-primary btn-sm view_button' data-id='".$newid."'><i class='fas fa-eye'></i></button>
        
        </td></tr>";

        }
        else{
            $errors = 'The ticket could not be created at the moment';
        }
        
    }

    $finalresponse = array(   'ticket'=>$ticket ,'success' => $_SESSION['message'], 'error' => $errors );
      echo json_encode($finalresponse);
}
// Check if the comment form has been submitted
if (isset($_POST['usermsg']) ) {
    $id=$katha->clean_input($_POST['id']); 
    $msg=$katha->clean_input($_POST['usermsg'],'h');
 
    // Insert the new comment into the "tickets_comments" table
    $katha->insert('tickets_comments',array('ticket_id','msg'),array($id,$msg));        
    $newid=$katha->id();
    if ($newid){
        $comment= '<div id="newticketcomment_'.$newid.'">
        <div>'.
        '<i class="fas fa-comment fa-2x"></i>'.
    '</div>'.
                    
        '<span class="ticketcomments">'.$msg.'&nbsp;&nbsp;'.'<i class="fas fa-check text-success resolved"></i>'.'</span>'.
        '<p><span class="ticketcommentdate">'.date('Y-m-d, G:ia', time()).'</span></p>';
    } 
    else{
        $error='the message could not be posted at the moment'; 
    }
    
    $response=array('comment'=>$comment,'id'=>$newid, 'error'=>$error);
    
    echo json_encode($response);
}



    ?>