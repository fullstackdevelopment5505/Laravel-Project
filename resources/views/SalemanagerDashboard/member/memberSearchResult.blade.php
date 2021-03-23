@extends('SalemanagerDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
	@include('SalemanagerDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SalemanagerDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 from_to_filter">
								<div class="view_back"><a onClick="javascript:history.go(-1)" href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a></div>
								<div class="title"> @if($search_type == 1) Members @else Non Members @endif</div>
						</div>
					</div>
				</div>
				<div class="col-sm-12">
					<div class="row">
						<div class="col-sm-12 top_selling">
							<div class="inside">
							
								<?PHP 
								$title = "Search Result for Non Members";
								if($search_type=='1'){
									$title = "Search Result for Members";
								}
								?>
								<div class="title searchResultTitle">{{$title}}</div>
								<table class="responsive nowrap display" id="member_search_table" width="100%">
									<thead>
										<tr>
											<th>Sr. No</th>
											<th>ID</th>
											<th>Name</th>
											<th>Email</th>
											<th>Phone</th>
											<th>Member Type</th>
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
													$purchase_date = date('d/m/Y', strtotime($value->membership_purchase_date));
												}else{ 
													$type='Non Member'; 
												} 
											?>
										<tr>
											<td>  </td>
											<td> {{$value->user_primary_id}} </td>
											<td>{{$value->f_name." ".$value->l_name}}</td>
											<td>{{$value->email}}</td>
											<td>{{$value->phone}}</td>
											<td>{{$type}}</td>
											<td>{{$purchase_date}}</td>
											<td>
												<a class="btn btn-success" href="{{URL::route('salemanagerMember.detail',['id'=>$value->user_primary_id,'type'=>$search_type])}}" >
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
			dom: 'lBfrtip',
				buttons: [
					'copyHtml5',
					'excelHtml5',
					'csvHtml5',
					'pdfHtml5',
				],
			lengthMenu: [
					[10, 20, 30, 40 ],
					[10, 20, 30, 40 ],
				],
				columns: [
					{
						data: null, render: function (data, type, full, meta) {
							return meta.row + 1;
						}
					},
					{ data: 'user_primary_id', name: 'user_primary_id' },
					{ data: 'name', name: 'name' },
					{ data: 'email', name: 'email' },
					{ data: 'phone', name: 'phone' },
					{ data: 'type', name: 'type' }, 
					{ data: 'membership_purchase_date', name: 'membership_purchase_date' },
					{data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
				]
           	});  
        });
	</script>
@endsection