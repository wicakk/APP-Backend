<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('requests_cuti', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->constrained()->cascadeOnDelete();

        // Ganti foreignId jadi string biasa
        $table->string('jenis_cuti'); // "Cuti Sakit", "Izin", dll

        $table->date('tanggal_mulai');
        $table->date('tanggal_akhir');
        $table->integer('total_hari');
        $table->text('alasan');
        $table->string('file')->nullable();
        $table->enum('status', ['pending', 'disetujui', 'ditolak'])->default('pending');
        $table->foreignId('disetujui_oleh')
            ->nullable()
            ->references('id')
            ->on('users')
            ->nullOnDelete();
        $table->timestamp('disetujui_pada')->nullable();
        $table->text('catatan_penolakan')->nullable();
        $table->timestamps();
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('requests_cuti');
    }
};
