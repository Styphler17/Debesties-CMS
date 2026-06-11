<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('media', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->string('file_name');
            $table->string('file_path');
            $table->string('file_url');
            $table->string('mime_type');
            $table->unsignedBigInteger('file_size');
            $table->string('alt_text')->nullable();
            $table->string('caption')->nullable();
            $table->string('title')->nullable();
            $table->string('folder')->nullable();
            $table->integer('width')->nullable();
            $table->integer('height')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('media');
    }
};
