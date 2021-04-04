$(document).ready(function() {
            $('#register_password_1').keyup(function() {
              var password=$(this).val();
              var strength=checkStrength(password);
              $('#strength_message').html(strength);
            })

            function checkStrength(password) {
                var strength = 0
                if (password.length < 1) {
                  $('#strength_message').removeClass();                 
                  return false;
              }
                if (password.length < 8) {
                    $('#strength_message').removeClass().addClass('text-danger');              
                    return 'Short';
                }
                if (password.length > 7) strength += 1  
                if (password.match(password.match(/([0-9])/))) strength += 1
                // If password contains both lower and uppercase characters, increase strength value.  
                if (password.match(/([a-z].*[A-Z])|([A-Z].*[a-z])/)) strength += 1  
                // If it has numbers and characters, increase strength value.  
                if (password.match(/([a-zA-Z])/) && password.match(/([0-9])/)) strength += 1  
                // If it has one special character, increase strength value.  
                if (password.match(/([!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1  
                // If it has two special characters, increase strength value. 
                if (password.match(/(.*[!,%,&,@,#,$,^,*,?,_,~].*[!,%,&,@,#,$,^,*,?,_,~])/)) strength += 1 
                if (password.length > 12) strength += 1 
               
                if (strength < 2) {
                  $('#strength_message').removeClass().addClass('text-warning');                   
                    return 'Weak';
                } else if (strength ==2 || strength==3) {
                  $('#strength_message').removeClass().addClass('text-primary');               
                    return 'Good'
                } 
                else if (strength > 3 && strength<6) {
                  $('#strength_message').removeClass().addClass('text-info');  
                    return 'Strong'
                }
                else {
                   $('#strength_message').removeClass().addClass('text-success'); 
                    return 'Very Strong'
                }
                
            }
        });