<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'chama_account_id',
        'loan_amount',
        'interest_rate',
        'loan_date',
        'loan_status'
    ];

    public function chama()
    {
        return $this->belongsTo(Chama::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
