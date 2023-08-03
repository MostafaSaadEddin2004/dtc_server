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

        Schema::create('teacher_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('certificate');
            $table->string('speciality');
            $table->date('date_of_birth');
            $table->string('current_address');
            $table->string('address');
            $table->foreignId('department_id')->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('teacher_registrations');
    }
};
