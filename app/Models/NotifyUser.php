<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NotifyUser extends Model
{
    protected $table = 'notify_user';
     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'task_id','action','users_id'
    ];

}
