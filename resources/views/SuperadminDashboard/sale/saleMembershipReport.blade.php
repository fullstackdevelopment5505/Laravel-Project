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
								<form class="" action="memberSearch" method="get" id="formSearchMemberNon">
										<div class="form-group">
							
										    <label>From:</label>
										    <input type="text" class="form-control datepickerSuper" placeholder="Date" name="date_from" id="date_from">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" name="date_to" class="form-control datepickerSuper" placeholder="Date" id="date_to">
										</div>
										<button type="button" class="btn btn-success" id="search_submit">Search</button>
									</form>
								</div>
							</div>
						</div>
						<!-- datepicker -->                 
						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Sale membership Report</div>
								<table class="display responsive nowrap" width="100%" id="saleMemReportList">
		 							<thead>
										<tr>
										    <th>Date & Time</th>
										    <th>Member name</th>
										    <th>Membership type</th>											
										    <th>Amount</th>
										    <th>Tax</th>
										    <th>Cash</th>
										    <th>Total</th>


										   
										</tr>
									</thead>
									<tbody>
									</tbody>									
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
	$(function() {

		$('#date_from').datepicker({
			beforeShow: customRange,
			dateFormat: "mm/dd/yy",
			firstDay: 1,
			maxDate: 'now',
			changeFirstDay: false
		});
		$('#date_to').datepicker({
			beforeShow: customRange,
			dateFormat: "mm/dd/yy",
			firstDay: 1,
			changeFirstDay: false
		});
	});

	function customRange(input) {
		var min = null, // Set this to your absolute minimum date
			dateMin = min,
			dateMax = null;
			if (input.id === "date_from") {
				console.log("start time");
				dateMax = 'now';	
			}
			if (input.id === "date_to") {
				dateMin = $('#date_from').datepicker('getDate');
				dateMax = null;
				
				//if ($('#startdatepicker').datepicker('getDate') != null) { dateMax = 'now'; }
			}
		
		return {
			minDate: dateMin,
			maxDate: dateMax
		};
	}

	$('.datepickerSuper').datepicker('widget').delegate('.ui-datepicker-close', 'mouseup', function() {
		var inputToBeCleared = $('.datepicker').filter(function() { 
		return $(this).data('pickerVisible') == true;
		});    
		$(inputToBeCleared).val('');
	});


	$(function() {
		var table = $('#saleMemReportList').DataTable({
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
			url: "{{route('saleMembershipReport')}}",
			data: function (d) {
					d.date_from = $('input[name="date_from"]').val();
				
					d.date_to =$('input[name="date_to"]').val();
					
				}
			},
			columns: [ 
				{title: "date",data: "date",
                   render: function(d) {
                   return moment(d).format("DD-MMM-YYYY");}},
				{ data: 'name', name: 'name'},
				{ data: 'type', name: 'type'},
				{ data: 'amount', name: 'amount'},
				{ data: 'tax', name: 'tax'},
				{ data: 'cash', name: 'cash'},
				{ data: 'abc', name: 'abc'}
			],
			"order": [[ 0, 'desc' ]] ,
		});
			
		$('#search_submit').click(function(){
			var title = 'Search result for Members';
			$('.searchResultTitle').text(title);	
			$('#saleMemReportList').DataTable().draw(true);
		});  
    });
</script>

@endsection 