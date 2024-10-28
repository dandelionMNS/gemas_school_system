<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'year',
        'name',
        'teacher_id',
    ];
}