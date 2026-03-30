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
        if (Schema::hasTable('pretest_answers')) {
            return;
        }

        Schema::create('pretest_answers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pretest_attempt_id')->constrained()->cascadeOnDelete();
            $table->foreignId('pretest_question_id')->constrained()->cascadeOnDelete();
            $table->string('selected_answer');
            $table->boolean('is_correct')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pretest_answers');
    }
};
