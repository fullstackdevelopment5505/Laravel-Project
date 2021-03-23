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
                    <form method="post" id="revenueTargetForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/targets') }}" style="width:96%">
                        @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
                                <div class="page-header">
                                <div class="title">Targets</div>
                                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="hr-success" />
                                </div>
                                <div class="page-header">
                                    <div class="title">Revenue</div>
                                    <hr class="dashed">
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Annual Target Amount</div>
                                            <!-- <input class="form-control req" type="text" name="revenue_target" value="{{$targets_arr['revenue_target']}}" /> -->
											<input class="form-control req" name="revenue_target" value="{{$targets_arr['revenue_target']}}" data-inputmask="'alias': 'currency'" style="text-align: right;">
                                        </div>
                                    </div>
									<div class="col-sm-3">
										<input class="form-control" type="hidden" name="type" value="add_revenue_target" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
                                    <!--div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Period</div>
											<select class="form-control" name="revenue_target_period">
											<option value="">Select Period</option>
											<option value="monthly" @if ($targets_arr['revenue_target_period'] =='monthly') selected @endif>Monthly</option>
											<option value="anually" @if ($targets_arr['revenue_target_period'] =='anually') selected @endif>Annually</option>
                                            </select>
                                        </div>
                                    </div-->
                                </div>
                                
                            </div>
                        </div>
                    </form>
					 <!--table end-->
                    <form method="post" id="expenseTargetForm" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/targets') }}" style="width:96%">
                        @csrf
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
								<div class="page-header">
                                <div class="title">Targets</div>
                                <hr style="height:2px;border-width:0;color:gray;background-color:gray" class="hr-success" />
                                </div>
                                <div class="page-header">
                                    <div class="title">Expense</div>
                                    <hr class="dashed">
                                </div>
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Annual Target Amount</div>
                                            <input class="form-control req" data-inputmask="'alias': 'currency'" style="text-align: right;" name="expense_target" value="{{$targets_arr['expense_target']}}" />
                                        </div>
                                    </div>
									<div class="col-sm-3">
										<input class="form-control" type="hidden" name="type" value="add_expense_target" />
										<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg">Save</button></div>
									</div>
                                    <!--div class="col-sm-3">
                                        <div class="form-group">
                                            <div class="title">Period</div>
											<select class="form-control" name="expense_target_period">
											<option value="">Select Period</option>
											<option value="monthly" @if ($targets_arr['expense_target_period'] =='monthly') selected @endif>Monthly</option>
											<option value="anually" @if ($targets_arr['expense_target_period'] =='anually') selected @endif>Annually</option>
                                            </select>
                                        </div>
                                    </div-->
                                </div>
                                
                            </div>
                        </div>
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
     var validator;
    $(function() {
        $('#revenueTargetForm').validate({
            rules: {
                revenue_target:{
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