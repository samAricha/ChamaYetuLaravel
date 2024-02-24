<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone',
        'date_joined'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function chamas()
    {
        return $this->belongsToMany(Chama::class, 'chama_members');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'chama_roles');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}

