<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChamaMembers extends Model
{
    use HasFactory;

    protected $fillable = [
        'chama_id',
        'member_id',
    ];
}
