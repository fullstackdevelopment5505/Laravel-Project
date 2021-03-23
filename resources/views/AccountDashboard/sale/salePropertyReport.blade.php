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
								<div class="col-sm-8 from_to_filter input-daterange">
								<form class="" action="memberSearch" method="get" id="formSearchMemberNon">
										<div class="form-group">
										    <label>From:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date" name="date_from" id="date_from">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" name="date_to" class="form-control datepicker" placeholder="Date" id="date_to">
										</div>
										<button type="button" class="btn btn-success" id="search_submit">Search</button>
									</form>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<input type="hidden" name="_token" id="token" value="{{ csrf_token() }}">
						
						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling" id="member">
							<div class="inside">
								<div class="title">Sale property Report</div>
								<table class="display responsive nowrap" width="100%" id="saleReportList" >
									<thead>
										<tr>																						
											<th>Date</th>											
										    <th>Member Name</th>
										    <th>Report Type</th>											
											<th>Price</th>
											<th>tax</th>
											<th>Actual sale</th>
											<th>Total</th>
														
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
	
	@endsection
	@section('page_js')

<!-- Fetching sale report list -->

<script type="text/javascript">	
	
$(function() {
			var table = $('#saleReportList').DataTable({
			processing: true,
			serverSide: true,
			dom: 'lBfrtip',
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5',
				],
			lengthMenu: [
					[20, 40, 60, 100 ],
					[20, 40, 60, 100 ]
				],
			paging: true,
			ajax: {
				url: "{{route('salePropertyReport')}}",
				data: function (d) {
					
			
						d.date_from = $('input[name="date_from"]').val();
					
						d.date_to =$('input[name="date_to"]').val();
						
					}
				},
				
				columns: [ 
				 {title: "date",
                 data: "date",
                   render: function(d) {
                   return moment(d).format("DD-MMM-YYYY");}},
					{ data: 'name', name: 'name' },
					{ data: 'property_type', name: 'property_type' },
					{ data: 'amount', name: 'amount' },
					{ data: 'tax', name: 'tax' },
					{ data: 'cash', name: 'cash' },
					{ data: 'abc', name: 'abc' }
				],
				"order": [[ 0, 'desc' ]] ,
								
           	});
			  
			   $('#search_submit').click(function(){
					var title = 'Search result for Members';
					$('.searchResultTitle').text(title);	
					$('#saleReportList').DataTable().draw(true);
				});  
        });
		


</script>

	@endsection
	