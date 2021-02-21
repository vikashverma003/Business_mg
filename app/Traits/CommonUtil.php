<?php

namespace App\Traits;

use Illuminate\Support\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;



trait CommonUtil {

    public function ValidationResponseFormating($e) {
        $errorResponse = [];
        $errors = $e->validator->errors();
        $col = new Collection($errors);
        foreach ($col as $error) {
            foreach ($error as $errorString) {
                $errorResponse[] = $errorString;
            }
        }
        return $errorResponse;
    }

    public function uploadGalery($image,$uploadPath=null){
      
          $name = uniqid().'_'.time().'.'.$image->getClientOriginalExtension();
          if(is_null($uploadPath)){
          $destinationPath = public_path(env('IMAGE_UPLOAD_PATH'));
          }else{
            $destinationPath = public_path($uploadPath);
        }
          $image->move($destinationPath, $name);
          return $name;
  
      }

    public function printLog($lineNo,$fileName,$message,$type=1){
        Log::info("**********************".$fileName.":" .$lineNo."***********************");
        switch($type){
            case 1:
                Log::info($message);
                break;
            case 2: 
                Log::error($message);
                break;  
        }
        Log::info("**********************".$fileName.":" .$lineNo."***********************");
       

    }  

    public function getCurrentTime($timezone){
       return  now()->setTimezone($timezone);
    }
}
