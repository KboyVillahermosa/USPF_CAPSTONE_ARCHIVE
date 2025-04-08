<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('research_repositories', function (Blueprint $table) {
            $table->id();
            $table->string('project_name');
            $table->text('members')->nullable();
            $table->string('department')->nullable();
            $table->text('abstract')->nullable();
            $table->boolean('approved')->default(false);
            $table->boolean('rejected')->default(false);
            $table->text('rejection_reason')->nullable();
            $table->string('banner_image')->nullable();
            $table->string('file')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('research_repositories');
    }
};