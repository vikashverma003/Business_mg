<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Dompdf\Dompdf;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use Mail;
use App\Models\Department;
use App\Models\Task;
use App\Models\Image;
use App\Models\Attachment;
use App\Models\Note;
use URL;
use App\Repositories\Interfaces\LocationRepositoryInterface;

class GraphController extends Controller
{
    use \App\Traits\APIResponseManager;
    use \App\Traits\CommonUtil;

    protected $userObj;
    protected $taskObj;
   

    public function __construct(User $user,Task $task)
    {
        $this->userObj =$user;
        $this->taskObj =$task;
    }
    
   public function managerGraph(Request $request){

      try{
            $request->validate([
               'userid'     =>'required',
               //'status'     => 'required',
               'recurring'  => 'required',
             ]);
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

        try{
           

            if(!empty($request->status)){
                if($request->status == '4'){
                    if($request->recurring == 'Weekly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-7 days')); 
                    }else if($request->recurring == 'Monthly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-30 days')); 
                    }else if($request->recurring == 'Quarterly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-90 days'));
                    }else if($request->recurring == 'Yearly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-360 days'));
                    }
                $data= Task::where('user_id',$request->userid)->whereBetween('date',[$fromweek, $toWeek])->get();

                }else{

                    if($request->recurring == 'Weekly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-7 days')); 
                    }else if($request->recurring == 'Monthly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-30 days')); 
                    }else if($request->recurring == 'Quarterly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-90 days'));
                    }else if($request->recurring == 'Yearly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-360 days'));
                    }


                $data= Task::where('user_id',$request->userid)->where('complete_status',$request->status)->whereBetween('date',[$fromweek, $toWeek])->get();
                 }
        }else{

                    if($request->recurring == 'Weekly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-7 days')); 
                    }else if($request->recurring == 'Monthly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-30 days')); 
                    }else if($request->recurring == 'Quarterly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-90 days'));
                    }else if($request->recurring == 'Yearly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-360 days'));
                    }

             $data= Task::where('user_id',$request->userid)->where('date',[$fromweek, $toWeek])->get();
        }
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

   }

   public function KpiGraph(Request $request){
        try{
            $request->validate([
               'department' => 'required',
               'recurring'  => 'required',
             ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

            try{

           // if(!empty($request->status)){
                if($request->department =='all'){
                
                   if($request->recurring == 'Weekly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-7 days')); 
                    }else if($request->recurring == 'Monthly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-30 days')); 
                    }else if($request->recurring == 'Quarterly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-90 days'));
                    }else if($request->recurring == 'Yearly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-360 days'));
                    }

               $data= Task::where('parent_id',$request->owner_id)->where('complete_status','!=' ,'1')->whereBetween('date',[$fromweek, $toWeek])->get();
                    
                }else{
                    if($request->userid ==''){

                    if($request->recurring == 'Weekly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-7 days')); 
                    }else if($request->recurring == 'Monthly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-30 days')); 
                    }else if($request->recurring == 'Quarterly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-90 days'));
                    }else if($request->recurring == 'Yearly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-360 days'));
                    }
                       
                    $data= Task::where('parent_id',$request->owner_id)->where('complete_status','!=','1')->whereBetween('date',[$fromweek, $toWeek])->where('department',$request->department)->get();
                   
                    }else{
                   
                    if($request->recurring == 'Weekly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-7 days')); 
                    }else if($request->recurring == 'Monthly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-30 days')); 
                    }else if($request->recurring == 'Quarterly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-90 days'));
                    }else if($request->recurring == 'Yearly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-360 days'));
                    }

                        $data= Task::where('user_id',$request->userid)->where('parent_id',$request->owner_id)->where('complete_status','!=','1')->whereBetween('date',[$fromweek, $toWeek])->where('department',$request->department)->get();
                    }
        
        }
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }

   public function KpiGraphEmployee(Request $request){

          try{
            $request->validate([
               'employee_id' => 'required',
               'recurring'   => 'required',
             ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
            try{
            if($request->recurring == 'Weekly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-7 days')); 
            }else if($request->recurring == 'Monthly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-30 days')); 
            }else if($request->recurring == 'Quarterly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-90 days'));
            }else if($request->recurring == 'Yearly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-360 days'));
            }

            $data= Task::where('user_id',$request->employee_id)->whereBetween('date',[$fromweek, $toWeek])->get();
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
            }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }

   public function EmployeeRevinueGraph(Request $request){

          try{
            $request->validate([
               'employee_id' => 'required',
               'recurring'   => 'required',
             ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
            try{
            if($request->recurring == 'Weekly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-7 days')); 
            }else if($request->recurring == 'Monthly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-30 days')); 
            }else if($request->recurring == 'Quarterly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-90 days'));
            }else if($request->recurring == 'Yearly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-360 days'));
            }

            $data= Task::where('user_id',$request->employee_id)->where('complete_status','!=',1)->whereBetween('date',[$fromweek, $toWeek])->get();
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
            }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }



   public function KpiIndicatorGraph(Request $request){

        try{
            $request->validate([
               //'userid'     => 'required',

               'owner_id' => 'required',
               'recurring'  => 'required',
             ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

         try{
            if($request->recurring == 'Weekly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-7 days')); 
            }else if($request->recurring == 'Monthly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-30 days')); 
            }else if($request->recurring == 'Quarterly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-90 days'));
            }else if($request->recurring == 'Yearly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-360 days'));
            }
            $data= Task::where('parent_id',$request->owner_id)->whereBetween('date',[$fromweek, $toWeek])->get();
            return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
            }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }

   public function managerRavenueGraph(Request $request){
    try{
            $request->validate([
               'manager_id' => 'required',
               'recurring'  => 'required',
             ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
    }
    try{
        $data=Department::where('status','1')->get();

        $dataRes=array();
        foreach ($data as $res) {

           $id=$res->id;
           if($request->recurring == 'Weekly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-7 days')); 
            }else if($request->recurring == 'Monthly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-30 days')); 
            }else if($request->recurring == 'Quarterly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-90 days'));
            }else if($request->recurring == 'Yearly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-360 days'));
            }

           $dataRes= Task::where('user_id',$request->manager_id)->where('complete_status','!=','1')->where('department',$id)->whereBetween('date',[$fromweek, $toWeek])->get();
           $myArray = json_decode(json_encode($dataRes), true);
          
                if(!empty($myArray)){
                   $newData[]=$myArray;
                }else{
                    $newData=[];
                }

          

        }
       
       // print_r($dataRes);
         return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $newData);

           // die('===');
            }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }

   }

public function KpiRavenueGraph(Request $request){
        try{
            $request->validate([
               //'userid'     => 'required',

               'department' => 'required',
               'recurring'  => 'required',
             ]);
            } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }

            try{

           // if(!empty($request->status)){
                if($request->department =='all'){
                
                   $data=Department::where('status','1')->get();
          //print($data);
        $dataRes=array();
        foreach ($data as $res) {

           $id=$res->id;
           if($request->recurring == 'Weekly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-7 days')); 
            }else if($request->recurring == 'Monthly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-30 days')); 
            }else if($request->recurring == 'Quarterly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-90 days'));
            }else if($request->recurring == 'Yearly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-360 days'));
            }

           $dataRes= Task::where('parent_id',$request->owner_id)->where('complete_status','!=','1')->where('department',$id)->whereBetween('date',[$fromweek, $toWeek])->get();
           $myArray = json_decode(json_encode($dataRes), true);
            // print_r($myArray);
            // die();
                if(!empty($myArray)){
                   $newData[]=$myArray;
                }

          

        }
                    
                }else{
                    if($request->userid ==''){
                        //die('=');

                     $data=Department::where('status','1')->get();

        $dataRes=array();
        foreach ($data as $res) {

           $id=$res->id;
           if($request->recurring == 'Weekly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-7 days')); 
            }else if($request->recurring == 'Monthly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-30 days')); 
            }else if($request->recurring == 'Quarterly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-90 days'));
            }else if($request->recurring == 'Yearly'){
                $toWeek=date('Y-m-d');
                $fromweek=date('Y-m-d', strtotime('-360 days'));
            }

           $dataRes= Task::where('parent_id',$request->owner_id)->where('complete_status','!=','1')->where('department',$id)->whereBetween('date',[$fromweek, $toWeek])->get();
           $myArray = json_decode(json_encode($dataRes), true);
          
                if(!empty($myArray)){
                   $newData[]=$myArray;
                }else{
                    $newData=[];
                }

          

        }
                    }else{
                        //die('=====');
                        $data=Department::where('status','1')->get();

                        $dataRes=array();
                        foreach ($data as $res) {

                        $id=$res->id;
                        if($request->recurring == 'Weekly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-7 days')); 
                        }else if($request->recurring == 'Monthly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-30 days')); 
                        }else if($request->recurring == 'Quarterly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-90 days'));
                        }else if($request->recurring == 'Yearly'){
                        $toWeek=date('Y-m-d');
                        $fromweek=date('Y-m-d', strtotime('-360 days'));
                        }

                        $dataRes= Task::where('user_id',$request->userid)->where('department',$id)->whereBetween('date',[$fromweek, $toWeek])->get();
                        $myArray = json_decode(json_encode($dataRes), true);

                        if(!empty($myArray)){
                        $newData[]=$myArray;
                        }
                        }
                    }
        
        }
        if(!empty($newData)){
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $newData);
        }else{
             return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response');
        }
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
   }  

 


   public function downlaodGraphPdf(Request $request){
      include(base_path().'/vendor/dompdf/dompdf/autoload.inc.php');
        $document = new Dompdf();
        $output = "
        <style>
        table {
        font-family: arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        }

        td, th {
        border: 1px solid #dddddd;
        text-align: left;
        padding: 8px;
        }
        tr:nth-child(even) {
        background-color: #dddddd;
        }
        </style>
        <table>
        <tr>
        <th>Task Name</th>
        <th>Department</th>
        <th>Manager Name</th>
        <th>Due Date</th>
        <th>Due Time</th>
        <th>Recurring</th>
        <th>Graph Type</th>
        <th>Complete Status</th>
        <th>Created At</th>
        </tr>
        ";
          
         if($request->department =='all' && $request->userid == 'all') {
           $data= Task::where('parent_id',$request->owner_id)->get();
         }else if($request->department =='all'){
           $data= Task::where('user_id',$request->userid)->where('parent_id',$request->owner_id)->get();  
         }else{
           $data= Task::where('user_id',$request->userid)->where('parent_id',$request->owner_id)->where('department',$request->department)->get(); 
         }

        
        foreach ($data as $res) {
       
        if($res->complete_status == '1'){
         $satus='Open';
        }else if($res->complete_status == '2'){
         $satus='Complete';   
        }else if($res->complete_status == '3'){
         $satus='Over Due date'; 
        }

       $dep=Department::where('id',$res->department)->first();
            
         
          $output .= '
            <tr>
              <td>'.$res->task_name.'</td>
              <td>'.$dep->name.'</td>
              <td>'.$res->manager_name.'</td>
              <td>'.$res->due_date.'</td>
              <td>'.$res->due_time.'</td>
              <td>'.$res->recurring.'</td>
              <td>'.$res->graph_type.'</td>
              <td>'.$satus.'</td>
              <td>'.$res->date.'</td>
            </tr>
          ';
          }

        $output .= '</table>';
        //echo $output;
        $document->loadHtml($output);

        //set page size and orientation
        $document->setPaper('A4', 'landscape');
        //Render the HTML as PDF
        $document->render();
        //Get output of generated pdf in Browser
        $document->stream("Webslesson", array("Attachment"=>1));
    }

}
