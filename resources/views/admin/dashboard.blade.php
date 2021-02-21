@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper">
          <div class="row">

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/userList')}}">
                      <p class="mb-0">Bussiness Owner</p>
                      <h6>{{$usersCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/managerList')}}">
                      <p class="mb-0">Bussiness Manager</p>
                      <h6>{{$managerCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="#">
                      <p class="mb-0">Employee</p>
                      <h6>{{$employeeCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="#">
                      <p class="mb-0">Total Users</p>
                      <h6>{{$totalUsersCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

             <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-cash icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="#">
                      <p class="mb-0">Total Revenue</p>
                      <h6>{{$revenue}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

           
          </div>
        </div>
@endsection