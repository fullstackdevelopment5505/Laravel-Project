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
                        <!--table start -->
						<div class="col-sm-12 top_selling">
							<div class="inside">
								<div class="title">Purchase Records</div>
									<table class="display responsive nowrap" width="100%">
										<thead>
										    <tr>
										        <th>date</th>
										        <th>time</th>
												<th>Report name</th>
												<th>Points</th>
										    </tr>
										</thead>
										<tbody>
										    <tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
											<tr>
										        <td>02/10/2020</td>
												<td>10:00 AM</td>
												<td>Lorem ipsum dummy text</td>
										        <td>10 pt.</td>
											</tr>
										</tbody>
									</table>
								</div>
							</div>
							<!--table end-->
						</div>
					</div>
		        </div>
			    <!-- inside_content_area end-->
	    </section>
	    <!-- right area end -->
    </div>
    <!-- main div end -->
@endsection
   