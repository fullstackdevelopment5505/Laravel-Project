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
                    
                    <!--table end-->
                    <form method="post" id="contentForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/') }}" style="width:96%">
                        @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="page-header">
                                <div class="title">Popup for becoming a member</div>
                                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="hr-success" />
                                </div>
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="title">Title</div>
                                            <input class="form-control req" type="text" name="page_title" value="{{$data['become_member_popup_title']}}" />
                                        </div>
                                    </div>
                                   
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="title">Content  </div>
                                            <textarea class="form-control req content_wrap" id="page_content" name="page_content" rows="3" cols="20">{{$data['become_member_popup_content']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                               
                                <input type="hidden" name="popup_name" value="become_member_popup" />
                                <input class="form-control" type="hidden" name="type" value="popup" />
                                <div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                            </div>
                        </div>
                    </form>
					
					<!--table end-->
                    <form method="post" id="cookieForm" action="{{ URL('/superadmin/cms/') }}" style="width:96%">
                        @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="page-header">
                                <div class="title">Cookies</div>
                                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="hr-success" />
                                </div>
                                <div class="row">
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="title">Content  </div>
                                            <textarea class="form-control" id="cookie_content" name="cookie_content" rows="3" cols="20">{{$cookie_content}}</textarea>
                                        </div>
                                    </div>
                                </div>
                               
                                <input type="hidden" name="popup_name" value="cookie_popup" />
                                <input class="form-control" type="hidden" name="type" value="popup" />
                                <div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                            </div>
                        </div>
                    </form>
					
					<!--table end-->
                    <form method="post" id="sessionForm" action="{{ URL('/superadmin/cms/') }}" style="width:96%">
                        @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="page-header">
                                <div class="title">Session</div>
                                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="hr-success" />
                                </div>
                                <div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<div class="title">Title</div>
											<input class="form-control" type="text" name="session_title" value="{{$session_title}}" />
										</div>
									</div>
                                    <div class="col-sm-8">
                                        <div class="form-group">
                                            <div class="title">Session Content </div>
                                            <textarea class="form-control" id="session_content" name="session_content" rows="3" cols="20">{{$session_content}}</textarea>
                                        </div>
                                    </div>
                                </div>
                               
                                <input type="hidden" name="popup_name" value="session_popup" />
                                <input class="form-control" type="hidden" name="type" value="popup" />
                                <div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
                            </div>
                        </div>
                    </form>
					
					
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
	CKEDITOR.replace( 'cookie_content',{
	toolbarGroups: [
	
 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
 		{ name: 'links' }
	] });
    var validator;
    $(document).ready(function () {
    
        $.validator.addClassRules({
            req: {
                required: true
            },
            content_wrap: {
                required:true
            }
        });

        $("#contentForm").validate({
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
		$("#cookieForm").validate({
			ignore: [],
			rules: {
                cookie_content:{
                    ckrequired: true
                },
			},
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
		
		$("#sessionForm").validate({
			rules: {
                session_content:{
                    required:true
                },
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
				$(element).val(ckValue);
            } else {
				$(element).val(editor.getData());
            }
            return $(element).val().length > 0;
        }, "This field is required");
    });
   
    $("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 2000 );
    });
   
</script>   
@endsection