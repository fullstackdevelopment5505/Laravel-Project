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
                               
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
                        <?php //cho "<pre>"; print_r($user); echo "</pre>"; ?>
                        
                        <div class="col-sm-12 top_selling d-block">
						
                            <div class="inside">
								<div class="title mb-4">Add Package</div>
								<form action="{{ URL('/superadmin/configuration/packages')}}" method="post" id="packageForm" enctype= multipart/form-data>
								<!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
								{{@csrf_field()}}
								
								<div class="alert alert-danger print-error-msg" style="display:none">
									<ul></ul>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Plan Name</label>
											<input type="text" id="plan_name" name="plan_name" value="" class="form-control">
										</div>
									</div>
									
									
									<div class="col-md-4">
										<div class="form-group">
											<label>Amount</label>
											<input type="text" name="amount" id="amount" class="form-control" data-inputmask="'alias': 'currency'" style="text-align: right;">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Duration</label>
											<select name="validity_period" class="form-control">
												<option value="">Select</option>
												<option value="week">/Per Week</option>
												<option value="month">/Per Month</option>
												<option value="year">/Per Year</option>
											</select>
										</div>
									</div>
									<div class="col-md-12">
										<div class="form-group">
											<label>Select Your Features list:</label>
											<select class="js-example-basic-multiple form-control" name="features[]" multiple="multiple">
												<option value=""></option>
												
											</select>
										</div>
									</div>
									<div class="col-sm-12 d-flex">
										<button type="submit" id="save_button" class="btn btn-success btn-submit save_button mr-2">Save</button>
										<a href="{{ URL('/superadmin/configuration/packages')}}" class="btn btn-danger"></a>
										<button type="reset" id="save_button" class="btn btn-danger">Cancel</button>
									</div>
								</div>
							</form>
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

	
@endsection
@section('page_js')

<script>
	$(document).ready(function() {
	    $('.js-example-basic-multiple').select2();
		$(":input").inputmask();
	});
    $(function() {
        validator = $('#packageForm').validate({
            rules: {
                plan_name:{
                    required:true
                },
                amount:{ 
                    required:true
                } ,
                validity_period:{
                    required:true

                },
                features:{
                    required:true
                },
                
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });

    });
	
</script> 
@endsection