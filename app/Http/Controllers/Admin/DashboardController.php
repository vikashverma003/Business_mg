<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use App\Models\Language;
use Illuminate\Support\Facades\Auth;
use DB;
use App\Models\Transaction;

class DashboardController extends Controller
{
    public function index(){
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

        return view('admin.dashboard', ['title' => 'Dashboard','revenue'=>$earning,'totalUsersCount'=>$totalUsersCount, 'user'=>$user,'usersCount'=>$usersCount,'managerCount'=>$managerCount,'employeeCount'=>$employeeCount]);
    }
}
