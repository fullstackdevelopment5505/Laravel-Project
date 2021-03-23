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
										<button type="button" class="btn btn-success">Search</button>
									</form>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Wallet</div>
								<table class="display responsive nowrap" width="100%" id="walletList">
									<thead>
										<tr>
										    <th>Date</th>
										    <th>Customer name</th>
										    <th>Deposit Amount</th>
										    <th>Tax %</th>
										    <th>Cash</th>
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

	<script type="text/javascript">	
		$(document).ready(function() {
			
			$('#walletList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('wallet') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{title: "date",data: "date",
                   render: function(d) {
                   return moment(d).format("DD-MMM-YYYY");}},
					{"data":"name","name":"name"},
					{"data":"amount"},
					{"data":"tax"},
					{"data":"cash"}	
				],
				"order": [[ 0, 'desc' ]] ,
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
				],
				"aoColumnDefs": [ {
                         "aTargets": [ 2,3,4 ],
                         "mRender": function (data, type, full) {
     					 return data.toString().match(/\d+(\.\d{1,2})?/g)[0];
 }
                    }],
				"bDestroy": true
			});
		});
	</script>


@endsection