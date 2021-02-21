<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\CroneTask;
use App\User;
use App\Models\NotifyUser;
use DB;
use DateTime;
class AddTask extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:addtask';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Task has been added successfully.';

    /**
     * Execute the console command.
     *
     * @return mixed
     */

    public function handle()
    {
       
       $data=Task::where('cron_status',1)->with('cronTask')->get();
      
       foreach ($data as $response) {

           if($response->recurring == 'Weekly'){
            $due_date=$response->due_date;
            $next_date=$response->cronTask['next_date'];

            $id=$response->id;
     
            if ($due_date > $next_date) {

                 $currentDate=date('Y-m-d');
                    
                if($currentDate == $next_date){
              
               $info= DB::table('task')->insertGetid([
                'task_name'             =>  $response->task_name,
                'department'            =>  $response->department??null,
                'manager_name'          =>  $response->manager_name??null,
                'due_date'              =>  $response->due_date??null,
                'due_time'              =>  $response->due_time??null,
                'recurring'             =>  $response->recurring??null,
                'task_kpi'              =>  $response->task_kpi??null,
                'graph_type'            =>  $response->graph_type??null,
                'sucess_from'           =>  $response->sucess_from??null,
                'sucess_to'             =>  $response->sucess_to??null,
                'satisfactory_from'     =>  $response->satisfactory_from??null,
                'satisfactory_to'       =>  $response->satisfactory_to??null,
                'not_accept_from'       =>  $response->not_accept_from??null,
                'not_accept_to'         =>  $response->not_accept_to??null,
                'action'                =>  $response->action??null,
                'parent_id'             =>  $response->parent_id??null,
                'leave'                 =>  $response->leave??null,
                'discription'           =>  $response->discription??null,
                'notify_user'           =>  $response->notify_user??null,
                'date'                  =>  $response->date??null,
                'date_count'            =>  $response->date_count??null,
                'achived_number'        =>  $response->achived_number??null,
                'complete_status'       =>  $response->complete_status??null,
                'owner_complete_status' =>  $response->owner_complete_status??null,
                'kpi_score'             =>  $response->kpi_score??null,
                'kpi_score_range'       =>  $response->kpi_score_range??null,
                'owner_status'          =>  $response->owner_status??null,
                'delete_status'         =>  $response->delete_status??null,
                'user_id'               =>  $response->user_id??null,
                'created_at'            =>new \DateTime,
                'updated_at'            =>new \DateTime
              
            ]);

                $newnotify= NotifyUser::where('task_id',$id)->get();
          foreach ($newnotify as $newresult) {

           $addNotify= DB::table('notify_user')->insert([
                'task_id'               =>  $info,
                'action'                =>  $newresult->action??null,
                'users_id'              =>  $newresult->users_id??null,
                'created_at'            =>  new \DateTime,
                'updated_at'            =>  new \DateTime
            ]);

          }


               $date = strtotime("+7 day", strtotime($next_date));
          //\Log::error($date);
          $newdate= date("Y-m-d", $date);
          $affected = DB::table('auto_task')->where('task_id',$id)->update(['next_date' =>$newdate]);
          \Log::error('successfully');
           }
          
        }
        }

        if($response->recurring == 'Monthly'){
            $due_date=$response->due_date;
            $next_date=$response->cronTask['next_date'];
          \Log::error('monthly');

            $id=$response->id;
     
            if ($due_date > $next_date) {

                 $currentDate=date('Y-m-d');

                if($currentDate == $next_date){
              
               $info= DB::table('task')->insertGetid([
                'task_name'             =>  $response->task_name,
                'department'            =>  $response->department??null,
                'manager_name'          =>  $response->manager_name??null,
                'due_date'              =>  $response->due_date??null,
                'due_time'              =>  $response->due_time??null,
                'recurring'             =>  $response->recurring??null,
                'task_kpi'              =>  $response->task_kpi??null,
                'graph_type'            =>  $response->graph_type??null,
                'sucess_from'           =>  $response->sucess_from??null,
                'sucess_to'             =>  $response->sucess_to??null,
                'satisfactory_from'     =>  $response->satisfactory_from??null,
                'satisfactory_to'       =>  $response->satisfactory_to??null,
                'not_accept_from'       =>  $response->not_accept_from??null,
                'not_accept_to'         =>  $response->not_accept_to??null,
                'action'                =>  $response->action??null,
                'parent_id'             =>  $response->parent_id??null,
                'leave'                 =>  $response->leave??null,
                'discription'           =>  $response->discription??null,
                'notify_user'           =>  $response->notify_user??null,
                'date'                  =>  $response->date??null,
                'date_count'            =>  $response->date_count??null,
                'achived_number'        =>  $response->achived_number??null,
                'complete_status'       =>  $response->complete_status??null,
                'owner_complete_status' =>  $response->owner_complete_status??null,
                'kpi_score'             =>  $response->kpi_score??null,
                'kpi_score_range'       =>  $response->kpi_score_range??null,
                'owner_status'          =>  $response->owner_status??null,
                'delete_status'         =>  $response->delete_status??null,
                'user_id'               =>  $response->user_id??null,
                'created_at'            =>new \DateTime,
                'updated_at'            =>new \DateTime
              
            ]);

                $newnotify= NotifyUser::where('task_id',$id)->get();
          foreach ($newnotify as $newresult) {

           $addNotify= DB::table('notify_user')->insert([
                'task_id'               =>  $info,
                'action'                =>  $newresult->action??null,
                'users_id'              =>  $newresult->users_id??null,
                'created_at'            =>  new \DateTime,
                'updated_at'            =>  new \DateTime
            ]);

          }


                $date = strtotime("+30 day", strtotime($next_date));
          //\Log::error($date);
          $newdate= date("Y-m-d", $date);
          $affected = DB::table('auto_task')->where('task_id',$id)->update(['next_date' =>$newdate]);
          \Log::error('successfully');
           }
         
        }
        }

        if($response->recurring == 'Quarterly'){
            $due_date=$response->due_date;
            $next_date=$response->cronTask['next_date'];

            $id=$response->id;
     
            if ($due_date > $next_date) {

                 $currentDate=date('Y-m-d');
                    
                if($currentDate == $next_date){
              
               $info= DB::table('task')->insertGetid([
                'task_name'             =>  $response->task_name,
                'department'            =>  $response->department??null,
                'manager_name'          =>  $response->manager_name??null,
                'due_date'              =>  $response->due_date??null,
                'due_time'              =>  $response->due_time??null,
                'recurring'             =>  $response->recurring??null,
                'task_kpi'              =>  $response->task_kpi??null,
                'graph_type'            =>  $response->graph_type??null,
                'sucess_from'           =>  $response->sucess_from??null,
                'sucess_to'             =>  $response->sucess_to??null,
                'satisfactory_from'     =>  $response->satisfactory_from??null,
                'satisfactory_to'       =>  $response->satisfactory_to??null,
                'not_accept_from'       =>  $response->not_accept_from??null,
                'not_accept_to'         =>  $response->not_accept_to??null,
                'action'                =>  $response->action??null,
                'parent_id'             =>  $response->parent_id??null,
                'leave'                 =>  $response->leave??null,
                'discription'           =>  $response->discription??null,
                'notify_user'           =>  $response->notify_user??null,
                'date'                  =>  $response->date??null,
                'date_count'            =>  $response->date_count??null,
                'achived_number'        =>  $response->achived_number??null,
                'complete_status'       =>  $response->complete_status??null,
                'owner_complete_status' =>  $response->owner_complete_status??null,
                'kpi_score'             =>  $response->kpi_score??null,
                'kpi_score_range'       =>  $response->kpi_score_range??null,
                'owner_status'          =>  $response->owner_status??null,
                'delete_status'         =>  $response->delete_status??null,
                'user_id'               =>  $response->user_id??null,
                'created_at'            =>new \DateTime,
                'updated_at'            =>new \DateTime
              
            ]);

                $newnotify= NotifyUser::where('task_id',$id)->get();
          foreach ($newnotify as $newresult) {

           $addNotify= DB::table('notify_user')->insert([
                'task_id'               =>  $info,
                'action'                =>  $newresult->action??null,
                'users_id'              =>  $newresult->users_id??null,
                'created_at'            =>  new \DateTime,
                'updated_at'            =>  new \DateTime
            ]);

          }

               $date = strtotime("+90 day", strtotime($next_date));
          //\Log::error($date);
          $newdate= date("Y-m-d", $date);
          $affected = DB::table('auto_task')->where('task_id',$id)->update(['next_date' =>$newdate]);
          \Log::error('successfully');
           }
          
        }
        }


        if($response->recurring == 'Yearly'){
            $due_date=$response->due_date;
            $next_date=$response->cronTask['next_date'];

            $id=$response->id;
     
            if ($due_date > $next_date) {

                 $currentDate=date('Y-m-d');
                    
                if($currentDate == $next_date){
              
               $info= DB::table('task')->insertGetid([
                'task_name'             =>  $response->task_name,
                'department'            =>  $response->department??null,
                'manager_name'          =>  $response->manager_name??null,
                'due_date'              =>  $response->due_date??null,
                'due_time'              =>  $response->due_time??null,
                'recurring'             =>  $response->recurring??null,
                'task_kpi'              =>  $response->task_kpi??null,
                'graph_type'            =>  $response->graph_type??null,
                'sucess_from'           =>  $response->sucess_from??null,
                'sucess_to'             =>  $response->sucess_to??null,
                'satisfactory_from'     =>  $response->satisfactory_from??null,
                'satisfactory_to'       =>  $response->satisfactory_to??null,
                'not_accept_from'       =>  $response->not_accept_from??null,
                'not_accept_to'         =>  $response->not_accept_to??null,
                'action'                =>  $response->action??null,
                'parent_id'             =>  $response->parent_id??null,
                'leave'                 =>  $response->leave??null,
                'discription'           =>  $response->discription??null,
                'notify_user'           =>  $response->notify_user??null,
                'date'                  =>  $response->date??null,
                'date_count'            =>  $response->date_count??null,
                'achived_number'        =>  $response->achived_number??null,
                'complete_status'       =>  $response->complete_status??null,
                'owner_complete_status' =>  $response->owner_complete_status??null,
                'kpi_score'             =>  $response->kpi_score??null,
                'kpi_score_range'       =>  $response->kpi_score_range??null,
                'owner_status'          =>  $response->owner_status??null,
                'delete_status'         =>  $response->delete_status??null,
                'user_id'               =>  $response->user_id??null,
                'created_at'            =>new \DateTime,
                'updated_at'            =>new \DateTime
              
            ]);

          $newnotify= NotifyUser::where('task_id',$id)->get();
          foreach ($newnotify as $newresult) {

           $addNotify= DB::table('notify_user')->insert([
                'task_id'               =>  $info,
                'action'                =>  $newresult->action??null,
                'users_id'              =>  $newresult->users_id??null,
                'created_at'            =>  new \DateTime,
                'updated_at'            =>  new \DateTime
            ]);

          }


                $date = strtotime("+365 day", strtotime($next_date));
          //\Log::error($date);
          $newdate= date("Y-m-d", $date);
          $affected = DB::table('auto_task')->where('task_id',$id)->update(['next_date' =>$newdate]);
          \Log::error('successfully');
           }
         
        }
        }

        if($response->recurring == 'Daily'){
            $due_date=$response->due_date;
            $next_date=$response->cronTask['next_date'];
            $id=$response->id;
            if ($due_date >= $next_date) {

                 $currentDate=date('Y-m-d');
                if($currentDate == $next_date){
               $timeInfos=User::where('id',$response->user_id)->first();
               date_default_timezone_set($timeInfos->time_zone);
               $times = date( 'h:i:s A', time () );
              // \Log::error($times);
                $time='11:58:01 PM';
                $timess='11:58:02 PM';
                //\Log::error("times".$times);
                //\Log::error("time".$time);

                if($times == $time OR $times == $timess){
                \Log::error('yess');

               $date = strtotime("+1 day", strtotime($next_date));
          //\Log::error($date);
               $newdate= date("Y-m-d", $date);
               $info= DB::table('task')->insertGetid([
                'task_name'             =>  $response->task_name,
                'department'            =>  $response->department??null,
                'manager_name'          =>  $response->manager_name??null,
                'due_date'              =>  $newdate??null,
                'due_time'              =>  $response->due_time??null,
                'recurring'             =>  $response->recurring??null,
                'task_kpi'              =>  $response->task_kpi??null,
                'graph_type'            =>  $response->graph_type??null,
                'sucess_from'           =>  $response->sucess_from??null,
                'sucess_to'             =>  $response->sucess_to??null,
                'satisfactory_from'     =>  $response->satisfactory_from??null,
                'satisfactory_to'       =>  $response->satisfactory_to??null,
                'not_accept_from'       =>  $response->not_accept_from??null,
                'not_accept_to'         =>  $response->not_accept_to??null,
                'action'                =>  $response->action??null,
                'parent_id'             =>  $response->parent_id??null,
                'leave'                 =>  $response->leave??null,
                'discription'           =>  $response->discription??null,
                'notify_user'           =>  $response->notify_user??null,
                'date'                  =>  $response->date??null,
                'date_count'            =>  $response->date_count??null,
                'achived_number'        =>  $response->achived_number??null,
                'complete_status'       =>  $response->complete_status??null,
                'owner_complete_status' =>  $response->owner_complete_status??null,
                'kpi_score'             =>  $response->kpi_score??null,
                'kpi_score_range'       =>  $response->kpi_score_range??null,
                'owner_status'          =>  $response->owner_status??null,
                'delete_status'         =>  $response->delete_status??null,
                'user_id'               =>  $response->user_id??null,
                'created_at'            =>  new \DateTime,
                'updated_at'            =>  new \DateTime
            ]);

           
          $newnotify= NotifyUser::where('task_id',$id)->get();

          foreach ($newnotify as $newresult) {
           $addNotify= DB::table('notify_user')->insert([
                'task_id'               =>  $info,
                'action'                =>  $newresult->action??null,
                'users_id'              =>  $newresult->users_id??null,
                'created_at'            =>  new \DateTime,
                'updated_at'            =>  new \DateTime
            ]);
          }

           $date = strtotime("+1 day", strtotime($next_date));
           //\Log::error($date);

          $newdate= date("Y-m-d", $date);
          $affected = DB::table('auto_task')->where('task_id',$id)->update(['next_date' =>$newdate]);
          \Log::error('Done');

         }
           }
         
        }
        }








       }
         //\Log::error($data);
    }
}
