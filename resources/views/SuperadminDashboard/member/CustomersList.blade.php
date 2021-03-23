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
			<!-- filter -->
				<div class="col-sm-12 filter_and_title mb-3">
					<div class="row">
						<div class="col-md-2 filter"><i class="fa fa-filter"></i></div>
					</div>
				</div>
				<!-- filter-end -->

				<div class="col-sm-12 filter_box mb-3">
					<div class="inside pb-0">
						<form class="" action="{{ URL('/superadmin/memberSearch/') }}" method="post" id="formSearchMember">
							{{@csrf_field()}}
							<div class="row">
								<div class="col-md-3 col-lg-3">
									<div class="form-group">
										<label>Name</label>
										<input type="text" name="name" class="form-control">
									</div>
								</div>
								<div class="col-md-3 col-lg-3">
									<div class="form-group">
										<label>Email</label>
										<input type="text" name="email" class="form-control">
									</div>
								</div>
								<div class="col-md-3 col-lg-3">
									<div class="form-group">
										<label>Postal Code</label>
										<input type="text" name="postal" class="form-control">
									</div>
								</div>
								<div class="col-md-3 col-lg-3">
									<div class="form-group">
										<label>Joining Date</label>
										<div class="row">
											<div class="col-md-6">
												<input type="text" placeholder="From" id="date_created_start" name="date_created_start" class="form-control datepickerSuper">
											</div>
											<div class="col-md-6">
												<input type="text" placeholder="To"  id="date_created_end" name="date_created_end" class="form-control datepickerSuper">
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-3 col-lg-3">
								<button type="button" id="search_submit" class="btn btn-success mb-2">Search</button>
								<button type="button" id="search_reset" class="btn btn-success mb-2">Reset</button>
								</div>
							</div>
						</form>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Customers</div>
								<div class="title searchResultTitle"></div>
								<table class="responsive nowrap display" id="member_search_table" width="100%">
									<thead>
										<tr>
											<?php /* <th>Sr. No</th> */ ?>
											<th>ID</th>
											<th>Name</th>
											<th>Email</th>
											<!--th>End Date</th-->
											<th>Phone</th>
											<th>Accepted Terms</th>
											<th>Joining Date</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
									</tbody>
								</table>
							</div>
							<!--table end-->
						</div>
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
	<script>
$('.datepickerSuper').datepicker('widget').delegate('.ui-datepicker-close', 'mouseup', function() {
		var inputToBeCleared = $('.datepicker').filter(function() { 
			return $(this).data('pickerVisible') == true;
		});    
		$(inputToBeCleared).val('');
	});
	$(function() {

			$('#date_created_start').datepicker({
				beforeShow: customRange,
				dateFormat: "d-M-yy",
				firstDay: 1,
				maxDate: 'now',
				changeFirstDay: false
			});
			$('#date_created_end').datepicker({
				beforeShow: customRange,
				dateFormat: "d-M-yy",
				firstDay: 1,
				changeFirstDay: false
			});
	});

	function customRange(input) {	
		var min = null, // Set this to your absolute minimum date
		dateMin = min,
		dateMax = null;


		if (input.id === "date_created_start") {
			dateMax = 'now';	
		}
		if (input.id === "date_created_end") {
			dateMin = $('#date_created_start').datepicker('getDate');
		}

		return {
			minDate: dateMin,
			maxDate: dateMax
		};
	}
		$(function() {
			var table = $('#member_search_table').DataTable({
				processing: true,
				serverSide: true,
				bDestroy: true,
				//"ajax": "{{ route('kickstarter.list') }}",   
				ajax: {
					url: "{{route('superadminCustomers')}}",
					data: function (d) {
						d.name   =   $('input[name="name"]').val();
						d.email   =   $('input[name="email"]').val();
						d.postal   =   $('input[name="postal"]').val();
						d.date_created_start   =   $('input[name="date_created_start"]').val();
						d.date_created_end   =   $('input[name="date_created_end"]').val();
					}
				},
				rowId: "ShipmentId",
				order:[[0,"desc"]],
			   columns: [
					/* { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false}, */
					{ data: 'id', name: 'id' },
					{ data: 'name', name: 'name' },
					{ data: 'email', name: 'email' },
				/* 	{ data: 'subscription.plan_period_end', name: 'end_date',defaultContent: "<i>-</i>" }, */
					{ data: 'phone', name: 'phone',defaultContent: "<i>-</i>" },
					{ data: 'accepted_terms', name: 'accepted_terms' }, 
					{ data: 'join_date', name: 'created_at' },
					{data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
				],
				dom: 'lBfrtip',
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5',
				],
				lengthMenu: [
					[20, 40, 60, 80, 100],
					[20, 40, 60, 80, 100]
				],
				
           	});  
			$('#search_submit').click(function(){	
		
				$('#member_search_table').DataTable().draw(true);
			});			
			$('#search_reset').click(function(){	
			  $('#formSearchMember')[0].reset();
				$('#member_search_table').DataTable().draw(true);
			});		
        });
		$('.filter_and_title .filter i').click(function(){
		  $('.filter_box ').slideToggle(100);
		});
	</script>
@endsection