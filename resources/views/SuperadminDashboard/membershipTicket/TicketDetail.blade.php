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
                        <!-- datepicker -->
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <!--div class="col-sm-12 top_btns">
                                    <button class="btn btn-primary" id="add-item" data-toggle="modal" data-title="Add New Kickstarter" data-url="{{ URL('/superadmin/kickstarter/') }}" data-target="#createKickstarterModal">Add Kickstarter<i class="fa fa-plus"></i></button>
                                </div-->
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
                        <?php //cho "<pre>"; print_r($user); echo "</pre>"; ?>
                        
                        <div class="col-sm-12 top_selling">
							<div class="row">
								<!--Parent div start -->
									<div class="col-lg-4 top_selling2">
										<div class="inside">
											<div class="row">
												<div class="col-sm-12 all_customer_data2">
													<div class="profile_pic">
														<?php if($profileimage != ""){ ?> 
															<img src="{{asset($profileimage)}}">
														<?php }else{ ?>
															<img src="{{asset('assets/customer/images/user.png')}}">
														<?php } ?>
													</div>
													<div class="profile_left">
														<h1>{{ isset($data->users->details->f_name) ? $data->users->details->f_name: 'NA'}}</h1>
														<p><i class="fa fa-map-marker"></i> <span>{{ isset($data->users->details->address) ? $data->users->details->address : $data->users->details->postal}}</span></p>
														<p><i class="fa fa-envelope"></i> <span>Email: {{$data->users->email}}</span></p>
														<p><i class="fa fa-phone"></i> <span>Phone No: {{ isset($data->users->details->phone) ? $data->users->details->phone: 'NA'}}</span></p>
													</div>
												</div>
											</div>
										</div>
									</div>
								<!--Parent div end-->

								 <!--Parent div start -->
									<div class="col-lg-8 top_selling2  customer_joined">
										<div class="inside">
											<div class="form-group">
												<h4>Ticket Id:</h4>
												<p>{{$data->ticket_number}}</p>
											</div>
											<div class="form-group">
												<h4>Reason:</h4>
												<p>{{$reason->reason_text != "" ? $reason->reason_text : $reason->other}}</p>
											</div>
											<div class="form-group">
												<h4>Subject:</h4>
												<p>{{$data->subject}}</p>
											</div>
											<div class="form-group">
												<h4>Message:</h4>
												<p>{{$data->message}}</p>
											</div>
										</div>
									</div>
								<!--Parent div end-->
							</div>
						</div>
                        <!--table end-->
						<div class="col-lg-12 mt-4 text-center">
							@if($data->status == '0') 
							<a href="javascript:void(0);"><button type="button"  data-id="{{$data->id}}" data-user="{{$data->user_id}}"  id="mark_closed" class="btn btn-success">Mark As Resolve</button></a>
							@endif
							<a href="{{URL::route('superadmin.member.detail',['id'=>$data->user_id,'type'=>$user_type])}}"><button type="button" class="btn btn-dark">View User Profile</button></a>
						</div>
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
$(document).ready(function() {
	$('#open_ticket_table').DataTable({
	  "ordering": false
	});
	
	 $('body').on('click', '#mark_closed', function(e) {
        e.preventDefault();
        var id = $(this).data("id");
        var user_id = $(this).data("user");
        div = $(".status_button_wrap");
        swal({
            title: "Are you sure!",
            type: "warning",
            confirmButtonClass: "Eliminar!'",
            confirmButtonText: "Resolve!",
            showCancelButton: true,
        },
        function() {
			
            var type = 'resolve_cancel_membership_request';
         
            $.ajax({
                type: "GET",
                url: "{{route('superadminSavedSearchList')}}",
                data: { user_id: user_id, type: type,id:id },
                success: function(data){
                    
                    if($.isEmptyObject(data.error)){
                       window.location.replace('/superadmin/membership-ticket/closed/');
                    }else{
                        
                        swal("Cancelled", data.error, "error");   
                    }

                }       
            });
        });
    });
});
</script>
@endsection