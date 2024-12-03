<?php

declare(strict_types=1);

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up(): void
    {
        Schema::create('nodes', function (Blueprint $table): void {
            $table->id();
            $table->unsignedInteger('sort');
            $table->foreignId('user_id')->constrained();
            $table->unsignedInteger('x');
            $table->unsignedInteger('y');
            $table->unsignedInteger('w');
            $table->unsignedInteger('h');
            $table->string('type')->comment('image|video');
            $table->foreignId('image_id')->nullable()->constrained();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('nodes');
    }
};
