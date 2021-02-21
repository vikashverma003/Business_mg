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
          <h4 class="card-title">Update Reports</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" action="{{url('admin/updatedReports')}}" method="post" enctype="multipart/form-data">
                         @csrf
                        
                         <div class="form-group">
                          <label for="exampleInputPassword1">Name</label>
                          <input type="text" value="{{$singleUser->name}}" name="name" class="form-control" id="exampleInputPassword1" placeholder="Enter Name" required="">
                        </div>

                        <input type="hidden" value="{{$singleUser->id}}" name="id">

                        <div class="form-group">
                          <label for="exampleInputEmail1">Email</label>
                          <input type="email" value="{{$singleUser->email}}" class="form-control" name="email" id="exampleInputEmail1" placeholder="Enter Email" required="">  
                        </div>

                    <div class="form-group">
                    <label for="exampleSelectSuccess">Department</label>
                    <select class="form-control border-success accountTytpe" id="exampleSelectSuccess" name="department" required="">
                       <option value="">--Select--</option>
                    @foreach($department as $res)
                      <option value="{{$res->id}}" {{ $singleUser->department == $res->id ? 'selected' : '' }} >{{$res->name}}</option>
                    @endforeach
                    </select>
                  </div>
                  


                   <div class="form-group">
                    <label for="exampleSelectSuccess">Manager</label>
                    <select class="form-control border-success accountTytpe" id="exampleSelectSuccess" name="manager" required="">
                       <option value="">--Select--</option>
                    @foreach($manager as $res)
                      <option value="{{$res->id}}" {{ $singleUser->manager == $res->id ? 'selected' : '' }}>{{$res->name}}</option>
                    @endforeach
                    </select>
                  </div>

                  <div class="form-group">
                          <label for="exampleInputEmail1">Successfull From</label>
                          <input type="text" value="{{$singleUser->success_from}}" class="form-control" name="successfull_from" id="exampleInputEmail1" placeholder="" required="">  
                  </div>

                      

                         
                      
                    </div>
                  </div>
                </div>

                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                     
                        
                         <div class="form-group">
                          <label for="exampleInputPassword1">Successfull To</label>
                          <input type="text" name="successfull_to" value="{{$singleUser->success_to}}" class="form-control" id="exampleInputPassword1" placeholder="Enter Name" required="">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Satisfactory From </label>
                          <input type="text" class="form-control" value="{{$singleUser->satisfactory_from}}" name="satisfactory_from" id="exampleInputEmail1" placeholder="" required="">  
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Satisfactory To</label>
                          <input type="text" class="form-control" value="{{$singleUser->satisfactory_to}}" name="satisfactory_to" id="exampleInputEmail1" placeholder="" required="">  
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Not Acceptable From </label>
                          <input type="text" class="form-control" value="{{$singleUser->not_accept_from}}" name="acceptable_from" id="exampleInputEmail1" placeholder="" required="">  
                        </div> 

                        <div class="form-group">
                          <label for="exampleInputEmail1">Not Acceptable To </label>
                          <input type="text" class="form-control" value="{{$singleUser->not_accept_to}}" name="acceptable_to" id="exampleInputEmail1" placeholder="" required="">  
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