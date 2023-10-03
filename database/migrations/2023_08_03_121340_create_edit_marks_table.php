<?php

use App\Models\Subject;
use App\Models\Teacher;
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

        Schema::create('edit_marks', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Subject::class)->constrained()->cascadeOnDelete();
            $table->integer('mark');
            $table->string('reason');
            $table->foreignIdFor(Teacher::class)->constrained();
            $table->foreignId('user_id')->reference('id')->on('users');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('edit_marks');
    }
};
