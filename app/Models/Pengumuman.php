<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

// app/Models/Pengumuman.php
class Pengumuman extends Model
{
    protected $table = 'pengumuman';
    protected $fillable = ['judul', 'isi', 'prioritas', 'aktif', 'tanggal_mulai', 'tanggal_berakhir'];
    protected $casts = ['aktif' => 'boolean'];

    public function scopeAktif($query)
    {
        return $query->where('aktif', true)
            ->where(function($q) {
                $q->whereNull('tanggal_berakhir')
                  ->orWhere('tanggal_berakhir', '>=', now()->toDateString());
            });
    }
}
