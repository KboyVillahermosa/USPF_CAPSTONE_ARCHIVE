<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('research_repositories', function (Blueprint $table) {
            $table->string('curriculum')->after('department')->nullable();
        });
    }

    public function down()
    {
        Schema::table('research_repositories', function (Blueprint $table) {
            $table->dropColumn('curriculum');
        });
    }
};