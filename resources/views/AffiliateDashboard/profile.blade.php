@extends('AffiliateDashboard.master')
@section('content')
    <!-- main div start -->
    <div class="main_area">
        @include('AffiliateDashboard.layouts.sidebar');
        <!-- right area start -->
        <section class="right_section">
        @include('AffiliateDashboard.layouts.header');

        <div class="content_area">
      <!-- datepicker -->
      <section id="e_profilebg">
	<div class="container">
		<div class="col-md-6 offset-md-3">
			<div class="profile_box2">
				<h5>Profile</h5>
				<div class="editpic">
					<div class="circle">
				       <img class="profile-pic" src="{{asset('assets/affiliate/images/user.png')}}">
				    </div>
				</div>

				 <div class="user_detail">
			    	<h2>{{$f_name}}</h2>
			    	<!-- <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s</p> -->
			    	<div class="sperator">Info</div>
					<input type="text" class="form-control" value="{{$url.'shareaffiliate#'.$username}}" id="myInput">
					<button type="button" class="btn btn-info" onclick="myFunction()">Copy text</button>
			    	<ul>
			    	
			    		<li><i class="fa fa-phone"></i> {{$email}}</li>
			    		<li><i class="fa fa-phone"></i> {{$phone}}</li>
			    		<li><i class="fa fa-map-marker"></i>{{$address}}, {{$city}},{{$state}},{{$zipcode}},{{$country}}</li>
			    	</ul>

			    	<div class="btns_new">
			    		<a href="#" class="edits"><i class="fa fa-pencil"></i> Edit Profile</a>
			    		<a href="{{route('affiliate.logout')}}"><i class="fa fa-sign-out"></i> Log out</a>
			    	</div>

			    	<div class="graphs"><img src="{{asset('assets/affiliate/images/graphics.png')}}"></div>

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
@section('page_js') 
<script>
  /* Get the text field */
  var copyText = document.getElementById("myInput");

  /* Select the text field */
  copyText.select();
  copyText.setSelectionRange(0, 99999); /*For mobile devices*/

  /* Copy the text inside the text field */
  document.execCommand("copy");

  /* Alert the copied text */
  alert("Copied the text: " + copyText.value);
}
$(document).ready(function () {
	$('#phone').usPhoneFormat({
		format: '(xxx) xxx-xxxx',
	});
	$('#postal_code').usZipFormat({
		format: 'xxxxx-xxxx',
	});
});
</script>
@endsection  