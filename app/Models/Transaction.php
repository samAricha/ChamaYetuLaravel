<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'chama_account_id',
        'transaction_date',
        'transaction_type_id',
        'amount'
    ];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function type()
    {
        return $this->belongsTo(TransactionType::class);
    }
}
