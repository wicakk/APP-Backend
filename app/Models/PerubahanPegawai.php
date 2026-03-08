<?php
// app/Models/PerubahanPegawai.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerubahanPegawai extends Model
{
    protected $table = 'perubahan_pegawai';

    protected $fillable = [
        'pegawai_id',
        'name',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'tanggal_lahir',
        'foto',
        'catatan',
        'status',
        'diproses_oleh',
        'diproses_pada',
        'catatan_penolakan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'pegawai_id');
    }

    public function diprosesOleh()
    {
        return $this->belongsTo(User::class, 'diproses_oleh');
    }
}