<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('department')->nullable()->after('email');
            $table->string('course')->nullable()->after('department');
            $table->string('year_level')->nullable()->after('course');
            $table->string('student_id')->nullable()->after('year_level');
            $table->enum('role', ['student', 'faculty', 'admin'])->default('student')->after('student_id');
            $table->string('position')->nullable()->after('role');
        });
    }

    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'department',
                'course',
                'year_level',
                'student_id',
                'role',
                'position'
            ]);
        });
    }
};