<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Equity</title>
	<meta charset="UTF-8" />
	<meta name="keywords" content="HTML,CSS,XML,JavaScript" />
	<meta name="description" content="Free Web tutorials" />
	<meta name="author" content="Equity" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="{{asset('assets/salemanager/css/bootstrap.min.css')}}"/>
	<link rel="stylesheet" href="{{asset('assets/superadmin/css/jquery-ui.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/salemanager/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/salemanager/css/responsive.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/salemanager/css/buttons.dataTables.min.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/salemanager/css/dropzone.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/salemanager/css/owl.carousel.min.css')}}" />
	<!-- <link rel="stylesheet" type="text/css" href="{{asset('assets/property/css/propdetail.css')}}"> -->
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('assets/salemanager/css/style.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/salemanager/css/pages.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/bootstrap.min.css')}}" /> 
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/owl.carousel.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('assets/css/custome.css')}}">
	<link rel="stylesheet" type="text/css" href="{{asset('assets/salemanager/css/property3.css')}}">

	<script src="http://maps.google.com/maps/api/js"></script>
  	<script src="https://cdnjs.cloudflare.com/ajax/libs/gmaps.js/0.4.24/gmaps.js"></script>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700&display=swap" rel="stylesheet">
	<style type="text/css">
    	#mymap {
      		border:1px solid red;
      		width: 570px;
      		height: 500px;
    	}
  	</style>

	<style type="text/css">
		.mapael .map {position: relative;}
		.mapael .mapTooltip {
			position: absolute;
			background-color: #fff;
			moz-opacity: 0.70;
			opacity: 0.70;
			filter: alpha(opacity=70);
			border-radius: 10px;
			padding: 10px;
			z-index: 1000;
			max-width: 200px;
			display: none;
			color: #343434;
		}
		.mapcontainer_miller {margin-top:10px;}
	</style>
	@yield('css_files')
</head>
<body>
	@yield('content')

	<script src="{{asset('assets/salemanager/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/salemanager/js/dropzone.js')}}"></script>

	<!-- datatable start-->
	<script src="{{asset('assets/salemanager/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/jszip.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/pdfmake.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/vfs_fonts.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/buttons.html5.min.js')}}"></script>

	<!-- datatable end-->
	    <script src="{{asset('assets/superadmin/js/jquery-ui.js')}}"></script>

	<script src="{{asset('assets/salemanager/js/popper.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/bootstrap.min.js')}}"></script>
	<!-- chart js start-->
	<script src="{{asset('assets/salemanager/js/chart.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/utils.js')}}"></script>
	<!-- end chart js -->
	<!--validation js-->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> -->

	<!-- <script src="{{asset('assets/salemanager/js/addTeam.js')}}"></script> -->
	<!--validation js end-->
	<!-- map-visitor -->
	 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-mousewheel/3.1.13/jquery.mousewheel.min.js"charset="utf-8"></script> -->
	 <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/raphael/2.2.7/raphael.min.js" charset="utf-8"></script> -->
	 <!-- <script src="{{asset('assets/salemanager/js/jquery.mapael.js')}}" charset="utf-8"></script> -->
	<!-- <script src="{{asset('assets/salemanager/js/world_countries.js')}}" charset="utf-8"></script> -->
	<!-- <script src="{{asset('assets/salemanager/js/world_countries_mercator.js')}}" charset="utf-8"></script> -->
	<!-- <script src="{{asset('assets/salemanager/js/world_countries_miller.js')}}" charset="utf-8"></script> -->
	<!-- <script src="{{asset('assets/salemanager/js/jquery-ui.js')}}"></script> 
	<script src="{{asset('assets/salemanager/js/addCustomer.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/addTeam.js')}}"></script>
	<script src="https://www.amcharts.com/lib/4/core.js"></script>  -->
	<script src="https://www.amcharts.com/lib/4/core.js"></script>
<script src="https://www.amcharts.com/lib/4/maps.js"></script>
<script src="https://www.amcharts.com/lib/4/geodata/worldLow.js"></script>
<script src="https://www.amcharts.com/lib/4/themes/animated.js"></script>
<script src="{{asset('assets/salemanager/js/map.js')}}"></script>

	<!-- map-visitor-js -->
	<script src="{{asset('assets/salemanager/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('assets/salemanager/js/custom.js')}}"></script>
	<script src="{{asset('assets/js/custom.js')}}"></script>
	<script src="{{url('assets/superadmin/js/jquery.session.js')}}"></script>
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
	<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.11.1/additional-methods.js"></script>
	<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
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
@yield('page_js')
</body>
</html>