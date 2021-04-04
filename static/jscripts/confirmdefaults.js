jconfirm.defaults = {   
    boxWidth: '30%',
    useBootstrap: false,
    dragWindowBorder: false,
    icon: 'fa fa-warning',  
    closeIcon: true, // explicitly show the close icon
    closeIcon: 'No',//defines what to do when close icon is clicked
    autoClose: 'No|15000',//defines what to do when autoclose is enabled and the time
    backgroundDismiss: false,
    backgroundDismissAnimation: 'glow',   
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