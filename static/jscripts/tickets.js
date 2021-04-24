$(document).ready(function(){

	$('.hiderow').click(function(){
		clickedbtn=$(this);
		var id=clickedbtn.attr('id');
		$('.hiderow').each(function ()
		{   $button=$(this);
			var id=$button.attr('id');				
			if($button.hasClass('btn-success'))				
				dataTable.$('.'+id).closest('tr').hide();		
			else			
				dataTable.$('.'+id).closest('tr').show();		
		});
		
		if(clickedbtn.hasClass('btn-success'))	
			dataTable.$('.'+id).closest('tr').show();	
		else	
			dataTable.$('.'+id).closest('tr').hide();
		
		$('.showonly').removeClass('btn-success');	
		clickedbtn.toggleClass('btn-success');	
	});

	$('.showonly').click(function(){	
		var id=$(this).data('id');
		$('.showonly, .hiderow').removeClass('btn-success');	
		$(this).addClass('btn-success');
		dataTable.$('tr').show();		
		dataTable.$('.'+id).closest('tr').siblings().hide();
		dataTable.$('.'+id).closest('tr').show();
	});

	$('.reset').click(function(){
		$('.showonly, .hiderow').removeClass('btn-success');
		dataTable.$('tr').show();
	});
	

	$('#add_ticket').click(function(){
		$('#ticket_form')[0].reset();
		$('#ticket_form').parsley().reset();
    	$('#modal_title').text('Add Ticket');
    	$('#action,#submit_button').val('Add');    	
    	$('#ticketModal').modal('show');
    	$('#append_ticket,#form_message').html(''); 
	});

	var count_comment = 0;

	$(document).on('click', '#add_comment', function(){
		count_comment++;
		var html = `		
		<div class="row mt-2" id="comment_`+count_comment+`">
			<label class="col-md-4">&nbsp;</label>
			<div class="col-md-6">
				<input type="text" name="ticket_comment[]" class="form-control ticket_comment" required data-parsley-pattern="/^[a-zA-Z0-9]+$/"  data-parsley-trigger="keyup" />
			</div>
			<div class="col-md-2">
				<button type="button" name="remove_comment" class="btn btn-danger btn-sm remove_comment" data-id="`+count_comment+`">-</button>
			</div>
		</div>
		`;
		$('#append_comment').append(html);
	});

	$(document).on('click', '.remove_comment', function(){
		var button_id = $(this).data('id');
		$('#comment_'+button_id).remove();
	});

	$('#ticket_form').on('submit', function(event){
		event.preventDefault();			
		var data = new FormData(this);		
		if($('#ticket_form').parsley().isValid())
		{		
			$.ajax({
				url:url,
				method:"POST",
				data:data,
				contentType:false,
				processData:false,
				cache: false,
				dataType:"JSON",
				beforeSend:function()
				{
					$('#submit_button').attr('disabled', 'disabled').val('wait...');					
				},
				complete:function(){
				$('#submit_button').attr('disabled', false).val('Add');				
				$('#ticketModal').modal('hide');                 
				},
				success:function(data)
				{
					showMessage(data.response);				
					if(data.status== 'success')									
						$('#list').prepend(data.data);
				}            										
					
			})
		}
	});


//ticketview

$(document).on('click', '.view_button', function(){
		  var id = $(this).data('id');		
		  var date = $("#ticket_" + id + " .ticketdate span").text();
		  var email=$("#ticket_" + id + " .ticketemail").text();
		  var title=$("#ticket_" + id + " .messagebox .title").text();
		  var message=$("#ticket_" + id + " .messagebox .msg").text();
		  var statusicon=$("#ticket_" + id + " .ticketstatus i");
		  var status=statusicon.attr('title');		  	  
		  $('#statusview').removeClass().text('('+status+')'); 		  
		  $('#messageview').text(message);
		  $('#titleview').text(title);		  
		  $('#dateview').text(date);
		  $('#emailview').text(email);		  
		  $('.status_button').data('id',id);
		  $('#allcomments').empty();
		  $('#ticketcommentid').val(id);
		  $('#viewticketModal').modal('show');
		  $('.comments_view').show();

		  var status_class=['success','warning','danger','secondary','primary'];
		  var status_type=['resolved','on-hold','pending','closed','open'];	
		  $.each(status_type, function(i, e) {
			  if(status==status_type[i]){
				  $('#statusview').addClass('text-'+status_class[i]);
				  return false;
			  }			   
		})	
		$.ajax({
			url:url,
			method:"POST",
			data:{	id:id,	fetch_ticket_detail:1},
			dataType:'JSON',
			complete:function(){				  
				$('.comments_view').hide();
			},
			success:function(data){				  
				$('#messageview').text(data.comment);
				comments=data.comments;
				$.each(comments, function(key, value){
					var comment= '<div>'+
						'<i class="fas fa-comment fa-2x"></i>'+
					'</div>'+								
						'<span class="ticketcomments">'+value.msg+'</span>'+
						'<p><span class="ticketcommentdate">'+value.created+'</span></p>';					
						$('#allcomments').append(comment);					
				});
			}
		});//ajax end
	});//view button end
 
	$(document).on('click', '.status_button', function(){
		  var id = $(this).data('id');
		  var status=$(this).data('status');
		  var statusicon=$("#ticket_" + id + " .ticketstatus i"); 		  
		 $.ajax({
		url:url,
		method:"POST",
		data:{id:id,status:status},
		dataType:'JSON',
		success:function(data)	{			
			var status_class=['success','warning','danger','secondary','primary'];
			var status_type=['resolved','on-hold','pending','closed','open'];
			var status_icon=['check','pause-circle','clock','times','envelope-open'];	
			$.each(status_type, function(i, e) {
				if(data==status_type[i]){	
					$('#statusview').removeClass().addClass('text-'+status_class[i]).text('('+status_type[i]+')');					
					statusicon.removeClass().addClass(status_type[i]+' fas fa-'+status_icon[i]+' fa-2x text-'+status_class[i] ).attr('title',status_type[i]);
					return false;
				}			   
		})
		}
	  })   //ajax end  
	});//status button end
	
	

$('#comment_form').on('submit', function(event)
{
	event.preventDefault();
	if($('#comment_form').parsley().isValid())
	{		
		var ticketid=$('#ticketcommentid').val();		
		var msg=$('#ticketcomments').val();		
		var r='<div id="newticketcomment_'+1+'">'+
		'<div>'+
			'<i class="fas fa-comment fa-2x"></i>'+
		'</div>'+						
			'<span class="ticketcomments">'+msg+'  '+'<i class="fas fa-clock text-warning"></i>'+
			'<p><span class="ticketcommentdate">'+'</span></p></div>';
				         
		$.ajax({
			url:url,
			method:"POST",
			data:{usermsg:msg, id:ticketid},
			dataType:"JSON",
			beforeSend:function()
			{
				$('#allcomments').append(r);				
			},		
				success:function(data)
			{   				
				$('#newticketcomment_'+1).remove();
				$('#allcomments').append(data.comment);					
			},
			complete:function()
			{				
				$('#ticketcomments').val('');
				$('#comment_form').parsley().reset();				
			},
			
		})
	}
});


});