<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'subnama',
        'description',
        'price',
        'billing_period',
        'foto'
    ];

    protected $casts = [
        'description' => 'array',
    ];
}
