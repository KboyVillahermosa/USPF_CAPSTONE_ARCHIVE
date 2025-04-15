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
        Schema::table('dissertations', function (Blueprint $table) {
            $table->integer('view_count')->default(0);
            $table->integer('download_count')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('dissertations', function (Blueprint $table) {
            $table->dropColumn(['view_count', 'download_count']);
        });
    }
};