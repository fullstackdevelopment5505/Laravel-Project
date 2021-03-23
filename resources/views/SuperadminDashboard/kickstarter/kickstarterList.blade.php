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
                            <div class="inside">
                                <table class="display responsive nowrap" id="kickstart_table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr No</th>
                                            <th>Name</th>
                                            <th>Profile Image</th>
                                            <th>Email</th>
                                            <th>Phone Number</th>
                                            <th>Add Serach Parameters</th>
                                            <th>action</th>

                                        </tr>
                                    </thead>

                                </table>
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

    <!-- popup start from here-->
    <div class="modal fade" id="createKickstarterModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><b>Add New Kickstarter</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/superadmin/kickstarter" method="post" id="kickstarterForm" enctype= multipart/form-data>
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body register_new_user">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Name</label>
                                <input type="hidden" name="kickstart_id" class="form-control" id="kickstart_id">
                                <input type="hidden" name="url" class="form-control" >
                                <input type="text" id="name" name="name" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="row">
                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label>Profile Image</label>
                                        <input type="file" class="form-control pt-2" name="kickstart_image" id="̥" />
                                    </div>
                                </div>
                                <div class="col-sm-3 kick_img">
                                    <img style="display: none" src="#">
                                </div>
                            </div>
                        </div>
                        <!-- <div class="col-sm-6">
                            <div class="form-group">
                                <label>Email Id</label>
                                <input type="email" name="email" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Phone No</label>
                                <input type="text" name="phone" id="phone" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Address</label>
                                <input type="text" name="address" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Country</label>
                                <input type="text" name="country" value="US" readonly="readonly" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
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
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>City</label>
                                <select id="city" name="city" class="form-control">
                                    <option value="" selected="selected">Select City</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Postal Code</label>
                                <input type="text" id="postal_code" name="postal_code" class="form-control">
                            </div>
                        </div>punch remove -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Description</label>
                                <textarea class="form-control" name="description" rows="4"></textarea>
                            </div>
                        </div>
                        <!-- punch start-->
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Add Search</label>
                                <select id="addSearch" name="addSearch" class="form-control">
                                    <option value="" selected="selected" >Select Search</option>
                                    <optgroup>
                                        <!-- @foreach($states as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->state_name}}</option>
                                        @endforeach -->
                                        <option value="Mikee">Mikee</option>
                                    </optgroup>
                                 </select>
                            </div>
                        </div>
                        <!-- punch end-->
                    </div>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0">
                        <button type="button" id="save_button" class="btn btn-success btn-submit save_button">Add</button>
                        <button type="button" id="update_button" style="display:none;" class="btn btn-success btn-submit update_button">Update</button>
                        <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- popup end here-->

	<!-- popup start from here-->
    <div class="modal fade" id="addSearchModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><b>Advance Search Parameters</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="{{URL('superadmin/kickstarter/SaveSearch')}}" method="post" id="searchForm" enctype= multipart/form-data>
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body register_new_user">
                    <div class="alert alert-danger print-error-msg" style="display:none">
                        <ul></ul>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 main_fields_title">State & County Bundle</div>
						<div class="col-sm-12">
                            <div class="form-group">
                                <label>State</label>
                                <select id="state_search" name="state" class="form-control">
                                    <option value="" selected="selected" >Select State</option>
                                    <optgroup>
                                        @foreach($states as $key=>$value)
                                        <option value="{{$value->id}}">{{$value->state_name}}</option>
                                        @endforeach
                                    </optgroup>
                                 </select>
                            </div>
                        </div>
						<div class="col-sm-6">
                            <div class="form-group">
                                <label>County Select</label>
                                <select id="countySelect" name="countySelect" class="form-control">
                                    <option value="is">Is</option>
									<option value="is not">Is Not</option>
                                 </select>

                            </div>
                        </div>
						<div class="col-sm-6">
                            <div class="form-group">
                                <label for="county" class="w-100">County</label>
                                <select id="county_search" name="county[]" class="js-example-basic-multiple js-county form-control w-100" multiple="multiple" style="width: 100%;">
                                    <option value=""></option>
                                 </select>

                            </div>
                        </div>
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="w-100">City Select</label>
                                <select id="citySelect" name="citySelect" class="form-control" style="width: 100%;">
                                    <option value="is">Is</option>
									<option value="is not">Is Not</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label for="county" class="w-100">City</label>
                                <select id="city_search" name="city[]" class="js-example-basic-multiple js-city form-control" multiple="multiple"  style="width: 100%;">
                                    <option value="" selected="selected">Select City</option>
                                 </select>

                            </div>
                        </div>
						<div class="col-sm-6">
                            <div class="form-group">
                                <label class="w-100">Zip Select</label>
                                <select id="zipSelect" name="zipSelect" class="form-control" style="width: 100%;">
                                    <option value="is">Is</option>
									<option value="is not">Is Not</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Zip</label>
                                <input type="text" id="zipcode" name="zipcode" class="form-control" placeholder="zip">
                            </div>
                        </div>

                        <div class="col-sm-12 main_fields_title mt-4">Characteristics</div>
						<div class="col-sm-12">
                            <div class="form-group">
                                <label  for="land" class="w-100">Land use</label>
                                <select id="land" name="land[]" class="js-example-basic-multiple js-land form-control" multiple="multiple" style="width: 100%;">
                                    <option value="163;SFR">SFR</option>
									<option value="133;Multi-family">Multi-family</option>
									<option value="112;Condominium">Condominium</option>
									<option value="102;Townhouse">Townhouse</option>
                                 </select>

                            </div>
                        </div>


                        <div class="col-sm-12 main_fields_title mt-4">Owner</div>
						<div class="col-sm-6">
                            <div class="form-group">
                                <label for="exemption" class="w-100">Exemption</label>
                                <select id="exemption" name="exemption[]" class="js-example-basic-multiple js-exemption form-control" multiple="multiple"style="width: 100%;">
                                    <option value="3;Homestead">Homestead</option>
									<option value="2;Disabled">Disabled</option>
									<option value="11;Veteran">Veteran</option>
									<option value="9;Senior Citizen">Senior Citizen</option>
                                 </select>

                            </div>
                        </div>

						<div class="col-sm-6">
                            <div class="form-group">
                                <label for="occupancy" class="w-100">Occupancy</label>
                                <select id="occupancy" name="occupancy[]" class="js-example-basic-multiple js-occupancy form-control" multiple="multiple" style="width: 100%;">
                                    <option value="O;Owner">Owner</option>
									<option value="A;Absentee">Absentee</option>
                                 </select>

                            </div>
                        </div>


                        <div class="col-sm-12 main_fields_title mt-4">Sale Information</div>
						<div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Last Sale Recording Date</label>
                                <select id="saleSelect" name="saleSelect" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4  mt-4">
                            <div class="form-group">

                                <input type="text" id="salesFrom" name="salesFrom" class="form-control" placeholder="dd-mmm-yy">
                            </div>
                        </div>

                       <div class="col-sm-4  mt-4">
                            <div class="form-group">

                                <input type="text" id="salesTo" name="salesTo" class="form-control" placeholder="dd-mmm-yy">
                            </div>
                        </div>


                        <div class="col-sm-12 main_fields_title mt-4">Open Lien Information</div>
						<div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Mortgage Amount</label>
                                <select id="mortgageAmountSelect" name="mortgageAmountSelect" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" id="mortgageAmountFrom"  name="mortgageAmountFrom" class="form-control numbersOnly" placeholder="amount">
                            </div>
                        </div>

                       <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" id="mortgageAmountTo" name="mortgageAmountTo" class="form-control numbersOnly" placeholder="amount">
                            </div>
                        </div>

						<div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Mortgage Recording Date</label>
                                <select id="mortgageRecordingDate" name="mortgageRecordingDate" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" id="mortgageRecordingFrom" name="mortgageRecordingFrom" class="form-control" placeholder="dd-mmm-yy">
                            </div>
                        </div>

						<div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" id="mortgageRecordingTo" name="mortgageRecordingTo" class="form-control" placeholder="dd-mmm-yy">
                            </div>
                        </div>
						<div class="col-sm-12">
                            <div class="form-group">
                                <label for="mortgageType" class="w-100">Mortgage Type</label>
                                <select id="mortgageType" name="mortgageType[]"  class="js-example-basic-multiple js-mortgageType form-control" multiple="multiple" style="width: 100%;">
                                    <option value="CNV;Conventional">Conventional</option>
									<option value="FHA;FHA">FHA</option>
									<option value="CON;Construction">Construction</option>
									<option value="PP;Private Party">Private Party</option>
									<option value="SBA;SBA">SBA</option>
									<option value="VA;VA">VA</option>
                                 </select>

                            </div>
                        </div>
						<div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Interest Rate Between</label>
                                <select id="mortgageInterestStatus" name="mortgageInterestStatus" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="mortgageInterestFrom" id="mortgageInterestFrom" class="form-control numbersOnly" placeholder="percent">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="mortgageInterestTo" id="mortgageInterestTo" class="form-control numbersOnly" placeholder="percent">
                            </div>
                        </div>
						<div class="col-sm-12">
                            <div class="form-group">
                                <label  for="maxOpenLien" class="w-100">Max Open Lien</label>
                                <select id="maxOpenLien" name="maxOpenLien[]" class="js-example-basic-multiple js-maxOpenLien form-control" multiple="multiple" style="width: 100%;">
                                    <option value="Free and Clear">Free and Clear</option>
									<option value="1">1</option>
									<option value="2">2</option>
									<option value="3">3</option>
									<option value="4">4</option>
                                 </select>

                            </div>
                        </div>


                        <div class="col-sm-12 main_fields_title mt-4">Equity</div>
						<div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Equity Percentage</label>
                                <select id="equityStatus" name="equityStatus" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="equityFrom" id="equityFrom" class="form-control numbersOnly" placeholder="percent" >
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="equityTo" id="equityTo" class="form-control numbersOnly" placeholder="percent">
                            </div>
                        </div>


                        <div class="col-sm-12 main_fields_title mt-4">Listing Information</div>
						<div class="col-sm-12">
                            <div class="form-group">
                                <label for="listingStatus" class="w-100">Listing Status</label>
                                <select id="listingStatus" name="listingStatus[]" class="js-example-basic-multiple js-listing-status form-control" multiple="multiple" style="width: 100%;">
									<option value="1;Active">Active</option>
									<option value="2;Pending">Pending</option>
                                 </select>

                            </div>
                        </div>
						<div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Listing Price</label>
                                <select id="listingPriceStatus" name="listingPriceStatus" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="listingPriceFrom" id="listingPriceFrom" class="form-control numbersOnly" placeholder="amount">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="listingPriceTo" id="listingPriceTo" class="form-control numbersOnly" placeholder="amount">
                            </div>
                        </div>


                        <div class="col-sm-12 main_fields_title mt-4">Forclosure Information</div>
						<div class="col-sm-12">
                            <div class="form-group">
                                <label class="w-100">Forclosure Status</label>
                                <select id="forclosureStatus" name="forclosureStatus" class="form-control" style="width: 100%;">
									<option value="">Select </option>
									<option value="1;Default">Default</option>
									<option value="2;Auction">Auction</option>
									<option value="3;REO">REO</option>
									<option value="4;REO Sale">REO Sale</option>
									<option value="5;Short Sale">Short Sale</option>
                                 </select>

                            </div>
                        </div>
                       <div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Foreclosure Event Date</label>
                                <select id="forclosureDateStatus" name="forclosureDateStatus" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" id="forclosureDateFrom" name="forclosureDateFrom" class="form-control" placeholder="dd-mmm-yy">
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="forclosureDateTo" id="forclosureDateTo" class="form-control" placeholder="dd-mmm-yy">
                            </div>
                        </div>

						 <div class="col-sm-4">
                            <div class="form-group">
                                <label class="w-100">Foreclosure Amount</label>
                                <select id="forclosureAmountStatus" name="forclosureAmountStatus" class="form-control" style="width: 100%;">
                                    <option saleVal="0" value="is between">Is Between</option>
                                    <option saleVal="1" value="is">Is</option>
                                 </select>

                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="forclosureAmountFrom" id="forclosureAmountFrom" class="form-control numbersOnly" placeholder="amount" >
                            </div>
                        </div>
                        <div class="col-sm-4 mt-4">
                            <div class="form-group">
                                <input type="text" name="forclosureAmountTo" id="forclosureAmountTo" class="form-control numbersOnly" placeholder="amount">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0">
                        <button type="submit"  class="btn btn-success">Add</button>
                        <input type="hidden" name="kick_id" id="kick_id" class="form-control" />
                        <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </form>
            </div>
        </div>
    </div>

    <!-- popup end here-->
@endsection
@section('page_js')

<script>
$(function () {
	$('.numbersOnly').keyup(function () {
		this.value = this.value.replace(/[^0-9\.]/g,'');
	});
	$("#salesFrom,#mortgageRecordingFrom,#forclosureDateFrom").datepicker({
		beforeShow: customRange,
        changeMonth: true,
        changeYear: true,
		dateFormat: "d-MM-y",
		yearRange: "c-100:c+0",
    });

	$("#salesTo,#mortgageRecordingTo,#forclosureDateTo").datepicker({
		beforeShow: customRange,
        changeMonth: true,
        changeYear: true,
		dateFormat: "d-MM-y",
		yearRange: "c-100:c+0",
    });
});

function customRange(input) {
		var min = null, // Set this to your absolute minimum date
		dateMin = min,
		dateMax = null;


		if (input.id === "salesFrom") {
			dateMax = 'now';
		}
		if (input.id === "salesTo") {
			dateMin = $('#salesFrom').datepicker('getDate');
		}
		if (input.id === "mortgageRecordingFrom") {
			dateMax = 'now';
		}
		if (input.id === "mortgageRecordingTo") {
			dateMin = $('#mortgageRecordingFrom').datepicker('getDate');
		}
		if (input.id === "forclosureDateFrom") {

			dateMax = 'now';
		}
		if (input.id === "forclosureDateTo") {
			dateMin = $('#forclosureDateFrom').datepicker('getDate');
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

	$('.js-example-basic-multiple').select2({
		sorter: function(data) {
			return data.sort();
		},
	  placeholder: 'Select an option',
	  theme: "classic"
	});
</script>
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
		validator_1 = $('#searchForm').validate({
			rules: {
				state:{ required:true}
			},

            errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
		});
        validator = $('#kickstarterForm').validate({
            rules: {
                name:{
                    required:true,
                    alpha: true
                },

                kickstart_image: {
                    accept:"image/jpeg,image/png",
                    filesize_max: 300000

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
		$('#forclosureDateFrom').prop( "disabled", true );
		$('#forclosureDateTo').prop( "disabled", true );
		$('#forclosureAmountFrom').prop( "disabled", true );
		$('#forclosureAmountTo').prop( "disabled", true );

		$('#saleSelect').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#salesTo').show();
			}
			else $('#salesTo').hide(); // hide div if value is not "custom"
		});

		$('#mortgageAmountSelect').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#mortgageAmountTo').show();
			}
			else $('#mortgageAmountTo').hide(); // hide div if value is not "custom"
		});

		$('#mortgageRecordingDate').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#mortgageRecordingTo').show();
			}
			else $('#mortgageRecordingTo').hide(); // hide div if value is not "custom"
		});

		$('#mortgageInterestStatus').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#mortgageInterestTo').show();
			}
			else $('#mortgageInterestTo').hide(); // hide div if value is not "custom"
		});

		$('#equityStatus').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#equityTo').show();
			}
			else $('#equityTo').hide(); // hide div if value is not "custom"
		});

		$('#listingPriceStatus').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#listingPriceTo').show();
			}
			else $('#listingPriceTo').hide(); // hide div if value is not "custom"
		});

		$('#forclosureDateStatus').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#forclosureDateTo').show();
			}
			else $('#forclosureDateTo').hide(); // hide div if value is not "custom"
		});

		$('#forclosureAmountStatus').change(function () {
			if ( $('option:selected', this).attr('saleVal') == '0') {
				$('#forclosureAmountTo').show();
			}
			else $('#forclosureAmountTo').hide(); // hide div if value is not "custom"
		});

		$('#forclosureStatus').change(function () {
			if ( $(this).val() == '') {
				$('#forclosureDateFrom').prop( "disabled", true );
				$('#forclosureDateTo').prop( "disabled", true );
				$('#forclosureAmountFrom').prop( "disabled", true );
				$('#forclosureAmountTo').prop( "disabled", true );
			}
			else {
				$( "#forclosureDateFrom" ).prop( "disabled", false );
				$( "#forclosureDateTo" ).prop( "disabled", false );
				$('#forclosureAmountFrom').prop( "disabled", false );
				$('#forclosureAmountTo').prop( "disabled", false );
			}
		});

		$('#state_search').change(function(){
            var sid = $(this).val();
            if(sid){
                getCitiesSearch(sid,0);
                getCountySearch(sid,0);
            }else{
				$("#city_search").empty();
				$("#city_search").append('<option value="">Select County</option>');
				$("#county_search").empty();
				$("#county_search").append('<option value="">Select County</option>');
			}
        });

		$('#county_search').change(function(){
			var state_id = $('#state_search').val();
			var theID = [];
			var theSelection = [];
			 $.each($(this).find(":selected"), function (i, item) {
				theID.push(item.id);
				theSelection.push(item.text);
            });
            var sid = $(this).find("option:selected").text();

            if(sid){
                getCitiesByCounty(theSelection,0,state_id);
            }else{
				$("#city_search").empty();
				$("#city_search").append('<option value="">Select City</option>');
			}
        });

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

        //Delete User
        $(document).on('click', '.delKick', function (e) {
            $row =  $(this).parent().parent();
            e.preventDefault();
            var id = $(this).data('id');
            swal({
                    title: "Are you sure!",
                    type: "error",
                    confirmButtonClass: "btn-danger",
                    confirmButtonText: "Yes!",
                    showCancelButton: true,
                },
                function() {
					$('#loader').show();
                    $.ajax({
                        type: "POST",
                        url: "{{URL('superadmin/kickstarter/delete/')}}/"+id,
                        data: {_token: "{{ csrf_token() }}"},
                        success: function(data){

                            if($.isEmptyObject(data.error)){
                                $('#loader').hide();
                                swal("Deleted!", data.success, "success");
                                $row.remove();
								location.reload();

                            }else{
                                $('#loader').hide();
                                swal("Cancelled", data.error, "error");
                            }

                        }
                    });
            });
        });

        //Get Listing
        $('#kickstart_table').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            "ajax": "{{ route('kickstarter.list') }}",
            "rowId": "ShipmentId",
            "columns":[
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: "name", className: "name"},
                {data: "image", className: "image", orderable: false, searchable: false },
                {data: "email", className: "email"},
                {data: "phone", className: "phone"},
                {data: "search", className: "search"},
                {data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function ( row, data, index ) {
                $(row).addClass('data-row');
            },
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
            ],
        });

    });

    //Save user
    $('.btn-submit').click(function(){
        if($("#kickstarterForm").valid()){
			$('#loader').show();
            var button_id = $(this).attr("id");
            var _token      =  $("input[name='_token']").val();
            var name        = $("input[name='name']").val();
            var addSearch       = $('select[name="addSearch"]').val();// punch
            var description = $("textarea[name='description']").val();
            var kickstart_id      = $("input[name='kickstart_id']").val();
            var url = $("input[name='url']").val();
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

    //Edit User
    $(document).on('click', "#edit-item", function() {
        $(this).addClass('edit-item-trigger-clicked');
        var options = {
            'backdrop': 'static'
        };
        var title = $(this).data('title');
        var modal    =  $('#createKickstarterModal').modal(options);
        modal.find('.modal-title').text(title);
		$('#kickstarterForm')
				.find('[name="url"]')
					.val($(this).data('url'))
					.end();
        $('.save_button').hide();
        $('.update_button').show();
    });

    // Add User
    $(document).on('click', "#add-item", function() {
        $(this).addClass('edit-item-trigger-clicked');
        var options = {
            'backdrop': 'static'
        };
        var title = $(this).data('title');
        var modal       =  $('#createKickstarterModal').modal(options);
        modal.find('.modal-title').text(title);
        $('#kickstarterForm')
                .find('[name="url"]')
                    .val($(this).data('url'))
                    .end()
        $("#kickstarterForm").trigger("reset");
		$(".kick_img kick_img").hide();
		 $(".kick_img img").attr('src', '');
		 $("textarea[name='description']").text("");
        validator.resetForm();
		$("#city").empty();
        $("#city").append('<option value="">Select City</option>');
        $('.save_button').show();
        $('.update_button').hide();

    });

    // on modal show
    $('#createKickstarterModal').on('show.bs.modal', function() {
		$('#loader').show();
        var el = $(".edit-item-trigger-clicked");
        var row = el.closest(".data-row");
        var span = row.children(".action");
        var kickstart_id = el.data('kickstart_id');
        if(typeof kickstart_id !==  "undefined"){
            var name = row.children(".name").text();
            var image = span.children("span.image").text();
            var description = span.children("span.description").text();
            $("#kickstart_id").val(kickstart_id);
            $("input[name='name']").val(name);
            $("textarea[name='description']").text(description);
            $("select[name='addSearch']").val('');
            if (image) {
                $(".kick_img img").attr('src', image);
                $(".kick_img img").show();
            } else {
                $(".kick_img img").hide();
            }
			$('#loader').hide();
        }
		$('#loader').hide();

    });

    // on modal hide
    $('#createKickstarterModal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#kickstarterForm").trigger("reset");
		$(".kick_img kick_img").hide();
		 $(".kick_img img").attr('src', '');
		 $("textarea[name='description']").text("");
		$("#city").empty();
        $("#city").append('<option value="">Select City</option>');
        jQuery('.alert-danger').hide();
        validator.resetForm();
    });

	$(document).on('click', ".search_form_button", async function() {
        $(this).addClass('edit-item-trigger-clicked');
        var options = {
            'backdrop': 'static'
        };
        var modal       =  $('#addSearchModal').modal(options);
        console.log('----------  punch start -----------')
        var kick_id = $(this).data('kick-id');
        var searchObj = JSON.parse($('[data-kick-id=' + kick_id + ']').siblings('.search_json').html());
        searchObj =JSON.parse(searchObj);
        console.log(searchObj)
        $('#state_search').val(searchObj.state['val'])
        $('#countySelect').val(searchObj.countySelect)
        searchObj.county.forEach(async function (item, index, arr){
            await getCountySearch(searchObj.state['val'], item.val);
        })
        searchObj.city.forEach(async function (item, index, arr){
            await getCitiesSearch(searchObj.state['val'], item.val);
        })
        $('#citySelect').val(searchObj.citySelect)
        $('#zipSelect').val(searchObj.zipSelect)
        $('#zipcode').val(searchObj.zipcode)
        $('#land').val(searchObj.land)
        console.log('----------  punch end -----------')
        validator.resetForm();
		$("#city").empty();
    });

</script>
@endsection
