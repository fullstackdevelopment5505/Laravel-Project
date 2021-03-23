@extends('SaleExecutiveDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('SaleExecutiveDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SaleExecutiveDashboard.layouts.header');	
			<!-- header start -->
			<!-- header end -->
			<!-- inside_content_area start-->
			<div class="content_area">
                <!-- datepicker -->
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 top_btns">
							<a href="{{route('saleExecutiveEditProfile')}}" class="btn btn-primary">Edit Profile <i class="fa fa-pencil"></i></a>
						</div>
					</div>
				</div>
				<!-- datepicker -->
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!--Parent div start -->
						<div class="col-sm-8 top_selling profile_whole_detail">
							<div class="inside">
                                <div class="title">Profile</div>
                                    <div class="row">
                                        <div class="col-sm-12 all_customer_data">
                                            <div class="profile_pic">
                                                <img src="{{asset('assets/saleExecutive/images/user.jpg')}}">
                                            </div>
											@foreach($customerDetail as $row)
												<div class="profile_left">
													<h1> {{$row->name}}</h1>
													<div class="member"><a href="#"><img src="{{asset('assets/saleExecutive/images/trophy.png')}}"> member</a></div>
													<p><i class="fa fa-map-marker"></i> <span>795 Folsom Ave, Suite 600 San Francisco, CADGE 94107</span></p>
													<p><i class="fa fa-envelope"></i> <span>{{$row->email}}</span></p>
												</div>
												<div class="profile_right">
													<p><i class="fa fa-flag"></i> <span>Country: United States</span></p>
													<p><i class="fa fa-map"></i> <span>State: California</span></p>
													<p><i class="fa fa-map-pin"></i> <span>City:{{$row->location}}</span></p>
													<p><i class="fa fa-map-signs"></i> <span>Postal Code: 90224</span></p>
													<p><i class="fa fa-phone"></i> <span>Phone No:{{$row->phoneno}}</span></p>
												</div>
											@endforeach
                                        </div>
                                    </div>
								</div>
							</div>
                            <!--Parent div end-->

                            <!--Parent div start -->
							<div class="col-sm-4 top_selling customer_joined_details">
								<div class="inside">
                                    <div class="customer_other_details">
                                        <ul>
                                            <li>
                                                <strong>Joining Date:</strong>
                                                <p>10/01/2020</p>
                                            </li>
                                                <li>
                                                    <strong>Report Purchased:</strong>
                                                    <p>400</p>
                                                </li>
                                                <li>
                                                    <strong>Sales Manager:</strong>
                                                    <p>House</p>
                                                </li>
                                                <li>
                                                    <strong>Sales Executive:</strong>
                                                    <p>Robert</p>
                                                </li>
                                            </ul>
                                        </div>
									</div>
								</div>
                            <!--Parent div end-->


                            <div class="col-sm-8 top_selling mt-4">
									<div class="inside">
                                        <div class="title">Your Membership Plan</div>
										@foreach($customerDetail as $row)

										<div class="membership_details">
                                            <div class="membership_data">
                                                <div class="data_left">
                                                    <div class="name">hi, {{$row->name}}</div>
                                                    <label>valid Up to <span>23 Dec, 2020</span></label>
                                                    <div class="available_plan">
                                                        <span>27 Days Left in membership</span>
                                                        <div class="progress" style="height:30px"><div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:40%; height:30px;">40%</div></div>
                                                    </div>
                                                </div>
                                                <div class="trophy"><img src="{{asset('assets/saleExecutive/images/badge.png')}}"></div>
                                            </div>
                                        </div>
                                        @endforeach
									</div>
								</div>

								<div class="col-sm-4 top_selling mt-4">
									<div class="inside">
                                        <div class="title">About Membership</div>
                                        <div class="about_membership">
                                            <div class="list">
                                                <strong>Membership Type:</strong>
                                                <span>Regular</span>
                                            </div>
                                            <div class="list">
                                                <strong>Membership Amount:</strong>
                                                <span>$99.99</span>
                                            </div>
                                            <div class="list">
                                                <strong>Purchase Date:</strong>
                                                <span>10 Jan, 2020</span>
                                            </div>
                                        </div>
                                        <div class="member_cta"><a href="#" class="btn btn-primary">Renew Your Membership</a></div>
									</div>
								</div>


                             <!--Parent div start -->
							    <div class="col-sm-12 top_selling">
									<div class="inside about_customer">
									@foreach($customerDetail as $row)

                                        <div class="title">About  {{$row->name}}</div>    
									@endforeach	
                                        <div class="content">
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In vitae cum iste reprehenderit rem ex ratione possimus sequi quod. Atque quia eaque consequuntur repellat eveniet veniam dolor dicta asperiores delectus!</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In vitae cum iste reprehenderit rem ex ratione possimus sequi quod.</p>
                                            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. In vitae cum iste reprehenderit rem ex ratione possimus sequi quod. Atque quia eaque consequuntur repellat eveniet veniam dolor dicta asperiores delectus!</p>
                                        </div>
									</div>
								</div>
                            <!--Parent div end-->
                            
                            
                            <!--Parent div start -->
							    <div class="col-sm-12 top_selling">
									<div class="inside">
                                        <div class="title">Recent used Area Filters:</div>    
                                        <div class="areas">
                                            <ul>
                                                <li><a href="#">Sab Diego</a></li>
                                                <li><a href="#">Los Angeles</a></li>
                                                <li><a href="#">San Jose</a></li>
                                                <li><a href="#">Fresno</a></li>
                                                <li><a href="#">San Francisco</a></li>
                                                <li><a href="#">Oakland</a></li>
                                                <li><a href="#">Long Beach</a></li>
                                                <li><a href="#">Riverside</a></li>
                                                <li><a href="#">Palm Springs</a></li>
                                                <li><a href="#">Pasadena</a></li>
                                                <li><a href="#">Stockton</a></li>
                                                <li><a href="#">Santa Monica</a></li>
                                                <li><a href="#">modesto</a></li>
                                            </ul>
                                        </div>
									</div>
								</div>
                            <!--Parent div end-->
                            
                             <!--Parent div start -->
							    <div class="col-sm-12 top_selling">
									<div class="inside">
                                        <img src="{{asset('assets/saleExecutive/images/map-marker.png')}}" width="100%">
									</div>
								</div>
							<!--Parent div end-->
														<!--table start -->
							<div class="col-sm-12 top_selling">
									<div class="inside">
										<div class="title">Saved Searches</div>
										<table class="display responsive nowrap" width="100%">
										<thead>
										        <tr>
										            <th>date</th>
										            <th>name</th>
													<th>ID</th>
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