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
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">API</div>
									<table class="display responsive nowrap" id="switch-table" width="100%">
										<thead>
											<tr>
												<th>Sr No.</th>
												<th>Name</th>
												<th>Secret Key</th>
												<th>Status</th>
											</tr>
										</thead>
										<tbody>
											<tr>
												<td>1</td>
												<td>Data Tree</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_datafincer">Show Secret key</button></td>
												<td>
												
												<div class="live_and_test {{$data['datatree']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="datatree" />
												</td>
											</tr>
											<tr>
												<td>2</td>
												<td>Data Finder</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_datafinder">Show Secret key</button></td>
												<td>
												<div class="live_and_test {{$data['datafinder']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="datafinder" /></td>
											</tr>
											<tr>
												<td>3</td>
												<td>Accurate Append Key</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_accurateappend">Show Secret key</button></td>
												<td><div class="live_and_test {{$data['accurate_append']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="accurate_append" />
												</td>
											</tr>
											<tr>
												<td>4</td>
												<td>Send Grid</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_sendgrid">Show Secret key</button></td>
												<td><div class="live_and_test {{$data['sendgrid']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="sendgrid" /></td>
											</tr>
											<tr>
												<td>5</td>
												<td>Paypal Mass API</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_paypal">Show Secret key</button></td>
												<td><div class="live_and_test {{$data['paypal']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="paypal" /></td>
											</tr>
											<tr>
												<td>6</td>
												<td>Thanks.io(postcard)</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_postcard">Show Secret key</button></td>
												<td><div class="live_and_test {{$data['postcard']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="thanksio" /></td>
											</tr>
											<tr>
												<td>7</td>
												<td>Twilio(SMS)</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_twilio">Show Secret key</button></td>
												<td><div class="live_and_test {{$data['twilio']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="twilio" /></td>
											</tr>
											<tr>
												<td>8</td>
												<td>Stripe</td>
												<td><button class="btn btn-success" data-toggle="modal" data-target="#show_api_stripe">Show Secret key</button></td>
												<td><div class="live_and_test {{$data['stripe']['toggle_class']}}"></div>
												<input type="hidden" class="api_type" name="api_type" value="stripe" /></td>
											</tr>
										</tbody>
									</table>
							</div>
						</div>
                        <!--table end -->
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
   <!-- popup start from here-->
   <div class="modal" id="show_api_datafincer">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['datatree']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>username </h6>
					<p>{{$data['datatree']['dtapi_auth_password']}}</p>
					<h6>password </h6>
					<p>{{$data['datatree']['dtapi_auth_password']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
	
	<div class="modal" id="show_api_datafinder">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['datafinder']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>Key </h6>
					<p>{{$data['datafinder']['datafinder_key']}}</p>
					<h6>Token </h6>
					<p>{{$data['datafinder']['datafinder_token']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
	
	<div class="modal" id="show_api_accurateappend">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['accurate_append']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>Key </h6>
					<p>{{$data['accurate_append']['accurate_append_key']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
	<div class="modal" id="show_api_sendgrid">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['sendgrid']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>Key </h6>
					<p>{{$data['sendgrid']['key']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
    <div class="modal" id="show_api_paypal">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['paypal']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>username </h6>
					<p>{{$data['paypal']['username']}}</p>
					<h6>password </h6>
					<p>{{$data['paypal']['password']}}</p>
					<h6>secret </h6>
					<p>{{$data['paypal']['secret']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
    <div class="modal" id="show_api_postcard">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['postcard']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>Token </h6>
					<p>{{$data['postcard']['token']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
	<div class="modal" id="show_api_twilio">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['twilio']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>SID </h6>
					<p>{{$data['twilio']['sid']}}</p>
					<h6>Token </h6>
					<p>{{$data['twilio']['token']}}</p>
					<h6>From number </h6>
					<p>{{$data['twilio']['from_number']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
	<div class="modal" id="show_api_stripe">
	  <div class="modal-dialog modal-lg">
		<div class="modal-content">

		  <div class="modal-header">
			<h5 class="modal-title">{{$data['stripe']['title']}}</h5>
			<button type="button" class="close" data-dismiss="modal">&times;</button>
		  </div>

		  <div class="modal-body">
			<div class="row">
				<div class="col-md-12 d_finder">
					<div class="user_finder bg-light p-3 border border-secondary">
					<h6>key </h6>
					<p>{{$data['stripe']['key']}}</p>
					</div>
					<!--p class="h6 bg-light p-3 border border-secondary mt-3">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</p-->
				</div>
			</div>
		  </div>

		</div>
	  </div>
	</div>
	<!-- popup end here-->
@endsection
@section('page_js')
<script>
	$(document).ready( function () {
		$('#switch-table').DataTable();
	} );
	$('.live_and_dive').click(function(){
		
		$(this).toggleClass('change');
		$('#dive').fadeToggle(100);
		$('#live').fadeToggle(100);
	});
	 $(document).on('click', '.live_and_test', function (e) {
		current = $(this);
		
		var api_type = $(this).closest('tr').find('.api_type').val();
		if($(this).hasClass('live')){
			mode = 0;
			mode_text = 'Test';
		}else{
			mode 	 = 1;
			mode_text = 'Live';
		}
		// $('#live').fadeToggle(100);
        swal({
               customClass:'api_toggle_alert',	  
				title: "Are you sure?",
				text: "Would you like to change it to "+mode_text+" mode.",
				imageUrl : "{{asset('assets/images/question-mark.svg')}}",
				showCancelButton: true,   confirmButtonColor: "#DD6B55",
				confirmButtonText: "OK",
            },
        function() {
            $.ajax({
                type: "GET",
                url: "{{route('superadminConfigAjaxRequest')}}",
                data: { api_mode: mode, enabled_mode: mode_text, api_type: api_type,type: "change_mode" },
                success: function(data){
                    
                    if($.isEmptyObject(data.error)){
                        
                        current.toggleClass('change');
						current.toggleClass('live');
						$(data.model_id).find('.d_finder').html(data.html);
						$(data.model_id).find('.modal-title').text(data.title);
			
                    }else{
                        
                        alert(data.error);
                    }

                }       
            }); 
        }); 
    });
</script>
@endsection