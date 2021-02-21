@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
      <div class="content-wrapper">
          <div class="row">
             <h4 class="card-title">Add Department</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form action="{{url('admin/CreateDepartment')}}" method="POST" class="forms-sample">
                        @csrf
                        <div class="form-group">
                          <label for="exampleInputEmail1">Name</label>
                          <input type="text" name="name" class="form-control" id="exampleInputEmail1" placeholder="Enter Department" required="">
                             </div>
                         <div class="form-group">
                          <label for="exampleInputEmail1">Check Box</label>
                         <input type="checkbox" id="vehicle1" name="status" value="1">
                             </div>

                         <button type="submit" class="btn btn-success mr-2">Submit</button>
                         
                     </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            
                
          </div>
        </div>

@endsection