$(document).ready(function(){
	
	$('#add_user').click(function(){		
		$('#user_form')[0].reset();
		$('#user_form').parsley().reset();
		$('#modal_title').text('Add New User');		
    	$('#action').attr('name','reg_admin');		
    	$('#submit_button').val('Add');			
		$('#password_section').show();		
		$('#action').val('add');			
		$('#userModal').modal('show');		
	});
	$(document).on('click', '.edit_button', function(){
		$('#user_form').parsley().reset();
		  var id = $(this).data('id');		 		  
		  var username=$("#userlist_"+id+" .username").text();
		  var email=$("#userlist_"+id+" .email").text();		  
		  var first_name=$("#userlist_"+id+" .full_name span.first_name").text();
		  var last_name=$("#userlist_"+id+" .full_name span.last_name").text();
		  var user_type=$("#userlist_"+id+" .user_type").text();		  
		   $('#username').val(username);
		  $('#email').val(email);		  
		 $('#first_name').val(first_name);
		  $('#last_name').val(last_name);
		  $('#user_type').val(user_type);
		  $('#action').attr('name','update_user');
		  $('#hidden_id').val(id);
		  $('#modal_title').text('Edit Data');		 
	      $('#submit_button').val('Edit');
		  $('#password_section').hide();
	      $('#userModal').modal('show');
		  $('#action').val('edit');
	});
	
	$('#user_form').on('submit', function(event){
	event.preventDefault();	
	var data = new FormData(this);
	var action= $('#action').val();
	var id=$('#hidden_id').val();	
	if($('#user_form').parsley().isValid())
	{			
		$.ajax({
			url:url,
			method:"POST",
			data:data,
			contentType:false,
			processData:false,
			dataType:"JSON",
			beforeSend:function()
			{
				$('#submit_button').attr('disabled', 'disabled').val('wait...');								
			},				
			complete: function()
			{			  
			  $('#submit_button').attr('disabled', false);
			  $('#userModal').modal('hide');
			},
			success:function(data)
			{	
				var status = data.status;
				showMessage(data.response)
				if (status=="success"){	
						var row=data.data
						dataTable.destroy()	
						switch(action) 
						{
							case "add":								
							$("#list").prepend(row);							
							break;
							case "edit":									
							$("#userlist_"+id).replaceWith(row);
							updateIndex();		
							break;	     
						}
					}
				maketable()
			}
		});
	}
});

$(document).on('click', '.verify_button', function(){
	var id = $(this).data('id');
	$('#hidden_verify_id').val(id);
	$('#verify_button').attr('disabled', false);
	$('#verifyModal').modal('show');
});
$('#verify_form').on('submit', function(event){
	event.preventDefault();	
	var data = new FormData(this);
		$.ajax({
			url:url,
			method:"POST",
			data:data,
			dataType:"JSON",
			processData: false,
			contentType: false,
			beforeSend:function()
			{
				$('#verify_button').attr('disabled', 'disabled').val('wait...');	
				$('#verifyModal').modal('hide');		
			},				
			complete: function(){
			  $('#verify_button').attr('disabled', false);			  
			},
			success:function(data){	
				showMessage(data.response)
			}
		});
	
});

	
$(document).on('click', '.delete_button', function(e) 
{
	var id = $(this).data('id');
	$clicked_btn = $(this);
	var user_type=$clicked_btn.closest('tr').find('.user_type').text();
	var profile_image=$clicked_btn.closest('tr').find('img').data('src');	
	var username=$clicked_btn.closest('tr').find('.username').text();
	$.confirm
	({
		title: 'Delete!',
		content: 'This will delete the data permanently. Proceed?',    
		buttons: {
			Yes:{      
				action: function(){				 
					$.ajax({
						url:url,
						method: 'POST',
						dataType:"JSON",    
						data:{
								id:id,username:username,user_type:user_type,
								profile_image:profile_image,delete:1
						},
						success: function(data)	{	
							var status=data.status;
							showMessage(data.response)							
							if (status=="success")
								$clicked_btn.closest('tr').fadeOut("slow");
						}//ajax success function ends here
					});//ajax call ends here
				}
        	},
    	}
	});	
});	//confim box ends here

  	$(document).on('click', '.view_button', function(){
		  var id = $(this).data('id');
		  //var src = $('#profile_image').attr("src"); 
		  //var path = src.substring(0,src.lastIndexOf('/')); // get the path from the src 		 
         // var new_path=path+'/';
		 $('#detail_submit_button').val('Save');
		 $('#detail_modal_title').text('User details');								
		 $('#detail_submit_button').removeClass('btn-danger').addClass('btn-success');		 	
		 $('#remarks_div').siblings().show();
  		 $.ajax({
  			url:url,
			  method:"POST",			 
	      	data:{id:id, fetch_detail:1},
	      	dataType:'JSON',
			  complete:function() {					    		
				$('#detailModal').modal('show');
				$('#detail_hidden_id').val(id);
				$('#detail_action').attr('name','update_status');
	      	},
	      	success:function(data)
			  {   var profile_image=data.response.profile_image;
				  if((profile_image==null)){profile_image='user_profile.png';}
				var newSrc = data.data+profile_image; 				
				$('#profile_image').attr('src',newSrc);  
	      		$('#username_detail').text(data.response.username);
	      		$('#email_detail').text(data.response.email);
	      		$('#name_detail').text(data.response.first_name+" "+data.response.last_name);
				$('#user_type_detail').text(data.response.user_type);
				$('#user_status_detail').text(data.response.user_status);
				$('#facebook').text(data.response.facebook);
				$('#twitter').text(data.response.twitter);
				$('#googleplus').text(data.response.googleplus);
				$('#remarks').text(data.response.remarks); 
	      	}
		  })
		  

  	$('#details_form').on('submit', function(event){
		  event.preventDefault();
  		  if($('#details_form').parsley().isValid())
		  {		
			$.ajax({
				url:url,
				method:"POST",
				data:$(this).serialize(),
				dataType:'JSON',
				beforeSend:function(){
					$('#detailModal').modal('hide');
				},
				success:function(data){
					showMessage(data.response);					
				}
			});
		  }
  	});
});
	  

	$(document).on('click', '.disable_button', function(){
		var id = $(this).data('id');
		$clicked_btn = $(this);
		var status_indicator=$clicked_btn.closest("tr").find('td.status');
		var current_status=status_indicator.text();		
		var change_status="Disable";
		if (current_status=="Disable")
		change_status="Enable"
		$.confirm({
				title:change_status+' Account!',
				content: 'This will '+change_status+ ' the account. Proceed?',    
				buttons: {
					Yes: {//name of the function              
						action: function(){
							$('#action_modal_title').text(change_status+' User');						
							if (change_status=="Disable")
								$('#action_submit_button').removeClass('btn-success').addClass('btn-danger');
							else
								$('#action_submit_button').addClass('btn-success').removeClass('btn-danger');							$('#action_submit_button').val(change_status);	
							$('#action_remarks_div').siblings().hide();							
							$('#actionModal').modal('show');
							$('#action_submit_button').on('click', function(event){
							var remarks=$('#action_remarks').val();
								event.preventDefault();				
								$.ajax({
									url:url,
									method:"POST",
									data:{id:id, remarks:remarks,
										update_status:1,user_status:change_status
									},
									dataType:'JSON',
									beforeSend: function(){		
										$('#actionModal').modal('hide');		
									},
									success: function(data){
										var status=data.status;
										var response=data.response;	
										showMessage(response)				
										if (status=="success"){
													switch(change_status){
														case "Disable":
															$clicked_btn.removeClass("btn-warning fas fa-ban").addClass("btn-success fas fa-unlock-alt");										
														break;
														case "Enable":
															$clicked_btn.removeClass("btn-success fas fa-unlock-alt").addClass(" btn-warning fas fa-ban");																	
														break;
													}
													status_indicator.text(change_status);
											}								
									}//ajax complete function ends here				
								});//ajax call ends here
							});
						}//action call ends here
					},//yes button ends here
				}//button ends here
		});//confirm box ends here
  	});
  
	$(document).on('click', '.reset_button', function(){		
		var id = $(this).data('id');
		$clicked_btn = $(this);
		var url=$('#actionModalurl').val();
		$.confirm({
				title: 'Reset Password!',
				content: 'This will reset the profile account password. Proceed?',      
				buttons:{
						Yes:{//name of the function             
							action: function(){				 
								$.ajax({
									url: url,
									method: 'POST',
									data: {	'reset': 1,'sel_record': id	}, 
									dataType:'JSON',
									success: function(data){
										showMessage(data.response)
									}//ajax complete function ends here
								});//ajax call ends here
							}//action call ends here
						},//yes button ends here
				}//button ends here
		});//confirm box ends here
	});//button click function ends here

  	

  

});