@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper">
        <!--  $getdoctor->diseases -->
          <h4 class="card-title">Bussiness Manager</h4>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Bussiness Manager</h6>
                  <div class="row">
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Name</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <div class="br-wrapper br-theme-fontawesome-stars">
                                 {{$data->name}}
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Email</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                                 {{$data->email}}
                          </div>
                        </div>
                      </div>
                    </div>

                   <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         <?php 
                         $url= URL::to('/');
                         ?>
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Profile</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            @if(!empty($data->profile_image))
                            <img src="{{$data->profile_image}}" style="width: 70px; height: 60px;">
                            @else
                            <img src="https://businessmanagement.netsolutionindia.com/admin/images/owner/dummy.jpg" style="width: 70px; height: 60px;">
                            
                            @endif
                           
                          </div>
                          </div>
                        </div>
                      </div>
                    </div>

                </div>
              </div>
            </div>

          </div>

          
           </div>
        
        </div>
@endsection