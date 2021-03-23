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
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                            <div class="row">
                                
								<div class="col-sm-12 customer_tabs">
									<ul class="nav nav-pills">
										<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#debit_points">Regular Records</a></li>
										<!--li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#credit_points">Packages</a></li-->
									</ul>
								</div>
								<div class="tab-content">
									<!--table start -->
										<div class="col-sm-12 tab-pane top_selling" id="credit_points">
											<div class="inside">
												<div class="col-sm-12 mt-2 mb-4 text-right">
													<a href="{{ URL('/superadmin/configuration/features') }}" class="btn btn-primary"> Add Features <i class="fa fa-plus ml-2"></i></a>
													<a href="{{ URL('/superadmin/configuration/packages') }}" class="btn btn-success"> Add Package <i class="fa fa-plus ml-2"></i></a>
												</div>
												<div class="row">
													@if($packages->count()>0)
													@foreach($packages as $key => $data)
													<div class="col-md-4">
														<div class="bluearea">
															<div class="seprate">
																<h3>{{$data->plan_name}}</h3>
																<h1>${{$data->price}}</h1>
																<p>Per {{$data->validity_period}}</p>
															</div>
															@if(isset($data->features) && $data->features)
															<ul>
																@foreach($data->features as $key => $feature)
																@if($feature->type !="")
																<li>{{$feature->allowed_number}} {{$feature->type}}</li>
																@endif
																@if($feature->description !="")
																<li>{{$feature->description}}</li>
																@endif
																@endforeach
															</ul>
															 @endif
															<div class="buttons">
																<a href="add-package.php?active=rat"><button type="button" class="btn btn-success"><i class="fa fa-pencil"></i></button></a>
																<button class="btn btn-danger"><i class="fa fa-trash"></i></button>
															</div>
														</div>
													</div>
													@endforeach
													@else
													<div class="col-sm-12 mt-2 mb-4 text-left">
														<div class="title">No Package Found.</div>
													</div>
												    @endif
												</div>
											</div>
										</div>
										<!--table end-->
									<!--table start -->
									<div class="col-sm-12  tab-pane active top_selling" id="debit_points">
										<div class="inside">
					                    <div class="row">
											<div class="col-md-4">
												<div class="title">Membership</div>
												<form method="post" id="membershipPricetForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
													@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="membership_price" value="{{isset($membership->amount) ? $membership->amount : ''}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="membership_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												</form>
											</div>
											<div class="col-md-4">
												<div class="title">Property Record(Advance Search)</div>
												<form method="post" id="purchaseRecordForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
													@csrf
												<div class="form-group d-flex">
													<input class="form-control req" id="purchase_record_price" name="purchase_record_price" value="{{$purchase_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;" >
													<input class="form-control" type="hidden" name="type" value="purchase_record_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												</form>
											</div>
											<div class="col-md-4">
												<div class="title">Property Detail Report(Report Download)</div>
												<form method="post" id="propertyreporttForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
												@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="property_report_price" value="{{$property_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="property_report_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												</form>
											</div>
											</div>
											</div>
											<div class="inside">
											<div class="row">
											<div class="title ml-3">Datafinder/Accurate Append Price</div>
											<div class="col-md-4">
												<div class="title">Email</div>
												<form method="post" id="emailPriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
												@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="email_price" value="{{$email_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="email_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												<div class="errorTxtEmail text-danger"></div>
												</form>
											</div>
											<div class="col-md-4">
												<div class="title">Phone Number</div>
												<form method="post" id="phonePriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
												@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="phone_price" value="{{$phone_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="phone_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												<div class="errorTxtPhone text-danger"></div>
											</form>
											</div>
											</div>
											</div>
											<div class="inside">
											<div class="row">
											<div class="title ml-3">Marketing Price</div>
											<div class="col-md-4">
												<div class="title">Email</div>
												<form method="post" id="marketEmailPriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
												@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="market_email_price" value="{{$market_email_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="market_email_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												<div class="errorTxtMarketemail text-danger"></div>
												</form>
											</div>
											<div class="col-md-4">
												<div class="title">SMS</div>
												<form method="post" id="smsPriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
												@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="market_sms_price" value="{{$market_sms_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="market_sms_price" />
												
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												<div class="errorTxtSms text-danger"></div>
											</form>
											</div>
											<div class="col-md-4">
												<div class="title">Postcard</div>
												<form method="post" id="postcardPriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
												@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="market_postcard_price" value="{{$market_postcard_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="market_postcard_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												<div class="errorTxtPostcard text-danger"></div>
											</form>
											</div>
											<div class="col-md-4">
												<div class="title">Custom Postcard</div>
												<form method="post" id="customPostcardPriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
												@csrf
												<div class="form-group d-flex">
													<input class="form-control req" name="custom_postcard_price" value="{{$custom_postcard_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
													<input class="form-control" type="hidden" name="type" value="custom_postcard_price" />
													<button type="submit" class="btn btn-primary ml-3">Save</button>
												</div>
												<div class="errorTxtCustomPostcard text-danger"></div>
												</form>
											</div>
											</div>
											</div>
										</div>
										</div>
										</div>
										</div>
									</div>
								<!--tab end-->
								</div>
								<!--tab-content end-->	
							</div>
							 <!--row end-->	
                            </div>
							 <!--inside end-->
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
		
		
         $('#purchaseRecordForm').validate({
            rules: {
                purchase_record_price:{
                    required:true
                }
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
			
            wrapper: 'span'
        }); 
		$('#expenseTargetForm').validate({
            rules: {
                expense_target:{
                    required:true,
					//number:true
                }
            },
            
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });
		
		$('#marketEmailPriceForm').validate({
            rules: {
                market_email_price:{
                    required:true,
					//number:true
                }
            },
            errorElement : 'div',
			errorLabelContainer: '.errorTxtMarketemail'
        });
		$('#smsPriceForm').validate({
            rules: {
                market_sms_price:{
                    required:true,
					//number:true
                }
            },
            errorElement : 'div',
			errorLabelContainer: '.errorTxtSms'
        });
		$('#postcardPriceForm').validate({
            rules: {
                market_postcard_price:{
                    required:true,
					//number:true
                }
            },
			errorElement : 'div',
			errorLabelContainer: '.errorTxtPostcard'
        });
		$('#customPostcardPriceForm').validate({
            rules: {
                custom_postcard_price:{
                    required:true,
					//number:true
                }
            },
			errorElement : 'div',
			errorLabelContainer: '.errorTxtCustomPostcard'
        });
    }); 
    $("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 2000 );
		$(":input").inputmask();
    });
   
</script>   
@endsection