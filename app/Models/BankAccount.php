<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankAccount extends Model
{
    protected $fillable = [
        'account', 'bank', 'id_user', 'uuid', 'number',
    ];
}
