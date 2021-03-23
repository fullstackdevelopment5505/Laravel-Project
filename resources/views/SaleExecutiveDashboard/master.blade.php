<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Equity</title>
	<meta charset="UTF-8" />
	<meta name="keywords" content="HTML,CSS,XML,JavaScript" />
	<meta name="description" content="Free Web tutorials" />
	<meta name="author" content="Equity" />
	<meta name="csrf-token" content="{{ csrf_token() }}">

	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="{{asset('assets/saleExecutive/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/saleExecutive/css/responsive.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/saleExecutive/css/buttons.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/saleExecutive/css/bootstrap.min.css')}}" />
	<link rel="stylesheet" type="text/css" href="{{asset('assets/saleExecutive/css/dropzone.css')}}">
	<link rel="stylesheet" href="{{asset('assets/saleExecutive/css/jquery-ui.css')}}" />

	<link rel="stylesheet" type="text/css" href="{{asset('assets/saleExecutive/css/owl.carousel.min.css')}}" />
	<link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700,900&display=swap" rel="stylesheet">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('assets/saleExecutive/css/style.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/saleExecutive/css/pages.css')}}" />
    <link rel="stylesheet" href="{{asset('assets/saleExecutive/css/message.css')}}" />
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
		.top_selling .inside {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            background: #fff;
            padding: 20px;
            border-radius: 5px;
            margin-bottom: 0px !important;
            height: 100%;
        }
		.right_area .inside .title, .top_selling .inside .title, .single_box .inside .title {
		font-size: 20px;
		color: #6b6b6b;
		margin-bottom: 13px;
		text-transform: capitalize;
	}
	.right_area .inside .title, .top_selling .inside .title {
		font-weight: 600;
	}
	.col-sm-12.top_selling {
		margin-top: 30px;
	}
	.error{
		color:red;
	}
	</style>
	@yield('css_files')

</head>
<body>

	@yield('content')
	<script src="{{asset('assets/saleExecutive/js/jquery.min.js')}}"></script>
	<script type="text/javascript" src="{{asset('assets/saleExecutive/js/dropzone.js')}}"></script>

	<!-- datatable start-->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> -->
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

	<script src="{{asset('assets/saleExecutive/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/jszip.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/pdfmake.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/vfs_fonts.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/buttons.html5.min.js')}}"></script>

	<!-- datatable end-->
	<script src="{{asset('assets/saleExecutive/js/popper.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/bootstrap.min.js')}}"></script>
	<!-- chart js start-->
	<script src="{{asset('assets/saleExecutive/js/chart.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/utils.js')}}"></script>
	<script src="http://cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
	<script>
        CKEDITOR.replace( 'text' );
    </script>
	
	<!-- end chart js -->
	<!-- <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6.2/jquery.min.js"></script> -->
	<script src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.js"></script>
	<script src="http://ajax.microsoft.com/ajax/jquery.validate/1.11.1/additional-methods.js"></script>
	<script src="{{asset('assets/saleExecutive/js/addcustomer.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/addContact.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/addTeam.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/sendMessage.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/owl.carousel.min.js')}}"></script>
	<script src="{{asset('assets/saleExecutive/js/custom.js')}}"></script>
	@yield('page_js')
</body>
</html>