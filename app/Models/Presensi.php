<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Presensi extends Model
{
    use HasFactory;

    protected $table = 'presensis';

    protected $fillable = [
        'user_id',
        'latitude',
        'longitude',
        'tanggal',
        'masuk',
        'pulang',
    ];
    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'user_id');
    }
    
}