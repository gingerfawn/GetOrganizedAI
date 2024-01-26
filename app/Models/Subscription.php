<?php

namespace App\Models;
use Carbon\Carbon;

use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{
    use HasFactory;
    protected $fillable = [
        'active_until', 
        'user_id', 
        'plan_id'
    ];

    protected $dates =[
        'active_until',
    ];

    protected $casts = [
        'active_until' => 'datetime',
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function plan(){
        return $this->belongsTo(Plan::class);
    }

    public function isActive(){
        return $this->active_until->gt(now());
    }
}
