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
								<div class="title mb-4">Add Kickstarter</div>
								<form action="/superadmin/kickstarter" method="post" id="kickstarterForm" enctype= multipart/form-data>
								<!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
								{{@csrf_field()}}
								
								<div class="alert alert-danger print-error-msg" style="display:none">
									<ul></ul>
								</div>
								<div class="row">
									<div class="col-md-4">
										<div class="form-group">
											<label>Name</label>
											<input type="hidden" name="kickstart_id" class="form-control" id="kickstart_id">
											<input type="hidden" name="url" class="form-control" >
											<input type="text" id="name" name="name" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="row">
											<div class="col-sm-9">
												<div class="form-group">
													<label>Profile Image</label>
													<input type="file" class="form-control" name="kickstart_image" id="̥" />
												</div>
											</div>
											<div class="col-sm-3 kick_img">
												<img style="display: none" src="#">
											</div>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Email Id</label>
											<input type="email" name="email" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Phone No</label>
											<input type="text" name="phone" id="phone" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Address</label>
											<input type="text" name="address" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Country</label>
											<input type="text" name="country" value="US" readonly="readonly" class="form-control">
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>State</label>
											<select id="state" name="state" class="form-control">
												<option value="" selected="selected" >Select State</option>
												<optgroup>
													@foreach($states as $key=>$value)
													<option value="{{$value->id}}">{{$value->state_name}}</option>
													@endforeach
												</optgroup>
											 </select>
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>City</label>
											<select id="city" name="city" class="form-control">
												<option value="" selected="selected">Select City</option>
											 </select>
											 
										</div>
									</div>
									<div class="col-md-4">
										<div class="form-group">
											<label>Postal Code</label>
											<input type="text" id="postal_code" name="postal_code" class="form-control">
										</div>
									</div>
									<div class="col-sm-12">
										<div class="form-group">
											<label>Description</label>
											<textarea class="form-control" name="description" rows="8"></textarea>
										</div>
									</div>
									<div class="col-sm-12 d-flex">
										<button type="button" id="save_button" class="btn btn-success btn-submit save_button mr-2">Save</button>
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

    var validator;
	$(document).ready(function () {
		$('#phone').usPhoneFormat({
			format: '(xxx) xxx-xxxx',
		});
        $('#postal_code').usZipFormat({
			format: 'xxxxx-xxxx',
		});
	});
    $(function() {
		
        validator = $('#kickstarterForm').validate({
            rules: {
                name:{
                    required:true,
                    alpha: true
                },
                email:{
                    required:true,
                    email: true,
                    remote: {
                        url: "{{route('superadminKickstarterVarifyemail')}}",
                        type: "GET",
                        async: false,
                        data: {
                            email: function () {
                                return $("input[name='email']").val();
                            },
                            id: function () {
                                return $("input[name='kickstart_id']").val();
                            },
                        }
                    
                    }

                },
                phone:{ 
                    required:true,
                    phoneUS: true
                } ,
                address:{
                    required:true

                },
                kickstart_image: {
                    accept:"image/jpeg,image/png",
                    filesize_max: 300000
                
                },
                state:{
                    required:true
                },
                postal_code:{
                    required:true,
                    zipCodeValidation: true
                },
                city:{
                    required:true
                }
            },
            messages: {
                phone:{
                        required:"Please enter a mobile number ",
                        digits: "Please enter only numbers",
                        minlength:"Please put 10  digit mobile number",
                        maxlength:"Please put 10  digit mobile number",
                },
                kickstart_image: {
                    filesize_max:" file size must be less than 250 KB.",
                    accept: "Please upload file in these format only (jpg, jpeg, png)."
                },
                name:{
                    required:"Please enter name"
                },
                email:{
                    remote: "Email id already registred",
                    required:"Please enter email"
                }
            },
            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
        });

        $.validator.addMethod("filesize_max", function(value, element, param) {
            var isOptional = this.optional(element),
                file;
            
            if(isOptional) {
                return isOptional;
            }
            
            if ($(element).attr("type") === "file") {
                
                if (element.files && element.files.length) {
                    
                    file = element.files[0];            
                    return ( file.size && file.size <= param ); 
                }
            }
            return false;
        }, "File size is too large.");

        $.validator.addMethod("zipCodeValidation", function() {
            var zipCode = $("input[name='postal_code']").val();
            return (/(^\d{5}$)|(^\d{5}-\d{4}$)/).test(zipCode); // returns boolean
        }, "Please enter a valid US zip code either 5 or 9 digits.");

		$.validator.addMethod("phoneUS", function(phone, element) {
			phone= phone.replace(/[^0-9]/gi, '');
			//console.log(phone);
            return this.optional(element) || phone.length == 10;
        }, "Please specify a valid US phone number");

        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
        }, "Letters only please");
		
		$.validator.addMethod("checkAmoundDifferance", function(value, element, param) {
			console.log($(element).attr("name"));
			if($(element).attr("name") == 'mortgageAmountTo' || $(element).attr("name") == 'mortgageAmountFrom'){
				mAmtTo = $("input[name='mortgageAmountTo']").val();
				mAmtFrm = $("input[name='mortgageAmountFrom']").val();
				return compareAmountBetween(parseInt(mAmtTo), parseInt(mAmtFrm));
			}
			
			if($(element).attr("name") == 'listingPriceTo' || $(element).attr("name") == 'listingPriceFrom'){
				mAmtTo = $("input[name='listingPriceTo']").val();
				mAmtFrm = $("input[name='listingPriceFrom']").val();
				return compareAmountBetween(parseInt(mAmtTo), parseInt(mAmtFrm));
			}
			
			if($(element).attr("name") == 'mortgageInterestTo' || $(element).attr("name") == 'mortgageInterestFrom'){
				mAmtTo = $("input[name='mortgageInterestTo']").val();
				mAmtFrm = $("input[name='mortgageInterestFrom']").val();
				return compareAmountBetween(parseInt(mAmtTo), parseInt(mAmtFrm));
			}
			
			if($(element).attr("name") == 'equityTo' || $(element).attr("name") == 'equityFrom'){
				mAmtTo = $("input[name='equityTo']").val();
				mAmtFrm = $("input[name='equityFrom']").val();
				return compareAmountBetween(parseInt(mAmtTo), parseInt(mAmtFrm));
			}
			
			if($(element).attr("name") == 'forclosureAmountTo' || $(element).attr("name") == 'forclosureAmountFrom'){
				mAmtTo = $("input[name='forclosureAmountTo']").val();
				mAmtFrm = $("input[name='forclosureAmountFrom']").val();
				return compareAmountBetween(parseInt(mAmtTo), parseInt(mAmtFrm));
			}
			
        }, "Invalid or missing data");

    });
	
	compareAmountBetween = function ( Amt_To, Amt_Frm){
		console.log('Amt_To=' + Amt_To + ' Amt_Frm=' + Amt_Frm);
		if (Amt_To == '' && Amt_Frm == ''){
			//console.log('both null');
			return true;
		} else if ((Amt_To != '' && Amt_Frm == '') || (Amt_To == '' && Amt_Frm != '')){
			//console.log('one null');
			return false;
		} else if (Amt_To != '' && Amt_Frm != ''){
			if(Amt_To >= Amt_Frm){
				//console.log('to > from');
				return true;
			} else {
				//console.log('to < from');
				return false;
			}
			return true;
		}
	}

    window.getCities = function(sid,city){
		$('#loader').show();		
        $.ajax({
            type:"get",
            url:"{{URL('superadmin/kickstarter/getCities/')}}/"+sid,
            
            success:function(res)
            {       
                if(res)
                {
					$('#loader').hide();
                    $("#city").empty();
                    $("#city").append('<option value="">Select City</option>');
                
                    $.each(res,function(key,value){
                        if(city>0){
                            var selected ='';
                            if(city==key){
                                selected = "selected='selected'";
                            }
                        }
                        $("#city").append('<option '+selected+' value="'+key+'">'+value+'</option>');
                    });
                    return true;
                }
            }

        });
    }
    
	window.getCitiesSearch = function(sid,city){
		$('#loader').show();		
        $.ajax({
            type:"get",
            url:"{{URL('superadmin/kickstarter/getCities/')}}/"+sid,
            
            success:function(res)
            {       
                if(res)
                {
					$('#loader').hide();
                    $("#city_search").empty();
                    $("#city_search").append('<option value="">Select City</option>');
                
                    $.each(res,function(key,value){
                        if(city>0){
                            var selected ='';
                            if(city==key){
                                selected = "selected='selected'";
                            }
                        }
                        $("#city_search").append('<option '+selected+' value="'+key+'">'+value+'</option>');
                    });
                    return true;
                }
            }

        });
    }
	
	window.getCitiesByCounty = function(countyname,city,state_id){
		$('#loader').show();		
        $.ajax({
            type:"get",
            url:"{{URL('superadmin/kickstarter/getCityByCounty/')}}/"+countyname+"/"+state_id,
            
            success:function(res)
            {       
                if(res)
                {
					$('#loader').hide();
                    $("#city_search").empty();
                    $("#city_search").append('<option value="">Select City</option>');
                
                    $.each(res,function(key,value){
                        if(city>0){
                            var selected ='';
                            if(city==value){
                                selected = "selected='selected'";
                            }
                        }
                        $("#city_search").append('<option '+selected+' value="'+value+'">'+key+'</option>');
                    });
                    return true;
                }
            }

        });
    }
	
	window.getCountySearch = function(sid,county){
		$('#loader').show();		
        $.ajax({
            type:"get",
            url:"{{URL('superadmin/kickstarter/getCounties/')}}/"+sid,
            
            success:function(res)
            {       
                if(res)
                {
					$('#loader').hide();
                    $("#county_search").empty();
                    $("#county_search").append('<option value="">Select County</option>');
					
					
                    $.each(res,function(key,value){
						
                        if(county>0){
                            var selected ='';
                            if(county==value){
                                selected = "selected='selected'";
                            }
                        }
                        $("#county_search").append('<option '+selected+' data-val="'+key+'" value="'+value+'">'+key+'</option>');
                    });
                    return true;
                }
            }

        });
    }
    
	//On Load functions
    $(document).ready(function() {
		
        //get all states
        $('#state').change(function(){
            var sid = $(this).val();
            if(sid){
                getCities(sid,0);
            }else{ 
				$("#city").empty();
				$("#city").append('<option value="">Select City</option>');
			}
        }); 


        
       
        		
    });

    //Save user
    $('.btn-submit').click(function(){
        if($("#kickstarterForm").valid()){ 
			$('#loader').show();
            var button_id = $(this).attr("id");
            var _token      =  $("input[name='_token']").val();
            var name        = $("input[name='name']").val();
            var email       = $("input[name='email']").val();
            var phone       = $("input[name='phone']").val();
            var state       = $('select[name="state"]').val();
            var city        = $('select[name="city"]').val();
            var country     = $('input[name="country"]').val();
            var postal_code = $("input[name='postal_code']").val();
            var address      = $("input[name='address']").val();
            var description = $("textarea[name='description']").val();
            var kickstart_id      = $("input[name='kickstart_id']").val();
             var url = "{{url('superadmin/kickstarter/')}}";
            //var url = $("input[name='url']").val();
            var formData = new FormData($("#kickstarterForm")[0]);
            $.ajax({
                url: url,
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                processData: false,
                contentType: false,
                data: formData,
                success: function(data) {
                    if($.isEmptyObject(data.error)){
						$('#loader').hide();
                        alert(data.success);
                        jQuery('.alert-danger').hide();
                        $('#open').hide();
                        $('#createKickstarterModal').modal('hide');
                        location.reload();
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
	
</script> 
@endsection