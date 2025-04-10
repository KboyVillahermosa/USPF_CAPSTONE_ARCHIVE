<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddViewDownloadCounts extends Migration
{
    public function up()
    {
        Schema::table('research_repositories', function (Blueprint $table) {
            $table->integer('view_count')->default(0);
            $table->integer('download_count')->default(0);
        });
    }

    public function down()
    {
        Schema::table('research_repositories', function (Blueprint $table) {
            $table->dropColumn(['view_count', 'download_count']);
        });
    }
}