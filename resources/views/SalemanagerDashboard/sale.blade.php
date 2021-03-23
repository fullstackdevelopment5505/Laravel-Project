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
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-4 topdata">
							<div class="insides">
								<h5>Earned Today</h5>
								<h6>${{$earnedTodaySale}}</h6>
							</div>
						</div>
						<div class="col-md-4 topdata">
							<div class="insides">
								<h5>last 7 Days</h5>
								<h6>${{$earnedLastWeekSale}}<i class="fa fa-arrow-up"></i></h6>
							</div>
						</div>
						<div class="col-md-4 topdata">
							<div class="insides">
								<h5>Past 30 Days</h5>
								<h6>${{$earnedLastMonthSale}}<i class="fa fa-arrow-up"></i></h6>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-4 blue_box">
							<div class="insides">
								<div class="intext">
									<h5>earned today</h5>
									<h6>${{$earnedTodaySale}}</h6>
								</div>
								<!-- <div class="tags"><span>+52%</span></div> -->
							</div>
						</div>
						<div class="col-md-4 blue_box green">
							<div class="insides">
								<div class="intext">
									<h5>earned this week</h5>
									<h6>${{$earnedThisWeekSale}}</h6>
								</div>
								@if($weekPercent>0)
								<div class="tags"><span>+{{$weekPercent}}%</span></div>
								@else
								<div class="tags"><span>{{$weekPercent}}%</span></div>
								@endif
							</div>
						</div>
						<div class="col-md-4 blue_box red">
							<div class="insides">
								<div class="intext">
									<h5>earned this month</h5>
									<h6>${{$earnedThisMonthSale}}</h6>
								</div>
								@if($monthPercent>0)
								<div class="tags"><span>+{{$monthPercent}}%</span></div>
								@else
								<div class="tags"><span>{{$monthPercent}}%</span></div>
								@endif
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12"><canvas id="canvas"></canvas></div>
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-4 profile_box">
							<div class="inner">
								<div class="profsize"><img src="{{asset('assets/salemanager/images/pro.png')}}"></div>
								<h2>{{$firstName}} {{$lastName}}</h2>
								<p>Top Seller (last month)</p>
								<a href="#"><button class="btn btn-primary">View Detail</button></a>
							</div>
						</div>
						<div class="col-md-4 profile_box">
							<div class="inner">
								<div class="head_title">
									<h3>Top Earnings</h3>
									<i class="fa fa-usd"></i>
								</div>
								<div class="topearn">
									<ul>
									@foreach($topEarning as $row)
										<li>
											<a href="#">
												<div class="earnbox">
													<div class="ernleft"><img src="{{asset('assets/salemanager/images/t1.png')}}"></div>
													<div class="txts">
													<?php  $points = ($row->point)/10; ?>
														<p>Has earned ${{$points}}</p>
														<span>5 minutes ago</span>
													</div>
												</div>
											</a>
										</li>
									@endforeach	
										<!-- <li>
											<a href="#">
												<div class="earnbox">
													<div class="ernleft"><img src="{{asset('assets/salemanager/images/t2.png')}}"></div>
													<div class="txts">
														<p>Has earned $1,742.00</p>
														<span>5 minutes ago</span>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="earnbox">
													<div class="ernleft"><img src="{{asset('assets/salemanager/images/t3.png')}}"></div>
													<div class="txts">
														<p>Has earned $1,742.00</p>
														<span>5 minutes ago</span>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="earnbox">
													<div class="ernleft"><img src="{{asset('assets/salemanager/images/t4.png')}}"></div>
													<div class="txts">
														<p>Has earned $1,742.00</p>
														<span>5 minutes ago</span>
													</div>
												</div>
											</a>
										</li> -->
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-4 profile_box">
							<div class="inner">
								<div class="head_title">
									<h3>Top Ranking</h3>
									<i class="fa fa-star"></i>
								</div>
								<div class="toprank">
									<ul>
									@foreach($topRanking as $row)
										<li>
											<a href="#">
												<div class="rankbox">
													<div class="leftrank">
														<div class="ernleft"><img src="{{asset('assets/salemanager/images/t5.png')}}"></div>
														<div class="txts">
															<p>{{$row->f_name}} {{$row->l_name}}</p>
															<span>{{$row->point}} done</span>
														</div>
													</div>
													<div class="rightrank">
														<div class="txts">
															<p>95%<i class="fa fa-arrow-up"></i></p>
														</div>
													</div>
												</div>
											</a>
										</li>
										@endforeach
										<!-- <li>
											<a href="#">
												<div class="rankbox">
													<div class="leftrank">
														<div class="ernleft"><img src="{{asset('assets/salemanager/images/t4.png')}}"></div>
														<div class="txts">
															<p>Sarah</p>
															<span>30      done</span>
														</div>
													</div>
													<div class="rightrank">
														<div class="txts">
															<p>33%<i class="fa fa-arrow-down danger"></i></p>
														</div>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="rankbox">
													<div class="leftrank">
														<div class="ernleft"><img src="{{asset('assets/salemanager/images/t3.png')}}"></div>
														<div class="txts">
															<p>Mike</p>
															<span>5 done</span>
														</div>
													</div>
													<div class="rightrank">
														<div class="txts">
															<p>8%<i class="fa fa-arrow-down danger"></i></p>
														</div>
													</div>
												</div>
											</a>
										</li>
										<li>
											<a href="#">
												<div class="rankbox">
													<div class="leftrank">
														<div class="ernleft"><img src="{{asset('assets/salemanager/images/t2.png')}}"></div>
														<div class="txts">
															<p>Robert</p>
															<span>14 done</span>
														</div>
													</div>
													<div class="rightrank">
														<div class="txts">
															<p>86%<i class="fa fa-arrow-up"></i></p>
														</div>
													</div>
												</div>
											</a>
										</li> -->
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row tb_space">
								<div class="col-md-4">
									<div class="rctitle">Recent Order</div>
								</div>
								<!-- <div class="col-md-8">
									<div class="fkexsrh">
									<div class="srhbox">
										<select class="control">
											<option>Date</option>
											<option>Id</option>
											<option>Name</option>
										</select>
										<select class="control">
											<option>Delivered</option>
											<option>Failed</option>
											<option>Pending</option>
										</select>
									</div>
									<div class="biling_period">
										<label>From:</label>
										<input type="text" class="control datepicker" placeholder="Date">
										<label>to</label>
										<input type="text" class="control datepicker" placeholder="Date">
									</div>
									</div>
								</div> -->
							</div>
							<table id="property_data" class="display responsive nowrap" width="100%">
							    <thead>
							        <tr>
							            <th>Sr No</th>
							            <th>SE Name</th>
							            <th>Total Sale</th>
							            <th>Total Commission</th>
							            <!-- <th>Status</th> -->
							            <th>Action</th>
							        </tr>
							    </thead>
							    <tbody>
								
								@foreach($recentRecord as $index=>$row)
								<?php  $points=($row->point)/10; ?>
							        <tr>
							        	<td>{{$index+1}}</td>
							            <td>{{$row->f_name}} {{$row->l_name}}</td>
							            <td>{{$row->point}}</td>
							            <td>20%</td>
							            <!-- <td><button class="btn_act2">Delivered</button></td> -->
							            <td>
							            <a href="#" class="btn btn-success">View Details</a>
							            			
							            </td>
							        </tr>
									@endforeach
							        <!-- <tr>
							        	<td>02 Jan 2019</td>
							            <td>Karen Smith (Sales Representative)</td>
							            <td>#11108</td>
							            <td>$3445.00</td>
							            <td><button class="btn_act2 warning">Pending</button></td>
							            <td>
							            	<div class="actionbtn">
							            		<ul>
							            			<li><a href="#"><i class="fa fa-pencil"></i></a></li>
							            			<li><a href="#" class="trash"><i class="fa fa-trash"></i></a></li>
							            		</ul>
							            	</div>
							            </td>
							        </tr>
							        <tr>
							        	<td>03 Jan 2019</td>
							            <td>Steven Short (Sales Manager)</td>
							            <td>#11108</td>
							            <td>$3445.00</td>
							            <td><button class="btn_act2 danger">Failed</button></td>
							            <td>
							            	<div class="actionbtn">
							            		<ul>
							            			<li><a href="#"><i class="fa fa-pencil"></i></a></li>
							            			<li><a href="#" class="trash"><i class="fa fa-trash"></i></a></li>
							            		</ul>
							            	</div>
							            </td>
							        </tr>
							        <tr>
							        	<td>04 Jan 2019</td>
							            <td>Tara Knows (Sales Manager)</td>
							            <td>#3198</td>
							            <td>$8650.99</td>
							            <td><button class="btn_act2">Delivered</button></td>
							            <td>
							            	<div class="actionbtn">
							            		<ul>
							            			<li><a href="#"><i class="fa fa-pencil"></i></a></li>
							            			<li><a href="#" class="trash"><i class="fa fa-trash"></i></a></li>
							            		</ul>
							            	</div>
							            </td>
							        </tr>
							        <tr>
							        	<td>05 Jan 2019</td>
							            <td>Karen Smith (Sales Representative)</td>
							            <td>#11108</td>
							            <td>$3445.00</td>
							            <td><button class="btn_act2 warning">Pending</button></td>
							            <td>
							            	<div class="actionbtn">
							            		<ul>
							            			<li><a href="#"><i class="fa fa-pencil"></i></a></li>
							            			<li><a href="#" class="trash"><i class="fa fa-trash"></i></a></li>
							            		</ul>
							            	</div>
							            </td>
							        </tr>
							        <tr>
							        	<td>06 Jan 2019</td>
							            <td>Steven Short (Sales Manager)</td>
							            <td>#11108</td>
							            <td>$3445.00</td>
							            <td><button class="btn_act2 danger">Failed</button></td>
							            <td>
							            	<div class="actionbtn">
							            		<ul>
							            			<li><a href="#"><i class="fa fa-pencil"></i></a></li>
							            			<li><a href="#" class="trash"><i class="fa fa-trash"></i></a></li>
							            		</ul>
							            	</div>
							            </td>
							        </tr> -->
							    </tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
			<!-- inside_content_area-end-->
		</section>
		<!-- right area end -->
	</div>
	<!-- main div end -->

	<!-- add-customer-popup -->
	<!-- The Modal -->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<!-- Modal Header -->
				<div class="modal-header">
					<h4 class="modal-title">Add Customer</h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				<!-- Modal body -->
				<div class="modal-body">
					<div class="main_form">
						<label>Name</label>
						<input type="text" class="form-control fldtxt" name="">
						<label>Email Id</label>
						<input type="text" class="form-control fldtxt" name="">
						<label>Phone No.</label>
						<input type="text" class="form-control fldtxt" name="">
						<label>City</label>
						<input type="text" class="form-control fldtxt" name="">
						<button class="btn btn-success svbtn">Save</button>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- add-customer-popup -->
@endsection
@section('page_js')

<script>
		var MONTHS = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
		var config = {
			type: 'line',
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
				datasets: [{
					label: 'My First dataset',
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					fill: false,
				}, {
					label: 'My Second dataset',
					fill: false,
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
				}]
			},
			options: {
				responsive: true,
				title: {
					display: true,
					text: 'Chart.js Line Chart'
				},
				tooltips: {
					mode: 'index',
					intersect: false,
				},
				hover: {
					mode: 'nearest',
					intersect: true
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
							labelString: 'Value'
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
@endsection	


