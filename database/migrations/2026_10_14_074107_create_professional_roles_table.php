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
        // create_professional_roles_table
        Schema::create('professional_roles', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->timestamps();
        });

        // create_skills_table
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('nama')->unique();
            $table->timestamps();
        });

        // create_member_pivot_tables
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

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('professional_roles');
        Schema::dropIfExists('skills');
        Schema::dropIfExists('member_professional_role');
        Schema::dropIfExists('member_skills');
    }
};
