<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id',
        'grade_lvl',
        'name',
        'teacher_id',
    ];

    public function teacher()
    {
        return $this->belongsTo(User::class);
    }
}