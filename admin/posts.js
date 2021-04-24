
$(document).ready(function(){


	$('#add_post').click(function(){
		$('#post_form')[0].reset();
		$('#post_form').parsley().reset()
		CKEDITOR.instances.body.setData('');
		$('#publish,#anonymity').attr('checked',false);		
		$("#featured_image").prop('required', true);
		$('#action').attr('name','create-post');
		$('#modal_title').text('Create Post');
		$('#submit_button').val('Create');
		$('#action').val('create');
		$('#featured_image').removeAttr('required');					
		$('#postModal').modal('show');		
	});

	$(document).on('click', '.edit_button', function(){
		CKEDITOR.instances.body.setData('');
		$('#post_form')[0].reset();
		$('#post_form').parsley().reset();
		$('#publish,#anonymity').attr('checked',false);	
		var id = $(this).data('id');
		var url=$('#post_form').attr('action');			
		$('#submit_button').attr('disabled', false);
		$('#featured_image').removeAttr('required');
		$.ajax({
	      	url:url,
	      	method:"POST",
	      	data:{id:id, edit_post:1},
			  dataType:'JSON',			  
				complete:function(){
				$('#modal_title').text('Edit Post');
	        	$('#action').val('update').attr('name','update-post');	
	        	$('#submit_button').val('Edit');
	        	$('#postModal').modal('show');
			},
	      	success:function(data){           	
				var publish_status=data.response.published;
				if (publish_status==1) $('#publish').attr('checked',true);
				else $('#publish').attr('checked',false);
	           var anonymity_status=data.response.anonymity;
			   if (anonymity_status=="yes")$('#anonymity').attr('checked',true);
			   else $('#anonymity').attr('checked',false);
				$('#title').val(data.response.title);       	
	        	$('#post_id').val(id);
				$('#user_id').val(data.response.user_id);
				$('#created_at').val(data.response.created_at);
				$('#old_featured_image').val(data.response.image);
				$('#publish_status').val(publish_status);								
				CKEDITOR.instances.body.setData(data.response.newbody);
				$('#topic_id').val(data.status);
	      	}
	    })
	});

		

	$('#post_form').on('submit', function(event){
		for ( instance in CKEDITOR.instances )		
		CKEDITOR.instances[instance].updateElement();		
		event.preventDefault();
		var data = new FormData(this);
		var id=$('#post_id').val();		
		var action=$('#action').val();
		if($('#post_form').parsley().isValid())
		{	
			$.ajax({
				url:url,
				method:"POST",
				data:data,
				contentType:false,
				processData:false,
				dataType:"JSON",
				beforeSend:function(){					
					$('#submit_button').attr('disabled', 'disabled').val('wait...');
				},
				error:function(request)
				{  
					showMessage('<div class="alert alert-warning">there was some error in the database. Please try again later</div>')
				} ,
				complete:function(){	
					$('#submit_button').attr('disabled', false);
					$('#postModal').modal('hide');
				},
				success:function(data)
				{	var status = data.status;
					var response = data.response;
					showMessage(response)
					if (status=="success"){										
							switch(action) 
							{
								case "create":										
								$('#list').prepend(data.data);															
								break;
								case "update":								
								var row=data.data;
								$("#post_"+id).replaceWith(row);																									
								break;	     
							}		
						}
				}
			})
		}
	});
	
	
	$(document).on('click', '.action_button', function(){		
		var id = $(this).data('id');
		var action=$(this).data('action');
		var statusicon=$("#post_" + id + " .publish_status i"); 
		var statusspan=$("#post_" + id + " .publish_status span");
		var statusbutton=$("#post_" + id + " .buttons .toggle:button");				
		$.ajax({
			url:url,
	      	method:"POST",
	      	data:{id:id, action:action},
			dataType:'JSON',
	      	success:function(data)
	      	{
				var status = data.status;
				var response = data.response;
				showMessage(response)			
				if (status=="success"){
						switch(action) 
						{
							case "publish":
								statusicon.removeClass().addClass('fa fa-check btn btn-success');			
								statusbutton.attr('title','unpublish').removeClass('fa-eye btn-success').addClass('fa-times btn-warning').data('action','unpublish');
								statusspan.text('b');						
							break;
							case "unpublish":
								statusicon.removeClass().addClass('fa fa-times btn btn-danger');			
								statusbutton.attr('title','publish').addClass('fa-eye btn-success').removeClass('fa-times btn-warning').data('action','publish');
								statusspan.text('a');						
							break;
							case "delete":
								$(this).closest('tr').fadeOut('slow');
							break;	
						}	
					} 
	        }
	    });
	});
	$(document).on('click', '.delete_button', function(){
		var id = $(this).data('id');
		$row=$(this).closest('tr');
		$.confirm({
			title: 'Delete!',
			content: 'This will delete the data permanently. Proceed?',    
			buttons:{
					Yes:{      
						action: function(){
											$.ajax({
												url:url,
												method:"POST",
												data:{id:id, 'action':'delete'},
												dataType:'JSON',
												success:function(data){
													var status = data.status;
													var response = data.response;
													showMessage(response)						
													if (status=="success"){
														$row.fadeOut('slow');
													}								
												}
											});
										}	
							}
					}		
		});	
  	});
});