@extends('AffiliateDashboard.master')
@section('content')
	<!-- main div start -->
<style>
	body {
  font-family: -apple-system, BlinkMacSystemFont, 
  "Segoe UI", Roboto, Helvetica, Arial, sans-serif, 
  "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
}
#chartdiv {
  width: 100%;
  height: 361px;
  overflow: hidden;
}
</style>
	<div class="main_area">
		@include('AffiliateDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('AffiliateDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-12 left_area">
								<div class="row">
									<div class="col-md-3 single_box">
										<div class="inside">
											<div class="title">Members</div>
											<div class="cus_num">{{$customerJoined}}</div>
											@if($joinPercent>0)
											<div class="cus_revenue grow"><i class="fa fa-arrow-up"></i>{{$joinPercent}}%</div>
											@else
											<div class="cus_revenue grow loss"><i class="fa fa-arrow-down"></i>{{$joinPercent}}%</div>
											@endif
											<div class="cus_rev_title">Since last month</div><br>
											<a href="{{url('salemanager/members')}}" style="font-weight:bold">View All Members</a>
										</div>	
									</div>
									<div class="col-md-3 single_box">
										<div class="inside">
											<div class="title">Non Members</div>
											<div class="cus_num">{{$customerEnrolled}}</div>
											@if($enrollPercent>0)
											<div class="cus_revenue grow"><i class="fa fa-arrow-up"></i>{{$enrollPercent}}%</div>
											@else
											<div class="cus_revenue grow loss"><i class="fa fa-arrow-down"></i>{{$enrollPercent}}%</div>
											@endif
											<div class="cus_rev_title">Since last month</div><br>
											<a href="{{url('salemanager/non-member/list')}}" style="font-weight:bold">View All Non-members</a>
										</div>
									</div>
									<div class="col-md-3 single_box">
										<div class="inside">
											<div class="title">Monthly Sales To Date</div>
											<div class="cus_num">${{$currentMonthPoint}}</div>
											@if($changePercentage >0)
											<div class="cus_revenue grow"><i class="fa fa-arrow-up"></i> {{$changePercentage}}%</div>
											@elseif($changePercentage =='0')
											<div class="cus_revenue grow">{{$changePercentage}}%</div>
											@else
											<div class="cus_revenue grow loss"><i class="fa fa-arrow-down"></i>{{$changePercentage}}%</div>
											@endif
											<div class="cus_rev_title">Since last month</div>
										</div>
									</div>
									<div class="col-md-3 single_box">
										<div class="inside" style="height:290px;">
											<div class="title">Total Sales</div>
												<div class="cus_num">${{$totalSalePoint}}</div>
												
												<div class="cus_rev_title">Since last month</div> 
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>


					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6 right_area">
								<div class="inside">
									<div class="title">Annual Sale</div>

									<canvas id="bar-chart" width="800" height="450"></canvas>
								</div>
							</div>
							<div class="col-md-6 right_area">
								<div class="inside">
									<div class="title">Team Annual Sales Trend</div>

									<canvas id="bar-chart2" width="800" height="450"></canvas>
								</div>
							</div>
						</div>
					</div>
					<div class="col-md-12">
						<div class="row row-eq-height">
							<!-- top selling property data start -->
							
							<!-- top selling property data end -->
							
							<!--Total-sales-chart-->
							<div class="col-md-12 donutchart">
								<div class="chart_inside">
									<div class="title">Top Sales</div>
									<table id="property_data" class="display responsive nowrap" width="100%">
									    <thead>
									        <tr>
									            <th>Sr No</th>
									            <th>Date</th>
									            <th>Property</th>
									            <th>Amount</th>
									        </tr>
									    </thead>
									    <tbody>
								
										@forelse($topExecutiveSale as $index=>$row)
									        <tr>
									        	<td>{{$index+1}}</td>
									            <td>{{date('d-M-Y', strtotime($row->created_at))}}</td>
									            <td>{{$row->Address}}</td>
									            <td>${{$row->AssessedTotalValue}}</td>
									        </tr>
										@empty
											<h2>No Sale yet</h2>
										@endforelse
									    
									    </tbody>
									</table>
								</div>
							</div>
							<!-- Total-sales-chart-end -->
						</div>
					</div>

					<div class="col-md-12 top_space">
						<div class="row">
							<div class="col-md-5 left_prop">
								<div class="owl-carousel">
									@if(!empty($newArr))
									@foreach($newArr as $value)
									<div class="propbox">
										<div class="img">
									<?php  $imgsrc = $value["image"] ?>
									<img src="{{ asset($imgsrc) }}">
									</div>
										<div class="content">
										<div class="heads">
											<p>Trending Properties</p>
											<ul>
												<li>{{$value["property_id"]}}</li>
												<li>{{$value["total"]}}</li>
											</ul>
											</div>
											<div class="heart"><a class="fa fa-eye" href="{{route('affiliatepropertyDetail',$value['property_id'])}}"></a></div>
										</div>
									</div>									
									@endforeach	
									@else	
										<div class="content">
										<div class="heads">
										<p>Trending Properties</p>
										<ul>
												<li>No property found</li>
										</ul>
										</div>
										</div>
									@endif
									<!-- <div class="propbox">
										<div class="img"><img src="{{asset('assets/salemanager/images/pro1.png')}}"></div>
										<div class="content">
											<div class="heads">
											<p>Trending Properties 2</p>
											<ul>
												<li>4122 Properties</li>
												<li>1225 Favourites</li>
											</ul>
											</div>
											<div class="heart"><i class="fa fa-heart-o"></i></div>
										</div>
									</div> -->
									<!-- <div class="propbox">
										<div class="img"><img src="{{asset('assets/salemanager/images/pro1.png')}}"></div>
										<div class="content">
											<div class="heads">
											<p>Trending Properties 3</p>
											<ul>
												<li>4122 Properties</li>
												<li>1225 Favourites</li>
											</ul>
											</div>
											<div class="heart"><i class="fa fa-heart-o"></i></div>
										</div>
									</div> -->
								</div>
							</div>
							<div class="col-md-7 right_side">
								<div class="blue_box">
									<div class="row">
										<div class="col-md-6 m_team"><div class="title">Our Team -LA</div></div>
										<div class="col-md-6 r_tabs">
											<!-- tabbar-start -->
											<nav>
												<div class="nav nav-tabs nav-fill" id="nav-tab" role="tablist">
													<a class="nav-item nav-link active" id="nav-account-tab" data-toggle="tab" href="#nav-account" role="tab" aria-controls="nav-account" aria-selected="true">Long Beach</a>
													<a class="nav-item nav-link" id="nav-marketing-tab" data-toggle="tab" href="#nav-marketing" role="tab" aria-controls="nav-marketing" aria-selected="false">Glandale</a>
													<a class="nav-item nav-link" id="nav-development-tab" data-toggle="tab" href="#nav-development" role="tab" aria-controls="nav-development" aria-selected="false">Pasadena</a>
												</div>
											</nav>
											<!-- tabbar-end -->
										</div>
									</div>

									<div class="tab-content py-3 px-3 px-sm-0" id="nav-tabContent">
										<!-- first-tab -->
										<div class="tab-pane fade show active" id="nav-account" role="tabpanel" aria-labelledby="nav-account-tab">
											<div class="row">
												<div class="col-md-6 m_team">
													<div class="boxul">
														<ul>
														@foreach($employee as $row)
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t1.png')}}"></div>
																	<div class="textlink">
																		<h2>{{$row->f_name}} {{$row->l_name}}</h2>
																		<p>{{$row->phone}}</p>
																	</div>
																</div>
															</li>
														@endforeach	
															<!-- <li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t2.png')}}"></div>
																	<div class="textlink">
																		<h2>Sandra</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t3.png')}}"></div>
																	<div class="textlink">
																		<h2>John</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t4.png')}}"></div>
																	<div class="textlink">
																		<h2>Hannah</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t5.png')}}"></div>
																	<div class="textlink">
																		<h2>Justin</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t6.png')}}"></div>
																	<div class="textlink">
																		<h2>Savage</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li> -->
														</ul>
													</div>
												</div>
												<div class="col-md-6 r_tabs">
													@foreach($empLongBeach as $row)
													<div class="lightbox">
														<div class="accleft">
															<div class="circluimg"><img src="{{asset('assets/salemanager/images/t7.png')}}"></div>
															<div class="textlink">
																<h2>{{$row->f_name}} {{$row->l_name}}</h2>
																<p>Long Beach</p>
															</div>
														</div>
														<div class="accright">
															<a href="mailto:example@gmail.com"><i class="fa fa-envelope"></i></a>
															<a href="tel:+91-9898989898"><i class="fa fa-phone"></i></a>
														</div>
													</div>
													@endforeach
													<!-- <div class="lightbox">
														<div class="accleft">
															<div class="circluimg"><img src="{{asset('assets/salemanager/images/t7.png')}}"></div>
															<div class="textlink">
																<h2>Hannah</h2>
																<p>Account</p>
															</div>
														</div>
														<div class="accright">
															<a href="mailto:example@gmail.com"><i class="fa fa-envelope"></i></a>
															<a href="tel:+91-9898989898"><i class="fa fa-phone"></i></a>
														</div>
													</div> -->
												</div>
											</div>
										</div>
										<!-- first-tab-end -->

										<!-- second-tab -->
										<div class="tab-pane fade" id="nav-marketing" role="tabpanel" aria-labelledby="nav-marketing-tab">
											<div class="row">
												<div class="col-md-6 m_team">
													<div class="boxul">
														<ul>
														@foreach($employee as $row)
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t1.png')}}"></div>
																	<div class="textlink">
																		<h2>{{$row->f_name}} {{$row->l_name}}</h2>
																		<p>{{$row->phone}}</p>
																	</div>
																</div>
															</li>
														@endforeach	
															<!-- <li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t4.png')}}"></div>
																	<div class="textlink">
																		<h2>Hannah</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t1.png')}}"></div>
																	<div class="textlink">
																		<h2>Aaban</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t2.png')}}"></div>
																	<div class="textlink">
																		<h2>Sandra</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t5.png')}}"></div>
																	<div class="textlink">
																		<h2>Justin</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t6.png')}}"></div>
																	<div class="textlink">
																		<h2>Savage</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li> -->
														</ul>
													</div>
												</div>
												<div class="col-md-6 r_tabs">
												@foreach($empGlendale as $row)
													<div class="lightbox">
														<div class="accleft">
															<div class="circluimg"><img src="{{asset('assets/salemanager/images/t4.png')}}"></div>
															<div class="textlink">
																<h2>{{$row->f_name}} {{$row->l_name}}</h2>
																<p>Glendale</p>
															</div>
														</div>
														<div class="accright">
															<a href="mailto:example@gmail.com"><i class="fa fa-envelope"></i></a>
															<a href="tel:+91-9898989898"><i class="fa fa-phone"></i></a>
														</div>
													</div>
												@endforeach	
													<!-- <div class="lightbox">
														<div class="accleft">
															<div class="circluimg"><img src="{{asset('assets/salemanager/images/t3.png')}}"></div>
															<div class="textlink">
																<h2>Hannah</h2>
																<p>Marketing</p>
															</div>
														</div>
														<div class="accright">
															<a href="mailto:example@gmail.com"><i class="fa fa-envelope"></i></a>
															<a href="tel:+91-9898989898"><i class="fa fa-phone"></i></a>
														</div>
													</div> -->
												</div>
											</div>
										</div>
										<!-- second-tab -->

										<!-- third-tab -->
										<div class="tab-pane fade" id="nav-development" role="tabpanel" aria-labelledby="nav-development-tab">
											<div class="row">
												<div class="col-md-6 m_team">
													<div class="boxul">
														<ul>
														@foreach($employee as $row)
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t1.png')}}"></div>
																	<div class="textlink">
																		<h2>{{$row->f_name}} {{$row->l_name}}</h2>
																		<p>{{$row->phone}}</p>
																	</div>
																</div>
															</li>
														@endforeach	
															<!-- <li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t6.png')}}"></div>
																	<div class="textlink">
																		<h2>Savage</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t1.png')}}"></div>
																	<div class="textlink">
																		<h2>Aaban</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t2.png')}}"></div>
																	<div class="textlink">
																		<h2>Sandra</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t3.png')}}"></div>
																	<div class="textlink">
																		<h2>John</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li>
															<li>
																<div class="flexbox">
																	<div class="circluimg"><img src="{{asset('assets/salemanager/images/t4.png')}}"></div>
																	<div class="textlink">
																		<h2>Hannah</h2>
																		<p>935-768-2457</p>
																	</div>
																</div>
															</li> -->
														</ul>
													</div>
												</div>

												<div class="col-md-6 r_tabs">
													@foreach($empPasadena as $row)
													<div class="lightbox">
														<div class="accleft">
															<div class="circluimg"><img src="{{asset('assets/salemanager/images/t2.png')}}"></div>
															<div class="textlink">
																<h2>{{$row->f_name}} {{$row->l_name}}</h2>
																<p>Pasadena</p>
															</div>
														</div>
														<div class="accright">
															<a href="mailto:example@gmail.com"><i class="fa fa-envelope"></i></a>
															<a href="tel:+91-9898989898"><i class="fa fa-phone"></i></a>
														</div>
													</div>
													@endforeach
													<!-- <di  v   v class="lightbox">
														<div class="accleft">
															<div class="circluimg"><img src="{{asset('assets/salemanager/images/t1.png')}}"></div>
															<div class="textlink">
																<h2>Hannah</h2>
																<p>Development</p>
															</div>
														</div>
														<div class="accright">
															<a href="mailto:example@gmail.com"><i class="fa fa-envelope"></i></a>
															<a href="tel:+91-9898989898"><i class="fa fa-phone"></i></a>
														</div>
													</div> -->
												</div>
											</div>
										</div>
										<!-- third-tab -->

									</div>
								</div>
							</div>
						</div>
					</div>

					<div class="col-md-12 top_space">
						<div class="row">
							<div class="col-md-6 report_table">
								<div class="title">Recently Purchased Reports</div>
								<div class="inside" style="overflow-y:scroll; height:410px;">
									<ul>
                                    
									@forelse($recentlyPurchaseReport as $row)
										<li>
											<div class="reportflex">
												<div class="leftreport">
													<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i>{{$row->report_name}}</a>
												</div>
												<div class="rightreport">
													<!-- <a href="#" download="true"><i class="fa fa-eye"></i></a> -->
													<p>{{date('d-M-Y', strtotime($row->created_at))}}</p>
												</div>
											</div>
										</li>
									@empty	
										<h2><b>No report purchased yet</b></h2>
									@endforelse
									
										<!-- <li>
											<div class="reportflex">
												<div class="leftreport">
													<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
												</div>
												<div class="rightreport">
													<a href="#" download="true"><i class="fa fa-eye"></i></a>
												</div>
											</div>
										</li>
										<li>
											<div class="reportflex">
												<div class="leftreport">
													<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
												</div>
												<div class="rightreport">
													<a href="#" download="true"><i class="fa fa-eye"></i></a>
												</div>
											</div>
										</li>
										<li>
											<div class="reportflex">
												<div class="leftreport">
													<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
												</div>
												<div class="rightreport">
													<a href="#" download="true"><i class="fa fa-eye"></i></a>
												</div>
											</div>
										</li>
										<li>
											<div class="reportflex">
												<div class="leftreport">
													<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
												</div>
												<div class="rightreport">
													<a href="#" download="true"><i class="fa fa-eye"></i></a>
												</div>
											</div>
										</li>
										<li>
											<div class="reportflex">
												<div class="leftreport">
													<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
												</div>
												<div class="rightreport">
													<a href="#" download="true"><i class="fa fa-eye"></i></a>
												</div>
											</div>
										</li>
										<li>
											<div class="reportflex">
												<div class="leftreport">
													<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
												</div>
												<div class="rightreport">
													<a href="#" download="true"><i class="fa fa-eye"></i></a>
												</div>
											</div>
										</li> -->

									</ul>
									
								</div>
							</div>
							<div class="col-md-6 report_table_right">
								<div class="title">Sale By Top Location</div>
								<div class="inside">
								    <!-- <div class="mapcontainer_miller">
								        <div class="map">
								            <span>Alternative content for the map</span>
								        </div>
								    </div> -->
									<!-- <div id="chartdiv"></div> -->
									<div id="mymap"></div>


								    <!-- <div class="legend">
								    	<ul>
								    		<li><span class="circle green"></span> Asia</li>
								    		<li><span class="circle yelow"></span> india</li>
								    		<li><span class="circle orange"></span> South Africa</li>
								    		<li><span class="circle blue"></span> USA</li>
								    	</ul>
								    </div> -->
								</div>
							</div>
						</div>
					</div>
			</div>
			<!--inside_content_area-end-->
	</section>
	<!-- right area end -->
</div>
<!-- main div end -->

@endsection
@section('page_js')
<script type="text/javascript">
        $(function () {
            var test_plots = {
                "paris": {
                    latitude: 48.86,
                    longitude: 2.3444444444444,
                    tooltip: {
                        content: "Paris"
                    }
                },
                "tokyo": {
                    latitude: 35.689488,
                    longitude: 139.691706,
                    tooltip: {
                        content: "Tokyo"
                    }
                },
                "moscow": {
                    latitude: 55.755786,
                    longitude: 37.617633,
                    tooltip: {
                        content: "Moscow"
                    }
                },
                "los_angeles": {
                    latitude: 34.052234,
                    longitude: -118.243685,
                    tooltip: {
                        content: "Los Angeles"
                    }
                },
                "pasadena": {
                    latitude: 34.156113,
                    longitude: -118.131943,
                    tooltip: {
                        content: "Pasadena"
                    }
                },
                "aukland": {
                    latitude: -36.84846,
                    longitude: 174.763332,
                    tooltip: {
                        content: "Aukland"
                    }
                },
                "kiruna": {
                    latitude: 67.855737,
                    longitude: 20.225231,
                    tooltip: {
                        content: "Kiruna"
                    }
                },
                "reykjavik": {
                    latitude: 64.135338,
                    longitude: -21.89521,
                    tooltip: {
                        content: "Reykjavík"
                    }
                },
                "alert": {
                    latitude: 82.516305,
                    longitude: -62.308482,
                    tooltip: {
                        content: "Alert"
                    }
                },
                "wales": {
                    latitude: 65.609167,
                    longitude: -168.0875,
                    tooltip: {
                        content: "Wales"
                    }
                },
                "tiksi": {
                    latitude: 71.625094,
                    longitude: 128.872883,
                    tooltip: {
                        content: "Tiksi"
                    }
                },
                "pretoria": {
                    latitude: -25.746019,
                    longitude: 28.18712,
                    tooltip: {
                        content: "Pretoria"
                    }
                }
            };

            var getElemID = function(elem) {
                // Show element ID
                return $(elem.node).attr("data-id");
            };


            $(".mapcontainer_miller").mapael({
                map: {
                    name: "world_countries_miller",
                    defaultArea: {
                        tooltip: {
                            content: getElemID
                        }
                    },
                    defaultPlot: {
                        size: 9
                    }
                },

                plots: test_plots
            });
        });
    </script>
<!-- map-visitor-js -->
 <script>
	var randomScalingFactor = function() {
		return Math.ceil(Math.random() * 10.0) * Math.pow(10, Math.ceil(Math.random() * 5));
	};
	var config = {
		type: 'line',
		data: {
			labels: ['Mon', 'Tue', 'Wed', 'Thus', 'Fri', 'Sat', 'Sun', 'Mon'],
			datasets: [{
				label: 'My First dataset',
				backgroundColor: window.chartColors.red,
				borderColor: window.chartColors.red,
				fill: false,
				data: [
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor()
				],
			}, {
				label: 'My Second dataset',
				backgroundColor: window.chartColors.blue,
				borderColor: window.chartColors.blue,
				fill: false,
				data: [
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor(),
					randomScalingFactor()
				],
			}]
		},
		options: {
			responsive: true,
			title: {
				display: true,
				text: 'Chart.js Line Chart - Logarithmic'
			},
			scales: {
				xAxes: [{
					display: true,
				}],
				yAxes: [{
					display: true,
					type: 'logarithmic',
				}]
			}
		}
	};
	
	//DonutChart
	var randomScalingFactor = function() {
			return Math.round(Math.random() * 100);
		};
		var config2 = {
			type: 'doughnut',
			data: {
				datasets: [{
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
					],
					backgroundColor: [
						window.chartColors.red,
						window.chartColors.orange,
						window.chartColors.yellow,
						window.chartColors.green,
						window.chartColors.blue,
					],
					label: 'Dataset 1'
				}],
				labels: [
					'Red',
					'Orange',
					'Yellow',
					'Green',
					'Blue'
				]
			},
			options: {
				responsive: true,
				legend: {
					position: 'top',
				},
				title: {
					display: true,
					text: 'Chart.js Doughnut Chart'
				},
				animation: {
					animateScale: true,
					animateRotate: true
				}
			}
		};

	window.onload = function() {
		var ctx = document.getElementById('canvas').getContext('2d');
		window.myLine = new Chart(ctx, config);

		//DonutChart
		var ctx2 = document.getElementById('chart-area').getContext('2d');
		window.myDoughnut = new Chart(ctx2, config2);
	};
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script type="text/javascript">


var pointsGraphData = {!! $pointsGraphArr !!};

 
new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Jan","Feb","March", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [
        {
		
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#8e5ea2","#3cba9f"],
          data: pointsGraphData
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: ''
      }
    }
});

new Chart(document.getElementById("bar-chart2"), {
    type: 'bar',
    data: {
      labels: ["Jan","Feb","March", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#8e5ea2","#3cba9f"],
          data: pointsGraphData
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: ''
      }
    }
});
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset=utf-8></script>

<script type="text/javascript">


var locations = <?php print_r(json_encode($locations)) ?>;


var mymap = new GMaps({
  el: '#mymap',
  lat: 36.778259,
  lng: -119.417931,
  zoom:6
});


$.each( locations, function( index, value ){
	mymap.addMarker({
		lat: value.LATITUDE,
		lng: value.LONGITUDE,
	  title: value.CITY,
	  click: function(e) {
		alert('This is '+value.CITY+',  from US.');
	  }
	});
});


</script>

@endsection