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
										    <input type="text" class="form-control datepicker" placeholder="Date" id="date_from" name="date_from">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date" id="date_to" name="date_to">
										</div>
										<button type="button" id="search_submit_purchase" class="btn btn-success">Search</button>
									</form>
									
								</div>

								<div class="col-sm-4 top_btns">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New Report<i class="fa fa-plus"></i></button>
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal1">Add Bulk Reports<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->

						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								 <div class="title">Purchase Data Tree</div>
								<table class="display responsive nowrap" width="100%" id="purchaseDataTree">
									<thead>
										<tr>
										    <th>Date</th>
										    <th>Report Type</th>
										    <th>Amount</th>
										    <th>Tax</th>
										    <th>Actual Purchase</th>
											<th>Total Purchase</th>
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
					<h4 class="modal-title"><b>Add New Report</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				  <form action="{{route('saveDataTreeFinderData')}}" method="post" id="customerForm" >
					{{@csrf_field()}}
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Select Report</label>
								<select class="form-control" id="report" name="report">
								<option value="1.95&Gl-101&ForeclosureReport">Foreclosure Report</option>
								<option value="5.85&Gl-102&OpenLienReport">Open Lien Report</option>
								<option value="0.70&Gl-103&PropertyDetailReport">Property Detail Report</option>
								<option value="2.30&Gl-104&TaxStatusReport">Tax Status Report</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Report Qty</label>
							    <input type="text" class="form-control" id="qty" name="qty" required onChange="checkOption(this)">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Amount</label>
							    <input type="text" class="form-control" id="amount" name="amount">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Select Payment Mode</label>
								<select id="brand" name="brand" class="form-control">
								<option value="Paypal">Paypal</option>
								<option value="Stream">Stream</option>
								<option value="Cash">Cash</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Batch Num</label>
								<input type="text" class="form-control" id="batch_no" name="batch_no">
							</div>
						</div>

					
					</div>
					<div class="modal-footer pl-0 pr-0">
					<div class="col-md-12 text-center p-0"> 
					<input type="hidden" name="type" value="datatree_single_entry">
					<input type="submit" class="btn btn-success svbtn" value="Save">
						<a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
					</div>
				</div>
				</form>				
				</div>	
			</div>
		</div>
	</div>
	<!-- popup start from here-->
	<div class="modal fade" id="myModal1">
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Add Bulk Entry</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				  <form action="{{route('saveDataTreeFinderData')}}" method="post" id="customerForm1" >
					{{@csrf_field()}}
					<div class="row">
						<div class="col-sm-6">
							<div class="form-group">
							<label>Bulk Purchase</label>
								<select class="form-control" id="report" name="report" readonly>
								<option value="BP-201&BulkPurchase">Bulk Purchase</option>
								</select>
							</div>
						</div>
					
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Amount</label>
							    <input type="text" class="form-control" id="amount" name="amount" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Select Payment Mode</label>
								<select id="brand" name="brand" class="form-control">
								<option value="Paypal">Paypal</option>
								<option value="Stream">Stream</option>
								<option value="Cash">Cash</option>
								</select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Batch Num</label>
								<input type="text" class="form-control" id="batch_no" name="batch_no" required>
							</div>
						</div>

					
					</div>
					<div class="modal-footer pl-0 pr-0">
					<div class="col-md-12 text-center p-0"> 
					<input type="submit" class="btn btn-success svbtn" value="Save">
					<input type="hidden" name="type" value="datatree_bulk_entry">
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

<script type="text/javascript">	
	$(document).ready(function() {
		
		$('#purchaseDataTree').DataTable({
			"processing": true,
			"serverSide": true,  
			ajax: {
				url: "{{route('superadminPurchaseDataTree')}}",
				data: function (d) {
					d.date_from = $('input[name="date_from"]').val();
					d.date_to =$('input[name="date_to"]').val();	
				}
			},			
			"columns":[
				// {"data": 'DT_RowIndex'},
				{"data":"date" , render: function(d){
					return moment(d).format('DD-MMM-YYYY');
					},
				},
				{"data":"report"},
				{"data":"amount"},
				{"data":"tax"},
				{"data":"cash"},
				{"data":"total"}
			],
			"order": [[ 0, 'desc' ]] ,
			dom: 'lBfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf',
			],
			"bDestroy": true
		});
		 $('#search_submit_purchase').click(function(){	
			$('#purchaseDataTree').DataTable().draw(true);
		});
	});
</script>
<script>
	function checkOption(obj) {
    var amount = document.getElementById("report").value;
	var newAmount = amount.split("&");	
	console.log(newAmount, newAmount[0],'jhkhk')
	var qty = document.getElementById("qty").value;	
	debugger;		
	if(newAmount[0]!="" && qty!="")
	{
		var result=qty*newAmount[0];
		
		document.getElementsByName('amount')[0].value= result;
	}
}
	</script>
@endsection