@extends('SuperadminDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('SuperadminDashboard.layouts.sidebar');	
        <!-- right area start -->
        <section class="right_section">
            @include('SuperadminDashboard.layouts.header');	
			<!-- inside_content_area start-->
			<div class="content_area">
				<div class="col-sm-12">
					<div class="row">	
                        <!-- datepicker -->
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <div class="col-sm-8 from_to_filter">
                                    <form>
                                        <div class="form-group">
                                            <label>Employee ID:</label>
                                            <input type="text" class="form-control">
                                        </div>
                                        <div class="form-group">
                                            <label>From:</label>
                                            <input type="text" class="form-control datepicker" placeholder="Date">
                                        </div>
                                        <div class="form-group">
                                            <label>To:</label>
                                            <input type="text" class="form-control datepicker" placeholder="Date">
                                        </div>
                                        <button type="button" class="btn btn-success">Search</button>
                                    </form>
                                </div>
                                <div class="col-sm-4 top_btns">
                                    <button class="btn btn-primary" data-toggle="modal" data-target="#myModal">Add New Leave<i class="fa fa-plus"></i></button>
                                </div>
                            </div>
                        </div>
                        <!-- datepicker -->
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Leave Requests</div>
                                <table class="display responsive nowrap" width="100%">
                                    <thead>
                                        <tr>
                                            <th>Employee ID</th>
                                            <th>Employee Name</th>
                                            <th>Department</th>
                                            <th>Holiday From</th>
                                            <th>Holiday To</th>
                                            <th>No. Of Days</th>
                                            <th>Reason</th>
                                            <th>Leave Type</th>
                                            <th>Status</th>                                             
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>001</td>
                                            <td>Mike Miller</td>
                                            <td>Seller</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going For Picnic</td>
                                            <td>Casual Leave</td>
                                            <td><label class="badge badge-success">Approved</label></td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td>John Doe</td>
                                            <td>Seller</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going to Hospital</td>
                                            <td>Medical</td>
                                            <td><label class="badge badge-warning">Pending</label></td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td>Ashley Graham</td>
                                            <td>Broker</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going to Native</td>
                                            <td>Loss of Pay</td>
                                            <td><label class="badge badge-danger">Reject</label></td>
                                        </tr>
                                        <tr>
                                            <td>001</td>
                                            <td>Mike Miller</td>
                                            <td>Seller</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going For Picnic</td>
                                            <td>Casual Leave</td>
                                            <td><label class="badge badge-success">Approved</label></td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td>John Doe</td>
                                            <td>Seller</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going to Hospital</td>
                                            <td>Medical</td>
                                            <td><label class="badge badge-warning">Pending</label></td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td>Ashley Graham</td>
                                            <td>Broker</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going to Native</td>
                                            <td>Loss of Pay</td>
                                            <td><label class="badge badge-danger">Reject</label></td>
                                        </tr>
                                        <tr>
                                            <td>001</td>
                                            <td>Mike Miller</td>
                                            <td>Seller</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going For Picnic</td>
                                            <td>Casual Leave</td>
                                            <td><label class="badge badge-success">Approved</label></td>
                                        </tr>
                                        <tr>
                                            <td>002</td>
                                            <td>John Doe</td>
                                            <td>Seller</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going to Hospital</td>
                                            <td>Medical</td>
                                            <td><label class="badge badge-warning">Pending</label></td>
                                        </tr>
                                        <tr>
                                            <td>003</td>
                                            <td>Ashley Graham</td>
                                            <td>Broker</td>
                                            <td>02/12/2020</td>
                                            <td>02/10/2020</td>
                                            <td>8</td>
                                            <td>Going to Native</td>
                                            <td>Loss of Pay</td>
                                            <td><label class="badge badge-danger">Reject</label></td>
                                        </tr>
                                    </tbody>
                                </table>
							</div>
						</div>
                        <!--table end -->
					</div>
				</div>
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
                    <h4 class="modal-title"><b>Add New Leave</b></h4>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>

                <div class="modal-body register_new_user">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Employee ID</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Employee Name</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Department</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Leave Type</label>
                                <select class="form-control">
                                    <option>Casual Leave</option>
                                    <option>Medical</option>
                                    <option>Loss of Pay</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Holiday From</label>
                                <input type="text" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Holiday To</label>
                                <input type="text" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>No. Of Days</label>
                                <input type="text" class="form-control">
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <label>Status</label>
                                <select class="form-control">
                                    <option>Approved</option>
                                    <option>Pending</option>
                                    <option>Reject</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label>Reason</label>
                                <textarea class="form-control" rows="4"></textarea>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer pl-0 pr-0">
                    <div class="col-md-12 text-center p-0"> 
                        <a href="#" type="btn" class="btn btn-success">Save</a>
                        <a href="#" type="btn" class="btn btn-secondary ml-1" data-dismiss="modal">Cancel</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- popup end here-->
@endsection    
  