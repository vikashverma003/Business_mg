<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class User extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            $this->mergeWhen(config('constants.role.MANAGER') ==$this->role, [
                'department'          => $this->department,
                'employees'           => $this->employees,
                'success_from'        => $this->success_from,
                'success_to'          => $this->success_to,
                'satisfactory_from'   => $this->satisfactory_from,
                'satisfactory_to'     => $this->satisfactory_to,
                'not_accept_from'     => $this->not_accept_from,
                'not_accept_to'       => $this->not_accept_to,
                ]),
            'email'           =>  $this->email,
            'role'            =>  $this->role,
            'profile_image'   =>  $this->profile_image,
            'company_logo'    =>  $this->company_logo, 
            'company_name'    =>  $this->company_name,
            'social_id'       =>  $this->social_id,
            'social_type'     =>  $this->social_type,

            $this->mergeWhen($this->access_token, [
            'access_token'    =>  $this->access_token,
            ]),
            'otp'    =>$this->when($this->otp,$this->otp),
            'location'  =>$this->when(
                $this->relationLoaded('location'),
                function () {
                    return new Location($this->location);
                }
            ),
            'created_at'      => $this->created_at,
            'updated_at'      => $this->updated_at,
            'business'        =>$this->when(
                $this->relationLoaded('business'),
                function () {
                    return new Business($this->business);
                }
            )
        ];
    }
}
