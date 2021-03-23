jQuery(function ($) {
    $('#sendMessageForm').validate({
        rules: {
                    member:{
                        required:true
                    },

                    text:{
                        required:true
                    },
                    
                },
        messages: {
                    
                   member:{
                       required:"Please select member in the list"
                   },
                  
                   text:{
                       required:"Please enter message"
                    },
                   
                },
    });
});           