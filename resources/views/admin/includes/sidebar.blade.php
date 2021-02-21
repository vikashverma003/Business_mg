@include('admin.includes.sidebar-skin')
<!-- partial:partials/_sidebar.html -->
<nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <div class="nav-link">
                <div class="profile-image">
                  @php
                    $user=Auth::user();
                  
                    @endphp

                  <img src="{{asset($user->profile_image)}}" alt="image" />
                  <span class="online-status online"></span> <!--change class online to offline or busy as needed-->
                </div>
                <div class="profile-name">
                  <p class="name">
                  @yield('user_name')
                  </p>
                  <p class="designation">
                  @yield('role')
                  </p>
                </div>
              </div>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/dashboard')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Dashboard </span>
              </a>
            </li>

            <!--<li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layouts" aria-expanded="false" aria-controls="page-layouts">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Patient</span>
              </a>
              <div class="collapse" id="page-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/users')}}">View Patient</a>
                  </li>
                </ul>
              </div>
            </li>-->
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/userList')}}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Business Owner </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/managerList')}}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Business Manager </span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/reportList')}}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Reports Management</span>
              </a>
            </li>
              <li class="nav-item">
              <a class="nav-link" href="{{url('admin/viewTransaction')}}">
                <i class="mdi mdi-history menu-icon"></i>
                <span class="menu-title">Transactions</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/sendingEmailToUser')}}">
                <i class="mdi mdi-history menu-icon"></i>
                <span class="menu-title">Send Email To User</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/term')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Term & Condition</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>

            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/policy')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Privacy Policy</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="{{url('admin/contact')}}">
                <i class="icon-rocket menu-icon"></i>
                <span class="menu-title">Contact Us</span>
                 <!--<span class="badge badge-success">New</span> -->
              </a>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#page-layoutss" aria-expanded="false" aria-controls="page-layoutss">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">User</span>
              </a>
              <div class="collapse" id="page-layoutss">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/userList')}}">View Manager</a>
                  </li>
                </ul>
              </div>
            </li> -->

           <li class="nav-item">
              <a class="nav-link" data-toggle="collapse" href="#survey-layouts" aria-expanded="false" aria-controls="page-layouts">
                <i class="mdi mdi-settings menu-icon"></i>
                <span class="menu-title">Settings</span>
              </a>
              <div class="collapse" id="survey-layouts">
                <ul class="nav flex-column sub-menu">
                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/departmentlist')}}">Department</a>
                  </li>

                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/paymentlist')}}">Payment</a>
                  </li>

                  <li class="nav-item d-none d-lg-block"> <a class="nav-link" href="{{url('admin/price')}}">Price</a>
                  </li>

                </ul>
              </div>
            </li>

            <!-- <li class="nav-item">
              <a class="nav-link" href="{{url('admin/viewNotice')}}">
                <i class="icon-user menu-icon"></i>
                <span class="menu-title">Formal Notice</span>
              </a>
            </li> -->

              
          </ul>
        </nav>
        <!-- partial -->