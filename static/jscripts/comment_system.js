 $(document).ready(function(){
	// When user clicks on submit comment to add comment under post
	$(document).on('click', '.submit_comment', function(e) {
		e.preventDefault();
		var post_id=$(this).data('id');		
		var comment_text = $('#comment_text_'+post_id).val();		
		var url = $('.comment_form').attr('action');	
		var receiver_id=$(this).data('user_id');
		
		// Stop executing if no value is entered
		if (comment_text == "" ) return;
		$.ajax({
			url: url,
			method: "POST",
			data: {
				comment_text: comment_text,
				post_id:post_id,
				receiver_id:receiver_id,
				comment_posted: 1
			},
			dataType:"JSON",
			error:function(request)
			{          showAlert(request.responseText);    
				showAlert('There was an error in the server. Please try again');        
			} , 
			success: function(data){				
				if (data === "error") {
					showAlert('There was an error adding comment. Please try again');
				} else {										
					$('.comment_text').val(''); 										
					$('#comments-wrapper_'+post_id).prepend(data.comment);
					$('#comments_count_'+post_id).text(data.comments_count+' Comment'+(data.comments_count>1?'s':''));
					$('#comment_call_'+post_id).hide(); 
				}
			}
		});
	});

// When user clicks on edit comment
$(document).on('click', '.edit-btn', function(e){
		e.preventDefault();	
		// Get the comment id from the edit button's data-id attribute
		var comment_id = $(this).data('id');
		$edit_comment = $(this).parent();
        // grab the comment to be edited
        var comment = $(this).siblings('.comment_value').text();
		$('.comment-details').show();
        // place comment in form
		$('.reply_text').val(comment);
		$('.comment_info').show();		
		$edit_comment.hide();
		$('#profilepic_'+comment_id ).show();
		// show/hide the appropriate edit form (from the edit-btn (this), go to the parent element (comment-details)
		// and then its siblings which is a form element with id comment_reply_form_ + comment_id)
		$('.reply_form').hide();
		$('#comment_reply_form_'+comment_id).show();	
		$('.submit-reply').hide();
		$('.update-reply').show();

	$(document).on('click', '.update-reply', function(e){
		e.preventDefault();
		// elements
		var comment_id = $(this).data('id');
		$childform=$(this).parent('#comment_reply_form_'+comment_id);
		$childtext=$(this).siblings('#reply_text_'+comment_id);
		var comment_text = $childtext.val();
		var url = $(this).closest().find('form').attr('action');	
		$.ajax({
			url: url,
			method: "POST",
			data: {
				'comment_id': comment_id,
				'comment_text': comment_text,
				'edit_comment': 1
			},
			dataType:"JSON",
			error:function(request)
			{          
			  showAlert(request.responseText);        
			} , 
			success: function(data){				 
				if (data === "error") {
					showAlert('There was an error adding reply. Please try again');
					$edit_comment.show();
				} else {
					$edit_comment.replaceWith(data);
					$childtext.val('');
					$childform.hide();
					
				}
			}
		});
	});
});

	// When user clicks on submit reply to add reply under comment
	$(document).on('click', '.reply-btn', function(e){
		e.preventDefault();	
		$('.comment_info').show();	
		var comment_id = $(this).data('id');
		$('.reply-btn').show();
		$('.delete-btn').show();
		$(this).siblings('.delete-btn').hide();
		$(this).hide();	
		$('.reply_text').val('');		
		$('.reply_form').hide();
		$('#comment_reply_form_'+comment_id).toggle();
		$('.submit-reply').show();
		$('.update-reply').hide();
	
		
		$(document).on('click', '.submit-reply', function(e){
			e.preventDefault();		
			var comment_id = $(this).data('id');
			var receiver_id=$(this).data('receiver_id');
			var reply_textarea =$('#reply_text_'+comment_id); // reply textarea element
			var reply_text = reply_textarea.val();
			var url = $(this).parent().attr('action');
			$.ajax({
				url: url,
				method: "POST",
				data: {
					comment_id: comment_id,
					receiver_id:receiver_id,
					reply_text: reply_text,
					reply_posted: 1
				},
				dataType:"JSON",
				success: function(data){					 
					if (data === "error") {
						showAlert('There was an error adding reply. Please try again');
					} 
					else {
						reply_textarea.val('');
						$('.replies_wrapper_' + comment_id).append(data);
					}
				}
			});
		});
	});


// When user clicks on submit reply to add reply under comment
$(document).on('click', '.cancel-btn', function(e){
		e.preventDefault();	
		//var comment_id = $(this).data('id');	
		$('.reply_text').val('');		
		$('.reply_form').hide();
		//var div=$(this).closest('form').parent().children('.comment-details').children('.comment_info');	
		$('.comment_info').show();					
		//div.show();
		$('.reply-btn').show();	
		$('.delete-btn').show();	
	});




// When user clicks on delete reply under comment
$(document).on('click', '.delete-btn', function(e){
	e.preventDefault();
	// Get the comment id from the button's data-id attribute
	var comment_id = $(this).data('id');
	var object=$(this).data('object');
	var post_id = $('#post_id').val();
	$clickedbutton=$(this);
	$comment=$clickedbutton.parent().parent().parent();
		$.ajax({
			url: "single_post.php",
			method: "POST",
			data: {
				'comment_id': comment_id,
				'object': object,
				'post_id': post_id,
				'comment_deleted': 1
			},
			dataType:"JSON",
			beforeSend: function(){	
				$comment.fadeOut('slow');
			   },			  
			success: function(data){
				if (data.status === "error") {
					showAlert('There was an error deleting the comment. Please try again');
					$comment.show();
				} else {
					$('#comments_count_'+post_id).text(data.comments_count+' Comment'+(data.comments_count>1?'s':''));					
					$comment.remove();
					if (data.comments_count==0){
					$('#comments-wrapper').append('<h2 id="comment_call">Be the first to comment on this post</h2>');
					}
					
				}
			}
		});
	});



	function showAlert($content,$title='Error')
	{						
			   $.alert({
						   title: $title,
						   content: $content,
						   buttons: 
						   {
								   No: {
									   text:'OK',           
									   btnClass: 'btn-blue',
								   }, 
								   Yes:{
									   isHidden: true,
								   }
						   }
					   });
	   }










});
