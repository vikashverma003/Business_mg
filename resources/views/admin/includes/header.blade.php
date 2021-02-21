<nav class="navbar col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
      <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
        <a class="navbar-brand brand-logo" href="{{url('admin/dashboard')}}">
       <!-- <img src="{{asset('images/logo_2.png')}}" alt="logo" /> -->
        <!-- <h2 style="color:#3bbbca">Vinku App</h2> -->
        </a>
        <a class="navbar-brand brand-logo-mini" href="{{url('admin/dashboard')}}">
         <h4 style="color:#3bbbca">Manager</h4>
                    @php
                    $user=Auth::user();
                    @endphp
                  <img src="{{asset($user->profile_image)}}" alt="logo" />
      
        </a>
      </div>
      <div class="navbar-menu-wrapper d-flex align-items-center">
        <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
          <span class="icon-menu"></span>
        </button>
         <ul class="navbar-nav">
          <li class="nav-item dropdown d-none d-lg-flex">
            <a class="nav-link dropdown-toggle nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
              <span class="btn">+ Create new</span>
            </a>
            <div class="dropdown-menu navbar-dropdown dropdown-left" aria-labelledby="actionDropdown">
              <a class="dropdown-item" href="#">
                <i class="icon-user text-primary"></i>
                User Account
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i class="icon-user-following text-warning"></i>
                Admin User
              </a>
              <div class="dropdown-divider"></div>
              <a class="dropdown-item" href="#">
                <i class="icon-docs text-success"></i>
                Sales report
              </a>
            </div>
          </li>
        </ul> 
        <?php
               $count=\App\User::where(['notification'=>0])->count();
              ?>
        <ul class="navbar-nav navbar-nav-right">
          <li class="nav-item dropdown">
            <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
              <i class="icon-bell mx-0">{{$count}}</i>
              <span class="count"></span>
            </a>
            <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="notificationDropdown">
              <a class="dropdown-item">
                <p class="mb-0 font-weight-normal float-left">You have {{$count}} new notifications
                </p>
               <a href="{{route('view_all_notification')}}"><span class="badge badge-pill badge-warning float-right">View all</span></a>
              </a>
             
             <?php
               $data=\App\User::where(['notification'=>0])->orderBy('created_at', 'DESC')->get();
              ?>
              @foreach($data as $res)
              <div class="dropdown-divider"></div>
              <a href="{{route('user_feedback_update',$res->id)}}" class="dropdown-item preview-item notification_user">
                <div class="preview-thumbnail">
                  @if(!empty($res->profile_image))
                  <img src="{{$res->profile_image}}" style="width: 50px; height: 50px;">
                  @else
                   <img src="https://businessmanagement.netsolutionindia.com/admin/images/owner/dummy.jpg" style="width: 50px; height: 50px;">
                   @endif
                </div>
                <div class="preview-item-content">
                  <h6 class="preview-subject font-weight-medium">{{$res->name}}</h6>
                  <p class="font-weight-light small-text">
                   {{$res->role}}
                  </p>
                </div>
              </a>
              @endforeach
              
            </div>
          </li>
          
          <li class="nav-item nav-settings d-none d-lg-block">
            <a class="nav-link" href="{{url('admin/logout')}}" style="transform: rotate(180deg)">
              <i class="icon-logout" ></i>
            </a>
          </li>
        </ul>
        <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
          <span class="icon-menu"></span>
        </button>
      </div>
    </nav>
    