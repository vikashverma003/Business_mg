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
          <h4 class="card-title">Update Price</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" action="{{url('admin/Updateprice')}}" method="post" enctype="multipart/form-data">
                         @csrf
                        
                         <div class="form-group">
                          <label for="exampleInputPassword1">Price</label>
                          <input type="text" name="price" value="{{$data->price}}" class="form-control" id="exampleInputPassword1" placeholder="Enter Company Name" required="">
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