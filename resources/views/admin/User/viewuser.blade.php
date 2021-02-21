@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')
        
        <div class="content-wrapper" style="min-height: 1545px;">
          <div class="card">
            <div class="card-body">
              <a href="{{url('admin/addOwner')}}" class="btn addLangBtn">
                  Add Owner
                          </a>
                  @foreach($errors->all() as $error)
                      <div class="alert alert-dismissable alert-danger">
                          {!! $error !!}
                      </div>
                  @endforeach

                  @if (session('status'))
                      <div class="alert alert-success">
                          {{ session('status') }}
                      </div>
                  @endif
                <!-- <a href="{{url('admin/adddepartment')}}" class="btn addLangBtn">
                  Add Department
                          </a> -->
              <h4 class="card-title"></h4>
              <div class="row">
                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Series</th>
                            <th width="5%">Name</th>
                            <th width="5%">Status</th>
                            <th width="5%">Company Name</th>
                            <th width="5%">Email</th>
                            <th width="5%">Social Id</th>
                            <th width="10%">Actions</th>
                        </tr>
                      </thead>
                      <tbody>
                       @php $i=0; @endphp
                        @foreach($manager as $user)
                        @php $i++; @endphp
                        <tr>
                            <td> @php echo $i; @endphp</td>
                            <td>{{$user->name}}</td>
                             <td>
                                <label class="badge {{$user->block_status == '0' ? 'badge-success' : 'badge-danger'}}"> {{$user->block_status == '0' ? 'UNBLOCK' : 'BLOCK'}}</label>
                            </td>
                            <td>{{$user->company_name}}</td>
                            <td>{{$user->email}}</td>
                            <td> @if($user->social_id != 0){{$user->social_id}} @endif</td>
                            <td>
                              <ul class="navbar-nav">
                                <li class="nav-item dropdown d-none d-lg-flex">
                                  <a class="nav-link  nav-btn" id="actionDropdown" href="#" data-toggle="dropdown">
                                    <button class="btn btn-outline-primary">Action</button>
                                  </a>
                                  <div class="dropdown-menu navbar-dropdown" aria-labelledby="actionDropdown">
                                    <a href="{{route('ViewOwner',$user->id)}}" class="dropdown-item">View</a>
                                     <a href="{{route('OwnerEdit',$user->id)}}" class="dropdown-item">Edit</a>
                                     @if($user->block_status == '0')
                                      <a href="#" class="dropdown-item" onclick="block_confirmation('{{$user->id}}','Block')">Block</a>
                                    @else
                                    <a href="#" class="dropdown-item" onclick="block_confirmation('{{$user->id}}','Unblock')"> Unblock</a>
                                    @endif
                                      <a href="#" class="dropdown-item" onclick="delete_confirmation('{{$user->id}}')">Delete</a>
                                  </div>
                                </li>
                              </ul>
                            </td>
                        </tr>
                         @endforeach
                      </tbody>
                    </table>                   
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
<script type="text/javascript">
  

   function delete_confirmation(id)
  {
    swal({
        title: "Are you sure want to delete this user?",
        text: "Please ensure and then confirm",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ab8be4",
        confirmButtonText: "Yes",
        closeOnConfirm: false
    })
   
    .then((willDelete) => {
      if (willDelete) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: 'GET',
          url: "{{route('delete_user')}}?user_id="+id,
          success:function(data){
            if(data.success == true)
            {
              swal("Done!", data.message, "success");
            }
            else
            {
              swal("Error!", data.message, "error");
            }
            setTimeout(function(){ location.reload()}, 3000);
          }
        });
      } 
    });
  }


  function block_confirmation(id, status)
  {
    swal({
        title: "Are you sure you want to "+status+"?",
        text: "Please ensure and then confirm",
        type: "warning",
        showCancelButton: true,
        confirmButtonColor: "#ab8be4",
        confirmButtonText: "Yes, "+status+" it!",
        closeOnConfirm: false
    })
   
    .then((willDelete) => {
      if (willDelete) {
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
          type: 'GET',
           url: "{{route('block_user')}}?user_id="+id+"&status="+status,
          success:function(data){
            if(data.success == true)
            {
              swal("Done!", data.message, "success");
            }
            else
            {
              swal("Error!", data.message, "error");
            }
            setTimeout(function(){ location.reload()}, 3000);
          }
        });
      } 
    });
  }
 
</script>
@endsection