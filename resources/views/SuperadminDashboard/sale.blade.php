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
						<div class="col-sm-12 top_selling customer_search">
							<form action="#">
                                <div class="inside">
                                    <div class="title mb-4">Search By Sale</div>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>State</label>
                                                <select class="form-control">
                                                    <option selected="selected" disabled="disabled">Select State</option>
                                                    <optgroup>
                                                        <option>Alabama</option>
                                                        <option>Alaska</option>
                                                        <option>Arizona</option>
                                                        <option>Arkansas</option>
                                                        <option>California</option>
                                                        <option>Colorado</option>
                                                        <option>Connecticut</option>
                                                        <option>Delaware</option>
                                                        <option>District Of Columbia</option>
                                                        <option>Florida</option>
                                                        <option>Georgia</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div> 
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Sale Manager</label>
                                                <select class="form-control">
                                                    <option selected="selected" disabled="disabled">Select Sale Manager</option>
                                                    <optgroup>
                                                        <option>John Doe</option>
                                                        <option>Mike Miller</option>
                                                        <option>Ashley Graham</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label>Sale Executive</label>
                                                <select class="form-control">
                                                    <option selected="selected" disabled="disabled">Select Executive</option>
                                                    <optgroup>
                                                        <option>John Doe</option>
                                                        <option>Mike Miller</option>
                                                        <option>Ashley Graham</option>
                                                    </optgroup>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2>Price Range</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>From</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend mt-2"><div class="input-group-text">$</div></div>
                                                            <input type="text" class="form-control mt-2">
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>To</label>
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend mt-2"><div class="input-group-text">$</div></div>
                                                            <input type="text" class="form-control mt-2">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <h2>Date</h2>
                                                <div class="row">
                                                    <div class="col-sm-6">
                                                        <label>From:</label>
                                                        <input type="text" class="form-control datepicker">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label>To:</label>
                                                        <input type="text" class="form-control datepicker">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-12">
                                            <input type="button" class="btn btn-success" value="Search Result">
                                            <input type="reset" class="btn btn-danger" value="Reset">
                                        </div>
                                    </div>
                                </div>
							</form>
                        </div>
                        <hr class="line_divider">
                        <!-- datepicker -->
                        <div class="col-sm-12 top_bar_area">
                            <div class="row">
                                <div class="col-sm-12 from_to_filter">
                                    <form>
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
                            </div>
                        </div>
                        <!-- datepicker -->
                        <div class="col-sm-12 top_selling customer_search">
                            <div class="inside">
								<table class="display responsive nowrap" width="100%">
									<thead>
                                        <tr>
                                            <th>date</th>
                                            <th>State</th>
                                            <th>Sales manager</th>
                                            <th>sales executive</th>
                                            <th>sale</th>
                                            <th>commission</th>
                                            <th>action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>California</td>
                                            <td>Robert</td>
                                            <td>Abraham</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>Florida</td>
                                            <td>Tiffany</td>
                                            <td>John Doe</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>California</td>
                                            <td>Robert</td>
                                            <td>Abraham</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>Florida</td>
                                            <td>Tiffany</td>
                                            <td>John Doe</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>California</td>
                                            <td>Robert</td>
                                            <td>Abraham</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>Florida</td>
                                            <td>Tiffany</td>
                                            <td>John Doe</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                        </tr>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>California</td>
                                            <td>Robert</td>
                                            <td>Abraham</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                            </tr>
                                        <tr>
                                            <td>02/01/2020</td>
                                            <td>Florida</td>
                                            <td>Tiffany</td>
                                            <td>John Doe</td>
                                            <td>$100,000</td>
                                            <td>$10000</td>
                                            <td><a href="#" class="btn btn-success">View Detail</a></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
						</div>
					</div>
				</div>
			</div>
			<!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
@endsection
   