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
			@include('SaleExecutiveDashboard.layouts.header');	
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
								<li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#sale_manager">Sales Manager</a></li>
								<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#sale_executive">Sales Executive</a></li>
							</ul>
						</div>
						<div class="tab-content">
							<!--property data start -->
							<div class="col-sm-12  tab-pane top_selling active" id="sale_manager">
								<div class="inside">
									<table id="sale_managerList" class="display display2 responsive nowrap" width="100%">
										<thead>
											<tr>
												<!-- <th>Sr. No.</th> -->
												<th>Name</th>
												<th>Location</th>
												<th>Action</th>
											</tr>
										</thead>
									</table>
								</div>
							</div>
							<!-- property data end -->
							<!--property data start -->
							<div class="col-sm-12  tab-pane top_selling fade" id="sale_executive">
								<div class="inside">
									<table id="sale_ExecutiveList" class="display display2 responsive nowrap" width="100%">
										<thead>
											<tr>
												<!-- <th>Sr. No.</th> -->
												<th>Name</th>
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
					<form action="{{route('contact.add')}}" method="post" id="contactForm">
						{{@csrf_field()}}
						<div class="main_form">
							<label>Name</label>
							<input type="text" class="form-control fldtxt" name="name"><br>
							<label>Email Id</label>
							<input type="text" class="form-control fldtxt" name="email"><br>
							<label>Phone No.</label>
							<input type="text" class="form-control fldtxt" name="phoneno"><br>
							<label>Location</label>
							<input type="text" class="form-control fldtxt" name="location"><br>
							<label>Type of contact</label>
							<select class="form-control fldtxt" id="type"  name="type"  onChange="checkOption(this)" required>
								<option value = " ">Type of contact</option>
								<option value = "sale_manager">Sale Manager</option>
								<option value = "sale_executive">Sale Executive</option>
							</select>
							<input type="submit" class="btn btn-success svbtn" value="Save">
						</div>
					</form>	
				</div>
			</div>
		</div>
	</div>
@endsection	
	@section('page_js')
	<script type="text/javascript">
		$(document).ready(function() {
			$('#sale_managerList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('saleManager.list') }}",
				"columns":[
					// {"data": 'DT_RowIndex'},
					{ "data": "name" },
					{"data":"location"},
					{data: 'message', name: 'message', orderable: false, searchable: false},
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
			$('#sale_ExecutiveList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('saleExecutive.list') }}",
				"columns":[
					// {"data": 'DT_RowIndex'},
					{ "data": "name" },
					{"data":"location"},
					{data: 'message', name: 'message', orderable: false, searchable: false},

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
	