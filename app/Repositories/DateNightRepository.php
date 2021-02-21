<?php
namespace App\Repositories;
use App\Models\DateNight;
use App\Http\Resources\DateNight as DateNightResource;
use App\Http\Resources\DateNightCollection;


use App\Repositories\Interfaces\DateNightRepositoryInterface;



class DateNightRepository implements DateNightRepositoryInterface
{
    public function all()
    {
        $location= DateNight::all();
       return $this->resourceCollection($location);
    }

  

    public function create(array $data){
        return DateNight::create([
            'user_id'           =>  $data['user_id'],
            'name'              =>  $data['name'],
            'date'              =>  $data['date'],
            'start_time'        =>$data['start_time'],
            'location'          => $data['location']
            ]);
    }

    public function resource($dateNight){
        return new DateNightResource($dateNight);
    }
    public function resourceCollection($dateNights){
        return  new DateNightCollection($dateNights);
    }
    public function collection($locations){
       // return  new LocationCollection($locations);
    }
    public function getCreatedDateNights($user_id,$isPrev=0,$perPage=10){
        $dateNights= DateNight::where('user_id',$user_id);
        
        if($isPrev==1){
            $dateNights=  $dateNights->previous();
        }else{
            $dateNights=  $dateNights->presentFuture();
        }
        $dateNights=$dateNights->with(['locationd','businesses','contacts','user'])->orderBy('id','desc')->paginate($perPage);
        return $this->resourceCollection($dateNights);
    }

    public function getInvitedDateNights($user,$isPrev=0,$perPage=10){
        $dateNights= DateNight::whereHas('contacts',function($q) use($user){
            $q->where('contact_no',$user->phone_code.''.$user->phone_number)->orWhere('contact_no',$user->phone_number);
        })->where('user_id','!=',$user->id);
        if($isPrev==1){
            $dateNights=  $dateNights->previous();
        }else{
            $dateNights=  $dateNights->presentFuture();
        }
        $dateNights=$dateNights->with(['locationd','businesses','contacts','user'])->orderBy('id','desc')->paginate($perPage);
        return $this->resourceCollection($dateNights);
    }
   
    public function find($id){
        return DateNight::where('id',$id)->first();
    }
   

   
}
