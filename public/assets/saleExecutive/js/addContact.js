jQuery(function ($) {
    $('#contactForm').validate({
        rules: {
                    name:{
                        required:true
                    },
                    email:{
                        required:true,
                        email:true
                    },
                   phoneno:{ 
                       required:true,
                        number:true,
                        minlength:10,
                        maxlength:13  
                    } ,
                    location:{
                        required:true

                    },
                    type:{
                        required:true
                    }
                },
        messages: {
                    phoneno:{
                           required:"Please enter a mobile number ",
                            number:"Please enter numeric value",
                            minlength:"Mobile should be more than 10 characters",
                            maxlength:"Mobile should be less than 13 characters",
                    },
                   name:{
                       required:"Please enter name"
                   },
                   email:{
                       required:"Please enter email",
                       email:"Please enter valid email"
                   },
                   location:{
                       required:"Please enter location"
                   },
                   type:{
                       required:"Please select type of member"
                   }
                },
    });
});           