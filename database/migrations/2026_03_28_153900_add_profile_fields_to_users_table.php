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
        Schema::table('users', function (Blueprint $table) {
            $table->string('grade_level')->nullable();
            $table->string('learning_level')->nullable();
            $table->unsignedTinyInteger('overall_diagnostic_score')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'grade_level',
                'learning_level',
                'overall_diagnostic_score',
            ]);
        });
    }
};
