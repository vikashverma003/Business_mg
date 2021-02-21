@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper">
        <!--  $getdoctor->diseases -->
          <h4 class="card-title">Bussiness Owner</h4>
          <div class="row">
            <div class="col-md-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body pb-0">
                  <h6 class="card-title">Bussiness Owner</h6>
                  <div class="row">
                    <div class="col-12">
                      <div class="wrapper border-bottom py-2">
                        <div class="d-flex">
                         
                          <div class="wrapper ml-0">
                            <!-- <p class="mb-0">Professional Id</p> -->
                            <small class="text-muted mb-0">Company Name</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <div class="br-wrapper br-theme-fontawesome-stars">
                                 {{$data->company_name}}
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
                            <small class="text-muted mb-0">Name</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            
                                 {{@$data->name}}
                          
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
                            <small class="text-muted mb-0">Company Logo</small>
                          </div>
                          <div class="rating ml-auto d-flex align-items-center">
                            <img src="{{$data->company_logo}}" style="width: 70px; height: 60px;">
                           
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