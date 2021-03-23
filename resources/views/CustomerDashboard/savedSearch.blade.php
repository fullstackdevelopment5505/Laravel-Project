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
						<!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Saved Searches</div>
								<table class="display responsive nowrap" width="100%">
									<thead>
										<tr>
										    <th>date</th>
										    <th>name</th>
											<th>ID</th>
											<th>Action</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										    <td>02/10/2020</td>
											<td>Mortg...am</td>
											<td>#EQ000123</td>
										    <td><a href="#" class="btn btn-success">View</a></td>
										</tr>
										<tr>
										    <td>02/10/2020</td>
											<td>Mortg...am</td>
											<td>#EQ000123</td>
										    <td><a href="#" class="btn btn-success">View</a></td>
										</tr>
										<tr>
										    <td>02/10/2020</td>
											<td>Mortg...am</td>
											<td>#EQ000123</td>
										    <td><a href="#" class="btn btn-success">View</a></td>
										</tr>
										<tr>
										    <td>02/10/2020</td>
											<td>Mortg...am</td>
											<td>#EQ000123</td>
										    <td><a href="#" class="btn btn-success">View</a></td>
										</tr>
										<tr>
										    <td>02/10/2020</td>
											<td>Mortg...am</td>
											<td>#EQ000123</td>
										    <td><a href="#" class="btn btn-success">View</a></td>
										</tr>
										<tr>
										    <td>02/10/2020</td>
											<td>Mortg...am</td>
											<td>#EQ000123</td>
										    <td><a href="#" class="btn btn-success">View</a></td>
										</tr>
										<tr>
										    <td>02/10/2020</td>
											<td>Mortg...am</td>
											<td>#EQ000123</td>
										    <td><a href="#" class="btn btn-success">View</a></td>
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