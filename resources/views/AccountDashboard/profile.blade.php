@extends('AccountDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('AccountDashboard.layouts.sidebar');
        <!-- right area start -->
        <section class="right_section">
        @include('AccountDashboard.layouts.header');

        <div class="content_area">
      <!-- datepicker -->
      <section id="e_profilebg">
	<div class="container">
		<div class="col-md-6 offset-md-3">
			<div class="profile_box2">
				<h5>Profile</h5>
				<div class="editpic">
					<div class="circle">
				       <img class="profile-pic" src="{{asset('assets/account/images/user.png')}}" style="max-width:60%">
				    </div>
				</div>

				 <div class="user_detail">
			    	<h2>{{$f_name}} {{$l_name}}</h2>
			    	<!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p> -->

			    	<div class="sperator">Info</div>
			    	<ul>
			    		<li><i class="fa fa-envelope-o"></i> {{$email}}</li>
			    		<li><i class="fa fa-phone"></i> {{$phone}}</li>
			    		<li><i class="fa fa-map-marker"></i>{{$add}}, {{$city}},{{$state}},{{$country}}</li>
			    	</ul>

			    	<div class="btns_new">
			    		<a href="#" class="edits"><i class="fa fa-pencil"></i> Edit Profile</a>
			    		<a href="{{route('logout')}}"><i class="fa fa-sign-out"></i> Log out</a>
			    	</div>

			    	<div class="graphs"><img src="{{asset('assets/account/images/graphics.png')}}"></div>

			    </div>

			</div>
		</div>
	</div>
</section>


        
        </div>
        </section>
        </div>
    <!-- main div end -->
@endsection    