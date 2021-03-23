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
										    <label>From:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<button type="button" class="btn btn-success">Search</button>
									</form>
								</div>
								<div class="col-sm-4 top_btns">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add Salary<i class="fa fa-plus"></i></button>
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
											<th>Salary</th>
											<th>Payslip</th>
										</tr>
									</thead>
									<tbody>
										<tr>
											<td><span class="empl_img"><img src="{{asset('assets/account/images/empl1.png')}}"></span> <span class="user_name">Marry Willy</span></td>
											<td>#0021</td>
											<td>marryfahim93@gmail.com</td>
											<td>+123-8865234</td>
											<td>1 Jan 2020</td>
											<td>Employee</td>
											<td>$11,340.0</td>
											<td><a href="#" class="btn btn-success">Generate Slip</a></td>
										</tr>
										<tr>
											<td><span class="empl_img"><img src="{{asset('assets/account/images/empl3.png')}}"></span> <span class="user_name">Jeesie Willy</span></td>
											<td>#0022</td>
											<td>JeesieWilly@gmail.com</td>
											<td>+123-689658253</td>
											<td>8 Jan 2020</td>
											<td>Broker</td>
											<td>$20,000.0</td>
											<td><a href="#" class="btn btn-success">Generate Slip</a></td>
										</tr>
										<tr>
											<td><span class="empl_img"><img src="{{asset('assets/account/images/empl2.png')}}"></span> <span class="user_name">Mike</span></td>
											<td>#0023</td>
											<td>mike@gmail.com</td>
											<td>+123-6546545</td>
											<td>10 Jan 2020</td>
											<td>Broker</td>
											<td>$20,000.0</td>
											<td><a href="#" class="btn btn-success">Generate Slip</a></td>
										</tr>
										<tr>
											<td><span class="empl_img"><img src="{{asset('assets/account/images/empl1.png')}}"></span> <span class="user_name">Marry Willy</span></td>
											<td>#0021</td>
											<td>marryfahim93@gmail.com</td>
											<td>+123-8865234</td>
											<td>1 Jan 2020</td>
											<td>Employee</td>
											<td>$11,340.0</td>
											<td><a href="#" class="btn btn-success">Generate Slip</a></td>
										</tr>
										<tr>
											<td><span class="empl_img"><img src="{{asset('assets/account/images/empl3.png')}}"></span> <span class="user_name">Jeesie Willy</span></td>
											<td>#0022</td>
											<td>JeesieWilly@gmail.com</td>
											<td>+123-689658253</td>
											<td>8 Jan 2020</td>
											<td>Broker</td>
											<td>$20,000.0</td>
											<td><a href="#" class="btn btn-success">Generate Slip</a></td>
										</tr>
										<tr>
											<td><span class="empl_img"><img src="{{asset('assets/account/images/empl2.png')}}"></span> <span class="user_name">Mike</span></td>
											<td>#0023</td>
											<td>mike@gmail.com</td>
											<td>+123-6546545</td>
											<td>10 Jan 2020</td>
											<td>Broker</td>
											<td>$20,000.0</td>
											<td><a href="#" class="btn btn-success">Generate Slip</a></td>
										</tr>
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
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Add Salary</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Emp. ID</label>
							    <input type="text" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Emp. Name</label>
							    <select class="form-control">
									<option>Jeesie Willy</option>
									<option>Marry Willy</option>
									<option>Mike Miller</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Designation</label>
							    <input type="text" class="form-control">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Net Salary</label>
							    <input type="text" class="form-control" disabled="disabled">
							</div>
						</div>

						<div class="col-sm-6">
							<h1 class="earning_titles_popups">Earnings:</h1>
							<div class="form-group">
							    <label>Basic</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>DA(7%)</label>
							    <input type="text" class="form-control" disabled="disabled">
							</div>
							<div class="form-group">
							    <label>HRA(10%)</label>
							    <input type="text" class="form-control" disabled="disabled">
							</div>
							<div class="form-group">
							    <label>Conveyance</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Allowance</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Medical Allowance</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Others</label>
							    <input type="text" class="form-control">
							</div>
						</div>

						<div class="col-sm-6">
							<h1 class="earning_titles_popups">Deductions:</h1>
							<div class="form-group">
							    <label>TDS (max upto 20%)</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>ESI</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>PF</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Leave</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Prof. Tax (%)</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Labour Welfare</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Fund</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Loan</label>
							    <input type="text" class="form-control">
							</div>
							<div class="form-group">
							    <label>Others</label>
							    <input type="text" class="form-control">
							</div>
						</div>
						
					</div>
				</div>

				<div class="modal-footer pl-0 pr-0">
					<div class="col-md-12 text-center p-0"> 
						<a href="#" type="btn" class="btn btn-success">Create Salary</a>
						<a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
					</div>
				</div>
			</div>
		</div>
	</div>
@endsection
	