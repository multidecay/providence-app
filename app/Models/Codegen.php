<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codegen extends Model
{
    use HasFactory;

    protected $fillable= [
        'name',
        'language',
        'user_id'
    ];

    public function files(){
        return $this->hasMany(CodegenFile::class,'id','codegen_id');
    }
}
