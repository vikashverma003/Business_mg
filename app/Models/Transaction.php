<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Helper;
use App\User;

class Transaction extends Model
{
    protected $table = 'transaction_history';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'card_id','amount','balance_transaction','payment_status','owner_id'
    ];

   

   
}
