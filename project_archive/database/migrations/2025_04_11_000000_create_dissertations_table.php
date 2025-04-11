<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('dissertations', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('author');
            $table->enum('type', ['dissertation', 'thesis']);
            $table->text('abstract');
            $table->string('department');
            $table->integer('year');
            $table->string('file_path');
            $table->string('keywords');
            $table->foreignId('user_id')->constrained();
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('dissertations');
    }
};