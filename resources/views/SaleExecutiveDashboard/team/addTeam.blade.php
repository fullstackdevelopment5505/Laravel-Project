@extends('SaleExecutiveDashboard.master')
@section('content')
<style>
.error{
	color:red;
}

</style>
	<!-- main div start -->
	<div class="main_area">
		@include('SaleExecutiveDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			<!-- header start -->
			<header class="header_area">
				<div class="col-sm-6 l_head">
					<div class="toggle">
						<span></span>
					</div>
					<div class="heading_title">
						Add Team
					</div>
					<!-- <div class="headline"><h2>Account Dashboard</h2></div> -->
				</div>

				<div class="col-sm-6 r_head">
					<div class="search">
						<i class="fa fa-search show_search"></i>
						<i class="fa fa-remove remove_search"></i>
					</div>
					<div class="notification">
						<i class="fa fa-envelope"></i>
						<span>13</span>
					</div>
					<div class="expand" onclick="toggleFullScreen();"><i class="fa fa-arrows-alt"></i></div>
					<div class="user">
						<span><img src="{{asset('assets/saleExecutive/images/user.png')}}"> <i class="fa fa-caret-down"></i></span>
						<div class="user_detail">
							<ul>
								<li><a href="#">My Profile</a></li>
								<li><a href="#">Logout</a></li>
							</ul>
						</div>
					</div>
				</div>
			</header>	
			<!-- header end -->
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-md-12">
					<div class="row row-eq-height">
						<!--property data start -->
						<div class="col-md-12 add_team">
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
							<form action="{{route('sale_executive.addTeam')}}" id="addTeamForm" method="post" enctype="multipart/form-data">
							{{@csrf_field()}}	
							<div class="inside">
								<div class="row">
									<div class="col-md-3">
										<input type="text" class="form-control fldtxt" placeholder="First Name" name="first_name">
									</div><br>
									<div class="col-md-3">
										<input type="text" class="form-control fldtxt" placeholder="Last Name" name="last_name">
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control fldtxt" placeholder="Email" name="email">
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control fldtxt" placeholder="Phone Number" name="phoneno">
									</div>
									<div class="col-md-3">
										<input type="date" class="form-control fldtxt datepicker" placeholder="Date of Birth" name="dob">
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control fldtxt" placeholder="Age" name="age">
									</div>
									<div class="col-md-3">
										<select class="form-control fldtxt" name="gender">
											<option value="Male">Male</option>
											<option value="Female">Female</option>
										</select>
									</div>
									<div class="col-md-3">
										<input type="text" class="form-control fldtxt" placeholder="City" name="city">
									</div>
									<div class="col-md-3">
										<select class="fontsrm-control fldtxt" name="department">
											<option value="">--Choose-Department--</option>
											<option value="Marketing">Marketing</option>
											<option value="Accounts">Accounts</option>
											<option value="Development">Development</option>
										</select>
									</div>	
								</div>
								<!-- <div class="row dropzone" id="frmFileUpload"  >
									<div class="col-md-12">
			                             <div class="dz-message">
			                                <img src="{{asset('assets/saleExecutive/images/touch.png')}}">
			                                <h3>Drop files here or click to upload.</h3>
			                                <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em> 
			                                </div>
			                                <div class="fallback">
			                                    <input name="file" type="file" multiple />
			                                </div>
									</div>
								</div> -->
								<!-- <div class="row">
									<div class="col-md-12"> -->
										<!-- <form action="/" id="frmFileUpload" class="dropzone" method="post" enctype="multipart/form-data"> -->
			                                <!-- <div class="dz-message">
			                                    <img src="{{asset('assets/saleExecutive/images/touch.png')}}">
			                                    <h3>Drop files here or click to upload.</h3>
			                                    <em>(This is just a demo dropzone. Selected files are <strong>not</strong> actually uploaded.)</em> 
			                                </div>
			                                <div class="fallback">
			                                    <input name="file" type="file" multiple />
			                                </div> -->
			                            <!-- </form> -->
									<!-- </div>
								</div> -->
								<div class="row mt-4">
									<div class="col-md-12">
									<input type="submit" class="btn_save" value="Save">

										<!-- <a href="{{route('saleExecutiveTeam')}}"><button class="btn_save">Save</button></a> -->
										<a href="{{route('saleExecutiveTeam')}}"><button class="btn_cancl">Cancel</button></a>
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