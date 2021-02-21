<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'department';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name','id','status'
    ];

    public function createDepartment($data){
      
        $createdUser= self::create(
            [
                'name'    =>  $data['name']??null,
                'status'  =>  $data['status']??null,
            ]
        );
       return $createdUser;
    }
}
