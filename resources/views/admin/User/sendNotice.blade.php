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
          <h4 class="card-title">Send Formal Notice</h4>
            <div class="col-md-12 d-flex align-items-stretch grid-margin">
              <div class="row flex-grow">
                <div class="col-6 grid-margin">
                  <div class="card">
                    <div class="card-body">
                      <form class="forms-sample" action="{{url('admin/createNotice')}}" method="post" enctype="multipart/form-data">
                         @csrf
                        
                         <div class="form-group">
                          <label for="exampleInputPassword1">Type Of Validation</label>
                          <input type="text" name="validates" class="form-control" id="exampleInputPassword1" placeholder="Enter Company Name" required="">
                          <input type="hidden" value="{{$data->id}}" name="id">
                          <input type="hidden" name="name" value="{{@$parent_id}}">
                        </div>

                        <div class="form-group">
                          
                          <textarea name="description" rows="6" cols="53" placeholder="Eneter Description"></textarea> 
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