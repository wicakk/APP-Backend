<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('pegawais', function (Blueprint $table) {
            $table->id();
            $table->string('nip')->unique();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('password');
            $table->string('no_hp')->nullable();
            $table->text('alamat')->nullable();
            $table->enum('jenis_kelamin', ['L','P'])->nullable();
            $table->date('tanggal_lahir')->nullable();

            $table->unsignedBigInteger('jabatan_id')->nullable();
            $table->unsignedBigInteger('departemen_id')->nullable();

            $table->date('tanggal_masuk')->nullable();
            $table->enum('status_pegawai', ['aktif','nonaktif'])->default('aktif');
            $table->string('foto')->nullable();

            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('jabatan_id')->references('id')->on('jabatans')->onDelete('set null');
            $table->foreign('departemen_id')->references('id')->on('departemens')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pegawais');
    }
};