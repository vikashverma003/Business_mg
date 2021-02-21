<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    protected $table = 'notes';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'note','task_id','parent_id'
    ];

 public function createdtask()
    {
        return $this->hasMany(\App\User::class,"id","parent_id");
        

    }

}
