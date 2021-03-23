@extends('CustomerDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('CustomerDashboard.layouts.sidebar');
        <!-- right area start -->
        <section class="right_section">
            @include('CustomerDashboard.layouts.header');
			<!-- inside_content_area start-->
			<div class="content_area">
                <!-- datepicker -->
				<div class="col-sm-12 top_bar_area">
					<div class="row">
						<div class="col-sm-12 from_to_filter">
							<form>
                                <div class="view_back"><a href="{{route('customerMessage')}}"><i class="fa fa-arrow-left"></i></a></div>
                                <div class="title">Send Message</div>
                            </form>
						</div>
					</div>
				</div>
				<!-- datepicker -->
				<!-- main row start-->
					<div class="col-sm-12">
						<div class="row">
                            <form id="sendMessage" >
                                <!--  customer detail start-->
                                <div class="col-sm-12 top_selling">
                                    <div class="inside">
                                        <div class="full_message_detail">
                                            <div class="row">
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Choose member</label>
                                                        <select class="form-control" name="member">
                                                            <option value="member 1">Member 1</option>
                                                            <option value="member 2">Member 2</option>
                                                            <option value="member 3">Member 3</option>
                                                            <option value="member 4">Member 4</option>
                                                            <option value="member 5">Member 5</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <div class="form-group">
                                                        <label>Subject</label>
                                                        <input type="text" name="subject" class="form-control">
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
                                        <div class="reply_cta mt-4"><input type="submit" name="submit" value="Send Message" class="btn btn-primary btn-lg" ></div>
                                    </div>
                                </div>
                                <!--  customer detail end-->
                            </formss>    
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