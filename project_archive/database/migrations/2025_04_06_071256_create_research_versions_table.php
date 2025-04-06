<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('research_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('research_id')->constrained('researches')->onDelete('cascade');
            $table->integer('version_number');
            $table->string('file_path');
            $table->text('changes_made')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('research_versions');
    }
};