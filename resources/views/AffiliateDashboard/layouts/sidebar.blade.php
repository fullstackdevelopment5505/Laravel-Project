<!-- sidebar start -->
<aside class="sidebar">
	<div class="logo"><img src="{{asset('assets/affiliate/images/logo.png')}}"></div>
	<div class="navigation">
		<ul>
			<li class="{{  (Request::path() ==  'affiliateAdmin/dashboard') ? 'active_nav' : '' }}"><a href="{{route('affiliateDashboard')}}"><i class="fa fa-th-large"></i>  <span>Dashboard</span></a></li>
			<li class="{{  (Request::path() ==  'affiliateAdmin/properties') ? 'active_nav' : '' }}"><a href="{{route('affiliateProperties')}}"><i class="fa fa-building-o"></i> <span>Properties</span> </a></li>
			<li class="{{  (Request::path() ==  'affiliateAdmin/sale') ? 'active_nav' : '' }}"><a href="{{route('affiliateSale')}}"><i class="fa fa-line-chart"></i> <span>Sale</span></a></li>
			<li class="{{  (Request::path() ==  'affiliateAdmin/member') ? 'active_nav' : '' }}"><a href="{{route('affiliateCustomer')}}"><i class="fa fa-user"></i> <span>Member</span></a></li>
			<li class="{{  (Request::path() ==  'affiliateAdmin/team') ? 'active_nav' : '' }}"><a href="{{route('affiliateTeam')}}"><i class="fa fa-users"></i> <span>Team</span></a></li>
			<!-- <li class="{{  (Request::path() ==  'salemanager/message') ? 'active_nav' : '' }}"><a href="{{route('sale_manager.message')}}"><i class="fa fa-comments"></i> <span>Messages</span></a></li>

			<!-- <li class="has_dropdown"><a href="#"><i class="fa fa-user"></i> Properties</a>
				<div class="sub_menu">
					<ul>
						<li class="active_subnav"><a href="#">Property</a></li>
						<li><a href="#">Account Books</a></li>
					</ul>
				</div>
			</li> -->
		</ul>
	</div>
</aside>
<!-- sidebar end -->