<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Document extends Model
{
    protected $fillable = [
        'doc_type', 'doc_number', 'doc_link', 'id_user', 'uuid',
    ];
}
