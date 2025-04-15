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
        Schema::table('research_projects', function (Blueprint $table) {
            $table->string('document_type')->after('id')->comment('Research, Dissertation, Thesis');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending')->after('document_type');
            $table->text('reviewer_notes')->nullable()->after('status');
            $table->foreignId('reviewer_id')->nullable()->after('reviewer_notes')->constrained('users')->nullOnDelete();
            $table->timestamp('reviewed_at')->nullable()->after('reviewer_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('research_projects', function (Blueprint $table) {
            $table->dropForeign(['reviewer_id']);
            $table->dropColumn(['document_type', 'status', 'reviewer_notes', 'reviewer_id', 'reviewed_at']);
        });
    }
};
