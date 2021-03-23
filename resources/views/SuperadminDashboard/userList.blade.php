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
			<div class="col-sm-12">
				<div class="row">
					<!-- Non Member start -->
					<div class="col-sm-12 top_selling customer_search active_now">
						 <form action="{{route('superadminDashboardTrashUser')}}" method="post" id="userform" >
						{{@csrf_field()}}
							<div class="inside">
								
								<div class="row">
									<div class="col-sm-12">
										<div class="row">
											<div class="col-sm-6">
												<div class="form-group">
													<label>Users</label>
													<select class="form-control" name="user_id">
														<option value="">Select User</option>
														@foreach($users as $val)
														<option value="{{$val->id}}">{{$val->email}}</option>
														@endforeach
													</select>
												</div>
											</div>
											<div class="col-sm-6">
												<div class="form-group">
													<label>Affiliates</label>
													<select class="form-control" name="affiliate_id">
														<option value="">Select Affiliate</option>
														@foreach($affiliates as $val)
														<option value="{{$val->id}}">{{$val->email}}</option>
														@endforeach
													</select>
												</div>
											</div>
										</div>
									</div>
									
									
									<div class="col-sm-12">
									 <button type="submit"  class="btn btn-success btn-submit save_button">Delete</button>
									</div>
								</div>
							</div>
						</form>
						</div>
						<!-- Non Member end -->

						
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
		</section>
		<!-- right area end -->
	</div>
	<!-- main div end -->
@endsection
