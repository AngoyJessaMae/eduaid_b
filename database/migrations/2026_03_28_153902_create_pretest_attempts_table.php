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
        Schema::create('pretest_attempts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedTinyInteger('overall_score')->default(0);
            $table->unsignedTinyInteger('math_score')->default(0);
            $table->unsignedTinyInteger('science_score')->default(0);
            $table->unsignedTinyInteger('english_score')->default(0);
            $table->string('math_level')->nullable();
            $table->string('science_level')->nullable();
            $table->string('english_level')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pretest_attempts');
    }
};
