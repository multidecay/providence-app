<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'command',
        'argument',
        'device_id',
        'maid_id',
        'user_id',
        'state',
        'received_at',
        'reported_at',
        'report_type',
        'report_message'
    ];

    public function maid_name()
    {
        return $this->hasOne(Maid::class,'id','maid_id')->name;
    }
}
