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
								<div class="title">About</div>
								<div class="row">
									<div class="col-sm-4">
										<div class="form-group">
											<div class="title">Title</div>
											<input type="text" name="page_title" class="form-control" value="{{$data->page_title}}" />
										</div>
									</div>
									<div class="col-sm-8">
										<div class="form-group">
											<div class="title">About Us Content</div>
											<textarea name="page_content">{!!$data->page_content!!}</textarea>
										</div>
									</div>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<input type="hidden" name="type" value="about" />
										<input type="hidden" name="id" value="{{$data->id}}" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
								</div>
							</div>
						</div>
						<!--table end-->
					</form>

                    <div class="col-sm-12 top_selling">
                         <div class="inside">
                            <div class="title">Add Slider Data</div>
                            <form method="post" id="sliderForm" action="{{ URL('/superadmin/cms/about/upload-image') }}" enctype="multipart/form-data">
                                <!--form start -->
                                @csrf
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="title">Add Image</div>
                                            <input type="file" name="file_slider" class="form-control" id="images"/>
                                            {!! $errors->first('file_slider', '<small class="text-danger">:message</small>') !!}
                                        </div>
                                    </div>
									 <div class="col-sm-4">
                                        <div class="form-group">
                                            <div class="title">Slide Title</div>
                                            <input type="text" name="slide_title" class="form-control" />
                                        </div>
                                    </div>
									<div class="col-sm-4">
										<div class="form-group">
											<div class="title">Position</div>
											<input  type="text" name="position" required />
										</div>
									</div>
                                    <div class="col-sm-8">
                                        <div class="row">

                                            <div class="col-sm-4">
                                                <div class="form-group">
                                                    <button type="submit" id="save_button" class="btn btn-success btn-submit save_button">Submit</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!--form end-->
                            </form>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 top_selling slider_images">
                            <div class="inside">
                                <div class="title">Slider</div>
                                <table class="display responsive nowrap" id="aboutSliders" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Sr. No.</th>
                                                <th>Image</th>
												 <th>Title</th>
                                                <th>Position</th>
                                                <th>Status</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody> <?php $i=1; ?>
                                            @foreach($sliderData as $slide)
                                            <tr>
                                                <td>{{$i}}</td>
                                                <td><img data-toggle="modal" data-target="#myModal" class="myImg" alt="" width="300" src="{{asset($slide->image)}}" style="cursor: pointer;" />

                                                 </td>
												 <td>{{$slide->slide_title}}</td>
                                                <td>{{$slide->position}}</td>
                                                <td>

                                                <input data-id="{{$slide->id}}" data-title="{{ $slide->status ? 'Deactivate' : 'Activate' }}" class="toggle-class" type="checkbox" data-onstyle="success" data-offstyle="danger" data-toggle="toggle" data-on="Active" data-off="InActive" {{ $slide->status ? 'checked' : '' }}>

                                                </td>
                                                <td>
                                                    <button data-title="Edit position" type="button" class="btn btn-success changePosition" id="edit-item-{{$slide->id}}" >Change Position</button>
                                                    <a class="btn btn-danger deleteSlide" data-slideid="{{$slide->id}}" data-value="{{$slide->status}}" href="#">delete</a>
                                                    <div class="position_input" style="display:none;">
                                                    <form id="up_pos_{{$slide->id}}" class="update_pos_form" method="GET" action="">
                                                    <input type="text" value="{{$slide->position}}" name="position" required />
                                                    <button type="button" data-title="Edit position" class="btn btn-success updatePosition" data-slideid="{{$slide->id}}" >Submit</button>
                                                    </form>
                                            </div>
                                                </td>
                                            </tr>
											<?php $i++; ?>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <!-- The Modal -->
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
<script>CKEDITOR.replace( 'page_content' );</script>
<script src="{{asset('assets/superadmin/js/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/superadmin/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/superadmin/js/dataTables.buttons.min.js')}}"></script>
<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

<script>
	$("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 2000 );
    });
    $("#sliderForm").validate({
        rules: {
            position:{
                required:true,
                number: true
            },
            file_slider:{
                required:true,
                accept:"image/jpeg,image/png",
            },

        }
    });

    $(document).on('click', ".deleteSlide", function(e) {
        e.preventDefault();
        slider_id =  $(this).data("slideid");
        $row = $(this).closest("tr");
        console.log($(this).closest("tr").addClass("clickedtr"));
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
                dataType: "json",
                url: "{{route('superadminCmsAjaxRequest')}}",
                data: {'slider_id': slider_id, 'type': 'delete_slide'},
                success: function(data){
                    if($.isEmptyObject(data.error)){

                        swal("Deleted!", data.success, "success");
                        $row.remove();

                    }else{

                        swal("Cancelled", data.error, "error");
                    }

                }
            });
        });
    });
    $(document).on('click', ".changePosition", function() {
        $(this).closest("td").addClass("clicked td");
        $(this).closest("td").find(".position_input").toggle();
    });


    $(document).on('click', ".updatePosition", function() {

        var position = $(this).closest("td").find("input").val();
       var form = $(this).closest("td").find("form");
       var formID = form.attr("id");
       $("#"+formID).validate({
            rules: {
                position:{
                    required:true,
                    number: true
                },
                messages: {
                    position:{
                        required:"Please enter a value ",
                        number: "Please enter only numbers"
                    },
                }
            }
        });
        console.log($(this).data("slideid"));
        slider_id =  $(this).data("slideid")
        if($("#"+formID).valid()){
            $.ajax({
                type: "GET",
                dataType: "json",
                async:false,
                url: "{{route('superadminCmsAjaxRequest')}}",
                data: {'position': position, 'slider_id': slider_id, 'type': 'update_position'},
                success: function(data){
                    alert(data.success);
                    location.reload();
                }
            });
        }

    });


    $(document).on('change', ".toggle-class", function() {

      var status = $(this).prop('checked') == true ? 1 : 0;
      var slider_id = $(this).data('id');
       console.log(status);
       console.log(slider_id);

      swal({
          title: "Are you sure!",
          type: "error",
          confirmButtonClass: "btn-danger",
          confirmButtonText: "Yes!",
          showCancelButton: true,
          },
          function(isConfirm) { // punch
              if(isConfirm){  // punch
                      $.ajax({
                      type: "GET",
                      dataType: "json",
                      url: "{{route('superadminCmsAjaxRequest')}}",
                      data: {'status': status, 'slider_id': slider_id, 'type': 'update_status'},
                      success: function(data){
                          alert(data.success);
                      location.reload();
                      }
                  });
              }else{// punch
                  if(status == 0){// punch
                      $('input[data-id=' + slider_id + ']').parent().addClass("btn-success on");// punch
                      $('input[data-id=' + slider_id + ']').parent().removeClass('btn-danger off');// punch
                  }else{// punch
                      $('input[data-id=' + slider_id + ']').parent().removeClass('btn-success on');// punch
                      $('input[data-id=' + slider_id + ']').parent().addClass('btn-danger off');// punch
                  }// punch
              }// punch

      });
  });


    $("#contentForm").submit( function(e) {
        var messageLength = CKEDITOR.instances['page_content'].getData().replace(/<[^>]*>/gi, '').length;
        if( !messageLength ) {
            alert( 'Please enter  content' );
            e.preventDefault();
        }
    });
    $("document").ready(function(){


       $('#aboutSliders').DataTable();

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

</script>

@endsection
