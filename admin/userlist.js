$(document).ready(function(){
	
	var dataTable = $('#list').DataTable( {"order" : [] } );
	$('#user_form').parsley();
	var url=$('#user_form').attr('action');	

	$('.toggle').on( 'click', function (e) 
	{		var column = table.column( $(this).attr('data-column') );		
			column.visible( ! column.visible() );
	} );
	
	updateIndex = function() {
         $('td.index').each(function(i) {
            $(this).html(i + 1);
         });
      };
	  //var dataTable=load_data();
	function load_data(from_date = '', to_date = '')
	{
		var dataTable = $('#list').DataTable({
			"processing" : true,
			"serverSide" : true,
			"order" : [],
			"ajax" : {
				url:"server/useraction_server.php",
				type:"POST",
				data:{action:'fetchall', from_date:from_date, to_date:to_date}
			},			
		});
		return dataTable;
	}

	$('#add_user').click(function(){		
		$('#user_form')[0].reset().parsley().reset();
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
			  $.unblockUI();
			  $('#submit_button').attr('disabled', false);
			  $('#userModal').modal('hide');
			},
			success:function(data)
			{
				var status = data.status;
				var response = data.response;
				if (status=="error")				
					$('#error_msg').html(response).show().fadeTo(2500, 500).slideUp(500);
				else{
						var row=data.data
						$('#success_msg').html(response).show().fadeTo(2500, 500).slideUp(500);						
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
			}
		});
	}
});


	
$(document).on('click', '.delete_button', function(e) 
{
	var id = $(this).data('id');
	var url=$('#user_form').attr('action');	
	$clicked_btn = $(this);
	var user_type=$clicked_btn.closest('tr').find('.user_type').text();
	var profile_image=	$clicked_btn.closest('tr').find('img').data('src');	
	var username=$clicked_btn.closest('tr').find('.username').text();
	$.confirm
	({
		title: 'Delete!',
		content: 'This will delete the data permanently. Proceed?',    
		buttons: 
		{
			Yes: 
			{      
				action: function()
				{				 
					$.ajax
					({
						url:url,
						method: 'POST',
						dataType:"JSON",    
						data:{
							id:id,
							username:username,
							user_type:user_type,
							profile_image:profile_image,
							delete:1
						},								
						beforeSend: function()
						{							
							$.blockUI
							({ message: '<h1><i class="fa fa-spinner fa-pulse "></i> Just a moment...</h1>', css: 
								{ 
									border: 'none', padding: '15px',  backgroundColor: '#000',  '-webkit-border-radius': '10px', 
									'-moz-border-radius': '10px',   opacity: .5,  color: '#fff' 
								} 
							});
						},
						complete: function()
						{
							$.unblockUI();
						},
						success: function(data)
						{
							$.unblockUI();
							var status=data.status;
							var response=data.response;							
							if (status=="error")							
								$('#error_msg').html(response).show().fadeTo(3500, 500).slideUp(500);							
							else
							{
								$clicked_btn.closest('tr').fadeOut("slow");
								$('#success_msg').html(response).show().fadeTo(3500, 500).slideUp(500);	
							}	
								
						}//ajax success function ends here
					});//ajax call ends here

				}
        	},
       
    	}
	});	
});	//confim box ends here

	

  	$(document).on('click', '.view_button', function(){
		  var id = $(this).data('id');
		  var url=$('#user_form').attr('action');		 
		  var src = $('#profile_image').attr("src"); 
		  var path = src.substring(0,src.lastIndexOf('/')); // get the path from the src 		 
          var new_path=path+'/';
		 $('#detail_submit_button').val('Save');
		 $('#detail_modal_title').text('User details');								
		 $('#detail_submit_button').removeClass('btn-danger').addClass('btn-success');		 	
		 $('#remarks_div').siblings().show();
  		 $.ajax({
  			url:url,
			  method:"POST",			 
	      	data:{id:id, fetch_detail:1},
	      	dataType:'JSON',
			  complete:function(data) {					    		
				$('#detailModal').modal('show');
				$('#detail_hidden_id').val(id);
				$('#detail_action').attr('name','update_status');
	      	},
	      	success:function(data)
			  {   var profile_image=data.detail.profile_image;
				  if((profile_image==null)){profile_image='user_profile.png';}
				var newSrc = new_path+profile_image; 				
				$('#profile_image').attr('src',newSrc);  
	      		$('#username_detail').text(data.detail.username);
	      		$('#email_detail').text(data.detail.email);
	      		$('#name_detail').text(data.detail.first_name+" "+data.detail.last_name);
				$('#user_type_detail').text(data.detail.user_type);
				$('#user_status_detail').text(data.logs.user_status);
				$('#facebook').text(data.detail.facebook);
				$('#twitter').text(data.detail.twitter);
				$('#googleplus').text(data.detail.googleplus);
				$('#remarks').text(data.logs.remarks); 
	      	}
		  })
		  

  	$('#details_form').on('submit', function(event){
		  event.preventDefault();
		  var id=$('#detail_hidden_id').val();
		  var url=$('#user_form').attr('action');		  
  		  if($('#details_form').parsley().isValid())
		  {		
			$.ajax
			({
				url:url,
				method:"POST",
				data:$(this).serialize(),
				beforeSend:function()
				{
					$('#detail_submit_button').attr('disabled', 'disabled');
					$('#detail_submit_button').val('wait...');
				},
				complete:function()
				{
					$('#detail_submit_button').attr('disabled', false);
					$('#detail_submit_button').val('Save');					
				},
				success:function(data)
				{
					$('#detailModal').modal('hide');
					$('#success_msg').html("The profile was successfully updated").show().fadeTo(2500, 500).slideUp(500);					
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
		if (current_status=="Disabled")
		change_status="Enable"
		var new_status=change_status+"d";	
		$.confirm({
				title:change_status+' Account!',
				content: 'This will '+change_status+ ' the account. Proceed?',    
				buttons: {
					Yes: {//name of the function              
						action: function(){
							$('#action_modal_title').text(change_status+' User');						
							if (change_status=="Disable"){
								$('#action_submit_button').removeClass('btn-success').addClass('btn-danger');}
							else
								$('#action_submit_button').addClass('btn-success').removeClass('btn-danger');							
							$('#action_update_detail').val(new_status);							
							$('#action_submit_button').val(change_status);									
							$('#action_hidden_id').val(id);							
							$('#action_remarks_div').siblings().hide();							
							$('#actionModal').modal('show');
							$('#action_submit_button').on('click', function(event){
								var id=$('#action_hidden_id').val();
								var url=$('#actionModalurl').val();
								var remarks=$('#action_remarks').val();
								var c=$('#action_update_detail').val();
								event.preventDefault();				
								$.ajax({
									url:url,
									method:"POST",
									data:{
										id:id, 
										remarks:remarks,
										update_status:1,
										user_status:new_status
									},
									dataType:'JSON',
									beforeSend: function()
									{		
										$('#actionModal').modal('hide');									
										$.blockUI
										({ 
											message: '<h1><i class="fa fa-spinner fa-pulse "></i> Just a moment...</h1>', css: 
											{ 
												border: 'none', 
												padding: '15px', 
												backgroundColor: '#000', 
												'-webkit-border-radius': '10px', 
												'-moz-border-radius': '10px', 
												opacity: .5, 
												color: '#fff' 
											} 		
										});
									},						
									complete: function(){
										$.unblockUI();
									},
									success: function(data){
										$.unblockUI();						
										var status=data.status;
										var response=data.response;							
										if (status=="error"){
												$('#error_msg').html(response);					
												$('#error_msg').show();					
												}
												else{
													switch(response){
														case "Disabled":
															$clicked_btn.removeClass("btn-warning fas fa-ban").addClass("btn-success fas fa-unlock-alt");										
															status_indicator.text(new_status);
														break;
														case "Enabled":
															$clicked_btn.removeClass("btn-success fas fa-unlock-alt").addClass(" btn-warning fas fa-ban");																	
														break;
													}
													status_indicator.text(new_status);
													$('#success_msg').html('The profile was successfully '+new_status).show();
											}
											$('#error_msg,#success_msg').fadeTo(2500, 500).slideUp(500);								
									}//ajax complete function ends here				
								});//ajax call ends here
							});
						}//action call ends here
					},//yes button ends here
				}//button ends here
		});//confirm box ends here
  	});

	  
	  
  
	$(document).on('click', '.reset_button', function()
	{		
		var id = $(this).data('id');
		$clicked_btn = $(this);
		var url=$('#actionModalurl').val();
		$.confirm
		({
				title: 'Reset Password!',
				content: 'This will reset the profile account password. Proceed?',      
				buttons: 
				{
						Yes: 
						{//name of the function             
							action: function()
							{				 
								$.ajax
								({
									url: url,
									method: 'POST',
									data: {	'reset': 1,'sel_record': id	}, 
									beforeSend: function()
									{		
										// Show image container loader image has still not been added
										$.blockUI
										({ 
												message: '<h1><i class="fa fa-spinner fa-pulse "></i> Just a moment...</h1>', css: 
											{ 
												border: 'none', 
												padding: '15px', 
												backgroundColor: '#000', 
												'-webkit-border-radius': '10px', 
												'-moz-border-radius': '10px', 
												opacity: .5, 
												color: '#fff' 
											} 
										});
									},
									complete: function()
									{
										$.unblockUI();
										$('#success_msg').html('The profile password reset was successfull').show();
										$('#error_msg,#success_msg').fadeTo(2500, 500).slideUp(500);
									}//ajax complete function ends here
													
								});//ajax call ends here

							}//action call ends here
						},//yes button ends here
				
				}//button ends here
		});//confirm box ends here


	});//button click function ends here


  	$('#filter').click(function(){
  		var from_date = $('#from_date').val();
  		var to_date = $('#to_date').val();
  		$('#list').DataTable().destroy();
  		load_data(from_date, to_date);
  	});

  	$('#refresh').click(function(){
  		$('#from_date').val('');
  		$('#to_date').val('');
  		$('#list').DataTable().destroy();
  		load_data();
  	});

  	$('#export').click(function(){
		  var url=$(this).data('url');
  		var from_date = $('#from_date').val();
  		var to_date = $('#to_date').val();

  		if(from_date != '' && to_date != '')
  			window.location.href=url+"export.php?from_date="+from_date+"&to_date="+to_date+"";
  		else
  			window.location.href=url+"export.php";
  	});



	

});