<?php

use App\Models\CertificateType;
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

        Schema::create('department_marks', function (Blueprint $table) {
            $table->id();
            $table->integer('mark');
            $table->integer('year');
            $table->foreignId('department_id')->constrained();
            $table->foreignIdFor(CertificateType::class)->constrained();
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('department_marks');
    }
};
