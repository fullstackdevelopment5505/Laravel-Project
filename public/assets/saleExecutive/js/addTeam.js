jQuery(function ($) {
    $('#addTeamForm').validate({
        rules: {
                    first_name:{
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
                    dob:{
                        required:true
                    },
                    city:{
                        required:true
                    },
                    gender:{
                        required:true
                    },
                    department:{
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
                   first_name:{
                       required:"Please enter name"
                   },
                   email:{
                       required:"Please enter email",
                       email:"Please enter valid email"
                   },
                   city:{
                       required:"Please enter city"
                    },
                    gender:{
                       required:"Please select gender of member"
                   },
                   department:{
                       required:"Please select type of department"
                   },
                   dob:{required:"Please enter date of birth"}
                },
    });
});           