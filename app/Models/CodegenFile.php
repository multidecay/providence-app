<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CodegenFile extends Model
{
    use HasFactory;

    protected $fillable = [
        'codegen_id',
        'user_id',
        'filename',
        'content'
    ];
}
