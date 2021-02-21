<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Hash;
use Stripe;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use DB;
use Mail;
use App\Helper;
use App\Models\Department;
use App\Models\ExportHistory;
use App\Models\Task;
use App\Models\Image;
use App\Models\Attachment;
use App\Models\Card;
use App\Models\Price;
use App\Models\Transaction;
use URL;
use DateTime;
use App\Repositories\Interfaces\LocationRepositoryInterface;

class PaymentController extends Controller
{
    use \App\Traits\APIResponseManager;
    use \App\Traits\CommonUtil;
    use \App\Traits\StripeManager;
    protected $cardObj;

    public function __construct(Card $card)
    {
        $this->cardObj =$card;
       
    }
    
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */

    
    public function addCardToStripe(Request $request){
        \Log::info($request->all());
        try{
            $request->validate([
                'token'    => 'required',
                'card_type'=> 'required',
                'user_id'  => 'required',
                'name'     => 'required',
                ]);
            
             } catch (\Illuminate\Validation\ValidationException $e) {
                $errorResponse = $this->ValidationResponseFormating($e);
                return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
            }
        $user=Auth::user();
        
        try{

            \Stripe\Stripe::setApiKey('sk_test_8yC94mSeeL8g58IdI9XMXIUI00zAt5m2qV');

// Create a Customer:
            $customers = \Stripe\Customer::create([
                'source' => $request->token,
                'email' => $user->email,
            ]);
            $customer=$customers;
        
      \Log::info($customer);
      $rest=Card::where('user_id',$request->user_id)->first();
    
        if($request->is_default=='1'){

            Card::where('user_id',$request->user_id)->update([
                        'is_default'   => '0',
                       
                ]);
        }

        $data=$this->cardObj->createCard([
        'user_id'=>  $request->user_id,
        'customer_id'=> $customer->id,
        'token'      => $request->token,
        'brand'=>$customer['sources']['data'][0]['brand'],
        'last4'=>$customer['sources']['data'][0]['last4'],
        'name'=>$request->name,
        'is_default' => $request->is_default,
        'exp_month'=>$customer['sources']['data'][0]['exp_month'],
        'exp_year'=>$customer['sources']['data'][0]['exp_year'],
        'card_id'=>$customer['sources']['data'][0]['id'],
        'card_type'=>$request->card_type
    ]);
          
    

    return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
   
        } catch (\PDOException $e) {
            DB::rollback();
            $errorResponse = $e->getMessage();
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }   
    }

    public function getCard(Request $request){
     
     try{
        $request->validate([
            'user_id'     => "required",
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
        $data=Card::where('user_id',$request->user_id)->get();
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    public function deleteCard(Request $request){
        try{
        $request->validate([
            'id'     => "required",
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

         try{

       
          $res=Card::where('id',$request->id)->first();
           
          $user_id=$res->user_id; 
          
          $info=Card::where('user_id',$user_id)->get();
          foreach ($info as $rest) {
          }
           $data= Card::where('id',$rest->id)->update([
                             'is_default'   => '1',
                ]);

          $data=DB::table('user_cards')->where('id',$request->id)->delete();

         // $data= Card::where('id',$request->id)->update([
         //                     'is_default'   => '1',
         //        ]);
        
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'CARD');
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    public function cardStatus(Request $request){
        try{
        $request->validate([
            'id'      => "required",
            'user_id' => "required",
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }
        try{
          $data= Card::where('user_id',$request->user_id)->update([
                             'is_default'   => '0',
                       
                ]);
           $data= Card::where('id',$request->id)->update([
                             'is_default'   => '1',
                       
                ]);
        return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'CARDSELECT');
        }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    public function payment(Request $request){
      try{
        $request->validate([
            'card_id'      => "required",
            ]);
         } catch (\Illuminate\Validation\ValidationException $e) {
            $errorResponse = $this->ValidationResponseFormating($e);
            return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'BAD_REQUEST', 'error_details', $errorResponse);
        }

    try{
       $CardDetails=Card::where('id',$request->card_id)->first();
       if(!empty($CardDetails->customer_id)){
       $priceStatus=Price::where('id',1)->first();
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET_KEY'));
        $data= Stripe\Charge::create ([
                'shipping' => [
                'name' => 'Jenny Rosen',
                'address' => [
                'line1' => '510 Townsend St',
                'postal_code' => '98140',
                'city' => 'San Francisco',
                'state' => 'CA',
                'country' => 'US',
                ],
                ],
                "amount"       => $priceStatus->price *100,
                "currency"     => "usd",
                'customer'     => $CardDetails->customer_id,
                'card'         => $CardDetails->card_id,
                "description"  => "Payment for manager" 
        ]);
   
       DB::table('transaction_history')->insert(['card_id' => $data->id, 'balance_transaction' => $data->balance_transaction,'amount'=>$priceStatus->price,'payment_status'=>$data->outcome->seller_message,'owner_id'=>$CardDetails->user_id,'date'=>date('Y-m-d'),'created_at'=>new \DateTime,'updated_at'=>new \DateTime]);


       return $this->responseManager(Config('statuscodes.request_status.SUCCESS'), 'SUCCESS', 'response',  $data);
     }else{

       return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'WENT_WORNG');

     }
       }catch (\PDOException $e) {
        $errorResponse = $e->getMessage();
        return $this->responseManager(Config('statuscodes.request_status.ERROR'), 'DB_ERROR', 'error_details', $errorResponse);
        }
    }

    
}
