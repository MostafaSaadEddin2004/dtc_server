<?php

use App\Models\Department;
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

        Schema::create('academic_registrations', function (Blueprint $table) {
            $table->id();
            $table->string('father_name');
            $table->string('mother_name');
            $table->date('date_of_birth');
            $table->string('place_of_birth');
            $table->string('military');
            $table->string('current_address');
            $table->string('address');
            $table->string('name_of_parent');
            $table->string('job_of_parent');
            $table->string('phone_of_parent', 10);
            $table->string('phone_of_mother', 10);
            $table->integer('avg_mark');
            $table->string('certificate_year');
            $table->string('id_image');
            $table->string('certificate_image');
            $table->string('personal_image');
            $table->string('un_image');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained()->cascadeOnDelete();
            $table->boolean('accepted')->nullable();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('academic_registrations');
    }
};
