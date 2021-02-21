@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
      
<style type="text/css">
  .field-icon {
    font-size: 15px;
    position: absolute;
    right: 9px;
    top: 11px;
}

</style>
      <div class="content-wrapper">
        <div class="row">
          <h4 class="card-title">Bussiness Owner</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" action="{{url('admin/createOwner')}}" method="post" enctype="multipart/form-data">
                         @csrf
                        
                         <div class="form-group">
                          <label for="exampleInputPassword1">Company Name</label>
                          <input type="text" name="company_name" class="form-control" id="exampleInputPassword1" placeholder="Enter Company Name" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input type="email" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter Email" required="">  
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Password</label>
                          <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Enter Password" required="">
                        </div>

                         <div class="form-group">
                          <label for="exampleInputPassword1">Company Logo</label>
                      <input type="file" name="company_logo" id="curp_document" class="file-upload-default"  required="">
                      <div class="input-group col-xs-12">
                        <input type="text" class="form-control file-upload-info" disabled="" placeholder="Upload Company logo" required="">
                        <span class="input-group-btn">
                          <button class="file-upload-browse btn btn-info" type="button">Upload</button>
                        </span>
                      </div>
                      <span id="curp_doc" style="color: red;"></span>
                        </div>
                       <button type="submit" class="btn btn-success mr-2 submit_button">Submit</button>
                    </div>
                  </div>
                </div>
                
              </div>

            </div>
     </form>
          </div>
        </div>

@endsection