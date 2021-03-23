@extends('SuperadminDashboard.master')
@section('content')
<!-- main div start -->
<div class="main_area">
@include('SuperadminDashboard.layouts.sidebar')	
	<!-- right area start -->
	<section class="right_section">
    @include('SuperadminDashboard.layouts.header')	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-md-12">
						<div class="row row-eq-height">

							<div class="col-md-12 main_btn">
								<div class="flex_btn">
									<div class="tab_btn"></div>
									<div class="add_btn">
										<a href="JavaScript:void()" data-toggle="modal" data-target="#myModal"><i class=" fa fa-plus"></i>Add New</a>
									</div>
								</div>
							</div>
							<div class="col-sm-12 customer_tabs">
								<ul class="nav nav-pills">
									<li class="nav-item"><a class="nav-link active" data-toggle="pill" href="#sale_manager">Sales Manager</a></li>
									<li class="nav-item"><a class="nav-link" data-toggle="pill" href="#sale_executive">Sales Executive</a></li>
								</ul>
							</div>


							<div class="tab-content">
								<!--property data start -->
								<div class="col-sm-12  tab-pane top_selling active" id="sale_manager">
									<div class="inside">
										<table id="property_data" class="display display2 responsive nowrap" width="100%">
										    <thead>
												<tr>
													<th>Sr. No.</th>
													<th>Name</th>
													<th>Location</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>2</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>3</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>4</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>5</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>6</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>7</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>8</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
											</tbody>
										</table>

									</div>
								</div>
								<!-- property data end -->
								<!--property data start -->
								<div class="col-sm-12  tab-pane top_selling fade" id="sale_executive">
									<div class="inside">
										<table id="property_data" class="display display2 responsive nowrap" width="100%">
										    <thead>
												<tr>
													<th>Sr. No.</th>
													<th>Name</th>
													<th>Location</th>
													<th>Action</th>
												</tr>
											</thead>
											<tbody>
												<tr>
													<td>1</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>2</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>3</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>4</td>
													<td>John Doe</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>5</td>
													<td>Leon kennedy</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>6</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>7</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
												<tr>
													<td>8</td>
													<td>Chris Redfill</td>
													<td>California</td>
													<td><a href="{{route('superadminMessage')}}" class="btn btn-success">Message</a></td>
												</tr>
											</tbody>
										</table>

									</div>
								</div>
								<!-- property data end -->
							</div>
					</div>
			  </div>
			<!-- inside_content_area end-->
	</section>
	<!-- right area end -->
</div>
<!-- main div end -->

<!-- add-customer-popup -->
<!-- The Modal -->
<div class="modal fade" id="myModal">
<div class="modal-dialog modal-md">
  <div class="modal-content">
  
    <!-- Modal Header -->
    <div class="modal-header">
      <h4 class="modal-title">Add Customer</h4>
      <button type="button" class="close" data-dismiss="modal">&times;</button>
    </div>
    
    <!-- Modal body -->
    <div class="modal-body">
      <div class="main_form">
      	<label>Name</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<label>Email Id</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<label>Phone No.</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<label>City</label>
      	<input type="text" class="form-control fldtxt" name="">
      	<button class="btn btn-success svbtn">Save</button>
      </div>
    </div>
   
  </div>
</div>
</div>
<!-- add-customer-popup -->
@endsection