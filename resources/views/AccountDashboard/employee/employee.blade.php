@extends('AccountDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('AccountDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('AccountDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<!-- main row start-->
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
										    <label>Employee ID:</label>
										    <input type="text" class="form-control">
										</div>
										<div class="form-group">
										    <label>Employee Name:</label>
										    <input type="text" class="form-control">
										</div>
										<div class="form-group">
										    <label>Designation:</label>
										    <select class="form-control">
										    	<option>Broker</option>
										    	<option>Seller</option>
										    	<option>Purchased</option>
										    </select>
										</div>
										<button type="button" class="btn btn-success">Search</button>
									</form>
								</div>
								<div class="col-sm-4 top_btns">
									<button class="btn btn-primary" id="add-employee" data-url="{{ URL('/account/employee/add') }}" data-toggle="modal" data-target="#employeeModal">Add Employee<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->

						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">All Employees Data</div>
								<table class="display responsive nowrap" width="100%">
									<thead>
										<tr>
											<th>Name</th>
											<th>Employee ID</th>
											<th>Email</th>
											<th>Mobile</th>
											<th>Join Date</th>
											<th>Designation</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
									@foreach($user as $value)
                                           <?php
                                            $phone=''; 
                                            $name='';
                                            $f_name='';
                                            $l_name='';
                                            $company='';
                                            $designationnum = $value->designation;
                                            $designation = $value->designation;
                                            if($designation > 0 ){
                                                if($designation=='1'){ $designation='user'; }elseif($designation=='2'){ $designation='Accountant'; }elseif($designation=='4'){$designation='Sales Manager';}else{ $designation='Sales Executive'; }

                                            }else{$designation='Not Registered';}
                                            if($value->detail){
                                                $phone = $value->detail->phone;
                                                $name= $value->detail->f_name." ".$value->detail->l_name;
                                               $f_name=  $value->detail->f_name;
                                               $l_name=  $value->detail->l_name;
                                               $company= $value->detail->company;
                                            }
                                            ?>
                                            <tr class="data-row">
                                               <td class="username">{{$value->username}}</td>
                                                <td class="username">{{$value->id}}</td>
                                                <td class="email">{{$value->email}}</td>
                                                <td class="phone">{{$phone}}</td>
                                                <td>{{date('d/m/Y', strtotime($value->created_at))}}</td>
                                                <td class="designation"> {{$designation}}</td>
                                                <td class="action"><span style="display:none;" class="designation">{{$designationnum}}</span>
                                                  <span style="display:none;" class="f_name">{{$f_name}}</span>
                                                  <span style="display:none;" class="l_name">{{$l_name}}</span>
                                                  <span style="display:none;" class="company">{{$company}}</span>
                                                    <button data-url="{{ URL('/account/employee/'.$value->id) }}" type="button" class="btn btn-success" id="edit-employee" data-user_id="{{$value->id}}">edit</button>
                                                    <a  class="btn btn-danger" href = "{{ URL('/account/employee/delete/'.$value->id ) }}">delete</a>
                                                    

                                                </td>
                                            </tr>
                                        @endforeach
									</tbody>
								</table>
							</div>
						</div>
						<!-- Sale Table end-->
					</div>
				</div>
				<!-- main row end-->
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
					<h4 class="modal-title"><b>Add New Employee</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<form id="employeeForm" action="/superadmin/kickstarter" method="post" enctype= multipart/form-data>
                    @csrf
				<div class="modal-body register_new_user">
				<div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div> 
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							    <label>First Name</label>
							    <input type="text" class="form-control" id="f_name" name="f_name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Last Name</label>
							    <input type="text" class="form-control"  id="l_name" name="l_name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Username</label>
							    <input type="text" class="form-control" id="username" name="username">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Email</label>
							    <input type="text" class="form-control" id="email" name="email">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Password</label>
							    <input type="password" id="password" name="password" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Confirm Password</label>
							    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Employee ID</label>
							    <input type="text" class="form-control" disabled="disabled">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Joining Date</label>
							    <input type="text" class="form-control datepicker" id="joinnig_date" name="joinnig_date">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Company</label>
							    <input type="text" id="company" name="company" class="form-control ">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Designation</label>
							    <select  id="designation" name="designation" class="form-control" >
							    	<option>Broker</option>
							    	<option>Seller</option>
							    	<option>Purchased</option>
							    </select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Phone</label>
							    <input type="text" class="form-control" id="phone" name="phone">
							</div>
						</div>
					</div>
				</div>

				<div class="modal-footer pl-0 pr-0">
					<div class="col-md-12 text-center p-0"> 
					<input type="hidden" id="user_id" name="user_id" >
					<button type="button" id="save_button" class="btn btn-success save_employee save_button">Add</button>
                            <button type="button" id="update_button" style="display:none;" class="btn btn-success save_employee update_button">Update</button>
                            <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>

	@endsection
@section('page_js')
<script>
    //Employee add/edit bootstrap modal ajax


    $(document).on('click', ".save_employee", function() {  
      
      var button_id                 =   $(this).attr("id");
      var _token                    =   $("input[name='_token']").val();
      var username                  =   $("input[name='username']").val();
      var f_name                    =   $("input[name='f_name']").val();
      var l_name                    =   $("input[name='l_name']").val();
      var email                     =   $("input[name='email']").val();
      var phone                     =   $("input[name='phone']").val();
      var password                  =   $('input[name="password"]').val();
      var password_confirmation     =   $('input[name="password_confirmation"]').val();
      var designation               =   $('select[name="designation"]').val();
	  var joinnig_date               =   $('select[name="joinnig_date"]').val();
      var company                   =   $('input[name="company"]').val();
      var id                        =   $("input[name='user_id']").val();
    
      var url = $('#employeeForm').attr('action');
      
      $.ajax({
          url: url,
          type:'POST',
          data: {_token:_token, id:id, f_name:f_name, l_name:l_name, email:email, phone:phone, password:password, designation:designation, company:company, password_confirmation:password_confirmation, username:username},
          success: function(data) {
             
              if($.isEmptyObject(data.error)){
                
                  alert(data.success);
                  jQuery('.alert-danger').hide();
                  
                      $('#open').hide();
                      $('#employeeModal').modal('hide');
                      location.reload();
              }else{
                  printErrorMsg(data.error);
              }
          }
      });


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
        $(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

        var options = {
          'backdrop': 'static'
        };
        
        $('#employeeModal').modal(options);	
        $('#employeeForm').attr('action', $(this).data('url'));
        
        //show/hide button
        $('.save_button').hide();
        $('.update_button').show();
    });

    //on add button


    $(document).on('click', "#add-employee", function() {
        $('#employeeForm').attr('action', $(this).data('url'));
        $('.save_button').show();
        $('.update_button').hide();

    });


    //on modal show

    $('#employeeModal').on('show.bs.modal', function() {
      
        var el = $(".edit-item-trigger-clicked"); // See how its usefull right here? 
        var user_id = el.data('user_id');
          if(typeof user_id !==  "undefined"){
            var row = el.closest(".data-row");
            var span = row.children(".action");
            
            // get the data
            
            var username = row.children(".username").text();
            var email = row.children(".email").text();
            var phone = row.children(".phone").text();
            var designation = span.children("span.designation").text();
            var f_name = span.children("span.f_name").text();
            var l_name = span.children("span.l_name").text();
            var company = span.children("span.company").text();
			var joinnig_date = span.children("span.joinnig_date").text();


            // fill the data in the input fields
            $("input[name='user_id']").val(user_id);
            $("input[name='f_name']").val(f_name);
            $("input[name='l_name']").val(l_name);
            $("input[name='email']").val(email);
            $("input[name='phone']").val(phone);
            $("input[name='username']").val(username);
            $("input[name='company']").val(company);
			$("input[name='joinnig_date']").val(joinnig_date);
            $('[name=designation] option').filter(function() { 
              return ($(this).val() == designation); //To select Blue
            }).prop('selected', true);
          }
      });

      // on modal hide
      $('#employeeModal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#employeeForm").trigger("reset");
        jQuery('.alert-danger').hide();
        
      });



</script> 
@endsection
	