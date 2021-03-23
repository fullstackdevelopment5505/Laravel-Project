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


							<div class="col-sm-12 mb-4">
								<div class="row">
									<div class="col-md-3 colorful_box mt-2">
										<div class="inset">
											<div class="title">${{$paid_amount_total}}</div>
											<div class="subline">Total commission paid</div>
										</div>
									</div>
									<div class="col-md-3 colorful_box mt-2">
										<div class="inset">
											<div class="title">{{$total_pending_affiliate}}</div>
											<div class="subline">Affiliates to be paid</div>
										</div>
									</div>
									<div class="col-md-3 colorful_box mt-2">
										<div class="inset">
											<div class="title">{{$prospectsJoined}}</div>
											<div class="subline">Prospects</div>
										</div>
									</div>
									<div class="col-md-3 colorful_box mt-2">
										<div class="inset">
											<div class="title">{{$customerEntrolled}}</div>
											<div class="subline">Customers</div>
										</div>
									</div>
								</div>
							</div>


                            <div class="col-sm-12 mb-4">
                            	<div class="row align-items-center">
                            		<div class="col-md-6 payment_headline">
                            			<h2>Pending Payout</h2>
                            			<h5>{{$total_pending_affiliate}} Affiliates need to be paid total commission of ${{$pending_amount}}</h5>
                            		</div>
                            		<div class="col-md-6 send_payment_cta"><a href="{{ URL('/superadmin/affiliate/mass-payment-detail') }}" class="btn btn-success"><i class="fa fa-credit-card"></i> Send Paypal Mass Payment</a></div>
                            	</div>
                            </div>


                            <!--table start -->
							    <div class="col-sm-12 top_selling d-block">
									<div class="inside">
										<div class="title mb-4">Affiliates Payments</div>
										<table class="display responsive nowrap" id="affiliate_table" width="100%">
											<thead>
										        <tr>
										            <th>Sr. No.</th>
										            <th>Payment Date</th>
													<th>Affiliate Email</th>
													<th>Affiliate Name</th>
													<th>Affiliate Username</th>
													<th>Transaction ID</th>
													<th>Commission</th>
													<th>Status</th>
													<th>Action</th>
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
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
   <!-- popup start from here-->
     <div class="modal fade" id="paymentDetailModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><b><div class="title">Affiliate Payment Detail</div></b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="" method="post" id="payment_detail_form" >
                <!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
                {{@csrf_field()}}
                <div class="modal-body payment_detail">
                    <hr class="mt-3 mb-3">
					<!--table start -->
						<div class="col-sm-12 top_selling d-block">
							<div class="inside">
								<div class="title mb-4">Affiliate Payment</div>
								<div class="table_warap">


								</div>
							</div>
						</div>
					<!--table end-->
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0">
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
<script>
	$(document).on('click', ".view_detail_button", function() {

        $(this).addClass('affiliate-trigger-clicked');
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

        var options = {
            'backdrop': 'static'
        };
		$('#loader').show();
		var _token   = $('#payment_detail_form').find('[name="_token"]').val();
		var wallet_ids 	= 	$(this).data('ids');
		var order_id 	= 	$(this).data('order_id');

        $.ajax({
			type: "POST",
			url: "{{route('superadminAffiliateAjaxRequest')}}",
			data: { wallet_ids: wallet_ids,order_id: order_id, type: "get_payment_detail" },
			headers: {
				'X-CSRF-TOKEN': _token
			},
			success: function(json){
				$('#loader').show();
				if($.isEmptyObject(json.error)){
					$('#loader').hide();
					var table='<table class="display responsive nowrap" id="payment_detail_table" width="100%"><thead><tr><th>Sr. No.</th><th>Customer</th><th>Email</th><th>Status</th><th>Revenue</th><th>Date</th></tr></thead><tbody>';
					var i=1;
					$.each(json.data, function(k, v) {
						date = json.data[k].date;
						if(date == null){
							date = 'NA';
						}
						table += '<tr><td>' + i + '</td><td>' + json.data[k].name + '</td><td>' + json.data[k].email + '</td><td>' + json.data[k].status +'</td><td>$' +json.data[k].revenue + '</td><td>' + date + '</td></tr>';
							i++;
					});
					table+='</tbody></table>';
					 $('.table_warap').html(table);
					 $('#payment_detail_table').DataTable().draw(true);
                }else{
					$('#loader').hide();
                    alert(json.error);
                }
			}
		});
    });

    $(document).ready(function() {
        $('#affiliate_table').DataTable({
            processing: true,
		    responsive: true,
		    serverSide: true,
			paging: true,
            //"ajax": "{{ route('employee.list') }}",
			dom: 'lBfrtip',

            columns:[
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: "order_date", className: "order_date"},
                { data: "affiliate_detail.email"},
                { data: "affiliate_detail.full_name"},
                { data: "affiliate_detail.username"},
                { data: "order_id"},
                { data: "commission"},
                { data: "status",className:"status"},
                { data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
            createdRow: function ( row, data, index ) {
                    $(row).addClass('data-row');
            },
			rowCallback: function( row, data ) {

				if ( data['order_date'] == null) {
				  $('td:eq(1)', row).html( '-');
				}
				if ( data['order_id'] == null) {
				  $('td:eq(5)', row).html( '-');
				}
				if ( data['commission']) {
				  $('td:eq(6)', row).html( '<b>$</b>'+data['commission'] );
				}
			},

            buttons: [
                'copy', 'csv', 'excel', {
                extend: 'pdfHtml5',
				title : function() {
                    return "Affiliates Payment";
                },
				orientation : 'landscape',
					pageSize : 'A4',
					text : '<i class="fa fa-file-pdf-o"> PDF</i>',
					titleAttr : 'PDF',
				},
            ],
        });

	});
</script>
@endsection
