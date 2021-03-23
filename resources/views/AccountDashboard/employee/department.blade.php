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
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New Departments<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Departments</div>
								<table class="display responsive nowrap" width="100%" id ="DepartmentList">
									<thead>
										<tr>
											<th>Department</th>
											<th>Created Date</th>
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
		<div class="modal-dialog modal-md">
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title"><b>Add New Departments</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
					<form action="{{route('department.add')}}" method="post" id="customerForm" >
						{{@csrf_field()}}
						<div class="row">
							<div class="col-sm-12">
								<div class="form-group">
									<label>Department Name</label>
									<input type="text" class="form-control" id="name" name="name">
								</div>
							</div>
						</div>
						<div class="modal-footer pl-0 pr-0">
							<div class="col-md-12 text-center p-0"> 
							<input type="submit" class="btn btn-success svbtn" value="Save">
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

<!-- Fetching Leave Request report list -->
 

	<script type="text/javascript">	


		$(document).ready(function() {
			
			$('#DepartmentList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('employeeDepartment') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"name"},
					{"data":"created_at"}
			
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