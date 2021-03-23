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
								<div class="col-sm-12 from_to_filter">
									<form>
										<div class="form-group">
										    <label>Customer Name:</label>
										    <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
										    <label>Customer ID:</label>
										    <input type="text" class="form-control">
										</div>
										<button type="button" class="btn btn-success">Search</button>
									</form>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<!--  Table start-->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">My Customers</div>
								<table class="display responsive nowrap" width="100%" id="AccountList">
									<thead>
										<tr>
                                            <th>Customer ID</th>
                                            <th>Company Name</th>
                                            <th>Primary Contact</th>
                                            <th>Email</th>
                                            <th>Phone</th>
                                            <th>Last Login Date</th>
                                            <th>Status</th>
                                            <th>Action</th>
										</tr>
									</thead>
									
								</table>
							</div>
						</div>
						<!--  Table end-->
					</div>
				</div>
				<!-- main row end-->
			</div>
			<!-- inside_content_area end-->
        </section>
        <!-- right area end -->
    </div>
    <!-- main div end -->

    @endsection
	@section('page_js')

	<script type="text/javascript">	
		$(document).ready(function() {
			
			$('#AccountList').DataTable({
				"processing": true,
				"serverSide": true,
				"ajax": "{{ route('customer') }}",   
				"columns":[
					// {"data": 'DT_RowIndex'},
					{"data":"custid"},
					{"data":"company_name"},
					{"data":"first_name"},
					{"data":"email"},
					{"data":"phone_number"},
					{"data":"created_at"},
                    {"data":"type"},
                    {data: 'action', name: 'action', orderable: false, searchable: false}
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