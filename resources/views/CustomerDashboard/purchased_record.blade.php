@extends('CustomerDashboard.master')
@section('content')
	<!-- main div start -->
	<div class="main_area">
		@include('CustomerDashboard.layouts.sidebar')	
		<!-- right area start -->
		<section class="right_section">
			@include('CustomerDashboard.layouts.header')	
			<!-- inside_content_area start-->
			<div class="content_area">
				<!-- main row start-->
				<div class="col-sm-12">
					<div class="row">
						<!-- datepicker -->
						<div class="col-sm-12 top_bar_area">
							<div class="row">
								<div class="col-sm-12 from_to_filter">
									<form method="post" action="{{route('customerPurchaseRecord')}}">
									{{@csrf_field()}}
										<div class="form-group">
											<label>From:</label>
											<input type="text" class="form-control datepicker" name="from" placeholder="Date">
										</div>
										<div class="form-group">
											<label>To:</label>
											<input type="text" class="form-control datepicker" name="to" placeholder="Date">
										</div>
										<input type="submit" name="submit" value="submit" class="btn btn-success">
									</form>
								</div>
							</div>
						</div>
						<!-- datepicker -->
						<!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Purchase Records</div>
									<table class="display responsive nowrap" width="100%">
										<thead>
											<tr>
												<th>Date</th>
												<th>Time</th>
												<th>Report name</th>
												<th>Points</th>
											</tr>
										</thead>
										<tbody>
										@if(isset($_POST['submit']))
											@foreach($filterRecord as $row)
												<tr>
													<td>{{$row->date}}</td>
													<td>{{$row->time}}</td>
													<td>{{$row->report_name}}</td>
													<td>{{$row->points}}</td>
												</tr>
											@endforeach
										@else
											@foreach($record as $row)
												<tr>
													<td>{{$row->date}}</td>
													<td>{{$row->time}}</td>
													<td>{{$row->report_name}}</td>
													<td>{{$row->points}}</td>
												</tr>
											@endforeach
									@endif		
										</tbody>
									</table>
								</div>
							</div>
							<!--table end-->
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