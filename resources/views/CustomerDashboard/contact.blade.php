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
							<div class="col-sm-12 customer_tabs">
								<ul class="nav nav-pills">
									<li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#sale_manager">Sales Manager</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#sale_executive">Sales Executive</a></li>
								</ul>
							</div>
							<div class="tab-content">
								<!--table start -->
								<div class="col-sm-12 tab-pane active top_selling" id="sale_manager">
									<div class="inside">
										<div class="title">Sales Manager</div>
											<table class="display responsive nowrap" width="100%">
												<thead>
													<tr>
														<th>Sr. No.</th>
														<th>Name</th>
														<th>Location</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1</td>
														<td>John Doe</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>2</td>
														<td>Leon kennedy</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>3</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>4</td>
														<td>John Doe</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>5</td>
														<td>Leon kennedy</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>6</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>7</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>8</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
												</tbody>
											</table>
										</div>
									</div>
									<!--table end-->

									<!--table start -->
									<div class="col-sm-12  tab-pane top_selling fade" id="sale_executive">
											<div class="inside">
												<div class="title">Sales Executive</div>
												<table class="display responsive nowrap" width="100%">
												<thead>
													<tr>
														<th>Sr. No.</th>
														<th>Name</th>
														<th>Location</th>
														<th>Action</th>
													</tr>
												</thead>
												<tbody>
													<tr>
														<td>1</td>
														<td>John Doe</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>2</td>
														<td>Leon kennedy</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>3</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>4</td>
														<td>John Doe</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>5</td>
														<td>Leon kennedy</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>6</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>7</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
													<tr>
														<td>8</td>
														<td>Chris Redfill</td>
														<td>California</td>
														<td><a href="#" class="btn btn-success">Message</a></td>
													</tr>
												</tbody>
												</table>
											</div>
										</div>
									<!--table end-->
								</div>
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
		