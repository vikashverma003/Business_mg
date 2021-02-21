<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Task;
use App\Models\NotifyUser;
use DB;
use App\User;
use DateTime;
use App\Helper;

class TestLog extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'command:testlog';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Store dummy log based for testing cron';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {

         \Log::error('dummy text for cron testing'.date("Y-m-d",time()));
        \Log::error("test console and also the cron jobs");

        die(23232);
        $data=Task::where('due_date',date('Y-m-d'))->where('cron_status',0)->get();

        foreach ($data as $res) {
           $parent_id =$res->parent_id;
           $user_id =$res->user_id;
           $due_time  =$res->due_time;
           $userData  =User::where('id',$parent_id)->first();
           date_default_timezone_set($userData->time_zone);
           $times = date( 'h:i A', time () );

            //$now =  date('Y-m-d H:i:s');
            $time   = strtotime($due_time);
            $timess   = $time - (60*60); //one hour
            $beforeOneHour = date("h:i A", $timess);
            \Log::error($times);
            \Log::error($beforeOneHour);

            if($beforeOneHour == $times){

                //if(!empty($data->task_id)){

                    $taskNotify=NotifyUser::where('task_id',$res->id)->where('action',3)->first();

                    if(!empty($taskNotify->users_id)){
                    $nofityUser=explode(",",$taskNotify->users_id);

                    foreach ($nofityUser as $usernotify) {
                         \Log::error('hahha');
                         $data=User::where('id',$usernotify)->first();
                          \Log::error($data);
                         $nes=Helper::SendPushNotifications($data->device_token,'Task Message','Task has been completed');
                         
                       
                    }
                }

                         $datas=User::where('id',$user_id)->first();
                         $nes=Helper::SendPushNotifications($datas->device_token,'Task Message','Task has been completed');


                //}

            }
          
        }
      //\Log::error($data);
    }
}
