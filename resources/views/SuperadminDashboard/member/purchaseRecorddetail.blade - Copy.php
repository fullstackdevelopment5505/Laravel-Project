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
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 from_to_filter">
								<div class="view_back"><a  href="{{ URL('/superadmin/member/detail/')}}<?php echo "/".$userid."/".$member; ?>"><i class="fa fa-arrow-left"></i></a></div>
								<div class="title">Back </div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12 top_selling">
							<div class="inside">
							
								<div class="title searchResultTitle">Purchased Records</div>
								<table class="responsive nowrap display property_table" id="member_search_table" width="100%">
									<thead>
										<tr>
											<th>Sr. No</th>
											<th>Address</th>
											<th>Amount</th>
											<th>Status</th>
											<th>Date & Time</th>
										</tr>
									</thead>
									
									<tbody>
										@foreach($data as $key=>$value)
											<?php
												/*  $purchase_date = '-';
												if($search_type == '1' ){
													$type='Member';
													$purchase_date = date('d-M-yy', strtotime($value->registration_date));
												}else{ 
													$type='Non Member'; 
													$purchase_date = date('d-M-yy', strtotime($value->registration_date));
												}   */
												
											?>
										<tr>
											<td> </td>
											<td> {{$value->SitusHouseNumber}} {{$value->SitusStreetName}} {{$value->SitusMode}} </td>
											<td> {{($value->amount) ? '$'.$value->amount : '' }} </td>
											<td>
											<ul>
												<li> 
												<button class="btn btn-actions bulb">
												@if($value->status == 1)
												<img style="height: 27px;" src="{{asset('assets/superadmin/images/bulb.png')}}" alt="">
												@else
													<img style="height: 27px;" src="{{asset('assets/superadmin/images/bulb-d.png')}}" alt="">
												@endif
												</button> 
												</li>
												<li>
												<button class="btn btn-actions fire">
												@if($value->status == 2)
												<img style="height: 27px;" src="{{asset('assets/superadmin/images/fire.png')}}" alt="">
												@else
													<img style="height: 27px;" src="{{asset('assets/superadmin/images/fire-d.png')}}" alt="">
												@endif
												</button>
												</li>
												<li><button class="btn btn-actions trash">
												
												@if($value->trash == 1)
												<img style="height: 27px;" src="{{asset('assets/superadmin/images/bin.png')}}" alt="">
												@else
													<img style="height: 27px;" src="{{asset('assets/superadmin/images/bin.png')}}" alt="">
												@endif
												
												</button></li>
											</ul>
											</td>
											<td>{{$value->date}}</td>
											
										</tr>
										@endforeach
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

		$(function() {
			var table = $('#member_search_table').DataTable({
			processing: false,
			serverSide: false,
			responsive: true,
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
				columns: [
				{
						data: null, render: function (data, type, full, meta) {
							return meta.row + 1;
						}
					},
				
					{ data: 'address', name: 'address' },
					{ data: 'amount', name: 'amount' },
					{ data: 'status', name: 'status' },
					{ data: 'date', name: 'date' }, 
				]
           	});
			   
			  
        });
	</script>
@endsection