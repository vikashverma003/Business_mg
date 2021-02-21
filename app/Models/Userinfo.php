<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userinfo extends Model
{
    protected $table = 'usersinfo';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'gender', 'born','fathername','address1','address2','interior_house','exterior_house','zipcode','country','chronic_illness','consume_medicines','allergic_medication','fractures','supervison','marital_status','education_level'
    ];
}
