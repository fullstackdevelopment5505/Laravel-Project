        <div class="col-sm-12 topbar">

          <!-- left header start -->
          <div class="top_bar_left">
            <div class="main_logo">
              <!-- <span>A</span><span>8</span> -->
              <a href="#" title="ideal solutions" class="desk_logo"><img height="40" src="{{URL('assets/images/logo.png?ver=1')}}" alt="main logo"></a>
              
               <!--<a href="#" title="ideal solutions" class="mob_logo"><img src="{{URL('public/assets/images/logo.png')}}" alt="main logo"></a> -->
            </div>
            <div class="toggle_bar"><span></span></div>
          </div>
          <!-- left header end -->



          <!-- right header start -->
          <div class="right_top_bar">
            <div class="setting_list">
              <ul>
<!--                 <li><a href="#" data-toggle="tooltip" title="" data-original-title="Triggered Reminder"><img src="{{URL('public/assets/images/admin.png')}}"></a></li> -->
                <li><a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" data-toggle="tooltip" title="" data-original-title="Maintenance"><img src="{{URL('assets/images/log-out.png')}}"></a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
              </ul>
            </div>
          </div>
          <!-- right header end -->
        </div>