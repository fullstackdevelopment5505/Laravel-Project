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
                                    <button class="btn btn-primary" id="add-news" data-toggle="modal" data-title="Add News" data-url="{{ URL('/superadmin/cms/news/') }}" data-target="#createNewsModal">Add News<i class="fa fa-plus"></i></button>
									<a class="btn btn-info" href="{{ URL('/superadmin/cms/news/category/') }}"  data-title="view category"  >View categories<i class="fa fa-eye"></i></a>
									<a class="btn btn-info" href="{{ URL('/superadmin/cms/news/role/') }}"  data-title="view Roles"  >View Roles<i class="fa fa-eye"></i></a>
                                </div>
                            </div>
                        </div>  
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">News List</div>
									<table class="display responsive nowrap" id="newsWrap" width="100%">
										<thead>
										    <tr>
										        <th>Sr. No.</th>
                                                <th>Title</th>
                                                <th>Category</th>
												<th>Role</th>
												<th>Date</th>
                                                <th>Image</th>
                                                <th>Small Description</th>
												<th>Description</th>
												<th>URL</th>
												<th>Actions</th>
										    </tr>
										</thead>
										<tbody>
                                         @foreach($data as $news)							    
                                            <tr>
                                                <td></td>
                                                <td>{{$news->title}}</td>
                                                <td>{{isset($news->category_detail) ? $news->category_detail->name : ''}}</td>
												<td>	{{ isset($news->role_detail) ? $news->role_detail->role : '-'}}</td>
												<td>{{ $news->date}}</td>
                                                <td><img width="150" src="{{$news->filename}}"/></td>
                                                <td>{{ substr(strip_tags($news->small_description),0, 20) }} 
                                                    @if (strlen(strip_tags($news->small_description)) > 20)
                                                    
                                                    ... <a href="#" data-desc="{{$news->small_description}}" class="btn btn-link viewMore">Read More</a>
                                                    @endif 
                                              
                                                </td>
                                                <td> {{ substr(strip_tags($news->description),0, 20) }}
                                                    @if (strlen(strip_tags($news->description)) > 20)
                                                         ... <a href="#" data-desc="{{$news->description}}" class="btn btn-link viewMore">Read More</a>
                                                     @endif
                                                    
                                                 </td>
                                                <td>{{$news->url}}</td>
                                                <td>
                                                    <button data-url="{{URL::route('superadminViewNewsEdit', $news->id)}}" data-title="Edit News" type="button" class="btn btn-success edit-news" id="edit-news" data-newsid="{{$news->id}}" >Edit</button>
                                                    <a class="btn btn-danger deleteNews" data-newsid="{{$news->id}}" href="#">delete</a>
                                                  
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
     <div class="modal fade" id="createNewsModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              
                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New News</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/superadmin/cms/news/" method="post" id="NewsForm" enctype= multipart/form-data>
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body register_new_user">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="hidden" name="news_id" class="form-control" id="news_id">
                                <input type="hidden" name="url" value="/superadmin/cms/news/" class="form-control" >
                                <input type="hidden" name="slug" value="" >
                                <input type="text" id="title" name="title" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Category</label>
                                <select id="category" name="category" class="form-control">
                                    <option value="">Select Category</option>
                                    <optgroup>
                                        @foreach($categories as $val)
                                        <option value="{{$val->id}}">{{$val->name}}</option>
                                        @endforeach
                                    </optgroup>
                                </select>
                            </div>
                        </div>
						<div class="col-sm-8">
							<div class="form-group">
								<label>Role</label>
								<select id="role" name="posted_by_role" class="form-control">
									<option value="">Select Role</option>
									<optgroup>
										@foreach($roles as $val)
										<option value="{{$val->id}}">{{$val->role}}</option>
										@endforeach
									</optgroup>
								</select>
							</div>
						</div>
						<div class="col-sm-8">
                            <div class="form-group">
                                <label>Date</label>
								<input type="text" autocomplete="off" id="date" name="date" class="date form-control">
                                
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group">
                                <label>Image</label>
                                <input type="file" name="filename" id="filename" class="form-control">
                            </div>
							<img id="preview" src="" />
                            <div class="col-sm-3 image">
                                <img src="">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Small Description</label>
                                <textarea class="form-control" id="small_description" name="small_description" rows="2"></textarea>
                            </div>
							
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" id="description" data-maxlen="5" name="description" ></textarea>
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
      <!-- popup start from here-->
    <div class="modal fade" id="myModal">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title"><b>Content Preview</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body">
                <textarea class="form-control" id="view_desc" name="view_desc" rows="2"></textarea>
                    
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
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    CKEDITOR.replace( 'view_desc' );
    CKEDITOR.replace( 'small_description' );
    CKEDITOR.replace( 'description' ); 

    var validator;
    $(function() {
        validator = $('#NewsForm').validate({
            ignore: [],
            rules: {
                title:{
                    required:true
                },
                category:{
                    required:true

                },
				posted_by_role:{
                    required:true

                },
				date:{
                    required:true

                },
                filename: {
                    required:true,
                    accept:"image/jpeg,image/png"
                
                },
                small_description:{
                    ckrequired: true,
					cklength:true
                },
                description:{
                    ckrequired:true,
					cklength:true
                }
            },
            messages: {
                filename: {
                    accept: "Please upload file in these format only (jpg, jpeg, png)."
                },
                
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
        $.validator.addMethod("cklength", function (value, element) {
         
			var idname = $(element).attr('id');
			var editor = CKEDITOR.instances[idname];
			var ckValue = GetTextFromHtml(editor.getData());
			return ckValue.length >= 75;
		}, "Minimum 75 characters required.");
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
	
	$(function() {
		$('#date').datepicker({
			dateFormat: "yy/mm/dd",
			firstDay: 1,
		});
		
	});
    function GetTextFromHtml(html) {
            var dv = document.createElement("DIV");
            dv.innerHTML = html;
            return dv.textContent || dv.innerText || "";
        }
    
    $("#newsWrap").on('shown.bs.modal', function() {
        CKEDITOR.replace('description', {
        height: '400px',
        width: '100%'
        });
    });
    $('.btn-submit').click(function(){
        if($("#NewsForm").valid()){ 
			$('#loader').show();
            var _token      =  $("input[name='_token']").val();
            var url         = $("input[name='url']").val();
            var data        =  new FormData($("#NewsForm")[0])
            data.append('description', CKEDITOR.instances['description'].getData());
            data.append('small_description', CKEDITOR.instances['small_description'].getData());
          
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
                        $('#createKickstarterModal').modal('hide');
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
        var t_aboutSliders =  $('#newsWrap').DataTable({
			 columns:[
                {data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: "title"},
                { data: "category"},
				{ data: "role",className: "role"},
                { data: "date", render: function(d){
					return moment(d).format("DD-MMM-YYYY");
					},
				},
               
				{ data: "filename"},
				{ data: "small_description"},
				{ data: "description"},
                { data: "url"},
				
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
    $(document).on('click', "#add-news", function() {
		$("#preview").attr('src', '');
       $('input[name="filename"]').rules('add', {
            required: true
        });	
       var options = {
           'backdrop': 'static'
       };
       $('#NewsForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
       var title = $(this).data('title');
       var modal = $('#createNewsModal').modal(options);
       modal.find('.modal-title').text(title);
       $("#NewsForm").trigger("reset");
      
         CKEDITOR.instances.description.setData('');//destroy the existing editor
         CKEDITOR.instances.small_description.setData('');//destroy the existing editor
		 
     
	   $(".image").find("img").attr('src', '');
	
       validator.resetForm();
       $('.save_button').show();
       $('.update_button').hide();
   });
    //Edit News
    $(document).on('click', "#edit-news", function() {
			$("#preview").attr('src', '');
		$('input[name="filename"]').rules('add', {
            required: false
        });	
        $(this).addClass('edit-item-trigger-clicked'); 
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
        var news_id = $(this).data("newsid");
        $('#NewsForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();
        $.ajax({
            type: "GET",
            url: "{{route('superadminViewAjaxRequest')}}",
            data: { id: news_id, type: "getNewsById" },
            success: function(data) {                
                if ($.isEmptyObject(data.error)) {
                    //len = length;
                    //console.log("content "+data['data'].description);
                    if (data['data']) {
                        $("input[name='news_id']").val(data['data'].id);
                        $("input[name='title']").val(data['data'].title);
                        $("input[name='slug']").val(data['data'].url);
						$('#date').datepicker("setDate", new Date(data['data'].date) );
                        CKEDITOR.instances['description'].setData(data['data'].description);
                        CKEDITOR.instances['small_description'].setData(data['data'].small_description);
                        $("#category").val(data['data'].category);
						$("#role").val(data['data'].posted_by_role);
                        if (data['data'].filename) {
                            $(".image img").attr('src', data['data'].filename);
                           
                        } 
                        
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
        var modal = $('#createNewsModal').modal(options);
        modal.find('.modal-title').text(title);
        $('#NewsForm').find('[name="url"]').val($(this).data('url')).end();
        //show/hide button
        $("#NewsForm").trigger("reset");
        validator.resetForm();
        $('.save_button').hide();
        $('.update_button').show();
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
        CKEDITOR.instances['view_desc'].setData(src);
        

    });
    $('#myModal').on('hide.bs.modal', function() {
        CKEDITOR.instances.view_desc.setData('');
		$("#preview").attr('src', '');
    });
    $(document).on('click', '.deleteNews', function (e) {
        $row =  $(this).parent().parent();
        e.preventDefault();
        var newsid = $(this).data('newsid');
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
                url: "{{route('superadminViewAjaxRequest')}}",
                data: { id: newsid, type: "deleteNews" },
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
	function readURL(input) {
	  if (input.files && input.files[0]) {
		var reader = new FileReader();
		
		reader.onload = function(e) {
			
			$("#preview").attr('src', e.target.result);
           
		 
		}
		
		reader.readAsDataURL(input.files[0]); // convert to base64 string
	  }
	}
	$(document).on('change', '#filename', function () {
		
	  readURL(this);
	});
    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

    
</script>
@endsection