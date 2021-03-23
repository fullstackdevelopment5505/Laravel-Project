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
                        <div class="col-sm-12 from_to_filter">
                            <form>
                                <div class="view_back"><a href="{{route('saleExecutiveMessage')}}"><i class="fa fa-arrow-left"></i></a></div>
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
                                            <div class="pic"><img src="{{asset('assets/saleExecutive/images/user.png')}}"></div>
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
                                            <img src="{{asset('assets/saleExecutive/images/house1.jpg')}}">
                                            <img src="{{asset('assets/saleExecutive/images/house2.jpg')}}">
                                        </div>
                                    </div>
                                </div>
                                <div class="reply_cta mt-4"><a href="{{route('saleExecutiveReplyMessage')}}" class="btn btn-primary btn-lg"><i class="fa fa-mail-reply"></i> Reply</a ></div>
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