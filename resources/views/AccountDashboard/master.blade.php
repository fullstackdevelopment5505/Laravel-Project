<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Equity</title>
	<meta charset="UTF-8" />
	<meta name="keywords" content="HTML,CSS,XML,JavaScript" />
	<meta name="description" content="Free Web tutorials" />
	<meta name="author" content="Equity" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="{{asset('assets/account/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/account/css/responsive.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/account/css/buttons.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/account/css/bootstrap.min.css')}}" />
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800i&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('assets/account/css/style.css')}}"/>
	<link rel="stylesheet" href="{{asset('assets/superadmin/css/jquery-ui.css')}}" />
	<link rel="stylesheet" href="{{asset('assets/account/css/site-demos.css')}}" />

	<!-- datatable start-->
    @yield('css_files')
</head>
<body>

	@yield('content')
	<script src="{{asset('assets/account/js/jquery.min.js')}}"></script>
	<script src="{{asset('assets/account/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/account/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/account/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('assets/account/js/vfs_fonts.js')}}"></script>
	<script src="{{asset('assets/account/js/buttons.html5.min.js')}}"></script>
	
	<script src="{{asset('assets/account/js/jszip.min.js')}}"></script>
	<script src="{{asset('assets/account/js/pdfmake.min.js')}}"></script>
	<script src="{{asset('assets/account/js/datatable.js')}}"></script>

	<!-- datatable end-->
	<script src="{{asset('assets/account/js/jquery-ui.js')}}"></script>
	<script src="{{asset('assets/account/js/popper.min.js')}}"></script>
	<!-- datatable end-->
	<script src="{{asset('assets/account/js/popper.min.js')}}"></script>
	<script src="{{asset('assets/account/js/bootstrap.min.js')}}"></script>
	<!-- chart js start-->
	<script src="{{asset('assets/account/js/chart.min.js')}}"></script>
	<script src="{{asset('assets/account/js/utils.js')}}"></script>


	<!-- end chart js -->
	<script src="{{asset('assets/account/js/custom.js')}}"></script>
		<script src="{{asset('assets/account/js/validate.min.js')}}"></script>
	<script src="{{asset('assets/account/js/additional-methods.min.js')}}"></script>
	<script src="{{asset('assets/account/js/moment.min.js')}}"></script>

       <script>
	var i=1;
	var ind=0;	
	$(".add_new_item").click(()=>{
		var index = ++ind
		var appHtm='<tr><td>'+(++i)+'</td><td><input type="text" class="form-control" id="item_name" name="item_name['+index+']"></td><td><input type="text" class="form-control" id="item_description" name="item_description['+index+']"></td><td><input type="text" class="form-control changeQty" id="unit_cost" name="unit_cost['+index+']"></td><td><input type="text" class="form-control changeQty" id="quantity" data-index='+index+' name="quantity['+index+']"></td><td><input type="text" class="form-control" id="amount" name="amount['+index+']" readonly></td></tr>';
		$("#new_invoice").append(appHtm);
	});
	</script>
    @yield('page_js')

</body>
</html>