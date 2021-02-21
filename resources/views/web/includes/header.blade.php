<!-- Header -->
<header class="fixed-top new-hompage-header  {{ (request()->is('/')) ? '': 'inner' }}">
  <nav class="navbar navbar-expand-lg navbar-light container">
  <a class="navbar-brand" href="{{route('home')}}"><img src="{{asset('web/images/logo.png')}}"></a>
    <button class="navbar-toggler collapsed" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="navbar-collapse collapse" id="navbarSupportedContent" style="">
      <ul class="navbar-nav mr-auto ml-3">
        <li>
          <div class="search-box white-place">
            <input class="" type="" name="" placeholder="Search">
            <img src="{{asset('web/images/ic_search_24px.png')}}">
          </div>
        </li>
      </ul>
      <ul class="navbar-nav ml-auto">
        <li class="nav-item menu-head">
          <a class="nav-link" href="#">{{__('messages.nav.CATEGORIES')}}</a>
          <div class="sub-menu pt-2">
            <ul class="list-inline brdr-1 wd-50 mb-0">
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.ADVERTISING')}}</a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.MEDIA')}}</a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.CIA')}}  </a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.HWB')}}</a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.PM')}}</a></li>
            </ul>
            <ul class="list-inline wd-50  mb-0">
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.RA')}}</a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.CW')}}</a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.LEGAL')}}</a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.BD')}}</a></li>
            <li class="full-width"><a href="nav-link">{{__('messages.nav.cat.VA')}}</a></li>
            </ul>
          </div>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">{{__('messages.nav.OB')}}</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">{{__('messages.nav.WWWU')}}</a>
        </li>
        <li class="nav-item">
          <div class="dropdown sign-up">
          <a class="nav-link dropdown-toggle" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" href="#">{{__('messages.nav.SIGNUP')}}</a>
          <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a class="dropdown-item" href="#">{{__('messages.nav.TODDER')}}</a>
            <hr class="mt-0 mb-0">
            <a class="dropdown-item pt-1" data-toggle="modal" data-target="#exampleModal" href="#">{{__('messages.nav.PO')}}</a>
          </div>
        </div>
        </li>
        <li class="nav-item">
        <a class="nav-link" href="{{route('login.index')}}"><button class="header-btn bordered">{{__('messages.nav.LOGIN')}}</button></a>
        </li>
      </ul>
  </div>
</nav>
</header>