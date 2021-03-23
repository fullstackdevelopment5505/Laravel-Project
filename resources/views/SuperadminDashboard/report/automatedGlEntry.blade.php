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
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">	
						<!-- Table start-->
						<div class="col-lg-12 top_selling">
							<div class="inside">
								<div class="title">Automated GL Entry</div>
								<table class="display responsive nowrap" width="100%">
									<thead>
										<tr>
										    <th>GL Code</th>
										    <th>Amount</th>
										    <th>User ID</th>
										    <th>Entry User ID</th>
										    <th>Entry Date Time</th>
										    <th>Batch#</th>
										</tr>
									</thead>
									<tbody>
										<tr>
										    <td>220.4</td>
										    <td>$5.00</td>
										    <td>6</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.234</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
										</tr>
										<tr>
										    <td>215.5</td>
										    <td>$0.62</td>
										    <td>8</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.239</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
										</tr>
										<tr>
										    <td>215.4</td>
										    <td>$1.60</td>
										    <td>7</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.345</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
										</tr>
										<tr>
										    <td>220.3</td>
										    <td>$1.00</td>
										    <td>5</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.389</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
										</tr>
										<tr>
										    <td>220.1</td>
										    <td>$0.60</td>
										    <td>3</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.456</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
										</tr>
										<tr>
										    <td>220.2</td>
										    <td>$0.20</td>
										    <td>4</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.498</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
										</tr>
										<tr>
										    <td>215.6</td>
										    <td>$0.08</td>
										    <td>9</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.588</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
										</tr>
										<tr>
										    <td>240.1</td>
										    <td>-20.00</td>
										    <td>12</td>
										    <td>0</td>
										    <td>2-6-2020 3:14:01.588</td>
										    <td>5010af04-7816-47af-b002-077e137cf6d7</td>
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