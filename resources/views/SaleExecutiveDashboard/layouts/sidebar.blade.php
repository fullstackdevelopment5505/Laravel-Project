<!-- sidebar start -->
<aside class="sidebar">
	<div class="logo"><img src="{{asset('assets/saleExecutive/images/logo.png')}}"></div>
	<div class="navigation">
		<ul>
			<li class="{{  (Request::path() ==  'sale-executive/dashboard') ? 'active_nav' : '' }}"><a href="{{route('saleExecutiveDashboard')}}"><i class="fa fa-th-large"></i>  <span>Dashboard</span></a></li>
			<li class="{{  (Request::path() ==  'sale-executive/properties') ? 'active_nav' : '' }}"><a href="{{route('saleExecutiveProperties')}}"><i class="fa fa-building-o"></i> <span>Properties</span> </a></li>
			<li class="{{  (Request::path() ==  'sale-executive/sale') ? 'active_nav' : '' }}"><a href="{{route('saleExecutiveSale')}}"><i class="fa fa-line-chart"></i> <span>Sale</span></a></li>
			<li class="{{  (Request::path() ==  'sale-executive/customer') ? 'active_nav' : '' }}"><a href="{{route('saleExecutiveCustomer')}}"><i class="fa fa-user"></i> <span>Customer</span></a></li>
			<li class="{{  (Request::path() ==  'sale-executive/contact') ? 'active_nav' : '' }}"><a href="{{route('saleExecutiveContact')}}"><i class="fa fa-phone"></i> <span>Contacts</span></a></li>
			<li class="{{  (Request::path() ==  'sale-executive/message') ? 'active_nav' : '' }}"><a href="{{route('saleExecutiveMessage')}}"><i class="fa fa-envelope"></i> <span>Message</span></a></li>
			<li class="{{  (Request::path() ==  'sale-executive/team') ? 'active_nav' : '' }}"><a href="{{route('saleExecutiveTeam')}}"><i class="fa fa-users"></i> <span>Team</span></a></li>
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

