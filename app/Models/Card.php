<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Card extends Model
{
    protected $table = 'user_cards';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
    'user_id',
    'customer_id',
    'brand',
    'last4',
    'name',
    'is_default',
    'exp_month',
    'exp_year',
    'card_id',
    'card_type',
    'token'
    ];



    public function createCard($data){
     $data= self::create([
            'user_id'=>$data['user_id'],
            'customer_id'=>$data['customer_id'],
            'token'      => $data['token'],
            'brand'=>$data['brand'],
            'last4'=>$data['last4'],
            'name'=>$data['name'],
            'is_default' =>$data['is_default'],
            'exp_month'=>$data['exp_month'],
            'exp_year'=>$data['exp_year'],
            'card_id'=>$data['card_id'],
            'card_type'=>$data['card_type']??null
        ]);
       return  $data;
    }


 

}
