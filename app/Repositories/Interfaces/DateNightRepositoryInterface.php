<?php 
namespace App\Repositories\Interfaces;

interface DateNightRepositoryInterface
{
  
    public function all();
    public function find($id);
    public function create(array $data);
    public function resource($datenight);
    public function collection($datenight);
    public function resourceCollection($datenight);
}