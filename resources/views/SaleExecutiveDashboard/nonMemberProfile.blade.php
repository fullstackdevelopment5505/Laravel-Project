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
							    <div class="col-sm-12 top_selling profile_whole_detail">
									<div class="inside">
                                        <div class="title">Profile</div>
                                        <div class="row">
                                            <div class="col-sm-12 all_customer_data">
                                                <div class="profile_pic">
                                                    <img src="{{asset('assets/saleExecutive/images/user.jpg')}}">
                                                </div>
												@foreach($nonMemberDetail as $row)

                                                <div class="profile_left">
                                                    <h1> {{$row->name}}</h1>
                                                    <div class="member"><a href="#">Non member</a></div>
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