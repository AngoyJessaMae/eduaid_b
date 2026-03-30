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
        Schema::table('lessons', function (Blueprint $table) {
            if (!Schema::hasColumn('lessons', 'material_path')) {
                $table->string('material_path')->nullable()->after('video_url');
            }

            if (!Schema::hasColumn('lessons', 'material_name')) {
                $table->string('material_name')->nullable()->after('material_path');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('lessons', function (Blueprint $table) {
            if (Schema::hasColumn('lessons', 'material_name')) {
                $table->dropColumn('material_name');
            }

            if (Schema::hasColumn('lessons', 'material_path')) {
                $table->dropColumn('material_path');
            }
        });
    }
};
