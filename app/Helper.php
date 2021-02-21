<?php

namespace App;
use URL;

class Helper
{
    public static function userimg($data)
    {
        if($data){
            return  $data;
        }else{
          return  URL::to("/").'/images/users/no_img.png';
        }
      
    }

    public static function productImage($data)
    {
        if($data){
            return  $data;
        }else{
          return  URL::to("/").'/images/review-banner.png';
        }
      
    }

    public static function encodeNum($num)
    {
       return base64_encode($num);
    }

    public static function decodeNum($num) 
    {
       return base64_decode($num); 
    } 


    public static function SendPushNotifications($token,$title,$body,$sound=null,$badge=null){

       if(!empty($sound)){
        $res=$sound;
       }else{
        $res='true';
       }
     

          $ch = curl_init("https://fcm.googleapis.com/fcm/send"); 
          $notification = array('title' =>$title , 'body' => $body, 'vibrate'=> true, 'sound'=> $sound, 'content-available' => true, 'priority' => 'high'); 
          $data = array('title' => $title, 'body' => $body);
          $arrayToSend = array('to' => $token, 'notification' => $notification, 'data' => $data);
          
          $json = json_encode($arrayToSend); 
           $headers = array();
           $headers[] = 'Content-Type: application/json';
           $headers[] = 'Authorization: key=AAAA1zGB86Y:APA91bGYt74OtFCuZm40ff5eozBOglc6fCrV2_odt2ZjPP3GSRkXpSRYLxGi84z9-ODMpSCLrZzdzHs_VaJgGKRt41x0JhOLw28pWEl6HBKBkDyWR7I6Nk7__nAzk_nGFWXTqYrvVowj';
           curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");  
           curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
           curl_setopt($ch,CURLOPT_HTTPHEADER, $headers);
           
           curl_setopt($ch,CURLOPT_SSL_VERIFYPEER, true);  
           curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
           curl_setopt($ch, CURLOPT_POST, 1);
           $response = curl_exec($ch);
           curl_close($ch);
          return $response ;     
      }  
     




}
