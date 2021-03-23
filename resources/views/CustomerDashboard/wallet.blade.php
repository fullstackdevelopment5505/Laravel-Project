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
                <!-- datepicker -->
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 top_btns">
                            <a href="{{route('customerTransactionHistory')}}" class="btn btn-success">Transaction History <i class="fa fa-history"></i></a>
						</div>
					</div>
				</div>
				<!-- datepicker -->
                <div class="col-sm-12">
					<div class="row">
						<div class="col-md-4 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/customer/images/wallet.svg')}}"></div>
								<div class="title">Total Wallet Credits</div>
								<div class="cus_num">2000</div>
							</div>
                        </div>	
                        <div class="col-md-4 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/customer/images/wallet.svg')}}"></div>
								<div class="title">Today Credit Points</div>
								<div class="cus_num">500</div>
							</div>
                        </div>		
                        <div class="col-md-4 single_box">
							<div class="inside">
								<div class="icon"><img src="{{asset('assets/customer/images/wallet.svg')}}"></div>
								<div class="title">Today Debit Points</div>
								<div class="cus_num">300</div>
							</div>
						</div>		
					</div>
                </div>
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!--content start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
                                <div class="title">Credit Plans</div>
									<table class="display responsive nowrap" width="100%">
										<thead>
										    <tr>
										        <th>Amount</th>
                                                <th>Credit</th>
                                                <th>Action</th>
										    </tr>
										</thead>
										<tbody>
										    <tr>
										        <td>$50</td>
                                                <td>100 Points</td>
                                                <td><a href="{{route('customerPayment')}}" class="btn btn-success">Add Credit</a></td>
                                            </tr>
                                            <tr>
										        <td>$100</td>
                                                <td>200 Points</td>
                                                <td><a href="{{route('customerPayment')}}" class="btn btn-success">Add Credit</a></td>
                                            </tr>
                                            <tr>
										        <td>$200</td>
                                                <td>400 Points</td>
                                                <td><a href="{{route('customerPayment')}}" class="btn btn-success">Add Credit</a></td>
                                            </tr>
                                            <tr>
										        <td>$500</td>
                                                <td>800 Points</td>
                                                <td><a href="{{route('customerPayment')}}" class="btn btn-success">Add Credit</a></td>
                                            </tr>
                                            <tr>
										        <td>$1000</td>
                                                <td>2000 Points</td>
                                                <td><a href="{{route('customerPayment')}}" class="btn btn-success">Add Credit</a></td>
                                            </tr>
                                            <tr>
										        <td>$2000</td>
                                                <td>5000 Points</td>
                                                <td><a href="{{route('customerPayment')}}" class="btn btn-success">Add Credit</a></td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
                            <!--content end-->
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