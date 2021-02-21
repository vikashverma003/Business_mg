<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper;
use App\User;

class Task extends Model
{
    protected $table = 'task';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_name','department','manager_name','due_date','due_time','recurring','task_kpi','graph_type','sucess_from','sucess_to','satisfactory_from','satisfactory_to','not_accept_from','not_accept_to','action','parent_id','created_at','updated_at','user_id','leave','achived_number','date','discription','notify_user','cron_status',
    ];

    public function createTask($data){
       
      if(!empty($data['action'])){
        $action = implode(",",$data['action']);
       }else{
        $action ='';
       }
       // if(!empty($data['notify_user'])){
       //  $notify = implode(",",$data['notify_user']);
       // }else{
       //  $notify ='';
       // }
       // if(!empty($data['notify_user'])){
       //  foreach ($data['notify_user'] as $rest) {
       //      $new=User::where('id',$rest)->first();
       //      if(!empty($new->device_token)){
       //      Helper::SendPushNotifications($new->device_token,'Task Message','New Task added Sucessfully.'); 
       //  }
       // }
        
       // }

        $createdUser= self::create(
            [
                'task_name'         =>  $data['task_name']??null,
                'department'        =>  $data['department']??null,
                'manager_name'      =>  $data['manager_name']??null,
                'due_date'          =>  $data['due_date']??null,
                'due_time'          =>  $data['due_time']??null,
                'recurring'         =>  $data['recurring']??null, 
                'task_kpi'          =>  $data['task_kpi']??null,
                'graph_type'        =>  $data['graph_type']??null,
                'sucess_from'       =>  $data['sucess_from']??null,
                'sucess_to'         =>  $data['sucess_to']??null,
                'date'              =>  $data['date']??null,
                'satisfactory_from' =>  $data['satisfactory_from']??null,
                'satisfactory_to'   =>  $data['satisfactory_to']??null,
                'not_accept_from'   =>  $data['not_accept_from']??null,
                'not_accept_to'     =>  $data['not_accept_to']??null,
                'action'            =>  $action??null,
                'parent_id'         =>  $data['parent_id']??null,
                'user_id'           =>  $data['user_id']??null,
                'discription'       =>  $data['discription']??null,
                //'notify_user'       =>  $notify??null,
                'cron_status'       =>  '1',
            ]
        );
       return $createdUser;
    }

    public function createTasks($data){
       
      if(!empty($data['action'])){
        $action = implode(",",$data['action']);
       }else{
        $action ='';
       }
       // if(!empty($data['notify_user'])){
       //  $notify = implode(",",$data['notify_user']);
       // }else{
       //  $notify ='';
       // }
       // if(!empty($data['notify_user'])){
       //  foreach ($data['notify_user'] as $rest) {
       //      $new=User::where('id',$rest)->first();
       //      if(!empty($new->device_token)){
       //      Helper::SendPushNotifications($new->device_token,'Task Message','New Task added Sucessfully.'); 
       //  }
       // }
        
       // }

       if($data['recurring'] =='weekly'){
          $next_date =date('Y-m-d');
          $date = strtotime("+7 day", strtotime($next_date));
          echo $newdate= date("Y-m-d", $date);
          //die('====');
       }else if($data['recurring'] =='Monthly'){
          $next_date =date('Y-m-d');
          $date = strtotime("+30 day", strtotime($next_date));
          $newdate= date("Y-m-d", $date);
       }else if($data['recurring'] =='Quarterly'){
        $next_date =date('Y-m-d');
         $date = strtotime("+90 day", strtotime($next_date));
         $newdate= date("Y-m-d", $date);
       }else if($data['recurring'] =='Yearly'){
         $next_date =date('Y-m-d');
         $date = strtotime("+365 day", strtotime($next_date));
         $newdate= date("Y-m-d", $date);
       }

        $createdUser= self::create(
            [
                'task_name'         =>  $data['task_name']??null,
                'department'        =>  $data['department']??null,
                'manager_name'      =>  $data['manager_name']??null,
                'due_date'          =>  $data['due_date']??null,
                'due_time'          =>  $data['due_time']??null,
                'recurring'         =>  $data['recurring']??null, 
                'task_kpi'          =>  $data['task_kpi']??null,
                'graph_type'        =>  $data['graph_type']??null,
                'sucess_from'       =>  $data['sucess_from']??null,
                'sucess_to'         =>  $data['sucess_to']??null,
                'date'              =>  $data['date']??null,
                'satisfactory_from' =>  $data['satisfactory_from']??null,
                'satisfactory_to'   =>  $data['satisfactory_to']??null,
                'not_accept_from'   =>  $data['not_accept_from']??null,
                'not_accept_to'     =>  $data['not_accept_to']??null,
                //'action'            =>  $action??null,
                'parent_id'         =>  $data['parent_id']??null,
                'user_id'           =>  $data['user_id']??null,
                'discription'       =>  $data['discription']??null,
                //'notify_user'       =>  $notify??null,
                'cron_status'       =>  '0',
            ]
        );
       return $createdUser;
    }

    public function department()
    {
        return $this->hasOne(\App\Models\Department::class,"id","department");

    }

    public function image()
    {
        return $this->hasMany(\App\Models\Image::class,"task_id","id");

    }
    
    public function parent()
    {
        return $this->hasOne(\App\User::class,"id","parent_id");

    }

    public function attachment()
    {
        return $this->hasMany(\App\Models\Attachment::class,"task_id","id");
    }

    public function note()
    {
        return $this->hasMany(\App\Models\Note::class,"task_id","id");
    }

    public function cronTask()
    {
        return $this->hasOne(\App\Models\CroneTask::class,"task_id","id");
    }

    public function notifyUser()
    {
        return $this->hasMany(\App\Models\NotifyUser::class,"task_id","id");
    }

    public function userinfo()
    {
        return $this->hasOne(\App\User::class,"id","user_id");
    }


   
}
