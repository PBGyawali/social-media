</body>
</html>

<script type="text/javascript" src="<?php echo JS_URL?>jquery.min.js"></script> 
<script type="text/javascript" src="<?php echo JS_URL?>container.js"></script>
<script type="text/javascript" src="<?php echo JS_URL?>parsley.min.js"></script>	  
<script type="text/javascript" src="<?php echo JS_URL?>popper.min.js"></script>	
<script type="text/javascript" src="<?php echo JS_URL?>password_strength.js"></script>
<script type="text/javascript" src="<?php echo JS_URL?>live_register.js"></script>
<script type="text/javascript" src="<?php echo JS_URL?>toggle_password.js"></script>
<script type="text/javascript" src="<?php echo JS_URL?>tilt.jquery.min.js"></script>
<script src="<?php echo JS_URL?>jquery.cookieBar.js"></script>
<div id="wrapper">
        <div class="blocker"></div>
        <div  class="bg-dark text-white text-center py-0 px-2 pb-0 mb-0" id="popup" style="border-radius:4px;font-size: 16px;display:none;">
            <p class="text-danger py-0 my-0">For owner login
            <p class="py-0 my-0">username: puskar
            <p class="py-0 my-0">password: philieep<p>
            <p class="text-danger py-0 my-0">For admin login
            <p class="py-0 my-0">username: prakhar
            <p class="py-0 my-0">password: philieep </p>  
            <p  class="text-danger py-0 my-0 ">For author login
            <p class="py-0 my-0">username: gyawali
            <p class="py-0 my-0">password: 123456<p>   
            <p class="text-danger py-0 my-0">For user login
            <p class="py-0 my-0">username: puskar
            <p class="py-0 my-0">password: philieep</p>            
            <p class="text-danger py-0 my-0">For guest login
            <p class="py-0 my-0">Just press login as guest button<p>                     
        </div>
        <div class="blocker"></div>        
</div>
<script>
        setTimeout(function(){
                    $('.alert, .error, .message').slideUp();
                }, 4000);
        $('.js-tilt').tilt({scale: 1.1});  
        var ref = $('#hint');        
        var popup = $('#popup'); 
        ref.click(function(){ 
            popup.show();
                var popper = new Popper(ref,popup,{
                        placement: 'top',                      
                        modifiers: {
                                flip: {behavior: ['left', 'right', 'top','bottom']},
                                offset: { enabled: true, offset: '0,10' }
                        }
                });
                setTimeout(function(){
                    $(popup).slideUp();
                }, 5000);
        });


        $.cookieBar({
                style: 'bottom',
                wrapper :'body',
                expireDays:1,
                privacy: popup
	});
</script>
