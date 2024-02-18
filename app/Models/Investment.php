<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    use HasFactory;

    protected $fillable = [
        'member_id',
        'chama_account_id',
        'investment_description',
        'investment_amount',
        'investment_date'
    ];

    public function chama()
    {
        return $this->belongsTo(Chama::class);
    }
}
