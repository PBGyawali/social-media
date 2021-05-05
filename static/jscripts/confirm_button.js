$(document).ready(function(){
	$('#user_form').parsley();
	var url = $('#user_form').attr('action');
	var formclass= $('#user_form').attr('class');
	$('#user_form').on('submit', function(event){		
		event.preventDefault();
		if($('#user_form').parsley().isValid())
		{							
		var data = new FormData(this);
		buttonvalue=$('#submit_button').html();
			$.ajax({
				url:url,
				method:"POST",
				data:data,
				contentType:false,
				processData:false,
				cache: false,
            	timeout: 800000,
				dataType:"JSON",
				beforeSend:function(){
					$('#submit_button').attr('disabled', 'disabled').html('wait...');					
				},				
				complete:function(){
					$('#submit_button').attr('disabled', false).html(buttonvalue);					
				},
				success:function(data){	
					$('#alert_action,#message').fadeIn().html(data.response);  
					timeout();				
					if(data.status == 'success' && formclass=='password'){
						$('#user_form')[0].reset();									
						$('.timeago').timeago('update', new Date());
					}
				}
			})
		}		
	});		
			$('.social_media_data').each(function (){
				var data= $(this).val();
				var button_id=$(this).data('id');												
				if (data == '')					
					$('#'+button_id).css({"filter": "grayscale(100%)","-webkit-filter":"grayscale(100%)"});
			});
			$("#facebook").click(function(){
				socialMedia('facebook');
			});

			$("#twitter").click(function(){
				socialMedia('twitter');
			});

			$("#google-plus").click(function(){
				socialMedia('google-plus','red');	
			});			
		
	function socialMedia($title,$color='blue'){
		$.confirm
		({
			title: $title.charAt(0).toUpperCase() + $title.slice(1),
			content:'<form action=""  id="confirm_form">' +	
					'<div class="form-input-group">'+
					'<label class="">Please enter your '+$title+ ' profile link.</label>' +   
					'<input type="text"  value="' +$('#'+$title+'_data').val()+ '" placeholder="Your link here" class="link form-control"  >'+
					' </div>' +
					'</form>' ,  
			type: $color,  
			boxWidth: '35%',   
			backgroundDismiss: false, 
			icon: 'fab fa-'+$title,    
			buttons: {
					Yes: {//also the name of the function
							text: 'Save',
							btnClass: 'btn-green',          
							action: function(){
							var link= this.$content.find('.link').val();
							if(!link)
								$('#'+$title).css({"filter": "grayscale(100%)","-webkit-filter": "grayscale(100%)"});
							else
								$('#'+$title).css({"filter": "","-webkit-filter": ""});	
							$('#'+$title+'_data').val(link);
						}        
					},
					No: {text:'Cancel',
					btnClass: 'btn-blue',			   
				}
			},		
		});
	};

});

