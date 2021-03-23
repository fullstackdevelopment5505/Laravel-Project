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
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <div class="col-sm-12 top_btns">
                                    <button class="btn btn-primary" id="add-team" data-toggle="modal" data-title="Add Faq" data-url="{{ URL('/superadmin/cms/affiliate/faq/') }}" data-target="#createFaqModal">Add Faq<i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>  
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Frequently Asked Questions</div>
									<table class="display responsive nowrap" id="faqWrap" width="100%">
										<thead>
										    <tr>
										        <th>Sr. No.</th>
                                                <th>Question</th>
                                                <th>Answer</th>
												<th>Actions</th>
										    </tr>
										</thead>
										<tbody>
                                         @foreach($data as $faq)							    
                                            <tr>
                                                <td></td>
                                                <td>{{$faq->question}}</td>
												 <td>{{ substr(strip_tags($faq->answer),0, 20) }} 
                                                    @if (strlen(strip_tags($faq->answer)) > 20)
                                                    
                                                    ... <a href="#" data-desc="{{$faq->answer}}" class="btn btn-link viewMore">Read More</a>
                                                    @endif 
                                                </td>
                                                <td>
                                                    <button data-url="{{URL::route('superadminCmsAffiliateFaqEdit', $faq->id)}}" data-title="Edit Faq" type="button" class="btn btn-success edit-faq" id="edit-faq" data-faqid="{{$faq->id}}" >Edit</button>
                                                    <a class="btn btn-danger deleteFaq" data-faqid="{{$faq->id}}" href="#">delete</a>
                                                  
                                                </td>
                                            </tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
							</div>
							<!--table end-->
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
                    <h4 class="modal-title"><b>Content Preview</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                <textarea class="form-control" id="view_desc" name="view_desc" rows="6"></textarea>
                    
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
     <!-- popup start from here-->
     <div class="modal fade" id="createFaqModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Faq</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/superadmin/cms/affiliate/faq/" method="post" id="FaqForm" enctype= multipart/form-data>
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body register_new_user">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Question</label>
                                <input type="hidden" name="faq_id" class="form-control" id="faq_id">
                                <input type="hidden" name="url" class="form-control" >
								<textarea class="form-control" name="question" rows="4"></textarea>
                            </div>
                        </div>
                        
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Answer</label>
                                <textarea class="form-control" name="answer" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0"> 
                        <button type="button" id="save_button" class="btn btn-success btn-submit save_button">Add</button>
                        <button type="button" id="update_button" style="display:none;" class="btn btn-success btn-submit update_button">Update</button>
                        <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>
   
    <!-- popup end here-->
@endsection
@section('page_js') 
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
    var validator;
	$(document).ready(function () {
		$('#phone').usPhoneFormat({
			format: '(xxx) xxx-xxxx',
		});
		
		
	});
	
	$(document).on('click', '.viewMore', function (e) {
        e.preventDefault();
       
        var src = $(this).data("desc");
        console.log(src);
        var options = {
            'backdrop': 'static'
        };
        var modal = $('#myModal').modal(options);
        modal.find('.modal-title').text('');
		$("#view_desc").text(src);
        
        

    });
	
    $(function() {
        validator = $('#FaqForm').validate({
            rules: {
                question:{
                    required:true
                },
                answer:{
                    required:true

                }
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
    });
    $("#faqWrap").on('shown.bs.modal', function() {
        CKEDITOR.replace('description', {
        height: '400px',
        width: '100%'
        });
    });
    $('.btn-submit').click(function(){
        if($("#FaqForm").valid()){ 
			$('#loader').show();
            var _token      =  $("input[name='_token']").val();
            var url         = $("input[name='url']").val();
            var data        =  new FormData($("#FaqForm")[0])
          
            console.log(url);
            $.ajax({
                url: url,
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                processData: false,
                contentType: false,
                data: data,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
						$('#loader').hide();
                        alert(data.success);
                        jQuery('.alert-danger').hide();
                        $('#open').hide();
                        $('#createFaqModal').modal('hide');
                        location.reload();
                    }else{
                        printErrorMsg(data.error);
						$('#loader').hide();
                        $.each(data.responseJSON, function (key, value) {
                            var input = '#formArticle input[name=' + key + ']';
                            $(input + '+span>strong').text(value);
                            $(input).parent().parent().addClass('has-error');
                        });
                    }
                }
            });
        }
    });
    $("document").ready(function(){
        var t_aboutSliders =  $('#faqWrap').DataTable({
            "columns":[
                {data: "index", orderable: false, searchable: false},
                {data: "question"},
                {data: "answer"},
                {data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
           
            "order": [[ 0, 'desc' ]]          
        });

        t_aboutSliders.on( 'order.dt search.dt', function () {
            t_aboutSliders.column(0, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
                cell.innerHTML = i+1;
            } );
        }).draw();

    });
 //on add button
    $(document).on('click', "#add-team", function() {
       
       var options = {
           'backdrop': 'static'
       };
       $('#FaqForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
       var title = $(this).data('title');
       var modal = $('#createFaqModal').modal(options);
       modal.find('.modal-title').text(title);
       $("#FaqForm").trigger("reset");
      
         CKEDITOR.instances.description.setData('');//destroy the existing editor
		 
       $(".profile_img").hide();
	   $(".profile_img").find("img").attr('src', '');
       $(".header_image").hide();
	   $(".header_image").find("img").attr('src', '');
       validator.resetForm();
       $('.save_button').show();
       $('.update_button').hide();
   });
    //Edit Team
    $(document).on('click', "#edit-faq", function() {        
        $(this).addClass('edit-faq-trigger-clicked'); 
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
        var teamid = $(this).data("teamid");
        $('#FaqForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
        $.ajax({
            type: "GET",
            url: "{{route('superadminCmsAjaxRequest')}}",
            data: { id: teamid, type: "getFaqById" },
            success: function(data) {                
                if ($.isEmptyObject(data.error)) {
                    //len = length;
                    //console.log("content "+data['data'].description);
                    if (data['data']) {
                        $("input[name='faq_id']").val(data['data'].id);
                        $("textarea[name='question']").text(data['data'].question);
                        $("textarea[name='answer']").text(data['data'].answer);
                    } else {
                        alert("Something went wrong!");
                    }
                } else {
                    alert(data.error);               
                }
            }       
        });

        var options = {
            'backdrop': 'static'
        };
        var title = $(this).data('title');
        var modal = $('#createFaqModal').modal(options);
        modal.find('.modal-title').text(title);
        $('#FaqForm').find('[name="url"]').val($(this).data('url')).end();
        //show/hide button
        $("#FaqForm").trigger("reset");
        validator.resetForm();
        $('.save_button').hide();
        $('.update_button').show();
    });
  
    $(document).on('click', '.deleteFaq', function (e) {
        $row =  $(this).parent().parent();
        e.preventDefault();
        var faqid = $(this).data('faqid');
        swal({
                title: "Are you sure!",
                type: "error",
                confirmButtonClass: "btn-danger",
                confirmButtonText: "Yes!",
                showCancelButton: true,
            },
            function() {
            $.ajax({
                type: "GET",
                url: "{{route('superadminCmsAjaxRequest')}}",
                data: { id: faqid, type: "deleteFaq" },
                success: function(data){
                    
                    if($.isEmptyObject(data.error)){
                        
                        swal("Deleted!", data.success, "success"); 
						location.reload();
                        $row.remove();
                        
                    }else{
                        
                        swal("Cancelled", data.error, "error");   
                    }

                }       
            });
        });
    });
</script>
@endsection