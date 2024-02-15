<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'transaction_date',
        'transaction_type',
        'amount'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
