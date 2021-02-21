<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use Mail;
use App\Helper;
use App\Models\Department;
use App\Models\ExportHistory;
use App\Models\Task;
use App\Models\Image;
use App\Models\Attachment;
use App\Models\Note;
use App\Models\Notice;
use App\Models\Notify;
use App\Models\NotifyUser;
use URL;
use DateTime;
use App\Repositories\Interfaces\LocationRepositoryInterface;
use Carbon\Carbon;
class UserController extends Controller
{
    use \App\Traits\APIResponseManager;
    use \App\Traits\CommonUtil;

    protected $userObj;
    protected $taskObj;
    protected $exportObj;
   

    public function __construct(User $user,Task $task,ExportHistory $export)
    {
        $this->userObj =$user;
        $this->taskObj =$task;
        $this->exportObj =$export;
    }
    
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */

    public function signup(Request $request)
    {
        try{
        $request->validate([
            'password'     => "required",
            //'email'        => 'required|exists:users,email',
            'email'        => 'required|email|unique:users',
            'company_name' => 'required',
            'company_logo' => 'required'
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        } 
      
        try{
          

         DB::beginTransaction();
         if ($request->hasFile('company_logo')) {
            $file = request()->file('company_logo');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $img=  $url.'/admin/images/owner/'.$logoName;
            }

            $createdUsers=$this->userObj->createUser([
                'email'         =>  $request->email??null,
                'password'      =>  $request->password??null,
                'company_name'  =>  $request->company_name??null,
                'company_logo'  =>  $img??null,
            ]);

            $token=$this->userObj->createPassportToken($createdUsers);
            $createdUsers->access_token=$token;
            User::where('id',$createdUsers->id)->update([
                        'device_token'   => $request->device_token,
                        'time_zone'      => $request->time_zone,
                       
                ]);
         DB::commit();   
       
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_REGISTER_SUCCESS', 'response',$createdUsers);

    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
     
    }



    public function checkSocialUserExist(Request $request){

   try{
        $request->validate([
            'social_id'   => 'required',
            'social_type' => "required",
            'role'        => "required",
            
           
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
    }

    try{
            $existuser=$this->userObj->checkSocial( $request->all());
            if(is_null($existuser)){

                  DB::beginTransaction();

                  if ($request->hasFile('profile')) {
            $file = request()->file('profile');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $img=  $url.'/admin/images/owner/'.$logoName;
            }else{
               $img='';
            }

            $createdUsers=$this->userObj->createUserFacebook([
                'social_id'         =>  $request->social_id??null,
                'social_type'       =>  $request->social_type??null,
                'role'              =>  $request->role??null,
                'name'              =>  $request->name??null,
                'profile'           =>  $img??null,
                'email'             =>  $request->email??null,
            ]);
            $token=$this->userObj->createPassportToken($createdUsers);
            $createdUsers->access_token=$token;
            DB::commit();  
             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_REGISTER_SUCCESS', 'response',$createdUsers); 
              // return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'SOCIAL_USER_NOT_EXIST');        
            }else{
                Auth::loginUsingId($existuser->id);
                $user=Auth::user();
                $user->device_token=$request->device_token??null;
               
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                //$updatedUser =$user->load(['location','business']);
                User::where('id',$user->id)->update([
                        'device_token'   => $request->device_token,
                        'time_zone'      => $request->time_zone??null,
                       
                ]);

                $updatedUser=$this->userObj->user_resource($user);
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_LOGIN_SUCCESS', 'response', $updatedUser);  

    }
        //return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_LOGIN_SUCCESS', 'response', $updatedUser);

    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

}
  
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */

    public function login(Request $request)
    { 

         try{
        $request->validate([
            //'email' => 'required|exists:users,email',
            'password'    => 'required|string',
            'device_token'=> 'string',
            'email'       => 'required',
            'role'        => 'required',
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
                
              if(!empty($request->email)){
                $data=User::where('email',$request->email)->first();
                if(!empty($data->id)){
                if(!Auth::attempt(['email' => $request->email, 'password' => $request->password,'role' => $request->role])) {
                    return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'USER_PASSWORD_WRONG', 'response','');
                }
                $user=Auth::user();
                $user->device_token=$request->device_token??null;
                $user->save();
                $token=$this->userObj->createPassportToken($user);
                $user->access_token=$token;
                $updatedUser=$this->userObj->user_resource($user);

                User::where('id',$updatedUser->id)->update([
                        'device_token'   => $request->device_token,
                        'time_zone'      => $request->time_zone??null,
                ]);

              }else{
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'EMAIL_DOES_NOT_EXIT', 'response','');
              }
            }

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_LOGIN_SUCCESS', 'response', $updatedUser);
    } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }


    public function signupManager(Request $request){

      try{
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users',
            'department'        => 'required',
           // 'employees'         => 'required',
            'success_from'      => 'required',
            'success_to'        => 'required',
            'satisfactory_from' => 'required',
            'satisfactory_to'   => 'required',
            'not_accept_from'   => 'required',
            'not_accept_to'     => 'required',
            'parent_id'         => 'required',
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

    try{
       
         DB::beginTransaction();
         $random=mt_rand(100000,999999);
      
         $createdUser=$this->userObj->createManager([
                'name'              =>  $request->name??null,
                'email'             =>  $request->email??null,
                'department'        =>  $request->department??null,
                'employees'         =>  $request->employees??null,
                'password'          =>  $random??null,
                'success_from'      =>  $request->success_from??null,
                'success_to'        =>  $request->success_to??null,
                'satisfactory_from' =>  $request->satisfactory_from??null,
                'satisfactory_to'   =>  $request->satisfactory_to??null,
                'not_accept_from'   =>  $request->not_accept_from??null,
                'not_accept_to'     =>  $request->not_accept_to??null,
                'parent_id'         =>  $request->parent_id??null,
                'time_zone'         =>  $request->time_zone??null,
            ]);

         $token=$this->userObj->createPassportToken($createdUser);
         $createdUser->access_token=$token;

         DB::commit();   


        $users  = User::where('id',$createdUser->id)->first();
        $test= Mail::send('templates.activate', ['users' => $random,'email'=>$users->email], function ($m) use ($users) {
        $m->from('joewpolizzi@gmail.com', 'Assistant Manager Application');
        $m->to($users->email,$users->id)->subject('Activate User By Email');
        });
      
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_REGISTER_SUCCESS', 'response',  $createdUser);

    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function editManager(Request $request){
        try{
        $request->validate([
            'name'              => 'required',
            'department'        => 'required',
            'id'                => 'required',
            'success_from'      => 'required',
            'success_to'        => 'required',
            'satisfactory_from' => 'required',
            'satisfactory_to'   => 'required',
            'not_accept_from'   => 'required',
            'not_accept_to'     => 'required',
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

         try{

         $affected = DB::table('users')->where('id',$request->id)->update(['name' => $request->name,'department'=>$request->department,'success_from'=>$request->success_from,'success_to'=>$request->success_to,'satisfactory_from'=>$request->satisfactory_from,'satisfactory_to'=>$request->satisfactory_to,'not_accept_from'=>$request->not_accept_from,'not_accept_to'=>$request->not_accept_to]);
        $data=User::where('id',$request->id)->first();
        
         if($data->role == 'Employee'){
             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'EMPLOYEE_UPDATE_SUCCESS');
         }else{
             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'MANAGER_UPDATE_SUCCESS');
         }

       

    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function updateOwner(Request $request){
        try{
        $request->validate([
            //'company_name'              => 'required',
            'name'                      => 'required',
            'email'                     => 'required',
            //'company_logo'              => 'required',
            'phone_number'              => 'required',
            'id'                        => 'required',
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{


   
        if ($request->hasFile('profile')) {
            $file = request()->file('profile');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $img=  $url.'/admin/images/owner/'.$logoName;
            }else{
               $data=User::where(['id'=>$request->id])->first();
               $img=$data->profile_image;
            }

             if ($request->hasFile('company_logo')) {
            $file = request()->file('company_logo');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $Cmpimg=  $url.'/admin/images/owner/'.$logoName;
            }else{
               $data=User::where(['id'=>$request->id])->first();
               $Cmpimg=$data->company_logo;
            }

          $affected = DB::table('users')->where('id',$request->id)->update(['name' => $request->name,'company_name'=>$request->company_name,'profile_image'=>$img,'company_logo'=>$Cmpimg,'phone'=>$request->phone_number,'email'=>$request->email]);

           $Userdata=User::where(['id'=>$request->id])->first();
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'OWNER_UPDATE_SUCCESS','response',$Userdata);
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function DeleteManager(Request $request){
        try{
        $request->validate([
            'id'                        => 'required',
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

        $affected = DB::table('users')->where('id',$request->id)->update(['delete_status' => 1]);
        $Deletetask = DB::table('task')->where('user_id',$request->id)->update(['delete_status' => 1]);
       
       
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'MANAGER_DELETE_SUCCESS','response');
    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

    }


    public function employeeSignup(Request $request){
      try{
        $request->validate([
            'name'              => 'required',
            'email'             => 'required|email|unique:users',
            'department'        => 'required',
            'manager'           => 'required',
            'success_from'      => 'required',
            'success_to'        => 'required',
            'satisfactory_from' => 'required',
            'satisfactory_to'   => 'required',
            'not_accept_from'   => 'required',
            'not_accept_to'     => 'required',
            'parent_id'         => 'required',
            ]);
        
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
       
         DB::beginTransaction();
         $random=mt_rand(100000,999999);
         $createdUser=$this->userObj->createEmployee([
                'name'              =>  $request->name??null,
                'email'             =>  $request->email??null,
                'department'        =>  $request->department??null,
                'manager'           =>  $request->manager??null,
                'password'          =>  $random,
                'success_from'      =>  $request->success_from??null,
                'success_to'        =>  $request->success_to??null,
                'satisfactory_from' =>  $request->satisfactory_from??null,
                'satisfactory_to'   =>  $request->satisfactory_to??null,
                'not_accept_from'   =>  $request->not_accept_from??null,
                'not_accept_to'     =>  $request->not_accept_to??null,
                'parent_id'         =>  $request->parent_id??null,
                'time_zone'         =>  $request->time_zone??null,
            ]);


         $token=$this->userObj->createPassportToken($createdUser);
         $createdUser->access_token=$token;
         DB::commit(); 

       $users  = User::where('id',$createdUser->id)->first();
        $test= Mail::send('templates.activate', ['users' => $random,'email'=>$users->email], function ($m) use ($users) {
        $m->from('joewpolizzi@gmail.com', 'Assistant Manager Application');
        $m->to($users->email,$users->id)->subject('Activate User By Email');
        });

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_REGISTER_SUCCESS', 'response',  $createdUser);

    }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
    }

    public function getDepartment(Request $request){

        try{

          $data= Department::get();
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);

        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    public function getManager(Request $request){

        try{
        $request->validate([
            'owner_id'              => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
          if($request->department_id OR $request->name){

            if(empty($request->department_id)){

              $data= User::where(['parent_id'=>$request->owner_id,'role'=>'Manager','delete_status'=>0])->where('name', 'like', '%' . $request->name . '%')->with('department')->orderBy('created_at', 'desc')->get();

            }else{
              $data= User::where(['parent_id'=>$request->owner_id,'department'=>$request->department_id,'role'=>'Manager','delete_status'=>0])->where('name', 'like', '%' . $request->name . '%')->with('department')->orderBy('created_at', 'desc')->get();
            }
          }else{

          $datas= User::where(['parent_id'=>$request->owner_id,'role'=>'Manager','delete_status'=>0])->with('department')->orderBy('created_at', 'desc')->get();

           $sum=0;
           $neg=0;
           $n=0;
          foreach ($datas as $res) {
                  $id=$res->id;
                  $Taskdata=Task::where('user_id',$id)->where('cron_status',0)->get();
                   foreach ($Taskdata as $totalres) {
                   }
                  if(!empty($totalres->id)){
                  
              foreach ($Taskdata as $totalres) {
                 $n++;
                 $kpiScore=$totalres->kpi_score;
                 $range=$totalres->kpi_score_range;

                 $sum+= $kpiScore;
                 $neg+= $range;
                 
              }
                 $kpi= $sum/$n;
                 $ranges=$neg/$n;
                 $result=$kpi+$ranges;
                 $ab= $result/2;
                 $final=round($ab);
                
               // $affected = DB::table('users')->where('id',$id)->update(['kpi' => $final]);
              }
          }

           $data= User::where(['parent_id'=>$request->owner_id,'role'=>'Manager','delete_status'=>0])->with('department')->orderBy('created_at', 'desc')->get();


         }

         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);

        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    public function getEmployee(Request $request){

    try{
        $request->validate([
            'manager_id'              => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

          
        //$data= User::where(['manager'=>$request->manager_id,'role'=>'Employee'])->with('department')->get();

        $datas= User::where(['manager'=>$request->manager_id,'role'=>'Employee','delete_status'=>0])->with('department')->orderBy('created_at', 'desc')->get();
           $sum=0;
           $neg=0;
           $n=0;



          foreach ($datas as $res) {
                 $id=$res->id;
                  $Taskdata=Task::where('user_id',$id)->where('cron_status',0)->get();
                 //die('=');

                foreach ($Taskdata as $totalres) { 
                }
                  if(!empty($totalres->id)){
                    
              foreach ($Taskdata as $totalres) {
                 $n++;
                 $kpiScore=$totalres->kpi_score;
                 $range=$totalres->kpi_score_range;

                 $sum+= $kpiScore;
                 $neg+= $range;
                 
              }
                 $kpi= $sum/$n;
                 $ranges=$neg/$n;
                 $result=$kpi+$ranges;
                 $ab= $result/2;
                 $final=round($ab);
              
                //$affected = DB::table('users')->where('id',$id)->update(['kpi' => $final]);
              }
          }

           $data= User::where(['manager'=>$request->manager_id,'role'=>'Employee','delete_status'=>0])->with('department')->orderBy('created_at', 'desc')->get();

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);

        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

    }

    public function managerDetails(Request $request){
    try{
        $request->validate([
            'manager_id'              => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

        $data= User::where(['id'=>$request->manager_id,'role'=>'Manager'])->with('department')->first();
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    public function getEmployeedetail(Request $request){

      try{
        $request->validate([
            'employee_id'              => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

        $data= User::where(['id'=>$request->employee_id,'role'=>'Employee'])->with('department')->first();
         $data['manager']=User::where('id',$data->manager)->first();
        // 
        // die();
        
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

    }


    public function assignTask(Request $request){
        try{
        $request->validate([
            'task_name'               => 'required',
            'department'              => 'required',
            'manager_name'            => 'required',
           // 'due_date'                => 'required',
            //'due_time'                => 'required',
            //'recurring'               => 'required',
            'task_kpi'                => 'required',
            'graph_type'              => 'required', 
            'sucess_from'             => 'required',
          //'sucess_to'               => 'required',
            'satisfactory_from'       => 'required',
            'satisfactory_to'         => 'required',
            'not_accept_from'         => 'required',
          //'not_accept_to'           => 'required',
            'parent_id'               => 'required',
            'user_id'                 => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }



        try{
    
           \Log::error($request->notify_user);

           

       

      DB::beginTransaction();
         $createdTask=$this->taskObj->createTask([
                'task_name'         =>  $request->task_name??null,
                'department'        =>  $request->department??null,
                'manager_name'      =>  $request->manager_name??null,
                'due_date'          =>  $request->due_date??null,  
                'due_time'          =>  $request->due_time??null,
                'recurring'         =>  $request->recurring??null,
                'task_kpi'          =>  $request->task_kpi??null,
                'graph_type'        =>  $request->graph_type??null,
                'sucess_from'       =>  $request->sucess_from??null,
                'sucess_to'         =>  $request->sucess_to??null,
                'date'              =>  date('Y-m-d'),
                'satisfactory_from' =>  $request->satisfactory_from??null,
                'satisfactory_to'   =>  $request->satisfactory_to??null,
                'not_accept_from'   =>  $request->not_accept_from??null,
                'not_accept_to'     =>  $request->not_accept_to??null,
                'action'            =>  $request->action??null,
                'parent_id'         =>  $request->parent_id??null,
                'user_id'           =>  $request->user_id??null,
                'discription'       =>  $request->discription??null,
                'notify_user'       =>  $request->notify_user??null,
                'cron_status'       => '1',
            ]);
        DB::commit();   
      
       foreach ($request->notify_user as $newaction) {
              $action_id=$newaction['id'];
             \Log::error($newaction['users']);
            $newrs=implode(', ', $newaction['users']);
            DB::table('notify_user')->insert(['task_id' => $createdTask->id, 'action' => $action_id,'users_id'=>$newrs,'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);
           }

        DB::beginTransaction();
          
          if($request->recurring =='Weekly'){
          $next_date =date('Y-m-d');
          $date = strtotime("+7 day", strtotime($next_date));
           $newdate= date("Y-m-d", $date);
          
       }else if($request->recurring =='Monthly'){
          $next_date =date('Y-m-d');
          $date = strtotime("+30 day", strtotime($next_date));
          $newdate= date("Y-m-d", $date);
       }else if($request->recurring =='Quarterly'){
        $next_date =date('Y-m-d');
         $date = strtotime("+90 day", strtotime($next_date));
         $newdate= date("Y-m-d", $date);
       }else if($request->recurring =='Yearly'){
         $next_date =date('Y-m-d');
         $date = strtotime("+365 day", strtotime($next_date));
         $newdate= date("Y-m-d", $date);
       }else if($request->recurring =='Daily'){
         $next_date =date('Y-m-d');
         $date = strtotime("+1 day", strtotime($next_date));
         $newdate= date("Y-m-d", $date);
       }

         $createdTasks=$this->taskObj->createTasks([
                'task_name'         =>  $request->task_name??null,
                'department'        =>  $request->department??null,
                'manager_name'      =>  $request->manager_name??null,
                'due_date'          =>  $newdate??null,  
                'due_time'          =>  $request->due_time??null,
                'recurring'         =>  $request->recurring??null,
                'task_kpi'          =>  $request->task_kpi??null,
                'graph_type'        =>  $request->graph_type??null,
                'sucess_from'       =>  $request->sucess_from??null,
                'sucess_to'         =>  $request->sucess_to??null,
                'date'              =>  date('Y-m-d'),
                'satisfactory_from' =>  $request->satisfactory_from??null,
                'satisfactory_to'   =>  $request->satisfactory_to??null,
                'not_accept_from'   =>  $request->not_accept_from??null,
                'not_accept_to'     =>  $request->not_accept_to??null,
                'action'            =>  $request->action??null,
                'parent_id'         =>  $request->parent_id??null,
                'user_id'           =>  $request->user_id??null,
                'discription'       =>  $request->discription??null,
                'notify_user'       =>  $request->notify_user??null,
                'cron_status'       =>  '0',
            ]);

      DB::commit();  

      

      foreach ($request->notify_user as $newaction) {
              $action_id=$newaction['id'];
             \Log::error($newaction['users']);
            $newrs=implode(', ', $newaction['users']);
            DB::table('notify_user')->insert(['task_id' => $createdTasks->id, 'action' => $action_id,'users_id'=>$newrs,'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);
           }

      $token=User::where('id',$request->user_id)->first();
      $nes=Helper::SendPushNotifications($token->device_token,'Task Message','New Task assigned');

      DB::table('notify')->insert(['user_id' => $request->user_id, 'action_id' => $createdTask->id,'message'=>'New Task assigned','title'=>'New Task','send_notification'=>'1','created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

       $dateAdd= date("Y-m-d");

       DB::table('auto_task')->insert(['task_id' => $createdTask->id, 'next_date' => $newdate,'date'=>$dateAdd,'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $createdTask);

        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }
    public function taskList(Request $request){
        try{
        $request->validate([
            'manager_id'              => 'required',
            'pageno'                  => 'required',
            'pageoffset'              => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{

            $first=$request->pageno;
            $firstSkip=$first*$request->pageoffset;
            $total=$request->pageoffset;
           

           if($request->recurring OR $request->complete_status){

                 
                  
             if(empty($request->complete_status) AND !empty($request->recurring)){

              $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring,'cron_status'=>0])->with('department')->count();

              $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring,'cron_status'=>0])->with('department')->skip($firstSkip)->take($total)->get();

             
            }else if(!empty($request->complete_status) AND !empty($request->recurring)){

              $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->count();

              $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->skip($firstSkip)->take($total)->get();

            }else if(!empty($request->complete_status) AND empty($request->recurring)){

               $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->count();

              $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->skip($firstSkip)->take($total)->get();
            }
 
          }else{

                 $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'cron_status'=>0])->with('department')->count();

               $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'cron_status'=>0])->with('department')->skip($firstSkip)->take($total)->get();

           }
        return $res= array('status'=>'SUCCESS','count'=>$count,'status_code'=>'200','response'=>$data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

    }

    public function EmployeeTaskList(Request $request){
        try{
        $request->validate([
            'manager_id'              => 'required',
            'pageno'                  => 'required',
            'pageoffset'              => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{

        $first=$request->pageno;
            $firstSkip=$first*$request->pageoffset;
            $total=$request->pageoffset;
           

           if($request->recurring OR $request->complete_status){

                 
                  
             if(empty($request->complete_status) AND !empty($request->recurring)){

              $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring])->with('department')->count();

              $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring])->with('department')->skip($firstSkip)->take($total)->get();

             
            }else if(!empty($request->complete_status) AND !empty($request->recurring)){

              $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring,'complete_status'=>$request->complete_status])->with('department')->count();

              $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'recurring'=>$request->recurring,'complete_status'=>$request->complete_status])->with('department')->skip($firstSkip)->take($total)->get();

            }else if(!empty($request->complete_status) AND empty($request->recurring)){

               $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'complete_status'=>$request->complete_status])->with('department')->count();

              $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0,'complete_status'=>$request->complete_status])->with('department')->skip($firstSkip)->take($total)->get();
            }
 
          }else{

                $count= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0])->with('department')->count();

               $data= Task::where(['user_id'=>$request->manager_id,'delete_status'=>0])->with('department')->skip($firstSkip)->take($total)->get();

           }
        return $res= array('status'=>'SUCCESS','count'=>$count,'status_code'=>'200','response'=>$data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

    }



    public function allTasklist(Request $request){

       try{
        $request->validate([
            'owner_id'                => 'required',
            'pageno'                  => 'required',
            'pageoffset'              => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

           // $request->pageno * $request->pageoffset;

            $first=$request->pageno;
            $firstSkip=$first*$request->pageoffset;
            $total=$request->pageoffset;
           

           if($request->recurring OR $request->complete_status){
                  
             if(empty($request->complete_status) AND !empty($request->recurring)){

              $count= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'recurring'=>$request->recurring,'cron_status'=>0])->with('department')->with('userinfo')->count();

              $data= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'recurring'=>$request->recurring,'cron_status'=>0])->with('department')->with('userinfo')->skip($firstSkip)->take($total)->get();

             
            }else if(!empty($request->complete_status) AND !empty($request->recurring)){

               $count= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'recurring'=>$request->recurring,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->with('userinfo')->count();

              $data= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'recurring'=>$request->recurring,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->with('userinfo')->skip($firstSkip)->take($total)->get();
            }else if(!empty($request->complete_status) AND empty($request->recurring)){

              $count= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->with('userinfo')->count();
              
              $data= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'complete_status'=>$request->complete_status,'cron_status'=>0])->with('department')->with('userinfo')->skip($firstSkip)->take($total)->get();
            }
 
          }else{
              $owner_count= Task::where(['user_id'=>$request->owner_id,'delete_status'=>0,'cron_status'=>0])->with('department')->with('userinfo')->count();
              $data_owner= Task::where(['user_id'=>$request->owner_id,'delete_status'=>0,'cron_status'=>0])->with('department')->with('parent')->with('userinfo')->skip($firstSkip)->take($total)->get()->toArray();
              

             
              $count= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'cron_status'=>0])->with('department')->with('userinfo')->get()->count();
              $datas= Task::where(['parent_id'=>$request->owner_id,'delete_status'=>0,'cron_status'=>0])->with('department')->with('parent')->with('userinfo')->skip($firstSkip)->take($total)->get()->toArray();
            
              $data = array_merge($datas, $data_owner);
            
           }

        //$data= Task::where(['parent_id'=>$request->owner_id])->with('department')->get();

        //return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data); 
          return $res= array('status'=>'SUCCESS','count'=>$count,'status_code'=>'200','response'=>$data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    public function changePassword(Request $request){
       
        try{
            $request->validate([
               'old_password'=>'required',
               'new_password'=>'min:6|required_with:confirm_password|same:confirm_password',
               'confirm_password'=>'min:6',
             ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
            try{
                $user=Auth::user();
                DB::beginTransaction();
                if (\Hash::check($request->old_password, $user->password)) { 
                    $user->fill([
                     'password' => \Hash::make($request->new_password)
                     ])->save();
                     DB::commit();
                    }else{
                        DB::rollback();
                        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'OLD_PASSWORD_NOT_MATCH_ERROR');
                    }
                 
                    return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'PASSWORD_UPDATE_SUCCESS', 'response',[]);
            }catch (\PDOException $e) {
                DB::rollback();
                $errorResponse = $e->getMessage();
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
            }
    }

    public function logout(Request $request)
    {
        try{
            $request->user()->device_token=null;
            $request->user()->save();
        $request->user()->token()->revoke();
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_LOGOUT_SUCCESS');
         // return response()->json([
             // 'message' => 'Successfully logged out'
        // ]);
        } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
}

public function singleTask(Request $request){

    try{
            $request->validate([
               'task_id'        =>'required',
               'id'             =>'required',
               //'achived_number' => 'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
        if(!empty($request->image)){
        $img=array();
        foreach($request->image as $file){
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $img[]=  $url.'/admin/images/owner/'.$logoName;
           }
             foreach ($img as $value) {
                 DB::table('taskimage')->insert(['image' => $value, 'task_id' => $request->task_id]);
             }
        }

        if(!empty($request->document)){
        $document=array();
        foreach($request->document as $file){

               $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $document[]=  $url.'/admin/images/owner/'.$logoName;

           }
             foreach ($document as $documentvalue) {
                 DB::table('taskattachment')->insert(['attachment' => $documentvalue, 'task_id' => $request->task_id]);
             }
        }

        if(!empty($request->note)){
          $affected = DB::table('task')->where('id',$request->task_id)->update(['achived_number' => $request->achived_number]);
         }else{
            $affected = DB::table('task')->where('id',$request->task_id)->update(['achived_number' => $request->achived_number]);
         }

         if(!empty($request->achived_number)){

            $taskdata=Task::where(['id'=>$request->task_id,'cron_status'=>0])->first();
           
            
            $x          = $request->achived_number;
            $total      = $taskdata->sucess_from;
            $percentage = ($x*100)/$total;
            $affected   = DB::table('task')->where('id',$request->task_id)->update(['kpi_score_range' => $percentage]); 
        }



         if(!empty($request->note)){
           DB::table('notes')->insert(['note' => $request->note, 'task_id' => $request->task_id,'parent_id'=>$request->id,'created_at'=>date('Y-m-d H:i:s'),'updated_at'=>date('Y-m-d H:i:s')]);
         }

          $taskinfo=Task::where(['id'=>$request->task_id,'cron_status'=>0])->first();
          $date=$taskinfo->due_date;
          $time=$taskinfo->due_time;
          $Userid=$taskinfo->user_id;
          $today = date('Y-m-d'); 

           $getUser=User::where('id',$Userid)->first();
            //$datetime1 = new DateTime($time);
            date_default_timezone_set($getUser->time_zone);
            $timeCurrent = date( 'h:i A', time () );
            // $datetime2 = new DateTime($datetimes2);
            // $interval = $datetime1->diff($datetime2);
            // $hours= $interval->format('%h');
            // $minuts= $interval->format('%i');
           
        //Time Find
            // $time1 = $time;
            // $time2 = date("h:i:s");
            // list($hours, $minutes) = explode(':', $time1);
            // $startTimestamp = mktime($hours, $minutes);
            // list($hours, $minutes) = explode(':', $time2);
            // $endTimestamp = mktime($hours, $minutes);
            // $seconds = $endTimestamp - $startTimestamp;
            // $minutes = ($seconds / 60) % 60;
            // $hours = round($seconds / (60 * 60));
           
        //Date Find
         $datetime1 = date_create($date); 
         $datetime2 = date_create($today); 
         $interval  = date_diff($datetime1, $datetime2); 
         $dateCount=$interval->format('%R%a');
          
         $userAllinfo=User::where(['id'=>$request->id])->first();
         $role=$userAllinfo->role;
         if($role == 'Owner'){
           $affected = DB::table('task')->where('id',$request->task_id)->update(['owner_complete_status' => 1]);
         }

           if($dateCount <= 0 ){
            if($date == $today){
              if($time = $timeCurrent ){
               
                $affected = DB::table('task')->where('id',$request->task_id)->update(['complete_status' => 2,'kpi_score'=>100]);

                if(!empty($request->task_id)){
                    $taskNotify=NotifyUser::where('task_id',$request->task_id)->where('action',4)->first();
                    if(!empty($taskNotify->users_id)){
                    $nofityUser=explode(",",$taskNotify->users_id);
                    foreach ($nofityUser as $usernotify) {
                         $data=User::where('id',$usernotify)->first();
                         $nes=Helper::SendPushNotifications($data->device_token,'Task Message','Task has been completed');
                    }
                }
                }

                if(!empty($request->task_id)){
                    $taskNotify=NotifyUser::where('task_id',$request->task_id)->where('action',1)->first();
                    if(!empty($taskNotify->users_id)){
                    $nofityUser=explode(",",$taskNotify->users_id);
                    foreach ($nofityUser as $usernotify) {
                         $data=User::where('id',$usernotify)->first();
                         $nes=Helper::SendPushNotifications($data->device_token,'Task Message','Task has been completed');
                    }
                }
                }

                      $token=User::where('id',$Userid)->first();
                      $nes=Helper::SendPushNotifications($token->device_token,'Task Message','Task has been completed');
                      DB::table('notify')->insert(['user_id' => $Userid, 'action_id' => $request->task_id,'message'=>'Task has been completed','title'=>'Completed Task','send_notification'=>'2','created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

              }else{

                DB::table('task')->where('id',$request->task_id)->update(['complete_status' => 3,'kpi_score'=>0]);
                   
                     $taskNotify=NotifyUser::where('task_id',$request->task_id)->where('action',2)->first();
                    if(!empty($taskNotify->users_id)){
                    $nofityUser=explode(",",$taskNotify->users_id);
                    foreach ($nofityUser as $usernotify) {
                         $data=User::where('id',$usernotify)->first();
                         $nes=Helper::SendPushNotifications($data->device_token,'Task Message','Task has been completed');
                       
                    }
                }

                 $token=User::where('id',$Userid)->first();
                 $nes=Helper::SendPushNotifications($token->device_token,'Task Message','Task is incomplete');
                 DB::table('notify')->insert(['user_id' => $Userid, 'action_id' => $request->task_id,'message'=>'Task is incomplete','title'=>'InComplete Task','send_notification'=>'3','created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

              }

            }else{

              $affected = DB::table('task')->where('id',$request->task_id)->update(['complete_status' => 2,'kpi_score'=>100]);

              if(!empty($request->task_id)){
                    $taskNotify=NotifyUser::where('task_id',$request->task_id)->where('action',1)->first();
                    if(!empty($taskNotify->users_id)){
                    $nofityUser=explode(",",$taskNotify->users_id);
                    foreach ($nofityUser as $usernotify) {
                         $data=User::where('id',$usernotify)->first();
                         $nes=Helper::SendPushNotifications($data->device_token,'Task Message','Task has been completed');
                       
                    }
                }
                }
                
              $token=User::where('id',$Userid)->first();
              $nes=Helper::SendPushNotifications($token->device_token,'Task Message','Task has been completed');
              DB::table('notify')->insert(['user_id' => $Userid, 'action_id' => $request->task_id,'message'=>'Task has been completed','title'=>'Completed Task','send_notification'=>'2','created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

            }
              
            // if($time <= $timeCurrent ){
               // $affected = DB::table('task')->where('id',$request->task_id)->update(['complete_status' => 2,'kpi_score'=>100]);
            // }else{

            //     $affected = DB::table('task')->where('id',$request->task_id)->update(['complete_status' => 3,'kpi_score'=>0]);
            // }
            }else{

                   $affected = DB::table('task')->where('id',$request->task_id)->update(['complete_status' => 3,'kpi_score'=>0]);
                   $taskNotify=NotifyUser::where('task_id',$request->task_id)->where('action',2)->first();
                    if(!empty($taskNotify->users_id)){
                    $nofityUser=explode(",",$taskNotify->users_id);
                    foreach ($nofityUser as $usernotify) {
                         $data=User::where('id',$usernotify)->first();
                         $nes=Helper::SendPushNotifications($data->device_token,'Task Message','Task has been completed');
                       
                    }
                }
                    $token=User::where('id',$Userid)->first();
                    $nes=Helper::SendPushNotifications($token->device_token,'Task Message','Task is incomplete on due date');
                    DB::table('notify')->insert(['user_id' => $Userid, 'action_id' => $request->task_id,'message'=>'Task is incomplete on due date','title'=>'InComplete Task','send_notification'=>'3','created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

            }

            if(!empty($request->id)){
           $sum=0;
           $neg=0;
           $n=0;
             $userId= Task::where('id',$request->task_id)->where('parent_id',$request->id)->first();
             $user_id=$userId->user_id;
             $Taskdata=Task::where('user_id',$user_id)->where('cron_status',0)->get();
                   foreach ($Taskdata as $totalres) {
                   }
                  if(!empty($totalres->id)){
                  
              foreach ($Taskdata as $totalres) {
                 $n++;
                 $kpiScore=$totalres->kpi_score;
                 $range=$totalres->kpi_score_range;

                 $sum+= $kpiScore;
                 $neg+= $range;
                 
              }
                 $kpi= $sum/$n;
                 $ranges=$neg/$n;
                 $result=$kpi+$ranges;
                 $ab= $result/2;
                 // print_r($ab);
                 // die();
                 $final=round($ab);
                
                $affected = DB::table('users')->where('id',$user_id)->update(['kpi' => $final]);
              }

            }




            if(!empty($request->id)){
           $sum=0;
           $neg=0;
           $n=0;
             $userId= Task::where('id',$request->task_id)->where('parent_id',$request->id)->first();
             $user_id=$userId->user_id;
             $Taskdata=Task::where('user_id',$user_id)->where('cron_status',0)->get();
                   foreach ($Taskdata as $totalres) {
                   }
                  if(!empty($totalres->id)){
                  
              foreach ($Taskdata as $totalres) {
                 $n++;
                 $kpiScore=$totalres->kpi_score;
                 $range=$totalres->kpi_score_range;

                 $sum+= $kpiScore;
                 $neg+= $range;
                 
              }
                 $kpi= $sum/$n;
                
                
                 $finalCompleteScore=round($kpi);
                 $affected = DB::table('users')->where('id',$user_id)->update(['complete_task_score' => $finalCompleteScore]);
                //$affected = DB::table('users')->where('id',$user_id)->update(['kpi' => $final]);
              }

            }

            if(!empty($request->id)){
           $sum=0;
           $neg=0;
           $n=0;
             $userId= Task::where('id',$request->task_id)->where('parent_id',$request->id)->first();
             $user_id=$userId->user_id;
             $Taskdata=Task::where('user_id',$user_id)->where('cron_status',0)->get();
                   foreach ($Taskdata as $totalres) {
                   }
                  if(!empty($totalres->id)){
                  
              foreach ($Taskdata as $totalres) {
                 $n++;
                 $kpiScore=$totalres->kpi_score;
                 $range=$totalres->kpi_score_range;

                 $sum+= $kpiScore;
                 $neg+= $range;
                 
              }
                 $kpi= $sum/$n;
                 $rangesScore=$neg/$n;
                
                 $range_score=round($rangesScore);
                 $affected = DB::table('users')->where('id',$user_id)->update(['kpi_score' => $range_score]);
               
              }

            }


           //  if(!empty($request->id)){
           // $f=0;
           
           //   $userId= Task::where('id',$request->task_id)->where('parent_id',$request->id)->first();
           //   $user_id=$userId->user_id;
           //   $Taskdata=Task::where('user_id',$user_id)->where('cron_status',0)->get();
           //   $complete_TaskCount=Task::where('user_id',$user_id)->where('cron_status',0)->where('kpi_score','!=','0')->count();
           //         foreach ($Taskdata as $totalres) {
           //         }
           //        if(!empty($totalres->id)){
                  
           //    foreach ($Taskdata as $totalres) {
           //       $f++;
           //       $kpiScore=$totalres->kpi_score;
           //    }

           //    $finalCompleteScore=$complete_TaskCount/$f*100;
           //    $finals=round($finalCompleteScore);
           //      $affected = DB::table('users')->where('id',$user_id)->update(['complete_task_score' => $finals]);
           //    }

           //  }






        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'MARK_AS_COMPLETE');

        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
}


public function singleTaskDetails(Request $request){

        try{
            $request->validate([

               'id'=>'required',

             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

         try{
           
            $task=Task::where(['id'=>$request->id])->with('parent')->with('department')->with('image')->with('attachment')->with('note')->with('note.createdtask')->first();
           
             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $task);
        
        } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

}
public function deleteImage(Request $request){

    try{
            $request->validate([

               'id'=>'required',

             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        
         try{
           
           $data=\DB::table('taskimage')->where(['id'=>$request->id])->delete();
        if($data){
           return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'DELETE_SUCCESS');
       }
        
        } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
}

public function formal_notice(Request $request){

    try{
            $request->validate([
               'user_id'=>'required',
               'parent_id'=>'required',
               'status'=>'required',

             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        
         try{
        
           
           $data=DB::table('formal_notice')->insert(['user_id' => $request->user_id, 'parent_id' => $request->parent_id,'status' => $request->status,'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);
           $Userid=$request->user_id;
           $token=User::where('id',$Userid)->first();
          $nes=Helper::SendPushNotifications($token->device_token,'Formal Notice','Your Performance is going down');
          DB::table('notify')->insert(['user_id' => $Userid, 'action_id' => $request->parent_id,'message'=>'Your Performance is going down','title'=>'Formal Notice','send_notification'=>'1','created_at'=>new \DateTime,'updated_at'=>new \DateTime]);

        if($data){
           return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'NOTICE_SUCCESS');
       }
        
        } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
}

public function send_due_date_email(Request $request){

  $task=Task::get();
  $count=0;
  $today=date('Y-m-d');
  foreach($task as $tasks){
    if($tasks->complete_status ==3){
        $due_date=$tasks->due_date;
        //$cDate = Carbon::parse($due_date);
        $cDate=Carbon::rawParse($due_date, NULL);
        $days_count=$cDate->diffInDays();
        if($days_count==1)
        {                  //$count++;
        $users  = User::where('id',$tasks->user_id)->first();
        //$users  = User::where('id','=',316)->first();
        $test= Mail::send('templates.task_due', ['email'=>$users->email], function ($m) use ($users) {
        $m->from('joewpolizzi@gmail.com', 'Alert');
        $m->to($users->email,$users->id)->subject('Task is due');

        });
    }
        
    }
  }

}



public function deleteDocument(Request $request){
     try{
            $request->validate([
               'id'=>'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

          try{
           
           $data=\DB::table('taskattachment')->where(['id'=>$request->id])->delete();
        if($data){
           return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'DELETE_FILE_SUCCESS');
       }
        
        } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
}
public function getProfile(Request $request){
    try{
            $request->validate([
               'id'=>'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
           
           $data=User::where(['id'=>$request->id])->first();
           return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
        
        } catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
}


public function managerTask(Request $request){


    try{
        $request->validate([
            'task_name'               => 'required',
            'department'              => 'required',
            'manager_name'            => 'required',
            'due_date'                => 'required',
            'due_time'                => 'required',
            'recurring'               => 'required',
            'task_kpi'                => 'required',
            'graph_type'              => 'required', 
            'sucess_from'             => 'required',
            //'sucess_to'               => 'required',
            'satisfactory_from'       => 'required',
            'satisfactory_to'         => 'required',
            'not_accept_from'         => 'required',
            //'not_accept_to'           => 'required',
            'action'                  => 'required',
            'parent_id'               => 'required',
            'user_id'                 => 'required',
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 
            'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

       DB::beginTransaction();
         $createdTask=$this->taskObj->createTask([
                'task_name'         =>  $request->task_name??null,
                'department'        =>  $request->department??null,
                'manager_name'      =>  $request->manager_name??null,
                'due_date'          =>  $request->due_date??null,  
                'due_time'          =>  $request->due_time??null,
                'recurring'         =>  $request->recurring??null,
                'task_kpi'          =>  $request->task_kpi??null,
                'graph_type'        =>  $request->graph_type??null,
                'sucess_from'       =>  $request->sucess_from??null,
                'sucess_to'         =>  $request->sucess_to??null,
                'satisfactory_from' =>  $request->satisfactory_from??null,
                'satisfactory_to'   =>  $request->satisfactory_to??null,
                'not_accept_from'   =>  $request->not_accept_from??null,
                'not_accept_to'     =>  $request->not_accept_to??null,
                'action'            =>  $request->action??null,
                'parent_id'         =>  $request->parent_id??null,
                'user_id'           =>  $request->user_id??null,
            ]);
        DB::commit();   
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $createdTask);

        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
}

   public function gettask(Request $request){

     $data=Task::get();
     return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
   }

   public function addExportHistory(Request $request){

     try{
            $request->validate([
               'owner_id'=>'required',
               'upload_excel'=>'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

    try{

         DB::beginTransaction();
         if ($request->hasFile('upload_excel')) {
            $file = request()->file('upload_excel');
                $logoName = md5($file->getClientOriginalName() . time()) . "." . $file->getClientOriginalExtension();
               $file->move('admin/images/owner', $logoName);
               $url= URL::to('/');
               $img=  $url.'/admin/images/owner/'.$logoName;
            }

            $createdUsers=$this->exportObj->createUser([
                'image'         =>  $img??null,
                'owner_id'      =>  $request->owner_id??null,
               
            ]);

         DB::commit();   
       
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_REGISTER_SUCCESS', 'response',$createdUsers);

    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }
   }

   public function getHistory(Request $request){

    try{
            $request->validate([
               'owner_id'=>'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

         $data=ExportHistory::where('owner_id',$request->owner_id)->get();
       
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'USER_REGISTER_SUCCESS', 'response',$data);

    } catch (\PDOException $e) {
        DB::rollback();
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
    }

   }

   public function newget(Request $request){
    
     $data=Task::where('cron_status',1)->with('cronTask')->get();
     foreach ($data as $res) {
        echo $res->cronTask['next_date'];
        
     }
    // return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
   }
   public function transferTask(Request $request){

    try{
            $request->validate([
               //'owner_id'=>'required',
               'task_id' =>'required',
               'user_id' =>'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

      try{

        $data=User::where('id',$request->user_id)->first();

          Task::where('id',$request->task_id)->update([
                      'user_id'   => $request->user_id,
                      'manager_name'      => $data->name,
                       
                ]);
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'TASk_TRANSFER');

        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }

   public function getNotice(Request $request){

    try{
            $request->validate([
               'user_id' =>'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

        $data=Notice::where('user_id',$request->user_id)->get();
        
        foreach ($data as $res) {

          $res['name']=User::where('id',$res->name)->with('department')->first();
          $res['user_id']=User::where('id',$res->user_id)->with('department')->first();
        }

            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);

        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

   }


   public function getOwnerNotice(Request $request){
    try{
            $request->validate([
               'user_id' =>'required',
             ]);
        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

        $data=Notice::where('name',$request->user_id)->get();
        
        foreach ($data as $res) {

          $res['name']=User::where('id',$res->name)->with('department')->first();
          $res['user_id']=User::where('id',$res->user_id)->with('department')->first();
        }

            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);

        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }

   public function notify(Request $request){
   
   try{
            $request->validate([
               'user_id' =>'required',
             ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{

            $data=Notify::where('send_notification',1)->where('user_id',$request->user_id)->get();
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);

        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }

   public function searchTask(Request $request){

    try{

        if(!empty($request->parent_id)){
        $data=Task::where('parent_id', $request->parent_id)->Where('task_name', 'like', '%' . $request->task_name . '%')->where('cron_status',0)->get();
       }

       if(!empty($request->user_id)){
        $data=Task::where('user_id', $request->user_id)->Where('task_name', 'like', '%' . $request->task_name . '%')->where('cron_status',0)->get();
       }

            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);

        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

   }

   public function alltransferTask(Request $request){
    try{
            $request->validate([
               'delete_user_id' =>'required',
               'transfer_user_id' =>'required',
             ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
          
            Task::where('user_id',$request->delete_user_id)->where('complete_status',1)->update([
                        'user_id'   => $request->transfer_user_id,
                       
                ]);
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'TASk_TRANSFER');

        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }

   public function getManagerCount(Request $request){
     
     try{
            $request->validate([
               'user_id' =>'required',
             ]);

        } catch (\Illuminate\Validation\ValidationException $e) {

            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

        try{
           //die('==');
            $data=User::where('parent_id',$request->user_id)->count();
        if($data%2==0){
          $number='0';
          }else{
            $number='1';
          }
          
          $finalData=array('number'=>$number,
                            'count' => $data,);

          return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $finalData);
           
        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }



   }







    
}
