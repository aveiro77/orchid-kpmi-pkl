<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('businesses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->restrictOnDelete();
            $table->string('nama_usaha', 150);
            $table->string('kategori', 100);
            $table->text('deskripsi')->nullable();
            $table->string('alamat')->nullable();
            $table->string('website')->nullable();
            $table->string('status', 20)->default('aktif');
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'kategori']);   // filter direktori usaha
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('businesses');
    }
};
