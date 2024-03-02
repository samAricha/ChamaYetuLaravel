<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamaUsers extends Model
{
    use HasFactory;

    protected $fillable = [
        'chama_id',
        'user_id',
        'role_id',
    ];
}
