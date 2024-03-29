<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Chama extends Model
{
    use HasFactory;

    protected $fillable = [
        'chama_name',
        'chama_description',
        'date_formed'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class, 'chama_user')->withPivot('role_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class);
    }

    public function members()
    {
        return $this->belongsToMany(Member::class, 'chama_members');
    }

    public function contributions()
    {
        return $this->hasMany(Contribution::class);
    }

    public function investments()
    {
        return $this->hasMany(Investment::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }
}
