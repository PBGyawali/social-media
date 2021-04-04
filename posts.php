<?php include_once($_SERVER['DOCUMENT_ROOT'].'/social_media/includes/init.php');
$article=new article; 
$posts =$article-> getAllPosts();
include_once(USER_INCLUDES. 'minimal_header.php'); 
include_once(USER_INCLUDES.'sidebar.php');
if(!$check->is_login())	header("location:".$article->base_url."");
?>	
	
	        <div class="col-sm-12 py-4">
			<div class="alert alert-success success_msg" role="alert" id="success_msg" ></div>			
			<div class="alert alert-danger error_msg" role="alert" id="error_msg" ></div>
	        	<span id="message"></span>
	            <div class="card">
	            	<div class="card-header">
	            		<div class="row">
	            			<div class="col-sm-6">
	            				<h2>Post Management</h2>
	            			</div>	            					            		
	            			<div class="col-md-6 text-right">	            				
	            				<a  name="add_post" id="add_post" href="post.php" class="btn btn-success btn-sm" ><i class="fas fa-plus"></i>  Create Post</a>
	            			</div>
	            		</div>
	            	</div>
	            	<div class="card-body">
					<?php if (empty($posts)): ?>
				<h1 class="text-center mt-20">There are no posts in the database.</h1>
			<?php else: ?>
	            		<div class="table-responsive">
	            			<table class="table table-striped table-bordered" id="list">
	            				<thead>
	            					<tr>
										<th>Title</th>
										<?php if($check->is_admin()):?>	
										<th>Author</th>
										<?php endif?>
										<th>Views</th>
										<th>Created on</th>
										<th>Updated on</th>
										<th>Published</th>
										<?php if($check->is_admin()):?>							
										<th>Anonymous</th>
										<?php endif?>
										<th>Action</th>
	            					</tr>
	            				</thead>
								<tbody>
					<?php foreach ($posts as $key => $post): ?>
						<tr id="post_<?php echo $post["id"];?>">
						<td class="postname">
								<a 	target="_blank"
								href="<?php echo BASE_URL.'single_post.php?post-slug='.$post['slug'];?>">
									<?php echo $post['title'];?>	
								</a>
							</td>
							<?php if($check->is_admin()):?>	
							<td><?php echo $post['username']; ?></td>	
							<?php endif ?>				
							<td><?php echo $post['views']; ?></td>
							<td><?php echo $post['created_at']; ?></td>
							<td class="updated"><?php echo $post['updated_at']; ?></td>
							
							<!-- Only Admin can publish/unpublish post -->
								<td class="publish_status">
								<?php if ($post['published'] == true): ?>
									<i class="fa fa-check btn btn-success"></i><span style="display:none;">1</span>
								<?php else: ?>
									<i class="fa fa-times btn btn-danger"></i><span style="display:none;">2</span>		
								</td>
							<?php endif ?>
							<?php if($check->is_admin()):?>	
							<td class="anonymity">
							<?php echo $post['anonymity'];?></td>
							<?php endif ?>							
								<td class="buttons">
								<form  action='post' class='userlistform' target="_blank" method='POST' >
								<input type='hidden' name='id' value='<?php echo $post['id'] ?>'>
							<button type="submit" name="edit-post" title="edit"class="fa fa-edit btn btn-primary btn-sm edit_button" data-action="fetch_single" data-id="<?php echo $post['id'] ?>"></button>							
							</form>							
								&nbsp;
								<button type="button" name="delete_button" title="delete" class="fa fa-trash btn btn-danger btn-sm delete_button" data-action="delete" data-id="<?php echo $post['id'] ?>"></button>
								<?php if($check->is_admin()):?>	
								<?php if ($post['published'] == true): ?>
										&nbsp;
									<button type="button"  title="unpublish" class="fa fa-times btn btn-warning btn-sm toggle action_button" data-action="unpublish" data-id="<?php echo $post['id'] ?>"></button>
								<?php else: ?>
									&nbsp;
									<button type="button" title="publish" class="fa fa-eye btn btn-success btn-sm toggle action_button" data-action="publish" data-id="<?php echo $post['id'] ?>"></button>
								<?php endif ?>
								<?php endif ?>
							</td>
						</tr>
						
					<?php endforeach ?>
					</tbody>
				</table>
				<?php endif ?>
			
	            		</div>
	            	</div>
	            </div>
	        </div>
	    </div>
	</div>

</body>
</html>


<?php include_once(USER_INCLUDES.'minimal_footer.php');?>
<script type="text/javascript" src="<?php echo JS_URL.'datatables.min.js'?>"></script>
<link rel="stylesheet" href="<?php echo CSS_URL.'datatables.min.css'?>" >
<script>

$(document).ready(function(){

	var dataTable = $('#list').DataTable();

	$('.toggle').on( 'click', function (e) {
        // Get the column API object
        var column = table.column( $(this).attr('data-column') );
        // Toggle the visibility
        column.visible( ! column.visible() );
    } );


		$('#post_form').parsley();

	$('#post_form').on('submit', function(event){
		for ( instance in CKEDITOR.instances )
{
CKEDITOR.instances[instance].updateElement();
}
		event.preventDefault();
	

		var data = new FormData(this);
		
		var url=$('#post_form').attr('action');
			
		if($('#post_form').parsley().isValid())
		{	
			$.ajax({
				url:url,
				method:"POST",
				data:data,
				contentType:false,
				processData:false,
				dataType:"JSON",
				beforeSend:function(){					
					$('#submit_button').attr('disabled', 'disabled');
					$('#submit_button').val('wait...');					
				},
				complete:function(){$('#submit_button').attr('disabled', false);	},
				success:function(data)
				{
									
					$('#message').html(data.response);					
					$('#list').prepend(data.status);					
					setTimeout(function(){
						$('#message').html('');
					}, 5000);
				}
			})
		}
	});

	$(document).on('click', '.edit_button', function(){		
		var id = $(this).data('id');
		var action=$(this).data('action');
		var url=$('#post_form').attr('action');				
		$.ajax({
	      	url:url,
	      	method:"POST",
	      	data:{id:id, edit_post:1},
	      	dataType:'JSON',
			complete:function(){
				$('#modal_title').text('Edit Post');
	        	$('#action').val('edit');
	        	$('#submit_button').val('Update');	        	
				$('#action').attr('name','update-post');				
			},
	      	success:function(data)	      	{           	
				var a=data.response.published;
				if (a==1){$('#publish').attr('checked',true);}
				else{$('#publish').attr('checked',false);}
	           var b=data.response.anonymity;
			   if (b=="yes"){$('#anonymity').attr('checked',true);}
			   else{$('#anonymity').attr('checked',false);}
				$('#title').val(data.response.title);       	
	        	$('#post_id').val(id);
				$('#user_id').val(data.response.user_id);
				$('#old_featured_image').val(data.response.image);										
				CKEDITOR.instances.body.setData(data.response.body);
				$('#topic_id').val(data.status);
				
	      	}
	    })
	});

	$(document).on('click', '.action_button', function(){
		
		var id = $(this).data('id');
		var action=$(this).data('action');		
		var url=$('#post_form').attr('action');
		var statusicon=$("#post_" + id + " .publish_status i"); 
		var statusspan=$("#post_" + id + " .publish_status span");
		var statusbutton=$("#post_" + id + " .buttons .toggle:button");				
		$.ajax({
			url:url,
	      	method:"POST",
	      	data:{id:id, action:action},
	      	dataType:'JSON',
			  complete:function(){		
			  },
	      	success:function(data)
	      	{
				var status = data.status;
            var response = data.response;
			
			if (status=="error"){
			alert(response);				
					}
					else{			 
			switch(action) {
			case "publish":
			statusicon.removeClass();
			statusicon.addClass('fa fa-check btn btn-success');
			statusbutton.attr('title','unpublish');
			statusbutton.removeClass('fa-eye btn-success');
			statusbutton.addClass('fa-times btn-warning');
			statusbutton.data('action','unpublish');
			statusspan.text('b');						
			break;
			case "unpublish":
			statusicon.removeClass();
			statusicon.addClass('fa fa-times btn btn-danger');
			statusbutton.attr('title','publish');
			statusbutton.addClass('fa-eye btn-success');
			statusbutton.removeClass('fa-times btn-warning');
			statusbutton.data('action','publish');
			statusspan.text('a');						
			break;
			case "delete":
			$(this).closest('tr').fadeOut('slow');
			break;	
			        }	} 

	        	
	            	}
	    });
	});


	$(document).on('click', '.delete_button', function(){
		var id = $(this).data('id');
		$row=$(this).closest('tr');
		var action=$(this).data('action');
		var url=$('#post_form').attr('action');	
		if(confirm("Are you sure you want to remove it?"))
    	{
    		$.ajax({
    			url:url,
    			method:"POST",
    			data:{id:id, 'delete_post':1},
				dataType:'JSON',
    			success:function(data) {
					var status = data.status;
            var response = data.response;
			
			if (status=="error"){$.alert(response);}
					else{			
					
        			$('#message').html(response);        			
        			setTimeout(function(){
        				$('#message').html('');
        			}, 5000);
					$row.fadeOut('slow');
        		}}
        	});
    	}
  	});

  	
  	

});

</script><script>
	CKEDITOR.replace('body');
</script>