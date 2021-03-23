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
									<div class="col-sm-12 from_to_filter">
										<form>
                                            <div class="view_back"><a href="{{route('sale_manager.message')}}"><i class="fa fa-arrow-left"></i></a></div>
                                            <div class="form-group">
                                                <input type="text" class="form-control" placeholder="Search">
                                            </div>
                                            <button type="button" class="btn btn-success">Search</button>
                                            <div class="delete_all_mail"><i class="fa fa-trash"></i></div>
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
                                            <div class="col-sm-12 sender_details">
                                                <div class="pic"><img src="{{asset('assets/superadmin/images/user.png')}}"></div>
                                                <div class="full_detail">
                                                    <div class="email">
                                                        <span>From: woodwalton@orbaxter.com</span>
                                                        <p>To: johndoe@gmail.com</p>
                                                    </div>
                                                    <div class="attached">
                                                        <span>16:54 13-02-2020</span>
                                                        <p><i class="fa fa-paperclip"></i> (2 files, 89.2 KB)</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-sm-12 message_data">
                                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui eaque, aperiam eius deserunt consequatur doloremque delectus voluptates totam minima asperiores, et in hic nemo quos accusantium repellendus explicabo reiciendis similique?</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut atque nihil fugiat maxime laudantium quas explicabo quisquam sit provident? Doloribus modi ullam deleniti voluptas cum autem corrupti. Quia, ratione culpa.</p>
                                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Ut atque nihil fugiat maxime laudantium quas explicabo quisquam sit provident.</p>
                                                <p>Lorem ipsum dolor, sit amet consectetur adipisicing elit. Qui eaque, aperiam eius deserunt consequatur doloremque delectus voluptates totam minima asperiores, et in hic nemo quos accusantium repellendus explicabo reiciendis similique?</p>
                                                <img src="{{asset('assets/superadmin/images/house1.jpg')}}">
                                                <img src="{{asset('assets/superadmin/images/house2.jpg')}}">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="reply_cta mt-4"><button class="btn btn-primary btn-lg"><i class="fa fa-mail-reply"></i> Reply</button></div>
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



