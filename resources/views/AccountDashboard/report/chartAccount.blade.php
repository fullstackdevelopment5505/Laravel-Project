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

			@if ($message = Session::get('success'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>	
						<strong>{{ $message }}</strong>
					</div>
				@endif
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
					<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-12 top_btns">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New Entry<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Chart Of Accounts</div>
								<table class="display responsive nowrap" width="100%" id="AccouontChartList">
									<thead>
										<tr>
 										    <th>Title</th>
										    <th>Account Type</th>
										    <th>GL Code</th>
										    <th>Type</th>
										    <th>Action</th>
										</tr>
									</thead>
								
								</table>
							</div>
						</div>
						<!-- Table end-->
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
					<h4 class="modal-title"><b>Add New Entry</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				<form action="{{route('AccountChart.add')}}" method="post" id="customerForm" >
					{{@csrf_field()}}
					<div class="row">
					
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Account Type</label>
								<select class="form-control" id="account_type" name="account_type"> 
									<option value="Income">Income</option>
									<option value="Expence">Expence</option>
							   </select>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>GL Code</label>
							    <input type="text" class="form-control" id="gl_code" name="gl_code" autocomplete="off" required>
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Title</label>
							    <input type="text" class="form-control " id="title" name="title" required autocomplete="off">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Type</label>							   
							   <select class="form-control" name="type" id="type">
									<option value="Credit">Credit</option>
									<option value="Debit">Debit</option>
							   </select>
							</div>
						</div>	
					</div>

					<div class="modal-footer pl-0 pr-0">
					<div class="col-md-12 text-center p-0"> 
					<input type="submit" class="btn btn-success svbtn" value="Save">
						<a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
					</div>
				</div>
				
				</div>
				</form>
			
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

        <form id="productForm" name="productForm" class="form-horizontal" method="post" action="{{route('chartAccount.updateAccountChart')}}">
           {{@csrf_field()}}
		   <div class="main_form">

		   <input type="hidden" name="id" id="id">
		   <label class="col-sm-4 control-label form-group">Account Type</label>
							
				<input type="text" class="form-control fldtxt form-group" id="account_type" name="account_type" required value="">

                <label class="col-sm-2 control-label form-group ">Title</label>
				<input type="text" class="form-control fldtxt form-group" id="title" name="title" required value="">
  
				<label class="col-sm-2 control-label form-group">Type</label>							   
						
							   <input type="text" class="form-control fldtxt form-group"  name="type" id="type" required value="">

             <input type="submit" class="btn btn-success svbtn" id="btn-save" value="Save changes">
            </div>
        </form>
    </div>
    <div class="modal-footer">
         
    </div>
</div>
</div>

	@endsection
	@section('page_js')

<!-- Fetching Leave Request report list -->
 

	<script type="text/javascript">	


		$(document).ready(function() {
			
			$('#AccouontChartList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{route('chartAccount')}}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"title"},
					{"data":"account_type"},
					{"data":"gl_code"},
					{"data":"type"},
					{"data": 'action',className:"action", name: 'action', orderable: false, searchable: false}
			
				],
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
				var account_type = el.data('account_type');
				var title = el.data('title');
				var type = el.data('type');
				//var account_type = row.children(".account_type").text();
				//var title = row.children(".title").text();
				//var type = row.children(".type").text();
	
		
				// fill the data in the input fields
				$("input[name='id']").val(id);
				$("input[name='account_type']").val(account_type);
				$("input[name='title']").val(title);
				$("input[name='type']").val(type);
				
			});
			// on modal hide
			$('#teamModal').on('hide.bs.modal', function() {
				$('.edit-item-trigger-clicked').removeClass('edit-item-trigger-clicked')
				$("#edit-form").trigger("reset");
				jQuery('.alert-danger').hide();
			});
		});
	</script>

@endsection