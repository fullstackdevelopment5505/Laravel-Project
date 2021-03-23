@extends('SuperadminDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('SuperadminDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
            @include('SuperadminDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-sm-12">
					<div class="row">
                         @if(session()->get('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->get('danger'))
                            <div class="alert alert-danger">
                                {{ session()->get('danger') }}
                            </div>
                        @endif
                        <!-- datepicker -->
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <div class="col-sm-8 from_to_filter">
                                    <form>
                                        <div class="form-group">
                                            <label>Contractor ID:</label>
                                            <input name="search_id" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Contractor Name:</label>
                                            <input name="search_name" type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>Designation:</label>
                                            <select id="search_role" name="search_role" class="form-control">
                                            <option value="">Select Role</option>
                                            @foreach($role as $key=>$value)
                                            <option value="{{$value->id}}">{{$value->role}}</option>
                                            @endforeach
                                            </select>
                                        </div>
                                        <button type="button" id="search_submit" class="btn btn-success">Search</button>
                                    </form>
                                </div>
                                <div class="col-sm-4 top_btns">
                                    <button class="btn btn-primary" data-title="Add Contractor" id="add-employee" data-url="{{ URL('/superadmin/employee/') }}" data-toggle="modal" data-target="#employeeModal">Add Contractor<i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">All Contractors Data</div>
                                <table class="display responsive nowrap" id="employee_table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr. No</th>
                                            <th>Name</th>
                                            <th>Contractor ID</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Join Date</th>
                                            <th>Role</th>
                                            <th>Affiliate</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        
                                    </tbody>
                                </table>
							</div>
						</div>
                        <!--table end -->
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
    <!-- popup start from here-->
    <div class="modal fade" id="employeeModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Contractor</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <form id="employeeForm" action="/superadmin/employee" method="post" enctype= multipart/form-data>
                    <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                    {{@csrf_field()}}
                    <div class="modal-body register_new_user">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div>                    
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>Role</label>
                                    <select id="role" name="role" class="form-control">
                                        <option value="">Select Role</option>    
                                        @foreach($role as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->role}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>State</label>
                                    <select id="state" name="state" class="form-control">
                                        <option value="" selected="selected" >Select State</option>
                                        <optgroup>
                                            @foreach($states as $key=>$value)
                                            <option value="{{$value->id}}">{{$value->state_name}}</option>
                                            @endforeach
                                        </optgroup>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label>City</label>
                                    <select id="city" name="city" class="form-control">
                                        <option value="" selected="selected">Select City</option>
                                    </select>
                                    
                                </div>
                            </div>
                            
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>First Name</label>
                                    <input type="hidden" name="user_id" class="form-control" id="user_id">
                                    <input type="hidden" name="url" class="form-control" >
                                    <input type="text" id="f_name" name="f_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Last Name</label>
                                    <input type="text" id="l_name" name="l_name" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Email ID</label>
                                    <input type="text" id="email" name="email" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Phone Number</label>
                                    <input id="phone" name="phone" type="text" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Password</label>
                                    <input type="password" id="password" name="password" class="password form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Confirm Password</label>
                                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
                                </div>
                            </div>
                            <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label>Add Image</label>
                                        <input type="file" class="form-control" name="employee_image" id="" />
                                    </div>
                                </div>
                                <div class="col-sm-3 employee_img">
                                    <img style="display: none" src="#">
                                </div>
                            </div>
                        </div>
                        </div>
                    </div>

                    <div class="modal-footer pl-0 pr-0">
                        <div class="col-md-12 text-center p-0"> 
                            <button type="button" id="save_button" class="btn btn-success save_employee save_button">Add</button>
                            <button type="button" id="update_button" style="display:none;" class="btn btn-success save_employee update_button">Update</button>
                            <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- popup end here-->
@endsection
@section('page_js')
<script>
    //Employee add/edit bootstrap modal ajax
	$(document).ready(function () {
		$('#phone').usPhoneFormat({
			format: '(xxx) xxx-xxxx',
		});
	});
    var validator;
    $(function() {
        validator = $('#employeeForm').validate({
            rules: {
                role:{
                    required:true
                },
                state:{
                    required:true
                },
                city:{
                    required:true
                },
                f_name:{
                    required:true,
                    alpha: true
                },
                l_name:{
                    required:true,
                    alpha: true
                },
                email:{
                    required:true,
                    email: true,
                    remote: {
                        url: "{{route('superadminEmployeeVarifyemail')}}",
                        type: "GET",
                        async: false,
                        data: {
                            email: function () {
                                return $("input[name='email']").val();
                            },
                            id: function () {
                                return $("input[name='user_id']").val();
                            },
                        }
                    
                    }

                },
                phone:{ 
                    required:true,
                    phoneUS: true
                } ,
                password : {
                    minlength : 5
                },
                password_confirmation : {
                    minlength : 5,
                    equalTo : "#password"
                },
                password:{
                    required:true
                },
                employee_image: {
                    accept:"image/jpeg,image/png",
                    filesize_max: 300000
                
                },
               
            },
                messages: {
                f_name:{
                    required:"Please enter first name"
                },
                l_name:{
                    required:"Please enter last name"
                },
                phone:{
                        required:"Please enter a mobile number ",
                        digits: "Please enter only numbers",
                        minlength:"Please put 10  digit mobile number",
                        maxlength:"Please put 10  digit mobile number",
                },
                email:{
                    remote: "Email id already registred",
                    required:"Please enter email"
                },
                employee_image: {
                    filesize_max:" file size must be less than 250 KB.",
                    accept: "Please upload file in these format only (jpg, jpeg, png)."
                },
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });

        $.validator.addMethod("filesize_max", function(value, element, param) {
            var isOptional = this.optional(element),
                file;
            
            if(isOptional) {
                return isOptional;
            }
            
            if ($(element).attr("type") === "file") {
                
                if (element.files && element.files.length) {
                    
                    file = element.files[0];            
                    return ( file.size && file.size <= param ); 
                }
            }
            return false;
        }, "File size is too large.");
        $.validator.addMethod("zipCodeValidation", function() {
            var zipCode = $("input[name='postal_code']").val();
            return (/(^\d{5}$)|(^\d{5}-\d{4}$)/).test(zipCode); // returns boolean
        }, "Please enter a valid US zip code (use a hyphen if 9 digits).");

        $.validator.addMethod("phoneUS", function(phone_number, element) {
			phone_number= phone_number.replace(/[^0-9]/gi, '');
			return this.optional(element) || phone_number.length == 10;
		}, "Please specify a valid US phone number");
        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
        }, "Letters only please");
    });

    window.getCities = function(sid,city){ 
		$('#loader').show();
        $.ajax({
            type:"get",
            url:"{{URL('superadmin/kickstarter/getCities/')}}/"+sid,
            
            success:function(res)
            {       
                if(res)
                {
					$('#loader').hide();
                    $("#city").empty();
                    $("#city").append('<option value="">Select City</option>');
                
                    $.each(res,function(key,value){
                        if(city>0){
                            var selected ='';
                            if(city==key){
                                selected = "selected='selected'";
                            }
                        }
                        $("#city").append('<option '+selected+' value="'+key+'">'+value+'</option>');
                    });
                    return true;
                }
            }

        });
    }

    $(document).ready(function() {

         //get all cities
         $('#state').change(function(){
            var sid = $(this).val();
            if(sid){
                getCities(sid,0);
            }else{

                $("#city").empty();
                $("#city").append('<option value="">Select City</option>');
            }
        }); 
        

        $(document).on('click', '.delEmp', function (e) {
			
            $row =  $(this).parent().parent();
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "Are you sure!",
                    type: "error",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                },
                function() {
					$('#loader').show();
                $.ajax({
                    type: "POST",
                    url: "{{URL('superadmin/employee/delete/')}}/"+id,
                    data: {_token: "{{ csrf_token() }}"},
                    success: function(data){
                        
                        if($.isEmptyObject(data.error)){
                            $('#loader').hide();
                            swal("Deleted!", data.success, "success"); 
                            $row.remove();
                            
                        }else{
                            $('#loader').hide();
                            swal("Cancelled", data.error, "error");   
                        }

                    }       
                });
            });
        });


        $('#employee_table').DataTable({
            processing: true,
		    responsive: true,
		    serverSide: true,
            //"ajax": "{{ route('employee.list') }}",  
			dom: 'lBfrtip',
            ajax: {
			    url: "{{route('employee.list')}}",
			    data: function (d) {
					d.search_id     =   $('input[name="search_id"]').val();
					d.search_name   =   $('input[name="search_name"]').val();
					d.search_role   =   $('select[name="search_role"]').val();
					
				}
		    },
            columns:[
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: "name",className: "name"},
                { data: "empid",className: "empid"},
                { data: "email",className: "email"},
                {data:"phone",className: "phone"},
                {data:"join_date",className: "join_date", render: function(d){
					
					return moment(d).format("DD-MMM-YYYY");
					},
				},
                {data:"role",className: "role"},
                {data:"is_affiliate",className: "affiliate"},
                {data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
            createdRow: function ( row, data, index ) {
                    $(row).addClass('data-row');
            },
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
            ],
        });
   
        $('#search_submit').click(function(){	
            $('#employee_table').DataTable().draw(true);
        });

    $('.save_employee').click(function() {
		
        if($("#employeeForm").valid()){
             $('#loader').show();
            var formData  =   new FormData($("#employeeForm")[0]);
            var url       =   $("input[name='url']").val();
            var _token    =  $("input[name='_token']").val();
            $.ajax({
                url: url,
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    
                    if($.isEmptyObject(data.error)){
                         $('#loader').hide();
                        alert(data.success);
                        jQuery('.alert-danger').hide();
                        
                            $('#open').hide();
                            $('#employeeModal').modal('hide');
                            location.reload();
                    }else{
						 $('#loader').hide();
                        printErrorMsg(data.error);
						
                    }
                }
            });
        }
    });

    //show error message on submit
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

    //on edit button click set options
    $(document).on('click', "#edit-employee", function() {
       
		 $('#loader').show();
        var id = $(this).data("user_id");
        $.ajax({
            type: "GET",
            url: "{{route('superadminEmployeeAjaxRequest')}}",
            data: { id: id, type: "getEmpdata" },
            success: function(data){
                
                if($.isEmptyObject(data.error)){
					 $('#loader').hide();
                    len = data['data'].length;
                  if(len == 1){
                        $("input[name='user_id']").val(data['data'][0].id);
						if(data['data'][0]['detail']){
							$("input[name='f_name']").val(data['data'][0]['detail'].f_name);
							$("input[name='l_name']").val(data['data'][0]['detail'].l_name);
							$("input[name='phone']").val(data['data'][0]['detail'].phone);
							$("select[name='state']").val(data['data'][0]['detail'].state); 
							$("select[name='city']").val(data['data'][0]['detail'].city); 
							if(data['data'][0]['detail'].state>0){
								var state = data['data'][0]['detail'].state;
								var city = data['data'][0]['detail'].city;
								var res  = getCities(state,city);
							}
						}
                       
                        $("input[name='email']").val(data['data'][0].email);
                       
                        
                        if(data['data'][0].role>0){
                            $("select[name='role']").val(data['data'][0].role);
                        }
                        
                        if (data['data'][0]['image']) {
                            $(".employee_img img").attr('src', data['data'][0]['image'].filename);
                            $(".employee_img img").show();
                        } else {
                            $(".employee_img img").hide();
                        }
                    }else{

                        alert("Something went wrong!");
                    }
                }else{
					 $('#loader').hide();
                    alert(data.error);
                    
                }

            }       
        });
        $(this).addClass('edit-item-trigger-clicked'); 
        $('input[name="password"]').rules('add', {
            required: false
        });
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
        var options = {
        'backdrop': 'static'
        };
        var title = $(this).data('title');
        var modal = $('#employeeModal').modal(options);
        modal.find('.modal-title').text(title);
        $('#employeeForm')
                .find('[name="url"]')
                    .val($(this).data('url'))
                    .end();
        //show/hide button
        validator.resetForm();
        $('.save_button').hide();
        $('.update_button').show();
    });

    //on add button
    $(document).on('click', "#add-employee", function() {
       
       
        $('input[name="password"]').rules('add', {
            required: true
        });
        var options = {
            'backdrop': 'static'
        };
        $('#employeeForm')
            .find('[name="url"]')
            .val($(this).data('url'))
            .end();
        var title = $(this).data('title');
        var modal = $('#employeeModal').modal(options);
        modal.find('.modal-title').text(title);
		$("#employeeForm").trigger("reset");
		$(".employee_img img").hide();
		$("#city").empty();
        $("#city").append('<option value="">Select City</option>');
        validator.resetForm();
        $('.save_button').show();
        $('.update_button').hide();
    });

    //on modal show
    $('#employeeModal').on('show.bs.modal', function() {
        var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
        var user_id = el.data('user_id');
    
    });

    // on modal hide
    $('#employeeModal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#employeeForm").trigger("reset");
        jQuery('.alert-danger').hide();
        validator.resetForm();
    });
});
</script> 
@endsection