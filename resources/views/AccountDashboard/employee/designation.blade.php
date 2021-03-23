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
						<!-- datepicker -->
						<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-12 top_btns">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New Designation<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Designation</div>
								<table class="display responsive nowrap" width="100%" id="DesignationList">
									<thead>
										<tr>
											<th>Designation</th>
											<th>Department</th>
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
					<h4 class="modal-title"><b>Add New Designation</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				<form action="{{route('designation.add')}}" method="post" id="customerForm" >
					{{@csrf_field()}}
					<div class="row">
					
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Designation</label>
							    <input type="text" class="form-control" id="designation" name="designation">
							</div>
						</div>
						<div class="col-sm-6">
							<div class="form-group">
							    <label>Department Name</label>
							    <select class="form-control" id="department" name="department">
							    	<option>Please Select Department...</option>
							    	@foreach($department as $departments)
									
									<option value="{{ $departments->name }}">{{ $departments->name}}</option>
									@endforeach 
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


	
	
	@endsection
	@section('page_js')

<!-- Fetching Designations list -->
 

	<script type="text/javascript">	


		$(document).ready(function() {
			
			$('#DesignationList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('employeeDesignation') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"designation"},
					{"data":"department"}
			
				],
				dom: 'lBfrtip',
				buttons: [
					'copy', 'csv', 'excel', 'pdf',
				],
				"bDestroy": true
			});
		});
	</script>

	@endsection