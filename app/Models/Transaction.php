<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    //
    protected $fillable = [
        "id",
        "student_id",
        "feetype_id",
        "ref_url",
        "status",
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function feetype()
    {
        return $this->belongsTo(FeeType::class);
    }
}
