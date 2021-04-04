$('document').ready(function(){
  
  $('.user_form').parsley();

  $('.datacheck').on('change', function(){    
     $input=$(this);
     var object=$input.data('object');
     var send=object.toLowerCase();       
     var value=check($input,send);
    if($input.parsley().isValid())
		{
      ajaxcall(value,send,$input,object)
  }
  });
  
  $('input').on('blur', function(){
    clear($(this));	
    check($(this));    
  });
  function check(thisObj,send=null)
  {
      var value=thisObj.val();
      if (value == '') 
      {
          thisObj.parsley().reset();
          clear(thisObj);
          if(send)
            {
              window[send+'condition'] = false;         
            }         
        } 
        return value;       
  }

  function clear(thisObj,css=null,span=null){
    thisObj.siblings("span").html('');
    thisObj.parent().removeClass("form_success form_error");
    if(css) {thisObj.parent().addClass(css); }
    if (span){thisObj.siblings("span").html(span); }
  }

  function ajaxcall(value,send,$input,object){

    $.ajax({
       url:'server/main_server.php',
       method: 'POST',
       dataType:"JSON",       
       data: {'check' : 1,'data' : value, 'column':send},	      
       success: function(response){	
         if (response == 'exists' ) {          	
          clear($input,'form_error', object+" "+response+" "+ "<i class='fas fa-times checkdata'></i>");           
          window[send+'condition'] = false;           
         }else if (response == 'available') {	
          clear($input,'form_success',object+" "+response+" "+ "<i class='fas fa-check-circle checkdata'></i>");	          
          window[send+'condition'] = true; 
          
         }   
       }
    });
  }  

  $('#reg_btn').on('click', function(event){   
    if ( emailcondition==false || usernamecondition==false) {
	 $('#error_msg').html('We cannot move forward until the all the errors on the form is resolved');
   $("#error_msg").fadeTo(3500, 800).slideUp(800);
	 event.preventDefault();
   }else{    
       // proceed with form submission
	   $('#register_form').submit();
    }
  });

  
 });