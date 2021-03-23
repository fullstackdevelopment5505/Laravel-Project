@extends('SuperadminDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('SuperadminDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
            @include('SuperadminDashboard.layouts.header');	
            <!-- inside_content_area start-->
            <div class="content_area">
                <div class="col-sm-12">
                    <div class="row">
                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
						
                        @if ($message = Session::get('success'))
                        <div class="alert alert-success alert-block">
                            <button type="button" class="close" data-dismiss="alert">×</button>	
                                <strong>{{ $message }}</strong>
                        </div>
                        @endif
                        <?php 
                            //print_r($data1); die;
                        ?>
                    </div>
                    
                   
                        <!--table-start -->
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="sliderForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/home/update') }}">
							  @csrf
                                <div class="title">Home Banner Section</div>
                                <div class="row">
                                    <div class="col-sm-6">                                
                                        <div class="form-group">
                                            <div class="title">Banner Title</div>
                                            <input class="form-control" type="text" name="home_slider_title" value="{{$data1['home_slider_title']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">   
                                            <div class="title">Banner Content</div> 
                                            <textarea class="form-control" name="home_slider_conent" rows="5" cols="70">{{$data1['home_slider_conent']}}</textarea>
                                        </div>   
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group">   
                                            <div class="title">Banner Video Title</div> 
                                           <input class="form-control" type="text" name="home_slider_video_title" value="{{$data1['home_slider_video_title']}}" />
                                        </div>
                                            
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group">   
                                            <div class="title">Banner Video URL (Iframe embed code)</div> 
											<textarea class="form-control" name="home_slider_video" rows="4" cols="4">{{$data1['home_slider_video']}}</textarea>
                                        </div>
                                            
                                    </div>
                                </div>
								<div class="row">
									<div class="form-group">
										<div class="title">Banner Image</div> 
										<input type="hidden" name="home_slider_image_old" value="{{$data1['home_slider_image']}}" />
										<input class="form-control" type="file" name="home_slider_image" value="{{$data1['home_slider_image']}}" />
										<img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($data1['home_slider_image'])}}" style="cursor: pointer;" />
									</div>
								</div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="type" value="home_slider" />    
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg text-center">Save</button></div>
									</div>
								</div>
							</form>	
                            </div>                    
                        </div>
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="serviceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/home/update') }}">
							  @csrf
								<div class="page-header">
								<div class="title">Services</div>
									<hr class="dashed">
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<div class="title">Service Title 1</div> 
											<input class="form-control" type="text" name="service_title_1"  value="{{$data1['service_title_1']}}" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<div class="title">Image</div> 
											<input type="hidden" name="service_title_1_image_old" value="{{$data1['service_title_1_image']}}" />
											<input class="form-control" type="file" name="service_title_1_image" value="{{$data1['service_title_1_image']}}" />
											<img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($data1['service_title_1_image'])}}" style="cursor: pointer;" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<div class="title">Description</div>
											<textarea class="form-control" name="service_title_1_content" rows="5" cols="50">{{$data1['service_title_1_content']}}</textarea>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label class="title">Service Title 2</label>
											<input type="text" class="form-control" name="service_title_2"  value="{{$data1['service_title_2']}}" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="title">Image</label>
											<input type="hidden" name="service_title_2_image_old" value="{{$data1['service_title_2_image']}}" />
											<input type="file" class="form-control" name="service_title_2_image" value="{{$data1['service_title_2_image']}}" />
											<img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($data1['service_title_2_image'])}}" style="cursor: pointer;" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="title">Description</label>
											<textarea class="form-control" name="service_title_2_content" rows="5" cols="50">{{$data1['service_title_2_content']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<label class="title">Service Title 3</label>
											<input class="form-control" type="text" name="service_title_3"  value="{{$data1['service_title_3']}}" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="title">Image</label>
											<input type="hidden" name="service_title_3_image_old" value="{{$data1['service_title_3_image']}}" />
											<input class="form-control" type="file" name="service_title_3_image" value="{{$data1['service_title_3_image']}}" />
											<img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($data1['service_title_3_image'])}}" style="cursor: pointer;" />
										</div>
									</div>
									<div class="col-sm-4">
										<div class="form-group">
											<label class="title">Description</label>
											<textarea class="form-control" name="service_title_3_content" rows="5" cols="50">{{$data1['service_title_3_content']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row text-center">
								<div class="col-sm-12">
								<input type="hidden" name="type" value="home_services" />    
								<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
								</div>
								</div>
								</form>
                            </div>
                            </div>
                        </div>
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="categoryForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/home/update') }}">
							  @csrf
                                <div class="title">Category Section</div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Title</label>
                                            <input class="form-control" type="text" name="category_section_title" value="{{$data1['category_section_title']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Description</label>
                                            <textarea class="form-control" name="category_content" rows="5" cols="80">{{$data1['category_content']}}</textarea>
                                        </div>
                                    </div>
                                </div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="type" value="home_category" />    
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
								</div>
							</form>
                            </div>
                        </div>                       
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="kickstartForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/home/update') }}">
							  @csrf
                                <div class="title">Kickstart Section</div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Title</label>
                                            <input type="text" class="form-control" name="kickstart_section_title" value="{{$data1['kickstart_section_title']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Description</label>
                                            <textarea class="form-control" name="kickstart_content" rows="10" cols="80">{{$data1['kickstart_content']}}</textarea>
                                        </div>
                                    </div>
                                </div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="type" value="home_kickstarter" />    
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
								</div>
								</form>
                            </div>
                        </div>
                        <div class="col-sm-12 top_selling" id="footerSection">
                            <div class="inside">
							<form method="post" id="footerForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/home/update') }}">
							  @csrf
                                <div class="title">Footer Section</div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Facebook url</label>
                                            <input type="text" class="form-control" name="fb_url" value="{{$data1['fb_url']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Twitter url</label>
                                            <input type="text" class="form-control" name="twt_url" value="{{$data1['twt_url']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Piterest url</label>
                                            <input type="text" class="form-control" name="pin_url" value="{{$data1['pin_url']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Instagram url</label>
                                            <input type="text"  class="form-control" name="insta_url" value="{{$data1['insta_url']}}" />
                                        </div>
                                    </div> 
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Linkedin url</label>
                                            <input type="text"  class="form-control" name="linkedin_url" value="{{$data1['linkedin_url']}}" />
                                        </div>
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Youtube url</label>
                                            <input type="text"  class="form-control" name="youtube_url" value="{{$data1['youtube_url']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Footer Logo</label>
                                            <input type="file"  class="form-control" name="footer_logo" value="{{$data1['footer_logo']}}" />
                                            <input type="hidden" name="footer_logo_old" value="{{$data1['footer_logo']}}" />
                                            <img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($data1['footer_logo'])}}" style="cursor: pointer;" />
                                        </div>
                                    </div>
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Copyright Section</label>
                                            <textarea class="form-control" name="footer_copyright" >{!!$data1['footer_copyright']!!}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Footer Content</label>
                                            <textarea name="footer_content" rows="10" cols="80">{!!$data1['footer_content']!!}</textarea>
                                        </div>
                                    </div>
									
                                </div>
								<div class="row text-center">
									<div class="col-sm-12">
									<input type="hidden" name="type" value="home_footer" />    
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
								</div>
							</form>
                            </div>
                        </div>
                       
                        <!--table-end-->
                  
					<form method="post" id="contentFormCA" action="{{ URL('/superadmin/cms/home/update') }}">
                             <!--table start -->
                         @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="page-header">
                                    <div class="title">What’s Happening in the CA</div>
                                        <hr class="dashed">
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Heading</div> 
                                                <input class="form-control ca" type="text" name="heading"  value="{{$data1['ca_heading']}}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Counter 1</div> 
                                                <input class="form-control ca_num" type="text" name="counter_1"  value="{{$data1['counter_1']}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Title 1</div> 
                                                <input class="form-control ca" type="text" name="title_1"  value="{{$data1['title_1']}}" />
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Counter 2</div> 
                                                <input class="form-control ca_num" type="text" name="counter_2"  value="{{$data1['counter_2']}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Title 2</div> 
                                                <input class="form-control ca" type="text" name="title_2"  value="{{$data1['title_2']}}" />
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Counter 3</div> 
                                                <input class="form-control ca_num" type="text" name="counter_3"  value="{{$data1['counter_3']}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Title 3</div> 
                                                <input class="form-control ca" type="text" name="title_3"  value="{{$data1['title_3']}}" />
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Counter 4</div> 
                                                <input class="form-control ca_num" type="text" name="counter_4"  value="{{$data1['counter_4']}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Title 4</div> 
                                                <input class="form-control" type="text" name="title_4"  value="{{$data1['title_4']}}" />
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Counter 5</div> 
                                                <input class="form-control ca_num" type="text" name="counter_5"  value="{{$data1['counter_5']}}" />
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <div class="title">Title 5</div> 
                                                <input class="form-control" type="text" name="title_5"  value="{{$data1['title_5']}}" />
                                            </div>
                                        </div>
                                    </div> 
                                   <div class="row  text-center">
										<div class="col-sm-12">
                                        <input type="hidden" name="type" value="home_ca" />    
                                            <div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                   
                </div>
            </div>
            <!-- inside_content_area end-->
        </section>
        <!-- right area end -->
    </div>
    <!-- main div end -->
    <!-- popup start from here-->
    <div class="modal fade" id="myModal">
            <div class="modal-dialog modal-md">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title"><b>Slider Image Preview</b></h4>
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                    </div>

                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <img  src="" class="image_full"  />
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer pl-0 pr-0">
                        <div class="col-md-12 text-center p-0"> 
                            <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- popup end here-->


@endsection
@section('page_js')
<script>

	/* @if ($message = Session::get('success'))
		$([document.documentElement, document.body]).animate({
        scrollTop: $("#footerSection").offset().top-150
		}, 1000);
	@endif */
    var validator;
    
    $(document).on('click', ".myImg", function() {
        var src = $(this).attr("src");
        console.log(src);
        var options = {
            'backdrop': 'static'
        };
        var modal = $('#myModal').modal(options);
        modal.find('.modal-title').text('');
        console.log(modal.find('.image_full').attr('class'));
        modal.find(".image_full").attr('src',src);
    });
	$(document).ready(function () {
		$.validator.addMethod("youtube", function(value, element) {  
			var p = /^(?:https?:\/\/)?(?:www\.)?youtube\.com\/watch\?(?=.*v=((\w|-){11}))(?:\S+)?$/;  
			return (value.match(p)) ? RegExp.$1 : false;  
		}, "Enter correct URL");  
		$("#sliderForm").validate({
			rules: {  
				home_slider_video: {  
					required: true,  
					//youtube: "#useravideo"  
				}  
	  
			},  
			messages: {  
				home_slider_video: {  
					required: "Enter user A video URL",  
				}  
			},  
			errorPlacement: function(label, element) {
				label.addClass('text-danger');
				label.insertAfter(element);
			},
			wrapper: 'span'
		});
		$("#footerForm").validate({
			rules: {
				footer_copyright:{
					required:true,
				},
				footer_logo:{
					accept:"image/jpeg,image/png",
				},
			},
			messages: {
				footer_logo: {
					accept: "Please upload file in these format only (jpg, jpeg, png)."
				}
				
			},
			errorPlacement: function(label, element) {
				label.addClass('text-danger');
				label.insertAfter(element);
			},
			wrapper: 'span'
		});
		$("#serviceForm").validate({
			rules: {
				service_title_1_image:{
					accept:"image/jpeg,image/png",
				},
				service_title_2image:{
					accept:"image/jpeg,image/png",
				},
				service_title_3_image:{
					accept:"image/jpeg,image/png",
				}
			},
			messages: {
				service_title_1_image: {
					accept: "Please upload file in these format only (jpg, jpeg, png)."
				},
				service_title_2_image: {
					accept: "Please upload file in these format only (jpg, jpeg, png)."
				},
				service_title_3_image: {
					accept: "Please upload file in these format only (jpg, jpeg, png)."
				}
			},
			errorPlacement: function(label, element) {
				label.addClass('text-danger');
				label.insertAfter(element);
			},
			wrapper: 'span'
		});
		$('#contentFormCA').validate({ errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'});
        
        jQuery.validator.addClassRules("ca", {
            required: true
        });
        jQuery.validator.addClassRules("ca_num", {
            required: true,
			 max: 1000000,
            number:true
        });
	});
	$("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 5000 );
    });
</script>   
@endsection   