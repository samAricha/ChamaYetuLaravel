<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contribution extends Model
{
    use HasFactory;

    protected $fillable = ['member_id', 'chama_id', 'contribution_date', 'contribution_amount'];

    public function member()
    {
        return $this->belongsTo(Member::class);
    }

    public function chama()
    {
        return $this->belongsTo(Chama::class);
    }
}
