@extends('admin.layouts.app')
@section('title',$title)
@section('content')

        <div class="content-wrapper" style="min-height: 1545px;">
          <div class="card">
            <div class="card-body">
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
              <h4 class="card-title"></h4>
              <div class="row">

                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Series</th>
                            <th width="5%">Name</th>
                            <th width="5%">Email</th>
                            <th width="5%">Role</th>
                            <th width="5%">Date</th>
                            <th width="5%">Notify User</th>
                            
                        </tr>
                      </thead>

                      <tbody>
                       @php $i=0; @endphp
                        @foreach($user as $users)
                        @php $i++; @endphp
                        <tr>
                            <td> @php echo $i; @endphp</td>
                            <td>{{$users->name!=''?$users->name:'--'}}</td>
                            <td>{{$users->email}}</td>
                            <td>{{$users->role}}</td>
                             <td>{{$users->created_at}}</td>
                             <td><button type="button" class="btn btn-primary btn-sm user_id" data-id="{{$users->id}}"   data-toggle="modal" data-target="#ModalExample">
                    Send Email</button></td>

                        </tr>
                         @endforeach
                      </tbody>
                    </table>                   
                  </div>
                </div>
                  
            </div>
              <!-- Modal HTML Markup -->
            <div id="ModalExample" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-xs-center">Enter Text Message</h4>
                        </div>
                        <div class="modal-body">
                            <form id="sendEmail">
                                @csrf
                                <input type="hidden" name="_token" value="">
                               <!-- <input type="hidden" name="user_id1" id="user_id1" value="{{$users['_id']}}"/> -->
                                <input type="hidden" name="cafeId" id="cafeId" />
                                 <div class="form-group required">
                                  <div class="row">
                                        <div class="col-md-12">
                                  <label class="control-label" for="name"> Enter Message </label>
                                    <textarea row="3" style="height:100px" name="email_message" id="email_message"></textarea>
                                </div></div></div>
                                  </div>
                                  <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                  <button type="submit" name="submit" class="btn btn-secondary" >Submit</button>
                        </div>     
                            </form>
                        </div>
                      
                    </div><!-- /.modal-content -->
                </div>
           
          </div>
</div></div>
<script src="//code.jquery.com/jquery.js"></script>
<script src="//cdn.datatables.net/1.10.7/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/sweetalert/1.1.3/sweetalert.min.js"></script>
<script src="//cdn.ckeditor.com/4.14.0/standard/ckeditor.js"></script>
<script type="text/javascript">
    CKEDITOR.replace('email_message');
</script>

<script>
$(document).ready(function(){
  $(".user_id").click(function(){ // Click to only happen on announce links
    var d= $(this).data('id');
  $('#cafeId').val(d);
  var user_id=$("#cafeId").val();
   });
});

</script>

<script type="text/javascript">
$(document).on('submit','#sendEmail',function(e){
  //alert(232);
            e.preventDefault();
            var message=$("#email_message").val();
            //var user_id=$("#user_id1").val();
            var user_id=$("#cafeId").val();
            $.ajax({
                type:'POST',
                url:'{{route("sendingEmail")}}',
                data:{
                      "_token": "{{ csrf_token() }}",
                      'status': 1,
                      'message':message,
                      'user_id':user_id,
                    },

                success:function(response){
                  console.log(response);
                  if(response.status==1)
                  {
                  console.log(232);
                  location.reload();
                  }
                  else
                  {
                    console.log(333);
                  }
                                         
                },
                error:function(data){
                   
                   console.log(data);
                   console.log(00);
                }
            });
        });
</script>

@endsection