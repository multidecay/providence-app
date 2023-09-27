<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Device extends Model
{
    use HasFactory;

    protected $table = 'devices';

    protected $fillable = [
        'hwid',
        'operating_system',
        'maid_id',
        'country_code',
        'hostname',
        'ip',
        'notes',
        'abilities',
        'user_id'
    ];

    public function maid(): HasOne
    {
        return $this->hasOne(Maid::class,'id','maid_id');
    }
}
