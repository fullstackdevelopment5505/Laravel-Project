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
                <!-- title area -->
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 from_to_filter">
							<form>
                                <div class="view_back"><a href="{{route('customerProfile')}}"><i class="fa fa-arrow-left"></i></a></div>
                                <div class="title">Edit Profile</div>
                            </form>
						</div>
					</div>
				</div>
				<!-- title area -->
			    <!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
                        <!--Parent div start -->
						<div class="col-sm-12 top_selling">
							<div class="inside about_customer">
                                <div class="row">
                                    <div class="col-sm-3 edit_profile_image">
                                        <div class="inset">
                                            <label>
                                                <span><img src="{{asset('assets/customer/images/photo.svg')}}"></span>
                                                <input type="file">
                                            </label>
                                        </div>
                                    </div>
                                    <div class="col-sm-9 edit_profile_fields">
                                        <div class="row">
                                            <div class="col-sm-4 edit_profile_box">
                                                <div class="form-group">
                                                    <label>Full Name</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 edit_profile_box">
                                                <div class="form-group">
                                                    <label>Email</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 edit_profile_box">
                                                <div class="form-group">
                                                    <label>Mobile No.</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 edit_profile_box">
                                                <div class="form-group">
                                                    <label>State</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 edit_profile_box">
                                                <div class="form-group">
                                                    <label>City</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-4 edit_profile_box">
                                                <div class="form-group">
                                                    <label>Postal Code</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                            <div class="col-sm-12 edit_profile_box">
                                                <div class="form-group">
                                                    <label>Address</label>
                                                    <input type="text" class="form-control">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <div class="col-sm-12 edit_profile_fields">
                                    <div class="form-group">
                                        <label>A Little About Yourself</label>
                                        <textarea class="form-control" rows="10"></textarea>
                                    </div>
                                </div>
                                <div class="col-sm-12 view_all">
                                    <a href="#" class="btn btn-success btn-lg">Save Profile</a>
                                </div>
                            </div>
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
  