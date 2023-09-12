<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsArrayObject;
use Illuminate\Database\Eloquent\Casts\AsCollection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Maid extends Model
{
    use HasFactory;

    protected $table = 'maids';

    protected $fillable = [
        'name',
        'abilities',
        'commands',
        'signature',
        'user_id'
    ];

    protected $casts = [
        'abilities' => 'array',
        'commands' => 'array',
    ];
}
