<?php
namespace App\Repositories;
use App\Models\Location;
use App\Http\Resources\Location as BusinessResource;
use App\Http\Resources\LocationCollection;

use App\Repositories\Interfaces\LocationRepositoryInterface;



class LocationRepository implements LocationRepositoryInterface
{
    public function all()
    {
        $location= Location::all();
       return $this->locationResourceCollection($location);
    }

  

    public function create(array $data){
      return Location::create([
        'name'           =>  $data['name'],
        'hash_tag'          =>  $data['hash_tag'],
        'active'     =>     1
        ]);
    }

    public function locationResource($location){
        return new BusinessResource($location);
    }
    public function locationResourceCollection($location){
        return  BusinessResource::Collection($location);
    }
    public function locationCollection($locations){
        return  new LocationCollection($locations);
    }
    
   
   

   
}