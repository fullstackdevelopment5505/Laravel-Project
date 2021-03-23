@extends('SalemanagerDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('SalemanagerDashboard.layouts.sidebar');	
		<!-- right area start -->
		<section class="right_section">
			@include('SalemanagerDashboard.layouts.header');
            <div class="content_area">
				@if ($message = Session::get('success'))
					<div class="alert alert-success alert-block">
						<button type="button" class="close" data-dismiss="alert">×</button>	
						<strong>{{ $message }}</strong>
					</div>
				@endif
				<div class="col-md-12">
					<div class="row row-eq-height">
						<div class="col-md-12 main_btn">
							<div class="flex_btn">
								<div class="tab_btn"></div>
								<!-- <div class="add_btn">
									<a href="{{route('salemanagerAddTeam')}}"><i class=" fa fa-plus"></i>Add New</a>
								</div> -->
							</div>
						</div>
						<!--property data start -->
						<div class="col-md-12 main_top_selling">
							<div class="inside">
								<table id="nonMemberList" class="display  responsive nowrap" width="100%">
									<thead>
									    <tr>
									        <!-- <th>Sr No</th> -->
									        <th>Name</th>
									        <th>Email</th>
									        <th>Mobile</th>
									        <th>Joined</th>
									        <th>Action</th>
									    </tr>
									</thead>
								
								</table>
							</div>
						</div>
						<!-- property data end -->
					</div>
				</div>
			</div>
        </section>
    </div>
@endsection
 @section('page_js')
<script type="text/javascript">
	$(document).ready(function() {
		$('#nonMemberList').DataTable({
			"processing": true,
			"serverSide": true,
			"searching":false,
			"ajax": "{{ route('nonMemberList') }}",
			"columns":[
            //    { data: null, render: function (data, type, full, meta) {
			// 				return meta.row + 1;
			// 			}
            //             },
				// {"data": 'DT_RowIndex'},
				{ "data": "username"},
				{"data":"email"},
				{"data":"phone"},
                {"data":"created_at",name:'created_at'},
                // {"data":"expire_at"}
				// {"data":"department",name: 'department', orderable: false, searchable: false},
				// {"data":"city",className:"city"},
				// {"data": 'sales', name: 'sales', orderable: false, searchable: false},
				// {"data": 'commision', name: 'commision', orderable: false, searchable: false},
				{"data": 'action',className:"action", name: 'action', orderable: false, searchable: false},
			],
			// 'createdRow': function( row, data, index ) {
			// 	$(row).addClass( 'data-row' );
			// },
			dom: 'lBfrtip',
			buttons: [
				'copy', 'csv', 'excel', 'pdf',
			],
		});
	});
	</script>
@endsection