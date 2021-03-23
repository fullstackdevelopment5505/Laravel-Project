@extends('CustomerDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('CustomerDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('CustomerDashboard.layouts.header');
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-sm-12">
					<div class="row">
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/customer/images/notes.png')}}"></div>
								<div class="title">Total Purchased Reports</div>
								<div class="cus_num">1000</div>
							</div>
						</div>
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/customer/images/bulb.png')}}"></div>
								<div class="title">Interested Property</div>
								<div class="cus_num">1500</div>
							</div>
						</div>
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/customer/images/fire.png')}}"></div>
								<div class="title">Highly Interested Property</div>
								<div class="cus_num">2500</div>
							</div>
						</div>
						<div class="col-md-3 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/customer/images/heart.png')}}"></div>
								<div class="title">Saved Searches</div>
								<div class="cus_num">500</div>
							</div>
						</div>					
					</div>
				</div>
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!-- Interested properties start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title mb-4">interested properties</div>
									<div class="row">
										<div class="col-md-4 col-lg-3 property_box">
											<a href="#" target="_blank">
												<div class="inset">
													<div class="image_and_bulb">
														<p><img src="{{asset('assets/customer/images/house1.jpg')}}"></p>
														<span><img src="{{asset('assets/customer/images/bulb.png')}}"></span>
													</div>
													<div class="parent_data">
														<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
														<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
													</div>
												</div>
											</a>
										</div>
										<div class="col-md-4 col-lg-3 property_box">
											<a href="#" target="_blank">
												<div class="inset">
													<div class="image_and_bulb">
														<p><img src="{{asset('assets/customer/images/house2.jpg')}}"></p>
														<span><img src="{{asset('assets/customer/images/bulb.png')}}"></span>
													</div>
													<div class="parent_data">
														<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
														<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
													</div>
												</div>
											</a>
										</div>
										<div class="col-md-4 col-lg-3 property_box">
											<a href="#" target="_blank">
												<div class="inset">
													<div class="image_and_bulb">
														<p><img src="{{asset('assets/customer/images/house3.jpg')}}"></p>
														<span><img src="{{asset('assets/customer/images/bulb.png')}}"></span>
													</div>
													<div class="parent_data">
														<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
														<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
													</div>
												</div>
											</a>
										</div>
										<div class="col-md-4 col-lg-3 property_box">
											<a href="#" target="_blank">
												<div class="inset">
													<div class="image_and_bulb">
														<p><img src="{{asset('assets/customer/images/house4.jpg')}}"></p>
														<span><img src="{{asset('assets/customer/images/bulb.png')}}"></span>
													</div>
													<div class="parent_data">
														<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
														<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
													</div>
												</div>
											</a>
										</div>
									</div>

									<div class="view_all"><a href="interested-properties.php?active=prop1" class="btn btn-success btn-lg">View All</a></div>
								</div>
							</div>
							<!-- Interested properties end-->
							<!--Highly Interested properties start-->
							<div class="col-sm-12 top_selling">
								<div class="inside">
									<div class="title mb-4">Highly interested properties</div>
										<div class="row">
											<div class="col-md-4 col-lg-3 property_box">
												<a href="#" target="_blank">
													<div class="inset">
														<div class="image_and_bulb">
															<p><img src="{{asset('assets/customer/images/house1.jpg')}}"></p>
															<span><img src="{{asset('assets/customer/images/fire.png')}}"></span>
														</div>
														<div class="parent_data">
															<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
															<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
														</div>
													</div>
												</a>
											</div>
											<div class="col-md-4 col-lg-3 property_box">
												<a href="#" target="_blank">
													<div class="inset">
														<div class="image_and_bulb">
															<p><img src="{{asset('assets/customer/images/house2.jpg')}}"></p>
															<span><img src="{{asset('assets/customer/images/fire.png')}}"></span>
														</div>
														<div class="parent_data">
															<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
															<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
														</div>
													</div>
												</a>
											</div>

											<div class="col-md-4 col-lg-3 property_box">
												<a href="#" target="_blank">
													<div class="inset">
														<div class="image_and_bulb">
															<p><img src="{{asset('assets/customer/images/house3.jpg')}}"></p>
															<span><img src="{{asset('assets/customer/images/fire.png')}}"></span>
														</div>
														<div class="parent_data">
															<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
															<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
														</div>
													</div>
												</a>
											</div>

											<div class="col-md-4 col-lg-3 property_box">
												<a href="#" target="_blank">
													<div class="inset">
														<div class="image_and_bulb">
															<p><img src="{{asset('assets/customer/images/house4.jpg')}}"></p>
															<span><img src="{{asset('assets/customer/images/fire.png')}}"></span>
														</div>
														<div class="parent_data">
															<div class="data">2 Bed 3 Bath 1,599 Sqft 725 tehama St Unit 4</div>
															<div class="data2">1026 Ohio Avenue Long Beach, CA 90804, USA</div>
														</div>
													</div>
												</a>
											</div>
										</div>

										<div class="view_all"><a href="highly-interested-properties.php?active=prop2" class="btn btn-success btn-lg">View All</a></div>
									</div>
								</div>
								<!--Highly Interested properties end-->
								<!--table start -->
								<div class="col-sm-12 top_selling">
									<div class="inside">
										<div class="title">Recent Saved Searches</div>
											<table class="display responsive nowrap" width="100%">
												<thead>
													<tr>
														<th>date</th>
														<th>name</th>
														<th>id</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>02/10/2020</td>
														<td>Mortg...am</td>
														<td>#EQ000123</td>
														<td><a href="#" class="btn btn-success">View</a></td>
													</tr>
													<tr>
														<td>02/10/2020</td>
														<td>Mortg...am</td>
														<td>#EQ000123</td>
														<td><a href="#" class="btn btn-success">View</a></td>
													</tr>
													<tr>
														<td>02/10/2020</td>
														<td>Mortg...am</td>
														<td>#EQ000123</td>
														<td><a href="#" class="btn btn-success">View</a></td>
													</tr>
													<tr>
														<td>02/10/2020</td>
														<td>Mortg...am</td>
														<td>#EQ000123</td>
														<td><a href="#" class="btn btn-success">View</a></td>
													</tr>
													<tr>
														<td>02/10/2020</td>
														<td>Mortg...am</td>
														<td>#EQ000123</td>
														<td><a href="#" class="btn btn-success">View</a></td>
													</tr>
													<tr>
														<td>02/10/2020</td>
														<td>Mortg...am</td>
														<td>#EQ000123</td>
														<td><a href="#" class="btn btn-success">View</a></td>
													</tr>
													<tr>
														<td>02/10/2020</td>
														<td>Mortg...am</td>
														<td>#EQ000123</td>
														<td><a href="#" class="btn btn-success">View</a></td>
													</tr>
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
	<!-- main div end -->
@endsection
