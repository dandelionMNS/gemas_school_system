<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    protected $fillable = [
        "id",
        "transaction_id",
        "fee_type_id",
    ];
}
