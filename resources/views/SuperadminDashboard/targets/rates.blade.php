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
                                <div class="page-header">
                                <div class="title">Records</div>
                                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="hr-success" />
                                </div>
								<form method="post" id="membershipPricetForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
								@csrf
								<div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Membership</div>
											<input class="form-control req" name="membership_price" value="{{$membership->amount}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
                                        </div>
                                    </div>
									<div class="col-sm-3">
										<input class="form-control" type="hidden" name="type" value="membership_price" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
                                </div>
								</form>
                               <form method="post" id="purchaseRecordForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
								@csrf
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Property Record</div>
											<input class="form-control req" id="purchase_record_price" name="purchase_record_price" value="{{$purchase_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;" >
                                        </div>
                                    </div>
									<div class="col-sm-3">
										<input class="form-control" type="hidden" name="type" value="purchase_record_price" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
                                </div>
								</form>
								<form method="post" id="propertyreporttForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
								@csrf
								<div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Property Detail Report</div>
											<input class="form-control req" name="property_report_price" value="{{$property_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
                                        </div>
                                    </div>
									<div class="col-sm-3">
										<input class="form-control" type="hidden" name="type" value="property_report_price" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
                                </div>
								</form>
								
								
								<form method="post" id="emailPriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
								@csrf
								<div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Email</div>
											<input class="form-control req" name="email_price" value="{{$email_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
                                        </div>
                                    </div>
									<div class="col-sm-3">
										<input class="form-control" type="hidden" name="type" value="email_price" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
                                </div>
                                </form>
								
								<form method="post" id="phonePriceForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/rates') }}" style="width:96%">
								@csrf
								<div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Mobile Number</div>
											<input class="form-control req" name="phone_price" value="{{$phone_price}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
                                        </div>
                                    </div>
									<div class="col-sm-3">
										<input class="form-control" type="hidden" name="type" value="phone_price" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
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
 
    }); 
    $("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 2000 );
		
		$(":input").inputmask();
		
    });
   
</script>   
@endsection