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
                </div>
                <div class="row">
                    <form method="post" id="contentForm" action="{{ URL('/superadmin/cms/membership/update') }}" style="width:96%">
                        <!--table start -->
                        @csrf
                        <!--table start -->
                        <?php 
                            // echo '<pre>'; print_r($data);die;
                        ?>
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="title">Membership Page</div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Page Title</div>
                                            <input class="form-control" type="text" name="page_title" value="{{$data->page_title}}" />
											<input class="form-control" type="hidden" name="id" value="{{$data->id}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class = "row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                        <div class="title">Page Content</div>
                                        <textarea id="page_content" name="page_content">{!!$data->page_content!!}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="page_name" value="membership" />
                                <div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                            </div>
                        </div>
                        <!--table end-->
                    </form>
                    <form method="post" id="membershipForm" action="{{ URL('/superadmin/cms/membership/update') }}" style="width:96%">
                        <!--table start -->
                        @csrf
                        <!--table start -->
                        <?php 
                            // echo '<pre>'; print_r($data);die;
                        ?>
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="title">Membership Plan</div>
                                <div class="row">
									<div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Title</div>
                                            <input class="form-control" type="text" name="page_title" value="{{$plan->page_title}}" />
											
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Membership Type</div>
                                            <input class="form-control" type="text" name="type" value="{{$plan->type}}" />
											
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Description</div>
                                            <textarea class="form-control" name="description" rows="5" cols="6">{{$plan->description}}</textarea>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Amount</div> 
                                                        
                                            <input class="form-control" data-inputmask="'alias': 'currency', 'rightAlign': false" id="amount" type="text" name="amount" value="{{$plan->amount}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Allowed Users</div>              
                                            <input class="form-control" type="number" name="login_users" min="1" max="100" value="{{$plan->login_users}}" />
                                        </div>
                                    </div>                                    
                                </div>                                
                                <input type="hidden" name="page_name" value="plans" />
                                <input type="hidden" name="id" value="{{$plan->id}}" />
                                <div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                            </div>
                        </div>
                        <!--table end-->
                    </form>
					
					 <!--table end-->
					<form method="post" id="howWorksForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/membership/update') }}" style="width:96%">
                         @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
								<div class="page-header">
									<div class="title">How It Works</div>
									<hr class="dashed">
								</div>
								<div class="row">
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Heading</div>
											<input class="form-control req" type="text" name="heading" value="{{$extra_content_data['heading']}}" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Sub heading</div>
											<textarea class="form-control req" name="sub_heading">{{$extra_content_data['sub_heading']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<div class="title">Box Title 1</div> 
											<input class="form-control req" type="text" name="box_title_1"  value="{{$extra_content_data['box_title_1']}}" />
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<div class="title">Image</div> 
											<input type="hidden" name="box_image_1_old" id="box_image_1_old" value="{{$extra_content_data['box_image_1']}}" />
											<input class="form-control image" type="file" name="box_image_1" value="" />
											<img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($extra_content_data['box_image_1'])}}" style="cursor: pointer;" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<div class="title">Description</div>
											<textarea class="form-control req" name="box_1_content" rows="5" cols="50">{{$extra_content_data['box_1_content']}}</textarea>
										</div>
									</div>
								</div> 
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="title">Box Title 2</label>
											<input type="text" class="form-control req" name="box_title_2"  value="{{$extra_content_data['box_title_2']}}" />
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label class="title">Image</label>
											<input type="hidden" id="box_image_2_old" name="box_image_2_old" value="{{$extra_content_data['box_image_2']}}" />
											<input type="file" class="form-control image" name="box_image_2" value="" />
											<img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($extra_content_data['box_image_2'])}}" style="cursor: pointer;" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Description</label>
											<textarea class="form-control req" name="box_2_content" rows="5" cols="50">{{$extra_content_data['box_2_content']}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-3">
										<div class="form-group">
											<label class="title">Box  Title 3</label>
											<input class="form-control req" type="text" name="box_title_3"  value="{{$extra_content_data['box_title_3']}}" />
										</div>
									</div>
									<div class="col-sm-3">
										<div class="form-group">
											<label class="title">Image</label>
											<input type="hidden" id="box_image_3_old" name="box_image_3_old" value="{{$extra_content_data['box_image_3']}}" />
											<input class="form-control image" type="file" name="box_image_3" value="" />
											<img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="80" src="{{asset($extra_content_data['box_image_3'])}}" style="cursor: pointer;" />
										</div>
									</div>
									<div class="col-sm-6">
										<div class="form-group">
											<label class="title">Description</label>
											<textarea class="form-control req" name="box_3_content" rows="5" cols="50">{{$extra_content_data['box_3_content']}}</textarea>
										</div>
									</div>
								</div>
								<input type="hidden" name="page_name" value="how-works" />
								<input class="form-control" type="hidden" name="id" value="{{$data->id}}" />
								<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                            </div>
                        </div>
                    </form>
				</div>
            </div>
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
    CKEDITOR.replace( 'page_content' );
    var validator;
    $(function() {
        validator =   $("#contentForm").validate({
            ignore: [],
            rules: {
                page_title:{
                    required:true
                },
                page_content:{
                    ckrequired:true
                }
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });

       
        $.validator.addMethod("ckrequired", function (value, element) {
            
        var idname = $(element).attr('id');
        var editor = CKEDITOR.instances[idname];
        var ckValue = GetTextFromHtml(editor.getData())
            .replace(/<[^>]*>/gi, '').trim();
            if (ckValue.length === 0) {
        //if empty or trimmed value then remove extra spacing to current control
            $(element).val(ckValue);
            } else {
            //If not empty then leave the value as it is
            $(element).val(editor.getData());
            }
                return $(element).val().length > 0;
        }, "This field is required");
    });
    $(document).ready(function () {
		
        jQuery.validator.addMethod("dollarsscents", function (value, element) {
            return this.optional(element) || /^\d{0,4}(\.\d{0,2})?$/i.test(value);
        }, "You must include two decimal places or numbers");

        $("#membershipForm").validate({
            rules: {
				page_title:{
                    required:true
                },
                type:{
                    required:true
                },
                description:{
                    required:true
                },
                amount:{
                    required:true
                },
                login_users:{
                    required:true,
                    number:true
                },
                
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
		
		
		$('#howWorksForm').validate({ // initialize the plugin
            rules: {
                box_image_1:{
                    required: function(){
                        return $("#box_image_1_old").val() == "";
                    }
                
                },
                box_image_2:{
                    required: function(){
                        return $("#box_image_2_old").val() == "";
                    }
                },

                 box_image_3:{
                    required: function(){
                        return $("#box_image_3_old").val() == "";
                    }
                },
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span',
           
        });
        $.validator.messages.accept = 'File must be JPG, GIF or PNG';
        $.validator.addClassRules({
            req: {
                required: true
            },
           image:{
                accept:"image/jpeg,image/jpg,image/png",
            },
        });
    });
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
	$("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 2000 );
    });
    function GetTextFromHtml(html) {
        var dv = document.createElement("DIV");
        dv.innerHTML = html;
        return dv.textContent || dv.innerText || "";
    }
	 $("document").ready(function(){
		 $("#amount").inputmask();
		//$('#amount').maskMoney();
		//$('#amount').maskMoney();
	  })
	  
	
</script>   
@endsection