<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class Division extends Model
{
    protected $fillable = [
        'name', 'information', 'uuid', 'id_branch',
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
