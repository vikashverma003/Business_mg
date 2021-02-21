<?php 
namespace App\Repositories\Interfaces;

interface LocationRepositoryInterface
{
  
    public function all();

    public function create(array $data);
    public function locationResource($location);
    public function locationCollection($locations);
    public function locationResourceCollection($location);
}