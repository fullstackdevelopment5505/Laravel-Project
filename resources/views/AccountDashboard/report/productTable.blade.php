@extends('AccountDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('AccountDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('AccountDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!-- Table start-->
						<div class="col-lg-12 top_selling">
							<div class="inside">
								<div class="title">Non Title Report</div>
									<table class="display responsive nowrap" width="100%">
										<thead>
										    <tr>
										        <th>GL Code</th>
										        <th>Title</th>
										        <th>Percentage</th>
										    </tr>
										</thead>
										<tbody>
										    <tr>
										        <td>220.4</td>
										        <td>Commission</td>
										        <td>0.25 Percent</td>
										    </tr>
										    <tr>
										        <td>215.5</td>
										        <td>Credit Card Fee</td>
										        <td>0.0312 Percent</td>
										    </tr>
										    <tr>
										        <td>215.4</td>
										        <td>Sales tax 8%</td>
										        <td>0.08 Percent</td>
										    </tr>
										    <tr>
										        <td>220.3</td>
										        <td>Mgr Override 5%</td>
										        <td>0.05 Percent</td>
										    </tr>
										    <tr>
										        <td>220.1</td>
										        <td>NSM 3%</td>
										        <td>0.03 Percent</td>
										    </tr>
										    <tr>
										        <td>220.2</td>
										        <td>LTA 1%</td>
										        <td>0.01 Percent</td>
										    </tr>
										    <tr>
										        <td>215.6</td>
										        <td>For Future Software Development</td>
										        <td>0.08 Percent</td>
										    </tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- Table end-->
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