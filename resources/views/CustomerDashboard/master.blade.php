<!DOCTYPE html>
<html lang="en-US">
<head>
	<title>Equity</title>
	<meta charset="UTF-8" />
	<meta name="keywords" content="HTML,CSS,XML,JavaScript" />
	<meta name="description" content="Free Web tutorials" />
	<meta name="author" content="Equity" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<link rel="stylesheet" href="{{asset('assets/customer/css/jquery.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/customer/css/responsive.dataTables.min.css')}}">
	<link rel="stylesheet" href="{{asset('assets/customer/css/buttons.dataTables.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/customer/css/jquery-ui.css')}}" />

	<link rel="stylesheet" href="{{asset('assets/customer/css/bootstrap.min.css')}}" />
	<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800i&display=swap" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
	<link rel="stylesheet" href="{{asset('assets/customer/css/style.css')}}" />
@yield('css_files')    
</head>
<body>
	@yield('content')


	<script src="{{asset('assets/customer/js/jquery.min.js')}}"></script>
	<!-- datatable start-->
	<script src="{{asset('assets/customer/js/jquery.dataTables.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/dataTables.responsive.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/dataTables.buttons.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/jszip.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/pdfmake.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/vfs_fonts.js')}}"></script>
	<script src="{{asset('assets/customer/js/buttons.html5.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/datatable.js')}}"></script>
	<!-- datatable end-->
	<script src="https://cdn.ckeditor.com/4.13.1/full-all/ckeditor.js"></script>
	<script src="{{asset('assets/customer/js/message.js')}}"></script>
	<script>
			CKEDITOR.replace( 'editor1' );
	</script>
	<script src="{{asset('assets/customer/js/jquery-ui.js')}}"></script>
	<script src="{{asset('assets/customer/js/popper.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/bootstrap.min.js')}}"></script>
	<script src="{{asset('assets/customer/js/custom.js')}}"></script>
	<script>
		$('.all_properties .inside .title .list_and_grid i.grid_view').click(function(){
			$(this).addClass('active');
			$('.all_properties .inside .title .list_and_grid i.list_view').removeClass('active');
			$('.all_properties').removeClass('all_properties_list');
		});
		$('.all_properties .inside .title .list_and_grid i.list_view').click(function(){
			$(this).addClass('active');
			$('.all_properties .inside .title .list_and_grid i.grid_view').removeClass('active');
			$('.all_properties').addClass('all_properties_list');
		});
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
	@yield('page_js')
</body>
</html>

