<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;

    protected $fillable = ['first_name', 'last_name', 'contact_information', 'date_joined'];

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

