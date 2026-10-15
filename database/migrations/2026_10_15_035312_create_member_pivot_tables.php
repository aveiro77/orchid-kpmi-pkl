<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('member_professional_role', function (Blueprint $table) {
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('professional_role_id')->constrained()->cascadeOnDelete();
            $table->primary(['member_id', 'professional_role_id']);
        });

        Schema::create('member_skills', function (Blueprint $table) {
            $table->foreignId('member_id')->constrained()->cascadeOnDelete();
            $table->foreignId('skill_id')->constrained()->cascadeOnDelete();
            $table->primary(['member_id', 'skill_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('member_skills');
        Schema::dropIfExists('member_professional_role');
    }
};