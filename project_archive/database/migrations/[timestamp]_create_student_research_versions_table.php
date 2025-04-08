<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('student_research_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_id')->constrained('research_repositories')->onDelete('cascade');
            $table->integer('version_number');
            $table->string('file_path');
            $table->text('changes_description')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('student_research_versions');
    }
};