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
        Schema::disableForeignKeyConstraints();

        Schema::create('course_registrations', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_male');
            $table->string('social_status');
            $table->string('nationality');
            $table->string('address');
            $table->date('date_of_birth');
            $table->string('student_type');
            $table->string('work_type');
            $table->boolean('is_morning');
            $table->boolean('accepted')->nullable();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('course_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_registrations');
    }
};
