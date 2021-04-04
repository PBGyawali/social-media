$(document).ready(function(){

	var dataTable = $('#topic_table').DataTable({});
	var url = $('#topic_form').attr('action');	
	$('#add_topic').click(function(){
		$("#topic_name").val('');
		$('#topic_form').parsley().reset();
    	$('#modal_title').text('Add Topic');
    	$('#action').val('add');
    	$('#submit_button').val('Add');
    	$('#topicModal').modal('show');
   		});

	$(document).on('click', '.edit_button', function(){
		var topic_id = $(this).data('id');
		var topic = $("#topic_" + topic_id + " .topic-content").html();
		$('#topic_form').parsley().reset();	
		$('#topic_name').val(topic);     
		$('#modal_title').text('Edit Topic');
		$('#action').val('edit');
		$('#submit_button').val('Edit');
		$('#topicModal').modal('show');
		$('#hidden_id').val(topic_id); 
		});

		$('#topic_form').on('submit', function(event){
		event.preventDefault();
		var action=$('#action').val();
		var id=$('#hidden_id').val(); 
		if($('#topic_form').parsley().isValid())
		{	callCrudAction(action,id);	}
	});

	$(document).on('click', '.delete_button', function()
	{
		var id = $(this).data('id');		
		$.confirm
		({
			title: 'Delete!',
			content: 'This will delete the data permanently. Proceed?',    
			buttons: 
			{Yes: 
				{
					action: function()
					{	
						callCrudAction('delete',id); 
					}
				}
			}
  		}); 
	});


  updateIndex = function() {
         $('td.index').each(function(i) {
            $(this).html(i + 1);
         });
      };
	  function timeout()
	  {		
		  setTimeout(function(){
			  $('.error, .message, .alert').slideUp(500);
		  }, 3000);
		  
		  setTimeout(function(){
		  $('#message,#alert_action,#form_message').html('');
		  }, 5000);
	  }
function callCrudAction(action,id) {	
	var topic=$("#topic_name").val();	
	var queryString;
	//It is better to sanitise user input to avoid XSS attack and SQL injection
	switch(action) {
		case "add":
			queryString = 'action='+action+'&topic='+ topic;
			break;
		case "edit":
			queryString = 'action='+action+'&topic_id='+ id + '&topic='+ topic;
			break;
		case "delete":
			queryString = 'action='+action+'&topic_id='+ id;
			break;	
			        }	 

	jQuery.ajax({
	url: url,
	data:queryString,
	method: "POST",
	dataType:'JSON',
	beforeSend:function()
	{
		$('#submit_button').attr('disabled', 'disabled').val('wait...');		
	},
	success:function(data)
	{	
		$('#submit_button').attr('disabled', false);		
		var status = data.status;
		var response = data.response;
		if (status=="error"){
			$('#form_message').html('<div class="alert alert-danger">'+response+'</div>');
			timeout();	
			}
		else{			
				switch(action) 
				{
					case "add":
						$("#topic_table").append(response);
						updateIndex();
						$('#success_msg').html(status);							
						$('#topicModal').modal('hide');	
					break;
					case "edit":
						$("#topic_" + id + " .topic-content").html(response);
						$('#success_msg').html(status);	
						$('#topicModal').modal('hide');	
					break;
					case "delete":
						$('#success_msg').html(response);					
						$('#topic_'+id).fadeOut("slow");				
					break;
							
				}
				$('#topicModal').modal('hide');
				$('#success_msg').show().fadeTo(2500, 500).slideUp(500);
			}
		
			
	},
	});}
});