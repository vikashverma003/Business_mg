@extends('admin.layouts.app1')
@section('title',$title)

@section('content')
<div class="container-scroller">
    <div class="container-fluid page-body-wrapper">
      <div class="row">
         <div class="content-wrapper full-page-wrapper d-flex align-items-center auth">
            <div class="row w-100">
              <div class="col-lg-8 mx-auto">
                    @if (\Session::has('error'))
                    <div class="alert alert-danger">
                       {!! \Session::get('error') !!}
                    </div>
                  @endif
                <div class="row">
                  <div class="col-lg-6 bg-white">
                    <div class="auth-form-light text-left p-5">
                      <h2>Login</h2>
                      <h4 class="font-weight-light">Hello! let's get started</h4>
                      <form class="pt-5" action="{{url('admin/check_user')}}"  method="post">
                        @csrf

                          <div class="form-group">
                            <label for="exampleInputEmail1">Username</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"  name="email" value="{{ old('email') }}
                            " placeholder="Email" required>
                            <i class="mdi mdi-account"></i>
                            @if ($errors->has('email'))
                            <div class="error">{{ $errors->first('email') }}</div>
                            @endif
                          </div>
                          <div class="form-group">
                            <label for="exampleInputPassword1">Password</label>
                            <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password" required>
                            <i class="mdi mdi-eye"></i>
                            @if ($errors->has('password'))
                            <div class="error">{{ $errors->first('password') }}</div>
                            @endif
                          </div>
                          <div class="mt-5">

                            <input type="submit" class="btn btn-block btn-success btn-lg font-weight-medium" value="Login" />
                          </div>
                          <div class="mt-3 text-center">
                            <a href="#" class="auth-link text-black">Forgot password?</a>
                          </div>
                        </form>

                    </div>
                  </div>
                  <div class="col-lg-6 login-half-bg d-flex flex-column align-self-center">
				  <img class="img-logo" src="{{asset('images/logo_3.png')}}" alt="" />
                   <!-- <p class="font-weight-medium text-center flex-grow">Copyright © 2018  All rights reserved.</p>-->
                  </div>
                </div>
              </div>
            </div>
          </div>
      </div>
        <!-- content-wrapper ends -->
      </div>
      <!-- row ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->

  @endsection