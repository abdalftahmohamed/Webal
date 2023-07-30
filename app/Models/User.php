<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Carbon\Carbon;
use Laratrust\Contracts\LaratrustUser;
use Laratrust\Traits\HasRolesAndPermissions;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Notifications\ResetPasswordNotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;

use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable implements LaratrustUser,JWTSubject
{
//MustVerifyEmail
    use HasApiTokens, HasFactory, Notifiable, HasRolesAndPermissions,Billable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'country',
        'city',
        'type',
        'status',
        'code',
        'expire_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function sendPasswordResetNotification($token)
    {
        $url = 'https://spa.test/reset-password?token=' . $token;

        $this->notify(new ResetPasswordNotification($url));
    }

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function generateCode()
    {
        $this->timestamps=false;
        $this->code=rand(100000,600000);
        $this->expire_at=Carbon::now('Africa/Cairo')->addMinute(2);
        $this->save();
    }
}
