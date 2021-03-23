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
            @if(Session::has('success'))
        		<div class="alert alert-success">
            		{{Session::get('success')}}
        		</div>
    		@endif
			@if(Session::has('error'))
				<div class="alert alert-danger">
					{{Session::get('error')}}
				</div>
			@endif
                <!-- datepicker -->
                <div class="col-sm-12 top_bar_area">
                    <div class="row">
                        <div class="col-sm-12 from_to_filter">
                            <form>
                                <div class="view_back"><a href="{{route('saleExecutiveMessage')}}"><i class="fa fa-arrow-left"></i></a></div>
                                <div class="form-group">
                                    <input type="text" class="form-control" placeholder="Search">
                                </div>
                                <div class="delete_all_mail"><i class="fa fa-trash"></i></div>
                            </form>
                        </div>
                    </div>
                </div>
                <!-- datepicker -->
                <!-- main row start-->
                <div class="col-sm-12">
                    <div class="row">
                 
                        <!-- main row start-->
                        <div class="col-sm-12">
                            <div class="row">
                                <!--  customer detail start-->
                                <div class="col-sm-12 top_selling">
                                    <form method="post" action="{{route('sale_executive.replyMessage')}}">
                                    {{@csrf_field()}}
                                    <div class="inside">
                                        <div class="full_message_detail">
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>To</label>
                                                        <input type="text" name="member" class="form-control">
                                                    </div>
                                                </div>
                                                <input type="hidden" name="type" value="replied">
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Subject</label>
                                                        <input type="text" name="subject" class="form-control">
                                                    </div>
                                                </div>
                                                <div class="col-sm-12">
                                                    <div class="form-group">
                                                        <label>Content</label>
                                                        <textarea  name="text"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="reply_cta mt-4"><input type="submit" class="btn btn-primary btn-lg" value="Send Message"></div>
                                    </div>
                                    </form>
                                </div>
                                <!--  customer detail end-->
                            </div>
                        </div>
                        <!-- main row end-->
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