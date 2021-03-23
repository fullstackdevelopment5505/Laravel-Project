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
						<div class="col-sm-12 advance_search_data">
							<!-- <img src="assets/customer/images/advance-search.png"> -->
							<iframe src="https://clockwise4u.com/equity/authentication/login" width="100%" height="1670" scrolling="no" frameborder="0"></iframe>
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
	