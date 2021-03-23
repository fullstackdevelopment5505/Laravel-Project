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
                    <!-- back -->
                    <div class="col-sm-12 top_bar_area">
                        <div class="row">
                            <div class="col-sm-12 from_to_filter mb-1">
                                <form>
                                    <div class="view_back"><a href="{{route('customerWallet')}}"><i class="fa fa-arrow-left"></i></a></div>
                                    <div class="title">Transaction History</div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!-- back -->
                    <!-- main row start-->
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12 customer_tabs">
                                <ul class="nav nav-pills">
                                    <li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#credit_points">Credit Points</a></li>
                                    <li class="nav-item"><a class="nav-link" data-toggle="pill" href="#debit_points">Debit Points</a></li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <!--table start -->
                                <div class="col-sm-12 tab-pane active top_selling" id="credit_points">
                                    <div class="inside">
                                        <div class="title">Credit Points</div>
                                            <table class="display responsive nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Transaction ID</th>
                                                        <th>Amount</th>
                                                        <th>Credit</th>
                                                        <th>Payment Method</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>$50</td>
                                                        <td>100 Points</td>
                                                        <td>Net Banking</td>
                                                    </tr>
                                                </tbody>
										    </table>
									    </div>
								    </div>
								    <!--table end-->
                                    <!--table start -->
                                    <div class="col-sm-12  tab-pane top_selling fade" id="debit_points">
                                        <div class="inside">
                                            <div class="title">Debit Points</div>
                                            <table class="display responsive nowrap" width="100%">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Transaction ID</th>
                                                        <th>Debit</th>
                                                        <th>Debit Type</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
                                                    </tr>
                                                    <tr>
                                                        <td>20 Jan, 2020 16:35:40</td>
                                                        <td>#TRN214</td>
                                                        <td>100 Point</td>
                                                        <td>Report Purchase</td>
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