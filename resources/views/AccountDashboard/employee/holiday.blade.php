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
								<div class="col-sm-12 top_btns">
									<button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New Holiday<i class="fa fa-plus"></i></button>
								</div>
							</div>
						</div>
						<!-- datepicker -->

						<!-- Sale Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Holidays</div>
								<table class="display responsive nowrap" width="100%" id="holidayList">
									<thead>
										<tr>
											<th>Holiday Name</th>
											<th>Holiday Date</th>
											<th>Day</th>
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
					<h4 class="modal-title"><b>Add New Holiday</b></h4>
					<button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>

				<div class="modal-body register_new_user">
				  <form action="{{route('Holiday.add')}}" method="post" id="customerForm" >
					{{@csrf_field()}}
					<div class="modal-body register_new_user">
                        <div class="alert alert-danger print-error-msg" style="display:none">
                            <ul></ul>
                        </div> 
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Holiday Name</label>
                                    <input type="text" name="name" id="name" class="form-control" autocomplete="off">
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label>Holiday Date</label>
                                    <input autocomplete="off" type="text" name="holiday_date" id="holiday_date" class="form-control datepicker">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer pl-0 pr-0">
                        <div class="col-md-12 text-center p-0"> 
                            <input type="hidden" id="holiday_id" name="holiday_id" value="" > 
 				
                           	<input type="submit" class="btn btn-success svbtn" value="Save">
                             <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                        </div>
                    </div>
				    </form>			
			   </div>
		</div>
	</div>

	@endsection
	@section('page_js')

<!-- Fetching Holiday report list -->

	<script type="text/javascript">	
		$(document).ready(function() {
			
			$('#holidayList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('employeeHoliday') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"name"},
					{"data":"holiday_date"},
					{"data":"day"},
					
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