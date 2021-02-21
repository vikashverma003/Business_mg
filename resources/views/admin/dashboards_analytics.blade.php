@extends('admin.layouts.app')
@section('title',$title)
@section('user_name',$user->name)
@section('role',$user->role)
@section('content')

        <div class="content-wrapper">
          <div class="row">

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/userList')}}">
                      <p class="mb-0">Bussiness Owner</p>
                      <h6>{{$usersCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="{{url('admin/managerList')}}">
                      <p class="mb-0">Bussiness Manager</p>
                      <h6>{{$managerCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="#">
                      <p class="mb-0">Employee</p>
                      <h6>{{$employeeCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-lg-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-account icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="#">
                      <p class="mb-0">Total Users</p>
                      <h6>{{$totalUsersCount}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>

             <div class="col-md-3 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <div class="d-flex align-items-center justify-content-md-center">
                    <i class="mdi mdi-cash icon-lg text-success"></i>
                    <div class="ml-3">
                      <a href="#">
                      <p class="mb-0">Total Revenue</p>
                      <h6>{{$revenue}}</h6>
                      </a>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
            <div class="col-lg-6 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Users Graph</h4>
                  <select id="revenue_filter" class="float-right">
                    <option value="1" {{isset($_GET['revenueShow'])?$_GET['revenueShow']==1?'selected="selected"':'':''}}>All</option>
                    @foreach($getRevenueYear as $y)
                  <option value="{{$y->year}}" {{isset($_GET['revenueShow'])?$_GET['revenueShow']==$y->year?'selected="selected"':'':''}}>{{$y->year}}</option>
                    @endforeach
                  </select>             
                   <canvas id="revenueChart" style="height:400px!important"></canvas>
                </div>
              </div>
            </div>

          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
           
              <div class="card">
               
                <div class="card-body">
                    <h4 class="card-title">Users Payment Chart</h4>
                     <select id="project_filter" class="float-right">
                    <option value="1" {{isset($_GET['projectShow'])?$_GET['projectShow']==1?'selected="selected"':'':''}}>All</option>
                    <option value="2" {{isset($_GET['projectShow'])?$_GET['projectShow']==2?'selected="selected"':'':''}}>this month</option>
                    <option value="3" {{isset($_GET['projectShow'])?$_GET['projectShow']==3?'selected="selected"':'':''}}>this year</option>
                  </select>
                 <div class="panel-body">
                   <canvas id="canvas_payment" height="280" width="600"></canvas>
               </div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-lg-12 grid-margin stretch-card">
           
              <div class="card">
               
                <div class="card-body">
                    <h4 class="card-title">Users Registration Chart</h4>
                     <select id="user_filter" class="float-right">
                    <option value="1" {{isset($_GET['userRegistration'])?$_GET['userRegistration']==1?'selected="selected"':'':''}}>All</option>
                    <option value="2" {{isset($_GET['userRegistration'])?$_GET['userRegistration']==2?'selected="selected"':'':''}}>this month</option>
                    <option value="3" {{isset($_GET['userRegistration'])?$_GET['userRegistration']==3?'selected="selected"':'':''}}>this year</option>
                  </select>
                 <div class="panel-body">
                   <canvas id="canvas_registration" height="280" width="600"></canvas>
               </div>
                </div>
              </div>
            </div>
          </div>
          </div>
        </div></div>
@endsection
@section('footerScript')
@parent

  <!-- Plugin js for this page-->
<script src="{{asset('admin/node_modules/chart.js/dist/Chart.min.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.js"></script>

<script>
    function date() {
        var dateVal = document.getElementById("date").value;
        alert("Your typed in " + dateVal);
    }
</script>



 <script>
      let projectData1=JSON.parse('<?php echo $adminRevenueBarChart;?>');
      var chr = document.getElementById("revenueChart");      
      var ctx = chr.getContext("2d");     
   // ctx.canvas.width = 800;
      var data = {
      type: "bar",
      data: {
        labels: projectData1.projectLabel,
        datasets: [{
          label: "Revenue",
          backgroundColor:[
        "#e41a1c",
        "#9aed8b",
        "#377eb8",
        "#4daf4a",
        "#984ea3",
        "#ff7f00",
        "#ffff33",
        "#ff7f00",
        "#984ea3",
        "#4daf4a",
        "#377eb8",
        "#9aed8b"
      ],
          fillColor: "blue",
          strokeColor: "green",
          data:projectData1.projectCount
        }]
      },
      options: {
        scales: {
            xAxes: [{
                barThickness: 30,  // number (pixels) or 'flex'
                maxBarThickness: 30 ,// number (pixels)
                gridLines: {
                display: false,
               },
            }],
            yAxes: [{
             gridLines: {
           display: false,
      },
    }]
        },
        legend: {
      display: false,
      labels: {
          usePointStyle: true, // show legend as point instead of box
          fontSize: 10 // legend point size is based on fontsize
        }
    },
    elements: {
        point: {
          radius: 3
        }
      },
    pointDot: true,
                  pointDotRadius : 6,
                  datasetStrokeWidth : 6,
                  bezierCurve : false,
    }
    };
            
        
    var myfirstChart = new Chart(chr , data);

    $("#revenue_filter").on("change",function(e){
let selectValue=$(this).val();
var url = window.location.href.split('?')[0];    
if (url.indexOf('?') > -1){
   url += '&revenueShow='+selectValue
}else{
   url += '?revenueShow='+selectValue
}
window.location.href = url;
});
    </script>
      <!-- End plugin js for this page-->
      <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.12.3/js/bootstrap-select.min.js" charset="utf-8"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.6.0/Chart.bundle.js" charset="utf-8"></script>
      <script>
        //var url = "{{url('/admin/stock/payment_chart')}}";
        let url=JSON.parse('<?php echo $payment_charts;?>');
        console.log(url);

        var Years = new Array();
        var Labels = new Array();
        var Prices = new Array();
        $(document).ready(function(){
          //$.get(url, function(response){
            url.forEach(function(data){
              console.log(data);
              Years.push(data.month);
                Labels.push(data.data);
            });
            var ctx = document.getElementById("canvas_payment").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:Years,
                      datasets: [{
                          label: 'Users Payment',
                          data: Labels,
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
            
          //});
        });
$("#project_filter").on("change",function(e){
    let selectValue=$(this).val();
    var url = window.location.href.split('?')[0];
       
   if (url.indexOf('?') > -1){
       url += '&projectShow='+selectValue
    }else{
       url += '?projectShow='+selectValue
    }
    window.location.href = url;
});
        </script>
           <script>
        //var url = "{{url('/admin/stock/payment_chart')}}";
        let url_registration=JSON.parse('<?php echo $user_registrations;?>');
        console.log("regis"+url);

        var Years1 = new Array();
        var Labels1 = new Array();
        var Prices = new Array();
        $(document).ready(function(){
          //$.get(url, function(response){
            url_registration.forEach(function(data){
              console.log(data);
              Years1.push(data.month);
                Labels1.push(data.data);
            });
            var ctx = document.getElementById("canvas_registration").getContext('2d');
                var myChart = new Chart(ctx, {
                  type: 'bar',
                  data: {
                      labels:Years1,
                      datasets: [{
                          label: 'Users Registration',
                          data: Labels1,
                          borderWidth: 1
                      }]
                  },
                  options: {
                      scales: {
                          yAxes: [{
                              ticks: {
                                  beginAtZero:true
                              }
                          }]
                      }
                  }
              });
            
          //});
        });
$("#user_filter").on("change",function(e){
    let selectValue=$(this).val();
    var url = window.location.href.split('?')[0];
       
   if (url.indexOf('?') > -1){
       url += '&userRegistration='+selectValue
    }else{
       url += '?userRegistration='+selectValue
    }
    window.location.href = url;
});
        </script>

@endsection