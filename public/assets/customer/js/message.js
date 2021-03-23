jQuery(function($){
    $("#sendMessage").validate({
       rules:{
           member:{
               required:true
           },
           subject:{
               required:true
           },
           editor1:{
               required:true
           }
       },
       messages:{
        member:{
            required:"Please select member in the list"
        },
        subject:{
            required:"Please enter subject"
        },
        editor1:{
            required:"Please enter message to be send"
        }
       } 
    })
})