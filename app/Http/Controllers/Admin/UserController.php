<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use App\Models\Department;
use App\Models\Notice;
use App\Models\Price;
use App\Models\Transaction;
use App\User;
use URL;
use DB;
use App\Models\Privacy;
use App\Models\Term;
use App\Models\Contact;
use Mail;
class UserController extends Controller
{

    /**
     * Login page
     */

     protected $depObj;
     protected $userObj;

    public function __construct(Department $dep,User $userObj)
    {
        $this->depObj  =$dep;
        $this->userObj =$userObj;
    }
    


    public function index(){
      if (Auth::check()) {
        return redirect('admin/dashboard');
      }
      Auth::logout();

  
      return view('admin.login', ['title' => 'Login Page']);
    }

    /**
     * Check user Detail
     */

    public function login(Request $request){
         
      $request->validate([
          'email' => 'required|email|exists:users,email',
          'password' => 'required|min:6',
      ]);

      if (!Auth::check()) {
        $email=$request->get('email');
        $password=$request->get('password');
  
        if (Auth::attempt(['email' => $email, 'password' => $password, 'role' =>'Admin'])) {
          return redirect('admin/dashboard');
      }else{
        return redirect('admin/login')->with('error', 'Login credential is not valid ') ;
      }
      }
  }
  
  public function logout(){
    Auth::logout();
    return redirect(\URL::previous());
  }

  public function users(Request $request){
        $user=Auth::user();
        $allUser = User::where('role',config('constants.role.USER'))->where('account_status','0')->get();
        return view('admin.admin.viewUser', ['title' => 'Users','user'=>$user, 'allUser'=>$allUser]);
     
  }

  public function delete_user(Request $request){

            User::where('id',$request->user_id)->update([
                'delete_status' => '1',
                'updated_at' => new \DateTime
            ]);
            return response()->json(['success' => true,'message' => 'User Deleted Successfully']);
  }

  public function delete_manager(Request $request){

            User::where('id',$request->user_id)->update([
                'delete_status' => '1',
                'updated_at' => new \DateTime
            ]);
            return response()->json(['success' => true,'message' => 'Manager Deleted Successfully']);
  }

  public function viewUser(Request $request,$id){
   
     $user=Auth::user();
     $singleUser = User::where('id',$id)->first();
     return view('admin.admin.singleUser', ['title' => 'Users','user'=>$user,'singleUser'=>$singleUser]);
  }
  public function OwnerEdit(Request $request,$id){
     $user=Auth::user();
     $singleUser = User::where('id',$id)->first();
     return view('admin.User.editOwner', ['title' => 'Users','user'=>$user,'singleUser'=>$singleUser]);
  }
  public function EditReports(Request $request,$id){
     $user=Auth::user();
     $singleUser = User::where(['id'=>$id,'role'=>'Employee'])->first();
     $manager = User::where(['role'=>'Manager'])->get();
     $department = Department::get();

     return view('admin.User.EditReports', ['title' => 'Users','user'=>$user,'singleUser'=>$singleUser,'manager'=>$manager,'department'=>$department]);
  }

  public function UpdateOwner(Request $request){
   

    if ($request->hasFile('company_logo')) {
               $file = request()->file('company_logo');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $img=  $url.'/admin/images/owner/'.$logoName;
            }else{
               $res=User::where(['id'=>$request->id])->first();
               $img=$res->company_logo;
            }

     $result= User::where('id',$request->id)->update([
                'company_name' => $request->company_name,
                'company_logo'=>$img,
                'updated_at' => new \DateTime
            ]);
      return redirect('admin/userList')->with('status','Owner has beed Updated Successfully.');

  }

  public function updatedReports(Request $request){

    User::where('id',$request->id)->update([
                'name'               => $request->name,
                //'email'              => $request->email,
                'department'         => $request->department,
                'manager'            => $request->manager,
                'success_from'       => $request->successfull_from,
                'success_to'         => $request->successfull_to,
                'satisfactory_from'  => $request->satisfactory_from,
                'satisfactory_to'    => $request->satisfactory_to,
                'not_accept_from'    => $request->acceptable_from,
                'not_accept_to'      => $request->acceptable_to,
                'updated_at'         => new \DateTime
            ]);
     return redirect('admin/reportList')->with('status','Reports has been updated Successfully.');
  }
  public function user_feedback_update(Request $request,$id){

          User::where('id',$request->id)->update([
                'notification'       => 1,
                'updated_at'         => new \DateTime
            ]);
          $data=User::where(['id'=>$request->id])->first();
          $role=$data->role;
          if($role == 'Manager'){
             return redirect('admin/managerList');
          }else if($role == 'Owner'){
             return redirect('admin/userList');
          }else{
             return redirect('admin/reportList');
          }
 
  }

  public function departmentlist(Request $request){
     $user=Auth::user();
     $department = Department::get();
     return view('admin.department.viewDepartment', ['title' => 'View Department','user'=>$user,'department'=>$department]);
  }
  public function paymentlist(Request $request){

     $user=Auth::user();
     $userdata = User::where('role','!=','Owner')->get();
     return view('admin.payment.paymentlist', ['title' => 'View Payment','user'=>$user,'userdata'=>$userdata]);
  }



  public function userList(Request $request){

     $user=Auth::user();
     $manager = User::where(['role'=>'Owner','delete_status'=>0])->get();
     return view('admin.User.viewuser', ['title' => 'View Bussiness Owner','user'=>$user,'manager'=>$manager]);
  }

  public function reportList(Request $request){
     $user=Auth::user();
     $employee = User::where(['role'=>'Employee','delete_status'=>0])->get();
     return view('admin.User.viewreportList', ['title' => 'View Report List','user'=>$user,'employee'=>$employee]);
  }

  public function addOwner(Request $request){

     $user=Auth::user();
     $manager = User::where(['role'=>'Owner'])->get();
     return view('admin.User.addOwner', ['title' => 'Add Owner','user'=>$user,'manager'=>$manager]);
  }

  public function addReports(Request $request){
     $user=Auth::user();
     $manager = User::where(['role'=>'Manager'])->get();
     $department = Department::get();
     return view('admin.User.addReports', ['title' => 'Add Owner','user'=>$user,'manager'=>$manager,'department'=>$department]);
  }

  public function adddepartment(Request $request){
     $user=Auth::user();
    // $department = Department::get();
     return view('admin.department.addDepartment', ['title' => 'Add Department','user'=>$user]);
  }

  public function createReports(Request $request){
  // dd($request->all());

    $count=User::where(['email'=>$request->email])->first();
    if(!empty($count)){
       return redirect('admin/reportList')->with('status','Email Already Exist.');
    }else{

   $createdUser=$this->userObj->createReports([
             'name'             =>  $request->name??null,
             'email'            =>  $request->email??null,
             'department'       =>  $request->department??null,
             'parent_id'        =>  $request->manager??null,
             'successfull_from' =>  $request->successfull_from??null,
             'successfull_to'   =>  $request->successfull_to??null,
             'satisfactory_from'=>  $request->satisfactory_from??null,
             'satisfactory_to'  =>  $request->satisfactory_to??null,
             'acceptable_from'  =>  $request->acceptable_from??null,
             'acceptable_to'    =>  $request->acceptable_to??null,
       ]);
   
   return redirect('admin/reportList')->with('status','Employee has been added Successfully.');
 }

  }

  public function createOwner(Request $request){

    $count=User::where(['email'=>$request->email])->first();
    if(!empty($count)){
       return redirect('admin/userList')->with('status','Email Already Exist.');
    }else{

 if ($request->hasFile('company_logo')) {
               $file = request()->file('company_logo');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $img=  $url.'/admin/images/owner/'.$logoName;
            }

    $createdUser=$this->userObj->createOwner([
             'company_name'    =>  $request->company_name??null,
             'email'           =>  $request->email??null,
             'password'        =>  $request->password??null,
             'company_logo'    =>  $img??null,

       ]);
     return redirect('admin/userList')->with('status','Owner has beed added Successfully.');
  }
  }

  public function ViewOwner(Request $request,$id){
     $user=Auth::user();
     $data= User::where(['id'=>$id])->first();

     return view('admin.User.viewOwner', ['title' => 'View Owner Info','user'=>$user,'data'=>$data]);
  }

  public function ViewManager(Request $request,$id){
     $user=Auth::user();
     $data= User::where(['id'=>$id])->first();

     return view('admin.User.singleManager', ['title' => 'View Manager Info','user'=>$user,'data'=>$data]);
  }

  public function block_user(Request $request){

      $user = User::where('id',$request->user_id)->first();
        if ($request->status == 'Unblock')
        {
            if ($user->status == 'UNBLOCK')
              return response()->json(['success' => false,'message' => 'User Already Unblocked']);
            User::where('id',$request->user_id)->update([
                'block_status' => '0',
                'updated_at' => new \DateTime
            ]);
            return response()->json(['success' => true,'message' => 'User Unblocked Successfully']);

        }else{
            if ($user->status == 'Block')
              return response()->json(['success' => false,'message' => 'User Already Blocked']);
            User::where('id',$request->user_id)->update([
                'block_status' => '1',
                'updated_at' => new \DateTime
            ]);
            // dd($user = User::where('_id',$request->user_id)->first());
            return response()->json(['success' => true,'message' => 'User Blocked Successfully']);
        }

  }


  public function block_manager(Request $request){

      $user = User::where('id',$request->user_id)->first();
        if ($request->status == 'Unblock')
        {
            if ($user->status == 'UNBLOCK')
              return response()->json(['success' => false,'message' => 'User Already Unblocked']);
            User::where('id',$request->user_id)->update([
                'block_status' => '0',
                'updated_at' => new \DateTime
            ]);
            return response()->json(['success' => true,'message' => 'User Unblocked Successfully']);

        }else{
            if ($user->status == 'Block')
              return response()->json(['success' => false,'message' => 'User Already Blocked']);
            User::where('id',$request->user_id)->update([
                'block_status' => '1',
                'updated_at' => new \DateTime
            ]);
            // dd($user = User::where('_id',$request->user_id)->first());
            return response()->json(['success' => true,'message' => 'User Blocked Successfully']);
        }

  }
  
  public function managerList(Request $request){

     $user=Auth::user();
     $data= User::where(['role'=>'Manager','delete_status'=>0])->get();
     return view('admin.User.viewManager', ['title' => 'View Owner Info','user'=>$user,'data'=>$data]);
  }
  public function createNotice(Request $request){
         
    $data= DB::table('notice')->insert(['validates' =>$request->validates, 'description' => $request->description,'name'=>$request->name,'user_id'=>$request->id,'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

      return redirect('admin/managerList')->with('status','Notice has been Send Successfully.');

  }
  public function createNotices(Request $request){
         
    $data= DB::table('notice')->insert(['validates' =>$request->validates, 'description' => $request->description,'name'=>$request->name,'user_id'=>$request->id,'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

      return redirect('admin/reportList')->with('status','Notice has been Send Successfully.');

  }
  

  public function sendNotice(Request $request,$id){
     $user=Auth::user();
     $data= User::where(['id'=>$id,'delete_status'=>0])->first();
     $parent_id=$data->parent_id;
     $userinfoname=User::where('id',$parent_id)->first();

     return view('admin.User.sendNotice', ['title' => 'Formal Notice','user'=>$user,'data'=>$data,'parent_id'=>$parent_id]);
  }

  public function sendNotices(Request $request,$id){
     $user=Auth::user();
     $data= User::where(['id'=>$id,'delete_status'=>0])->first();
     $parent_id=$data->parent_id;
     $userinfoname=User::where('id',$parent_id)->first();

     return view('admin.User.sendEmployeeNotice', ['title' => 'Formal Notice','user'=>$user,'data'=>$data,'parent_id'=>$parent_id]);
  }
  

  public function viewNotice(Request $request){

     $user= Auth::user();
     $data= Notice::where(['id'=>1])->get();

     return view('admin.User.editNotice', ['title' => 'Formal Notice','user'=>$user,'data'=>$data]);

  }

  public function UpdateNotice(Request $request){

    $data=Notice::where('id',$request->id)->update([
                        'validation'  => $request->validation,
                        'description' => $request->description,
                        'updated_at'  => new \DateTime
                  ]);
    return redirect('admin/viewNotice')->with('status','Employee has been added Successfully.');

  }
  public function price(Request $request){
     $user= Auth::user();
     $data= Price::where(['id'=>1])->first();

     return view('admin.User.price', ['title' => 'Price','user'=>$user,'data'=>$data]);
  }

  public function Updateprice(Request $request){
              $data=Price::where('id',1)->update([
                            'price'  => $request->price,
                            'updated_at'  => new \DateTime
                  ]);
    return redirect('admin/price')->with('status','Employee has been added Successfully.');
  }

  
  public function viewTransaction(Request $request){

    $all_transaction=Transaction::orderBy('created_at', 'DESC')->get();
    $earning_month=0;
    $current_month_payment=Transaction::whereMonth('created_at', date('m'))
                     ->get();
    foreach($current_month_payment as $current_month_payments){
            $earning_month+=$current_month_payments->amount;
    }
  
    $earning=0;
    foreach($all_transaction as $all_transactions){
      $earning+=$all_transactions->amount;
      $user=User::where('id',$all_transactions->owner_id)->first();
      $user_info[]=[
      'name'=> $user->name!=null?$user->name:'--',
      'email'=>$user->email,
      'amount'=>$all_transactions->amount,
      'payment_status'=>$all_transactions->payment_status,
      'owner_id'=>$all_transactions->owner_id,
      'Date'=>$all_transactions->created_at,
      ];
    }
    //echo "<pre>"; print_r($user_info);die();
 return view('admin.Accounts.transactionList',['earning'=>$earning,'earning_month'=>$earning_month,'all_transaction'=>$user_info,'title'=>'View Transaction']);
 
  }
  public function sendingEmailToUser(Request $request){
    $user=User::orderBy('created_at', 'DESC')->get();
    return view('admin.Accounts.send_email',['title'=>'Send Email','user'=>$user]);
  }
    public function sendingEmail(Request $request){
   // $user=User::where('id',$id)->first();
    //echo 2323;
      $data=$request->all();
      $user_id=$data['user_id'];
      $users=User::where('id',$user_id)->first();
      $test= Mail::send('templates.admin_email', ['email'=>$users->email], function ($m) use ($users) {
        $m->from('joewpolizzi@gmail.com', 'Admin');
        $m->to($users->email,$users->id)->subject('Email from Admin');
        });
    return response()->json(['status'=>true,'data'=>$data,'user_id'=>$user_id, 'message'=>' successfully'], 200);
  }

 public function term(Request $request){
    $user=Auth::user();
    $term=Term::where('id',1)->first();

     return view('admin.term', ['title' => 'Term & Condition','user'=>$user,'term'=>$term]);
  }

  public function policy(Request $request){

    $user=Auth::user();
    $privacy=Privacy::where('id',1)->first();

     return view('admin.privacy', ['title' => 'Privacy Policy','user'=>$user,'privacy'=>$privacy]);
  }
   public function updateTerm(Request $request){
             Term::where('id',1)->update([
                        'heading'       => $request->heading,
                       
            ]);
     return redirect('admin/term')->with('status','Administrator has been created Successfully.');        
  }

public function updatePrivacy(Request $request){
               Privacy::where('id',1)->update([
                        'heading'       => $request->heading,
                       
                ]);
     return redirect('admin/policy')->with('status','Administrator has been created Successfully.');   
  }
   public function contact(Request $request){
    $user=Auth::user();
    $term=Contact::where('id',1)->first();

     return view('admin.contact', ['title' => 'Contact Us','user'=>$user,'term'=>$term]);
  }
  public function updateContact(Request $request){
             Contact::where('id',1)->update([
                        'heading'       => $request->heading,
            ]);
     return redirect('admin/contact')->with('status','Administrator has been created Successfully.');        
  }

  public function view_all_notification(Request $request){
        $data=\App\User::where(['notification'=>0])->orderBy('created_at', 'DESC')->get();
        return view('admin.Accounts.view_notification',['title'=>'View All Notification','user'=>$data]);
  }

   public function mark_as_read(Request $request,$id){

        $user=User::where('id',$request->id)->update([
                'notification'       => 1,
                'updated_at'         => new \DateTime
            ]);
        return redirect('admin/view_all_notification');        
  }


}
