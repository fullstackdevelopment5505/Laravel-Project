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
						<!--content start -->
						<div class="col-sm-8 top_selling">
							<div class="inside">
                                <div class="title">Your Membership Plan</div>
									<div class="membership_details">
                                        <div class="image"><img src="{{asset('assets/customer/images/user.jpg')}}"></div>
                                        <div class="membership_data">
                                            <div class="data_left">
                                                <div class="name">hi, John Doe</div>
                                                <label>valid Up to <span>23 Dec, 2020</span></label>
                                                <div class="available_plan">
                                                    <span>27 Days Left in membership</span>
                                                    <div class="progress"  style="height:30px"><div class="progress-bar bg-success progress-bar-striped progress-bar-animated" style="width:40%; height:30px;">40%</div></div>
                                                </div>
                                            </div>
                                            <div class="trophy"><img src="{{asset('assets/customer/images/badge.png')}}"></div>
                                        </div>
                                    </div>  
								</div>
							</div>
                            <!--content end-->
                            <!--content start -->
							<div class="col-sm-4 top_selling">
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
                            <!--content end-->
                            
                            <!--content start -->
							<div class="col-sm-12 top_selling membership_benefits">
								<div class="inside">
                                    <div class="title">Benefits Of Membership Plans</div>
                                    <div class="content">
                                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged.</p>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                        <p>
                                            <ul>
                                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                                <li>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</li>
                                                <li>Lorem Ipsum is simply dummy text of the printing and typesetting industry.</li>
                                                <li>It is a long established fact that a reader will be distracted by the readable.</li>
                                            </ul>
                                        </p>
                                        <p>It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem Ipsum is that it has a more-or-less normal distribution of letters, as opposed to using 'Content here, content here', making it look like readable English. Many desktop publishing packages and web page editors now use Lorem Ipsum as their default model text, and a search for 'lorem ipsum' will uncover many web sites still in their infancy. Various versions have evolved over the years, sometimes by accident, sometimes on purpose (injected humour and the like).</p>
                                    </div>
								</div>
							</div>
							<!--content end-->
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