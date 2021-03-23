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
                    <form method="post" id="signupForm" enctype="multipart/form-data" action="{{ URL('/superadmin/cms/') }}" style="width:96%">
                        @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="page-header">
                                <div class="title">Sign up</div>
                                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="hr-success" />
                                </div>
                                <div class="page-header">
                                    <div class="title">Step 1</div>
                                    <hr class="dashed">
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Heading 1</div>
                                            <input class="form-control req" type="text" name="heading_1" value="{{$data['heading_1']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Sub heading 1</div>
                                            <input class="form-control req" type="text" name="sub_heading_1" value="{{$data['sub_heading_1']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Content 1 </div>
                                            <textarea class="form-control req content_wrap" id="content_1" name="content_1" rows="3" cols="20">{{$data['content_1']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="page-header">
                                    <div class="title">Step 2</div>
                                    <hr class="dashed">
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Heading 2</div>
                                            <input class="form-control" type="text" name="heading_2" value="{{$data['heading_2']}}" />
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Sub heading 2.1</div>
                                            <input class="form-control" type="text" name="sub_heading_2_1" value="{{$data['sub_heading_2_1']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Content 2.1</label>
                                            <textarea class="form-control"  id="content_2_1" name="content_2_1" rows="5" cols="50">{{$data['content_2_1']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Sub heading 2.2</div>
                                            <input class="form-control" type="text" name="sub_heading_2_2" value="{{$data['sub_heading_2_2']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Content 2.2</label>
                                            <textarea class="form-control" id="content_2_2" name="content_2_2" rows="5" cols="50">{{$data['content_2_2']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <div class="title">Sub heading 2.3</div>
                                            <input class="form-control" type="text" name="sub_heading_2_3" value="{{$data['sub_heading_2_3']}}" />
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <label class="title">Content 2.3</label>
                                            <textarea class="form-control" id="content_2_3" name="content_2_3" rows="5" cols="50">{{$data['content_2_3']}}</textarea>
                                        </div>
                                    </div>
                                </div>
                                <input type="hidden" name="page_name" value="sign-up" />
                                <input class="form-control" type="hidden" name="type" value="signup" />
                                <input class="form-control" type="hidden" name="id" value="{{$id}}" />
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
    CKEDITOR.replace( 'content_1' );
    CKEDITOR.replace( 'content_2_1' );
    CKEDITOR.replace( 'content_2_2' );
    CKEDITOR.replace( 'content_2_3' );
    var validator;
    $(document).ready(function () {
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
        

        $.validator.addClassRules({
            req: {
                required: true
            },
            content_wrap: {
                ckrequired:true
            },
           image:{
                accept:"image/jpeg,image/jpg,image/png",
            },
        });

        $("#signupForm").validate({
            ignore: [],
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });

        
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
</script>   
@endsection