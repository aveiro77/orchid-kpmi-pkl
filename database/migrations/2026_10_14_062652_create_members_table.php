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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->unique()->constrained()->nullOnDelete();
            $table->string('nama_lengkap');
            $table->string('foto')->nullable();
            $table->string('nomor_wa', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('kota')->nullable()->index();
            $table->text('bio')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('website')->nullable();
            $table->string('instagram')->nullable();
            $table->boolean('status_aktif')->default(true)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
