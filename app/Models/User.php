<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class User extends Authenticatable
{
    use Notifiable, HasApiTokens;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'uuid', 'first_name', 'middle_name', 'email', 'password', 'last_name',
        'position', 'nik', 'emp_status', 'probation_date', 'entry_date',
        'out_date', 'birthday', 'place_of_birth', 'npwp', 'photo', 'account_status',
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

    public static function findByUuid($uuid)
    {
        return static::where('uuid', $uuid)->first();
    }


    public static function findOrFailByUuid($uuid)
    {
        if($result = static::findByUuid($uuid)){
            return $result;
        }else{
            throw new ModelNotFoundException('User Not Found');
        }
    }

    

}
