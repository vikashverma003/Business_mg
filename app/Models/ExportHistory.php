<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExportHistory extends Model
{
    protected $table = 'exporthistory';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'image','owner_id'
    ];

    public function createUser($data){
      
        $createdUser= self::create(
            [
                'image'     =>  $data['image']??null,
                'owner_id'  =>  $data['owner_id']??null,
            ]
        );
       return $createdUser;
    }
}
