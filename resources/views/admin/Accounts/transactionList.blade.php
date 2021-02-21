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
                <div class="sp-change" style="margin-top:-43px;">
              	 <button type="button" class="btn btn-primary" data-toggle="modal"   data-target="#ModalExample">
                      Total Earning</button>
                  <button type="button" class="btn btn-primary spacing-item" style="margin-left:777px;" data-toggle="modal"   data-target="#ModalExample1">
                      Total Earning of the Month</button>
                    </div>
              	<!--<a href="{{url('/admin/totalEarning')}}">Total Earning</a>-->

                <div class="col-12">
                  <div class="table-responsive">
                     <table id="order-listing" class="table">
                      <thead>
                        <tr>
                            <th width="5%">Series</th>
                            <th width="5%">Name</th>
                            <th width="5%">Email</th>
                            <th width="5%">Amount</th>
                            <th width="5%">Payment Status</th>
                            <th width="5%">Date</th>
                        </tr>
                      </thead>

                      <tbody>
                       @php $i=0; @endphp
                        @foreach($all_transaction as $all_transactions)
                        @php $i++; @endphp
                        <tr>
                            <td> @php echo $i; @endphp</td>
                            <td>{{$all_transactions['name']}}</td>
                            <td>{{$all_transactions['email']}}</td>
                            <td>{{$all_transactions['amount']}}</td>
                            <td>{{$all_transactions['payment_status']}}</td>
                             <td>{{$all_transactions['Date']}}</td>

                        </tr>
                         @endforeach
                      </tbody>
                    </table>                   
                  </div>
                </div>
                  
            </div>
            <div id="ModalExample" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-xs-center">Total Earning</h4>
                        </div>
                        <div class="modal-body">
                            {{$earning}}
                        </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div> 
                      
                    </div><!-- /.modal-content -->
                </div>
              </div>

               <div id="ModalExample1" class="modal fade">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title text-xs-center">Total Earning of the Month </h4>
                        </div>
                        <div class="modal-body">
                            {{$earning_month}}
                        </div>
                         <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        </div> 
                      
                    </div><!-- /.modal-content -->
                </div>
              </div>
          </div>
        </div></div>
@endsection