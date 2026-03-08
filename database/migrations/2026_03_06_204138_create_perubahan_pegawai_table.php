<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('perubahan_pegawai', function (Blueprint $table) {
            $table->id();

            // Relasi ke pegawai yang mengajukan
            $table->foreignId('pegawai_id')->constrained('pegawais')->cascadeOnDelete();

            // Data baru yang ingin diubah
            $table->string('name')->nullable();
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['Laki-laki', 'Perempuan'])->nullable();
            $table->date('tanggal_lahir')->nullable();
            $table->string('foto')->nullable();

            // Catatan dari pegawai
            $table->text('catatan')->nullable();

            // Status pengajuan
            $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');

            // Admin yang memproses
            $table->foreignId('diproses_oleh')->nullable()->references('id')->on('users')->nullOnDelete();
            $table->timestamp('diproses_pada')->nullable();
            $table->text('catatan_penolakan')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('perubahan_pegawai');
    }
};