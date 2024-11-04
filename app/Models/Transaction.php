<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        "id",
        "student_id",
        "ref_url",
        "status",
    ];
}
