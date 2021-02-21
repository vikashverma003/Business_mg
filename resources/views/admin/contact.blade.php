@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->first_name." ".$user->last_name)
@section('role',$user->role)
@section('content')
<div class="content-wrapper">
   <div class="row">
    <div class="col-md-6 grid-margin stretch-card">
      <div class="card">
        <div class="card-body pb-0">
          <h6 class="card-title">Contact Us</h6>
            
            <form class="forms-sample mb-4" action="{{url('admin/updateContact')}}" method="post" enctype="multipart/form-data" >
              @csrf
             
              <div class="form-group">
                      <label for="exampleTextarea1">Contact Us</label>
                     <textarea style="height:100px" name="heading" class="form-control" id="content" placeholder="Content" />{{$term->heading}}</textarea>
                    </div>
                
              
                <button type="submit" class=" own_btn_background mr-2 btn  btn-success ">Update</button>
              </form>
        
        </div>
      </div>
    </div>
   </div>
</div>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('content');
</script>
@endsection

