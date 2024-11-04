<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FeeType extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        "id",
        "name",
        "amount",
    ];
}
