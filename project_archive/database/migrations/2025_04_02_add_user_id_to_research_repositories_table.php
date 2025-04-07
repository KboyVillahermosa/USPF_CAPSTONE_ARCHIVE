<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('research_repositories', function (Blueprint $table) {
            if (!Schema::hasColumn('research_repositories', 'user_id')) {
                $table->unsignedBigInteger('user_id')->after('id');
            }
        });
        
    }

    public function down()
    {
        Schema::table('research_repositories', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
};