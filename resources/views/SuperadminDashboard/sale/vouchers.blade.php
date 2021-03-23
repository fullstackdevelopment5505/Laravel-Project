@extends('SuperadminDashboard.master')
@section('content')
<meta http-equiv="" content="5" >
	<!-- main div start -->
	<div class="main_area">
		@include('SuperadminDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SuperadminDashboard.layouts.header');	
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
								<!--	<form>
										<div class="form-group">
										    <label>From:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										<div class="form-group">
										    <label>To:</label>
										    <input type="text" class="form-control datepicker" placeholder="Date">
										</div>
										 <div class="form-group">
										    <label>Voucher Type:</label>
										    <select class="form-control">
										    	<option>Receipt Voucher</option>
										    	<option>Payment Voucher</option>
										    	<option>Sporting Voucher</option>
										    </select>
										</div> 
										<button type="button" class="btn btn-success">Search</button>
									</form>-->
								</div>

								<div class="col-sm-4 top_btns">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Create New Voucher<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->

						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Sale Vouchers</div>
								<table class="display responsive nowrap" width="100%" id="SalevoucherList">
									<thead>
										<tr>
											<th>Date</th>
											<th>Voucher No</th>
											<th>Purpose</th>
											<th>Amount</th>
											<th>Tax</th>
											<th>Remaining Amount</th>
											<th>Action</th>
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
		<div class="modal-dialog modal-lg">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Create New Voucher</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				<form action="{{route('vouchers.add')}}" method="post" id="customerForm" required>
					{{@csrf_field()}}
					<div class="row">
						<!-- <div class="col-sm-6">
							<div class="form-group">
							    <label>Voucher Number</label>
							    <input type="text" class="form-control" name="voucher_no" id="voucher_no" required autocomplete="off">
							</div>
						</div> -->

						<div class="col-sm-6">
							<div class="form-group">
							    <label>Purpose</label>
								<input type="text" class="form-control" name="purpose" id="purpose" required autocomplete="off">
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
							    <label>Total Amount</label>
							    <input type="text" class="form-control" name="amount" required id="amount"autocomplete="off" onChange="checkOption(this)" > 
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
							    <label>Tax %</label>
							    <input type="text" class="form-control" name="tax" id="tax" onChange="checkOption(this)" required autocomplete="off"> 
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
							    <label>Remaining Amount</label>
							    <input type="text" class="form-control" name="rem_total" id="rem_total" readonly autocomplete="off">
							</div>
						</div>
					</div>

					<div class="modal-footer mt-2 pb-0">
						<div class="col-md-12 text-center"> 
						<input type="submit" class="btn btn-success svbtn" value="Save">
							<a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
						</div>
					</div>
					</form>
				</div>
			</div>
		</div>
	</div>

		<!-- Edit Model Start-->

<div class="modal fade" id="teamModal" aria-hidden="true">
<div class="modal-dialog modal-md">
<div class="modal-content">
    <div class="modal-header">
        <h4 class="modal-title" >Edit Details</h4>
		<button type="button" class="close" data-dismiss="modal">&times;</button>

    </div>
    <div class="modal-body ">

        <form id="productForm" name="productForm" class="form-horizontal" method="post" action="{{route('Purchasevouchers.update')}}">
           {{@csrf_field()}}
		   <div class="main_form">
		   <input type="hidden" name="id" id="id">
		   <div class="row">

							    <input type="hidden" class="form-control" name="voucher_no" id="voucher_no" value="" required>


						<div class="col-sm-6">
							<div class="form-group">
							    <label>Purpose</label>
								<input type="text" class="form-control" name="purpose" id="purpose" value="" required>
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
							    <label>Total Amount</label>
							    <input type="text" class="form-control" name="amount" required id="amount" onChange="onChange(this)" value=""> 
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
							    <label>Tax %</label>
							    <input type="text" class="form-control" name="tax" id="tax" onChange="onChange(this)" required value=""> 
							</div>
						</div>

						<div class="col-sm-6">
							<div class="form-group">
							    <label>Remaining Amount</label>
							    <input type="text" class="form-control" name="rem_total" id="rem_total" readonly value="">
							</div>
						</div>
					</div>

					<div class="modal-footer mt-2 pb-0">
						<div class="col-md-12 text-center"> 
						<input type="submit" class="btn btn-success svbtn" value="Save" id="btn-save">
							<a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
						</div>
					</div>
				
            </div>
        </form>
    </div>
    <div class="modal-footer">
         
    </div>
</div>
</div>
	@endsection
	@section('page_js')

<!-- Fetching sale report list -->

	<script type="text/javascript">	
		$(document).ready(function() {
			
			$('#SalevoucherList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('SuperadminSalevouchers') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{title: "date",data: "date",
                   render: function(d) {
                   return moment(d).format("DD-MMM-YYYY");}},
					{"data":"voucher_no"},
					{"data":"purpose"},
					{"data":"amount"},
					{"data":"tax"},
					{"data":"rem_total"},
					{"data": "action"}
				],
				"order": [[ 0, 'desc' ]] ,
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
				],
				"bDestroy": true
			});
		});
	</script>
		
<script>
		$(document).on('click', "#edit-team", function() {
			// alert("edit clicked");
			$(this).addClass('edit-item-trigger-clicked'); //useful for identifying which trigger was clicked and consequently grab data from the correct row and not the wrong one.
			var options = {
				'backdrop': 'static'
			};
			$('#teamModal').modal(options);
				// alert("clicked");
		});

		$(document).ready(function () {
			$("#editTeam").click(function () {
			});
			$('#teamModal').on('show.bs.modal', function() {
				// alert("i am here");
			
				var el = $(".edit-item-trigger-clicked");
				var row = el.closest(".data-row");
				var span = row.children(".action");
				
				var id = el.data('id');
				var voucher_no = el.data('voucher_no');
				var purpose = el.data('purpose');
				var amount = el.data('amount');
				var tax = el.data('tax');
				var rem_total = el.data('rem_total');

				$("input[name='id']").val(id);
				$("input[name='voucher_no']").val(voucher_no);
				$("input[name='purpose']").val(purpose);
				$("input[name='amount']").val(parseInt(amount));
				$("input[name='tax']").val(parseInt(tax));
				$("input[name='rem_total']").val(parseInt(rem_total));

				
			});
			// on modal hide
			$('#teamModal').on('hide.bs.modal', function() {
				$('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
				$("#edit-form").trigger("reset");
				jQuery('.alert-danger').hide();
			});
		});
	</script>
	<script>
	function checkOption(obj) {
    var amount = document.getElementById("amount").value;	
	var tax = document.getElementById("tax").value;			
	if(amount!="" && tax!="")
	{
		var result=tax*amount/100;
		
		var totalval=parseInt(amount)-parseInt(result);
	
		document.getElementsByName('rem_total')[0].value= totalval;
	}
  }
  </script>
	<script>
  function onChange(obj) {
	  debugger;
    var amount = $("#productForm #amount").val();	
	var tax = $("#productForm #tax").val();			
	if(amount!="" && tax!="")
	{
		var result=tax*amount/100;
		
		var totalval=parseInt(amount)-parseInt(result);
		$("#productForm #rem_total").val(totalval)
	
		//document.getElementsByName('rem_total').value= totalval;
	}
  }
	</script>
@endsection