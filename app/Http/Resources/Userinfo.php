<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Userinfo extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    { 
     die('====');

        return [
            'id' => $this->id,
            $this->mergeWhen(config('constants.role.USER') ==$this->role, [
                'first_name'  => $this->name,
                'last_name'  => $this->last_name,
                ]),
            // $this->mergeWhen(config('constants.role.BUSINESS')==$this->role, [
            //         'business_name'  => $this->name,
            //         ]),
            'email' =>  $this->email,
            'role'      =>  $this->role,
            'profile_image'=>  is_null($this->profile_image)?'':env('APP_URL')."".env('IMAGE_UPLOAD_PATH').'/'.$this->profile_image,
            'phone_code'    => $this->phone_code,
            'phone_number'  =>   $this->phone_number,
           // 'date_of_birth' =>  $this->date_of_birth,
            'is_notify'     =>   $this->is_notify,
            //'registration_step' => $this->registration_step,
            $this->mergeWhen($this->access_token, [
            'access_token'   =>  $this->access_token,
            ]),
            'otp'    =>$this->when($this->otp,$this->otp),
            //'timezone'  => $this->timezone,
            //'location_id' => $this->location_id,
            'location'  =>$this->when(
                $this->relationLoaded('location'),
                function () {
                    return new Location($this->location);
                }
            ),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'business'  =>$this->when(
                $this->relationLoaded('business'),
                function () {
                    return new Business($this->business);
                }
            )
        ];
    }
}
