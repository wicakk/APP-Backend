<?php
namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Support\Facades\Hash;

class Pegawai extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'nip',  
        'name',
        'email',
        'password',
        'no_hp',
        'alamat',
        'jenis_kelamin',
        'tanggal_lahir',
        'jabatan_id',
        'departemen_id',
        'tanggal_masuk',
        'status_pegawai',
        'foto',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function presensis()
    {
        return $this->hasMany(Presensi::class, 'user_id');
    }

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function setPasswordAttribute($value)
    {
        if ($value) {
            $this->attributes['password'] = Hash::needsRehash($value) ? Hash::make($value) : $value;
        }
    }

    public function jabatan()
{
    return $this->belongsTo(Jabatan::class);
}

public function departemen()
{
    return $this->belongsTo(Departemen::class);
}
}