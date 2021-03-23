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
                         @if(session()->get('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif
                        @if(session()->get('danger'))
                            <div class="alert alert-danger">
                                {{ session()->get('danger') }}
                            </div>
                        @endif
						<div class="col-md-12 mb-3">
							<a href="{{URL::route('superadminPostcardDesignRequested')}}"><button class="btn btn-primary"><i class="fa fa-long-arrow-left"></i> Back</button></a>
						</div>
						<!--table start -->
						
						<div class="col-sm-12 top_selling profile_whole_detail">
							<div class="inside">
								<div class="title">Profile</div>
								<div class="row">
									<div class="col-sm-12 all_customer_data">
										<div class="profile_pic">
											<?php if($profileimage != ""){ ?> 
												<img src="{{asset($profileimage)}}">
											<?php }else{ ?>
												<img src="{{asset('assets/customer/images/user.png')}}">
											<?php } ?>
										
										</div>
										<div class="profile_left">
											<h1 class="mb-3">{{$detail->users->details->f_name}}</h1>
											<p><i class="fa fa-map-marker"></i> <span>{{$address}}</span></p>
											<p><i class="fa fa-envelope"></i> <span>Email: {{$detail->users->email}}</span></p>
										</div>
										<div class="profile_right">
											<p><i class="fa fa-flag"></i> <span>Country: United States</span></p>
											<p><i class="fa fa-map"></i> <span>State: {{$detail->users->details->state}}</span></p>
											<p><i class="fa fa-map-pin"></i> <span>City: {{$detail->users->details->city}}</span></p>
											<p><i class="fa fa-map-signs"></i> <span>Postal Code: {{$detail->users->details->postal}}</span></p>
											<p><i class="fa fa-phone"></i> <span>Phone No: {{$detail->users->details->phone}}</span></p>
										</div>
									</div>
								</div>
							</div>

							<div class="inside">
								<p class="h5 mb-4">Postcard Design Information</p>
								<table class="tableadmin">
									<tr>
										<td><strong>What is the goal of your campaign?</strong></td>
										<td>{{$detail->users->details->phone}}</td>
									</tr>
									<tr>
										<td><strong>Who are you targeting?</strong></td>
										<td>{{$detail->company_goal}}</td>
									</tr>
									<tr>
										<td><strong>Primary Color</strong></td>
										<td>{{$detail->primary_color}} <span style="background:{{$detail->primary_color}}" class="updateclr"></span></td>
									</tr>
									<tr>
										<td><strong>Secondary Color</strong></td>
										<td>{{$detail->secondary_color}} <span style="background:{{$detail->secondary_color}}" class="updateclr"></span></td>
									</tr>
									<tr>
										<td><strong>Font-Family</strong></td>
										<td>{{$detail->font_family}}</td>
									</tr>
									<tr>
										<td><strong>Postcard Content</strong></td>
										<td><p style="line-height: 26px;">{{$detail->postcard_content}}</p></td>
									</tr>
									<tr>
										<td><strong>Attachment</strong></td>
										<td><img src="{{$detail->sample_image}}" width="300"></td>
									</tr>
									<tr>
										<td><strong>Any additional note to designer.</strong></td>
										<td>
											<p style="line-height: 26px;">{{$detail->additional_notes}}</p>
										</td>
									</tr>
								</table>
								@if($detail->status=='0')
								<div class="text-center w-100 p-3">
									<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#aceptmodal">Accept Request</button>
									<button class="btn btn-danger btn-lg" id="reject_request">Reject Request</button>
								</div>
								@endif
								@if($detail->status=='3')
								<div class="text-center w-100 p-3">
									<button class="btn btn-success btn-lg" data-toggle="modal" data-target="#aceptmodal">Accept Request</button>
								</div>
								@endif
							</div>
							@if($detail->status=='1')
							<div class="inside new_title">
								<form action="" method="post" id="completedForm" enctype= multipart/form-data>
								{{@csrf_field()}}
								<div class="widtharea">
									<h2>Upload Designs</h2>
									<input type="file" class="form-control" id="final_image" name="final_image">
									<input type="hidden" name="user_id" class="form-control" value="{{$detail->user_id}}">
									<input type="hidden" name="id" class="form-control" value="{{$detail->id}}">
									<input type="hidden" name="type" class="form-control" value="request_completed">
									<p class="text-left"><input type="checkbox" id="marko" name="check_completed" onchange="valueChanged()"> <label for="marko" > Mark this job as completed</label></p>
									<button type="button" id="mark_completed" class="btn btn-success mt-3 saves">Save</button>
								</div>
								</form>
							</div>
							@endif
							@if($detail->status=='2' && isset($image_templates[0]))
								<div class="inside">
									<div class="title">Designs</div>
									<div class="lists mt-4">
										<div class="row">
											<div class="col-md-4 col-lg-3 mb-3">
												<div class="inset">
													<p>Date: {{date('d-M-Y', strtotime($detail->completed_at))}}</p>
													<div class="overlap">
														
														<a class="btn btn-success" href="{{$image_templates[0]->template_image_path}}" download>
														  <i class="fa fa-download"></i>Download <img style="display:none;" src="{{$image_templates[0]->template_image_path}}">
														</a>

														<button class="btn btn-primary ml-2" data-toggle="modal" data-target="#myModal"><i class="fa fa-eye"></i> Preview</button>
													</div>
													<span><img src="{{$image_templates[0]->template_image_path}}" width="100%"></span>
													<!--h3>Thank You</h3-->
												</div>
											</div>
										</div>
									</div>
								</div>
							@endif	
								
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
	<!-- Manage grid  -->
<div class="modal" id="aceptmodal">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
        <!-- Modal Header -->
        <div class="modal-header">
            <h4 class="modal-title">Agent</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <form action="" method="post" id="designerForm" enctype= multipart/form-data>
            {{@csrf_field()}}
			<!-- Modal body -->
			<div class="modal-body">
				<div class="alert alert-danger print-error-msg" style="display:none">
					<ul></ul>
				</div>
				<div class="row">
					<div class="col-sm-12">
						<div class="form-group">
							<label>Your Name</label>
							<input type="text" class="form-control" name="agent_name">
							<input type="hidden" name="id" class="form-control" value="{{$detail->id}}">
							<input type="hidden" name="type" class="form-control" value="request_accepted">
						</div>
					</div>
					<div class="col-sm-12">
						<div class="form-group">
							<label>Contact Detail(Phone number)</label>
							  <input type="text" name="phone" id="phone" class="form-control">
						</div>
					</div>
				</div>
			</div>

			<!-- Modal footer -->
			<div class="modal-footer">
				<button type="button" id="submit_form"  class="btn btn-success">Done</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
			</div>
		</form>
    </div>
  </div>
</div>
	<!-- Preview -->
	<div class="modal" id="myModal">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		<!-- Modal Header -->
		<div class="modal-header">
			<h4 class="modal-title">Design Preview</h4>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		</div>
	 
		<!-- Modal body -->
		<div class="modal-body">
		@if(isset($image_templates[0]))
			<img src="{{$image_templates[0]->template_image_path}}" width="100%">
		@endif
		</div>

		<!-- Modal footer -->
		<div class="modal-footer">
			<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
		</div>

		</div>
	  </div>
	</div>

    <!-- popup end here-->
@endsection
@section('page_js')
<script> 
	 $('#mark_completed').click(function(){
        if($("#completedForm").valid()){ 
			$('#loader').show();
            var _token      =  $("input[name='_token']").val();
            var formData = new FormData($("#completedForm")[0]);
            $.ajax({
                url: "{{URL::route('superadminPostcardAjaxRequest')}}",
                type:'POST',
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
						$('#loader').hide();
                        alert(data.success);
                        jQuery('.alert-danger').hide();
                        window.location = "/superadmin/marketing/postcard/completed";
                    }else{
						$('#loader').hide();
                        //printErrorMsg(data.error);
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

    function printErrorMsg (msg) {
        $(".print-error-msg").find("ul").html('');
        $(".print-error-msg").css('display','block');
        $.each( msg, function( key, value ) {
            $(".print-error-msg").find("ul").append('<li>'+value+'</li>');
        });
    }

	validator = $('#completedForm').validate({
		rules: {
			final_image: {
				accept:"image/jpeg,image/png",
				//filesize_max: 300000,
				required:true
			},
			check_completed:{
				required:true
			}
		},
		messages: {
			final_image: {
				//filesize_max:" file size must be less than 250 KB.",
				accept: "Please upload file in these format only (jpg, jpeg, png)."
			}
		},
		errorPlacement: function(label, element) {
			label.addClass('text-danger');
			label.insertAfter(element);
		},
		wrapper: 'span'
	});
		
    $(document).on('click', "#reject_request", function() {
		var id = "{{$detail->id}}";
		var _token =  $('#designerForm').find($("input[name='_token']")).val();
		swal({
			title: "Are you sure!",
			type: "error",
			confirmButtonClass: "btn-danger",
			confirmButtonText: "Yes!",
			showCancelButton: true,
		},
		function() {
			$.ajax({
				url: "{{URL::route('superadminPostcardAjaxRequest')}}",
				type:'POST',
				data: { "id": id, "type": "reject_request", "_token": "{{ csrf_token() }}", },
				success: function(data) {
					if($.isEmptyObject(data.error)){
						$('#loader').hide();
						alert(data.message);
						jQuery('.alert-danger').hide();
						$('#open').hide();
						$('#aceptmodal').modal('hide');
						location.reload();
					}else{
						$('#loader').hide();
						alert(data.error);
						$.each(data.responseJSON, function (key, value) {
								var input = '#formArticle input[name=' + key + ']';
								$(input + '+span>strong').text(value);
								$(input).parent().parent().addClass('has-error');
							});
					}
				}
			});
		});
    });
    validator = $('#designerForm').validate({
            rules: {
                agent_name:{
                    required:true,
                    alpha: true
                },
                phone:{ 
                    required:true,
                    phoneUS: true
                }
            },
            messages: {
                phone:{
					required:"Please enter a mobile number ",
					digits: "Please enter only numbers",
					minlength:"Please put 10  digit mobile number",
					maxlength:"Please put 10  digit mobile number",
                }
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
		$.validator.addMethod("phoneUS", function(phone, element) {
			phone= phone.replace(/[^0-9]/gi, '');
			//console.log(phone);
            return this.optional(element) || phone.length == 10;
        }, "Please specify a valid US phone number");

        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
        }, "Letters only please");
	function valueChanged()
	{
		if($('#marko').is(":checked"))   
			$(".saves").show();
		else
			$(".saves").hide();
	}
    $(document).ready(function() {
        $('#postcard_table').DataTable();
	});
	 $('#submit_form').click(function(){
        if($("#designerForm").valid()){ 
			$('#loader').show();
            var button_id = $(this).attr("id");
            var _token      =  $("input[name='_token']").val();
            var formData = new FormData($("#designerForm")[0]);
            $.ajax({
                url: "{{URL::route('superadminPostcardAjaxRequest')}}",
                type:'POST',
                data: formData,
				processData: false,
				contentType: false,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
						$('#loader').hide();
                        alert(data.message);
                        jQuery('.alert-danger').hide();
                        $('#open').hide();
                        $('#aceptmodal').modal('hide');
                        window.location = "/superadmin/marketing/postcard/inprogress";

                    }else{
						$('#loader').hide();
                        alert(data.error);
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

</script> 
@endsection