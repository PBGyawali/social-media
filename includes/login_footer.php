<script type="text/javascript" src="<?php echo JS_URL.'jquery.min.js'?>"></script>  
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css">
<link rel="stylesheet" href="<?php echo CSS_URL.'parsley.css'?>" >
<script type="text/javascript" src="<?php echo JS_URL.'parsley.min.js'?>"></script>	  
<script type="text/javascript" src="<?php echo JS_URL.'popper.min.js'?>"></script>	
<script src="<?php echo JS_URL?>container.js"></script>
<script src="<?php echo JS_URL?>password_strength.js"></script>
 <script src="<?php echo JS_URL?>live_register.js"></script>
 <script src="<?php echo JS_URL .'toggle_password.js'?>"></script>
 <script src="<?php echo JS_URL .'tilt.jquery.min.js'?>"></script>

<div id="wrapper">
        <div class="blocker"></div>
        <div  class="bg-dark text-white text-center py-0 px-2 pb-0 mb-0" id="popup" style="border-radius:4px;font-size: 16px;">
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

        $('.js-tilt').tilt({
            scale: 1.1
        });        
 
        var ref = $('#hint');        
        var popup = $('#popup');
        popup.hide();
        
        ref.click(function(){ 
            popup.show();
                var popper = new Popper(ref,popup,{
                        placement: 'top',
                        onCreate: function(data){
                                console.log(data);
                        },
                        modifiers: {
                                flip: {
                                        behavior: ['left', 'right', 'top','bottom']
                                },
                                offset: { 
                                        enabled: true,
                                        offset: '0,10'
                                }
                        }
                });
                setTimeout(function(){
                    $(popup).slideUp();
                }, 4000);
        });
       


</script>
