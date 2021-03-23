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
					<!-- main row start-->
					<div class="col-sm-12">
						<div class="row">
							<!--Highly Interested properties start-->
							<div class="col-sm-12 top_selling all_properties">
								<div class="inside">
									<div class="title mb-4">
										<p>Highly interested properties</p>
										<div class="list_and_grid">
											<i class="fa fa-th active grid_view"></i>
											<i class="fa fa-list-ul list_view"></i>
										</div>
									</div>
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

										<div class="col-sm-12 mt-4 mb-3">
											<nav aria-label="Page navigation example">
												<ul class="pagination justify-content-center">
													<li class="page-item disabled">
														<span class="page-link">Previous</span>
													</li>
													<li class="page-item"><a class="page-link" href="#">1</a></li>
													<li class="page-item active">
														<span class="page-link">
															2
															<span class="sr-only">(current)</span>
														</span>
													</li>
													<li class="page-item"><a class="page-link" href="#">3</a></li>
													<li class="page-item">
														<a class="page-link" href="#">Next</a>
													</li>
												</ul>
											</nav>
										</div>
									</div>
								</div>
							</div>
							<!--Highly Interested properties end-->
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