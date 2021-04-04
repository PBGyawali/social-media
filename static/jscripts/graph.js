$(document).ready(function()
{
	$('[data-bs-chart]').each(function(index, elem) {
		window ['figure_'+index]=this.chart = new Chart($(elem), $(elem).data('bs-chart'));
	});

    function emptyspace(canvas){  		         
        const context = canvas.getContext('2d');
        // Store the current transformation matrix
            context.save();
            // Use the identity matrix while clearing the canvas
            context.setTransform(1, 0, 0, 1, 0, 0);
            context.clearRect(0, 0, canvas.width, canvas.height);
            // Restore the transform
            context.restore();
            return true;        
    } 

    $('.bargraph').on('click', function()
    {   var id=$(this).data('id');
		var type=$(this).data('type');
        var month=$('#'+type+'_'+id).data('month');
        var monthvalue=$('#'+type+'_'+id).data('monthvalue');        
        updateGraphmonths(month,monthvalue,id,'bar');
    });
    $('.permonth').on('click', function()
    {   var id=$(this).data('id'); 
		var month=$(this).data('month');
        var monthvalue=$(this).data('monthvalue');
        updateGraphmonths(month,monthvalue,id);       
        $('#fullmonths'+'_'+id).show();
        $('#permonth'+'_'+id).hide();
        $('#bargraph'+'_'+id).data('type','permonth');        
    });  

    $('.fullmonths').on('click', function()
    {   var id=$(this).data('id');
		var month=$(this).data('month');
        var monthvalue=$(this).data('monthvalue');  
        updateGraphmonths(month,monthvalue,id);      
       $('#fullmonths'+'_'+id).hide();
        $('#permonth'+'_'+id).show();
        $('#bargraph'+'_'+id).data('type','fullmonths'); 
    });

    function updateGraphmonths($fullmonths,$fullmonthvalue,id=null,$type='line')
    {  
	   var label=$('#label_'+id).text(); 
	   var canvas = document.getElementById("graph_canvas_"+id); 
	   $space= emptyspace(canvas); 
	   if (window['figure_'+id].chart!=undefined) {
		window['figure_'+id].chart.destroy();
						}
        if ($space)       
        { 
             window.chart = new Chart(canvas, 
            {
                    type: $type,
                    data: {
                            labels: $fullmonths,
                            datasets: 
                            [{
                                    data: $fullmonthvalue,
                                    borderWidth: 2,
                                    label:label,
                                    fill:true,
                                    backgroundColor:'rgba(78, 78, 78, 0.3)',
                                    borderColor:'rgba(78, 115, 223, 1)',      
                            }]
                        },
                    options: {
                                responsive: true,
                                maintainAspectRatio:false,    
                                legend: 
                                {
                                    display: false
                                },
                                title:{},
                                scales:
                                {
                                    xAxes:
                                    [{
                                        gridLines:
                                        {
                                            color:'rgb(234, 236, 244)',zeroLineColor:'rgb(234, 236, 244)',
                                            drawBorder:false,drawTicks:false,borderDash:[2],zeroLineBorderDash:[2],
                                            drawOnChartArea:false
                                        },
                                        ticks:
                                        {
                                            fontColor:'#858796',padding:20
                                        }
                                    }],
                                    yAxes:
                                    [{
                                        gridLines:
                                        {   color:'rgb(234, 236, 244)',
                                            zeroLineColor:'rgb(234, 236, 244)',drawBorder:false,
                                            drawTicks:false,borderDash:[2],zeroLineBorderDash:[2]
                                        },
                                        ticks:
                                        {
                                            fontColor:'#858796',padding:20
                                        }
                                    }]
                                }
                            }
            });
        }
    } 

    $('.refresh').on('click', function()
    { 	var id=$(this).data('id');
		var url=$(this).data('url');
		var table=$('#label_'+id).text().toLowerCase();
		var type=$('#type_'+id).text().toLowerCase();
      $.ajax
      ({
            url: url,
            method: 'post',
            data:  {get_full_data:1,table:table,type:type},
           dataType:"JSON",
            success: function(data)
            {   
                updateGraphmonths(data.labels,data.data,id);                
            }
        });
    });
  
});