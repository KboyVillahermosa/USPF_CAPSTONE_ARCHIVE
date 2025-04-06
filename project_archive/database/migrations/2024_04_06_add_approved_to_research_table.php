<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('research', function (Blueprint $table) {
            $table->boolean('approved')->default(true);
        });
    }

    public function down()
    {
        Schema::table('research', function (Blueprint $table) {
            $table->dropColumn('approved');
        });
    }
};