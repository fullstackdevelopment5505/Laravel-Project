@extends('SaleExecutiveDashboard.master')
@section('content')

	<!-- main div start -->
	<div class="main_area">

		@include('SaleExecutiveDashboard.layouts.sidebar');	
			<!-- right area start -->
			<section class="right_section">
				@include('SaleExecutiveDashboard.layouts.header');	
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
				<!-- inside_content_area start-->
				<div class="content_area">
					<div class="col-md-12">
						<div class="row row-eq-height">
							<div class="col-md-12 main_btn">
								<div class="flex_btn">
									<div class="tab_btn"></div>
									<div class="add_btn">
										<a href="JavaScript:void()" data-toggle="modal" data-target="#myModal"><i class=" fa fa-plus"></i>Add New</a>
									</div>
								</div>
							</div>
							<div class="col-sm-12 customer_tabs">
								<ul class="nav nav-pills">
									<li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#member">Member</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#non-member">Non-Members</a></li>
								</ul>
							</div>
							
							<div class="tab-content">
								<!--property data start -->
								<div class="col-sm-12  tab-pane top_selling active" id="member">
									<div class="inside">
										<table id="memberList" class="display display2 responsive nowrap" width="100%">
										    <thead>
												<tr>
													<!-- <th>Sr. No.</th> -->
													<th>Date</th>
													<th>Name</th>
													<th>E-Mail</th>
													<th>Phone Number</th>
													<th>Location</th>
													<th>Property Description</th>
													<th>Report Name</th>
													<th>Price</th>
													<th>Commission</th>
													<th>Status</th>
													<th>Action</th>
												</tr>
											</thead>
										</table>
									</div>
								</div>
								<!-- property data end -->
								<!--property data start -->
								<div class="col-sm-12  tab-pane top_selling fade" id="non-member">
									<div class="inside">
										<table id="non_memberList" class="display display2 responsive nowrap" width="100%">
										   <thead>
												<tr>
													<!-- <th>Sr. No.</th> -->
													<th>Date</th>
													<th>Name</th>
													<th>E-Mail</th>
													<th>Phone Number</th>
													<th>Location</th>
													<th>Action</th>
												</tr>
											</thead>
										</table>
									</div>
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
					<form action="{{route('customer.add')}}" method="post" id="customerForm">
					{{@csrf_field()}}
					<div class="main_form">
						<label>Name</label>
						<input type="text" class="form-control fldtxt" name="name" ><br>
						<label>Email Id</label>
						<input type="text" class="form-control fldtxt" name="email"><br>
						<label>Phone No.</label>
						<input type="text" class="form-control fldtxt" name="phoneno"><br>
						<label>Location</label>
						<input type="text" class="form-control fldtxt" name="location"><br>
						<label>Type of customer</label>
						<select class="form-control fldtxt" id="type"  name="type"  onChange="checkOption(this)" required>
							<option value = "">Type of customer</option>
							<option value = "member">Member</option>
							<option value = "non_member">Non-Member</option>
						</select><br>
						<label>Property Description</label>
						<input type="text" class="form-control fldtxt" id="property_description" name="property_description">
						<label>Report Name</label>
						<input type="text" class="form-control fldtxt" id="report_name" name="report_name">
						<label>Price</label>
						<input type="text" class="form-control fldtxt" id="price" name="price">
						<input type="submit" class="btn btn-success svbtn" value="Save">
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

@endsection	
	@section('page_js')
	<script>
	function checkOption(obj) {
    var property = document.getElementById("property_description");
	property.disabled = obj.value == "non_member";
	var report = document.getElementById("report_name");
	report.disabled = obj.value == "non_member";
	var price = document.getElementById("price");
	price.disabled = obj.value == "non_member";

}
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#memberList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('member.list') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"date"},
					{ "data": "name"},
					{"data":"email"},
					{"data":"phoneno"},
					{"data":"location"},
					{"data":"property_description"},
					{"data":"report_name"},
					{"data":"price"},
					{data: 'commision', name: 'commision', orderable: false, searchable: false},
					{data: 'status', name: 'status', orderable: false, searchable: false},
					{data: 'action', name: 'action', orderable: false, searchable: false},
				],
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
				],
			});
			
		});
	</script>
	<script type="text/javascript">
		$(document).ready(function() {
			$('#non_memberList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('non_member.list') }}",
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"date"},
					{ "data": "name" },
					{"data":"email"},
					{"data":"phoneno"},
					{"data":"location"},
					{data: 'view', name: 'view', orderable: false, searchable: false},

				],
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
				],
			});
			
		});
	</script>
	<!-- add-customer-popup -->
@endsection
	