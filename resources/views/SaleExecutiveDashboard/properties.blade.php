@extends('SaleExecutiveDashboard.master')
@section('content')

	<!-- main div start -->
	<div class="main_area">
		@include('SaleExecutiveDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SaleExecutiveDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
			@if ($message = Session::get('success'))
				<div class="alert alert-success alert-block">
					<button type="button" class="close" data-dismiss="alert">×</button>	
					<strong>{{ $message }}</strong>
				</div>
			@endif
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-12 main_btn">
							<div class="flex_btn">
								<div class="tab_btn">
									<nav>
										<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
											<a class="nav-item nav-link active" id="nav-actives-tab" data-toggle="tab" href="#nav-actives" role="tab" aria-controls="nav-actives" aria-selected="true">Active</a>
											<a class="nav-item nav-link" id="nav-expired-tab" data-toggle="tab" href="#nav-expired" role="tab" aria-controls="nav-expired" aria-selected="false">Expired</a>
											<a class="nav-item nav-link" id="nav-draft-tab" data-toggle="tab" href="#nav-draft" role="tab" aria-controls="nav-draft" aria-selected="false">Draft</a>
										</div>
									</nav>
								</div>
								<div class="add_btn">
									<a href="#"><i class=" fa fa-plus"></i>List New</a>
								</div>
							</div>
						</div>
						<!--property data start -->
						<div class="col-md-12 main_top_selling">
							<div class="tab-content px-3 px-sm-0" id="nav-tabContent">
								<div class="tab-pane fade show active" id="nav-actives" role="tabpanel" aria-labelledby="nav-actives-tab">
									<div class="inside">
										<table id="active_data" class="display display2 responsive nowrap" width="100%">
											<thead>
											    <tr>
											        <th>Property</th>
											        <th>Leads</th>
											        <th>Stats</th>
											        <th>Posted On</th>
											        <th>Status</th>
											        <th>Action</th>
											    </tr>
											</thead>
											
										</table>
									</div>
								</div>
								<!-- second-tab -->
								<div class="tab-pane fade" id="nav-expired" role="tabpanel" aria-labelledby="nav-expired-tab">
									<div class="inside">
										<table id="expired_data" class="display display2 responsive nowrap" width="100%">
											<thead>
											    <tr>
											        <th>Property</th>
											        <th>Leads</th>
											        <th>Stats</th>
											        <th>Posted On</th>
											        <th>Status</th>
											    </tr>
											</thead>
											
										</table>
									</div>
								</div>
								<!-- second-tab-end -->

								<!-- second-tab -->
								<div class="tab-pane fade" id="nav-draft" role="tabpanel" aria-labelledby="nav-draft-tab">
									<div class="inside">
										<table id="draft_data" class="display display2 responsive nowrap" width="100%">
											<thead>
											    <tr>
											        <th>Property</th>
											        <th>Leads</th>
											        <th>Stats</th>
											        <th>Posted On</th>
											        <th>Status</th>
											    </tr>
											</thead>
										
										</table>
									</div>
								</div>
								<!-- second-tab-end -->
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
@endsection	
@section('page_js')
<script type="text/javascript">
	$(document).ready(function() {
		$('#active_data').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "{{ route('saleExecutive.activeProperty') }}",
			"columns":[
				// {"data": 'DT_RowIndex'},
				{ "data": "property", name: 'action', orderable: false, searchable: false},
				
				{"data": 'leads', name: 'sales', orderable: false, searchable: false},
				{"data": 'stats', name: 'commision', orderable: false, searchable: false},
				{"data":"date"},
				{"data":"status",name: 'action', orderable: false, searchable: false},
				{"data": 'action',className:"action", name: 'action', orderable: false, searchable: false},
			],
			'createdRow': function( row, data, index ) {
				$(row).addClass( 'data-row' );
			},
			dom: 'lBfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf',
			],
		});
	});
	</script>
<script type="text/javascript">
	$(document).ready(function() {
		$('#expired_data').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "{{ route('saleExecutive.expiredProperty') }}",
			"columns":[
				// {"data": 'DT_RowIndex'},
				{ "data": "property", name: 'property', orderable: false, searchable: false},
				
				{"data": 'leads', name: 'sales', orderable: false, searchable: false},
				{"data": 'stats', name: 'commision', orderable: false, searchable: false},
				{"data":"date"},
				{"data":"status",name: 'status', orderable: false, searchable: false},
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
		$('#draft_data').DataTable({
			"processing": true,
			"serverSide": true,
			"ajax": "{{ route('saleExecutive.draftProperty') }}",
			"columns":[
				// {"data": 'DT_RowIndex'},
				{ "data": "property", name: 'property', orderable: false, searchable: false},
				
				{"data": 'leads', name: 'sales', orderable: false, searchable: false},
				{"data": 'stats', name: 'commision', orderable: false, searchable: false},
				{"data":"date"},
				{"data":"status",name: 'status', orderable: false, searchable: false},
			],
			dom: 'lBfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf',
			],
		});
	});
	</script>
@endsection	