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
						<div class="col-sm-8 from_to_filter">
                            <div class="view_back"><a onClick="javascript:history.go(-1)" href="javascript:void(0);"><i class="fa fa-arrow-left"></i></a></div>
                            <div class="title">Profile</div>
						</div>
					</div>
				</div>
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!--Parent div start -->
						<div class="col-sm-8 top_selling profile_whole_detail">
							<div class="inside">
                                <div class="title">Kickstarter Profile</div>
                                <div class="row">
                                    <div class="col-sm-12 all_customer_data">
                                        <div class="profile_pic">
                                            <?php if($Kickstarter->profile_image){ ?>
                                                <img class="user_avatar" src="{{$Kickstarter->profile_image->filename}}">
                                          <?php  }else{ ?>
                                            No Image
                                            <?php } ?>
                                        </div>
                                        <div class="profile_left">
                                            <h1>{{$Kickstarter->name}}</h1>
                                            <div class="member"><a href="#"><img src="{{asset('assets/customer/images/trophy.png')}}"> Kickstarter</a></div>
                                            <p><i class="fa fa-map-marker"></i> <span>{{$Kickstarter->address}}</span></p>
                                            <p><i class="fa fa-envelope"></i> <span>Email: {{$Kickstarter->email}}</span></p>
                                        </div>
                                        <div class="profile_right">    
                                            <p><i class="fa fa-map-pin"></i> <span>City: {{$city->CITY}}</span></p>
                                            <p><i class="fa fa-map"></i> <span>State: {{$state->STATE_NAME}}</span></p>
                                            <p><i class="fa fa-map-signs"></i> <span>Postal Code: {{$Kickstarter->postal_code}}</span></p>
                                            <p><i class="fa fa-flag"></i> <span>Country: United States</span></p>
                                            <p><i class="fa fa-phone"></i> <span>Phone No: {{$Kickstarter->phone}}</span></p>
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
                                            <p>{{date('d-M-yy', strtotime($Kickstarter->created_at))}}</p>
                                        </li>
                                        <!-- <li>
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
                                        </li> -->
                                    </ul>
                                </div>
							</div>
						</div>
                        @if($Kickstarter->description)
                        <div class="col-sm-12 top_selling">
                            <div class="inside about_customer">
                                <div class="title">About {{$Kickstarter->name}}</div>    
                                <div class="content">
                                {{$Kickstarter->description}}
                                </div>
                            </div>
                        </div>
                       @endif
                       
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