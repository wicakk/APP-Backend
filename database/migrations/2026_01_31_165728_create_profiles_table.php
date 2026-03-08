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
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();

            // Personal Information
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone')->nullable();
            $table->string('bio')->nullable(); // Team Manager
            $table->string('photo')->nullable(); // avatar image path

            // Social Links
            $table->string('facebook')->nullable();
            $table->string('x')->nullable(); // x.com
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            
            $table->string('country')->nullable();
            $table->string('city')->nullable();
            $table->string('code')->nullable();
            $table->string('tax')->nullable();

            // Auth (optional, aman walau belum dipakai)
            $table->string('password')->nullable();
            $table->rememberToken();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profiles');
    }
};
