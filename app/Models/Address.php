<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Address extends Model
{
    protected $fillable = [
        'type', 'address', 'id_user', 'uuid', 
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
