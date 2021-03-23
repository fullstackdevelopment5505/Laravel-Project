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
                                     <div class="col-sm-12 from_to_filter">
                                         <form>
                                            <div class="form-group">
                                                <label>From:</label>
                                                <input type="text" id="date_from_purchase" name="date_from_purchase" class="form-control datepickerSuper" placeholder="Date">
                                            </div>
                                            <div class="form-group">
                                                <label>To:</label>
                                                <input type="text" id="date_to_purchase" name="date_to_purchase" class="form-control datepickerSuper" placeholder="Date">
                                            </div>
                                            <button type="button" id="search_submit_purchase" class="btn btn-success">Search</button>
                                         </form>
                                      </div>
                                 </div>
                            </div>
						<!-- datepicker -->
					
						
				         <!--table start -->
						 <div class="col-sm-12 top_selling">
									<div class="inside">
										<div class="title">Purchased Records</div>
										<table class="display responsive nowrap" id="purchase_record" width="100%">
										    <thead>
										        <tr>
										            <th>Date & Time</th>
													<th>Member name</th>
													<th>Amount</th>
													<th>Tax</th>
													<th>Actual Sale</th>
													<th>Total</th>


										        </tr>
										    </thead>
										    <tbody>
										    </tbody>
										</table>
									</div>
								</div>
                            <!--table end--> 
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
<script>

$('#search_submit').click(function(){	
        $('#SavedSearchlist').DataTable().draw(true);
    });  


    var table = $('#purchase_record').DataTable({
		processing: true,
		responsive: true,
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
			url: "{{route('purchasedRecordsReport')}}",
			data: function (d) {
					d.date_from_purchase = $('input[name="date_from_purchase"]').val();
					d.user_id = $('input[name="user_id"]').val();
                    d.type = 'purchased_record';
					d.date_to_purchase =$('input[name="date_to_purchase"]').val();
					
				}
			},
			
			columns: [ 
				{title: "date",data: "date",
                   render: function(d) {
                   return moment(d).format("DD-MMM-YYYY");}},
				{ data: 'name', name: 'name' },
				{ data: 'amount', name: 'amount'},
				{ data: 'tax', name: 'tax'},
				{ data: 'cash', name: 'cash'},
				{ data: 'abc', name: 'abc'}
			],
			"order": [[ 0, 'desc' ]] ,
	});
	 		
    $('#search_submit_purchase').click(function(){	
        $('#purchase_record').DataTable().draw(true);
    });




$(function() {

		$('#date_from_purchase').datepicker({
			beforeShow: customRange,
			dateFormat: "mm/dd/yy",
			firstDay: 1,
			maxDate: 'now',
			changeFirstDay: false
		});
		$('#date_to_purchase').datepicker({
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


		if (input.id === "date_from_purchase") {
			dateMax = 'now';	
		}
		if (input.id === "date_to_purchase") {
			dateMin = $('#date_from_purchase').datepicker('getDate');
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
</script>

	@endsection
	
