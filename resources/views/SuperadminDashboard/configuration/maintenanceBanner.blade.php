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
                        <?php 
                            //print_r($data1); die;
                        ?>
                    </div>
                    
                   
                        <!--table-start -->
                        <div class="col-sm-12 top_selling">
                            <div class="inside">
							<form method="post" id="maintenance_form" enctype="multipart/form-data" action="{{ URL('/superadmin/configuration/maintenance-banner') }}">
							  @csrf
                                <div class="title">Maintenance Banner</div>
									<div class="row">
										<div class="col-sm-6">
											<div class="title">Maintenance Mode</div>
											<div class="form-group">   
												<select name="status" class="form-control">
												<option value="0" <?php echo $content_arr['status'] == 0 ? "selected='selected'" :'' ?> >Off</option>
												<option value="1" <?php echo $content_arr['status'] == 1 ? "selected='selected'" :'' ?>>ON</option>
												</select>
											</div>   
										</div>
                                    </div>
									<div class="row">
                                    <div class="col-sm-6">
										<div class="title">Title</div>
                                        <div class="form-group">   
                                            <textarea class="form-control" name="maintenance_banner_title" rows="2" cols="50">{{$content_arr['maintenance_banner_title']}}</textarea>
                                        </div>   
                                    </div>
                                    </div>
									<div class="row">
                                    <div class="col-sm-6">
										<div class="title">Content</div>
                                        <div class="form-group">   
                                            <textarea class="form-control" name="maintenance_banner_content" rows="3" cols="70">{{$content_arr['maintenance_banner_content']}}</textarea>
                                        </div>   
                                    </div>
                                    </div>
									<div class="row">
										<div class="col-sm-6">
											<div class="title">Schedule Timeline</div> 
											<div class="row">
											
												<div class="col-sm-6">
													<div class="form-group">
														<label>Date From:</label>
														<input type="text" class="form-control datepickerSuper" placeholder="start date" name="start_date" id="date_from" value="{{$content_arr['start_date']}}" autocomplete="off" >
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Date To:</label>
														<input type="text" name="end_date" class="form-control datepickerSuper" placeholder="end date" id="date_to" value="{{$content_arr['end_date']}}" autocomplete="off" >
													</div>
												</div>
											</div>
											<div class="row" id="datepairExample">
											
												<div class="col-sm-6">
													<div class="form-group">
														<label>Time From:</label>
														<input type="text" class="form-control time start"  placeholder="start time" name="start_time" value="{{$content_arr['start_time']}}" /> 
													</div>
												</div>
												<div class="col-sm-6">
													<div class="form-group">
														<label>Time To:</label>
														<input type="text" class="form-control time end"  placeholder="end time" name="end_time" value="{{$content_arr['end_time']}}" />
													</div>
												</div>
											</div>
												
										</div>
                                    </div>
								
								<div class="row">
									<div class="col-sm-6">   
									<div class="reply_cta mt-4"><button type="submit" class="btn btn-primary btn-lg text-center">Save</button></div>
									</div>
								</div>
							</form>	
                            </div>                    
                        </div>
                        
                        </div>
                        <!--table-end-->
                </div>
            </div>
            <!-- inside_content_area end-->
        </section>
        <!-- right area end -->
    </div>
    <!-- main div end -->
    
@endsection
@section('page_js')

<script src="//jonthornton.github.io/jquery-timepicker/jquery.timepicker.js"></script>
<script type="text/javascript" src="{{asset('assets/superadmin/js/datepair.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/superadmin/js/jquery.datepair.js')}}"></script>
<script>
	// initialize input widgets first
	$('#datepairExample .time').timepicker({
		'showDuration': true,
		'timeFormat': 'h:i A'
	});
$('#datepairExample .date').datepicker({
		'format': 'yyyy-m-d',
		'autoclose': true
	});
	// initialize datepair
	$('#datepairExample').datepair();
</script>
<script>

	$(function() {

		$('#date_from').datepicker({
			//beforeShow: customRange,
			dateFormat: "dd-M-yy",
			firstDay: 1,
			changeFirstDay: false,
			onSelect	: function() {
				 $('#date_to').val("");
			}
		});
		$('#date_to').datepicker({
			beforeShow: customRange,
			dateFormat: "dd-M-yy",
			firstDay: 1,
			changeFirstDay: false
		});
	});

	function customRange(input) {
		var min = null, // Set this to your absolute minimum date
			dateMin = min,
			dateMax = null;
			if (input.id === "date_from") {
				//console.log("start time");
				//dateMax = 'now';	
			}
			if (input.id === "date_to") {
				dateMin = $('#date_from').datepicker('getDate');
				dateMax = null;
				
				//if ($('#startdatepicker').datepicker('getDate') != null) { dateMax = 'now'; }
			}
		
		return {
			minDate: dateMin,
			maxDate: dateMax
		};
	}

	$('.datepickerSuper').datepicker('widget').delegate('.ui-datepicker-close', 'mouseup', function() {
		var inputToBeCleared = $('.datepicker').filter(function() { 
		return $(this).data('pickerVisible') == true;
		});    
		$(inputToBeCleared).val('');
	});
var validator;
	$(document).ready(function () {
		$.validator.addMethod("time", function(value, element) {
				return this.optional(element) || /^([01][0-9])|(2[0123]):([0-5])([0-9])$/.test(value);
			}, "Please enter a valid time, between 00:00 and 23:59"
		);
		validator = $("#maintenance_form").validate({
			rules: {
				maintenance_banner_title:{
					required:true,
				},
				maintenance_banner_content:{
					required:true,
				},
				start_date:{
					required:true,
				},
				end_date:{
					required:true,
				},
				start_time:{
					required:true,
				},
				end_time:{
					required:true,
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
        }, 5000 );
    });
</script>   
@endsection   