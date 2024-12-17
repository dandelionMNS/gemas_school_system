<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Parentt extends Model
{
    use HasFactory;

    protected $table = 'parents'; 

    protected $fillable = [
        'id',
        'user_id'
    ];


    public function user_parent()
    {
        return $this->belongsTo(User::class);
    }
}