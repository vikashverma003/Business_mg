<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper;
use App\User;

class Price extends Model
{
    protected $table = 'admin_price';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'price',
    ];

   

   
}
