<!DOCTYPE html>
<html lang="en-US">
   <head>
      <title>@yield('title')</title>
      <meta name="keyword" content="" />
      <meta name="description" content="" />
      <meta charset="utf-8" />
      <meta name="csrf-token" content="{{ csrf_token() }}">
      <meta http-equiv="x-ua-compatible" content="ie=edge" />
      <meta name="viewport" content="width=device-width, initial-scale=1" />
      <link href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
      <link rel="shortcut icon" type="image/png" href="assets/images/icon/favicon.ico" />
      <link href="https://fonts.googleapis.com/css?family=Open+Sans&display=swap" rel="stylesheet">
      <link href="{{URL('assets/css/bootstrap.css')}}" rel="stylesheet" />
      <link href="{{URL('assets/css/jquery.dataTables.min.css')}}" rel="stylesheet" />
      <link href="{{URL('assets/css/style.css?ver=1.0')}}" rel="stylesheet" />
      <!-- <link rel="stylesheet" type="text/css" href="assets/css/owl.carousel.min.css" /> -->
      @yield('css_files')
      <style type="text/css">
        .error_msg{
          text-align: center;
          color: red;
        }
        .success_msg{
          text-align: center;
          color: green;
        }
        .topbar {
    border-bottom: 1px solid #2b3643;
    height: 60px;
    padding: 0 15px;
    display: flex;
    display: -webkit-flex;
    justify-content: space-between;
    -webkit-justify-content: space-between;
    position: fixed;
    right: 0;
    left: 0;
    top: 0;
    background: #2b3643;
    width: auto;
    z-index: 999;
}
.topbar .top_bar_left {
    width: 76%;
    display: flex;
    display: -webkit-flex;
}
.topbar .top_bar_left .main_logo {
    display: flex;
    display: -webkit-flex;
    align-items: center;
    -webkit-align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    min-width: 200px;
}
.main_logo {
    text-align: center;
}
.mobile_search_close, .mobile_search_click, .mob_logo {
    display: none;
}
.topbar .toggle_bar {
    /*border-right: 1px solid #dcdcdc;*/
    display: flex;
    display: -webkit-flex;
    align-items: center;
    -webkit-align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    cursor: pointer;
    min-width: 90px;
}
.topbar .toggle_bar span {
    width: 36px;
    background: #fff;
    height: 4px;
    display: block;
    border-radius: 100px;
    position: relative;
    -webkit-transition: 0.3s;
    -moz-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
}
.topbar .toggle_bar span::before {
    content: "";
    display: block;
    width: 23px;
    height: 4px;
    background: #fff;
    margin-top: -10px;
    border-radius: 100px;
    position: absolute;
    -webkit-transition: 0.3s;
    -moz-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
}
.topbar .toggle_bar span::after {
    content: "";
    display: block;
    width: 23px;
    height: 4px;
    background: #fff;
    margin-top: 10px;
    border-radius: 100px;
    position: absolute;
    -webkit-transition: 0.3s;
    -moz-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
}
.topbar .right_top_bar {
    width: 24%;
    display: flex;
    display: -webkit-flex;
    justify-content: flex-end;
    -webkit-justify-content: flex-end;
}
.right_top_bar .setting_list {
    display: flex;
    display: -webkit-flex;
    align-items: center;
    -webkit-align-items: center;
}
.topbar .right_top_bar .setting_list ul {
    display: flex;
    display: -webkit-flex;
}
.right_top_bar .setting_list li:nth-child(1) a {
    background: transparent;
}
.right_top_bar .setting_list li:nth-child(2) a {
    background: #f0658c;
}
.right_top_bar .setting_list li a {
    height: 45px;
    width: 45px;
    background: white;
    box-shadow: 0 0 10px rgba(29, 41, 57, 0.1);
    border-radius: 100px;
    display: flex;
    display: -webkit-flex;
    align-items: center;
    -webkit-align-items: center;
    justify-content: center;
    -webkit-justify-content: center;
    margin-left: 10px;
    -webkit-transition: 0.3s;
    -moz-transition: 0.3s;
    -o-transition: 0.3s;
    -ms-transition: 0.3s;
}
.sidebar {
    position: fixed;
    min-width: 200px;
    top: 0;
    left: 0;
    bottom: 0;
    background: #364150;
    -webkit-transition: 0.3s;
    -moz-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
    margin-top: 60px;
    z-index: 999;
    padding-bottom: 20px;
}
/*.user_profile {
    padding: 10px;
    display: flex;
    display: -webkit-flex;
    align-items: center;
    -webkit-align-items: center;
    justify-content: space-between;
    -webkit-justify-content: space-between;
    height: 80px;
    background: #364150;
    width: 100%;
    z-index: 999;
    cursor: pointer;
}
.user_profile span {
    border-radius: 100px;
    overflow: hidden;
    display: flex;
    display: -webkit-flex;
    height: 46px;
    width: 46px;
}
.user_profile span img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.user_profile h6 {
    color: #ffff;
    padding-left: 7px;
}
.user_profile i {
    color: #fff;
    margin-left: 10px;
    cursor: pointer;
}*/
.sidebar .side_nav {
    padding: 35px 0 20px 0;
    -webkit-transition: 0.3s;
    -moz-transition: 0.3s;
    -o-transition: 0.3s;
    transition: 0.3s;
    /*overflow-y: auto;*/
    position: absolute;
    top: 5px;
    left: 0;
    right: 0;
    bottom: 0;
    scrollbar-width: none;
}
.sidebar .side_nav > ul > li {
    position: relative;
    border-bottom: 1px solid #1e2d41;
    padding-left: 10px;
}
.sidebar .side_nav > ul > li > a:hover, .sidebar .side_nav > ul > li.active_nav > a {
    background: #eff3f5;
    color: #000;
    box-shadow: 0 0 30px rgba(0,0, 0, 0.2);
}
.sidebar .side_nav > ul > li > a:hover + i, .sidebar .side_nav > ul > li.active_nav > a + i {
    color: #000;
}
.sidebar .side_nav > ul > li > a {
    display: flex;
    display: -webkit-flex;
    align-items: center;
    -webkit-align-items: center;
    justify-content: flex-start;
    -webkit-justify-content: flex-start;
    flex-wrap: wrap;
    -webkit-flex-wrap: wrap;
    color: #fff;
    padding: 15px 10px;
    border-radius: 100px 0 0 100px;
    position: relative;
    text-transform: capitalize;
    font-weight: 500;
    text-align: center;
    text-decoration: none;
}
.sidebar .side_nav > ul > li > a:hover::before, .sidebar .side_nav > ul > li.active_nav > a::before {
    content: "";
    position: absolute;
    top: -19px;
    background-image: url("{{URL('assets/images/nav-before.png')}}");
    background-repeat: no-repeat;
    height: 19px;
    width: 61px;
    right: -1px;
}
.sidebar .side_nav > ul > li > a span {
    width: 26px;
    text-align: center;
    margin-right: 5px;
    line-height: 0;
}
.sidebar .side_nav > ul > li > a:hover img, .sidebar .side_nav > ul > li.active_nav > a img {
    -webkit-filter: brightness(0);
    -moz-filter: brightness(0);
    -o-filter: brightness(0);
    filter: brightness(0);
}
.sidebar .side_nav > ul > li > a:hover::after, .sidebar .side_nav > ul > li.active_nav > a::after {
    content: "";
    position: absolute;
    bottom: -19px;
    background-image: url("{{URL('assets/images/nav-after.png')}}");
    background-repeat: no-repeat;
    background-position: bottom;
    height: 19px;
    width: 61px;
    right: -1px;
}
.sidebar .side_nav > ul > li .dropdown_nav {
    background: #2d4e6b;
    width: 90%;
    margin-left: 10%;
    padding: 10px;
    border-radius: 0px 0 0 15px;
    display: none;
}
.sidebar .side_nav > ul > li .dropdown_nav li a {
    color: #a7c4ea;
    text-transform: capitalize;
    font-size: 15px;
    padding: 7px 0;
    display: block;
    text-decoration: none;
    text-align: left;
}
.sidebar .side_nav > ul > li > i {
    color: #fff;
    position: absolute;
    right: 10px;
    top: 10px;
    cursor: pointer;
}
.col-sm-10.solitude {
    top: 60px;
}
.top_bar_left .main_logo span{
  font-size: 35px;
  color: #fff;
}
.top_bar_left .main_logo span:nth-child(2){
  color: orange;
}
.sidebar.close_sidebar {
    left: -100%;
}

.main-sec.remove_space {
    padding-left: 0px;
}
@media (min-width: 1241px){
  .topbar .right_top_bar {
      display: flex !important;
      display: -webkit-flex !important;
  }
}
      </style>
      @yield('custom_css')

   </head>
   <body onload="myFunction()">
   <div class="ring" id="loader">
   <span class="loader_inr"></span>
	</div>
	
	
	<div style="display:none;" id="myDiv" class="animate-bottom">
      <div class="main-sec">
        @include('layouts.topbar')

      <aside class="col-sm-2  sidebar">
        @include('layouts.sidebar')
      </aside>
         <div class="col-sm-10 solitude">

            @yield('content')
         </div>
         <div class="overflow">
            <div class="cross_icon"><i class="fa fa-remove"></i></div>
         </div>
		 </div>
         <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
         <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.6.0/slick.js"></script> -->
         <script src="{{URL('assets/js/popper.min.js')}}"></script>
         <script src="{{URL('assets/js/bootstrap.min.js')}}"></script>
         <script src="{{URL('assets/js/jquery.dataTables.min.js')}}"></script>

         <script>
            $(document).ready(function() {
            document.getElementsByTagName("html")[0].style.visibility = "visible";
            });
         </script>
         <script src="{{URL('assets/js/owl.carousel.min.js')}}"></script>
         <script>
            $(".nav-btn.pull-left").click(function(){
            $(".sidebar").toggleClass("active_sidebar");
            $(".main-sec").toggleClass("active_main");
            $(".solitude").toggleClass("active_solitude");
            $("body,html").toggleClass("active_body");
            });
            
            
            $(".overflow .cross_icon, .overflow").click(function(){
            $(".sidebar").removeClass("active_sidebar");
            $(".main-sec").removeClass("active_main");
            $(".solitude").removeClass("active_solitude");
            $("body,html").removeClass("active_body");
            });
         </script>
         <script>
            function myFunction() {
              var copyText = document.getElementById("myInput");
              copyText.select();
              document.execCommand("copy");
              
              var tooltip = document.getElementById("myTooltip");
              tooltip.innerHTML = "Copied: " + copyText.value;
            }
            
            function outFunc() {
              var tooltip = document.getElementById("myTooltip");
              tooltip.innerHTML = "Copy to clipboard";
            }
         </script>

			
			<script>
            var myVar;

            function myFunction() {
              myVar = setTimeout(showPage, 1000);
            }

            function showPage() {
              document.getElementById("loader").style.display = "none";
              document.getElementById("myDiv").style.display = "block";
            }

// navigation
$(".sidebar .side_nav > ul > li > a, .sidebar .side_nav > ul > li > i").click(function(){
  $(this).parents("li").find(".dropdown_nav").slideToggle();
  $(this).parents("li").prevAll().removeClass("active_nav");
  $(this).parents("li").prevAll("li").find(".dropdown_nav").slideUp();
  $(this).parents("li").toggleClass("active_nav");
  $(this).parents("li").nextAll().removeClass("active_nav");
  $(this).parents("li").nextAll("li").find(".dropdown_nav").slideUp();
});


// toggle_bar
$(".topbar .toggle_bar").click(function(){
  $(this).toggleClass("active_toggle");
  $(".sidebar").toggleClass("close_sidebar");
  $(".main-sec").toggleClass("remove_space");
});


         </script>
      @yield('js_files')
      @yield('custom_js')
      </div>
	  	
   </body>
</html>