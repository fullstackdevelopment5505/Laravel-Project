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
								<div class="title">Balance Sheet</div>
								<table class="display responsive nowrap" width="100%" id="incomeExpenceList">
									<thead>
										<tr>
										<th>Date</th>
										    <th>Income</th>
										    <th>Expense</th>
											<th>Profit</th>
										</tr>
									</thead>
									<tbody>
								<tr>
								<td>{{@$Todaydate}}</td>
								<td>$ {{@$ledger}}</td>
								<td>$ {{@$Expence}}</td>
								<td>$ {{@$profit}}</td>
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
	@section('page_js')



@endsection	

