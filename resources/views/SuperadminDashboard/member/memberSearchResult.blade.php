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
								<div class="view_back"><a onClick="javascript:history.go(-1)" href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a></div>
								<div class="title"> @if($search_type == 1) Customers @else Prospects @endif</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12 top_selling">
							<div class="inside">
							
								<?PHP 
								$title = "Search Result for Prospects";
								if($search_type=='1'){
									$title = "Search Result for Customers";
								}
								?>
								<div class="title searchResultTitle">{{$title}}</div>
								<table class="responsive nowrap display" id="member_search_table" width="100%">
									<thead>
										<tr>
											<!--th>Sr. No</th-->
											<th>ID</th>
											<th>Full Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Accepted Terms</th>
											<th>Accepted Privacy Policy</th>
											<th>Joining Date</th>
											<th>Action</th>
										</tr>
									</thead>
									
									<tbody>
										@foreach($customers as $key=>$value)
											<?php
												$purchase_date = '-';
												if($search_type == '1' ){
													$type='Member';
													$purchase_date = date('d-M-yy', strtotime($value->registration_date));
												}else{ 
													$type='Non Member'; 
													$purchase_date = date('d-M-yy', strtotime($value->registration_date));
												} 
												
											?>
										<tr>
											<!--td> </td-->
											<td> {{$value->user_primary_id}} </td>
											<td>{{$value->f_name." ".$value->l_name}}</td>
											<td>{{$value->email}}</td>
											<td>{{ ($value->phone!="") ? "(".substr($value->phone, 0, 3).") ".substr($value->phone, 3, 3)."-".substr($value->phone,6) : ""}}</td>
											<td>{{$value->accepted_terms == 0 ? 'No' : 'Yes'}}</td>
											<td>{{$value->privacy_policy_updated == 0 ? 'No' : 'Yes'}}</td>
											<td>{{$purchase_date}}</td>
											<td>
												<a class="btn btn-success" href="{{URL::route('superadmin.member.detail',['id'=>$value->user_primary_id,'type'=>$search_type])}}" >
													<span><strong>Detail</strong></span>
												</a>

											</td>
											
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
					/* {
						data: null, render: function (data, type, full, meta) {
							return meta.row + 1;
						}
					}, */
					{ data: 'user_primary_id', name: 'user_primary_id' },
					{ data: 'name', name: 'name' },
					{ data: 'email', name: 'email' },
					{ data: 'phone', name: 'phone' },
					{ data: 'accepted_terms', name: 'accepted_terms' }, 
					{ data: 'membership_purchase_date', name: 'membership_purchase_date' },
					{data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
				]
           	});
			   
			  
        });
	</script>
@endsection