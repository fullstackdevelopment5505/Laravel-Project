        <div class="side_nav">
          <ul>
            <li @if(Request::is("home")) class="active_nav" @endif>
              <a href="{{URL('home')}}"><span><img src="{{URL('assets/images/gridicon.png')}}"></span> Dashboard</a>
            </li>
            <li @if(Request::is("users*")) class="active_nav" @endif>
              <a href="#"><span><img src="{{URL('assets/images/gridicon.png')}}"></span> Users</a>
              <i class="fa fa-angle-down"></i>
              <div class="dropdown_nav" @if(Request::is("users*")) style="display: block" @endif>
                <ul>
                  <li><a href="{{URL('users')}}">All Users</a></li>
                  <li><a href="{{URL('users/verified')}}">Verified Users</a></li>
                  <li><a href="{{URL('users/unverified')}}">Un-verified Users</a></li>
                </ul> 
              </div>
            </li>
            <li @if(Request::is("kickstarter*")) class="active_nav" @endif>
              <a href="#"><span><img src="{{URL('assets/images/gridicon.png')}}"></span> Kickstarters</a>
              <i class="fa fa-angle-down"></i>
              <div class="dropdown_nav" @if(Request::is("kickstarter*")) style="display: block" @endif>
                <ul>
                  <li><a href="{{URL('kickstarter')}}">All Kickstarters</a></li>
                  <li><a href="{{URL('kickstarter/add')}}">Add Kickstarters</a></li>
                </ul> 
              </div>
            </li>
            <li @if(Request::is("subscriber*")) class="active_nav" @endif>
              <a href="#"><span><img src="{{URL('assets/images/gridicon.png')}}"></span> Subscribers</a>
              <i class="fa fa-angle-down"></i>
              <div class="dropdown_nav" @if(Request::is("subscriber*")) style="display: block" @endif>
                <ul>
                  <li><a href="{{URL('subscriber')}}">Subscribers</a></li>
                </ul> 
              </div>
            </li>
            <li @if(Request::is("contact*")) class="active_nav" @endif>
              <a href="#"><span><img src="{{URL('assets/images/gridicon.png')}}"></span> Contact us</a>
              <i class="fa fa-angle-down"></i>
              <div class="dropdown_nav" @if(Request::is("contact*")) style="display: block" @endif>
                <ul>
                  <li><a href="{{URL('contact')}}">Contact us</a></li>
                </ul> 
              </div>
            </li>  
            <li @if(Request::is("pages*")) class="active_nav" @endif>
              <a href="#"><span><img src="{{URL('assets/images/gridicon.png')}}"></span> CMS Pages</a>
              <i class="fa fa-angle-down"></i>
              <div class="dropdown_nav" @if(Request::is("pages*")) style="display: block" @endif>
                <ul>
                  <li><a href="{{URL('pages/about')}}">About</a></li>
                  <li><a href="{{URL('pages/terms')}}">Terms</a></li>
                  <li><a href="{{URL('pages/faq')}}">FAQ</a></li>
                  <li><a href="{{URL('pages/privacy')}}">Privacy</a></li>
                </ul> 
              </div>
            </li> 
            <li @if(Request::is("search*")) class="active_nav" @endif>
              <a href="#"><span><img src="{{URL('assets/images/gridicon.png')}}"></span> Search</a>
              <i class="fa fa-angle-down"></i>
              <div class="dropdown_nav" @if(Request::is("search*")) style="display: block" @endif>
                <ul>
                  <li><a href="{{URL('search/all')}}">All</a></li>
                  <li><a href="{{URL('search/pending')}}">Pending</a></li>
                  <li><a href="{{URL('search/closed')}}">Closed</a></li>
                  <!-- <li><a href="{{URL('search/rejected')}}">Rejected</a></li> -->
                </ul> 
              </div>
            </li>                  
          </ul>
        </div>