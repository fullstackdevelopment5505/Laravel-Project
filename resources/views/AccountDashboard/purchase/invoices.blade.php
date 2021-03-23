<style>
    .tab{
        border-collapse: collapse; /* Remove cell spacing */
    }
    table, th, td{
        border: 1px solid #666;
    }
    table th, table td{
        padding: 2px; /* Apply cell padding */
    }
input{
	border-radius: 4px;
}
textarea{
	border-radius: 4px;
}
select{
	border-radius: 4px;
}
.pointer_event{
	pointer-events:none
}
</style>
@extends('AccountDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('AccountDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('AccountDashboard.layouts.header');
	
			<!-- inside_content_area start-->
			<div class="content_area">
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
					@if(Session::has('success'))
        		<div class="alert alert-success">
            		{{Session::get('success')}}
        		</div>
					@endif
					@if(Session::has('error'))
						<div class="alert alert-danger">
							{{Session::get('error')}}
						</div>
					@endif
						<!-- datepicker -->
						<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-8 from_to_filter">
									<form>
									<div class="form-group">
										<label>From:</label>
										<input type="text" id="date_from_purchase" name="date_from_purchase" class="form-control datepickerSuper" placeholder="Date">
									</div>
									<div class="form-group">
										<label>To:</label>
										<input type="text" id="date_to_purchase" name="date_to_purchase" class="form-control datepickerSuper" placeholder="Date">
									</div>
										<!-- <div class="form-group">
										    <label>Status:</label>
										    <select class="form-control">
										    	<option>Pending</option>
										    	<option>Paid</option>
										    	<option>Partially Paid</option>
												<option>Sent</option>
										    </select>
										</div> -->
										<button type="button" id="search_submit_purchase" class="btn btn-success">Search</button>
									</form>
								</div>
								<div class="col-sm-4 top_btns">
									<button class="btn btn-primary myscriptload" data-toggle="modal" data-target="#myModal">Create New Invoice<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->

						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Purchase Invoice</div>
									<table class="display display2 responsive nowrap form-controle" width="125%" id="PurchaseinvoiceList">
										<thead>
										<tr>
												
												<th>Date</th>
												<th>Invoice No.</th>
												<th>Company Name</th>
												<th>Amount</th>
												<th>Tax</th>
												<th>Discount</th>
												<th>cash</th>
												<th>Total</th>
												
											</tr>
										</thead>										
									</table>
								</div>
							</div>
							<!-- Sale Table end-->
						</div>
					</div>
					<!-- main row end-->
			</div>
			<!-- inside_content_area end-->
		</section>
		<!-- right area end -->
	</div>
	<!-- main div end -->

	<!-- popup start from here-->
	<div class="modal fade" id="myModal">
		<div class="modal-dialog modal-xl">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Create New Invoice</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				 <form action="{{route('purchaseinvoice.add')}}" method="post" id="customerForm" >
					{{@csrf_field()}}
					<div class="row">

					<div class="col-sm-3">
					<input type="checkbox" id="manual" name="manual">
					<label>Manual Date</label>
					</div>

					<div class="col-sm-3">
							<div class="form-group">
							    <label>Bill Type</label>
								<select id="bill_type" name="bill_type">
								<option>PLease Select Bill Type..</option>
									<option>Sale Bill</option>
								</select>
							</div>
						</div>

					<div class="col-sm-3">
							<div class="form-group">
							    <label>Company Name</label>
								<input type="text" id="company_name" name="company_name" value="Equity Finders" readonly>
							</div>
						</div>

						<div class="col-sm-3">
							<div class="form-group">
							    <label>Session</label>					
								<input type="text" id="session" name="session" value="2020-2021" readonly>
							</div>
						</div>
				</div>

				<br><br><br>

				<div class="row">
						<div class="col-sm-8"></div>
						<div class="col-sm-6">
							<div class="form-group">
							<table class="table" >
								<tr>
									<td><label> Address   </label></TD>
									<td>
									<input type="text" name="address" id="address" size="40" >
									</td>
								</tr>
								<tr>
									<td> GSTIN </td>
									<td><input type="text" name="gstin" id="gstin" size="40" ></td>
								</tr>
							</table>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							<table class="table" >
								<tr>
									<td><label>Invoice Prefix</label></TD>
									<td>
									<input type="text" name="invoice_prefix" id="invoice_prefix" size="40" >
									</td>
								</tr>
								<tr>
									<td>Date</td>
									<td><input type="text" name="date" id="date" size="40" class="datepicker pointer_event" value="{{date('m/d/Y')}}"  autoComplete="off"  ></td>
								</tr>
							</table>
							</div>
						</div>
						</div>
						<br><br><br>
						<div class="row">
					
						<div class="col-sm-6">
							<div class="form-group">
							<p>Details Of Reciever[Billed To]</P>
							<br>
							</br>
							<table class="tab" >
								<tr>
									<td><label>Name</label></TD>
									<td>
									<input type="TEXT" name="rec_name" id="rec_name" size="40" >
									</td>
								</tr>
								<tr>
									<td>Address</td>
									<td ><textarea type="text" name="rec_address" id="rec_address" rows="2" style="width:365px; height:50px" ></textarea></td>
								</tr>
								<tr>
									<td><label>State</label></TD>
									<td>
									<input type="TEXT" name="rec_state" id="rec_state" size="40" >
									</td>
								</tr>
								<tr>
									<td>Sate Code</td>
									<td><input type="text" name="rec_state_code" id="rec_state_code" size="40" ></td>
								</tr>
								<tr>
									<td><label>GSTIN/Unique ID</label></TD>
									<td>
									<input type="text" name="rec_gstin" id="rec_gstin" size="40" >
									</td>
								</tr>
							
							</table>
							</div>
						</div>
						<div class="col-sm-6">
						<p>Details Of Consignee[Shipped To]</P>
						<input type="checkbox" id="same_address" name="same_address" >
				     	<label>Same as Reciever</label>
						 </br>
						 </br>
							<div class="form-group">
    						<table class="tab" >
								<tr>
									<td><label>Name</label></TD>
									<td>
									<input type="TEXT" name="con_name" id="con_name" size="40" >
									</td>
								</tr>
								<tr>
									<td>Address</td>
									<td><textarea type="text" name="con_address" id="con_address" size="40" style="width:365px; height:50px" ></textarea></td>
								</tr>
								<tr>
									<td><label>State</label></TD>
									<td>
									<input type="TEXT" name="con_state" id="con_state" size="40" >
									</td>
								</tr>
								<tr>
									<td>Sate Code</td>
									<td><input type="text" name="con_state_code" id="con_state_code" size="40" ></td>
								</tr>
								<tr>
									<td><label>GSTIN/Unique ID</label></TD>
									<td>
									<input type="TEXT" name="con_gstin" id="con_gstin" size="40" >
									</td>
								</tr>
							
							</table>
							</div>
						</div>
					</div>

					<div class="col-sm-12 mt-3 mb-5">
						<div class="row">
							<div class="table-responsive">
								<table class="table">
									<thead class="thead-dark">
										<tr>
											<th>#</th>
											<th>Item</th>
											<th>Description</th>
											<th>Unit Cost</th>
											<th>Quantity</th>
											<th>Amount</th>
										</tr>
									</thead>
									<tbody id="new_invoice">
										<tr>
											<td>1</td>
											<td><input type="text" class="form-control" id="item_name" name="item_name[0]"></td>
											<td><input type="text" class="form-control" id="item_description" name="item_description[0]"></td>
											<td><input type="number" class="form-control changeQty" id="unit_cost" data-index="0" name="unit_cost[0]"></td>
											<td><input type="number" class="form-control changeQty" id="quantity" data-index="0" name="quantity[0]"></td>
											<td><input type="text" class="form-control" id="amount" name="amount[0]" readonly></td>
										</tr>
									</tbody>
								</table>
							</div>

						
							<div class="col-sm-12 text-center"><input type="button" class="btn btn-success add_new_item" value="Add New Item"></div>							
						</div>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<div class="form-group">
							    <label>Subtotal</label>
							    <input type="text" class="form-control" id="sub_total" name="sub_total"  readonly>
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							    <label>Tax</label>
							    <input type="number" class="form-control" id="tax" name="tax">
							</div>
						</div>
						<div class="col-sm-4">
							<div class="form-group">
							    <label>Discount%</label>
							    <input type="number" class="form-control" id="discount" name="discount">
							</div>
						</div>
						<div class="col-sm-12 total">
							<h1>Total: <input type="text" id="finalamount" name="finalamount" size="5" readonly /></h1>
						</div>
					</div>

					<div class="modal-footer pb-0 pl-0 pr-0">
						<div class="col-md-12 text-center p-0"> 
							<input type="submit" class="btn btn-success svbtn" value="Save">
							<!--<a href="#" type="btn" class="btn btn-primary ml-1">Save & Send</a>-->
							<a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
						</div>
					</div>

					
					</form>
				</div>
			</div>
		</div>
	</div>
	@endsection
	@section('page_js')

<!-- Fetching sale report list -->
 
<script type="text/javascript">	

	$(function()
	{
	$('[name="manual"]').change(function()
	{
		if ($(this).is(':checked')) {
		$("#date").removeClass("pointer_event");
		}
		else
		{
			$("#date").addClass("pointer_event");
		};
	});
	});

	$(function()
	{
	$('[name="same_address"]').change(function()
	{
		if ($(this).is(':checked')) {
				
				var con_name = $("#rec_name").val();
				var con_address = $("#rec_address").val();
				var con_state = $("#rec_state").val();
				var con_state_code = $("#rec_state_code").val();
				var con_gstin = $("#rec_gstin").val();
				

				$("input[name='con_name']").val(con_name);
				$("textarea[name='con_address']").val(con_address);
				$("input[name='con_state']").val(con_state);
				$("input[name='con_state_code']").val(con_state_code);
				$("input[name='con_gstin']").val(con_gstin);
				
		}
		else{
			$("input[name='con_name']").val(con_name);
				$("textarea[name='con_address']").val(con_address);
				$("input[name='con_state']").val(con_state);
				$("input[name='con_state_code']").val(con_state_code);
				$("input[name='con_gstin']").val(con_gstin);

		};
	});
	});

	$(document).on('change','.changeQty',  function() {
	console.log("mukehhh");
		var index = $(this).attr('data-index');
		var unit = $('input[name="unit_cost['+index+']"]').val();
		var qty = $('input[name="quantity['+index+']"]').val();
		var amount=qty*unit;
					$('input[name="amount['+index+']"]').val(amount);
					
		var sum=0;
		for(i=0; i<=index; i++){
			var value = $('input[name="amount['+i+']"]').val();
			sum = parseInt(value)+parseInt(sum);
		}			
		$("#sub_total").val(sum);
		
	})
	$('input[name=discount],input[name=tax]').change(function() {
		var ss=$("#sub_total").val();
		var tax = $("#tax").val();
		var taxamount= (ss*tax)/100;
		var rem =ss-taxamount;
		var dis= $("#discount").val();
		var disamount= (rem*dis)/100;
		var afterdis = rem-disamount;
		var finalamount=afterdis;
		$("#finalamount").val(parseFloat(finalamount).toFixed(2));
	});
	

	var table = $('#PurchaseinvoiceList').DataTable({
	processing: true,
	responsive: true,
	serverSide: true,
	dom: 'lBfrtip',
		buttons: [
			'copyHtml5',
			'excelHtml5',
			'csvHtml5',
			'pdfHtml5',
		],
	lengthMenu: [
			[20, 30, 50 ],
			[20, 30, 50]
		],
	paging: true,
	ajax: {
		url: "{{route('Purchaseinvoices')}}",
		data: function (d) {
				d.date_from_purchase = $('input[name="date_from_purchase"]').val();
				d.user_id = $('input[name="user_id"]').val();
				d.type = 'purchased_record';
				d.date_to_purchase =$('input[name="date_to_purchase"]').val();
				
			}
		},
		
		columns: [ 
			{title: "date",data: "date",
			   render: function(d) {
			   return moment(d).format("DD-MMM-YYYY");}},
			{ data: 'invoice_no', name: 'invoice_no' },
			{ data: 'company_name', name: 'company_name'},
			{ data: 'amount', name: 'amount'},
			{ data: 'tax', name: 'tax'},
			{ data: 'discount', name: 'discount'},
			{ data: 'cash', name: 'cash'},
			{ data: 'abc', name: 'abc'}

		],
		"order": [[ 0, 'desc' ]] ,

});
		 
$('#search_submit_purchase').click(function(){	
	$('#PurchaseinvoiceList').DataTable().draw(true);
});
$(function() {

$('#date_from_purchase').datepicker({
beforeShow: customRange,
dateFormat: "mm/dd/yy",
firstDay: 1,
maxDate: 'now',
changeFirstDay: false
});
$('#date_to_purchase').datepicker({
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


if (input.id === "date_from_purchase") {
dateMax = 'now';	
}
if (input.id === "date_to_purchase") {
dateMin = $('#date_from_purchase').datepicker('getDate');
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
</script>

<script>
	// just for the demos, avoids form submit
	jQuery.validator.setDefaults({
	debug: true,
	success: "valid"
	});
	$( "#customerForm" ).validate({
	rules: {
		address: {
		required: true
		},
		gstin: {
		required: true,
		lettersonly: true,
		maxlength: 15
		},
		invoice_prefix: {
		required: true,
		lettersonly: true,
		
		},
		rec_name: {
		required: true,
		lettersonly: true,
		maxlength: 25
		},
		rec_address: {
		required: true,
		maxlength: 50
		},
		rec_state: {
		required: true,
		lettersonly: true,
		maxlength: 20
		},
		rec_state_code: {
		required: true,
		lettersonly: true,
		maxlength: 15
		},
		rec_gstin: {
		required: true,
		lettersonly: true,
		maxlength: 15
		},
		con_name: {
		required: true,
		lettersonly: true,
		maxlength: 25
		},
		con_address: {
		required: true,
		maxlength: 50
		},
		con_state: {
		required: true,
		lettersonly: true,
		maxlength: 20
		},
		con_state_code: {
		required: true,
		lettersonly: true,
		maxlength: 15
		},
		con_gstin: {
		required: true,
		lettersonly: true,
		maxlength: 15
		}
		
	},
	submitHandler: function(customerForm) {
      customerForm.submit();
    }
	});
</script>
@endsection