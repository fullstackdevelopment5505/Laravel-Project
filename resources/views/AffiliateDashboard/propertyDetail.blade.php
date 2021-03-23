@extends('AffiliateDashboard.master')
@section('content')
<!-- main div start -->
<div class="main_area">
    <!-- sidebar start -->
	@include('AffiliateDashboard.layouts.sidebar')	
	<!-- sidebar end -->
	<!-- right area start -->
	<section class="right_section">
    <div class="content_area">
	<a href="{{route('affiliateProperties')}}"><i class="fa fa-arrow-left"></i></a>
        @include('AffiliateDashboard.layouts.header')
		<section id="mapview">
	<div class="col-md-12">
		<div class="row">
			<div class="col-md-4 nopadding fixdpic"><img src="{{asset('assets/affiliate/images/real-estate.jpg')}}"></div>
			<div class="col-md-8 nopadding"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3020.8746087359414!2d-73.95642648428597!3d40.7867707409741!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x89c258a13813be1d%3A0xd275a7e28ef2647d!2s1365%20Madison%20Ave%2C%20New%20York%2C%20NY%2010128%2C%20USA!5e0!3m2!1sen!2sin!4v1572962110793!5m2!1sen!2sin" width="100%" height="500" frameborder="0" style="border:0;" allowfullscreen=""></iframe></div>
		</div>
	</div>
</section>
<section id="prop_detail_bg">
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<div class="share_box">
					<div class="favicons2">
						<ul>
							<li><a href="javascript:void()" title="notes" data-toggle="modal" data-target="#myModal" class="intro"><img src="{{asset('assets/affiliate/images/notes.png')}}"></a></li>
							<li>
								<a href="javascript:void()" title="lightbulb">
									<img src="{{asset('assets/affiliate/images/bulb.png')}}" class="bulb">
									<img src="{{asset('assets/affiliate/images/bulb2.png')}}" class="bulb2">
								</a>
							</li>
							<li>
								<a href="javascript:void()" title="fire">
									<img src="{{asset('assets/affiliate/images/fire.png')}}"  class="fire">
									<img src="{{asset('assets/affiliate/images/fire2.png')}}" class="fire2">
								</a>
							</li>
							<li><a href="javascript:void()" title="trash"><i class="fa fa-trash"></i></a></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
</section>
<!-- modal_mynotes -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
      	<!-- Modal-Header-->
        <div class="modal-header">
          <h4 class="modal-title">My Notes</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal-Header-end -->

        <!-- Modal-body -->
        <div class="modal-body" id="notes_bg">
        	<form>
        		<textarea class="areas" placeholder="Add a note..."></textarea>
        		<input type="submit" class="sendbtn" value="Send A Message" name="">
        	</form>
        </div>
        <!-- Modal-body-end -->

      </div>
  </div>
</div>
<!-- modal_mynotes-end -->



<!-- send_message -->
<div class="modal fade" id="myModal2">
    <div class="modal-dialog modal-md">
      <div class="modal-content">
      	<!-- Modal-Header-->
        <div class="modal-header">
          <h4 class="modal-title">Send A Message</h4>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <!-- Modal-Header-end -->

        <!-- Modal-body -->
        <div class="modal-body2" id="notes_bg">
        	<div class="owner_detail">
        		<div class="ownpic"><img src="{{asset('assets/affiliate/images/owner.png')}}"></div>
        		<div class="owner_content">
        			<h3>Owner</h3>
        			<p>Alex Martynovych / Julia Martynovych</p>
        			<p><i class="fa fa-map-marker"></i> 1335 Madison 8605 Hutsville, AR 72740-7169</p>
        		</div>
        	</div>

        	<div class="form_boxs">
        		<form>
        			<div class="label">Name</div>
        			<input type="text" class="own-fild" name="">
        			<div class="label">Email Address</div>
        			<input type="email" class="own-fild" name="">
        			<div class="label">Mobile Number</div>
        			<input type="text" class="own-fild" name="">
        			<div class="label">Message</div>
        			<textarea class="tarea"></textarea>
        			<input type="submit" class="sendbtn2" value="Send A Message" name="">
        		</form>
        	</div>

        </div>
        <!-- Modal-body-end -->

      </div>
  </div>
</div>
<!-- send_message-end -->


<section id="prop_content_part">
	<div class="container">
		<div class="row">
			<div class="col-md-8 col-lg-9">
				<div class="prop_head">
					<h2>Villa On {{$propertyDetail->StreetName}} {{$propertyDetail->StreetType}}</h2>
					<h3>${{$propertyDetail->AssessedTotalValue}}</h3>
				</div>
				<div class="location"><i class="fa fa-map-marker"></i>{{$propertyDetail->Address}}</div>

				<div class="sidebar_box">
					<div class="owner_box">
						<h4>Owner</h4>
						<p>{{$propertyDetail->Owner}}</p>
						<!-- <p>Julia Martynovych</p> -->
					</div>
					<div class="owner_box">
						<h4>APN</h4>
						<p>{{$propertyDetail->Apn}}</p>
					</div>
					<div class="owner_box">
						<h4>Country</h4>
						<p>{{$propertyDetail->County}}</p>
					</div>
				</div>

				<div class="prop_head_link">
					<div class="grid_box">
						<img src="{{asset('assets/affiliate/images/pbed.png')}}">
						<h2>Bedroom</h2>
						<p>{{$propertyDetail->Bedrooms}}</p>
					</div>
					<div class="grid_box">
						<img src="{{asset('assets/affiliate/images/pbath.png')}}">
						<h2>baths ( F/ H )</h2>
						<p>{{$propertyDetail->Bathrooms}}</p>
					</div>
					<div class="grid_box">
						<img src="{{asset('assets/affiliate/images/pliving.png')}}">
						<h2>Living Area</h2>
						<p>2</p>
					</div>
					<div class="grid_box">
						<img src="{{asset('assets/affiliate/images/lotarea.png')}}">
						<h2>Lot Area</h2>
						<p>{{$propertyDetail->LotSize}}</p>
					</div>
				</div>


				<div class="decrp_box">
					<h3>Description</h3>
					<p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.</p>
				</div>

				


				<div class="decrp_box">
					<h3>Madison Huntsville</h3>
					<div class="P_grids">
						<div class="home_grid">
							<h3>Assessor Roll</h3>
							<h4>Available</h4>
							<i class="fa fa-check-circle"></i>
							<p>Last Update Date November, 2019</p>
						</div>
						<div class="home_grid">
							<h3>Assessor Map</h3>
							<h4>Available</h4>
							<i class="fa fa-check-circle"></i>
						</div>
						<div class="home_grid">
							<h3>Flex Search</h3>
							<h4>Available</h4>
							<i class="fa fa-check-circle"></i>
						</div>
					</div>
				</div>


				<!-- <div class="decrp_box"> -->
					<!-- <div class="accordianb_box"> -->
						<!-- <div class="accordian"> -->
							<!-- <div class="accordian-heading">
								Deeds						      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div> -->
							<!-- <div class="accordian_content" style="display: none;">
								<h3>Transaction Data</h3>
								<div class="acord_grid">
									<div class="grid_accord_box">
										<p>Available</p>
										<ul>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Last Record Data</p>
										<ul>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Start Date</p>
										<ul>
											<li>January 1997</li>
											<li>January 1997</li>
											<li>January 1907</li>
											<li>January 1997</li>
											<li>January 1901</li>
											<li>January 2010</li>
											<li>January 2015</li>
										</ul>
									</div>
								</div>
							</div> -->
						<!-- </div> -->
						<!-- <div class="accordian"> -->
							<!-- <div class="accordian-heading">
								Mortgages						      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div> -->
							<!-- <div class="accordian_content">
								<h3>Transaction Data</h3>
								<div class="acord_grid">
									<div class="grid_accord_box">
										<p>Available</p>
										<ul>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Last Record Data</p>
										<ul>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Start Date</p>
										<ul>
											<li>January 1997</li>
											<li>January 1997</li>
											<li>January 1907</li>
											<li>January 1997</li>
											<li>January 1901</li>
											<li>January 2010</li>
											<li>January 2015</li>
										</ul>
									</div>
								</div>
							</div> -->
						<!-- </div>
						<div class="accordian"> -->
							<!-- <div class="accordian-heading">
								Assignments						      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div> -->
							<!-- <div class="accordian_content">
								<h3>Transaction Data</h3>
								<div class="acord_grid">
									<div class="grid_accord_box">
										<p>Available</p>
										<ul>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Last Record Data</p>
										<ul>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Start Date</p>
										<ul>
											<li>January 1997</li>
											<li>January 1997</li>
											<li>January 1907</li>
											<li>January 1997</li>
											<li>January 1901</li>
											<li>January 2010</li>
											<li>January 2015</li>
										</ul>
									</div>
								</div>
							</div> -->
						<!-- </div>
						<div class="accordian"> -->
							<!-- <div class="accordian-heading">
								Releases						      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div> -->
							<!-- <div class="accordian_content">
								<h3>Transaction Data</h3>
								<div class="acord_grid">
									<div class="grid_accord_box">
										<p>Available</p>
										<ul>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Last Record Data</p>
										<ul>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Start Date</p>
										<ul>
											<li>January 1997</li>
											<li>January 1997</li>
											<li>January 1907</li>
											<li>January 1997</li>
											<li>January 1901</li>
											<li>January 2010</li>
											<li>January 2015</li>
										</ul>
									</div>
								</div>
							</div> -->
						<!-- </div>
						<div class="accordian"> -->
							<!-- <div class="accordian-heading">
								Foreclosures						      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div> -->
							<!-- <div class="accordian_content">
								<h3>Transaction Data</h3>
								<div class="acord_grid">
									<div class="grid_accord_box">
										<p>Available</p>
										<ul>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Last Record Data</p>
										<ul>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Start Date</p>
										<ul>
											<li>January 1997</li>
											<li>January 1997</li>
											<li>January 1907</li>
											<li>January 1997</li>
											<li>January 1901</li>
											<li>January 2010</li>
											<li>January 2015</li>
										</ul>
									</div>
								</div>
							</div> -->
						<!-- </div>
						<div class="accordian"> -->
							<!-- <div class="accordian-heading">
								HOA Liens						      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div> -->
							<!-- <div class="accordian_content">
								<h3>Transaction Data</h3>
								<div class="acord_grid">
									<div class="grid_accord_box">
										<p>Available</p>
										<ul>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Last Record Data</p>
										<ul>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Start Date</p>
										<ul>
											<li>January 1997</li>
											<li>January 1997</li>
											<li>January 1907</li>
											<li>January 1997</li>
											<li>January 1901</li>
											<li>January 2010</li>
											<li>January 2015</li>
										</ul>
									</div>
								</div>
							</div> -->
						<!-- </div>
						<div class="accordian"> -->
							<!-- <div class="accordian-heading">
								PACE Liens					      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div> -->
							<!-- <div class="accordian_content">
								<h3>Transaction Data</h3>
								<div class="acord_grid">
									<div class="grid_accord_box">
										<p>Available</p>
										<ul>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
											<li><i class="fa fa-check-circle"></i></li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Last Record Data</p>
										<ul>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
											<li>November 05, 2019</li>
										</ul>
									</div>
									<div class="grid_accord_box">
										<p>Start Date</p>
										<ul>
											<li>January 1997</li>
											<li>January 1997</li>
											<li>January 1907</li>
											<li>January 1997</li>
											<li>January 1901</li>
											<li>January 2010</li>
											<li>January 2015</li>
										</ul>
									</div>
								</div>
							</div> -->
						<!-- </div> -->

					<!-- </div>
				</div>-->


			</div>

			<div class="col-md-4 col-lg-3">
				<div class="mainside">
					<div class="accordianb_box">
						<div class="accordian">
							<div class="accordian-heading">
								Report						      
								<i class="fa fa-plus"></i>
								<i class="fa fa-minus"></i>
							</div>
							<div class="accordian_content">
								<div class="grid_accord_box">
									<ul>
										<li><a href="#">ForeclouseReport <i class="fa fa-download"></i></a></li>
										<li><a href="#">OpenLienReport <i class="fa fa-download"></i></a></li>
										<li><a href="#">PropertyDetialReport <i class="fa fa-download"></i></a></li>
										<li><a href="#">TaxStatusReport <i class="fa fa-download"></i></a></li>
									</ul>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="mainside mt-4">
					<div class="points">
						<ul>
							<li><a href="#"><i class="fa fa-credit-card"></i> Credits</a></li>
						</ul>
					</div>
				</div>	

			</div>
		</div>


	</div>
</section>

     


    </section>
    
<!-- sidebar end -->
	
</div>
    </div>
@endsection        