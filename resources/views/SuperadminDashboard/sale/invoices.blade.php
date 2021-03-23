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
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
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
						<!-- datepicker -->
						<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-8 from_to_filter">
									<form>
										<div class="form-group">
										    <label>From:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<div class="form-group">
										    <label>Status:</label>
										    <select class="form-control">
										    	<option>Pending</option>
										    	<option>Paid</option>
										    	<option>Partially Paid</option>
												<option>Sent</option>
										    </select>
										</div>
										<button type="button" class="btn btn-success">Search</button>
									</form>
								</div>
								<div class="col-sm-4 top_btns">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create new Invoice<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->

						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Invoices</div>
									<table class="display responsive nowrap" width="100%" id="invoiceList">
										<thead>
											<tr>
												<th>Sr. No.</th>
												<th>Invoice No.</th>
												<th>Client</th>
												<th>Created Date</th>
												<th>Due Date</th>
												<th>Amount</th>
												<th>Status</th>
												<th>Action</th>
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
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Create New Invoice</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				 <form action="{{route('invoice.add')}}" method="post" id="customerForm" >
					{{@csrf_field()}}
					<div class="row">
					<div class="col-sm-6">
							<div class="form-group">
							    <label>Invoice For</label>
								<!-- <input type="text" class="form-control" id="project" name="project"> -->
							    <select class="form-control" id="project" name="project">
								<option>Please Select Project....</option>
									<option>Reports</option>
									<option>Property</option>
									<option>Sale Reorts</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Data Provider</label>
							
								<!-- <input type="text" class="form-control" id="client_name" name="client_name"> -->

							    <select class="form-control" id="client_name" name="client_name">
								<option>Please Select Provider....</option>
									@foreach($customer as $customers)
									
									<option value="{{ $customers->name }}">{{ $customers->name}}</option>
									@endforeach 	 
								</select>
							</div>
						</div>

			
						<div class="col-sm-6">
							<div class="form-group">
							    <label>E-Mail</label>
							    <input type="email" class="form-control" id="email" name="email">

							
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Tax Category</label>
								<!-- <input type="text" class="form-control" id="tax" name="tax"> -->
							    <select class="form-control" id="tax" name="tax">
									<option>Please select Category ...</option>
									<option>Sale</option>
									<option>Purchase</option>															
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Billing Address</label>
							    <textarea class="form-control" rows="5" id="billing_address" name="billing_address"></textarea>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Client Address</label>
							    <textarea class="form-control" rows="5" id="client_address" name="client_address"></textarea>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Estimated Date</label>
							    <input type="text" class="form-control datepicker" id="estimated_date" name="estimated_date">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Expected Date</label>
							    <input type="text" class="form-control datepicker" id="expected_date" name="expected_date">
							</div>
						</div>
					</div>

					<div class="col-sm-12 mt-3 mb-5">
						<div class="row">
							<div class="table-responsive">
								<table class="table">
									<thead class="thead-dark">
										<tr>
											<th>#</th>
											<th>Item</th>
											<th>Description</th>
											<th>Unit Cost</th>
											<th>Quantity</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody id="new_invoice">
										<tr>
											<td>1</td>
											<td><input type="text" class="form-control" id="item_name" name="item_name"></td>
											<td><input type="text" class="form-control" id="item_description" name="item_description"></td>
											<td><input type="text" class="form-control" id="unit_cost" name="unit_cost"></td>
											<td><input type="text" class="form-control" id="quantity" name="quantity" onChange="checkOption(this)"></td>
											<td><input type="text" class="form-control" id="amount" name="amount" readonly></td>
										</tr>
									</tbody>
								</table>
							</div>
							<div class="col-sm-12 text-center"><button class="btn btn-success add_new_item">Add New Item</button></div>							
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
							    <label>Subtotal</label>
							    <input type="text" class="form-control" id="sub_total" name="sub_total"  readonly>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							    <label>Tax</label>
							    <input type="text" class="form-control" id="item_tax" name="item_tax">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							    <label>Discount%</label>
							    <input type="text" class="form-control" id="discount" name="discount">
							</div>
						</div>
						<div class="col-sm-12 total">
							<h1>Total: <span>$0.00</span></h1>
						</div>
					</div>

					<div class="modal-footer pb-0 pl-0 pr-0">
						<div class="col-md-12 text-center p-0"> 
							<input type="submit" class="btn btn-success svbtn" value="Save">
							<a href="#" type="btn" class="btn btn-primary ml-1">Save & Send</a>
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

<!-- Fetching sale report list -->
 
<script>
	var i=1;	
	$(".add_new_item").click(()=>{
		var appHtm='<tr><td>'+(++i)+'</td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td><td><input type="text" class="form-control"></td></tr>';
		$("#new_invoice").append(appHtm);
	});
	</script>
	<script type="text/javascript">	


		$(document).ready(function() {
			
			$('#invoiceList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('invoices') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"id"},
					{"data":"invoice_no"},
					{"data":"client_name"},
					{"data":"created_at"},
					{"data":"created_at"},
					{"data":"tax"},
					{"data":"status"},
					{data: 'action', name: 'action', orderable: false, searchable: false}
				],
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
				],
				"bDestroy": true
			});
		});
	</script>

<script>
	function checkOption(obj) {
    var unit_cost = document.getElementById("unit_cost").value;	
	var quntity = document.getElementById("quantity").value;			
	if(unit_cost!="" && quantity!="")
	{
		var result=unit_cost*quntity;
		document.getElementsByName('amount')[0].value= result;
		document.getElementsByName('sub_total')[0].value= result;
	}
}
	</script>

@endsection