<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamaAccount extends Model
{
    use HasFactory;

    protected $table = 'chama_accounts';

    public function chama()
    {
        return $this->belongsTo(Chama::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

}
