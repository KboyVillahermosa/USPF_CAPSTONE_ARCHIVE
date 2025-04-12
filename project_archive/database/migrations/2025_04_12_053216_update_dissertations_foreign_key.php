<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('dissertations', function (Blueprint $table) {
            // Drop the existing foreign key
            $table->dropForeign(['user_id']);
            
            // Add the foreign key with ON DELETE CASCADE
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->onDelete('cascade');
        });
        
        // If you have other tables with foreign keys to users,
        // you should update those too
    }

    public function down(): void
    {
        Schema::table('dissertations', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            
            // Restore the original foreign key without cascade
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
        });
    }
};