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
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Product List</div>
								<table class="display responsive nowrap" width="100%">
									<thead>
										<tr>
										    <th>Product List</th>
										    <th></th>
										</tr>
									</thead>
									<tbody>
										<tr>
										    <td>Last Transfer Document</td>
										    <td>$4.55</td>
										</tr>
										<tr>
										    <td>Last Finance Document</td>
										    <td>$4.55</td>
										</tr>
										<tr>
										    <td>Specific Document</td>
										    <td>$4.55</td>
										</tr>
										<tr>
										    <td>Assessor Map</td>
										    <td>$1.00</td>
										</tr>
										<tr>
										    <td>Property Detail Report</td>
										    <td>$0.70</td>
										</tr>
										<tr>
										    <td>TotalView Report</td>
										    <td>$5.85</td>
										</tr>
										<tr>
										    <td>Transaction History Report</td>
										    <td>$5.85</td>
										</tr>
										<tr>
										    <td>Open Lien Report</td>
										    <td>$5.85 </td>
										</tr>
										<tr>
										    <td>Sales Comparables</td>
										    <td>$2.10 </td>
										</tr>
										<tr>
										    <td>Title Chain & Lien Report</td>
										    <td>$20.00 </td>
										</tr>
										<tr>
										    <td>Tax Status Report</td>
										    <td>$2.30 </td>
										</tr>
										<tr>
										    <td>Foreclosure Report</td>
										    <td>$1.95 </td>
										</tr>
										<tr>
										    <td>Neighbors Report</td>
										    <td>$1.00  </td>
										</tr>
										<tr>
										    <td>PACE Lien Report</td>
										    <td>$5.85 </td>
										</tr>
										<tr>
										    <td>Mailing Label Export</td>
										    <td>$0.13 </td>
										</tr>
										<tr>
										    <td>Property Detail Export / Address Lead API</td>
										    <td>$0.10 </td>
										</tr>
										<tr>
										    <td>Open Lien Export Add-on</td>
										    <td>$3.58 </td>
										</tr>
										<tr>
										    <td>PACE Liens Export Add-on</td>
										    <td>$3.58 </td>
										</tr>
										<tr>
										    <td>HOA Lien Export Add-on</td>
										    <td>$3.58 </td>
										</tr>
										<tr>
										    <td>HOA Contact Export Add-on</td>
										    <td>$0.33 </td>
										</tr>
										<tr>
										    <td>Foreclosure Detail Export Add-on</td>
										    <td>$0.81 </td>
										</tr>
										<tr>
										    <td>Finance Scores Export Add-on</td>
										    <td>$0.33 </td>
										</tr>
										<tr>
										    <td>DataTree AVM</td>
										     <td>$5.85 </td>
										</tr>
										<tr>
										    <td>DataFinder</td>
										    <td>$0.02 </td>
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