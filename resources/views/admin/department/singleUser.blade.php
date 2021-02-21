@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper" style="min-height: 1545px;">
          <div class="row">


            <div class="col-12 grid-margin">
              <div class="card">
                <div class="row">

                  <div class="col-md-12">
                    <div class="card-body" style="text-align: center;">
                     <div class="profile-image" >
                   @if(!empty($singleUser->profile_image)) 
                  <img src="{{asset($singleUser->profile_image)}}" alt="image"  style="border-radius: 48px; height: 81px; ">
                    @else 
                  <img src="{{asset('admin/images/dummy-image.jpg')}}" alt="image"  style="border-radius: 48px; height: 81px;">
                   @endif 



                  <span class="online-status online"></span> 
                </div>
                    </div>
                  </div>
                
                </div>
              </div>
            </div>

            <div class="col-lg-12">
              <div class="card">
                <div class="card-body">
                  <div class="faq-section">
                    <div class="container-fluid bg-success py-2">
                      <p class="mb-0 text-white">Medical Info </p>
                    </div>
                    <div id="accordion" role="tablist" aria-multiselectable="true" class="accordion">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                                   Do You suffer from any chronic illness?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseOne" class="collapse" role="tabpanel" aria-labelledby="headingOne" style="">
                                <div class="card-body">
                                   {{@$singleUser->userinfo->chronic_illness}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingTwo">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Do You take any Medications?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseTwo" class="collapse" role="tabpanel" aria-labelledby="headingTwo" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->consume_medicines}}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Allergic to any Medications?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseThree" class="collapse" role="tabpanel" aria-labelledby="headingThree" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->allergic_medication}}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" role="tab" id="headingThrees">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseThrees" aria-expanded="false" aria-controls="collapseThrees">
                                    Have you had any fractures?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseThrees" class="collapse" role="tabpanel" aria-labelledby="headingThrees" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->fractures}}
                                </div>
                            </div>
                        </div>


                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-warning py-2 mt-5">
                      <p class="mb-0 text-white">Basic info</p>
                    </div>
                    <div id="accordion-2" role="tablist" aria-multiselectable="true" class="accordion">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne-2">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#accordion-2" href="#collapseOne-2" aria-expanded="false" aria-controls="collapseOne-2" class="collapsed">
                                   Mention your marital Status
                                    </a>
                                
                            </h5></div>
                            <div id="collapseOne-2" class="collapse" role="tabpanel" aria-labelledby="headingOne-2" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->marital_status}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingTwo-3">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-2" href="#collapseTwo-3" aria-expanded="false" aria-controls="collapseTwo-3">
                                     Mention your education level
                                    </a>
                                
                            </h5></div>
                            <div id="collapseTwo-3" class="collapse" role="tabpanel" aria-labelledby="headingTwo-3" style="">
                                <div class="card-body">
                                   {{@$singleUser->userinfo->education_level}}
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree-3">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-2" href="#collapseThree-3" aria-expanded="false" aria-controls="collapseThree-3">
                                    Do you have any underage kids or elder  adults under your supervison?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseThree-3" class="collapse" role="tabpanel" aria-labelledby="headingThree-3" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->supervison}}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree-4">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-2" href="#collapseThree-4" aria-expanded="false" aria-controls="collapseThree-4">
                                   What is your gender?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseThree-4" class="collapse" role="tabpanel" aria-labelledby="headingThree-4" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->gender}}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree-5">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-2" href="#collapseThree-5" aria-expanded="false" aria-controls="collapseThree-5">
                                   When where you born?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseThree-5" class="collapse" role="tabpanel" aria-labelledby="headingThree-5" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->born}}
                                </div>
                            </div>
                        </div>

                        <div class="card">
                            <div class="card-header" role="tab" id="headingThree-6">
                                <h5 class="mb-0">
                                    <a class="collapsed" data-toggle="collapse" data-parent="#accordion-2" href="#collapseThree-6" aria-expanded="false" aria-controls="collapseThree-6">
                                   What is your father name?
                                    </a>
                                
                            </h5></div>
                            <div id="collapseThree-6" class="collapse" role="tabpanel" aria-labelledby="headingThree-6" style="">
                                <div class="card-body">
                                    {{@$singleUser->userinfo->fathername}}
                                </div>
                            </div>
                        </div>

                    </div>
                  </div>
                  <div class="faq-section mt-4">
                    <div class="container-fluid bg-danger py-2 mt-5">
                      <p class="mb-0 text-white">Resedentiol info</p>
                    </div>
                    <div id="accordion-3" role="tablist" aria-multiselectable="true" class="accordion">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne-3">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#accordion-3" href="#collapseOne-3" aria-expanded="false" aria-controls="collapseOne-3" class="collapsed">
                                    Resedentiol info
                                    </a>
                                
                            </h5></div>
                            <div id="collapseOne-3" class="collapse" role="tabpanel" aria-labelledby="headingOne-3" style="">
                                <div class="card-body">
                                    Address Line 1: - {{@$singleUser->userinfo->address1}} <br>
                                    Address Line 2: - {{@$singleUser->userinfo->address2}} <br>
                                    Interior House: - {{@$singleUser->userinfo->interior_house}} <br>
                                    Interior House: - {{@$singleUser->userinfo->interior_house}} <br>
                                    Exterior House: - {{@$singleUser->userinfo->exterior_house}} <br>
                                    Zipcode: -        {{@$singleUser->userinfo->zipcode}} <br>
                                    Country: -        {{@$singleUser->userinfo->country}} <br>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                  </div>

                 <div class="faq-section mt-4">
                    <div class="container-fluid bg-danger py-2 mt-5">
                      <p class="mb-0 text-white">User Document Id  / Selfie / Upload Profile </p>
                    </div>
                    <div id="accordion-7" role="tablist" aria-multiselectable="true" class="accordion">
                        <div class="card">
                            <div class="card-header" role="tab" id="headingOne-7">
                                <h5 class="mb-0">
                                    <a data-toggle="collapse" data-parent="#accordion-3" href="#collapseOne-7" aria-expanded="false" aria-controls="collapseOne-7" class="collapsed">
                                      <img src="{{asset(@$singleUser->userimage->upload_id)}}" alt="logo" style="height: 100px" />
                                      <img src="{{asset(@$singleUser->userimage->selfie)}}" alt="logo" style="height: 100px" />
                                      <img src="{{asset(@$singleUser->userimage->upload_profile)}}" alt="logo" style="height: 100px" />
                                    </a>
                                
                            </h5></div>
                           
                        </div>
                        
                    </div>
                  </div>

                </div>
              </div>
            </div>
          </div>
        </div>
        
@endsection