$(document).ready(function() 
{
		$('.progress-bar').each(function ()
		{
				$progressbar = $(this);
				max_value = $(this).attr('aria-valuemax'),
				actual_value = $(this).attr('aria-valuenow');
				if(actual_value==0)return;		
				progressbarAnimate($progressbar,max_value,actual_value);
		});
				
				
		function progressbarAnimate($progressbar,max_value,actual_value)
		{

			if (actual_value == max_value)
			{
				$('.profile_complete_status').hide();
			}
			else
				{
					time = (1000/max_value)*10,//time to take for each progress % to add in milliseconds
					initial_value=0;
						
							var progress = function() 
							{
										initial_value=initial_value+1;

										addValue = $progressbar.css('width', initial_value+'%').attr('aria-valuenow', initial_value);	

										$sronly=$progressbar.children('span.sr-only');		

										$progressvalue=$progressbar.closest('.value-indicator').siblings('.value-indicator-text').find("span.progress-value");

										$($progressvalue, $sronly).html(initial_value + '%');

										if (initial_value <= 25) 
										{
											$($progressbar).addClass("bg-danger").removeClass("bg-warning");	
										}
										if (initial_value > 25 && initial_value < 45) 
										{
											$($progressbar).removeClass("bg-danger bg-secondary").addClass("bg-warning");
										}
										if (initial_value >=45 && initial_value <= 55)
										{
											$($progressbar).removeClass("bg-info bg-warning").addClass("bg-secondary");		            
										}
										if (initial_value > 55 && initial_value < 75) 
										{
											$($progressbar).removeClass("bg-secondary bg-info").addClass("bg-primary");		            
										}
										if (initial_value >= 75 && initial_value < 85) 
										{
											$($progressbar).removeClass("bg-primary bg-success").addClass("bg-info");				
										}
										if (initial_value>85) 
										{
											$($progressbar).removeClass("bg-info").addClass("bg-success");					
										}
							
										if (initial_value >= actual_value ||initial_value >= max_value) 
										{
											clearInterval(animate);
										}				
										if (initial_value >= max_value) 
										{
											$('.profile_complete_status').hide();
										}
							};

							var animate = setInterval(function() 
							{
								progress();
							}, time);
	
	
				}
		}
		
					
				



			
			
			
});