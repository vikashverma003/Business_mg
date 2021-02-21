<?php
namespace App\Traits;
use Stripe;

trait StripeManager{

        public static function stripeInit(){
                Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
            }

        public static function addCard($stripe_token,$email){
            try{
            $customer = Stripe\Customer::create([
                'source' => $stripe_token,
                'email' =>$email,
            ]);
            return ['status'=>1,'data'=>$customer];
            }catch(\Exception $e){
               return ['status'=>0,'data'=>$e->getMessage()];
            }
        } 
       public static function makePayment($stripe_customer_id,$cost){
        try{
        $charge = Stripe\Charge::create([
            'amount' => $cost*100,
            'currency' => 'INR',
            'customer' =>$stripe_customer_id,
        ]);
        return ['status'=>1,'data'=>$charge];
        }catch(\Exception $e){
        return ['status'=>0,'data'=>$e->getMessage()];
        }
       }

}