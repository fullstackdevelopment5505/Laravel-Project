@extends('SaleExecutiveDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('SaleExecutiveDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SaleExecutiveDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-md-12">
					<div class="row">
						<div class="col-md-12 left_area">
							<div class="row">
								<div class="col-md-3 single_box">
									<div class="inside">
										<div class="title">Customer Enrolled</div>
										<div class="cus_num">{{$customerEnrolled}}</div>
										<div class="cus_revenue grow"><i class="fa fa-arrow-up"></i> 5.25%</div>
										<div class="cus_rev_title">Since last month</div>
									</div>
								</div>
								<div class="col-md-3 single_box">
									<div class="inside">
										<div class="title">Customer joined</div>
										<div class="cus_num">{{$customerJoined}}</div>
										<div class="cus_revenue loss"><i class="fa fa-arrow-up"></i> 5.25%</div>
										<div class="cus_rev_title">Since last month</div>
									</div>
								</div>
								<div class="col-md-3 single_box">
									<div class="inside">
										<div class="title">Monthly Sales To Date</div>
										<div class="cus_num">$7,524</div>
										<div class="cus_revenue grow loss"><i class="fa fa-arrow-down"></i> 7.85%</div>
										<div class="cus_rev_title">Since last month</div>
									</div>
								</div>
								<div class="col-md-3 single_box">
									<div class="inside">
										<div class="title">Team Monthly Sales</div>
										<div class="cus_num">+35.52%</div>
										<div class="cus_revenue grow"><i class="fa fa-arrow-up"></i> +3.72%</div>
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
						<div class="col-md-6 top_selling">
							<div class="inside">
								<div class="title">Top Team A.E</div>
								<table id="property_data" class="display responsive nowrap" width="100%">
									<thead>
									    <tr>
									        <th>A.E</th>
									        <th>Name</th>
									        <th>Email</th>
									        <th>Phone</th>
									        <th>Last Login</th>
									    </tr>
									</thead>
									<tbody>
									    <tr>
									        <td>#000123</td>
									        <td>Robert</td>
									        <td>robert12@gmail.com</td>
									        <td>630-555-1212</td>
									        <td>01/01/2020</td>
									    </tr>
									    <tr>
									        <td>#000124</td>
									        <td>Dawn</td>
									        <td>dawn123@gmail.com</td>
									        <td>630-555-1010</td>
									        <td>02/01/2020</td>
									    </tr>
									    <tr>
									        <td>#000125</td>
									        <td>Charity</td>
									        <td>charity07@gmail.com</td>
									        <td>630-555-1414</td>
									        <td>03/01/2020</td>
									    </tr>
									    <tr>
									    	<td>#000126</td>
									        <td>Tiffany</td>
									        <td>tiffany123@gmail.com</td>
									        <td>630-555-1515</td>
									        <td>04/01/2020</td>
									    </tr>
									    <tr>
									        <td>#000127</td>
									        <td>Mike</td>
									        <td>mike2789@gmail.com</td>
									        <td>630-555-1616</td>
									        <td>01/01/2020</td>
									    </tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- top selling property data end -->
						<!--Total-sales-chart-->
						<div class="col-md-6 donutchart">
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
									    <tr>
									        <td>1</td>
									        <td>01/01/2020</td>
									        <td>245 Festival Dr, Oceanside, CA</td>
									        <td>$501,900</td>
									    </tr>
									    <tr>
									        <td>2</td>
									        <td>02/01/2020</td>
									        <td>245 Festival Dr, Oceanside, CA</td>
									        <td>$501,900</td>
									    </tr>
									    <tr>
									        <td>3</td>
									        <td>03/01/2020</td>
									        <td>245 Festival Dr, Oceanside, CA</td>
									        <td>$501,900</td>
									    </tr>
									    <tr>
									        <td>4</td>
									        <td>04/01/2020</td>
									        <td>245 Festival Dr, Oceanside, CA</td>
									        <td>$501,900</td>
									    </tr>
									    <tr>
									        <td>5</td>
									        <td>05/01/2020</td>
									        <td>245 Festival Dr, Oceanside, CA</td>
									        <td>$501,900</td>
									    </tr>
									</tbody>
								</table>
							</div>
						</div>
						<!-- Total-sales-chart-end -->
					</div>
				</div>
			</div>
			<div class="col-md-12 top_space">
				<div class="row">
					<div class="col-md-6 report_table">
						<div class="title">Recently Purchased Reports</div>
						<div class="inside">
							<ul>
								<li>
									<div class="reportflex">
										<div class="leftreport">
											<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
										</div>
										<div class="rightreport">
											<a href="JavaScript:void()" download="true"><i class="fa fa-download"></i></a>
										</div>
									</div>
								</li>
								<li>
									<div class="reportflex">
										<div class="leftreport">
											<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
										</div>
										<div class="rightreport">
											<a href="JavaScript:void()" download="true"><i class="fa fa-download"></i></a>
										</div>
									</div>
								</li>
								<li>
									<div class="reportflex">
										<div class="leftreport">
											<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
										</div>
										<div class="rightreport">
											<a href="JavaScript:void()" download="true"><i class="fa fa-download"></i></a>
										</div>
									</div>
								</li>
								<li>
									<div class="reportflex">
										<div class="leftreport">
											<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
										</div>
										<div class="rightreport">
											<a href="JavaScript:void()" download="true"><i class="fa fa-download"></i></a>
										</div>
									</div>
								</li>
								<li>
									<div class="reportflex">
										<div class="leftreport">
											<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
										</div>
										<div class="rightreport">
											<a href="JavaScript:void()" download="true"><i class="fa fa-download"></i></a>
										</div>
									</div>
								</li>
								<li>
									<div class="reportflex">
										<div class="leftreport">
											<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
										</div>
										<div class="rightreport">
											<a href="JavaScript:void()" download="true"><i class="fa fa-download"></i></a>
										</div>
									</div>
								</li>
								<li>
									<div class="reportflex">
										<div class="leftreport">
											<a href="javaScript:void()"><i class="fa fa-file-pdf-o"></i> Report 10/10/2019 - 15/10/2019</a>
										</div>
										<div class="rightreport">
											<a href="JavaScript:void()" download="true"><i class="fa fa-download"></i></a>
										</div>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="col-md-6 report_table_right">
						<div class="title">Sale By Top Location</div>
						<div class="inside">
							<div class="mapcontainer_miller">
								<div class="map">
								    <span>Alternative content for the map</span>
								</div>
							</div>
							<div class="legend">
								<ul>
								    <li><span class="circle green"></span> Asia</li>
								    <li><span class="circle yelow"></span> india</li>
								    <li><span class="circle orange"></span> South Africa</li>
								    <li><span class="circle blue"></span> USA</li>
								</ul>
							</div>
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
	<!-- map-visitor -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"charset="utf-8"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script>
	<script src="{{asset('assets/saleExecutive/js/jquery.mapael.js')}}" charset="utf-8"></script>
	<script src="{{asset('assets/saleExecutive/js/world_countries.js')}}" charset="utf-8"></script>
	<script src="{{asset('assets/saleExecutive/js/world_countries_mercator.js')}}" charset="utf-8"></script>
	<script src="{{asset('assets/saleExecutive/js/world_countries_miller.js')}}" charset="utf-8"></script>

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
					"punta_arenas": {
						latitude: -53.163833,
						longitude: -70.917068,
						tooltip: {
							content: "Punta Arenas"
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
$('.display').DataTable({
    responsive: true,
    dom: 'lBfrtip',
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdfHtml5',
        ]
});

</script>
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
new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Jan", "Feb", "March", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#8e5ea2","#3cba9f"],
          data: [5478,4267,3234,2200,2000,1500,1200,2500,3200,1000,1800,1300]
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
      labels: ["Jan", "Feb", "March", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#8e5ea2","#3cba9f"],
          data: [1500,1200,2500,5478,4267,3234,2200,2000,   3200,1000,1800,1300]
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

@endsection