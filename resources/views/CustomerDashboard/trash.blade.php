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
						<!-- datepicker -->
						<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-12 from_to_filter">
									<form>
										<div class="form-group">
										    <label>From:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<div class="form-group">
											<label>To:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<button type="button" class="btn btn-success">Search</button>
									</form>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Trash</div>
									<table class="display responsive nowrap" width="100%">
										<thead>
										    <tr>
												<th>Date</th>
												<th>Address</th>
												<th>Amount</th>
												<th>Action</th>
										    </tr>
										</thead>
										<tbody>
										    <tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
											</tr>
											<tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
											</tr>
											<tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
											</tr>
											<tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
											</tr>
											<tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
											</tr>
											<tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
											</tr>
											<tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
											</tr>
											<tr>
												<td>2020-02-14 06:54:35</td>
												<td><a href="#">100 B ST</a></td>
												<td>$0</td>
												<td><a href="#" class="btn btn-success"><i class="fa fa-undo"></i> Restore</a></td>
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