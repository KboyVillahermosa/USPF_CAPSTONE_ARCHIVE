<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddRejectionFieldsToFacultyResearch extends Migration
{
    public function up()
    {
        Schema::table('faculty_research', function (Blueprint $table) {
            $table->boolean('rejected')->default(false)->after('approved');
            $table->text('rejection_reason')->nullable()->after('rejected');
        });
    }

    public function down()
    {
        Schema::table('faculty_research', function (Blueprint $table) {
            $table->dropColumn(['rejected', 'rejection_reason']);
        });
    }
}