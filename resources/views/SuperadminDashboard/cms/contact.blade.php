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
                    <form method="post" id="contentForm" action="{{ URL('/superadmin/cms/') }}">
						 <!--table start -->
						 @csrf
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Contact Us</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<div class="title">Title</div>
											<input type="text" name="page_title" class="form-control" value="{{isset($data->page_title) ? $data->page_title : ''}}" />
										</div>
                                    </div>
                                    <div class="col-sm-4">
										<div class="form-group">
											<div class="title">Phone Number</div>
											<input type="text" id="phone" name="phone_number" class="form-control" value="{{isset($data->page_metadata) ? $data->page_metadata : ''}}" />
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<div class="title">Content</div>
											<textarea id="page_content" name="page_content">{{isset($data->page_content) ? $data->page_content : ''}}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="type" value="contact" />
										<input type="hidden" name="id" value="{{isset($data->id) ? $data->id : ''}}" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
								</div>
							</div>
						</div>
						<!--table end-->
					</form>
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
    CKEDITOR.replace( 'page_content' );
   
    $(document).ready(function () {
		$('#phone').usPhoneFormat({
			format: '(xxx) xxx-xxxx',
		});
    });
    var validator;
    $(function() {
        validator = $('#contentForm').validate({
            ignore: [],
            rules: {
                page_title:{
                    required:true
                },
                
                phone_number:{ 
                    required:true,
                    phoneUS: true
                },
                page_content:{ 
                    ckrequired: true
                } 
               
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
        $.validator.addMethod("phoneUS", function(phone_number, element) {
			 phone_number= phone_number.replace(/[^0-9]/gi, '');
            return this.optional(element) || phone_number.length == 10;
        }, "Please specify a valid US phone number");

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
    function GetTextFromHtml(html) {
        var dv = document.createElement("DIV");
        dv.innerHTML = html;
        return dv.textContent || dv.innerText || "";
    }
    $("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 2000 );
    });

</script>   
@endsection   