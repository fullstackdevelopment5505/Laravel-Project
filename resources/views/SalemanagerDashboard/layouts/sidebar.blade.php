<!-- sidebar start -->
<aside class="sidebar">
	<div class="logo"><img src="{{asset('assets/salemanager/images/logo.png')}}"></div>
	<div class="navigation">
		<ul>
			<li class="{{  (Request::path() ==  'salemanager/dashboard') ? 'active_nav' : '' }}"><a href="{{route('salemanagerDashboard')}}"><i class="fa fa-th-large"></i>  <span>Dashboard</span></a></li>
			<li class="{{  (Request::path() ==  'salemanager/properties') ? 'active_nav' : '' }}"><a href="{{route('salemanagerProperties')}}"><i class="fa fa-building-o"></i> <span>Properties</span> </a></li>
			<li class="{{  (Request::path() ==  'salemanager/sale') ? 'active_nav' : '' }}"><a href="{{route('salemanagerSale')}}"><i class="fa fa-line-chart"></i> <span>Sale</span></a></li>
			<li class="{{  (Request::path() ==  'salemanager/member') ? 'active_nav' : '' }}"><a href="{{route('salemanagerCustomer')}}"><i class="fa fa-user"></i> <span>Member</span></a></li>
			<li class="{{  (Request::path() ==  'salemanager/team') ? 'active_nav' : '' }}"><a href="{{route('salemanagerTeam')}}"><i class="fa fa-users"></i> <span>Team</span></a></li>
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