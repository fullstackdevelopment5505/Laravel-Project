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
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New Leave<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Leave Requests</div>
								<table class="display responsive nowrap" width="100%" id="LeaveRequestList">
									<thead>
										<tr>
											<th>Employee ID</th>
											<th>Employee Name</th>
											<th>Department</th>
											<th>Holiday From</th>
											<th>Holiday To</th>
											<th>No. Of Days</th>
											<th>Reason</th>
											<th>Leave Type</th>
											<th>Status</th>												
										</tr>
									</thead>
									
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
					<h4 class="modal-title"><b>Add New Leave</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				  <form action="{{route('leaveRequest.add')}}" method="post" id="customerForm" >
					{{@csrf_field()}}
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Employee ID</label>
							    <input type="text" class="form-control" id="employee_id" name="employee_id">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Employee Name</label>
							    <input type="text" class="form-control"  id="employee_name" name="employee_name">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Department</label>
							    <input type="text" class="form-control"  id="department" name="department">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Leave Type</label>
							    <select class="form-control" id="leave_type" name="leave_type">
							    	<option>Casual Leave</option>
							    	<option>Medical</option>
							    	<option>Loss of Pay</option>
							    </select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Holiday From</label>
							    <input type="text" class="form-control datepicker" id="holiday_from" name="holiday_from">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Holiday To</label>
							    <input type="text" class="form-control datepicker" id="holiday_to" name="holiday_to">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>No. Of Days</label>
							    <input type="text" class="form-control" id="no_of_days" name="no_of_days">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Status</label>
							    <select class="form-control" id="status" name="status">
							    	<option>Approved</option>
							    	<option>Pending</option>
							    	<option>Reject</option>
							    </select>
							</div>
						</div>
						<div class="col-sm-12">
							<div class="form-group">
							    <label>Reason</label>
							    <textarea class="form-control" rows="4" id="reason" name="reason"></textarea>
							</div>
						</div>
					</div>
					<div class="modal-footer pl-0 pr-0">
					<div class="col-md-12 text-center p-0"> 
					<input type="submit" class="btn btn-success svbtn" value="Save">
						<a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
					</div>
				</div>
				</form>				
				</div>	
			</div>
		</div>
	</div>

	@endsection
	@section('page_js')

<!-- Fetching Leave Request report list -->
 

	<script type="text/javascript">	


		$(document).ready(function() {
			
			$('#LeaveRequestList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('employee.leaveRequestlist') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"employee_id"},
					{"data":"employee_name"},
					{"data":"department"},				
					{"data":"holiday_from"},
					{"data":"holiday_to"},
					{"data":"no_of_days"},				
					{"data":"reason"}, 
					{"data":"leave_type"},
					{"data":"status"}
				
				],
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
				],
				"bDestroy": true
			});
		});
	</script>
@endsection