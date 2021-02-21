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
          <h4 class="card-title">Formal Notice</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" action="{{url('admin/UpdateNotice')}}" method="post" enctype="multipart/form-data">
                         @csrf
                        
                         <div class="form-group">
                          <label for="exampleInputPassword1">Violation</label>
                          <input type="text" name="validation" class="form-control" id="exampleInputPassword1" value="{{$data->validation}}" placeholder="Enter Violation" required="">
                          <input type="hidden" name="id" value="{{$data->id}}">
                        </div>

                        <div class="form-group">
                          <label for="exampleInputEmail1">Description</label>
                          <textarea id="w3review" name="description" rows="4" cols="50">{{$data->description}}</textarea>  
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