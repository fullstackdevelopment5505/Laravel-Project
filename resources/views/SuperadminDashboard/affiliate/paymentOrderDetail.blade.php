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


					<!-- main row start-->
					<div class="col-sm-12">
						<div class="row">
							<div class="col-sm-12 mt-2 mb-4 d-flex">
								<a href="{{ URL('/superadmin/affiliate/payments') }}" class="btn btn-default"><i class="fa fa-arrow-left"></i> Go Back</a>
							</div>
							<!--recent-customer-->
							<div class="col-sm-12 top_selling d-block">
									<div class="inside">
										<div class="title mb-4">Affiliate Payment Detail</div>
										
										<table class="display responsive nowrap order_table" width="100%">
										    <thead>
										        <tr>
										        	<th>Sr No</th>
										            <th>Date</th>
													<th>Customer</th>
													<th>Email</th>
													<th>Status</th>
													<th>Revenue</th>
										        </tr>
										    </thead>
										    <tbody>
											<?php $i =1; foreach($order_data as $key => $value){ ?>
										        <tr>
										        	<td>{{$i}}</td>
										            <td>{{$value->date ? $value->date : '-'}}</td>
													<td>{{$value->name}}</td>
													<td>{{$value->email}}</td>
													<td>{{$value->status}}</td>
													<td>{{$value->revenue}}</td>
												</tr>
											<?php $i++; } ?>	
										    </tbody>
										</table>
										
									</div>
								</div>
							<!--recent-customer-->

						</div>
					</div>
					<!-- main row end-->

			</div>
			<!-- inside_content_area end-->
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
   
@endsection
@section('page_js')
<script>
	
	var table;
    $(document).ready(function() {
       var  table = $('#order_table').DataTable();
	});
	
</script> 
@endsection