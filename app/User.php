<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\User as UserResource;
use App\Http\Resources\Userinfo as UserResourceinfo;
use Hash;
use DB;

class User extends Authenticatable
{
    use HasApiTokens,Notifiable;
  
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'company_name', 'email','role','profile_image','company_logo','password','department','employees','success_from','success_to','satisfactory_from','satisfactory_to','not_accept_from','not_accept_to','parent_id','manager','social_id','social_type','time_zone','complete_task_score'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];



    public function createUser($data){
      
        $createdUser= self::create(
            [
                'email'        =>  $data['email']??null,
                'role'         =>  'Owner',
                'password'     =>  Hash::make($data['password']),
                'company_name' =>  $data['company_name']??null,
                'company_logo' =>  $data['company_logo']??null,
            ]
        );
return   $createdUser;
     //  return $this->user_resource($createdUser);
    }

    public function createOwner($data){
        $createdUser= self::create(
            [
                'email'        =>  $data['email']??null,
                'role'         =>  'Owner',
                'password'     =>  Hash::make($data['password']),
                'company_name' =>  $data['company_name']??null,
                'company_logo' =>  $data['company_logo']??null,
            ]
        );
       return   $createdUser;

    }

    public function createUserFacebook($data){

        $createdUser= self::create(
            [
                'social_id'        => $data['social_id']??null,
                'social_type'      => $data['social_type']??null,
                'role'             => $data['role']??null,
                'name'             => $data['name']??null,
                'profile'          => $data['profile']??null,
                'email'            => $data['email']??null,
            ]
        );
        //print_r($createdUser);
        return   $createdUser;
    }

    

     public function createManager($data){
        
               

        $createdUser= self::create(
            [
                'name'              =>  $data['name']??null,
                'email'             =>  $data['email']??null,
                'role'              =>  'Manager',
                'password'          =>  Hash::make($data['password']),
                'department'        =>  $data['department'],
                'employees'         =>  $data['employees']??null,
                'success_from'      =>  $data['success_from']??null,
                'success_to'        =>  $data['success_to']??null,
                'satisfactory_from' =>  $data['satisfactory_from']??null,
                'satisfactory_to'   =>  $data['satisfactory_to']??null,
                'not_accept_from'   =>  $data['not_accept_from']??null,
                'not_accept_to'     =>  $data['not_accept_to']??null,
                'parent_id'         =>  $data['parent_id']??null,
                'time_zone'         =>  $data['time_zone']??null,

            ]
        );
        
        return $createdUser;
      // return $this->user_resource($createdUser);
     }

     public function createEmployee($data){
        $pass='12345678';
        $createdUser= self::create(
            [
                'name'              =>  $data['name']??null,
                'email'             =>  $data['email']??null,
                'role'              =>  'Employee',
                'password'          =>  Hash::make($data['password']),
                'department'        =>  $data['department'],
                'manager'           =>  $data['manager']??null,
                'success_from'      =>  $data['success_from']??null,
                'success_to'        =>  $data['success_to']??null,
                'satisfactory_from' =>  $data['satisfactory_from']??null,
                'satisfactory_to'   =>  $data['satisfactory_to']??null,
                'not_accept_from'   =>  $data['not_accept_from']??null,
                'not_accept_to'     =>  $data['not_accept_to']??null,
                'parent_id'         =>  $data['parent_id']??null,
                'time_zone'         =>  $data['time_zone']??null,

            ]
        );
        
        return $createdUser;
      // return $this->user_resource($createdUser);
     }
     public function createReports($data){
        // print_r($data);
        // die();
        $createdUser= self::create(
            [
                'name'              =>  $data['name']??null,
                'email'             =>  $data['email']??null,
                'role'              =>  'Employee',
                'department'        =>  $data['department']??null,
                'success_from'      =>  $data['successfull_from']??null,
                'success_to'        =>  $data['successfull_to']??null,
                'satisfactory_from' =>  $data['satisfactory_from']??null,
                'satisfactory_to'   =>  $data['satisfactory_to']??null,
                'not_accept_from'   =>  $data['acceptable_from']??null,
                'not_accept_to'     =>  $data['acceptable_to']??null,
                'manager'           =>  $data['parent_id']??null,
            ]
        );
        
        return $createdUser;

     }

     
    
    
    public function user_resource($user){

        return new UserResource($user);
    }

    public function department()
    {
        return $this->hasOne(\App\Models\Department::class,"id","department");
    }
     public function parent()
    {
        return $this->hasOne(\App\Models\User::class,"parent_id","id");
    }

    public function getmanager()
    {
        return $this->hasOne(\App\User::class,"manager","id");
    }

    
    public function createPassportToken($user){
        return $user->createToken('assistantManager')->accessToken;
    }

    public function checkSocial($data){
      return  self::where('social_id',$data['social_id'])->where('social_type',$data['social_type'])->first();
              
    }

     public function getTotalRevenue($year){
        if($year>1){
            return self::where(DB::raw("YEAR(created_at)"),$year)->pluck('id')->count();
        }
        return self::pluck('id')->count();
        }

        public function getCountforGraph($year){
            if($year>1){
               return  $project=self::select(DB::raw("count(id) as total"),DB::raw("MONTH(created_at) as status"))->where(DB::raw("YEAR(created_at)"),$year)->groupBy(DB::raw("MONTH(created_at)"))->get();
            }
            $project=self::select(DB::raw("count(id) as total"),DB::raw("YEAR(created_at) as status"))->groupBy(DB::raw("YEAR(created_at)"));
          
           return $project->get();
        }
        public function getRevenueYear(){
            return self::select(DB::raw("YEAR(created_at) as year"))->groupBy(DB::raw("YEAR(created_at)"))->get();
        }
}
