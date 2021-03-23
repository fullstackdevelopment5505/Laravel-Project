<!-- header start -->
<header class="header_area">
	<div class="col-sm-6 l_head">
		<div class="toggle">
			<span></span>
		</div>
		<div class="heading_title">
			Dashboard
		</div>
		<!-- <div class="headline"><h2>Account Dashboard</h2></div> -->
	</div>
	<div class="col-sm-6 r_head">
		
		<div class="expand" onclick="toggleFullScreen();"><i class="fa fa-arrows-alt"></i></div>
		<div class="user">
			<span><img src="{{asset('assets/salemanager/images/user.png')}}"> <i class="fa fa-caret-down"></i></span>
			<div class="user_detail">
				<ul>
					<li><a href="{{route('affiliateProfile')}}">My Profile</a></li>
					<li><a href="{{route('affiliate.logout')}}">Logout</a></li>
				</ul>
			</div>
		</div>
	</div>
</header>	
<!-- header end -->

<!-- search -->
<div class="search_popup" id="info">
	<div class="search_data">
		<input type="text" class="form-control" placeholder="Type Here">
		<input type="submit" value="Search" class="btn btn-success">
	</div>
</div>
