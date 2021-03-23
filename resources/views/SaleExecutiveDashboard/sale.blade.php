@extends('SaleExecutiveDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('SaleExecutiveDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SaleExecutiveDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-4 topdata">
							<div class="insides">
								<h5>Earned Today</h5>
								<h6>$6,120</h6>
							</div>
						</div>
						<div class="col-md-4 topdata">
							<div class="insides">
								<h5>last 7 Days</h5>
								<h6>$35,129<i class="fa fa-arrow-up"></i></h6>
							</div>
						</div>
						<div class="col-md-4 topdata">
							<div class="insides">
								<h5>Past 30 Days</h5>
								<h6>$142,545<i class="fa fa-arrow-up"></i></h6>
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
									<h6>$6,120</h6>
								</div>
								<div class="tags"><span>+52%</span></div>
							</div>
						</div>
						<div class="col-md-4 blue_box green">
							<div class="insides">
								<div class="intext">
									<h5>earned this week</h5>
									<h6>$14,229</h6>
								</div>
								<div class="tags"><span>+16%</span></div>
							</div>
						</div>
						<div class="col-md-4 blue_box red">
							<div class="insides">
								<div class="intext">
									<h5>earned this month</h5>
									<h6>$35,129</h6>
								</div>
								<div class="tags"><span>+5%</span></div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-12"><canvas id="canvas"></canvas></div>
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-4 profile_box">
							<div class="inner">
								<div class="profsize"><img src="{{asset('assets/saleExecutive/images/pro.png')}}"></div>
								<h2>John Strehl</h2>
								<p>Top Seller (last month)</p>
								<a href="profile.php"><button class="btn btn-primary">View Detail</button></a>
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
										<li>
											<a href="#">
												<div class="earnbox">
													<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t1.png')}}"></div>
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
													<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t2.png')}}"></div>
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
													<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t3.png')}}"></div>
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
													<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t4.png')}}"></div>
													<div class="txts">
														<p>Has earned $1,742.00</p>
														<span>5 minutes ago</span>
													</div>
												</div>
											</a>
										</li>
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
										<li>
											<a href="#">
												<div class="rankbox">
													<div class="leftrank">
														<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t5.png')}}"></div>
														<div class="txts">
															<p>John Mix</p>
															<span>54 done</span>
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
										<li>
											<a href="#">
												<div class="rankbox">
													<div class="leftrank">
														<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t4.png')}}"></div>
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
														<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t3.png')}}"></div>
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
														<div class="ernleft"><img src="{{asset('assets/saleExecutive/images/t2.png')}}"></div>
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
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div class="col-md-12">
							<div class="row tb_space">
								<div class="col-md-4">
									<div class="rctitle">Recent Order</div>
								</div>
								<div class="col-md-8">
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
								</div>
							</div>
							<table id="property_data" class="display responsive nowrap" width="100%">
							    <thead>
							        <tr>
							            <th>Date</th>
							            <th>Name</th>
							            <th>#INV</th>
							            <th>Amount</th>
							            <th>Status</th>
							            <th>Action</th>
							        </tr>
							    </thead>
							    <tbody>
							        <tr>
							        	<td>01 Jan 2019</td>
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
							        </tr>
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
	<!-- map-visitor -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
	<script src="assets/js/jquery.mapael.js" charset="utf-8"></script>
	<script src="assets/js/world_countries.js" charset="utf-8"></script>
	<script src="assets/js/world_countries_mercator.js" charset="utf-8"></script>
	<script src="assets/js/world_countries_miller.js" charset="utf-8"></script>

	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/custom.js"></script>
	<script src="assets/js/jquery-ui.js"></script>
	<script>
	$('.display').DataTable({
		responsive: true,
		dom: 'lBfrtip',
			buttons: [
				'copyHtml5',
				'excelHtml5',
				'csvHtml5',
				'pdfHtml5',
			]
	});
	</script>
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
	

	