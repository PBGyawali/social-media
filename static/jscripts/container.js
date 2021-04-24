$(document).ready(function() {
        var hash = window.location.hash;
        check(hash);
        function check(hash){
                var array=['#login','#register','#reset_password','#homepage','#conditions','#main','#about','#contact'];
                if (hash !=null && hash!='' && jQuery.inArray(hash,array)!= -1){
                        show(hash);
                }
        }
        
        window.onhashchange = function() { 
                var hash = window.location.hash;
                check(hash);
           }
          
                $('.login_link').on('click', function(event){     
                show('#login',event);           
                });
              
                $('.register_link').on('click',function(event) {        
                show('#register',event);                 
                });
        
                $('.reset_password_link').on('click',function(event) {               
                show('#reset_password',event);           
                });
                $('.conditions_link').on('click',function(event) {           
                show('#conditions',event);           
                });
                $('.homepage_link').on('click',function(event) {                            
                show('#homepage',event);           
                });
                /* Main Navigation Clicks */
                $('.main-nav ul li a').click(function() {
                        var link = $(this).attr('href');		
                        show(link);
                });         

        function show(data,event=null){
                if(event){ event.preventDefault();}			
                $('.container, .content').hide()
                $(data+'_container').show()
                $('.main-nav ul li a').removeClass('active'); //remove active
                $('a[href="'+data+'"]').addClass('active'); // add active	
                window.location.hash=data;  
        }
        
                $('.user_form').on("submit",function(){ 
                        if($(this).parsley().isValid())
                             {
                                $button=$(this).find("button") ;
                                $button.text('Please Wait').css({"filter": "grayscale(100%)","-webkit-filter":"grayscale(100%)"});
                             }
                             
                      });
                      
        
                
 });