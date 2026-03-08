<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Pest\Plugins\Parallel\Handlers\Pest;

class PengajuanAbsensi extends Model
{
    protected $table = 'pengajuan_absensis';

    protected $fillable = [
        'user_id',
        'tanggal_absensi',
        'jam_masuk',
        'jam_keluar',
        'alasan',
        'file',
        'status',
        'disetujui_oleh',
        'disetujui_pada',
        'catatan_penolakan',
    ];

    protected $casts = [
        'tanggal_absensi' => 'date',
        'disetujui_pada'  => 'datetime',
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
