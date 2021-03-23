
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
						<!-- datepicker -->
						<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-8 from_to_filter">
									<!--<form>
										<div class="form-group">
										    <label>From:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<button type="button" class="btn btn-success">Search</button>
									</form>-->
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
									        <th>Date & Time</th>
									        <th>Account Title</th>
									        <th>Account Type</th>
									        <th>Debit</th>
									        <th>Credit</th>
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
					{title: "created_at",data: "created_at",
                   render: function(d) {
                   return moment(d).format("DD-MMM-YYYY");}},
					{"data":"mode",name:"mode"},
					{"data":"type"},
					{"data":"debit",name:"debit"},
					{"data":"credit",name:"credit"}
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