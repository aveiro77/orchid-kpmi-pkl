<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('member_id')->constrained()->restrictOnDelete();
            $table->string('tipe', 20);                 // need | offer | collaborate
            $table->string('judul', 150);
            $table->text('deskripsi');
            $table->string('lokasi', 100)->nullable();
            $table->date('tanggal_expired');
            $table->string('status', 20)->default('draft');   // draft | published | closed
            $table->softDeletes();
            $table->timestamps();

            $table->index(['status', 'tipe', 'tanggal_expired']);   // filter papan peluang
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('opportunities');
    }
};
