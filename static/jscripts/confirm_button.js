$(document).ready(function(){
	var url = $('#user_form').attr('action');
	$('#user_form').on('submit', function(e){		
		e.preventDefault();							
		var data = new FormData(this);
		// If you want to add an extra field for the FormData
		data.append("update_user", 1);
		buttonvalue=$('#submit_button').html();
			$.ajax({
				url:url,
				method:"POST",
				data:data,
				contentType:false,
				processData:false,
				dataType:"JSON",
				beforeSend:function(){
					$('#submit_button').attr('disabled', 'disabled').html('wait...');					
				},				
				complete:function(){
					$('#submit_button').attr('disabled', false).html(buttonvalue);					
				},
				success:function(data){	
					errors=data.error;					
					if(errors!='')				
						/*$.each(errors,function(i){totalerrors="<p>"+errors[i]+"</p>";});*/	
						$('.error_msg').html(errors).show().fadeTo(3500, 500).slideUp(500);								
					else
						$('#success_msg').html(data.success).show().fadeTo(2500, 500).slideUp(500);
				}
			})		
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

