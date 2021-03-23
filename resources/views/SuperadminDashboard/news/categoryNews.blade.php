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
							<div class="col-sm-12 mt-2 mb-4 text-right"><a href="{{route('superadminCmsAddnews')}}" data-url="{{ route('superadminCmsAddnews') }}" id="add-news" data-toggle="modal" data-target="#createNewsModal" class="btn btn-success"><i class="fa fa-plus"></i> Create New</a></div>
                            <!--table start -->
							    <div class="col-sm-12 top_selling d-block">
									<div class="inside">
										<div class="title mb-4">News & Insight</div>
										<div class="row">
											@if(empty($data) || $data->count()==0)
												<div class="col-md-6 training_box">
												No News found
												</div>
											@endif
											@foreach($data as $news)
											<div class="col-md-6 training_box">
												<div class="inset">
													<div class="row">
														<div class="col-md-5">
														<!-- punch -->
														@if($news->vimeo_id !="")
															<iframe width="100%" height="100%" src="https://player.vimeo.com/video/{{$news->vimeo_id}}" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        @elseif($news->youtube_id !="")
                                                    		<iframe width="100%" height="100%" src='https://www.youtube.com/embed/{{$news->youtube_id}}' frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                                                        @elseif($news->filename !="")
															<img src="{{$news->filename}}"/>
														@else

														@endif


														</div>
														<div class="col-md-7">
															<div class="title training-title"><h2>
															{!! substr(strip_tags(htmlspecialchars_decode($news->title)),0, 100) !!}
															</h2></div>
															<div class="content mt-3"><p>{!! substr(strip_tags(htmlspecialchars_decode($news->description)),0, 120) !!}
															@if (strlen(strip_tags(htmlspecialchars_decode($news->description))) > 120)
																 ... <a href="#" data-desc="{{$news->description}}" class="btn btn-link viewMore">Read More</a>
															 @endif</p></div>
															<div class="d-flex mt-3">

																<a data-url="{{URL::route('superadminViewNewsEdit', $news->id)}}" id="edit-news" href="{{URL::route('superadminViewNewsEdit', $news->id)}}" class="btn btn-success mr-2 text-white rounded-circle edit-news edit-item-trigger-clicked" data-newsid="{{$news->id}}"><i class="fa fa-pencil"></i></a>
																<button class="btn btn-danger rounded-circle deleteNews" data-newsid="{{$news->id}}"><i class="fa fa-trash"></i></button>
															</div>
														</div>
													</div>
												</div>
											</div>
											@endforeach
										</div>
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
                <form action="{{route('superadminCmsAddnews')}}" method="post" id="NewsForm" enctype= multipart/form-data>
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
                                <input type="hidden" name="url" value="{{route('superadminCmsAddnews')}}" class="form-control" >
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
                                        <option value="{{$val->id}}" <?php if($cat_id == $val->id){ echo 'selected="selected"'; } ?>>{{$val->name}}</option>
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
								<label>Media</label>
								<select id="media" name="media" class="form-control">
									<option value="">Select Media</option>
									<optgroup>

										<option value="youtube_id">Youtube Video</option><!-- punch -->
										<option value="vimeo_id">Vimeo Video</option>
										<option value="image">Upload Image</option>

									</optgroup>
								</select>
							</div>
						</div>
                        <!-- punch -->
						<div class="col-sm-8 youtube">
                            <div class="form-group">
                                <label>Youtube ID</label>
                                <input type="text" id="youtube_id" name="youtube_id" class="form-control media-group">
                            </div>
                        </div>
                        <!-- punch -->
						<div class="col-sm-8 vimeo">
                            <div class="form-group">
                                <label>Vimeo ID</label>
                                <input type="text" id="vimeo_id" name="vimeo_id" class="form-control media-group">
                            </div>
                        </div>
                        <div class="col-sm-8">
                            <div class="form-group image">
                                <label>Image</label>
                                <input type="file" name="filename" id="filename" class="form-control media-group">
                                <input type="hidden" name="file_check" id="file_check" value="0">
                            </div>
							<img id="preview" src="" />
                            <div class="col-sm-3 image">
                                <img src="">
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Small Description</label>
                                <textarea class="form-control ignore" id="small_description" name="small_description" rows="2"></textarea>
                            </div>

                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control ignore" id="description" data-maxlen="5" name="description" ></textarea>
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
<script src="https://cdn.jsdelivr.net/jquery.validation/1.16.0/additional-methods.min.js"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>
<script>
    CKEDITOR.replace( 'view_desc' );
    CKEDITOR.replace( 'small_description' );
    CKEDITOR.replace( 'description' );

    var validator;
    $(function() {

        validator = $('#NewsForm').validate({
            ignore: [":not(:visible), :hidden,.ignore"],

            rules: {
                title:{
                    required:true
                },
				media:{
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
				vimeo_id: {

				    require_from_group: [1, ".media-group"]
				},
                youtube_id: {

				    require_from_group: [1, ".media-group"]
				},
                filename: {

                    require_from_group: [1, ".media-group"],
                    accept:"image/jpeg,image/jpg,image/png"

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
					require_from_group:'This field is required.',
                    accept: "Please upload file in these format only (jpg, jpeg, png)."
                },
				vimeo_id: {
					require_from_group:'This field is required.'
                },
                youtube_id: {
					require_from_group:'This field is required.'
                }

            },

            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span',
			invalidHandler: function() {
			  $(this).find(":input.error:first").focus();
			},
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
	$(document).ready(function() {
		$('.vimeo').hide();
		$('.youtube').hide(); //punch
		$('.image').hide();
		$('#media').change(function () {
			if ( $(this).val() == 'vimeo_id') {
				$('.vimeo').show();
				$('.image').hide();
				$('.youtube').hide(); //punch
				$('input[name="filename"]').val('');
				$('input[name="youtube_id"]').val(''); //punch
                $('#preview').attr('src','');
				if($("#vimeo_id").val() == "" ){
					$('input[name="vimeo_id"]').rules('add', {
						require_from_group: [1, ".media-group"],
					});
					$('input[name="filename"]').rules('add', {
						require_from_group: [1, ".media-group"],
					});
                    $('input[name="youtube_id"]').rules('add', {
						require_from_group: [1, ".media-group"],
					});//punch
				}else{
					$('input[name="vimeo_id"]').rules('add', {
						require_from_group: [0, ".media-group"],
					});
					$('input[name="filename"]').rules('add', {
						require_from_group: [0, ".media-group"],
						required:false
					});
                    $('input[name="youtube_id"]').rules('add', {
						require_from_group: [0, ".media-group"],
					});//punch
				}

			}
            else if ( $(this).val() == 'youtube_id') {
                // punch
                $('.vimeo').hide();
                $('.youtube').show();
				$('.image').hide();
				$('input[name="filename"]').val('');
				$('input[name="vimeo_id"]').val('');
					$('#preview').attr('src','');
				if($("#youtube_id").val() == "" ){
                    $('input[name="vimeo_id"]').rules('add', {
						require_from_group: [1, ".media-group"],
					});
					$('input[name="youtube_id"]').rules('add', {
						require_from_group: [1, ".media-group"],
					});
					$('input[name="filename"]').rules('add', {
						require_from_group: [1, ".media-group"],
					});
				}else{
                    $('input[name="vimeo_id"]').rules('add', {
						require_from_group: [0, ".media-group"],
					});
					$('input[name="youtube_id"]').rules('add', {
						require_from_group: [0, ".media-group"],
					});
					$('input[name="filename"]').rules('add', {
						require_from_group: [0, ".media-group"],
						required:false
					});
				}
            }
			else{
				$('.vimeo').hide();
				$('.image').show();
                $('.youtube').hide();//punch
				$('input[name="vimeo_id"]').val('');
				$('input[name="youtube_id"]').val('');//punch
				if($("#file_check").val() == 1){

					$('input[name="filename"]').rules('add', {
						require_from_group: [0, ".media-group"],
					});
					$('input[name="vimeo_id"]').rules('add', {
						require_from_group: [0, ".media-group"],
					});
                    $('input[name="youtube_id"]').rules('add', {
						require_from_group: [0, ".media-group"],
					}); //punch
				}else{

					$('input[name="vimeo_id"]').rules('add', {
						require_from_group: [1, ".media-group"],
						required:false
					});
					$('input[name="filename"]').rules('add', {
						require_from_group: [1, ".media-group"],
					});
                    $('input[name="youtube_id"]').rules('add', {
						require_from_group: [1, ".media-group"],
					}); //punch
				}


			}
		});
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


		if ($("#NewsForm").valid() == false){
			 $("#NewsForm").find(":file.error").focus();
		 $('html, body').animate({
		   scrollTop: ($('.error').offset().top - 60)
		}, 500);
		}
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
       /* $('input[name="filename"]').rules('add', {
            required: true
        });	 */
       var options = {
           'backdrop': 'static'
       };
       $('#NewsForm')
           .find('[name="url"]')
           .val($(this).data('url'))
           .end();

       var title = $(this).data('title');
       var modal = $('#createNewsModal').modal(options);
       modal.find('.modal-title').text('Add News');
       $("#NewsForm").trigger("reset");

         CKEDITOR.instances.description.setData('');//destroy the existing editor
         CKEDITOR.instances.small_description.setData('');//destroy the existing editor


	   $(".image").find("img").attr('src', '');
		$('.image').hide();
		$('.vimeo').hide();
        $('.youtube').hide(); //punch
       validator.resetForm();
       $('.save_button').show();
       $('.update_button').hide();
   });
    //Edit News
    $(document).on('click', "#edit-news", function(e) {
		e.preventDefault();
		$("#preview").attr('src', '');
		/* $('input[name="filename"]').rules('add', {
            required: false
        });	 */
        $(this).addClass('edit-item-trigger-clicked');
		var modal = $('#createNewsModal').modal(options);
       modal.find('.modal-title').text('Edit News');
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
                        if(data['data'].vimeo_id != ""){
							$("#media").val('vimeo_id');
							$('.vimeo').show();
							$('.image').hide();
							$('.youtube').hide();//punch
							$("input[name='vimeo_id']").val(data['data'].vimeo_id);
							$("#file_check").val('0');
							$('input[name="youtube_id"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});	//punch
                            $('input[name="filename"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});
							$('input[name="vimeo_id"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});
						}else if(data['data'].youtube_id != ""){//punch
                            $("#media").val('youtube_id');
							$('.vimeo').hide();
							$('.image').hide();
							$('.youtube').show();
							$("input[name='youtube_id']").val(data['data'].youtube_id);
							$("#file_check").val('2');
							$('input[name="youtube_id"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});	//punch
                            $('input[name="filename"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});
							$('input[name="vimeo_id"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});
                        }
                        $("input[name='slug']").val(data['data'].url);
						$('#date').datepicker("setDate", new Date(data['data'].date) );
                        CKEDITOR.instances['description'].setData(data['data'].description);
                        CKEDITOR.instances['small_description'].setData(data['data'].small_description);
                        $("#category").val(data['data'].category);
						$("#role").val(data['data'].posted_by_role);

                        if (data['data'].filename) {
							$('.vimeo').hide();
							$('.youtube').hide();//punch
							$('.image').show();
							$("#media").val('image');
							$('input[name="filename"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});
							$('input[name="vimeo_id"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});
                            $('input[name="youtube_id"]').rules('add', {
								require_from_group: [0, ".media-group"],
							});	//punch
							/* $('input[name="filename"]').rules('add', {
								require_from_group: [1, ".media-group"],
							});
							$('input[name="vimeo_id"]').rules('add', {
								require_from_group: [1, ".media-group"],
							});	 */
                            $(".image img").attr('src', data['data'].filename);
							$("#file_check").val('1');
                        }
                        if(data['data'].filename == "" && data['data'].vimeo_id =="" && data['data'].youtube_id ==""){//punch
							$('input[name="filename"]').rules('add', {
								require_from_group: [1, ".media-group"],
							});
							$('input[name="vimeo_id"]').rules('add', {
								require_from_group: [1, ".media-group"],
							});
                            // punch
                            $('input[name="youtube_id"]').rules('add', {
								require_from_group: [1, ".media-group"],
							});

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
