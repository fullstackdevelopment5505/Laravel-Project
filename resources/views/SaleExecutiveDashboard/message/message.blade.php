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
                <!-- datepicker -->
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-8 from_to_filter">
							<form>
                                <div class="select_all_mail"><label><input type="checkbox"><span></span>All</label></div>
								<div class="form-group">
									<input type="text" class="form-control" placeholder="Search">
								</div>
                                <button type="button" class="btn btn-success">Search</button>
                                <div class="delete_all_mail"><i class="fa fa-trash"></i></div>
                            </form>
						</div>
						<div class="col-sm-4 top_btns">
							<a href="{{route('saleExecutiveSendMessage')}}" class="btn btn-primary">Send Message <i class="fa fa-plus"></i></a>
						</div>
					</div>
				</div>
				<!-- datepicker -->

				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!--  customer detail start-->
                        <div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="communications">
                                    @foreach($message as $row)
                                        <ul>
                                            <li>
                                                <a href="{{route('saleExecutiveViewMessage')}}">
                                                    <label><input type="checkbox"><span></span></label>
                                                    <div class="pic"><img src="{{asset('assets/saleExecutive/images/user.jpg')}}"></div>
                                                    <div class="data">
                                                        <h2>Velit A Labore</h2>
                                                        <p>{{$row->text}}</p>
                                                    </div>
                                                    <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                                </a>
                                            </li> 
                                        </ul>
                                    @endforeach
                                </div>
							</div>
						</div>
                        <!--  customer detail end-->
					</div>
				</div>
				<!-- main row end-->
			</div>
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
    <!-- add-customer-popup -->
@endsection	
@section('page_js')
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
   @endsection