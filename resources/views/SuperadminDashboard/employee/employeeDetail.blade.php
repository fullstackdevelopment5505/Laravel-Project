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
                                <div class="title">Contractor Profile</div>
                                <div class="row">
                                    <div class="col-sm-12 all_customer_data">
                                        <div class="profile_pic">
                                            <?php if($user->image){ ?>
                                                <img class="user_avatar" src="{{$user->image->filename}}">
                                          <?php  }else{ ?>
                                            No Image
                                            <?php } ?>
                                        </div>
                                        <div class="profile_left">
                                            <h1>{{ $user->detail ? $user->detail->f_name." ". $user->detail->l_name : "" }}</h1>
                                            <p><i class="fa fa-map-marker"></i> <span>{{ ($user->detail) ? $user->detail->address : "" }}
                                            {{ ($user->detail) ? ( ($user->detail->address!="")? $user->detail->address : $user->detail->CITY ) : '-' }}
                                            {{ ($user->detail) ? ( ($user->detail->address=="")? ",".$user->detail->STATE_NAME : "" ) : '-' }}
											</span></p>
                                            <p><i class="fa fa-envelope"></i> <span>Email: {{$user->email}}</span></p>
                                        </div>
                                        <div class="profile_right"> 
                                            <p><i class="fa fa-map-pin"></i> <span>City: {{ ($user->detail) ? $user->detail->CITY : "" }}</span></p>
                                            <p><i class="fa fa-map"></i> <span>State: {{ ($user->detail) ? $user->detail->STATE_NAME : "" }}</span></p>
                                            <p><i class="fa fa-map-signs"></i> <span>Postal Code: {{ ($user->detail) ? $user->detail->postal_code : "" }}</span></p>
                                            <p><i class="fa fa-flag"></i> <span>Country: United States</span></p>
                                            <p><i class="fa fa-phone"></i> <span>Phone No: {{ ($user->detail) ? $user->detail->phone : "" }}</span></p>
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
                                            <p>{{date('d/m/Y', strtotime($user->created_at))}}</p>
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
                        @if($user->detail)
                        <div class="col-sm-12 top_selling">
                            <div class="inside about_customer">
                                <div class="title">About {{ ($user->detail) ? $user->detail->f_name." ".  $user->detail->l_name : "" }}</div>    
                                <div class="content">
                                {{$user->detail->description}}
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