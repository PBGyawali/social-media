$(document).ready(function(){
  
    // if the user clicks on the ratings button ...
    $('.rating-btn').on('click', function(){
      var data="Sorry you need to login to perform this action";
      var user_id= $(this).data('user_id');      
      if (user_id == ''|| !$.isNumeric(user_id))
      { 
        notallowed(data); 
        return false;  
      }
      var receiver_id=$(this).data('receiver_id');
      //var Class = $(this).attr("class");
      var post_id = $(this).data('id');
      var url=$('#action_server').val(); 
      $clicked_btn = $(this);
      $likes=$clicked_btn.siblings('span.likes');
      $dislikes=$clicked_btn.siblings('span.dislikes');
      $sibling=$clicked_btn.siblings('i');      
      var totallikes=$likes.text();
      var totaldislikes=$dislikes.text();
      var clicked_btnclass= $clicked_btn.attr("class");
      var siblingclass=$sibling.attr("class");
        if ($clicked_btn.hasClass('fa-thumbs-o-up')) 
        {
          action = 'like';          
          $clicked_btn.removeClass('fa-thumbs-o-up').addClass('text-primary');
          // change button styling of the other button if user is reacting the second time to post
          if (totaldislikes!=0 && $sibling.hasClass('text-primary'))
          {
            $dislikes.text(totaldislikes*1-1);
          }
          $sibling.removeClass(' text-primary').addClass('fa-thumbs-o-down');                     
          $likes.text(totallikes*1+1); 
        } 
        else if ($clicked_btn.hasClass('fa-thumbs-o-down')) 
        { 
          action = 'dislike';
          $clicked_btn.removeClass('fa-thumbs-o-down').addClass('text-primary'); 
          if (totallikes!=0  && $sibling.hasClass('text-primary'))
          {            
            $likes.text(totallikes*1-1);
          }
          $sibling.removeClass(' text-primary').addClass('fa-thumbs-o-up'); 
          $dislikes.text(totaldislikes*1+1);
        }    
        else if($clicked_btn.hasClass('fa-thumbs-up', 'text-primary'))
        {
          action = 'unlike';
          $clicked_btn.removeClass('text-primary').addClass('fa-thumbs-o-up');                    
          if (totallikes!=0)
          {            
            $likes.text(totallikes*1-1); 
          }	         
        }    
        else if($clicked_btn.hasClass('fa-thumbs-down', 'text-primary'))
        {
          action = 'undislike';
          $clicked_btn.removeClass(' text-primary').addClass('fa-thumbs-o-down');                  
          if (totaldislikes!=0)
          {            
            $dislikes.text(totaldislikes*1-1);
          }         
        }        
        
        $.ajax
        ({
            url: 'server/user_action_server.php',
            method: 'POST',
            data: {
                    'actions': action,
                    'receiver_id':receiver_id,
                    'post_id': post_id
                  },
            dataType:"JSON", 
            error:function(request)
            { 
              data="Sorry user reaction on this post cannot accepted at the moment"; 
              notallowed(data); 
              $clicked_btn.attr('class',  clicked_btnclass);
              $sibling.attr('class',  siblingclass); 
              $likes.text(totallikes); 
              $dislikes.text(totaldislikes);
            } , 
            success: function(response)
            { // display the number of likes and dislikes 
              $likes.text(response.likes);
              $dislikes.text(response.dislikes);        
            }
        });
    });
    // if the user clicks on the follow button
    $('.comments_count').on('click', function(e){
      e.preventDefault();      
      var path=$(this).parent();
      var form=path.siblings('form.comment_form');      
      var comments_wrapper=path.siblings('.comments-wrapper');
      var comment=comments_wrapper.children('.comment');
      var comment_call=comments_wrapper.find('.comment_call');
      $('.comment').hide();       
      $(comment).show();
      $('.comment_form').hide()
      $(form).show(); 
      $('.comment_call').show();
      comment_call.hide();
      $('.comments_count').show();
      $(this).hide();
    });

        // if the user clicks on the follow button
        $('.action_button').on('click', function(){          
          var receiver_id = $(this).data('receiver_id'); 
          var sender_id= $(this).data('user_id');
          var url=$('#action_server').val(); 
          var data="Sorry, You cannot follow yourself";          
          if (sender_id == ''|| !$.isNumeric(sender_id))
            {    
              var data="Sorry you need to login to perform this action";
              notallowed(data);
              return false;  
            }
          if (receiver_id==sender_id){
            notallowed(data);
            return false;
          }    
          $clickedbtn=$(this);
          var r=$(this).text(); 
          if (r=='Follow') {
              result = 'follow';
              $(this).html('Following').addClass('btn-success').removeClass('btn-primary');	
          } else if(r=='Following'|| r=='UnFollow'){
            result = 'unfollow';
              $(this).html('<i class="glyphicon glyphicon-plus text-white" style="color:white"></i>Follow').removeClass('btn-success').addClass('btn-primary');	
          }  
        
          $.ajax({
              url: url,
              method: 'post',
              data: {
                  'result': result,
                  'receiver_id': receiver_id},
              dataType:"JSON",
              error:function()
                   {  data="Sorry the user cannot be followed at the moment"; 
                   notallowed(data);		      
                     } , 
              success: function(data){
                if (data!="")
                {
                    notallowed(data);
                    $clickedbtn.text(r);    
                }    
                    }
          });		
        });
        function notallowed(data)
        {
            $.alert
            ({
                    title: 'Error',            
                    content: data,
                    buttons: 
                {
                    No: {  text:'OK',           
                           btnClass: 'btn-blue',
                        }, 
                    Yes:{isHidden: true,}
                }   
             });
    
        }
        
        
        });



          // if the user clicks on the follow button
          $('.send_message_button').on('click', function(){          
            var receiver_id = $(this).data('receiver_id'); 
            var sender_id= $(this).data('sender_id');  
            var url=$('#user_message_server').val();            
            var receiver_type=  $(this).data('receiver_type');
            if (receiver_type=="user"){
              $('#usermessage_0').hide();
              $('#chatbox_heading').text('Message');
            }
            else{
              $('#usermessage_0').show();
              $('#chatbox_heading').text('Support');
      
            }                   
            if (sender_id == ''|| !$.isNumeric(sender_id))
              {    
                var data="Sorry you need to login to perform this action";
                notallowed(data);
                return false;  
              }
              $('#receiver_type').val(receiver_type);
              $('#sender_id').val(sender_id);
              $('#receiver_id').val(receiver_id);
              $('#chatbox').toggleClass('d-none');                   
            		
          });
         
         