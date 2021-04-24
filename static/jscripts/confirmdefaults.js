jconfirm.defaults = { 
    useBootstrap: true,
    dragWindowBorder: false,
    icon: 'fa fa-warning',  
    closeIcon: true, // explicitly show the close icon
    closeIcon: 'No',//defines what to do when close icon is clicked
    autoClose: 'No|150000',//defines what to do when autoclose is enabled and the time    
    backgroundDismiss: true,
    backgroundDismissAnimation: 'glow', 
    columnClass: 'col-md-4 col-md-offset-8 col-xs-4 col-xs-offset-8',
    containerFluid: true, // this will add 'container-fluid' instead of 'container'
    theme: 'dark',
    type: 'red',
    animation: 'scale',
    closeAnimation: 'scale',
    animationSpeed: 400,      
    draggable: true,            
    buttons: {
              Yes: {
                    text: 'Yes',
                    btnClass: 'btn-red',
                    keys: ['enter'],
                    action: function () {
                    }
                  },
              No:  {
                text: 'No',
                btnClass: 'btn-green',
                keys: ['esc'],
                action: function(){
                  $( this ).remove();
                }
      },
    },
   
};

	// override these in your code to change the default behavior and style
  $.blockUI.defaults = {
    message:  '<h1><i class="fa fa-spinner fa-pulse "></i> Just a moment...</h1>',
    css: {
      border: 'none', 
      padding: '15px', 
      backgroundColor: '#000', 
      '-webkit-border-radius': '10px', 
      '-moz-border-radius': '10px', 
      opacity: .6, 
      color: '#fff',
          top:            '40%',
          left:           '35%',  
    },
      // styles for the overlay
      overlayCSS:  {
          backgroundColor: '#000',
          opacity:         0.5,        
      },
      // time in millis to wait before auto-unblocking; set to 0 to disable auto-unblock
      timeout: 5000,
      // disable if you don't want to show the overlay
      showOverlay: true,
  };