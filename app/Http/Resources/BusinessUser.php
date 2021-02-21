<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessUser extends JsonResource
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name'  => $this->name,
            'email' =>  $this->email,
            'role'      =>  $this->role,
            'profile_image'=>  is_null($this->profile_image)?'':env('APP_URL')."".env('IMAGE_UPLOAD_PATH').'/'.$this->profile_image,
            'phone_code'    => $this->phone_code,
            'phone_number'  =>   $this->phone_number,
            'date_of_birth' =>  $this->date_of_birth,
            'is_notify'     =>   $this->is_notify,
            'registration_step' => $this->registration_step,
            $this->mergeWhen($this->access_token, [
            'access_token'   =>  $this->access_token,
            ]),
            'otp'    =>$this->when($this->otp,$this->otp),
            'lat'   => $this->lat,
            'lng'   => $this->lng,
            'location_id' => $this->location_id,
            'location'  =>new Location($this->location),
            'timezone'  => $this->timezone,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at
        ];
    }
}
