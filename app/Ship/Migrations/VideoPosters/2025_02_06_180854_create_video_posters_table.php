<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('video_posters', function (Blueprint $table) {
            $table->id();
            $table->foreignId('video_id')->constrained();
            $table->string('bucket')->nullable();
            $table->string('original')->nullable();
            $table->string('md')->nullable();
            $table->string('sm')->nullable();
            $table->string('xs')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('video_posters');
    }
};
