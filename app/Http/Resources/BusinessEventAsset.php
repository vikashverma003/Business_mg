<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BusinessEventAsset extends JsonResource
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
            'event_id'  => $this->event_id,
            'file_url' =>  is_null($this->file_name)?'':env('APP_URL')."".env('BUSINESS_IMAGE_UPLOAD_PATH').'/'.$this->file_name,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
