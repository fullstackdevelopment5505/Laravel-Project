@extends('SuperadminDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('SuperadminDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
            @include('SuperadminDashboard.layouts.header');	
			<!-- inside_content_area start-->
						<!-- inside_content_area start-->
			<div class="content_area">

					<div class="col-sm-12">
						<div class="row">
                            
							<div class="col-sm-12 mt-2 mb-4 d-flex">
								<a href="{{ URL('/superadmin/affiliate/payments') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go Back</a>
							</div>
							<form id="mass_pay_detail_form" action="" method="POST">
							 {{@csrf_field()}}
                            <!--table start -->
							    <div class="col-sm-12 top_selling d-block">
									<div class="inside">
										<div class="title">Send A Mass Payment</div>
										<!--div class="subline"><p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p></div-->
										<hr class="mt-4 mb-4">
										<div class="title">Affiliate</div>
										<table class="display responsive nowrap" id="payment_table" width="100%">
											<thead>
										        <tr>
										            <th><input type="checkbox" name="select_all" value="1" id="checkboxes-select-all"> All</th>
										            <th>Affiliate</th>
													<th>Username</th>
													<th>Total Commission</th>
										        </tr>
										    </thead>
										</table>

										<div class="title mt-5 mb-4">Send a customized note to your recipients</div>
										<div class="form-group">
											<label>Subject</label>
											<input type="hidden" class="form-control" name="type" value="getMassPayDetail">
											<input type="text" class="form-control" name="subject" id="subject">
										</div>
										<div class="form-group">
											<label>Note To Recipient</label>
											<textarea class="form-control" rows="8" name="note" id="note" ></textarea>
										</div>
										<!--label class="d-flex mt-4 mb-4"><input type="checkbox" name="agree" id="agree_checkbox" class="mr-3"> I Agree Terms & Condition</label-->
										
										<input type="button" class="btn btn-success" id="mass_pay_submit" name="submit" value="Continue" />
									</div>
								</div>
							<!--table end-->
							</form>	
						</div>
					</div>

			</div>
			<!-- inside_content_area end-->
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
   <!-- popup start from here-->
     <div class="modal fade" id="sendMassPayModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
              
                <div class="modal-header">
                    <h4 class="modal-title"><b><div class="title">Total Recipients:</div></b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="" method="post" id="massPaySendForm" >
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body register_new_user">
                    <hr class="mt-3 mb-3">
					<div class="title mb-4">Summary</div>
					
					<ul class="summary">
						<li>
							<span>Mass Payment Subtotal</span>
							<p><input type="hidden" name="sub_total" class="sub_total" value="" /><span></span></p>
						</li>
						<li>
							<span>Fees</span>
							<p><input type="hidden" name="extra_fees" class="extra_fees" value="" /><span></span></p>
						</li>
						<li>
							<span>Total</span>
							<p><input type="hidden" name="total" class="total" value="" /><span></span></p>
						</li>
					</ul>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0"> 
						<button type="button" id="send_mass_payment" class="btn btn-success mr-2"><i class="fa fa-credit-card mr-2"></i> Send Paypal Mass Payment</button>
						<input type="hidden" name="type"  value="send_masspayment" />
						<input type="hidden" name="ids"  value="" />
						<input type="hidden" name="subject"  value="" />
						<input type="hidden" name="note"  value="" />
						<input type="hidden" name="affiliate_ids"  value="" />
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
<link type="text/css" href="//gyrocode.github.io/jquery-datatables-checkboxes/1.2.12/css/dataTables.checkboxes.css" rel="stylesheet" />
<script>
	$(function() {
		$('#agree_checkbox').click(function() {
			if ($(this).is(':checked')) {
				$('#mass_pay_submit').removeAttr('disabled');
			} else {
				$('#mass_pay_submit').attr('disabled', 'disabled');
				
			}
		});
	});
	var table;
    $(document).ready(function() {
       var  table = $('#payment_table').DataTable({
           // processing: true,
		   // responsive: true,
		    serverSide: true,
           
			   columnDefs: [{
					targets: 0,
					searchable: false,
					orderable: false,
					className: 'dt-body-center',
					render: function (data, type, full, meta){
						return '<input type="checkbox" name="mass_pay_affiliate_checkbox[]" class="single_checkbox" value="' + $('<div/>').text(data).html() + '">';
					}
					
				  }],
			  select: {
				 style: 'multi',
				 selector: 'td:first-child'
			  },
			  order: [[1, 'asc']],
            columns:[
                
                { data: "affiliate_id",name:"affiliate_id"},
                { data: "affiliate_detail.full_name",name: "affiliate_detail.full_name"},
                { data: "affiliate_detail.username",name: "affiliate_detail.username"},
                { data: "commission"},
            ]
            
        });
	});
	
	// Handle click on "Select all" control
	$('#checkboxes-select-all').click(function(){
		var table = $('#payment_table').DataTable();
		
		// Get all rows with search applied
		var rows = table.rows({ 'search': 'applied' }).nodes();
	  
	  // Check/uncheck checkboxes for all rows in the table
	  
		$('input[type="checkbox"]', rows).prop('checked', this.checked);
	});
	
	  // Handle click on checkbox to set state of "Select all" control
	
	$("#payment_table input[type='checkbox']").change(function(){	
	
		// If checkbox is not checked
		if(!this.checked){
			var el = $('#checkboxes-select-all').get(0);
				// If "Select all" control is checked and has 'indeterminate' property
			if(el && el.checked && ('indeterminate' in el)){
				// Set visual state of "Select all" control
				// as 'indeterminate'
				el.indeterminate = true;
			}
		}
	});
	
	// Handle form submission event
	/* $(document).on('click', "#mass_pay_submit", function() {

		var form = $('#mass_pay_detail_form');
		
		var rows_selected = $('#mass_pay_detail_form').checkboxes.selected();

	}); */
	
	var validator;
    $(function() {
        validator = $('#mass_pay_detail_form').validate({
            rules: {
                subject:{
                    required:true
                },
				note:{
                    required:true
                },
				"mass_pay_affiliate_checkbox[]": { 
					required: true, 
					minlength: 1 
				} 
            },
            errorPlacement: function(label, element) {
				if(element.attr("name") == 'mass_pay_affiliate_checkbox[]'){
					label.addClass('text-danger');
					label.insertAfter(element.closest('table'));
				}else{
					label.addClass('text-danger');
					label.insertAfter(element);
				} 
            },
            wrapper: 'span'
        });
    });
	
	$(document).on('click', "#send_mass_payment", function() {
		$('#loader').show();	
		var form = $('#massPaySendForm');
		var data = form.serialize();	
		var _token   =  $("input[name='_token']").val();
		$.ajax({
			url: "{{route('superadminAffiliateAjaxRequest')}}",
			type:'POST',
			headers: {
				'X-CSRF-TOKEN': _token
			},
			data: data,
			success: function(response) {
				if(response.error==false){ 
					$('#loader').hide();
					alert("Mass payment initiated successfully.");
					jQuery('.alert-danger').hide();
					$('#sendMassPayModal').modal('hide');
					location.href = "{{ url('/superadmin/affiliate/payments') }}";
				}else{
					$('#loader').hide();
					alert(response.message);
				    //printErrorMsg(data.error);
				} 
			}
		});	
	});
	
	$(document).on('click', "#mass_pay_submit", function() {
        //debugger;
		var form = $('#mass_pay_detail_form');
		
		
        if(form.valid()){ 
			var data = form.serialize();
			$('#loader').show();
			var _token    =  $("input[name='_token']").val();
            $.ajax({
                url: "{{route('superadminAffiliateAjaxRequest')}}",
                type:'POST',
                headers: {
                    'X-CSRF-TOKEN': _token
                },
                data: data,
                success: function(response) {
					
                    if($.isEmptyObject(response.error)){
						$('#loader').hide();
						console.log(response);
                        jQuery('.alert-danger').hide();
						var modal = $('#sendMassPayModal').modal();
                        modal.modal('show');
						modal.find('.modal-title').text('Total Recipients: '+response.total_recipient);
						$('#massPaySendForm').find('[name="sub_total"]').val(response.subtotal).end();
						$('#massPaySendForm').find('[name="sub_total"]').parent().find('span').text('$'+parseFloat(response.subtotal)+' USD');
						$('#massPaySendForm').find('[name="extra_fees"]').val(response.extra).end();
						$('#massPaySendForm').find('[name="extra_fees"]').parent().find('span').text('$'+parseFloat(response.extra)+' USD');
						$('#massPaySendForm').find('[name="total"]').val(response.total).end();
						$('#massPaySendForm').find('[name="total"]').parent().find('span').text('$'+parseFloat(response.total)+' USD');
						$('#massPaySendForm').find('[name="subject"]').val(response.subject).end();
						$('#massPaySendForm').find('[name="ids"]').val(response.wallet_ids).end();
						$('#massPaySendForm').find('[name="note"]').val(response.note).end();
						$('#massPaySendForm').find('[name="affiliate_ids"]').val(response.affiliates).end();
                        
                    }else{
						$('#loader').hide();
						alert(response.message);
                       // printErrorMsg(data.error);
                        
                    } 
                }
            });
        }
    });
</script> 
@endsection