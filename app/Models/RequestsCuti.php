<?php
// app/Models/RequestsCuti.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestsCuti extends Model
{
    protected $table = 'requests_cuti';

    protected $fillable = [
        'user_id',
        'jenis_cuti',
        'tanggal_mulai',
        'tanggal_akhir',
        'total_hari',
        'alasan',
        'file',
        'status',
        'disetujui_oleh',
        'disetujui_pada',
        'catatan_penolakan',
    ];

    public function pegawai()
    {
        return $this->belongsTo(Pegawai::class, 'user_id');
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }
}