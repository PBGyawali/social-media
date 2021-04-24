		</div>
	</body>
</html>
<script>
$(document).ajaxStart($.blockUI).ajaxStop($.unblockUI);
	var url=$('.form').attr('action');	
	$('.form').parsley();
 var dataTable = maketable();
	 function maketable(){
		 dataTable=$('#list').DataTable( {"order" : [] } );
	 return dataTable;
	 }
	updateIndex = function() {
		$('td.index').each(function(i) {
		   $(this).html(i + 1);
		});
	 };
	

	 $('.toggle').on( 'click', function (e) 
	{		var column = dataTable.column( $(this).attr('data-column') );		
			column.visible( ! column.visible() );
	} );
	function timeout()
	{		setTimeout(function(){
            $('.error, .message, .alert').slideUp();
		}, 3000);
		
		setTimeout(function(){
		$('#message,#alert_action,#form_message').html('');
		}, 5000);
	}
	function showMessage(data)
	{		$('#alert_action,#message').fadeIn().html(data);
		timeout();
	}
	  
	$('#filter').click(function(){
  		var from_date = $('#from_date').val();
  		var to_date = $('#to_date').val(); 
  	});

  	$('#refresh').click(function(){
  		$('#from_date').val('');
  		$('#to_date').val(''); 
	  });
	  
	  $('#export').click(function(){
		  var url=$(this).data('url');
  		var from_date = $('#from_date').val();
  		var to_date = $('#to_date').val();
  		if(from_date != '' && to_date != '')
  			window.location.href=url+"export.php?from_date="+from_date+"&to_date="+to_date+"";
  		else
  			window.location.href=url+"export.php";
  	});

</script>
