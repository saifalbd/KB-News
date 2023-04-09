<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone',
        'email',
        'work_info',
        'relationship',
        'address',
        'website',
        'note'
    ];

    protected $casts = [
        
        'phone'=>'array',
        'email'=>'array',
        'work_info'=>'array',
        'relationship'=>'array',
        'address'=>'array',
        'website'=>'array',
    ];
}
