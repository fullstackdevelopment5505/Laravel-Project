
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
							</div>
						</div>
						<!-- datepicker -->

						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">general ledger</div>
								<table class="display responsive nowrap" width="100%" id="JournaleadgerLeList">
									<thead>
									    <tr>
									        <th>date</th>
									       <!-- // <th>Payment Method</th> -->
									        <th>Amount</th>
									        <th>Account Type</th>
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

	@endsection
	@section('page_js')

<!-- Fetching Leadger report list -->
 

	<script type="text/javascript">	


		$(document).ready(function() {
			
			$('#JournaleadgerLeList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('journalGeneralLedger') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"created_at",name:"created_at"},
					// {"data":"paymnent_method",name:"paymnent_method",orderable:false,searchable:false},

					{"data":"amount",name:"amount",orderable:false,searchable:false},

				
					{"data":"type"},
					{data: 'action', name: 'action', orderable: false, searchable: false}
				],
				"order": [[0, 'desc' ]] ,
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
					
				],
				"bDestroy": true
			});
		});
	</script>
@endsection	