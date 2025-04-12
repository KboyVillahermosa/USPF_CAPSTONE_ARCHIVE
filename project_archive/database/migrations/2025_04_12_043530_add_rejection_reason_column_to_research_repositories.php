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
        Schema::table('research_repositories', function (Blueprint $table) {
            // Add the rejection_reason column
            $table->text('rejection_reason')->nullable()->after('rejected');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_repositories', function (Blueprint $table) {
            $table->dropColumn('rejection_reason');
        });
    }
};