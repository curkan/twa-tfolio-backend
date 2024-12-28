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
        Schema::create('settings', function (Blueprint $table): void {
            $table->collation = 'utf8_general_ci';
            $table->charset = 'utf8';

            $table->id();
            $table->timestamps();

            $table->bigInteger('settingable_id')->nullable();
            $table->string('settingable_type')->nullable();
            $table->string('name');
            $table->text('value')->nullable();

            $table->unique(['settingable_id', 'settingable_type', 'name']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
