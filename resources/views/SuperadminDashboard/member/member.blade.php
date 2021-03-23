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
					<!-- Non Member start -->
					<div class="col-sm-6 top_selling customer_search active_now">
						<form class="" action="{{ URL('/superadmin/memberSearch/') }}" method="post" id="formSearchMember">
							{{@csrf_field()}}
							<div class="inside">
								<div class="title mb-4">Search By Customer
									<label>
										<input type="radio" name="a" checked="checked">
										<span></span>
									</label>
								</div>
								<div class="row">
									<div class="col-sm-12">
									<div class="errorTxt"></div>
										<div class="form-group">
											<label>State</label>
											<select id="state" name="state" class="send form-control">
												<option value="" selected="selected">Select State</option>
												<optgroup>
											
													@foreach($states as $key=>$value)
													<option data-id="{{$value->state_val}}" value="{{$value->state_val}}">{{$value->state_name}}</option>
													@endforeach
												</optgroup>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>City</label>
											<select id="city" name="city" class="send form-control">
												<option value="" selected="selected">Select City</option>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Postal Code</label>
											<input type="text"  name="postal_code" class="send postal_code form-control">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<h2>Joining Date</h2>
											<div class="row">
												<div class="col-sm-6">
													<label>From:</label>
													<input type="text" autocomplete="off" id="date_from" name="membership_start_date_from" class="membership_start_date_from send form-control">
												</div>
												<div class="col-sm-6">
													<label>To:</label>
													<input type="text" autocomplete="off" id="date_to"  name="membership_start_date_to" class="membership_start_date_to send form-control">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<input type="hidden" name="type" value="1" />
										<input type="submit" id="search_submit" value="Search Result" class="btn btn-success btn-submit">
										<input type="reset" value="Reset" class="btn btn-danger">
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- Non Member end -->

					<!-- Non Member start -->
					<div class="col-sm-6 top_selling customer_search disable_now">
						<form class="" action="{{ URL('/superadmin/memberSearch/') }}"  method="post" id="formSearchMemberNon">
							{{@csrf_field()}}
							<div class="inside">
								<div class="title mb-4">Search By Prospect
									<label>
										<input type="radio" name="a">
										<span></span>
									</label>
								</div>
								<div class="row">
									<div class="col-sm-12">
										<div class="errorTxtN"></div>
										<div class="form-group">
											<label>State</label>
											<select id="state_non" name="state" class="sendN form-control">
												<option value="" selected="selected" >Select State</option>
												<optgroup>
													@foreach($states as $key=>$value)
													<option data-id="{{$value->state_val}}" value="{{$value->state_val}}">{{$value->state_name}}</option>
													@endforeach
												</optgroup>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>City</label>
											<select id="city_non" name="city" class="sendN form-control">
												<option value="" selected="selected">Select City</option>
											</select>
										</div>
									</div>
									<div class="col-sm-12">
									<div class="form-group">
										<label>Postal Code</label>
										<input type="text" name="postal_code" class="sendN form-control">
									</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<h2>Joining Date</h2>
											<div class="row">
												<div class="col-sm-6">
													<label>From:</label>
													<input type="text" autocomplete="off" id="date_from_non" name="membership_start_date_from" class="sendN form-control">
												</div>
												<div class="col-sm-6">
													<label>To:</label>
													<input type="text" autocomplete="off" id="date_to_non" name="membership_start_date_to" class="sendN form-control">
												</div>
											</div>
										</div>
									</div>
									<div class="col-sm-12">
										<input type="hidden" name="type" value="0" />
										<input type="submit" id="search_submit_non" value="Search Result" class="btn btn-success btn-submit">
										<input type="reset" value="Reset" class="btn btn-danger">
									</div>
								</div>
							</div>
						</form>
					</div>
					<!-- Non Member end -->
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
		$(function() {
			$('#date_from').datepicker({
				beforeShow: customRange,
				dateFormat: "mm/dd/yy",
				firstDay: 1,
				maxDate: 'now',
				changeFirstDay: false
			});
			$('#date_to').datepicker({
				beforeShow: customRange,
				dateFormat: "mm/dd/yy",
				firstDay: 1,
				changeFirstDay: false
			});
			$('#date_from_non').datepicker({
				beforeShow: customRange,
				dateFormat: "mm/dd/yy",
				firstDay: 1,
				maxDate: 'now',
				changeFirstDay: false
			});
			$('#date_to_non').datepicker({
				beforeShow: customRange,
				dateFormat: "mm/dd/yy",
				firstDay: 1,
				changeFirstDay: false
			});
		});

		function customRange(input) {
			var min = null, // Set this to your absolute minimum date
				dateMin = min,
				dateMax = null;
				if (input.id === "date_from" || input.id === "date_from_non") {
					console.log("start time");
					dateMax = 'now';	
				}
				if (input.id === "date_to_non") {
					dateMin = $('#date_from_non').datepicker('getDate');
					dateMax = null;
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
		

		window.getCities = function(sid,city_id,city){ 
			$.ajax({
				type:"get",
				url:"{{URL('superadmin/kickstarter/getCities/')}}/"+sid,
				
				success:function(res)
				{       
					if(res)
					{
						 $(city_id).empty();
						$(city_id).append('<option value="">Select City</option>');
					//console.log(res);
						$.each(res,function(key,value){
							if(city>0){
								var selected ='';
								if(city==key){
									selected = "selected='selected'";
								}
							}
							$(city_id).append('<option '+selected+' value="'+key+'">'+value+'</option>');
						});
						return true;
					}
				}

			});
		}
		/* window.addEventListener('beforeunload', function (e) {
			e.preventDefault();
			$.session.remove('clicked_form');
		}); */
		
                                                 
		$(function() {
			console.log( "ready!" );
			console.log($.session.get('clicked_form'));
			var formId = $.session.get('clicked_form');
			$("#"+formId).parents('.customer_search').addClass('active_now');
			$("#"+formId).parents('.customer_search').find('.inside .title input').prop("checked", true);

			$("#"+formId).parents('.customer_search').nextAll('.customer_search').find('.inside .title input').prop("checked", false);
			$("#"+formId).parents('.customer_search').prevAll('.customer_search').find('.inside .title input').prop("checked", false);

			$("#"+formId).parents('.customer_search').nextAll('.customer_search').removeClass('active_now').addClass('disable_now');
			$("#"+formId).parents('.customer_search').prevAll('.customer_search').removeClass('active_now').addClass('disable_now');
			
		});

		$(document).ready(function () {
			
			/* $('#formSearchMemberNon').validate({ // initialize the plugin
				groups: {
					names: "state city postal_code membership_start_date_from membership_start_date_to"
				},
				rules: {
					state: {
						require_from_group: [1, ".sendN"]
					},
					city: {
						require_from_group: [1, ".sendN"]
					},
					postal_code: {
						require_from_group: [1, ".sendN"]
					},
					membership_start_date: {
						require_from_group: [1, ".sendN"]
					},
					membership_end_date: {
						require_from_group: [1, ".sendN"]
					}
				},
				errorElement : 'div',
    			errorLabelContainer: '.errorTxtN'
			});

			$('#formSearchMember').validate({ // initialize the plugin
				groups: {
					names: "state city postal_code membership_start_date_from membership_start_date_to"
				},
				rules: {
					state: {
						require_from_group: [1, ".send"]
					},
					city: {
						require_from_group: [1, ".send"]
					},
					postal_code: {
						require_from_group: [1, ".send"]
					},
					membership_start_date: {
						require_from_group: [1, ".send"]
					},
					membership_end_date: {
						require_from_group: [1, ".send"]
					}
				},
				errorElement : 'div',
    			errorLabelContainer: '.errorTxt'
			});

			jQuery.extend(jQuery.validator.messages, {
				require_from_group: jQuery.format("Please enter atleast one field to search.")
			}); */

		});
		

		$(document).ready(function() {
			
			$('#state,#state_non').change(function(){
				var sname = $(this).val();
				var sid = $(this).find(':selected').data("id");
				var e1 =  $(this).attr("id");
				city_id = "#city";
				if(e1=="state_non"){
					city_id="#city_non";
				}
				if(sid){
					getCities(sid,city_id,0);
				}else{
					$("#city").empty();
				$("#city").append('<option value="">Select City</option>');
				}
				
					
				
			}); 
		
			$('#formSearchMember,#formSearchMemberNon').on('submit', function (e){
				var $form = $(this);
				var id = $form.attr('id');
				$.session.set('clicked_form',id)	
			});

		});

	</script>
@endsection