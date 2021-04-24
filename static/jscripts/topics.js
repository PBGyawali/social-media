$(document).ready(function(){
	
		
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
			callCrudAction(action,id);	
	});

	$(document).on('click', '.delete_button', function()
	{
		var id = $(this).data('id');		
		$.confirm({
			title: 'Delete!',
			content: 'This will delete the data permanently. Proceed?',    
			buttons:{
				Yes:{
					action: function(){	
						callCrudAction('delete',id); 
					}
				}
			}
  		}); 
	});


 
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
		if (status=="danger"){
			$('#form_message').html(response);
			timeout();	
			}
		else{
			$('#topicModal').modal('hide');	
				switch(action) 
				{
					case "add":
						$("#list").append(data.data);
						updateIndex();
					break;
					case "edit":
						$("#topic_" + id + " .topic-content").html(data.data);
					break;
					case "delete":	
						$('#topic_'+id).fadeOut("slow");				
					break;
				}
				showMessage(response)
			}
	},
	});}
	
});