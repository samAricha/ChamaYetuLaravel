<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamaAccount extends Model
{
    use HasFactory;

    protected $table = 'chama_accounts';
    protected $fillable = [
        'chama_id',
        'account_name',
        'account_type_id',
    ];

    public function chama()
    {
        return $this->belongsTo(Chama::class);
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function accountTypes()
    {
        return $this->belongsTo(AccountType::class);
    }

}
