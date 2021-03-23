@extends('SalemanagerDashboard.master')
@section('content')
<style>
.error{
	color:red;
}
</style>
	<!-- main div start -->
	<div class="main_area">
		@include('SalemanagerDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SalemanagerDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
			@if(Session::has('success'))
        		<div class="alert alert-success">
            		{{Session::get('success')}}
        		</div>
    		@endif
			@if(Session::has('error'))
				<div class="alert alert-danger">
					{{Session::get('error')}}
				</div>
			@endif
			<div class="col-md-12">
				<div class="row row-eq-height">
					<!--property data start -->
					<div class="col-md-12 add_team">
						<form id="addTeamForm" method="post" action="{{route('sale_manager.addTeam')}}" enctype="multipart/form-data">
						{{@csrf_field()}}
							<div class="inside">
								<div class="row">
								<input type="hidden" name="role" value="5">
									<div class="col-md-3">
										<!-- <label>Username</label><br> -->
										<input type="text" class="form-control fldtxt" placeholder="User Name" name="username">
									</div><br>
									<div class="col-md-3">
										<input type="email" class="form-control fldtxt" placeholder="Email" name="email">
									</div>
									<div class="col-md-3">
										<input type="password" class="form-control fldtxt" placeholder="Password" name="password">
									</div>
								</div>
								<div class="row">
									<div class="col-md-3">
										<input type="text" class="form-control  fldtxt" placeholder="Phone Number" name="phone">
									</div>
									<div class="col-md-3">
										<input type="password" class="form-control datepicker fldtxt" placeholder="Confirm password" name="confirm_password">
									</div>
									<!-- <div class="col-md-3">
										<input type="text" class="form-control fldtxt" placeholder="Age" name="age">
									</div>
									<div class="col-md-3">
										<select class="form-control fldtxt" name="gender"> 
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div> -->
									<div class="col-md-3">
									 <select class="form-control fldtxt" name="state" readonly> 
										@foreach($state as $row)
											<option value="5" >{{$row->STATE_NAME}}</option>
										@endforeach
										
										</select>
								 	<!-- <input type="hidden" class="form-control fldtxt" placeholder="State" name="state" name="state" value="19"> -->
									</div>
									<div class="col-md-3">
									<select class="form-control fldtxt" name="city"> 
										@foreach($city as $row)
											<option value="{{$row->ID}}">{{$row->CITY}}</option>
										@endforeach	
										</select> 									</div>
									</div>
									<div class="row">
									<div class="col-md-3">
									<!-- <input type="text" class="form-control fldtxt" placeholder="Department" name="department" value="Sales" readonly > -->
									</div>
								</div>
								<div class="row">
								<div class="col-md-3">
									<input type="file" class="form-control fldtxt" id="image" name="image" >   
								</div>
								</div>
								<!-- <div class="row">
									 <div class="col-md-12">
							6			<form action="/" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data">
			                                <div class="dz-message">
			                                    <img src="{{asset('assets/salemanager/images/touch.png')}}">
			                                    <h3>Drop files here or click to upload.</h3>
			                                    <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em> 
			                                </div>
			                                <div class="fallback">
			                                    <input name="file" type="file" multiple />
			                                </div>
			                            </form>
									</div> -->
								<!-- </div> -->
								<div class="row mt-4">
									<div class="col-md-12">
										<input type="submit" value="submit" style="background: #00CC4B;border: none;color: #fff;padding: 10px 28px;border-radius: 50px;font-size: 20px;">
										<!-- <a ><button class="btn_save">Save</button></a> -->
										<a href="{{route('salemanagerTeam')}}"><button class="btn_cancl">Cancel</button></a>
									</div>
								</div>
							</div>
						</form>	
						</div>
						<!-- property data end -->
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
		</section>
		<!-- right area end -->
	</div>
	<!-- main div end -->

	<!-- add-customer-popup -->
	<!-- The Modal -->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Add Customer</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
		
				<!-- Modal body -->
				<div class="modal-body">
					<div class="main_form">
						<label>Name</label>
						<input type="text" class="form-control fldtxt" name="">
						<label>Email Id</label>
						<input type="text" class="form-control fldtxt" name="">
						<label>Phone No.</label>
						<input type="text" class="form-control fldtxt" name="">
						<label>City</label>
						<input type="text" class="form-control fldtxt" name="">
						<button class="btn btn-success svbtn">Save</button>
					</div>
				</div>	
			</div>
		</div>
	</div>
	<!-- add-customer-popup -->
@endsection
@section('page_js')
<script>
	$(document).ready(function () {
		$('#addTeamForm').validate({
		rules: {
				username:{
					required:true,
					lettersonly:true
				},
				email:{
					required:true,
					email:true
				},
                phone:{ 
                    required:true,
                    number:true,
                    minlength:10,
                    maxlength:13  
                } ,
                city:{
                    required:true
				},
				password:{
                    number:true,
                    minlength:6,
                    required:true
                } ,
                confirm_password:{ 
                    equalTo:'[name="password"]',
                } ,   
				image: {
                    extension: "jpg|jpeg|png|"
                },
            },
        messages: {
			password:{
                        required:"Please enter password.",
                        minlength:"Password should be more than 6 characters",
                    },
            confirm_password:{
                            // required:"Please enter confirm password Same as new password",
            },
            phone:{
                required:"Please enter a mobile number ",
                number:"Please enter numeric value",
                minlength:"Mobile should be more than 10 characters",
                maxlength:"Mobile should be less than 13 characters",
            },
			username:{
				required:"Please enter name",
				lettersonly:"Please enter letters only"
			},
			email:{
				required:"Please enter email",
				email:"Please enter valid email"
			},
			city:{
                required:"Please select  city"
			},
			image:{
                extension:"Please choose jpeg,png,jpg file" 
        	},
        },
	});
});
</script>
@endsection