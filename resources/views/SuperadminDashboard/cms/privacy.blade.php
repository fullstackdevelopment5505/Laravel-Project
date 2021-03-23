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
                        <form method="post" id="contentForm" action="{{ URL('/superadmin/cms/') }}">
                            <!--table start -->
                            @csrf
                            <!--table start -->
							
							<div class="col-sm-12 top_selling">
								<div class="inside">
									<div class="title">Privacy</div>
									<div class="row">
										<div class="col-sm-4">
											<div class="form-group">
												<div class="title">Title</div>
												<input type="text" name="page_title" class="form-control" value="{{$data['page_title']}}" />
											</div>
										</div>
										<div class="col-sm-12">
											<div class="form-group">
												<div class="title">Content</div>
												<textarea id="page_content" name="page_content">{{$data['page_content']}}</textarea>
											</div>
										</div>
										
										<div class="col-sm-12">
											<div class="form-group">
												<input type="checkbox" id="exampleCheck1" name="notify_users" >
												<label class="form-check-label" for="exampleCheck1">Notify To All Users</label>
											</div>
												
										</div>	
										<div class="col-sm-12">
											<div class="showbox">
												
												  <div class="form-group">
													<label for="policy_popup_title">Message Title</label>
													<input type="text" name="policy_popup_title" value="{{$policy_popup_title}}" class="form-control">
												  </div>
												  <div class="form-group">
													<label for="policy_popup_content">Body Message</label>
													<textarea class="form-control" id="policy_popup_content" name="policy_popup_content" rows="3">{!!$policy_popup_content!!}</textarea>
												  </div>
												
											</div>
										</div>
									</div>
								
									<div class="row">
										<div class="col-sm-12">
											<input type="hidden" name="type" value="privacy" />
											<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
										</div>
									</div>
								</div>
							</div>
                            
                            <!--table end-->
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
    CKEDITOR.replace( 'page_content' );
    CKEDITOR.replace( 'policy_popup_content',{
	toolbarGroups: [
	
 		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
 		{ name: 'links' }
	] });
	
	
	$('.showbox').hide();
    var validator;
    $(function() {
        validator = $('#contentForm').validate({
            ignore: [],
            rules: {
                page_title:{
                    required:true
                },
                page_content:{ 
                    ckrequired: true
                },
				policy_popup_content: {
					ckrequiredpopup: true
				}	
               
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
		$.validator.addMethod("ckrequiredpopup", function (value, element) {
			
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
        $('#exampleCheck1').click(function(){
            if($(this).is(":checked")){
               $(".showbox").show();
            }else{
				$(".showbox").hide();
				$("#contentForm").find($('textarea[name="policy_popup_content"]')).rules('remove','ckrequiredpopup');
			}
            
        });
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