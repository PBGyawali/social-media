$(document).ready(function() {
	window.onhashchange = function() { 
		var hash = window.location.hash;
		check(hash);
   }

   function show(data,event=null){
	if(event){ event.preventDefault();}			
	$('.container, .content').hide()
	$(data+'_container').show()
	$('.main-nav ul li a').removeClass('active'); //remove active
	$('a[href="'+data+'"]').addClass('active'); // add active	
	window.location.hash=data;  
}

function check(hash){
var array=['#login','#register','#reset_password','#homepage','#conditions','#about','#main','#contact'];
		if (hash !=null && hash!='' && jQuery.inArray(hash,array)!= -1){
				show(hash);
		}
}

	/* Main Navigation Clicks */
	$('.main-nav ul li a').click(function() {
		var link = $(this).attr('href');		
		show(link);
	});


	
});