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
                            <th width="5%">Mark As Read</th>
                            
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
                             <td><a href="{{route('mark_as_read',$users->id)}}">
                    mark</a></td>

                        </tr>
                         @endforeach
                      </tbody>
                    </table>                   
                  </div>
                </div>
                  
            </div>
              <!-- Modal HTML Markup -->
</div></div>
@endsection