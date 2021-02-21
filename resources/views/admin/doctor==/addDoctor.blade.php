@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
      

      <div class="content-wrapper">
        <div class="row">
          <h4 class="card-title">General Documentation</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" action="{{url('admin/addDoctor')}}" method="post" enctype="multipart/form-data">
                         @csrf
                         <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" class="form-control" name="doctorname" id="exampleInputEmail1" placeholder="Enter Name" required="">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Professional card</label>
                          <input type="text" class="form-control" name="professional_card" id="exampleInputEmail1" placeholder="Enter email" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputPassword1">Professional title</label>
                      <input type="file" name="professional_title" id="professional_title" class="file-upload-default"  required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="title_Professional" style="color: red;"></span>
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Official identification</label>
                           <input type="file" name="official_identification" id="official_identification" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="official_ident" style="color: red;"></span>
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Curp</label>
                          <input type="text" name="curp" class="form-control" id="exampleInputPassword1" placeholder="Enter Curp" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">RFC</label>
                          <input type="text" name="rfc" class="form-control" id="exampleInputPassword1" placeholder="Enter RFC" required="">
                        </div>
                         <div class="form-group">
                      <label>Proof of address</label>
                      <input type="file" name="proof_address" id="proof_address" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="proof_add" style="color: red"></span>
                    </div>
                      
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                       <div class="form-group">
                          <label for="exampleInputPassword1">Email</label>
                          <input type="email" name="email" class="form-control" id="exampleInputPassword1" placeholder="Password" required="">
                        </div>

                       <div class="form-group">
                      <label></label>
                      <input type="file" name="professional_document" id="professional_document" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="professional_doc" style="color: red;"></span>
                    </div>

                       <div class="form-group">
                      <label></label>
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" style="" placeholder="" required=""> 
                        <span class="input-group-btn">
                        </span>
                      </div>
                    </div>

                    <div class="form-group">
                      <label></label>
                      <input type="file" class="file-upload-default" >
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="">
                        <span class="input-group-btn">
                        
                        </span>
                      </div>
                    </div>


                    <div class="form-group">
                      <label></label>
                      <input type="file" name="curp_document" id="curp_document" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="curp_doc" style="color: red;"></span>
                    </div>
                    <div class="form-group">
                      <label></label>
                      <input type="file" name="rfc_document" id="rfc_document" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="rfc_doc" style="color: red;"></span>
                    </div>

                    <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" name="doctorpassword" class="form-control" id="exampleInputPassword1" placeholder="Password" required="">
                        </div>
                       
                    </div>
                  </div>
                </div>
              </div>
            </div>



             <h4 class="card-title">Billing data</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                  
                     
                        <div class="form-group">
                          <label for="exampleInputEmail1">Company name </label>
                          <input type="text" name="company_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Company name" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Address</label>
                          <input type="text" name="address" class="form-control" id="exampleInputEmail1" placeholder="Enter Address" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Municipality</label>
                          <input type="text" name="municipality" class="form-control" id="exampleInputEmail1" placeholder="Enter Municipality" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Zip code</label>
                          <input type="text" name=" zipcode" class="form-control" id="exampleInputPassword1" placeholder="Zip code" required="">
                        </div>
                         <div class="form-group">
                          <label for="exampleInputPassword1">Mail</label>
                          <input type="email" name="mail" class="form-control" id="exampleInputPassword1" placeholder="Password" required="">
                        </div>
                         
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                       <div class="form-group">
                          <label for="exampleInputEmail1">Name or RFC </label>
                          <input type="text" name="name_rfc" class="form-control" id="exampleInputEmail1" placeholder="Enter Name or RFC " required="">
                        </div>

                       <div class="form-group">
                          <label for="exampleInputEmail1">Number</label>
                          <input type="text" name="number" class="form-control" id="exampleInputEmail1" placeholder="Enter Number " required="">
                        </div>

                     <div class="form-group">
                          <label for="exampleInputEmail1">State</label>
                          <input type="text" name="state" class="form-control" id="exampleInputEmail1" placeholder="Enter State " required="">
                        </div>


                    <div class="form-group">
                          <label for="exampleInputEmail1">Telephone</label>
                          <input type="text" name="telephone" class="form-control" id="exampleInputEmail1" placeholder="Enter State " required="">
                        </div>
                       
                    </div>
                  </div>
                </div>
              </div>
            </div>



             <h4 class="card-title">Use of CFDI</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                  
                      
                        <div class="form-group">
                          <label for="exampleInputEmail1">Purchase of goods</label>
                          <input type="text" name="purchase_goods" class="form-control" id="exampleInputEmail1" placeholder="Enter Purchase of goods" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Computer equipment and accessories</label>
                          <input type="text" name="accessories" class="form-control" id="exampleInputEmail1" placeholder="Enter Computer equipment and accessories" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Satellite communications</label>
                          <input type="text" name="satellite_communications" class="form-control" id="exampleInputEmail1" placeholder="Enter Satellite communications" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Medical expenses for disability or handicap</label>
                          <input type="text" name="handicap" class="form-control" id="exampleInputPassword1" placeholder="Medical expenses for disability or handicap" required="">
                        </div>
                         <div class="form-group">
                          <label for="exampleInputPassword1">Payments for educational services (tuition)</label>
                          <input type="text" name="educational_services" class="form-control" id="exampleInputPassword1" placeholder="Enter educational services" required="">
                        </div>
                         
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                       <div class="form-group">
                          <label for="exampleInputEmail1">Returns, discounts or rebates </label>
                          <input type="text" name="returns" class="form-control" id="exampleInputEmail1" placeholder="Enter Returns" required="">
                        </div>

                       <div class="form-group">
                          <label for="exampleInputEmail1">Telephone communications</label>
                          <input type="text" name="telephone_communications" class="form-control" id="exampleInputEmail1" placeholder="Enter Telephone communications " required="">
                        </div>

                     <div class="form-group">
                          <label for="exampleInputEmail1">Medical, dental and hospital fees</label>
                          <input type="text" name="hospital_fees" class="form-control" id="exampleInputEmail1" placeholder="Enter Medical, dental and hospital fees " required="">
                        </div>


                    <div class="form-group">
                          <label for="exampleInputEmail1">Health insurance premiums</label>
                          <input type="text" name="insurance_premiums" class="form-control" id="exampleInputEmail1" placeholder="Enter insurance premiums" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">To be defined</label>
                          <input type="text" name="be_defined" class="form-control" id="exampleInputEmail1" placeholder="Enter insurance premiums" required="">
                        </div>
                       
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <h4 class="card-title">Deposit data</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                  
                        <div class="form-group">
                          <label for="exampleInputEmail1">Bank account</label>
                          <input type="text" name="bank_account" class="form-control" id="exampleInputEmail1" placeholder="Enter Bank account" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">Type of account</label>
                          <input type="text" name="account_type" class="form-control" id="exampleInputEmail1" placeholder="Enter Computer equipment and accessories" required="">
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Interbank type</label>
                          <input type="text" name="interbank_type" class="form-control" id="exampleInputEmail1" placeholder="Enter Interbank type" required="">
                        </div>

                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                      <div class="form-group">
                      <label></label>
                      <input type="file" name="bank_document" id="bank_document" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="bank_doc" style="color: red;"></span>
                    </div>

                    <div class="form-group">
                    <label for="exampleSelectSuccess">Type of person</label>
                    <select class="form-control border-success" id="exampleSelectSuccess" name="person_type" required="">
                       <option value="">--Select--</option>
                      <option value="physical">Physical</option>
                      <option value="moral">Moral</option>
                    </select>
                  </div>

                 <div class="form-group">
                          <label for="exampleInputEmail1">Bank name</label>
                          <input type="text" name="bank_name" class="form-control" id="exampleInputEmail1" placeholder="Enter Bank name" required="">
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


            <h4 class="card-title">Fiscal keys</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                    <div class="form-group">
                      <label>CSD Digital Seal Certificate</label>
                      <input type="file" name="seal_certificate" id="seal_certificate" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="seal_cert" style="color: red;"></span>
                    </div>

                         <div class="form-group">
                          <label for="exampleInputEmail1">FIEL electronic signature</label>
                         <input type="file" name="electronic_signature" id="electronic_signature" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="electronic_sig" style="color: red"></span>
                        </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Password</label>
                          <input type="password" name="password" class="form-control" id="exampleInputEmail1" placeholder="Enter Password" required="">
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


        <h4 class="card-title">Medical Chat display information</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Full name</label>
                          <input type="text" name="chatfullname" class="form-control" id="exampleInputEmail1" placeholder="Enter Full name" required="">
                        </div>

                        <div class="form-group">
                           <label for="exampleSelectSuccess">Language</label>
                        <select class="form-control border-success" id="exampleSelectSuccess" name="chatlanguage" required="">
                           <option value="">--Select--</option>
                           <option value="physical">Spanish</option>
                           <option value="moral">German</option>
                        </select>
                      </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Years of experience</label>
                          <input type="number" name="chatexperience" class="form-control" id="exampleInputEmail1" placeholder="Enter experience" required="">
                        </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Workplace</label>
                          <input type="number" name="chatworkplace" class="form-control" id="exampleInputEmail1" placeholder="Enter Workplace" required="">
                      </div>

                         
                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">

                      <div class="form-group">
                          <label for="exampleInputEmail1">Professional card</label>
                          <input type="text" name="chatprofessional_card" class="form-control" id="exampleInputEmail1" placeholder="Enter Professional card" required="">
                        </div>

                     <div class="form-group">
                          <label for="exampleInputEmail1">Short personal description</label>
                          <input type="text" name="chatshort_description" class="form-control" id="exampleInputEmail1" placeholder="Enter personal description" required="">
                        </div>

                 <div class="form-group">
                          <label for="exampleInputEmail1">Degrees</label>
                          <input type="text" name="chatdegrees" class="form-control" id="exampleInputEmail1" placeholder="Enter Degrees" required="">
                        </div>

                  <div class="form-group">
                      <label>Profile photo</label>
                      <input type="file" name="chatprofile_photo"  id="chatprofile_photo" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="chatprofile_ph" style="color: red"></span>
                    </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>


            <h4 class="card-title">Medical Pro Display Information</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Full name</label>
                          <input type="text" name="fullname" class="form-control" id="exampleInputEmail1" placeholder="Enter Full name" required="">
                        </div>

                        <div class="form-group">
                           <label for="exampleSelectSuccess">Language</label>
                        <select class="form-control border-success" id="exampleSelectSuccess" name="language" required="">
                           <option value="">--Select--</option>
                           <option value="physical">Spanish</option>
                           <option value="moral">German</option>
                        </select>
                      </div>
                        <div class="form-group">
                          <label for="exampleInputEmail1">Years of experience</label>
                          <input type="number" class="form-control" id="exampleInputEmail1" name="experience" placeholder="Enter experience" required="">
                        </div>
                      <div class="form-group">
                          <label for="exampleInputEmail1">Workplace</label>
                          <input type="text" name="workplace" class="form-control" id="exampleInputEmail1" placeholder="Enter Workplace" required="">
                      </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Average Price of Consultation</label>
                          <input type="number" name="average_price" class="form-control" id="exampleInputEmail1" placeholder="Enter Workplace" required="">
                      </div>

                       <div class="form-group">
                          <label for="exampleInputEmail1">Awards</label>
                          <input type="text" name="awards" class="form-control" id="exampleInputEmail1" placeholder="Enter Awards" required="">
                      </div>

                       <div class="form-group">
                      <label>Profile photo</label>
                      <input type="file" name="profile_photo" id="profile_photo" class="file-upload-default" required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Image" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="profile_ph" style="color: red;"></span>
                    </div>

                    </div>
                  </div>
                </div>
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <div class="form-group">
                          <label for="exampleInputEmail1">Professional card</label>
                          <input type="text" name="professional_card" class="form-control" id="exampleInputEmail1" placeholder="Enter Professional card" required="">
                        </div>

                  <div class="form-group">
                          <label for="exampleInputEmail1">Short personal description</label>
                          <input type="text" name="short_description" class="form-control" id="exampleInputEmail1" placeholder="Enter personal description" required="">
                        </div>

                  <div class="form-group">
                          <label for="exampleInputEmail1">University</label>
                          <input type="text" name="university" class="form-control" id="exampleInputEmail1" placeholder="Enter University" required="">
                        </div>
                  <div class="form-group">
                          <label for="exampleInputEmail1">Working hours</label>
                          <input type="text" name="working_hours" class="form-control" id="exampleInputEmail1" placeholder="Enter Working hours" required="">
                        </div>
                 <div class="form-group">
                          <label for="exampleInputEmail1">Degrees</label>
                          <input type="text" name="degrees" class="form-control" id="exampleInputEmail1" placeholder="Enter Degrees" required="">
                        </div>
                  <div class="form-group">
                          <label for="exampleInputEmail1">Contact number</label>
                          <input type="text" name="contact_number" class="form-control" id="exampleInputEmail1" placeholder="Enter Contact number" required="">
                        </div>

                    </div>
                  </div>
                </div>
              </div>
            </div>



            <h4 class="card-title">Doctor Status</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Pre-registration</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="registration" name="pre_registration" value="completed" required="">
                              Completed
                            <i class="input-helper"></i></label>
                          </div>

                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="registration" name="pre_registration" value="pending" required="">
                              Pending
                            <i class="input-helper"></i></label>
                          </div>

                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="registration" name="pre_registration" value="rejected" required="">
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>

                 <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Presentation</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Presentation" name="presentation" value="completed" required="">
                              Completed
                            <i class="input-helper"></i></label>
                          </div>

                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Presentation" name="presentation" value="pending" required="">
                              Pending
                            <i class="input-helper"></i></label>
                          </div>

                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Presentation" name="presentation" value="rejected" required="">
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>



            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Interview</label>
                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Interview" name="interview" value="completed" required="">
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Interview" name="interview" value="pending" required="">
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Interview" name="interview" value="rejected" required="">
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                 <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Signing of contract </label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="contract" name="contract" value="completed" required="">
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="contract" name="contract" value="pending" required="">
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="contract" name="contract" value="rejected" required="">
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>


             <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Photo Registration</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Photo" name="photo_registration" value="completed" required="">
                              Completed
                            <i class="input-helper"></i></label>
                          </div>

                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Photo" name="photo_registration" value="pending" required="">
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Photo" name="photo_registration" value="rejected" required="">
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
                 <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                        <div class="form-group">
                          <label for="exampleInputEmail1">Activation</label>

                         <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="activation" value="completed" required="">
                              Completed
                            <i class="input-helper"></i></label>
                          </div>
                          <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="activation" value="pending" required="">
                              Pending
                            <i class="input-helper"></i></label>
                          </div>
                           <div class="form-check form-check-flat">
                            <label class="form-check-label">
                               <input type="radio" id="Activation" name="activation" value="rejected" required="">
                              Rejected
                            <i class="input-helper"></i></label>
                          </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          <button type="submit" class="btn btn-success mr-2 submit_button">Submit</button>
     </form>
          </div>
        </div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script>
$(document).ready(function(){
  $(".submit_button").click(function(){
    var professional_title =$('#professional_title').val();
    if(professional_title == ''){
      $('#title_Professional').html('Feild is required');
    }else{
      $('#title_Professional').html('');
    }


     var professional_document =$('#professional_document').val();
    if(professional_document == ''){
      $('#professional_doc').html('Feild is required');
    }else{
       $('#professional_doc').html('');
    }



    var official_identification =$('#official_identification').val();
    if(official_identification == ''){
      $('#official_ident').html('Feild is required');
    }else{
       $('#official_ident').html('');
    }


    var curp_doc =$('#curp_document').val();
    if(curp_doc == ''){
      $('#curp_doc').html('Feild is required');
    }else{
      $('#curp_doc').html('');
    }


    var rfc_document =$('#rfc_document').val();
    if(rfc_document == ''){
      $('#rfc_doc').html('Feild is required');
    }else{
      $('#rfc_doc').html('');
    }

    var bank_document =$('#bank_document').val();
    if(bank_document == ''){
      $('#bank_doc').html('Feild is required');
    }else{
      $('#bank_doc').html('');
    }

    var seal_certificate =$('#seal_certificate').val();
    if(seal_certificate == ''){
      $('#seal_cert').html('Feild is required');
    }else{
      $('#seal_cert').html('');
    }

    var electronic_sig =$('#electronic_signature').val();
    if(electronic_sig == ''){
      $('#electronic_sig').html('Feild is required');
    }else{
      $('#electronic_sig').html('');
    }

    var chatprofile_photo =$('#chatprofile_photo').val();
    if(chatprofile_photo == ''){
      $('#chatprofile_ph').html('Feild is required');
    }else{
      $('#chatprofile_ph').html('');
    }
    
    var profile_photo =$('#profile_photo').val();
    if(profile_photo == ''){
      $('#profile_ph').html('Feild is required');
    }else{
      $('#profile_ph').html('');
    }

    var proof_address =$('#proof_address').val();
    if(proof_address == ''){
      $('#proof_add').html('Feild is required');
    }else{
      $('#proof_add').html('');
    }

    
    
  });
});
</script>

@endsection