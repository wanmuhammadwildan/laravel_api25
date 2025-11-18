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
        Schema::create('task_models', function (Blueprint $table) {
            $table->id();
            $table->string('title', 255);       // <<< Pastikan ini ada!
            $table->text('description')->nullable(); // <<< Pastikan ini ada!
            $table->boolean('is_completed')->default(false); // <<< Pastikan ini ada!
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_models');
    }
};
