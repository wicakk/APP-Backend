<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JadwalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $hari = ['Senin','Selasa','Rabu','Kamis','Jumat'];
        foreach ($hari as $i => $h) {
            \App\Models\Jadwal::create([
                'hari'      => $h,
                'jam_masuk' => '07:30',
                'jam_pulang'=> '16:30',
                'durasi'    => '9 Jam',
            ]);
        }
    }
}
