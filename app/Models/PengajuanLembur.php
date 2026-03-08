<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PengajuanLembur extends Model
{
    protected $table = 'pengajuan_lembur';

    protected $fillable = [
        'user_id',
        'tanggal_lembur',
        'jam_mulai',
        'jam_selesai',
        'total_jam',
        'alasan',
        'file',
        'status',
        'disetujui_oleh',
        'disetujui_pada',
        'catatan_penolakan',
    ];

    protected $casts = [
        'tanggal_lembur' => 'date',
        'disetujui_pada' => 'datetime',
    ];

    public function pegawai()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function disetujuiOleh()
    {
        return $this->belongsTo(User::class, 'disetujui_oleh');
    }

    /// Hitung total jam otomatis dari jam_mulai & jam_selesai
    public static function hitungTotalJam(string $jamMulai, string $jamSelesai): float
    {
        $mulai = \Carbon\Carbon::createFromFormat('H:i', $jamMulai);
        $selesai = \Carbon\Carbon::createFromFormat('H:i', $jamSelesai);

        // Jika jam selesai melewati tengah malam
        if ($selesai->lt($mulai)) {
            $selesai->addDay();
        }

        return round($mulai->diffInMinutes($selesai) / 60, 2);
    }
}
