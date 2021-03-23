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
				<div class="col-sm-12">
					<div class="row">
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/account/images/clients.svg')}}"></div>
								<div class="title">Total Members</div>
								<div class="cus_num">{{$customerEnrolled}}</div>
							</div>
						</div>
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/account/images/sale.svg')}}"></div>
								<div class="title">Total Sale</div>
								<div class="cus_num">$ {{$ledger}}</div>
							</div>
						</div>
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/account/images/employee.svg')}}"></div>
								<div class="title">Total Contractor</div>
								<div class="cus_num">{{$userCount}}</div>
							</div>
						</div>
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/account/images/wallet.svg')}}"></div>
								<div class="title">Total Wallet Balance</div>
								<div class="cus_num">$ {{$walletBalance}}</div>
							</div>
						</div>					
					</div>
				</div>

				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!--Revenue start -->
						<div class="col-lg-12 right_area">
							<div class="inside">
								<div class="title">revenue</div>
								<canvas id="canvas"></canvas>
							</div>
						</div>
						<!--Revenue end -->

						
						<!--Customer Joined start-->
						<div class="col-sm-6 top_selling">
							<div class="inside customer_join_box">
								<div class="title">Members</div>
								<div class="enrolled_value">{{$customerEnrolled}}</div>
								<div class="custoner_absol">
									@if($enrollPercent>=0)
											<div class="enroll_grade color-green"><i class="fa fa-long-arrow-up"></i>{{number_format($enrollPercent)}}%</div>
											@else
											<div class="enroll_grade color-red"><i class="fa fa-long-arrow-down"></i>{{number_format($enrollPercent)}}%</div>
											@endif
									<div class="enroll_month">Since Last Month</div>
								</div>
								<!--<div class="view_all mt-3"><a href="{{route('AccountDashboard.sale.saleMembershipReport')}}" class="btn btn-success">View All</a></div>-->
							</div>
						</div>
						<!--Customer Joined end-->
							
						<!--Customer Enrolled start-->
						<div class="col-sm-6 top_selling">
							<div class="inside customer_enroll_box">
								<div class="title">Non Member</div>
								<div class="enrolled_value">{{$customerJoined}}</div>
								<div class="custoner_absol">
									@if($joinPercent>=0)
											<div class="enroll_grade color-green"><i class="fa fa-long-arrow-up"></i>{{number_format($joinPercent)}}%</div>
											@else
											<div class="enroll_grade color-red"><i class="fa fa-long-arrow-down"></i>{{number_format($joinPercent)}}%</div>
											@endif
									<div class="enroll_month">Since Last Month</div>
								</div>
								<!--<div class="view_all mt-3"><a href="#" class="btn btn-success">View All</a></div>-->
							</div>
						</div>
						<!--Customer Enrolled end-->


						<!--recent selling property start -->
						<div class="col-sm-6 top_selling">
							<div class="inside">
								<div class="title">Recently Purchased Property Records
								<!-- <select style="border-radius: 6px; width:165px; float:right">
							     	<option value="California">California</option>
								    @foreach($customer as $customers)									
									<option value="{{ $customers->state }}">{{ $customers->state}}</option>
									@endforeach 
								</select> -->
								</div>
								
								<table class="display responsive nowrap" width="100%" id="PropertyRecords">
									<thead>
										<tr>
										    <th>Date</th>
										    <th>Name</th>
										    <th>Amount</th>
										    <th>Tax</th>
										    <th>Cash</th>
										</tr>
									</thead>
									<tbody>
								
									@foreach($purchaseRecords as $records)

									<tr class="data-row">
											<td class="membership_id">{{date('d-M-Y', strtotime($records->date))}}</td>
											<td class="membership_id">{{$records->name}}</td>
											<td class="membership_id">${{floatval($records->amount)}}</td>
											<td class="membership_id">${{floatval($records->tax)}}</td>
											<td class="membership_id">${{floatval($records->cash)}}</td>
                                               
                                            </tr>
									@endforeach</tbody>
								</table>
								<div class="view_all mt-3"><a href="{{route('AccountDashboard.sale.purchasedRecordsReport')}}" class="btn btn-success">View All</a></div>
							</div>
						</div>
						<!--recent selling property end -->

						<!-- Recently puchased membership start -->
						<div class="col-sm-6 top_selling">
							<div class="inside">
								<div class="title">Recently Purchased Memberships
								<!-- <select style="border-radius: 6px; width:165px; float:right">
								    <option value="Los Angeles">Los Angeles</option>
								    @foreach($customer as $customers)
									<option value="{{ $customers->state }}">{{ $customers->state}}</option>
									@endforeach 
								</select> -->
								</div>
								<table class="display responsive nowrap" width="100%" id="MemReport" >
									<thead>
										<tr>
										    <th>Date</th>
										    <th>Name</th>
										    <th>amount</th>
										    <th>Tax</th>
										    <th>Cash</th>
										</tr><tbody>
										@foreach($MemReports as $customers)
									
									<tr class="data-row">
											<td class="membership_id">{{date('d-M-Y', strtotime($customers->date))}}</td>
											<td class="membership_id">{{$customers->name}}</td>
											<td class="membership_id">${{floatval($customers->amount)}}</td>
											<td class="membership_id">${{floatval($customers->tax)}}</td>
											<td class="membership_id">${{floatval($customers->cash)}}</td>
                                               
                                            </tr>
									@endforeach
									</tbody>
			    						</thead>
										
									</table>
									<div class="view_all mt-3"><a href="{{route('AccountDashboard.sale.saleMembershipReport')}}" class="btn btn-success">View All</a></div>
								</div>
							</div>
							<!-- Recently puchased membership end -->

							<!-- Recently puchased membership start -->
							<div class="col-sm-12 top_selling">
								<div class="inside">
									<div class="title">Recently Deposit</div>
									<table class="display responsive nowrap" width="100%">
										<thead>
										    <tr>
										        <th>Date</th>
										        <th>Sale Type</th>
										        <th>Amount</th>
										        <th>Tax</th>
										        <th>Cash</th>
										    </tr>
										</thead>
											<tbody> 
										<?php $i = 0; ?>
										@foreach($totalsale as $customers)

									<tr class="data-row">
											<td class="membership_id">{{date('d-M-Y', strtotime($customers["date"]))}}</td>
											<td class="membership_id">{{$customers["type"]}}</td>
							
											<td class="membership_id">${{floatval($customers["amount"])}}</td>
											<td class="membership_id">${{floatval($customers["tax"])}}</td>
											<td class="membership_id">${{floatval($customers["cash"])}}</td>
                                               
                                            </tr>
											<?php
											$i++;
											if($i == 10){
											break;
											}
											?>
									@endforeach</tbody>
										</tbody>
									</table>
								<div class="view_all mt-3"><a href="{{route('AccountDashboard.sale.totalSaleReport')}}" class="btn btn-success">View All</a></div>
								</div>
							</div>
							<!-- Recently puchased membership end -->
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
<script>
 $('.display').table({
    responsive: true,
	 paging: false,
    dom: 'lBfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ],
    
});
</script>
</script>
<!-- Fetching sale report list -->

<!-- Graph Script statr -->

	<script>
var pointsGraphData1 = {!! $sale_graph !!};
var pointsGraphData2 = {!! $purchase_records_graph !!};
var pointsGraphData3 = {!! $membership_graph !!};


console.log(pointsGraphData2)
		var ctx = document.getElementById("canvas");
		ctx.height = 100;
		var config = {
				type: 'line',
				data: {
					labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August','September','October','November','December'],
					datasets: [{
						label: 'dataset - Property Sale',
						data:pointsGraphData1,
						backgroundColor: window.chartColors.red,
						borderColor: window.chartColors.red,
						fill: false,
						borderDash: [5, 5],
						pointRadius: 15,
						pointHoverRadius: 10,
					}, {
						label: 'dataset - Records Sale',
						data:pointsGraphData2,
						backgroundColor: window.chartColors.blue,
						borderColor: window.chartColors.blue,
						fill: false,
						borderDash: [5, 5],
						pointRadius: [2, 4, 6, 18, 0, 12, 20],
					}, {
						label: 'dataset - Memberships Sale',
						data:pointsGraphData3,
						backgroundColor: window.chartColors.yellow,
						borderColor: window.chartColors.yellow,
						fill: false,
						pointHitRadius: 20,
					}]
				},
				options: {
					responsive: true,
					legend: {
						position: 'bottom',
					},
					hover: {
						mode: 'index'
					},
					scales: {
						xAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Month'
							}
						}],
						yAxes: [{
							display: true,
							scaleLabel: {
								display: true,
								labelString: 'Value',
							}
						}]
					}
				}
			};

			window.onload = function() {
				var ctx = document.getElementById('canvas').getContext('2d');
				window.myLine = new Chart(ctx, config);
			};
	</script>
<!-- Fetching sale report list -->
 
@endsection
	