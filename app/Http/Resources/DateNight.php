<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DateNight extends JsonResource
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
            'user_id'  => $this->user_id,
            'name' =>  $this->name,
            'date'      =>  $this->date,
            'start_time'=>  $this->start_time,
            'is_perform_action'=>$this->is_perform_action,
            'location_id'    => $this->location,
            'location'  =>$this->when(
                $this->relationLoaded('locationd'),
                function () {
                    return new Location($this->locationd);
                }
            ),
            'user'=>User::Collection($this->whenLoaded('user')),
            'created_at' => $this->created_at,
            'businesses' => Business::Collection($this->whenLoaded('businesses')),
            'contacts' => DateNightContact::Collection($this->whenLoaded('contacts')),
            'updated_at' => $this->updated_at
        ];
    }
}
