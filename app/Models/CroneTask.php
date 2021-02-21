<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CroneTask extends Model
{
    protected $table = 'auto_task';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'next_date','date'
    ];

    

   

   
}
