@extends('AffiliateDashboard.master')
@section('content')
<!-- main div start -->
<div class="main_area">
    <!-- sidebar start -->
	@include('AffiliateDashboard.layouts.sidebar');	
	<!-- sidebar end -->
	<!-- right area start -->
	<section class="right_section">
        @include('AffiliateDashboard.layouts.header');
		<!-- inside_content_area start-->
		<div class="content_area">
            <div class="col-sm-12 customer_tabs">
				<ul class="nav nav-pills">
					<li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#highly_interested_properties">Highly Interested Properties</a></li>
					<li class="nav-item"><a class="nav-link " data-toggle="pill" href="#interested_properties">Interested Properties</a></li>
				</ul>
            </div>
            <div class="tab-content">
                <!-- Interested properties start-->
                <div class="col-sm-12 top_selling all_properties tab-pane fade " id="interested_properties">
                    <div class="inside">
                        <div class="title mb-4">
                            <p>interested properties</p>
                            <div class="list_and_grid">
                                <i class="fa fa-th active grid_view"></i>
                                <i class="fa fa-list-ul list_view"></i>
                            </div>


                            
                        </div>
                        <div class="row">
                            @foreach($interestedProperty as $row)
                                <div class="col-md-4 col-lg-3 property_box">
                                    <a href="{{route('propertyDetail',$row->property_id)}}" target="_blank">
                                        <div class="inset">
                                            <div class="image_and_bulb">
                                                <p><img src="{{asset('assets/superadmin/images/house1.jpg')}}"></p>
                                                <span><img src="{{asset('assets/superadmin/images/bulb.png')}}"></span>
                                            </div>  
                                            <div class="parent_data">
                                                <div class="data">{{$row->Bedrooms}} Bed {{$row->Bathrooms}} Bath 1,{{$row->SqFoot}} Sqft </div>
                                                <div class="data2">{{$row->Address}}</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach                    
                            <!-- <div class="col-sm-12 mt-4 mb-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item active">
                                            <span class="page-link">
                                                2
                                                <span class="sr-only">(current)</span>
                                            </span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div> -->
                        </div>                  
                    </div>
                </div>
                <!-- Interested properties end-->

                <!--Highly Interested properties start-->
                <div class="col-sm-12 top_selling all_properties tab-pane active" id="highly_interested_properties">
                    <div class="inside">
                        <div class="title mb-4">
                            <p>Highly interested properties</p>
                            <div class="list_and_grid">
                                <i class="fa fa-th active grid_view"></i>
                                <i class="fa fa-list-ul list_view"></i>
                            </div>
                        </div>
                        <div class="row">
                            @foreach($highlyInterestedProperty as $row)
                                <div class="col-md-4 col-lg-3 property_box">
                                    <a href="{{route('propertyDetail',$row->property_id)}}" target="_blank">
                                        <div class="inset">
                                            <div class="image_and_bulb">
                                                <p><img src="{{asset('assets/superadmin/images/house1.jpg')}}"></p>
                                                <span><img src="{{asset('assets/superadmin/images/fire.png')}}"></span>
                                            </div>
                                            <div class="parent_data">
                                                <div class="data">{{$row->Bedrooms}} Bed {{$row->Bathrooms}} Bath {{$row->SqFoot}} Sqft </div>
                                                <div class="data2">{{$row->Address}}</div>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            @endforeach
                            <!-- <div class="col-sm-12 mt-4 mb-3">
                                <nav aria-label="Page navigation example">
                                    <ul class="pagination justify-content-center">
                                        <li class="page-item disabled">
                                            <span class="page-link">Previous</span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">1</a></li>
                                        <li class="page-item active">
                                            <span class="page-link">
                                                2
                                                <span class="sr-only">(current)</span>
                                            </span>
                                        </li>
                                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                                        <li class="page-item">
                                            <a class="page-link" href="#">Next</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Highly Interested properties end-->
            </div>
        </div>  
    </div>
	</div>
	<!-- inside_content_area end-->
	</section>
	<!-- right area end -->
</div>
<!-- main div end -->
@endsection
@section('page_js')
<script>
    $('.all_properties .inside .title .list_and_grid i.grid_view').click(function(){
        $('.all_properties .inside .title .list_and_grid i.grid_view').addClass('active');
        $('.all_properties .inside .title .list_and_grid i.list_view').removeClass('active');
        $('.all_properties').removeClass('all_properties_list');
    });
    $('.all_properties .inside .title .list_and_grid i.list_view').click(function(){
        $('.all_properties .inside .title .list_and_grid i.list_view').addClass('active');
        $('.all_properties .inside .title .list_and_grid i.grid_view').removeClass('active');
        $('.all_properties').addClass('all_properties_list');
    });
</script>
@endsection
