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
                                <div class="col-sm-8 from_to_filter">
                                    <form>
                                        <div class="form-group">
                                            <label>Affiliate Name:</label>
                                            <input name="search_name" type="text" class="form-control">
                                        </div>
                                        <button type="button" id="search_submit" class="btn btn-success">Search</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">All Affiliate Data</div>
                                <table class="display responsive nowrap" id="affiliate_table" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Sr. No.</th>
                                            <th>Service Code</th>
                                            <th>Name</th>
                                            <th>Affiliate Username</th>
                                            <th>Email</th>
                                            <th>Mobile</th>
                                            <th>Commission</th>
                                            <th>Join Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>

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
    <div class="modal fade" id="commissionModal">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">

                <div class="modal-header">
                    <h4 class="modal-title"><b>Affiliate Commission</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form action="/superadmin/affiliate/commission" method="post" id="commissionForm" enctype= multipart/form-data>
					<!-- <meta name="csrf-token" content="{!! csrf_token() !!}"> -->
					{{@csrf_field()}}
					<div class="modal-body register_new_user">
						<div class="alert alert-danger print-error-msg" style="display:none">
							<ul></ul>
						</div>
						<div class="row">
							<div class="col-sm-6">
								<div class="form-group">
									<label>Commission</label>
									<input type="hidden" name="affiliate_id" class="form-control" id="affiliate_id">
									<input class="form-control" id="commission" name="commission" value=""  style="text-align: right;" >

								</div>
							</div>

						</div>
					</div>

					<div class="modal-footer pl-0 pr-0">
						<div class="col-md-12 text-center p-0">
							<button type="button"  class="btn btn-success btn-submit save_button">Save</button>
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

	$(document).on('click', ".update_commission", function() {
        $('#loader').show();
        $(this).addClass('affiliate-trigger-clicked');
        //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.

        var options = {
            'backdrop': 'static'
        };

		$('#commissionForm').find('[name="affiliate_id"]').val($(this).data('affiliate_id')).end();

		var affiliate_id 	= 	$(this).data('affiliate_id');

        $.ajax({
			type: "GET",
			url: "{{route('superadminEmployeeAjaxRequest')}}",
			data: { id: affiliate_id, type: "get_affiliate_commission" },
			success: function(data){
				if($.isEmptyObject(data.error)){
					$('#loader').hide();
                    len = data['data'].length;
					if(len == 1){
                        $("input[name='affiliate_id']").val(data['data'][0].affiliate_id);
                        $("input[name='commission']").val(data['data'][0].commission);
                    }
                }else{
					$('#loader').hide();
                    alert(data.error);
                }
			}
		});
    });

	 // on modal hide
    $('#commissionModal').on('hide.bs.modal', function() {
        $('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
        $("#commissionForm").trigger("reset");
        jQuery('.alert-danger').hide();
    });

	$('.btn-submit').click(function(){

        if($("#commissionForm").valid()){

			$('#loader').show();

            var _token      	=  	$("input[name='_token']").val();
            var name        	= 	$("input[name='affiliate_id']").val();
            var commission      = 	$("input[name='commission']").val();
            var url = "{{url('/superadmin/affiliate/commission')}}";

            var formData = new FormData($("#commissionForm")[0]);
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
                        $('#commissionModal').modal('hide');
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


	$(function() {
		validator_1 = $('#commissionForm').validate({
			rules: {
                commission:{
                    required:true
                },
			},
			errorPlacement: function(label, element) {
                label.addClass('text-danger');
                label.insertAfter(element);
            },
            wrapper: 'span'
		});
	});
    //Employee add/edit bootstrap modal ajax
	$(document).ready(function () {
		$('#phone').usPhoneFormat({
			format: '(xxx) xxx-xxxx',
		});
	});
	$("#commission").inputmask('percentage', {
    rightAlign: false, showMaskOnHover: false,digitsOptional:false,showMaskOnFocus: false,
    suffix: "%",placeholder: '', max:1000,min:1
   });
	/* $("#commission").inputmask("decimal", {
		radixPoint: ".",
		groupSeparator: ",",
		autoGroup: true,
		suffix: " %",
		clearMaskOnLostFocus: false
	}); */
	/* $("document").ready(function(){
        setTimeout(function(){
            $(".alert").remove();
        }, 2000 );

		$(":input").inputmask();

    }); */
    $(document).ready(function() {
		$('#affiliate_table').DataTable({
            "processing": true,
            "serverSide": true,
            "bDestroy": true,
            //"ajax": "{{ route('kickstarter.list') }}",
			 "ajax": {
			    url: "{{route('affiliate.list')}}",
			    data: function (d) {
					d.search_name   =   $('input[name="search_name"]').val();
				}
		    },
            "rowId": "ShipmentId",
           "columns":[
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: "service_code", className: "service_code"},
                { data: "name", className: "name"},
                { data: "username", className: "username"},
                { data: "email", className: "email"},
                { data: "phone", className: "phone"},
                { data: "commission"},
                { data: "join_date",name:"created_at", className: "join_date"},
                { data: "status", className: "status"},
                { data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
            "createdRow": function ( row, data, index ) {
                $(row).addClass('data-row');
            },
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel',
				{
                extend: 'pdfHtml5',
				title : function() {
                    return "Affiliates List";
                },
				orientation : 'landscape',
					pageSize : 'A4',
					text : '<i class="fa fa-file-pdf-o"> PDF</i>',
					titleAttr : 'PDF',
                exportOptions: {

                    columns: [ 0, 1, 2, 3,4,5,6,7,8,9 ]
                }
				}
            ],
        });

       /*  $('#affiliate_table').DataTable({
            processing: true,
		    responsive: true,
		    serverSide: true,
			 bDestroy: true,
            //"ajax": "{{ route('employee.list') }}",
			dom: 'lBfrtip',
            ajax: {
			    url: "{{route('affiliate.list')}}",
			    data: function (d) {
					d.search_name   =   $('input[name="search_name"]').val();
				}
		    },
            columns:[
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false},
                { data: "service_code", className: "service_code"},
                { data: "name", className: "name"},
                { data: "username", className: "username"},
                { data: "email", className: "email"},
                { data: "phone", className: "phone"},
                { data: "commission"},
                { data: "join_date", className: "join_date", render: function(d){ return moment(d).format("DD-MMM-YYYY");},},
                { data: "status", className: "status"},
                { data: 'action', className:"action", name: 'action', orderable: false, searchable: false},
            ],
            createdRow: function ( row, data, index ) {
                    $(row).addClass('data-row');
            },
            dom: 'lBfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf',
            ],
        }); */

        $('#search_submit').click(function(){
            $('#affiliate_table').DataTable().draw(true);
        });

		//on modal show
		$('#employeeModal').on('show.bs.modal', function() {
			var el = $(".edit-item-trigger-clicked"); // See how its usefull right here?
			var user_id = el.data('user_id');
		});

		$(document).on('click', '.update_status', function (e) {

			$row =  $(this).parent().parent();
			e.preventDefault();

			var user_id = $(this).data('user_id');
			var is_affiliate = $(this).data('is_affiliate');
			var current_status = "approve";
			if(is_affiliate == 1){
				current_status = "cancel";
			}

			swal({
					title: "Are you sure?",
					text: "You want to " + current_status + " affiliate!!",
					type: "warning",
					confirmButtonClass: "btn-danger",
					confirmButtonText: "Update!",
					showCancelButton: true,
				}, function() {
					$('#loader').show();
				$.ajax({
					type: "GET",
					url: "{{route('superadminEmployeeAjaxRequest')}}",
					data: { id: user_id, is_affiliate: is_affiliate, type: "affiliate_status" },
					success: function(data){
						$('#loader').hide();
						if($.isEmptyObject(data.error)){
							//swal("Updated!", data.success, "success");
							swal({
								title: "Status updated successfully!",
								confirmButtonText: "OK!",
								showCancelButton: false,
							}, function() {
								location.reload();
							});

						}else{
							swal("Cancelled", data.error, "error");
						}
					}
				});
			});
		});

	});
</script>
@endsection
