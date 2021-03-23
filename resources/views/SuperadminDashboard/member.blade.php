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
					<div class="col-sm-6 top_selling customer_search active_now">
						<form action="#">
							<div class="inside">
								<div class="title mb-4">Search By Member 
									<label>
										<input type="radio" name="a" checked="checked">
										<span></span>
									</label>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="form-group">
											<label>State</label>
											<select class="form-control">
												<option selected="selected" disabled="disabled">Select State</option>
												<optgroup>
													<option>Alabama</option>
													<option>Alaska</option>
													<option>Arizona</option>
													<option>Arkansas</option>
													<option>California</option>
													<option>Colorado</option>
													<option>Connecticut</option>
													<option>Delaware</option>
													<option>District Of Columbia</option>
													<option>Florida</option>
													<option>Georgia</option>
												</optgroup>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>City</label>
											<select class="form-control">
												<option selected="selected" disabled="disabled">Select City</option>
												<optgroup>
													<option>Los Angeles</option>
													<option>San Francisco</option>
													<option>San Diego</option>
													<option>San Diego</option>
													<option>Fresno</option>
													<option>Oakland</option>
													<option>Long Beach</option>
													<option>Anaheim</option>
													<option>Riverside</option>
													<option>Irvine</option>
													<option>Palm Springs</option>
													<option>Santa Barbara</option>
													<option>Santa Ana</option>
													<option>Santa Rosa</option>
													<option>Santa Pomona</option>
												</optgroup>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Postal Code</label>
											<input type="text" class="form-control">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<h2>Joining Date</h2>
											<div class="row">
												<div class="col-sm-6">
													<label>From:</label>
													<input type="text" class="form-control datepicker">
												</div>
												<div class="col-sm-6">
													<label>To:</label>
													<input type="text" class="form-control datepicker">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<a href="customer-listing.php?active=custom"><input type="button" value="Search Result" class="btn btn-success"></a>
										<input type="reset" value="Reset" class="btn btn-danger">
									</div>
								</div>
							</div>
						</form>
						</div>
						<!-- Non Member end -->

						<!-- Non Member start -->
						<div class="col-sm-6 top_selling customer_search disable_now">
							<form action="#">
								<div class="inside">
									<div class="title mb-4">Search By Non-Member 
										<label>
											<input type="radio" name="a">
											<span></span>
										</label>
									</div>
									<div class="row">
										<div class="col-sm-12">
											<div class="form-group">
												<label>State</label>
												<select class="form-control">
													<option selected="selected" disabled="disabled">Select State</option>
													<optgroup>
														<option>Alabama</option>
														<option>Alaska</option>
														<option>Arizona</option>
														<option>Arkansas</option>
														<option>California</option>
														<option>Colorado</option>
														<option>Connecticut</option>
														<option>Delaware</option>
														<option>District Of Columbia</option>
														<option>Florida</option>
														<option>Georgia</option>
													</optgroup>
												</select>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>City</label>
												<select class="form-control">
													<option selected="selected" disabled="disabled">Select City</option>
													<optgroup>
														<option>Los Angeles</option>
														<option>San Francisco</option>
														<option>San Diego</option>
														<option>San Diego</option>
														<option>Fresno</option>
														<option>Oakland</option>
														<option>Long Beach</option>
														<option>Anaheim</option>
														<option>Riverside</option>
														<option>Irvine</option>
														<option>Palm Springs</option>
														<option>Santa Barbara</option>
														<option>Santa Ana</option>
														<option>Santa Rosa</option>
														<option>Santa Pomona</option>
													</optgroup>
												</select>
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<label>Postal Code</label>
												<input type="text" class="form-control">
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<h2>Joining Date</h2>
												<div class="row">
													<div class="col-sm-6">
														<label>From:</label>
														<input type="text" class="form-control datepicker">
													</div>
													<div class="col-sm-6">
														<label>To:</label>
														<input type="text" class="form-control datepicker">
													</div>
												</div>
											</div>
										</div>
										<div class="col-sm-12">
											<a href="customer-listing.php?active=custom"><input type="button" value="Search Result" class="btn btn-success"></a>
											<input type="reset" value="Reset" class="btn btn-danger">
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
