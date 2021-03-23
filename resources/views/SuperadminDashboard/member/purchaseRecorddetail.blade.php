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
											<!--th>Sr. No</th-->
											<th>First Name</th>
											<th>Last Name</th>
											<th>City</th>
											<th>Status</th>
											<th>Zipcode</th>
											<th>Address</th>
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
											<!--td> </td-->
											<td> {{$value->Owner1FirstName ? $value->Owner1FirstName : '-'}} </td>
											<td> {{$value->OwnerLastname1 ? $value->OwnerLastname1 : '-' }} </td>
											<td> {{$value->SitusCity ? $value->SitusCity : '-' }} </td>
											<td>
											<?php
											if(isset($value->logs) && !empty($value->logs)){
												echo $value->logs->contact_date;
											}
											if($value->opportunity_status == 1)
												$title = 'Prospecting';
											else if($value->opportunity_status == 2)
												$title = 'Qualification';
											else if($value->opportunity_status == 3)	
												$title = 'Needs Analysis';
											else if($value->opportunity_status ==4)	
												$title = 'Value Proposition';	
											else if($value->opportunity_status ==5)	
												$title = 'Id. Decision Makers';	
											else if($value->opportunity_status ==6)	
												$title = 'Perception Analysis';	
											else if($value->opportunity_status ==7)	
												$title = 'Proposal/Price Quote';
											else if($value->opportunity_status ==8)	
												$title = 'Negotiation/Review';	
											else if($value->opportunity_status ==9)	
												$title = 'Closed Won';		
											else if($value->opportunity_status ==10)	
												$title = 'Closed Lost';	
											else
												$title = '';
											?>
											<ul>
												<li class='li_tppl' title="{{$title}}" data-toggle="tooltip" > 
												<button type="button" class="btn btn-actions">
												@if($value->opportunity_status == 1)
												<img style="height: 27px;" src="{{ $url}}assets/images/pros.png" alt="">
												@elseif($value->opportunity_status == 2)
													<img data-toggle="tooltip" title="Qualification" style="height: 27px;" src="{{$url}}asset('images/qulification.png')" alt="">
												@elseif($value->opportunity_status == 3)
													<img data-toggle="tooltip" title="Needs Analysis" style="height: 27px;" src="{{$url}}asset('images/analysis.png')" alt="">
												@elseif($value->opportunity_status == 4)
													<img data-toggle="tooltip" title="Value Proposition" style="height: 27px;" src="{{$url}}asset('images//value-proposition.png')" alt="">
												@elseif($value->opportunity_status == 5)
													<img data-toggle="tooltip" title="Id. Decision Makers" style="height: 27px;" src="{{$url}}asset('images/dec-make.png')" alt="">
												@elseif($value->opportunity_status == 6)
													<img data-toggle="tooltip" title="Perception Analysis " style="height: 27px;" src="{{$url}}asset('images/per-analysis.png')" alt="">
												@elseif($value->opportunity_status == 7)
													<img data-toggle="tooltip" title="Proposal/Price Quote" style="height: 27px;" src="{{$url}}asset('images/proposal.png')" alt="">
												@elseif($value->opportunity_status == 8)
													<img data-toggle="tooltip" title="Negotiation/Review" style="height: 27px;" src="{{$url}}asset('images/negotion.png')" alt="">
												@elseif($value->opportunity_status == 9)
													<img data-toggle="tooltip" title="Closed Won" style="height: 27px;" src="{{$url}}asset('images/closed-won.png')" alt="">
												@elseif($value->opportunity_status == 10)
													<img data-toggle="tooltip" title="Closed Lost" style="height: 27px;" src="{{$url}}asset('images/los.png')" alt="">
												@endif
												</button> 
												</li>
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
											<td> {{$value->SitusZipCode ? $value->SitusZipCode : '-'}}</td>
											<td> {{$value->address ? $value->address : '-'}}</td>
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
		$('[data-toggle="tooltip"]').tooltip();
		$('li.li_tppl').tooltip();
	 });
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
				
					{ data: 'Owner1FirstName', name: 'Owner1FirstName' },
					{ data: 'OwnerLastname1', name: 'OwnerLastname1' },
					{ data: 'SitusCity', name: 'SitusCity' },
					{ data: 'status', name: 'status' },
					{ data: 'SitusZipCode', name: 'SitusZipCode' }, 
					{ data: 'address', name: 'address' }, 
				]
           	});
			   
			  
        });
	</script>
@endsection