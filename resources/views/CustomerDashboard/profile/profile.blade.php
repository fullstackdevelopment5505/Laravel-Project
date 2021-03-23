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
                <!-- datepicker -->
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 top_btns">
							<a href="{{route('customerEditProfile')}}" class="btn btn-primary">Edit Profile <i class="fa fa-pencil"></i></a>
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
                                            <img src="{{asset('assets/customer/images/user.jpg')}}">
                                        </div>
                                        <div class="profile_left">
                                            <h1>John Strehl</h1>
                                            <div class="member"><a href="#"><img src="{{asset('assets/customer/images/trophy.png')}}"> member</a></div>
                                            <p><i class="fa fa-map-marker"></i> <span>795 Folsom Ave, Suite 600 San Francisco, CADGE 94107</span></p>
                                            <p><i class="fa fa-envelope"></i> <span>Email: johnsterehl@gmail.com</span></p>
                                        </div>
                                        <div class="profile_right">
                                            <p><i class="fa fa-flag"></i> <span>Country: United States</span></p>
                                            <p><i class="fa fa-map"></i> <span>State: California</span></p>
                                            <p><i class="fa fa-map-pin"></i> <span>City: Los Angeles</span></p>
                                            <p><i class="fa fa-map-signs"></i> <span>Postal Code: 90224</span></p>
                                            <p><i class="fa fa-phone"></i> <span>Phone No: 656-555-1414</span></p>
                                        </div>
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
                        <!--Parent div start -->
						<div class="col-sm-12 top_selling">
							<div class="inside about_customer">
                                <div class="title">About John Strehl</div>    
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
                                <img src="{{asset('assets/customer/images/map-marker.png')}}" width="100%">
							</div>
						</div>
						<!--Parent div end-->
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