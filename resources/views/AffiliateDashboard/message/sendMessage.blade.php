@extends('AffiliateDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('AffiliateDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
            @include('AffiliateDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
                <!-- datepicker -->
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 from_to_filter">
							<form>
                                <div class="view_back"><a href="{{route('sale_manager.message')}}"><i class="fa fa-arrow-left"></i></a></div>
                                <div class="title">Send Message</div>
                            </form>
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
                                <div class="full_message_detail">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Choose member</label>
                                                <input type="text" class="form-control" value="johnsterehl@gmail.com" disabled="disabled">
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label>Subject</label>
                                                <input type="text" class="form-control">
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label>Message</label>
                                                <textarea name="editor1"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="reply_cta mt-4"><button class="btn btn-primary btn-lg">Send Message</button></div>
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
@endsection