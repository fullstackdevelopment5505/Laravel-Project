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
						<!-- datepicker -->
						<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-8 from_to_filter">
									<form method="post" action="">
										<div class="form-group">
										    <label>From:</label>
										    <input type="text" class="form-control datepicker" name="date_from" placeholder="Date">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" class="form-control datepicker" name="date_to"  placeholder="Date">
										</div>
										<button type="button" id="search_submit" class="btn btn-success">Search</button>
									</form>
								</div>
							</div>
						</div>

						<!-- Sale Report Table start -->
						<div class="col-sm-12 top_selling">
									<div class="inside">
										<div class="title">TOTAL SALE REPORT</div>
										<table class="display responsive nowrap" width="100%" id="TotalSaleList">
										<thead>
										    <tr>
											<th>Date & Time</th>											
										    <th>Sale Type</th>
										    <th>GL Code</th>											
											<th>Total Amount</th>
										    <th>Tax</th>
										    <th>Tax Code</th>
										    <th>Cash</th>
										    <th>Ledger Balance</th>

										    </tr>
										    </thead>
										
										</table>
									</div>
								</div>
						<!-- Sale table end -->
						<!-- datepicker -->
						
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


	<script type="text/javascript">	


	$(function() {
			
		$('#TotalSaleList').DataTable({
			"processing": true,
			"serverSide": true,
			//"ordering": false,  
			"ajax": {
				url: "{{route('SuperadmintotalSaleReport')}}",
				data: function (d) {
					d.date_from = $('input[name="date_from"]').val();
				
					d.date_to =$('input[name="date_to"]').val();
					
				}
			},
			"columns":[
				// {"data": 'DT_RowIndex'},
				{title: "date",data: "date",
                   render: function(d) {
                   return moment(d).format("DD-MMM-YYYY");}},
				{"data":"type",name:"type"},
				{"data":"glCode",name:"glCode"},
				{"data":"amount",name:"amount"},
				{"data":"tax",name:"tax"},
				{"data":"taxCode",name:"taxCode"},
				{"data":"cash",name:"cash"},
				{"data":"ledger",name:"ledger"}
			],
			 "order": [[ 0, 'desc' ]] ,  

			dom: 'lBfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf',
			],
		
			"bDestroy": true
		});

		$('#search_submit').click(function(){	
		
			$('#TotalSaleList').DataTable().draw(true);
		});  
			
	});
	</script>


<script>
	// commission chart
	new Chart(document.getElementById("commission-chart"), {
	type: 'bar',
	data: {
	labels: ["John", "Ashley", "Ethan", "Leon Kennedy", "Chris Redfill"],
	datasets: [
		{
		label: "Commissions Bar Graph",
		backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
		data: [2478,5267,734,784,433]
		}
	]
	}
});

// top ten commission chart
new Chart(document.getElementById("top-ten-chart"), {
type: 'line',
data: {
	labels: ["John", "Ashley", "Ethan", "Leon Kennedy", "Chris Redfill"],
	datasets: [{ 
		data: [66,1656,154465,106,107,111,133,221,783,2478],
		label: "John",
		borderColor: "#3e95cd",
		fill: false
	}, { 
		data: [282,350,411,55442,635,809,947,1402,3700,5267],
		label: "Ashley",
		borderColor: "#8e5ea2",
		fill: false
	}, { 
		data: [168,170,178,190,2054,276,4658,547,675,734],
		label: "Ethan",
		borderColor: "#3cba9f",
		fill: false
	}, { 
		data: [40,20,100,16,24,3548,74,1647,508,784],
		label: "Leon",
		borderColor: "#e8c3b9",
		fill: false
	}, { 
		data: [6,3,2,2,7,26,82,172,312,433],
		label: "Chris",
		borderColor: "#c45850",
		fill: false
	}
	]
}
});

// Lowest Earning Customers
new Chart(document.getElementById("lowest-earning"), {
type: 'line',
data: {
	labels: ["John", "Ashley", "Ethan", "Leon Kennedy", "Chris Redfill"],
	datasets: [{ 
		data: [86,114,106,106,107,111,133,221,783,2478],
		label: "John",
		borderColor: "#3e95cd",
		fill: false
	}, { 
		data: [282,350,411,502,635,809,947,1402,3700,5267],
		label: "Ashley",
		borderColor: "#8e5ea2",
		fill: false
	}, { 
		data: [168,170,178,190,203,276,408,547,675,734],
		label: "Ethan",
		borderColor: "#3cba9f",
		fill: false
	}, { 
		data: [40,20,10,16,24,38,74,167,508,784],
		label: "Leon",
		borderColor: "#e8c3b9",
		fill: false
	}, { 
		data: [6,3,2,2,7,26,82,172,312,433],
		label: "Chris",
		borderColor: "#c45850",
		fill: false
	}
	]
}
});

// Monthly Earning by customer
new Chart(document.getElementById("monthly-earning"), {
	type: 'bar',
	data: {
	labels: ["1900", "1950", "1999", "2050"],
	datasets: [{
		label: "Europe",
		type: "line",
		borderColor: "#8e5ea2",
		data: [408,547,675,734],
		fill: false
		}, {
		label: "Africa",
		type: "line",
		borderColor: "#3e95cd",
		data: [133,221,783,2478],
		fill: false
		}, {
		label: "Europe",
		type: "bar",
		backgroundColor: "rgba(0,0,0,0.2)",
		data: [408,547,675,734],
		}, {
		label: "Africa",
		type: "bar",
		backgroundColor: "rgba(0,0,0,0.2)",
		backgroundColorHover: "#3e95cd",
		data: [133,221,783,2478]
		}
	]
	},
	options: {
	title: {
		display: true,
		text: 'Population growth (millions): Europe & Africa'
	},
	legend: { display: false }
	}
});
</script>
<script>
	var ctx = document.getElementById("canvas");
	ctx.height = 100;
	var config = {
			type: 'line',
			data: {
				labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July'],
				datasets: [{
					label: 'dataset - big points',
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					backgroundColor: window.chartColors.red,
					borderColor: window.chartColors.red,
					fill: false,
					borderDash: [5, 5],
					pointRadius: 15,
					pointHoverRadius: 10,
				}, {
					label: 'dataset - individual point sizes',
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					backgroundColor: window.chartColors.blue,
					borderColor: window.chartColors.blue,
					fill: false,
					borderDash: [5, 5],
					pointRadius: [2, 4, 6, 18, 0, 12, 20],
				}, {
					label: 'dataset - large pointHoverRadius',
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					backgroundColor: window.chartColors.green,
					borderColor: window.chartColors.green,
					fill: false,
					pointHoverRadius: 30,
				}, {
					label: 'dataset - large pointHitRadius',
					data: [
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor(),
						randomScalingFactor()
					],
					backgroundColor: window.chartColors.yellow,
					borderColor: window.chartColors.yellow,
					fill: false,
					pointHitRadius: 20,
				}]
			},
			options: {
				responsive: true,
				legend: {
					position: 'bottom',
				},
				hover: {
					mode: 'index'
				},
				scales: {
					xAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Month'
						}
					}],
					yAxes: [{
						display: true,
						scaleLabel: {
							display: true,
							labelString: 'Value',
						}
					}]
				}
			}
		};


</script>




	@endsection
