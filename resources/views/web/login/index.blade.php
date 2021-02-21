@extends('web.layouts.app')
@section('title', __('messages.header_titles.LOGIN'))

@section('content')

<!-- Login block -->
<section class="login-section header-mt">
    <div class="container">
      <div class="row">
        <div class="col-md-5">
          <h3>Welcome Back,<br> Please Login to your Account</h3>
          <div class="row">
            <div class="col-md-6">
              <button class="linkedIn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_linkedin.png')}}">Linkedin</button>
            </div>
            <div class="col-md-6">
              <button class="facebook-btn text-left mb-4"><img class="mr-4 pl-3 float-left" src="{{asset('web/images/ic_facebook.png')}}">Facebook</button>
            </div>
            <div class="col-md-12 text-center line-block"><hr><span>Or</span></div>
            <div class="col-md-12">
              <form class="login-form mt-4">
                <div class="form-group mb-4">
                  <input class="form-control custom" type="" name="" placeholder="leannon.orion@quinten.net">
                </div>
                <div class="form-group password mb-3">
                  <input class="form-control custom" type="" name="" placeholder="Password">
                  <img class="cursor-pointer" src="{{asset('web/images/ic_show-password.png')}}">
                </div>
                <a class="dp-inline-block mb-5" href="">Forgot Password?</a>
                <button class="theme-button hover-ripple full-width mb-3">Login</button>
                <p class="text-center">Not a member yet? <a href=""> Sign Up </a></p>
              </form>
            </div>
          </div>
        </div>
        <div class="offset-md-2 col-md-5">
          <img class="img-fluid dp-block mx-auto" src="{{asset('web/images/login-bannar.png')}}">
        </div>
      </div>
    </div>
  </section>
  
  

@endsection