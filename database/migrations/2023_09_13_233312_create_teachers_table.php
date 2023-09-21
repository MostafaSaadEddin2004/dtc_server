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
        Schema::create('teachers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->string('certificate');
            $table->string('specialty');
            $table->date('birth_date');
            $table->string('current_location');
            $table->string('permanent_location');
            $table->string('nationality');
            $table->foreignId('department_id')->constrained();
            $table->boolean('accepted')->nullable();
            $table->boolean('is_department_head')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teachers');
    }
};
