   <!DOCTYPE html>
<html lang="en-US">
<head>
    <title>Equity</title>
    <meta charset="UTF-8" />
    <meta name="keywords" content="HTML,CSS,XML,JavaScript" />
    <meta name="description" content="Free Web tutorials" />
    <meta name="author" content="Equity" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="{{asset('assets/superadmin/css/jquery.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/superadmin/css/responsive.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/superadmin/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/superadmin/css/jquery-ui.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/superadmin/css/bootstrap.min.css')}}" />
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800i&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <link rel="stylesheet" href="{{asset('assets/superadmin/css/style.css')}}" />
  
    <link rel="stylesheet" type="text/css" href="{{asset('assets/superadmin/css/newhome.css')}}">
    @yield('css_files')
</head>
<body>
@yield('content')

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    
    <script src="{{asset('assets/superadmin/js/jquery.min.js')}}"></script>
	
	<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

	<!-- Updated stylesheet url -->
	<link rel="stylesheet" href="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.css">
	
	<script src="{{asset('assets/superadmin/js/us_phone_zip_mask.js')}}"></script>
    <!-- datatable start-->
	<script src="//cdnjs.cloudflare.com/ajax/libs/moment.js/2.11.2/moment.min.js"></script>
    <script src="{{asset('assets/superadmin/js/jquery.dataTables.min.js')}}"></script>
	  <script src="//cdn.datatables.net/plug-ins/1.10.12/sorting/datetime-moment.js"></script>
	  <script src="https://cdn.datatables.net/plug-ins/1.10.20/dataRender/datetime.js"></script>
	  
	
    <script src="{{asset('assets/superadmin/js/dataTables.responsive.min.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/dataTables.buttons.min.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/jszip.min.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/pdfmake.min.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/vfs_fonts.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/buttons.html5.min.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/datatable.js')}}"></script>
    <!-- datatable end-->
    <script src="{{asset('assets/superadmin/js/jquery-ui.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/popper.min.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/bootstrap.min.js')}}"></script>
    <!-- chart js start-->
    <script src="{{asset('assets/superadmin/js/chart.min.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/utils.js')}}"></script>
    <!-- end chart js -->
    <script src="{{asset('assets/superadmin/js/custom.js')}}"></script>
    <script src="{{asset('assets/superadmin/js/ckeditor/ckeditor.js')}}"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
	<script type="text/javascript" src="https://rawgit.com/RobinHerbots/jquery.inputmask/3.x/dist/jquery.inputmask.bundle.js"></script>
	<script type="text/javascript" src="{{asset('assets/superadmin/js/jquery.maskMoney.min.js')}}"></script>
	<script src="https://cdn.jsdelivr.net/npm/htmlson.js@1.0.4/src/htmlson.js"></script>
	<script type="text/javascript" src="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/js/dataTables.checkboxes.min.js"></script>
	 
	<style type="text/css">
    #loader {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        width: 100%;
        background: rgba(0,0,0,0.75) url({{asset("images/loading2.gif")}}) no-repeat center center;
        z-index: 10000;
    }
</style>
    <script>
        CKEDITOR.replace( 'editor1' );
    </script>
	<script>
		$('.select_all_mail label input').click(function(){
			if($(this).prop("checked") == true){
				$('.communications ul li label input').prop("checked", true);
			}
			else if($(this).prop("checked") == false){
				$('.communications ul li label input').prop("checked", false);
			}
		});

		$('.communications ul li label input').click(function(){
			if($(this).prop("checked") == true){
			}
			else if($(this).prop("checked") == false){
				$('.select_all_mail label input').prop("checked", false);
			}
		});
	</script>
    <!-- apexchart -->
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script type="text/javascript">
   


    var options2 = {
            series: [{
                name: 'Net Profit',
                data: [45, 52, 38, 24, 33, 26, 21, 20, 6, 8, 15, 10]
            },
            {
                name: 'Revenue',
                data: [35, 41, 62, 42, 13, 18, 29, 37, 36, 51, 32, 35]
            },
            {
                name: 'Free Cash Flow',
                data: [87, 57, 74, 99, 75, 38, 62, 47, 82, 56, 45, 47]
            }
            ],
            chart: {
            height: 250,
            type: 'line',
            zoom: {
                enabled: false
            },
            },
            dataLabels: {
            enabled: false
            },
            stroke: {
            width: [5, 7, 5],
            curve: 'straight',
            dashArray: [0, 8, 5]
            },
            
            legend: {
            tooltipHoverFormatter: function(val, opts) {
                return val + ' - ' + opts.w.globals.series[opts.seriesIndex][opts.dataPointIndex] + ''
            }
            },
            markers: {
            size: 0,
            hover: {
                sizeOffset: 6
            }
            },
            xaxis: {
            categories: ['01 Jan', '02 Jan', '03 Jan', '04 Jan', '05 Jan', '06 Jan', '07 Jan', '08 Jan', '09 Jan',
                '10 Jan', '11 Jan', '12 Jan'
            ],
            },
            tooltip: {
            y: {
                formatter: function (val) {
                return "$ " + val + " thousands"
                }
            }
            },
            grid: {
            borderColor: '#f1f1f1',
            }
            };

    var options3 = {
            series: [{
            name: 'Inflation',
            data: [2.3, 3.1, 4.0, 10.1, 4.0, 3.6, 3.2, 2.3, 1.4, 0.8, 0.5, 0.2]
            }],
            chart: {
            height: 250,
            type: 'bar',
            },
            plotOptions: {
            bar: {
                dataLabels: {
                position: 'top', // top, center, bottom
                },
            }
            },
            dataLabels: {
            enabled: true,
            formatter: function (val) {
                return val + "%";
            },
            offsetY: -20,
            style: {
                fontSize: '12px',
                colors: ["#304758"]
            }
            },
            
            xaxis: {
            categories: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
            position: 'top',
            labels: {
                offsetY: -18,
            
            },
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false
            },
            crosshairs: {
                fill: {
                type: 'gradient',
                gradient: {
                    colorFrom: '#D8E3F0',
                    colorTo: '#BED1E6',
                    stops: [0, 100],
                    opacityFrom: 0.4,
                    opacityTo: 0.5,
                }
                }
            },
            tooltip: {
                enabled: true,
                offsetY: -35,
            
            }
            },
            fill: {
            gradient: {
                shade: 'light',
                type: "horizontal",
                shadeIntensity: 0.25,
                gradientToColors: undefined,
                inverseColors: true,
                opacityFrom: 1,
                opacityTo: 1,
                stops: [50, 0, 100, 100]
            },
            },
            yaxis: {
            axisBorder: {
                show: false
            },
            axisTicks: {
                show: false,
            },
            labels: {
                show: false,
                formatter: function (val) {
                return val + "%";
                }
            }
            
            },
            
            };

    var options4 = {
            series: [{
            name: 'Membership',
            data: [44, 55, 41, 37, 22, 43, 21]
            }, {
            name: 'Forclosure',
            data: [53, 32, 33, 52, 13, 43, 32]
            }, {
            name: 'Business Owner',
            data: [12, 17, 11, 9, 15, 11, 20]
            }, {
            name: 'Open Lien',
            data: [9, 7, 5, 8, 6, 9, 4]
            }, {
            name: 'Sale Information',
            data: [25, 12, 19, 32, 25, 24, 10]
            }],
            chart: {
            type: 'bar',
            height: 350,
            stacked: true,
            },
            plotOptions: {
            bar: {
                horizontal: true,
            },
            },
            stroke: {
            width: 1,
            colors: ['#fff']
            },
            
            xaxis: {
            categories: [2008, 2009, 2010, 2011, 2012, 2013, 2014],
            labels: {
                formatter: function (val) {
                return val + "K"
                }
            }
            },
            yaxis: {
            title: {
                text: undefined
            },
            },
            tooltip: {
            y: {
                formatter: function (val) {
                return val + "K"
                }
            }
            },
            fill: {
            opacity: 1
            },
            legend: {
            position: 'top',
            horizontalAlign: 'left',
            offsetX: 20
            }
            };


    var options5 = {
            series: [{
            name: 'Series-1',
            data: [22, 43, 21, 44, 55, 41, 37]
            }],
            chart: {
            type: 'area',
            height: 250,
            sparkline: {
                enabled: true
            },
            },
            stroke: {
            curve: 'straight'
            },
            fill: {
            opacity: 0.3
            },
            xaxis: {
            crosshairs: {
                width: 1
            },
            },
            yaxis: {
            min: 0
            },
            title: {
            text: '+76',
            offsetX: 0,
            style: {
                fontSize: '24px',
            }
            },
            subtitle: {
            text: 'Revenue Increased this Quarter',
            offsetX: 0,
            style: {
                fontSize: '14px',
            }
            }
            };

        

        var chart = new ApexCharts(document.querySelector("#chart2"), options2);
        chart.render();

        var chart = new ApexCharts(document.querySelector("#chart3"), options3);
        chart.render();

        var chart = new ApexCharts(document.querySelector("#chart4"), options4);
        chart.render();

        var chart = new ApexCharts(document.querySelector("#chart5"), options5);
        chart.render();
    </script>
    <!-- apexchart-end -->
    <script>
        new Chart(document.getElementById("bar-chart"), {
        type: 'bar',
        data: {
        labels: ["Jan", "Feb", "March", "April", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
        datasets: [
            {
            label: "Profit",
            backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850","#8e5ea2","#3cba9f"],
            data: [5478,6267,6254,2200,5465,3534,1596,5456,6465,2186,5226,1300]
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
    <script>
		$('.customer_search .inside .title input').click(function(){
			$(this).prop("checked", true);
			$(this).parents('.customer_search').addClass('active_now');

			$(this).parents('.customer_search').nextAll('.customer_search').find('.inside .title input').prop("checked", false);
			$(this).parents('.customer_search').prevAll('.customer_search').find('.inside .title input').prop("checked", false);

			$(this).parents('.customer_search').nextAll('.customer_search').removeClass('active_now').addClass('disable_now');
			$(this).parents('.customer_search').prevAll('.customer_search').removeClass('active_now').addClass('disable_now');
		});
	</script>
	<script src="{{url('assets/superadmin/js/jquery.session.js')}}"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
	<script src="https://ajax.microsoft.com/ajax/jquery.validate/1.11.1/additional-methods.js"></script>
	
    <!-- Sweet Alert -->
    <link href="{{ url('assets/css/sweetalert.css') }}" rel="stylesheet">

    <!-- Sweet Alert -->
    <script src="{{ url('assets/js/sweetalert.min.js') }}"></script>
    @yield('page_js')
<div id="loader"></div>

</body>
</html>