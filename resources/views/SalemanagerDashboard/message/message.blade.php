@extends('SuperadminDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('SalemanagerDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
            @include('SuperadminDashboard.layouts.header');	
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
							<a href="{{route('sale_manager.sendMessage')}}" class="btn btn-primary">Send Message <i class="fa fa-plus"></i></a>
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
                                    <ul>
                                        <li>
                                            <a href="{{route('sale_manager.viewMessage')}}">
                                                <label><input type="checkbox"><span></span></label>
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.jpg')}}"></div>
                                                <div class="data">
                                                    <h2>Velit A Labore</h2>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta ea neque velit aliquid, incidunt voluptatibus tempora possimus.</p>
                                                </div>
                                                <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('sale_manager.viewMessage')}}">
                                                <label><input type="checkbox"><span></span></label>
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.jpg')}}"></div>
                                                <div class="data">
                                                    <h2>Velit A Labore</h2>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta ea neque velit aliquid, incidunt voluptatibus tempora possimus.</p>
                                                </div>
                                                <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('sale_manager.viewMessage')}}">
                                                <label><input type="checkbox"><span></span></label>
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.jpg')}}"></div>
                                                <div class="data">
                                                    <h2>Velit A Labore</h2>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta ea neque velit aliquid, incidunt voluptatibus tempora possimus.</p>
                                                </div>
                                                <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('sale_manager.viewMessage')}}">
                                                <label><input type="checkbox"><span></span></label>
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.jpg')}}"></div>
                                                <div class="data">
                                                    <h2>Velit A Labore</h2>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta ea neque velit aliquid, incidunt voluptatibus tempora possimus.</p>
                                                </div>
                                                <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('sale_manager.viewMessage')}}">
                                                <label><input type="checkbox"><span></span></label>
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.jpg')}}"></div>
                                                <div class="data">
                                                    <h2>Velit A Labore</h2>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta ea neque velit aliquid, incidunt voluptatibus tempora possimus.</p>
                                                </div>
                                                <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('sale_manager.viewMessage')}}">
                                                <label><input type="checkbox"><span></span></label>
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.jpg')}}"></div>
                                                <div class="data">
                                                    <h2>Velit A Labore</h2>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta ea neque velit aliquid, incidunt voluptatibus tempora possimus.</p>
                                                </div>
                                                <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{route('sale_manager.viewMessage')}}">
                                                <label><input type="checkbox"><span></span></label>
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.jpg')}}"></div>
                                                <div class="data">
                                                    <h2>Velit A Labore</h2>
                                                    <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Soluta ea neque velit aliquid, incidunt voluptatibus tempora possimus.</p>
                                                </div>
                                                <div class="time">12:35 AM <i class="fa fa-paperclip"></i></div>
                                            </a>
                                        </li>
                                    </ul>
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
@endsection