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
						<div class="col-lg-6 top_selling">
							<div class="inside">
								<div class="title">Lead Sale</div>
								<table class="display responsive nowrap" width="100%">
									<thead>
										<tr>
										    <th>GL Code</th>
										    <th>Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										    <td>215.1</td>
										    <td>0.10 Value</td>
										</tr>
										<tr>
										    <td>220.4</td>
										    <td>0.25 Percent</td>
										</tr>
										<tr>
										    <td>215.5</td>
										    <td>0.0312 Percent</td>
										</tr>
										<tr>
										    <td>215.4</td>
										    <td>0.08 Percent</td>
										</tr>
										<tr>
										    <td>220.3</td>
										    <td>0.05 Percent</td>
										</tr>
										<tr>
										    <td>220.1</td>
										    <td>0.03 Percent</td>
										</tr>
										<tr>
										    <td>220.2</td>
										    <td>0.01 Percent</td>
										</tr>
										<tr>
										    <td>215.6</td>
										    <td>0.08 Percent</td>
										</tr>
										<tr>
										    <td>240.1</td>
										    <td>Full Amt Charged </td>
										</tr>
										<tr>
										    <td>220.6</td>
										    <td>Left Over Amount Value</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Table end-->

						<!-- Table start-->
						<div class="col-lg-6 top_selling">
							<div class="inside">
								<div class="title">Title Report</div>
								<table class="display responsive nowrap" width="100%">
									<thead>
										<tr>
										    <th>GL Code</th>
										    <th>Value</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										    <td>215.1</td>
										    <td>20.00 Value</td>
										</tr>
										<tr>
										    <td>220.4</td>
										    <td>0.25 Percent</td>
										</tr>
										<tr>
										    <td>215.5</td>
										    <td>0.0312 Percent</td>
										</tr>
										<tr>
										    <td>215.4</td>
										    <td>0.08 Percent</td>
										</tr>
										<tr>
										    <td>220.3</td>
										    <td>0.05 Percent</td>
										</tr>
										<tr>
										    <td>220.1</td>
										    <td>0.03 Percent</td>
										</tr>
										<tr>
										    <td>220.2</td>
										    <td>0.01 Percent</td>
										</tr>
										<tr>
										    <td>215.6</td>
										    <td>0.08 Percent</td>
										</tr>
										<tr>
										    <td>240.1</td>
										    <td>Full Amt Charged </td>
										</tr>
										<tr>
										    <td>220.6</td>
										    <td>Left Over Amount</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Table end-->

						<!-- Table start-->
						<div class="col-lg-6 top_selling">
							<div class="inside">
								<div class="title">Foreclosure Report</div>
								<table class="display responsive nowrap" width="100%">
									<thead>
										<tr>
										    <th>GL Code</th>
										    <th>Value</th>
										</tr>
										</thead>
										<tbody>
										    <tr>
										        <td>215.1</td>
										        <td>20.00 Value</td>
										    </tr>
										    <tr>
										        <td>220.4</td>
										        <td>0.25 Percent</td>
										    </tr>
										    <tr>
										        <td>215.5</td>
										        <td>0.0312 Percent</td>
										    </tr>
										    <tr>
										        <td>215.4</td>
										        <td>0.08 Percent</td>
										    </tr>
										    <tr>
										        <td>220.3</td>
										        <td>0.05 Percent</td>
										    </tr>
										    <tr>
										        <td>220.1</td>
										        <td>0.03 Percent</td>
										    </tr>
										    <tr>
										        <td>220.2</td>
										        <td>0.01 Percent</td>
										    </tr>
										    <tr>
										        <td>215.6</td>
										        <td>0.08 Percent</td>
										    </tr>
										    <tr>
										        <td>240.1</td>
										        <td>Full Amt Charged </td>
										    </tr>
										    <tr>
										        <td>220.6</td>
										        <td>Left Over Amount</td>
										    </tr>
										</tbody>
									</table>
								</div>
							</div>
							<!-- Table end-->

							<!-- Table start-->
							<div class="col-lg-6 top_selling">
								<div class="inside">
									<div class="title">Pace Lien Report</div>
									<table class="display responsive nowrap" width="100%">
										<thead>
										    <tr>
										        <th>GL Code</th>
										        <th>Value</th>
										    </tr>
										</thead>
										<tbody>
										    <tr>
										        <td>215.1</td>
										        <td>20.00 Value</td>
										    </tr>
										    <tr>
										        <td>220.4</td>
										        <td>0.25 Percent</td>
										    </tr>
										    <tr>
										        <td>215.5</td>
										        <td>0.0312 Percent</td>
										    </tr>
										    <tr>
										        <td>215.4</td>
										        <td>0.08 Percent</td>
										    </tr>
										    <tr>
										        <td>220.3</td>
										        <td>0.05 Percent</td>
										    </tr>
										    <tr>
										        <td>220.1</td>
										        <td>0.03 Percent</td>
										    </tr>
										    <tr>
										        <td>220.2</td>
										        <td>0.01 Percent</td>
										    </tr>
										    <tr>
										        <td>215.6</td>
										        <td>0.08 Percent</td>
										    </tr>
										    <tr>
										        <td>240.1</td>
										        <td>Full Amt Charged </td>
										    </tr>
										    <tr>
										        <td>220.6</td>
										        <td>Left Over Amount</td>
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