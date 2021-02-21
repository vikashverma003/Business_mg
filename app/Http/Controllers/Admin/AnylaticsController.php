<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Transaction;
use Carbon\Carbon;
class AnylaticsController extends Controller
{
    public function __construct(User $adminRevenue){
       // $this->user=$user;
        //$this->project=$project;
        //$this->projectPayment=$projectPayment;
        $this->adminRevenue=$adminRevenue;
    }

    public function index(){

        //return view('admin.Anylatics.index');
        $revenueShow=1;
            if(isset($_GET['revenueShow'])){
              $revenueShow=$_GET['revenueShow'];
          }
          $isShow=1;
          if(isset($_GET['projectShow'])){
            $isShow=$_GET['projectShow'];
        }
         $isUser=1;
          if(isset($_GET['userRegistration'])){
            $isUser=$_GET['userRegistration'];
        }
          
         $user=Auth::user();
        $usersCount = User::where(['role'=>'Owner','delete_status'=>0])->count();

        $managerCount = User::where(['role'=>'Manager','delete_status'=>0])->count();

        $employeeCount = User::where(['role'=>'Employee','delete_status'=>0])->count();
        $totalUsersCount = User::where(['delete_status'=>0])->count();
        $all_transaction=Transaction::orderBy('created_at', 'DESC')->get();
        $earning=0;
        foreach($all_transaction as $all_transactions){
          $earning+=$all_transactions->amount;
        }
        $adminRevenueBarChart=$this->adminRevenueBarChart($revenueShow);
        $getRevenueYear=$this->adminRevenue->getRevenueYear();
        $payment_chart=$this->payment_chart($isShow);
       // echo "<pre>";print_r(json_encode($payment_chart));
       $payment_charts= json_encode($payment_chart);
       $user_registration=$this->user_registration_chart($isUser);
        //echo "<pre>";print_r(json_encode($user_registration));die();
       $user_registrations=json_encode($user_registration);
        return view('admin.dashboards_analytics', ['title' => 'Dashboard','revenue'=>$earning,'totalUsersCount'=>$totalUsersCount, 'user'=>$user,'usersCount'=>$usersCount,'managerCount'=>$managerCount,'employeeCount'=>$employeeCount,'adminRevenueBarChart'=>$adminRevenueBarChart,
        'getRevenueYear'=>$getRevenueYear,'payment_charts'=>$payment_charts,'user_registrations'=>$user_registrations]);



    }
    public function adminRevenueBarChart($revenueShow){
      if($revenueShow>1){
      $projectLabel=['Jan','Feb','Mar','Apr','May','Jun','Jul','Aus','Sep','Oct','Nov','Dec'];
      $projectCount=[0,0,0,0,0,0,0,0,0,0,0,0];
      $projectDAta=$this->adminRevenue->getCountforGraph($revenueShow);
      foreach($projectDAta as $key=>$value){
        $projectCount[$value->status-1]=$value->total;
       }
       $data['projectLabel']= count($projectLabel)>0?$projectLabel:['2018','2019','2020'];
       $data['projectCount']= count($projectCount)>0?$projectCount:[0,0,0];
       return json_encode($data);
      }
      $projectLabel=[];
     $projectCount=[];
     $projectDAta=$this->adminRevenue->getCountforGraph($revenueShow);
     foreach($projectDAta as $key=>$value){
      $projectLabel[]=$value->status;
      $projectCount[]=$value->total;
     }
    $data['projectLabel']= count($projectLabel)>0?$projectLabel:['2018','2019','2020'];
    $data['projectCount']= count($projectCount)>0?$projectCount:[0,0,0];
    // echo "<pre>";

    // print_r($data);die();

    return json_encode($data);
    }

    public function payment_chart($i=null){
        if($i>1&&$i<=2)
        {
            $current_month=date('m');
        $t=Transaction::whereRaw('MONTH(created_at) = '.$current_month)->select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();

        }
        elseif($i>2&&$i<=3){
            $current_year=date('yy');
            $t=Transaction::whereRaw('YEAR(created_at) = '.$current_year)->select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();
        }
        else{
            $t=Transaction::select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();
        }
       // die();
        // $t=Transaction::select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();
        foreach($t as $tt=>$val){
            $months=$val['month'];
            if($months=='1'){
                $month='Jan';
            }
            if($months=='2'){
                $month='Feb';
            }
            if($months=='3'){
                $month='March';
            }
            if($months=='4'){
                $month='April';
            }
            if($months=='5'){
                $month='May';
            }
            if($months=='6'){
                $month='June';
            }
            if($months=='7'){
                $month='July';
            }
            if($months=='8'){
                $month='August';
            }
            if($months=='9'){
                $month='Sep';
            }
            if($months=='10'){
                $month='Oct';
            }
            if($months=='11'){
                $month='Nov';
            }
            if($months=='12'){
                $month='Dec';
            }
            $data=$val['data'];
            $j[]=['month'=>$month,'data'=>$data];
        }
        // return response()->json($j);
        return $j;
    }

    public function user_registration_chart($i=null){

     if($i>1&&$i<=2)
        {
            $current_month=date('m');
        $t=User::whereRaw('MONTH(created_at) = '.$current_month)->select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();

        }
        elseif($i>2&&$i<=3){
            $current_year=date('yy');
            $t=User::whereRaw('YEAR(created_at) = '.$current_year)->select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();
        }
        else{
            $t=User::select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();
        }
       // die();
        // $t=Transaction::select(DB::raw('MONTH(created_at) as month'),DB::raw('count(id) as `data`') )->groupBy(DB::raw('MONTH(created_at)'))->get();
        foreach($t as $tt=>$val){
            $months=$val['month'];
            if($months=='1'){
                $month='Jan';
            }
            if($months=='2'){
                $month='Feb';
            }
            if($months=='3'){
                $month='March';
            }
            if($months=='4'){
                $month='April';
            }
            if($months=='5'){
                $month='May';
            }
            if($months=='6'){
                $month='June';
            }
            if($months=='7'){
                $month='July';
            }
            if($months=='8'){
                $month='August';
            }
            if($months=='9'){
                $month='Sep';
            }
            if($months=='10'){
                $month='Oct';
            }
            if($months=='11'){
                $month='Nov';
            }
            if($months=='12'){
                $month='Dec';
            }
            $data=$val['data'];
            $j[]=['month'=>$month,'data'=>$data];
        }
        // return response()->json($j);
        return $j;


    }


 public function chart()
      {
        
        //     $current_month_payment=Transaction::whereMonth('created_at', date('m'))

        // $result = \DB::table('users')
        //             ->orderBy('created_at', 'ASC')
        //             ->get();
        // return response()->json($result);
      }



}
